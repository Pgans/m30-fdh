<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\VisitInvoice;
use yii\web\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use yii\filters\AccessControl;        // เรียกใช้ คลาส AccessControl
use app\models\User;             // เรียกใช้ Model คลาส User ที่ปรับปรังปรุงไว้
use app\components\AccessRule;   // เรียกใช้ คลาส Component AccessRule ที่เราสร้างใหม่
use yii\filters\VerbFilter;

/**
 * Controller สำหรับจัดการใบค่ารักษาพยาบาล (db2)
 * ปรับปรุง: Preload ข้อมูลทั้งหมดในครั้งเดียว (batch query) แทนการยิง AJAX ทีละ visit
 */
class MedicalInvoiceController extends Controller
{
	public function behaviors(){
    
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access'=>[
                'class'=>AccessControl::className(),
                'only'=> ['index','admit','create','update','view','a15er'],
                'ruleConfig'=>[
                    'class'=>AccessRule::className()
                ],
                'rules'=>[
                    [
                        'actions' => [ 'view'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions'=>['a15er','create','view'],
                        'allow'=> true,
                        'roles' => [
                           User::ROLE_USER,
                         ]
                    ],
                    [
                        'actions'=>['a15er','index','update','view'],
                        'allow'=> true,
                        'roles'=>[
                            User::ROLE_EMPLOYEE,
                            User::ROLE_ADMIN
                        ]
                    ],
                    [
                        'actions'=>['admin','index','create','update','view'],
                        'allow'=> true,
                        'roles'=>[
                            User::ROLE_ADMIN
                        ]
                    ],
                    [
                        'actions'=>['delete'],
                        'allow'=> true,
                        'roles'=>[User::ROLE_ADMIN]
                    ]
                ]
            ]
        ];
    }
    /**
     * หน้าหลัก: โหลดข้อมูลทุก visit พร้อม invoice และ patient info ในครั้งเดียว
     */
    public function actionIndex($startDate = null, $endDate = null)
    {
        $startDate = $startDate ?: date('Y-m-d');
        $endDate   = $endDate   ?: date('Y-m-d');

        $dataProvider = VisitInvoice::searchOpdVisits($startDate, $endDate);

        // ดึง visit_id ทั้งหมดในหน้านี้
        $models   = $dataProvider->getModels();
        $visitIds = array_column($models, 'visit_id');

        // Batch query 2 ครั้ง แทน N+1 queries
        $allInvoices = VisitInvoice::getInvoicesByVisitIds($visitIds);
        $allPatients = VisitInvoice::getPatientInfoByVisitIds($visitIds);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'startDate'    => $startDate,
            'endDate'      => $endDate,
            'allInvoices'  => $allInvoices,
            'allPatients'  => $allPatients,
        ]);
    }

    /**
     * (ยังคงไว้สำหรับ backward compat) ดูรายละเอียดรายการค่ารักษาผ่าน AJAX
     * แต่ไม่ถูกเรียกจาก View หลักอีกต่อไป (ใช้ preload แทน)
     */
    public function actionViewInvoice($visit_id)
    {
        $invoices = VisitInvoice::getInvoiceByVisitId($visit_id);

        return $this->renderPartial('_invoice_details', [
            'invoices' => $invoices,
            'visit_id' => $visit_id,
        ]);
    }

    /**
     * ส่งออก Excel ที่มีรูปแบบเหมือนใบแจ้งค่ารักษา (รวมหัวเอกสารและตารางรายการ)
     */
    public function actionExportExcel($visit_id)
    {
        $patient  = VisitInvoice::getPatientInfo($visit_id);
        $invoices = VisitInvoice::getInvoiceByVisitId($visit_id);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('ใบแจ้งค่ารักษาพยาบาล');

        // 1. หัวเอกสาร
        $sheet->setCellValue('A1', 'เอกสารแสดงค่าใช้จ่ายในการรักษาพยาบาล โรงพยาบาลม่วงสามสิบ จังหวัดอุบลราชธานี');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // 2. ข้อมูลผู้ป่วย
        $sheet->setCellValue('A3', 'ผู้ป่วย: '     . ($patient['fullname'] ?? ''));
        $sheet->setCellValue('C3', 'อายุ: '        . ($patient['age_y'] ?? 0) . ' ปี ' . ($patient['age_m'] ?? 0) . ' เดือน');
        $sheet->setCellValue('E3', 'HN: '          . ($patient['hn'] ?? ''));

        $sheet->setCellValue('A4', 'เลขบัตร ปชช: '. ($patient['cid'] ?? ''));
        $sheet->setCellValue('C4', 'Visit ID: '    . $visit_id);
        $sheet->setCellValue('E4', 'สิทธิ: '      . ($patient['inscl'] ?? ''));

        $sheet->setCellValue('A5', 'วันที่รับบริการ: ' . ($patient['REG_DATETIME'] ?? ''));

        // 3. หัวตารางรายการ
        $headers = ['รายการ', 'จำนวน', 'ราคาต่อหน่วย', 'จำนวนเงินเบิกได้', 'จำนวนเงินเบิกไม่ได้', 'จำนวนเงินสุทธิ'];
        $sheet->fromArray($headers, NULL, 'A7');
        $sheet->getStyle('A7:F7')->getFont()->setBold(true);
        $sheet->getStyle('A7:F7')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A7:F7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // 4. ข้อมูลรายการ
        $row         = 8;
        $totalAmount = 0;
        if (!empty($invoices)) {
            foreach ($invoices as $item) {
                $sheet->setCellValue('A' . $row, $item['item']);
                $sheet->setCellValue('B' . $row, 1);
                $sheet->setCellValue('C' . $row, $item['amount']);
                $sheet->setCellValue('D' . $row, $item['amount']);  // เบิกได้
                $sheet->setCellValue('E' . $row, 0);                // เบิกไม่ได้
                $sheet->setCellValue('F' . $row, $item['subtotal']);

                $sheet->getStyle('A' . $row . ':F' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle('C' . $row . ':F' . $row)->getNumberFormat()->setFormatCode('#,##0.00');

                $totalAmount += $item['subtotal'];
                $row++;
            }
        }

        // 5. ยอดรวม
        $sheet->setCellValue('E' . $row, 'รวมทั้งสิ้น');
        $sheet->setCellValue('F' . $row, $totalAmount);
        $sheet->getStyle('E' . $row . ':F' . $row)->getFont()->setBold(true);
        $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('E' . $row . ':F' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // 6. ส่วนลงชื่อ
        $row += 2;
        $sheet->setCellValue('D' . $row, 'ลงชื่อ ............................................................ ผู้ป่วย/ผู้รับยาแทน');
        $row++;
        $sheet->setCellValue('D' . $row, '( ............................................................ )');

        // ปรับขนาดคอลัมน์อัตโนมัติ
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'Medical_Invoice_' . $visit_id . '_' . date('YmdHis') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * ส่งออก CSV ที่มีโครงสร้างเหมือนใบแจ้งค่ารักษา
     */
    public function actionExportCsv($visit_id)
    {
        if (ob_get_level()) ob_end_clean();

        $patient  = VisitInvoice::getPatientInfo($visit_id);
        $invoices = VisitInvoice::getInvoiceByVisitId($visit_id);

        $filename = 'Medical_Invoice_' . $visit_id . '_' . date('YmdHis') . '.csv';

        header('Content-Description: File Transfer');
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8

        fputcsv($output, ['เอกสารแสดงค่าใช้จ่ายในการรักษาพยาบาล โรงพยาบาลม่วงสามสิบ จังหวัดอุบลราชธานี']);
        fputcsv($output, []);

        fputcsv($output, [
            'ผู้ป่วย: '   . ($patient['fullname'] ?? ''),
            'อายุ: '       . ($patient['age_y'] ?? 0) . ' ปี ' . ($patient['age_m'] ?? 0) . ' เดือน',
            'HN: '         . ($patient['hn'] ?? ''),
            '',
            'สิทธิ: '     . ($patient['inscl'] ?? ''),
        ]);
        fputcsv($output, [
            'เลขบัตร ปชช: ' . ($patient['cid'] ?? ''),
            '',
            'Visit ID: '     . $visit_id,
        ]);
        fputcsv($output, ['วันที่รับบริการ: ' . ($patient['REG_DATETIME'] ?? '')]);
        fputcsv($output, []);
        fputcsv($output, ['รายการ', 'จำนวน', 'ราคาต่อหน่วย', 'จำนวนเงินเบิกได้', 'จำนวนเงินเบิกไม่ได้', 'จำนวนเงินสุทธิ']);

        $totalAmount = 0;
        if (!empty($invoices)) {
            foreach ($invoices as $item) {
                fputcsv($output, [
                    $item['item'],
                    1,
                    number_format($item['amount'],  2, '.', ''),
                    number_format($item['amount'],  2, '.', ''),
                    '0.00',
                    number_format($item['subtotal'], 2, '.', ''),
                ]);
                $totalAmount += $item['subtotal'];
            }
        }

        fputcsv($output, ['รวมทั้งสิ้น', '', '', '', '', number_format($totalAmount, 2, '.', '')]);
        fputcsv($output, []);
        fputcsv($output, ['', '', '', 'ลงชื่อ ............................................................ ผู้ป่วย/ผู้รับยาแทน']);
        fputcsv($output, ['', '', '', '( ............................................................ )']);

        fclose($output);
        exit;
    }

    /**
     * ส่งออกข้อมูลบริการ OPD ทั้งหมดในช่วงเวลาเป็น CSV (แบบตารางสรุป)
     */
    public function actionExportAllCsv($startDate, $endDate)
    {
        if (ob_get_level()) ob_end_clean();

        $dataProvider = VisitInvoice::searchOpdVisits($startDate, $endDate);
        $dataProvider->pagination = false;
        $models = $dataProvider->getModels();

        $filename = 'opd_visits_summary_' . $startDate . '_to_' . $endDate . '.csv';

        header('Content-Description: File Transfer');
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($output, ['ลำดับ', 'วันที่รับบริการ', 'Visit ID', 'HN', 'ชื่อ-นามสกุล', 'อายุ', 'CID', 'Main Diag', 'Diag อื่นๆ', 'สิทธิการรักษา', 'จำนวนเงิน', 'Claim Code']);

        foreach ($models as $model) {
            fputcsv($output, [
                $model['No'],
                $model['regdate'],
                $model['visit_id'],
                $model['hn'],
                $model['fullname'],
                $model['age'],
                $model['cid'],
                $model['Diagx'],
                $model['Diag'],
                $model['inscl'],
                $model['amount'],
                $model['claim_code'] ?: $model['claimcode'],
            ]);
        }

        fclose($output);
        exit;
    }
}