<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class DashtotalvisitController extends Controller
{
    public function actionIndex()
    {  
	    $db = Yii::$app->db14;

// 1. ดึงวันที่ล่าสุด และวันที่ย้อนหลัง 6 วัน
$endDate = $db->createCommand("
    SELECT DATE(MAX(regdate)) 
    FROM log_totalvisits 
    WHERE users = 'opd'
")->queryScalar();

$startDate = date('Y-m-d', strtotime($endDate . ' -6 days'));

// 2. สร้าง Temporary Table สำหรับ base count
$sqlTemp = "
    CREATE TEMPORARY TABLE tmp_base_visits AS
    SELECT 
        DATE(a.REG_DATETIME) AS reg_day,
        COUNT(DISTINCT a.VISIT_ID) AS base_count
    FROM opd_visits a
    LEFT JOIN cid_hn b ON a.HN = b.HN
    LEFT JOIN population c ON b.CID = c.CID
    LEFT JOIN main_inscls f ON a.INSCL = f.INSCL
    WHERE a.IS_CANCEL = 0
      AND a.VISIT_ID NOT IN (SELECT ipd_reg.VISIT_ID FROM ipd_reg WHERE IS_CANCEL = 0)
      AND a.VISIT_ID NOT IN (SELECT mobile_visits.VISIT_ID FROM mobile_visits WHERE is_cancel = 0)
      AND EXISTS (
          SELECT 1 FROM opd_diagnosis h
          WHERE h.VISIT_ID = a.VISIT_ID
            AND h.DXT_ID = 1
            AND h.IS_CANCEL = 0
      )
      AND a.REG_DATETIME BETWEEN :start_date AND :end_date
    GROUP BY DATE(a.REG_DATETIME)
";
$db->createCommand($sqlTemp)
    ->bindValue(':start_date', $startDate . ' 00:00:00')
    ->bindValue(':end_date', $endDate . ' 23:59:59')
    ->execute();

// 3. Query final summary with JOIN
$sqlFinal = "
    SELECT 
        DATE(l.regdate) AS reg_day,
        COUNT(*) AS sent_count,
        COALESCE(b.base_count, 0) AS base_count
    FROM log_totalvisits l
    LEFT JOIN tmp_base_visits b ON DATE(l.regdate) = b.reg_day
    WHERE l.users = 'opd'
      AND DATE(l.regdate) BETWEEN :start_date AND :end_date
    GROUP BY DATE(l.regdate)
    ORDER BY reg_day DESC
";

$rawData = $db->createCommand($sqlFinal)
    ->bindValue(':start_date', $startDate)
    ->bindValue(':end_date', $endDate)
    ->queryAll();

// 4. ใส่ใน DataProvider สำหรับ View
$opd1Provider = new ArrayDataProvider([
    'allModels' => $rawData,
    'pagination' => false,
]);

	   #######################################################################################
        $sql = "
            SELECT 
                MONTH(regdate) AS month_en,
                CASE MONTH(regdate)
                    WHEN 1 THEN 'มกราคม'
                    WHEN 2 THEN 'กุมภาพันธ์'
                    WHEN 3 THEN 'มีนาคม'
                    WHEN 4 THEN 'เมษายน'
                    WHEN 5 THEN 'พฤษภาคม'
                    WHEN 6 THEN 'มิถุนายน'
                    WHEN 7 THEN 'กรกฎาคม'
                    WHEN 8 THEN 'สิงหาคม'
                    WHEN 9 THEN 'กันยายน'
                    WHEN 10 THEN 'ตุลาคม'
                    WHEN 11 THEN 'พฤศจิกายน'
                    WHEN 12 THEN 'ธันวาคม'
                END AS thai_month,
                YEAR(regdate) + 543 AS thai_year,
                COUNT(*) AS total_visits
            FROM log_totalvisits
            WHERE users = 'opd'
              AND regdate BETWEEN '2024-10-01 00:01' AND '2025-09-30 23:59'
            GROUP BY YEAR(regdate), MONTH(regdate)
            ORDER BY YEAR(regdate), MONTH(regdate)
        ";

        $rawData = Yii::$app->db14->createCommand($sql)->queryAll();

        $opdProvider = new ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => false,
        ]);
		###############################################################################################
	// 1) ดึงวันที่ล่าสุดจาก log_totalvisits ที่ users = 'ipd'
$endDate = Yii::$app->db14->createCommand("
    SELECT DATE(MAX(regdate)) 
    FROM log_totalvisits 
    WHERE users = 'ipd'
")->queryScalar();

// 2) ย้อนหลัง 6 วัน (รวมเป็น 7 วัน)
$startDate = (new \DateTime($endDate))->modify('-6 days')->format('Y-m-d');

// 3) สร้างตารางชั่วคราวด้วย SQL ตั้งต้น
Yii::$app->db14->createCommand("DROP TEMPORARY TABLE IF EXISTS tmp_ipd_base_visits")->execute();

Yii::$app->db14->createCommand("
    CREATE TEMPORARY TABLE tmp_ipd_base_visits AS
    SELECT 
        DATE(a.DSC_DT) AS reg_day,
        COUNT(DISTINCT a.VISIT_ID) AS base_count
    FROM ipd_reg a
    LEFT JOIN opd_visits b ON a.VISIT_ID = b.VISIT_ID AND b.IS_CANCEL = 0
    LEFT JOIN cid_hn c ON c.HN = b.HN
    LEFT JOIN population d ON c.CID = d.CID
    LEFT JOIN main_inscls e ON e.INSCL = b.INSCL
    WHERE a.IS_CANCEL = 0
      AND a.WARD_NO != 57
      AND a.DSC_DT BETWEEN :start AND :end
    GROUP BY DATE(a.DSC_DT)
", [
    ':start' => $startDate . ' 00:01:00',
    ':end' => $endDate . ' 23:59:59',
])->execute();

// 4) ดึงข้อมูลเปรียบเทียบการส่งกับฐานข้อมูลจริง
$rawDataIpd = Yii::$app->db14->createCommand("
    SELECT
    DATE(l.regdate) AS reg_day,
    COUNT(DISTINCT l.visit_id) AS sent_count,
    COALESCE(b.base_count, 0) AS base_count
FROM log_totalvisits l
LEFT JOIN tmp_ipd_base_visits b ON DATE(l.regdate) = b.reg_day
WHERE l.users = 'ipd'
  AND DATE(l.regdate) BETWEEN
    (SELECT DATE(MAX(regdate)) FROM log_totalvisits WHERE users = 'ipd') - INTERVAL 6 DAY
    AND (SELECT DATE(MAX(regdate)) FROM log_totalvisits WHERE users = 'ipd')
GROUP BY DATE(l.regdate)
ORDER BY reg_day DESC;


", [
    ':start' => $startDate,
    ':end' => $endDate,
])->queryAll();

