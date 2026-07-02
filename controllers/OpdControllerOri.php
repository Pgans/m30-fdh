<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class OpdController extends Controller
{
	
  public function actionIndex()
{
    $data = Yii::$app->request->get();

    // ใช้ isset() เพื่อเช็คและใช้ strtotime() เพื่อแปลงวันที่
    $startDate = isset($data['start_date']) ? date('Y-m-d 00:01', strtotime($data['start_date'])) : '';
    $endDate = isset($data['end_date']) ? date('Y-m-d 23:59', strtotime($data['end_date'])) : '';

    $dep = Yii::$app->request->get('unit_reg', ''); // Default to '11' if not selected
    $icdcode1 = Yii::$app->request->get('icd_code1', '');
    $icdcode2 = Yii::$app->request->get('icd_code2', '');

    $sql1 = "
        SELECT 
            CASE MONTH(o.REG_DATETIME)
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
            END AS ชื่อเดือน,
            YEAR(o.REG_DATETIME) + 543 AS ปี,
            COUNT(DISTINCT o.VISIT_ID) AS visit,
            COUNT(DISTINCT o.HN) AS kon,
            COUNT(r.hosp_id) AS refers,
            COUNT(DISTINCT i.adm_id) AS admit
        FROM opd_visits o
        INNER JOIN cid_hn b ON o.HN = b.HN
        INNER JOIN population p ON b.CID = p.CID 
        LEFT JOIN refers r ON o.VISIT_ID = r.VISIT_ID AND o.IS_CANCEL = 0 AND r.IS_CANCEL = 0 AND r.rf_type = 2 
        LEFT JOIN opd_diagnosis od ON o.VISIT_ID = od.VISIT_ID AND od.IS_CANCEL = 0 AND DXT_ID = 1
        LEFT JOIN icd10new ic ON od.ICD10 = ic.ICD10 
        LEFT JOIN ipd_reg i ON i.visit_id = o.visit_id AND i.IS_CANCEL = 0
        LEFT JOIN service_units u ON u.unit_id = o.unit_reg
        WHERE o.IS_CANCEL = 0
          AND o.REG_DATETIME BETWEEN :start_date AND :end_date
          AND o.VISIT_ID NOT IN (SELECT mobile_visits.VISIT_ID FROM mobile_visits WHERE mobile_visits.IS_CANCEL = 0)
    ";

    // เพิ่มเงื่อนไขเมื่อมีการใส่ unit_reg
    if (!empty($dep) && $dep !== 'ALL') {
        $sql1 .= " AND o.unit_reg = :unit_reg";
    }

    // เพิ่มเงื่อนไขเมื่อมีการใส่ icd_code1 และ icd_code2
    if (!empty($icdcode1) && !empty($icdcode2)) {
        $sql1 .= " AND ic.ICD10_TM BETWEEN :icd_code1 AND :icd_code2";
    }

    $sql1 .= "
        GROUP BY YEAR(o.REG_DATETIME), MONTH(o.REG_DATETIME)
        ORDER BY YEAR(o.REG_DATETIME), MONTH(o.REG_DATETIME)
    ";

    try {
        // สร้างพารามิเตอร์สำหรับ SQL
        $params = array_filter([
            ':start_date' => $startDate,
            ':end_date' => $endDate,
            ':unit_reg' => !empty($dep) && $dep !== 'ALL' ? $dep : null,
            ':icd_code1' => !empty($icdcode1) ? $icdcode1 : null,
            ':icd_code2' => !empty($icdcode2) ? $icdcode2 : null,
        ]);

        // ดึงข้อมูลจากฐานข้อมูล
        $data1 = Yii::$app->db14->createCommand($sql1, $params)->queryAll();
    } catch (\yii\db\Exception $e) {
        throw new \yii\web\ConflictHttpException('SQL error: ' . $e->getMessage());
    }

    // สร้าง GridView data provider
    $dataProvider = new \yii\data\ArrayDataProvider([
        'allModels' => $data1,
        'pagination' => [
            'pageSize' => 10,
        ],
    ]);
}



   
#$######################################### รายงานตามVisit ##############################################################################
##########################################################################

$sql2 = "
    SELECT
        o.visit_id, o.hn,
        o.REG_DATETIME AS regdate,
        r.rf_dt AS referdate,
        i.adm_dt AS admitdate,
        r.hosp_id AS refer,
        i.adm_id AS an,
        o.unit_reg,
        u.unit_name,
        CONCAT(TRIM(p.fname), ' ', p.lname) AS fullname,
        CASE
            WHEN p.SEX = 1 THEN 'ชาย'
            WHEN p.SEX = 2 THEN 'หญิง'
        END AS `เพศ`,
        TIMESTAMPDIFF(YEAR, p.BIRTHDATE, o.REG_DATETIME) AS `age`,
        GROUP_CONCAT(ic.ICD10_TM) AS diag
    FROM opd_visits o
    INNER JOIN cid_hn b ON o.HN = b.HN
    INNER JOIN population p ON b.CID = p.CID
    LEFT JOIN refers r ON o.VISIT_ID = r.VISIT_ID  AND r.IS_CANCEL = 0 AND r.rf_type = 2
    LEFT JOIN opd_diagnosis od ON o.VISIT_ID = od.VISIT_ID AND od.IS_CANCEL = 0 AND DXT_ID = 1
    LEFT JOIN icd10new ic ON od.ICD10 = ic.ICD10
    LEFT JOIN ipd_reg i ON i.visit_id = o.visit_id AND i.IS_CANCEL = 0
    LEFT JOIN service_units u ON u.unit_id = o.unit_reg
    WHERE o.reg_datetime BETWEEN :start_date AND :end_date
	  AND o.IS_CANCEL = 0
      AND o.VISIT_ID NOT IN (
          SELECT mobile_visits.VISIT_ID
          FROM mobile_visits
          WHERE mobile_visits.IS_CANCEL = 0
      )
      AND (:unit_reg = 'ALL' OR o.unit_reg = :unit_reg)
";

// ตรวจสอบเงื่อนไข ICD Code และเพิ่มใน SQL
if (!empty($icdcode1) && !empty($icdcode2)) {
    $sql2 .= " AND ic.ICD10_TM BETWEEN :icd_code1 AND :icd_code2";
}

// เพิ่ม GROUP BY หลังจากการกรองข้อมูล
$sql2 .= " GROUP BY o.VISIT_ID";

try {
    // กำหนดพารามิเตอร์ให้ตรงกับเงื่อนไข
    $params = [
        ':start_date' => $startDate,
        ':end_date' => $endDate,
        ':unit_reg' => !empty($dep) ? $dep : 'ALL',  // ส่ง 'ALL' หาก :unit_reg ว่าง
        ':icd_code1' => !empty($icdcode1) ? $icdcode1 : null,
        ':icd_code2' => !empty($icdcode2) ? $icdcode2 : null,
    ];

    // ดึงข้อมูลจากฐานข้อมูล
    $command = Yii::$app->db14->createCommand($sql1);
    foreach ($params as $param => $value) {
        if ($value !== null) {
            $command->bindValue($param, $value);
        } else {
            $command->bindValue($param, null, \PDO::PARAM_NULL);
        }
    }
    $data2 = $command->queryAll();
} catch (\yii\db\Exception $e) {
    throw new \yii\web\ConflictHttpException('SQL error: ' . $e->getMessage());
}


// GridView data provider
$visitProvider = new ArrayDataProvider([
    'allModels' => $data2,
    'pagination' => [
        'pageSize' => 100,
    ],
]);

/*
#$##### กราฟ ##############################################################################
$sql3 = "
    SELECT
        CASE MONTH(o.REG_DATETIME)
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
        END AS ชื่อเดือน,
        YEAR(o.REG_DATETIME) + 543 AS ปี,
        COUNT(CASE WHEN r.transport <> '1' THEN o.VISIT_ID END) AS จำนวนครั้งโดยรถโรงพยาบาล,
        COUNT(CASE WHEN r.transport = '1' THEN o.VISIT_ID END) AS ไปเอง,
        COUNT(DISTINCT r.visit_id) AS refer_count,
        COUNT(DISTINCT i.adm_id) AS admit_count,
        COUNT(DISTINCT o.hn) AS person_count,
        COUNT(o.visit_id) AS visit_count,
        COUNT(CASE WHEN TIMESTAMPDIFF(HOUR, o.REG_DATETIME, r.rf_dt) < 2 THEN 1 END) AS less_than_2_hours,
        COUNT(CASE WHEN TIMESTAMPDIFF(HOUR, o.REG_DATETIME, r.rf_dt) >= 2 THEN 1 END) AS more_than_2_hours
    FROM opd_visits o
    INNER JOIN cid_hn b ON o.HN = b.HN
    INNER JOIN population p ON b.CID = p.CID
    LEFT JOIN refers r ON o.VISIT_ID = r.VISIT_ID AND o.IS_CANCEL = 0 AND r.IS_CANCEL = 0 AND r.rf_type = 2
    LEFT JOIN opd_diagnosis od ON o.VISIT_ID = od.VISIT_ID AND od.IS_CANCEL = 0
    LEFT JOIN icd10new ic ON od.ICD10 = ic.ICD10
    LEFT JOIN ipd_reg i ON i.visit_id = o.visit_id AND i.IS_CANCEL = 0
    LEFT JOIN service_units u ON u.unit_id = o.unit_reg
    WHERE o.reg_datetime BETWEEN :start_date AND :end_date
      AND (:unit_reg = 'ALL' OR o.unit_reg = :unit_reg)
    GROUP BY YEAR(o.REG_DATETIME), MONTH(o.REG_DATETIME)
    ORDER BY YEAR(o.REG_DATETIME), MONTH(o.REG_DATETIME)
";

try {
    // ตรวจสอบพารามิเตอร์
    $params = array_filter([
        ':start_date' => $startDate,
        ':end_date' => $endDate,
        ':unit_reg' => !empty($dep) ? $dep : 'ALL',
    ]);

    // Execute the query and fetch data
    $rawData = Yii::$app->db14->createCommand($sql3, $params)->queryAll();
} catch (\yii\db\Exception $e) {
    throw new \yii\web\ConflictHttpException('SQL error: ' . $e->getMessage());
}

// Data provider for GridView
$monthProvider = new \yii\data\ArrayDataProvider([
    'allModels' => $rawData,
    'pagination' => [
        'pageSize' => 20, // Limit number of items per page
    ],
]);
*/
##################  10 อันดับโรค #################################################################################
$sql4 = "
    SELECT 
        ic.ICD10_TM AS `โรค`,
        ic.NICKNAME AS `รายละเอียดโรค`,
        COUNT(o.visit_id) AS `จำนวนครั้ง`
    FROM opd_visits o
    INNER JOIN cid_hn b ON o.HN = b.HN
    INNER JOIN population p ON b.CID = p.CID
    LEFT JOIN refers r ON o.VISIT_ID = r.VISIT_ID AND o.IS_CANCEL = 0 AND r.IS_CANCEL = 0 AND r.rf_type = 2
    LEFT JOIN opd_diagnosis od ON o.VISIT_ID = od.VISIT_ID AND od.IS_CANCEL = 0 AND DXT_ID = 1
    LEFT JOIN icd10new ic ON od.ICD10 = ic.ICD10
    LEFT JOIN ipd_reg i ON i.visit_id = o.visit_id AND i.IS_CANCEL = 0
    LEFT JOIN service_units u ON u.unit_id = o.unit_reg
    WHERE o.REG_DATETIME BETWEEN :start_date AND :end_date
    AND (:unit_reg = 'ALL' OR o.unit_reg = :unit_reg)
	AND left(ic.icd10_tm,1) <> 'z'
	
";

// ตรวจสอบการกรอกข้อมูล ICD Code
if (!empty($icdcode1) && !empty($icdcode2)) {
    $sql4 .= " AND ic.ICD10_TM BETWEEN :icd_code1 AND :icd_code2";
}

// เพิ่ม GROUP BY และ ORDER BY
$sql4 .= "
    GROUP BY ic.ICD10_TM, ic.NICKNAME
    ORDER BY COUNT(o.visit_id) DESC
    LIMIT 10
";

try {
    // กรองค่าพารามิเตอร์ที่ไม่จำเป็นออกจาก array ก่อนการส่งให้ SQL
    $params = array_filter([
        ':start_date' => $startDate,
        ':end_date' => $endDate,
        ':unit_reg' => !empty($dep) ? $dep : 'ALL',  // ส่ง 'ALL' หาก :unit_reg ว่าง
        ':icd_code1' => !empty($icdcode1) ? $icdcode1 : null,
        ':icd_code2' => !empty($icdcode2) ? $icdcode2 : null,
    ]);

    // Execute the query
    $data4 = Yii::$app->db14->createCommand($sql4, $params)->queryAll();
} catch (\yii\db\Exception $e) {
    throw new \yii\web\ConflictHttpException('SQL error: ' . $e->getMessage());
}

// ตัวอย่างการดึงข้อมูลชื่อแผนกจากฐานข้อมูล
$departmentName = Yii::$app->db14->createCommand("
    SELECT unit_name 
    FROM service_units 
    WHERE unit_id = :unit_id
")
->bindValue(':unit_id', $dep)
->queryScalar();

// หากไม่พบแผนก ให้ตั้งค่าเป็น "ทุกแผนก"
$departmentName = $departmentName ?: 'ทั้งหมด';
 
// GridView data provider
$groupProvider = new \yii\data\ArrayDataProvider([
    'allModels' => $data4,
    'pagination' => [
        'pageSize' => 10,
    ],
]);
#########################
##################  แยกตามสิทธิ์การรักษา  #################################################################################

       $sql5 = "
	   
            SELECT m.INSCL_NAME as 'inscl', 
                   COUNT( a.VISIT_ID) as 'Visit',
                   COUNT(DISTINCT a.HN) as 'amount'
            FROM opd_visits a
		INNER JOIN cid_hn b ON a.HN = b.HN
		INNER JOIN population p ON b.CID = p.CID 
		LEFT JOIN refers r ON a.VISIT_ID = r.VISIT_ID AND  r.IS_CANCEL = 0 AND r.rf_type = 2 
		LEFT JOIN opd_diagnosis od ON a.VISIT_ID = od.VISIT_ID AND od.IS_CANCEL = 0 AND DXT_ID = 1
		LEFT JOIN icd10new ic ON od.ICD10 = ic.ICD10 
		LEFT JOIN ipd_reg i ON i.visit_id = a.visit_id AND i.IS_CANCEL = 0
		LEFT JOIN service_units u ON u.unit_id = a.unit_reg
    LEFT JOIN main_inscls m ON a.inscl = m.inscl
        
            WHERE a.IS_CANCEL = 0
              AND a.REG_DATETIME BETWEEN :start_date AND :end_date
              AND (:unit_reg = 'ALL' OR a.unit_reg = :unit_reg)
              AND a.VISIT_ID NOT IN (SELECT mobile_visits.VISIT_ID FROM mobile_visits WHERE mobile_visits.IS_CANCEL = 0)
        ";

        if (!empty($icdcode1) && !empty($icdcode2)) {
            $sql5 .= " AND ic.ICD10_TM BETWEEN :icd_code1 AND :icd_code2";
        }

        $sql5 .= "
            GROUP BY m.INSCL_NAME
            ORDER BY amount DESC
            LIMIT 10
        ";

        try {
            $params = array_filter([
                ':start_date' => $startDate,
                ':end_date' => $endDate,
                ':unit_reg' => !empty($dep) ? $dep : 'ALL',
                ':icd_code1' => $icdcode1,
                ':icd_code2' => $icdcode2,
            ]);

            $data4 = Yii::$app->db14->createCommand($sql5, $params)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('SQL error: ' . $e->getMessage());
        }

        $insclProvider = new ArrayDataProvider([
            'allModels' => $data4,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

	// ส่งค่าข้อมูลไปยัง View
        return $this->render('index', [
            'dataProvider' => $dataProvider,
			'visitProvider' => $visitProvider,
			'groupProvider' => $groupProvider,
			'monthProvider' => $monthProvider,
			'insclProvider' => $insclProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
			'departmentName' => $departmentName,
			'sql2' => $sql2,
        ]);
    }
	
}
