<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

/**
 * T305Controller สำหรับสร้างรายงาน C305
 */
class T305Controller extends Controller
{
    /**
     * แสดงหน้ารายงานพร้อม GridView
     */
    public function actionIndex()
    {
        // Query ข้อมูล
        $data = $this->queryDataWithReason();
        
        // สร้าง DataProvider สำหรับ GridView
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'attributes' => [
                    'trans_id',
                    'trans_id2', 
                    'cid',
                    'hn',
                    'regdate',
                    'fullname',
                    'reason'
                ],
            ],
        ]);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'totalRecords' => count($data),
        ]);
    }
    
   
    
    /**
     * Query ข้อมูลจาก database พร้อม JOIN ตาราง c305 เพื่อดึง reason
     */
    private function queryDataWithReason()
    {
        $sql = "
SELECT o.`เลขอ้างอิงชื่อไฟล์` AS trans_id,
    o.`ประเภทการบริการ` AS trans_id2,
    o.`รหัสบัตรประชาชน` AS cid,
    c.hn,
    o.`วันที่เข้ารับบริการ` AS regdate,
    CONCAT(TRIM(p.fname), ' ', p.lname) AS fullname,
    cc.reason,
	o.`รหัสหัตถการแพทย์แผนไทยที่จ่าย`,
    o.`หน่วยบริการประจำ`
from population p 
INNER JOIN cid_hn c ON c.cid = p.cid
INNER JOIN c305_oppp o ON o.`รหัสบัตรประชาชน` = p.cid
LEFT JOIN c305 cc ON cc.TRAN_ID = o.`ประเภทการบริการ` 
WHERE #p.cid = '3341400406350'
 o.`วันที่เข้ารับบริการ`  BETWEEN '2025-01-01' AND '2026-09-30'
AND o.`หน่วยบริการประจำ` LIKE '%TT305%' 
AND o.`หน่วยบริการประจำ` NOT LIKE '%TT004%'
AND o.`หน่วยบริการประจำ` NOT LIKE '%TT020%'
#GROUP BY o.`ประเภทการบริการ` 
GROUP BY cc.tran_id
ORDER BY 
    o.`วันที่เข้ารับบริการ` DESC,
    o.`เลขอ้างอิงชื่อไฟล์`;

        ";
        
        try {
            $data = Yii::$app->db70->createCommand($sql)->queryAll();
            
            // ทำความสะอาดข้อมูล
            foreach ($data as &$row) {
                $row['tran_id'] = trim($row['tran_id'] ?? '');
                $row['trans_id2'] = trim($row['trans_id2'] ?? '');
                $row['cid'] = trim($row['cid'] ?? '');
                $row['hn'] = trim($row['hn'] ?? '');
                $row['regdate'] = trim($row['regdate'] ?? '');
                $row['fullname'] = trim($row['fullname'] ?? '');
                $row['reason'] = trim($row['reason'] ?? '');
            }
            
            return $data;
            
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาดในการดึงข้อมูล: ' . $e->getMessage());
            return [];
        }
    }
    
    public function actionExport()
    {
        $data = $this->queryDataWithReason();
        $this->exportToCsv($data);
    }
    
    /**
     * Export เฉพาะเดือน
     */
    public function actionExportMonth($month)
    {
        // ตรวจสอบ format ของ month
        if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
            throw new \yii\web\BadRequestHttpException('รูปแบบเดือนไม่ถูกต้อง');
        }
        
        $data = $this->queryDataWithReason();
        
        // กรองข้อมูลเฉพาะเดือนที่เลือก
        $monthData = [];
        foreach ($data as $row) {
            $serviceDate = $row['regdate'];
            
            if (empty($serviceDate) || strtotime($serviceDate) === false) {
                continue;
            }
            
            $monthKey = date('Y-m', strtotime($serviceDate));
            
            if ($monthKey === $month) {
                $monthData[] = $row;
            }
        }
        
        // Export
        $this->exportToCsv($monthData, $month);
    }
    
    /**
     * Export ข้อมูลเป็น CSV พร้อม format และเติมเหตุผลอัตโนมัติ
     * 
     * @param array $data ข้อมูลที่จะ export
     * @param string $month (optional) เดือนสำหรับตั้งชื่อไฟล์ เช่น 2025-01
     */
  private function exportToCsv($data, $month = null)
{
    $defaultReasons = [
        'ให้บริการนอกพื้นที่ไม่สามารถขอ Authen ได้ทันในวันที่รับบริการ',
        'ระบบอินเตอร์เนตของหน่วยบริการมีปัญหา ทำให้ไม่สามารถขอ Authen ได้',
        'ปัญหาในหน่วยบริการเอง มีผู้รับบริการจำนวนมาก ทำให้ไม่สามารถขอ Authen ได้ทันเวลา'
    ];

    $filename = $month
        ? 'c305_report_' . $month . '_' . date('Ymd_His') . '.csv'
        : 'c305_report_' . date('Ymd_His') . '.csv';

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $output = fopen('php://output', 'w');

    // BOM รองรับภาษาไทย
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

    // ===== หัวกระดาษ =====
    fputcsv($output, [
        'แบบแจ้งเหตุผลความจำเป็นกรณีไม่ได้จัดให้ผู้มีสิทธิแสดงตนยืนยันสิทธิเมื่อสิ้นสุดการรับบริการ'
    ]);
    fputcsv($output, ['']);
    fputcsv($output, [
        'ชื่อหน่วยบริการ โรงพยาบาลม่วงสามสิบ รหัสหน่วยบริการ 10953'
    ]);
    fputcsv($output, ['']);
    // =======================

    // ===== Header ตาราง (เพิ่ม 2 คอลัมน์ซ้ายสุด) =====
    fputcsv($output, [
        'ลำดับ',
        'โปรแกรมที่ส่งเบิก',
        'เลขอ้างอิงชื่อไฟล์',
        'รหัสอ้างอิงจากแฟ้ม SERVICE',
        'รหัสบัตรประชาชน',
        'HN',
        'วันที่เข้ารับบริการ',
        'ชื่อ-สกุล',
        'เหตุผล'
    ]);

    if (!empty($data)) {

        $no = 1; // ตัวนับลำดับ

        foreach ($data as $row) {

            // ===== HN 6 หลัก + กัน Excel ตัด 0 =====
            $hn = trim($row['hn'] ?? '');

            if ($hn !== '') {
                $hn = preg_replace('/\D/', '', $hn);
                $hn = str_pad($hn, 6, '0', STR_PAD_LEFT);
                $hn = '="' . $hn . '"';
            } else {
                $hn = '="000000"';
            }

            // เหตุผล
            $reason = trim($row['reason'] ?? '');
            if ($reason === '') {
                $reason = $defaultReasons[array_rand($defaultReasons)];
            }

            // วันที่
            $regdate = $row['regdate'] ?? '';
            if (!empty($regdate) && strtotime($regdate)) {
                $regdate = date('d/m/Y', strtotime($regdate));
            }

            // ===== เขียนข้อมูล (เพิ่ม ลำดับ + oppp) =====
            fputcsv($output, [
                $no++,                 // ลำดับ
                'oppp',                // โปรแกรมที่ส่งเบิก
                $row['trans_id'] ?? '',
                $row['trans_id2'] ?? '',
                $row['cid'] ?? '',
                $hn,
                $regdate,
                $row['fullname'] ?? '',
                $reason
            ]);
        }
    }

    fclose($output);
    exit();
}



    /**
     * ฟังก์ชันสำหรับแสดงสถิติ
     */
     public function actionStatistics()
    {
        $data = $this->queryDataWithReason();
        
        // ชื่อเดือนภาษาไทย
        $thaiMonths = [
            '01' => 'มกราคม', '02' => 'กุมภาพันธ์', '03' => 'มีนาคม',
            '04' => 'เมษายน', '05' => 'พฤษภาคม', '06' => 'มิถุนายน',
            '07' => 'กรกฎาคม', '08' => 'สิงหาคม', '09' => 'กันยายน',
            '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม'
        ];
        
        // จัดกลุ่มข้อมูลตามเดือน
        $monthlyStats = [];
        
        foreach ($data as $row) {
            // ใช้ field 'regdate' ที่มาจาก `วันที่เข้ารับบริการ`
            $serviceDate = $row['regdate'];
            
            // ข้ามถ้าไม่มีวันที่หรือวันที่ไม่ถูกต้อง
            if (empty($serviceDate) || strtotime($serviceDate) === false) {
                continue;
            }
            
            // สร้าง key เป็น YYYY-MM
            $monthKey = date('Y-m', strtotime($serviceDate));
            $month = date('m', strtotime($serviceDate));
            $year = date('Y', strtotime($serviceDate)) + 543; // แปลงเป็น พ.ศ.
            
            $monthLabel = $thaiMonths[$month] . ' ' . $year;
            
            // สร้างข้อมูลเดือนถ้ายังไม่มี
            if (!isset($monthlyStats[$monthKey])) {
                $monthlyStats[$monthKey] = [
                    'label' => $monthLabel,
                    'total' => 0,
                    'withReason' => 0,
                    'withoutReason' => 0,
                ];
            }
            
            // นับจำนวน
            $monthlyStats[$monthKey]['total']++;
            
            if (!empty($row['reason'])) {
                $monthlyStats[$monthKey]['withReason']++;
            } else {
                $monthlyStats[$monthKey]['withoutReason']++;
            }
        }
        
        // เรียงลำดับจากเดือนล่าสุดไปเก่าสุด
        krsort($monthlyStats);
        
        return $this->render('statistics', [
            'monthlyStats' => $monthlyStats,
        ]);
    }
	/**
     * แสดงรายละเอียดข้อมูลในเดือนที่เลือก
     */
    public function actionMonthDetail($month)
    {
        // ตรวจสอบ format ของ month (ต้องเป็น YYYY-MM)
        if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
            throw new \yii\web\BadRequestHttpException('รูปแบบเดือนไม่ถูกต้อง');
        }
        
        $data = $this->queryDataWithReason();
        
        // ชื่อเดือนภาษาไทย
        $thaiMonths = [
            '01' => 'มกราคม', '02' => 'กุมภาพันธ์', '03' => 'มีนาคม',
            '04' => 'เมษายน', '05' => 'พฤษภาคม', '06' => 'มิถุนายน',
            '07' => 'กรกฎาคม', '08' => 'สิงหาคม', '09' => 'กันยายน',
            '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม'
        ];
        
        // กรองข้อมูลเฉพาะเดือนที่เลือก
        $monthData = [];
        foreach ($data as $row) {
            $serviceDate = $row['regdate'];
            
            if (empty($serviceDate) || strtotime($serviceDate) === false) {
                continue;
            }
            
            $monthKey = date('Y-m', strtotime($serviceDate));
            
            if ($monthKey === $month) {
                $monthData[] = $row;
            }
        }
        
        // สร้าง label เดือน
        list($year, $monthNum) = explode('-', $month);
        $yearThai = $year + 543;
        $monthLabel = $thaiMonths[$monthNum] . ' ' . $yearThai;
        
        // สร้าง dataProvider
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $monthData,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['regdate', 'hn', 'reason'],
                'defaultOrder' => [
                    'regdate' => SORT_DESC,
                ],
            ],
        ]);
        
        return $this->render('month-detail', [
            'dataProvider' => $dataProvider,
            'monthLabel' => $monthLabel,
            'month' => $month,
            'totalCount' => count($monthData),
            'withReasonCount' => count(array_filter($monthData, function($row) {
                return !empty($row['reason']);
            })),
            'withoutReasonCount' => count(array_filter($monthData, function($row) {
                return empty($row['reason']);
            })),
        ]);
    }
}