// 5) ส่งข้อมูลไปแสดงใน GridView หรือ DataProvider
$ipd1Provider = new \yii\data\ArrayDataProvider([
    'allModels' => $rawDataIpd,
    'pagination' => false,
]);



		###############################################################################################
		 $sql2 = "
            SELECT 
                MONTH(regdate) AS month_en,
                CASE MONTH(regdate)
                    WHEN 1 THEN 'มกราคม'
                    WHEN 2 THEN 'กุมภาพันธ์'
                    WHEN 3 THEN 'มีนาคม'
                    WHEN 4 THEN 'เมษายน'
                    WHEN 5 THEN 'พฤษภาคม'
                    WHEN 6 THEN 'มิถุนายน'
                    WHEN 7 THEN 'กรกฎาคม'
                    WHEN 8 THEN 'สิงหาคม'
                    WHEN 9 THEN 'กันยายน'
                    WHEN 10 THEN 'ตุลาคม'
                    WHEN 11 THEN 'พฤศจิกายน'
                    WHEN 12 THEN 'ธันวาคม'
                END AS thai_month,
                YEAR(regdate) + 543 AS thai_year,
                COUNT(*) AS total_visits
            FROM log_totalvisits
            WHERE users = 'ipd'
              AND regdate BETWEEN '2024-10-01 00:01' AND '2025-03-31 23:59'
            GROUP BY YEAR(regdate), MONTH(regdate)
            ORDER BY YEAR(regdate), MONTH(regdate)
        ";

        $rawData2 = Yii::$app->db14->createCommand($sql2)->queryAll();

        $ipdProvider = new ArrayDataProvider([
            'allModels' => $rawData2,
            'pagination' => false,
        ]);

        return $this->render('index', [
            'opdProvider' => $opdProvider,
			'opd1Provider' => $opd1Provider,
			'ipdProvider' => $ipdProvider,
			'ipd1Provider' => $ipd1Provider
        ]);
    }
}