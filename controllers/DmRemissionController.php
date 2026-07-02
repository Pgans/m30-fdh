<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * DM Remission Report Controller
 * รายงานผู้ป่วยเบาหวานที่เข้าสู่ระยะสงบ (DM remission)
 */
class DmRemissionController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get', 'post'],
                    'export' => ['post'],
                ],
            ],
        ];
    }

    /**
     * หน้าหลัก - แสดงฟอร์มค้นหาและผลลัพธ์
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        
        // ค่าเริ่มต้น
        $startDate = $request->post('start_date', date('Y-m-01'));
        $endDate = $request->post('end_date', date('Y-m-d'));
        $hospId = $request->post('hosp_id', 'all');
        
        $data = null;
        $summary = null;
        
        // ถ้ามีการ submit form
        if ($request->isPost && $request->post('search')) {
            $data = $this->getData($startDate, $endDate, $hospId);
            $summary = $this->getSummary($data);
        }
        
        return $this->render('index', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'hospId' => $hospId,
            'data' => $data,
            'summary' => $summary,
            'hospitalList' => $this->getHospitalList(),
        ]);
    }

    /**
     * ส่งออกรายงาน Excel
     */
    public function actionExport()
    {
        $request = Yii::$app->request;
        
        if (!$request->isPost) {
            return $this->redirect(['index']);
        }
        
        $startDate = $request->post('start_date');
        $endDate = $request->post('end_date');
        $hospId = $request->post('hosp_id', 'all');
        
        $data = $this->getData($startDate, $endDate, $hospId);
        $summary = $this->getSummary($data);
        
        if (empty($data)) {
            Yii::$app->session->setFlash('error', 'ไม่พบข้อมูลที่ต้องการส่งออก');
            return $this->redirect(['index']);
        }
        
        $filePath = $this->generateExcel($startDate, $endDate, $hospId, $data, $summary);
        
        if ($filePath && file_exists($filePath)) {
            return Yii::$app->response->sendFile($filePath, 'DM_Remission_Report_' . date('Ymd_His') . '.xlsx', [
                'mimeType' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'inline' => false,
            ])->on(\yii\web\Response::EVENT_AFTER_SEND, function($event) use ($filePath) {
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            });
        }
        
        Yii::$app->session->setFlash('error', 'ไม่สามารถส่งออกรายงานได้');
        return $this->redirect(['index']);
    }

    /**
     * ดึงข้อมูลจากฐานข้อมูล
     */
    private function getData($startDate, $endDate, $hospId)
    {
        $db = Yii::$app->db70;
        
        // สร้าง SQL query
        $sql = "
            SELECT 
                @n := @n + 1 AS no,
                DATE_FORMAT(o.reg_datetime, '%Y-%m-%d %H:%i') as regdate,
                o.visit_id,
                o.hn,
                o.weight,
                o.height,
                CONCAT(
                    CASE 
                        WHEN p.PRENAME not in('') THEN TRIM(p.PRENAME)
                        WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW())< '20' AND p.sex='1' AND p.MARRIAGE = '4' THEN 'สามเณร'
                        WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '20' AND p.sex='1' AND p.MARRIAGE  = '4' THEN 'พระภิกษุ'
                        WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='1' THEN 'เด็กชาย'
                        WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='1' THEN 'นาย'
                        WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='2' THEN 'เด็กหญิง'
                        WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='2' AND p.MARRIAGE ='1' THEN 'นางสาว'
                        ELSE 'นาง' 
                    END, TRIM(p.FNAME), '  ', TRIM(p.LNAME)
                ) as fullname,
                TIMESTAMPDIFF(year,p.BIRTHDATE,o.REG_DATETIME) as age,
                p.cid,
                GROUP_CONCAT(DISTINCT TRIM(icd1.ICD10_TM)) AS diagx,
                GROUP_CONCAT(DISTINCT TRIM(icd.ICD10_TM) ORDER BY icd.ICD10_TM SEPARATOR ', ') AS diag,
                LEFT(e.unit_name,10) as unit_name,
                f.INSCL_NAME as inscl,
                g.hospmain,
                pp.ppspecial,
                COALESCE((cos.cg01 + cos.cg02 + cos.cg03 + cos.cg04 + cos.cg05 + cos.cg06 + cos.cg07 + cos.cg08 + cos.cg09 + cos.cg10 + cos.cg11 + cos.cg12 + cos.cg13 + cos.cg14 + cos.cg15 + cos.cg16 + cos.cg17 + cos.cg18 + cos.cg19), 0) AS amount,
                IFNULL(ak.claimcode, '') AS claimcode,
                hpt.hosp_name,
                hpt.hosp_id,
                m.typearea_pcu
            FROM opd_visits o 
            INNER JOIN cid_hn c ON o.HN = c.HN
            INNER JOIN population p ON c.CID = p.CID AND LEFT(p.cid,5) <> '00000'
            LEFT JOIN opd_diagnosis d ON d.visit_id = o.visit_id AND d.is_cancel = 0
            LEFT JOIN icd10new icd ON icd.icd10 = d.icd10 AND icd.icd10 <> ''
            LEFT JOIN opd_diagnosis d1 ON d1.visit_id = o.visit_id AND d1.is_cancel = 0 AND d1.dxt_id = 1
            LEFT JOIN icd10new icd1 ON icd1.icd10 = d1.icd10 AND icd1.icd10 <> ''
            LEFT JOIN service_units e ON o.UNIT_REG = e.unit_id
            LEFT JOIN main_inscls f ON o.INSCL = f.INSCL
            LEFT JOIN uc_inscl g ON c.CID = g.CID AND (g.date_abort > DATE(o.REG_DATETIME) OR DAY(g.DATE_ABORT) = 0) AND TRIM(g.hospmain) <> ''
            LEFT JOIN hosp_sss h ON c.CID = h.CID AND (h.date_abort > DATE(o.REG_DATETIME) OR DAY(h.DATE_ABORT) = 0) AND TRIM(h.HOSP_ID) <> ''
            LEFT JOIN authen_kiosk ak ON ak.visit_id = o.visit_id AND ak.cid = p.cid
            LEFT JOIN log_fdh_opd_ck log ON log.visit_id = o.visit_id
            LEFT JOIN towns t ON p.town_id = t.town_id
            LEFT JOIN mathhn m ON m.cid = p.cid
            LEFT JOIN hospitals hpt ON hpt.hosp_id = t.hospsub
            LEFT JOIN cost_visits cos ON cos.visit_id = o.visit_id AND cos.is_cancel = 0
            INNER JOIN specialpp pp ON pp.visit_id = o.visit_id AND pp.is_cancel = 0 AND pp.ppspecial = '1I20'
            LEFT JOIN towns t1 ON CONCAT(LEFT(p.town_id,6),'00') = t1.town_id
            LEFT JOIN towns t2 ON CONCAT(LEFT(p.town_id,4),'0000') = t2.town_id
            LEFT JOIN towns t3 ON CONCAT(LEFT(p.town_id,2),'000000') = t3.town_id
            WHERE o.IS_CANCEL = 0
            AND o.REG_DATETIME BETWEEN :startDate AND :endDate
        ";
        
        $params = [
            ':startDate' => $startDate . ' 00:00:00',
            ':endDate' => $endDate . ' 23:59:59',
        ];
        
        // เพิ่มเงื่อนไขกรองตามรพ.สต.
        if ($hospId !== 'all' && !empty($hospId)) {
            $sql .= " AND hpt.hosp_id = :hospId";
            $params[':hospId'] = $hospId;
        }
        
        $sql .= " GROUP BY o.VISIT_ID ORDER BY o.reg_datetime DESC";
        
        // Initialize counter
        $db->createCommand('SET @n := 0')->execute();
        
        // Execute query
        return $db->createCommand($sql, $params)->queryAll();
    }

    /**
     * คำนวณสรุปสถิติ
     */
    private function getSummary($data)
    {
        if (empty($data)) {
            return [
                'total_patients' => 0,
                'by_hospital' => [],
            ];
        }
        
        $totalPatients = count($data);
        $byHospital = [];
        
        foreach ($data as $row) {
            $hospId = $row['hosp_id'] ?? 'unknown';
            $hospName = $row['hosp_name'] ?? 'ไม่ระบุ';
            
            if (!isset($byHospital[$hospId])) {
                $byHospital[$hospId] = [
                    'hosp_name' => $hospName,
                    'hosp_id' => $hospId,
                    'count' => 0,
                ];
            }
            $byHospital[$hospId]['count']++;
        }
        
        // เรียงตามจำนวนมากไปน้อย
        usort($byHospital, function($a, $b) {
            return $b['count'] - $a['count'];
        });
        
        return [
            'total_patients' => $totalPatients,
            'by_hospital' => $byHospital,
        ];
    }

    /**
     * สร้างไฟล์ Excel
     */
    private function generateExcel($startDate, $endDate, $hospId, $data, $summary)
    {
        require_once Yii::getAlias('@vendor/autoload.php');
        
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('DM Remission Report');
        
        // Styles
        $headerStyle = [
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '000000']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E7E6E6']],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
        ];
        
        $titleStyle = [
            'font' => ['bold' => true, 'size' => 16],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ];
        
        // Report Title
        $row = 1;
        $sheet->setCellValue('A' . $row, 'รายงาน DM Remission');
        $sheet->mergeCells('A' . $row . ':K' . $row);
        $sheet->getStyle('A' . $row)->applyFromArray($titleStyle);
        
        $row++;
        $sheet->setCellValue('A' . $row, 'ร้อยละของผู้ป่วยเบาหวานชนิดที่ 2 ที่เข้าสู่โรคเบาหวานระยะสงบ');
        $sheet->mergeCells('A' . $row . ':K' . $row);
        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        // Report Info
        $row += 2;
        $sheet->setCellValue('A' . $row, 'ช่วงเวลา:');
        $sheet->setCellValue('B' . $row, date('d/m/Y', strtotime($startDate)) . ' - ' . date('d/m/Y', strtotime($endDate)));
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        
        $row++;
        $hospitalList = $this->getHospitalList();
        $hospitalName = $hospId === 'all' ? 'ทั้งหมด' : ($hospitalList[$hospId] ?? 'ไม่ระบุ');
        $sheet->setCellValue('A' . $row, 'รพ.สต.:');
        $sheet->setCellValue('B' . $row, $hospitalName);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        
        $row++;
        $sheet->setCellValue('A' . $row, 'จำนวนผู้ป่วยทั้งหมด:');
        $sheet->setCellValue('B' . $row, number_format($summary['total_patients']) . ' คน');
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        
        // Data Table
        $row += 2;
        $headers = ['ลำดับ', 'วันที่รับบริการ', 'HN', 'ชื่อ-นามสกุล', 'อายุ', 'CID', 'การวินิจฉัยหลัก', 'การวินิจฉัยร่วม', 'หน่วยบริการ', 'รพ.สต.', 'รหัสพิเศษ'];
        $cols = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'];
        
        foreach ($cols as $i => $col) {
            $sheet->setCellValue($col . $row, $headers[$i]);
        }
        $sheet->getStyle('A' . $row . ':K' . $row)->applyFromArray($headerStyle);
        
        // Data Rows
        foreach ($data as $index => $item) {
            $row++;
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item['regdate']);
            $sheet->setCellValue('C' . $row, $item['hn']);
            $sheet->setCellValue('D' . $row, $item['fullname']);
            $sheet->setCellValue('E' . $row, $item['age']);
            $sheet->setCellValueExplicit('F' . $row, $item['cid'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('G' . $row, $item['diagx'] ?? '-');
            $sheet->setCellValue('H' . $row, $item['diag'] ?? '-');
            $sheet->setCellValue('I' . $row, $item['unit_name'] ?? '-');
            $sheet->setCellValue('J' . $row, $item['hosp_name'] ?? '-');
            $sheet->setCellValue('K' . $row, $item['ppspecial']);
            
            $sheet->getStyle('A' . $row . ':K' . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }
        
        // Auto-size columns
        foreach ($cols as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Save file
        $tempDir = Yii::getAlias('@runtime/temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }
        
        $filename = 'DM_Remission_' . date('Ymd_His') . '.xlsx';
        $filePath = $tempDir . '/' . $filename;
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($filePath);
        
        return $filePath;
    }

    /**
     * รายชื่อรพ.สต.
     */
    private function getHospitalList()
    {
        return [
            'all' => 'ทั้งหมด',
            '03697' => 'รพ.สต.หนองเมือง',
            '03694' => 'รพ.สต.หนองแสง',
            '03698' => 'รพ.สต.สร้างมิ่ง',
            '03695' => 'รพ.สต.บัวยาง',
            '03692' => 'รพ.สต.หนองหลัก',
            '03693' => 'รพ.สต.ขมิ้น',
            '03710' => 'รพ.สต.หนองขุ่น',
            '03708' => 'รพ.สต.ผักระย่า',
            '03709' => 'รพ.สต.หนองสองห้อง',
            '03712' => 'รพ.สต.แสงไผ่',
            '03713' => 'รพ.สต.ทุ่งมณี',
            '03711' => 'รพ.สต.ไผ่ใหญ่',
            '03707' => 'รพ.สต.หนองฮาง',
            '03705' => 'รพ.สต.หนองเหล่า',
            '03714' => 'รพ.สต.โพนแพง',
            '03706' => 'รพ.สต.ดอนแดงใหญ่',
            '03704' => 'รพ.สต.หนองไข่นก',
            '99809' => 'PCU.ม่วงสามสิบ',
            '03696' => 'รพ.สต.พระโรจน์',
            '03700' => 'รพ.สต.น้ำคำแดง',
            '03699' => 'รพ.สต.โนนขวาว',
            '03702' => 'รพ.สต.ยางสักกระโพหลุ่ม',
            '03701' => 'รพ.สต.นาดี',
            '03703' => 'รพ.สต.ยางเครือ',
        ];
    }
}