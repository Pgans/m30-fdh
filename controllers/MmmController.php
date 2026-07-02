<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class MmmController extends Controller
{
	 public function actionIndex()
{
  $data = Yii::$app->request->get();

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
            COUNT(DISTINCT o.VISIT_ID) AS 'visit',
            COUNT(DISTINCT o.HN) AS 'kon',
            COUNT(r.hosp_id) AS 'refers',
            COUNT(DISTINCT i.adm_id) AS 'admit'
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
          AND (:unit_reg = 'ALL' OR o.unit_reg = :unit_reg)";

    // เพิ่มเงื่อนไขเมื่อมีการใส่ icd_code1 และ icd_code2
    if (!empty($icdcode1) && !empty($icdcode2)) {
        $sql1 .= " AND ic.ICD10_TM BETWEEN :icd_code1 AND :icd_code2";
    }

    $sql1 .= "
        GROUP BY YEAR(o.REG_DATETIME), MONTH(o.REG_DATETIME)
        ORDER BY YEAR(o.REG_DATETIME), MONTH(o.REG_DATETIME)
    ";

    try {
        // กำหนดค่าพารามิเตอร์
        $params = [
            ':start_date' => $startDate,
            ':end_date' => $endDate,
            ':unit_reg' => !empty($dep) ? $dep : 'ALL',
        ];

        // ถ้ามี icd_code1 และ icd_code2 ให้ bind ค่าเพิ่ม
        if (!empty($icdcode1) && !empty($icdcode2)) {
            $params[':icd_code1'] = $icdcode1;
            $params[':icd_code2'] = $icdcode2;
        }

        $data1 = Yii::$app->db14->createCommand($sql1, $params)->queryAll();
    } catch (\yii\db\Exception $e) {
        throw new \yii\web\ConflictHttpException('SQL error: ' . $e->getMessage());
    }

    $dataProvider = new ArrayDataProvider([
        'allModels' => $data1,
        'pagination' => [
            'pageSize' => 10,
        ],
    ]);




#$######################################### รายงานตามVisit ##############################################################################
##########################################################################

$sql2 = "SELECT
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
    GROUP_CONCAT(DISTINCT ic.ICD10_TM ORDER BY ic.ICD10_TM ASC SEPARATOR ', ') AS diag
FROM opd_visits o
INNER JOIN cid_hn b ON o.HN = b.HN
INNER JOIN population p ON b.CID = p.CID
LEFT JOIN refers r ON o.VISIT_ID = r.VISIT_ID AND r.IS_CANCEL = 0 AND r.rf_type = 2
LEFT JOIN opd_diagnosis od ON o.VISIT_ID = od.VISIT_ID AND od.IS_CANCEL = 0 AND od.DXT_ID = 1
LEFT JOIN icd10new ic ON od.ICD10 = ic.ICD10
LEFT JOIN ipd_reg i ON i.visit_id = o.visit_id AND i.IS_CANCEL = 0
LEFT JOIN service_units u ON u.unit_id = o.unit_reg
WHERE o.IS_CANCEL = 0
  AND o.reg_datetime BETWEEN :start_date AND :end_date";

// ตรวจสอบแผนก (unit_reg)
$unit_reg = Yii::$app->request->get('unit_reg', 'ALL'); // ค่าเริ่มต้น 'ALL'

if ($unit_reg !== 'ALL') {
    $sql2 .= " AND o.unit_reg = :unit_reg";
}

// ตรวจสอบ ICD Code
if (!empty($icdcode1) && !empty($icdcode2)) {
   $sql2 .= " AND ic.ICD10_TM BETWEEN :icd_code1 AND :icd_code2";
}

// เพิ่ม GROUP BY
$sql2 .= " GROUP BY o.VISIT_ID";

try {
    // กำหนดพารามิเตอร์
    $params = [
        ':start_date' => $startDate,
        ':end_date' => $endDate,
    ];

    if ($unit_reg !== 'ALL') {
        $params[':unit_reg'] = $unit_reg;
    }

    if (!empty($icdcode1) && !empty($icdcode2)) {
        $params[':icd_code1'] = $icdcode1;
        $params[':icd_code2'] = $icdcode2;
    }

    // Debug ตรวจสอบพารามิเตอร์
    Yii::info($params, 'debug');

    // ดึงข้อมูล
    $data2 = Yii::$app->db14->createCommand($sql2, $params)->queryAll();
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



##################  10 อันดับโรค #################################################################################
$sql4 = "
    SELECT 
        ic.ICD10_TM AS `โรค`,
        ic.NICKNAME AS `รายละเอียดโรค`,
        COUNT(o.visit_id) AS `จำนวนครั้ง`
    FROM opd_visits o
    INNER JOIN cid_hn b ON o.HN = b.HN
    INNER JOIN population p ON b.CID = p.CID
    LEFT JOIN refers r ON o.VISIT_ID = r.VISIT_ID AND r.IS_CANCEL = 0 AND r.rf_type = 2
    LEFT JOIN opd_diagnosis od ON o.VISIT_ID = od.VISIT_ID AND od.IS_CANCEL = 0 AND od.DXT_ID = 1
    LEFT JOIN icd10new ic ON od.ICD10 = ic.ICD10
    LEFT JOIN ipd_reg i ON i.visit_id = o.visit_id AND i.IS_CANCEL = 0
    LEFT JOIN service_units u ON u.unit_id = o.unit_reg
    WHERE o.reg_datetime BETWEEN :start_date AND :end_date
      AND (:unit_reg IS NULL OR o.unit_reg = :unit_reg)
      AND ic.ICD10_TM NOT LIKE 'Z%'
";

// ตรวจสอบเงื่อนไขการกรอง ICD Code
if (!empty($icdcode1) && !empty($icdcode2)) {
    $sql4 .= " AND ic.ICD10_TM BETWEEN :icd_code1 AND :icd_code2";
}

// เพิ่ม GROUP BY และ ORDER BY
$sql4 .= "
    GROUP BY ic.ICD10_TM, ic.NICKNAME
    ORDER BY COUNT(o.visit_id) DESC
    LIMIT 10
";

// ดึงค่าจากฟอร์ม
$unit_reg = Yii::$app->request->get('unit_reg', 'ALL');

// กำหนดพารามิเตอร์ SQL
$params = [
    ':start_date' => $startDate,
    ':end_date' => $endDate,
];

// ถ้า unit_reg ไม่ใช่ 'ALL' ให้กำหนดค่า ถ้าเป็น 'ALL' ให้ใช้ `NULL`
$params[':unit_reg'] = ($unit_reg !== 'ALL') ? $unit_reg : null;

// ถ้ามี icd_code1 และ icd_code2 ให้เพิ่มพารามิเตอร์
if (!empty($icdcode1) && !empty($icdcode2)) {
    $params[':icd_code1'] = $icdcode1;
    $params[':icd_code2'] = $icdcode2;
}

// Debug parameters
Yii::info($params, 'debug');

try {
    // Execute the query
    $data4 = Yii::$app->db14->createCommand($sql4, $params)->queryAll();
} catch (\yii\db\Exception $e) {
    throw new \yii\web\ConflictHttpException('SQL error: ' . $e->getMessage());
}

// ดึงข้อมูลชื่อแผนกจากฐานข้อมูล
$departmentName = Yii::$app->db14->createCommand("
    SELECT unit_name 
    FROM service_units 
    WHERE unit_id = :unit_id
")
->bindValue(':unit_id', $unit_reg)
->queryScalar();

// หากไม่พบแผนก ให้ตั้งค่าเป็น "ทั้งหมด"
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
    SELECT 
        m.INSCL_NAME AS 'inscl', 
        COUNT(a.VISIT_ID) AS 'Visit',
        COUNT(DISTINCT a.HN) AS 'amount'
    FROM opd_visits a
    INNER JOIN cid_hn b ON a.HN = b.HN
    INNER JOIN population p ON b.CID = p.CID 
    LEFT JOIN refers r ON a.VISIT_ID = r.VISIT_ID AND r.IS_CANCEL = 0 AND r.rf_type = 2 
    LEFT JOIN opd_diagnosis od ON a.VISIT_ID = od.VISIT_ID AND od.IS_CANCEL = 0 AND DXT_ID = 1
    LEFT JOIN icd10new ic ON od.ICD10 = ic.ICD10 
    LEFT JOIN ipd_reg i ON i.visit_id = a.visit_id AND i.IS_CANCEL = 0
    LEFT JOIN service_units u ON u.unit_id = a.unit_reg
    LEFT JOIN main_inscls m ON a.inscl = m.inscl
    LEFT JOIN mobile_visits mv ON a.VISIT_ID = mv.VISIT_ID AND mv.IS_CANCEL = 0
    WHERE a.IS_CANCEL = 0
      AND a.reg_datetime BETWEEN :start_date AND :end_date
      AND (:unit_reg IS NULL OR a.unit_reg = :unit_reg)
      AND mv.VISIT_ID IS NULL
";

// ตรวจสอบการกรอกข้อมูล ICD Code
if (!empty($icdcode1) && !empty($icdcode2)) {
    $sql5 .= " AND ic.ICD10_TM BETWEEN :icd_code1 AND :icd_code2";
}

// เพิ่ม GROUP BY และ ORDER BY
$sql5 .= "
    GROUP BY m.INSCL_NAME
    ORDER BY amount DESC
    LIMIT 10
";

// ดึงค่าจากฟอร์ม
$unit_reg = Yii::$app->request->get('unit_reg', 'ALL'); // ค่าเริ่มต้นคือ 'ALL'

// กำหนดพารามิเตอร์ SQL
$params = [
    ':start_date' => $startDate,
    ':end_date' => $endDate,
    ':unit_reg' => ($unit_reg !== 'ALL') ? $unit_reg : null, // ใช้ $unit_reg ให้ถูกต้อง
];

// ถ้ามี icd_code1 และ icd_code2 ให้เพิ่มพารามิเตอร์
if (!empty($icdcode1) && !empty($icdcode2)) {
    $params[':icd_code1'] = $icdcode1;
    $params[':icd_code2'] = $icdcode2;
}

try {
    // ดึงข้อมูลจากฐานข้อมูล
    $data5 = Yii::$app->db14->createCommand($sql5, $params)->queryAll();
} catch (\yii\db\Exception $e) {
    throw new \yii\web\ConflictHttpException('SQL error: ' . $e->getMessage());
}

// GridView data provider
$insclProvider = new \yii\data\ArrayDataProvider([
    'allModels' => $data5,
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
