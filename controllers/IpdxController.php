<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class IpdController extends Controller
{
	public function actionIndex()
    {
 // รับข้อมูลจากฟอร์ม (POST)
    $data = Yii::$app->request->post();
    
    // ตรวจสอบค่าจากฟอร์ม (POST) และตั้งค่าเวลา
// ตรวจสอบค่าจากฟอร์ม (POST) และตั้งค่าเวลา
// รับค่าจาก URL หรือจากฟอร์ม
$startDate = Yii::$app->request->get('start_date', '2025-01-01 00:01'); // ค่าเริ่มต้นเป็น 2025-01-01 00:01
$endDate = Yii::$app->request->get('end_date', '2025-01-31 23:59'); // ค่าเริ่มต้นเป็น 2025-01-31 23:59

	
    $dep = Yii::$app->request->get('unit_reg', ''); // Default to '11' if not selected
    $icdcode1 = Yii::$app->request->get('icd_code1', '');
    $icdcode2 = Yii::$app->request->get('icd_code2', '');
	#############  รวมการนับจำนวนครั้ง จำนวนคน ##################################################
$sql1 = "
    SELECT 
        CASE MONTH(i.adm_dt)
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
        YEAR(i.adm_dt) + 543 AS ปี,
        COUNT(DISTINCT i.VISIT_ID) AS 'visit',
        COUNT(DISTINCT o.HN) AS 'kon',
        COUNT(r.hosp_id) AS 'refers',
        COUNT(DISTINCT i.adm_id) AS 'admit',
		SUM(CASE WHEN i.ward_no = '38' THEN 1 ELSE 0 END) AS 'ward1',
        SUM(CASE WHEN i.ward_no = '39' THEN 1 ELSE 0 END) AS 'ward2',
        SUM(CASE WHEN i.ward_no = '22' THEN 1 ELSE 0 END) AS 'lr',
        SUM(CASE WHEN i.ward_no = '50' THEN 1 ELSE 0 END) AS 'HomeWard',
        SUM(CASE WHEN i.ward_no = '55' THEN 1 ELSE 0 END) AS 'ward4'
    FROM opd_visits o
    INNER JOIN cid_hn b ON o.HN = b.HN
    INNER JOIN population p ON b.CID = p.CID 
    LEFT JOIN refers r ON o.VISIT_ID = r.VISIT_ID AND o.IS_CANCEL = 0 AND r.IS_CANCEL = 0 AND r.rf_type = 2 
    LEFT JOIN opd_diagnosis od ON o.VISIT_ID = od.VISIT_ID AND od.IS_CANCEL = 0 AND DXT_ID = 1
    LEFT JOIN icd10new ic ON od.ICD10 = ic.ICD10 
    INNER JOIN ipd_reg i ON i.visit_id = o.visit_id 
    LEFT JOIN service_units u ON u.unit_id = o.unit_reg
    WHERE o.IS_CANCEL = 0
	  AND i.IS_CANCEL = 0
      AND i.dsc_dt BETWEEN :start_date AND :end_date
      AND (:ward_no IS NULL OR i.ward_no = :ward_no)
";

// เพิ่มเงื่อนไขเมื่อมีการใส่ icd_code1 และ icd_code2
if (!empty($icdcode1) && !empty($icdcode2)) {
    $sql1 .= " AND ic.ICD10_TM BETWEEN :icd_code1 AND :icd_code2";
}

$sql1 .= "
    GROUP BY YEAR(i.adm_dt), MONTH(i.adm_dt)
    ORDER BY YEAR(i.adm_dt), MONTH(i.adm_dt)
";
// ดึงค่าจากฟอร์ม
$ward_no = Yii::$app->request->get('ward_no', 'ALL'); // ค่าเริ่มต้นคือ 'ALL'
try {
    // สร้างพารามิเตอร์สำหรับ SQL
    $params = array_filter([
        ':start_date' => $startDate,
        ':end_date' => $endDate,
        ':ward_no' => ($ward_no !== 'ALL') ? $ward_no : null, // หากเป็น 'ALL' จะส่ง null
        ':icd_code1' => !empty($icdcode1) ? $icdcode1 : null,
        ':icd_code2' => !empty($icdcode2) ? $icdcode2 : null,
    ]);
    // ตรวจสอบว่าเมื่อ ward_no เป็น null จะส่ง null จริงๆ
if ($ward_no === 'ALL') {
    $params[':ward_no'] = null;
}
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
    i.ward_no,
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
LEFT JOIN refers r ON o.VISIT_ID = r.VISIT_ID AND r.IS_CANCEL = 0 AND r.rf_type = 2
LEFT JOIN opd_diagnosis od ON o.VISIT_ID = od.VISIT_ID AND od.IS_CANCEL = 0 AND DXT_ID = 1
LEFT JOIN icd10new ic ON od.ICD10 = ic.ICD10
INNER JOIN ipd_reg i ON i.visit_id = o.visit_id AND i.IS_CANCEL = 0
LEFT JOIN service_units u ON u.unit_id = i.WARD_NO
WHERE o.IS_CANCEL = 0
  AND i.dsc_dt BETWEEN :start_date AND :end_date
  AND (:ward_no IS NULL OR i.ward_no = :ward_no)
";

// ตรวจสอบเงื่อนไข ICD Code และเพิ่มใน SQL
if (!empty($icdcode1) && !empty($icdcode2)) {
    $sql2 .= " AND ic.ICD10_TM BETWEEN :icd_code1 AND :icd_code2";
}

// เพิ่ม GROUP BY หลังจากการกรองข้อมูล
$sql2 .= " GROUP BY o.VISIT_ID";

// ดึงค่าจากฟอร์ม
$ward_no = Yii::$app->request->get('ward_no', 'ALL'); // ค่าเริ่มต้นคือ 'ALL'

// ตรวจสอบและกำหนดพารามิเตอร์
$params = array_filter([
    ':start_date' => $startDate ,
    ':end_date' => $endDate ,
    ':ward_no' => ($ward_no !== 'ALL') ? $ward_no : null, // หากเป็น 'ALL' จะส่ง null
    ':icd_code1' => !empty($icdcode1) ? $icdcode1 : null,
    ':icd_code2' => !empty($icdcode2) ? $icdcode2 : null,
]);
// ตรวจสอบว่าเมื่อ ward_no เป็น null จะส่ง null จริงๆ
if ($ward_no === 'ALL') {
    $params[':ward_no'] = null;
}
try {
    // Execute the query
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
    INNER JOIN ipd_reg i ON i.visit_id = o.visit_id AND i.IS_CANCEL = 0
    LEFT JOIN service_units u ON u.unit_id = o.unit_reg
    WHERE i.dsc_dt BETWEEN :start_date AND :end_date
    AND (:ward_no IS NULL OR i.ward_no = :ward_no)
    AND LEFT(ic.ICD10_TM, 1) <> 'Z'
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

// ดึงค่าจากฟอร์ม
$ward_no = Yii::$app->request->get('ward_no', 'ALL'); // ค่าเริ่มต้นคือ 'ALL'

// ตรวจสอบและกำหนดพารามิเตอร์
$params = array_filter([
    ':start_date' => $startDate ?? '2025-01-14 00:01',
    ':end_date' => $endDate ?? '2025-01-19 23:59',
    ':ward_no' => ($ward_no !== 'ALL') ? $ward_no : null, // หากเป็น 'ALL' จะส่ง null
    ':icd_code1' => !empty($icdcode1) ? $icdcode1 : null,
    ':icd_code2' => !empty($icdcode2) ? $icdcode2 : null,
]);
// ตรวจสอบว่าเมื่อ ward_no เป็น null จะส่ง null จริงๆ
if ($ward_no === 'ALL') {
    $params[':ward_no'] = null;
}

try {
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
    SELECT m.INSCL_NAME as 'inscl', 
           COUNT(a.VISIT_ID) as 'Visit',
           COUNT(DISTINCT a.HN) as 'amount'
    FROM opd_visits a
    INNER JOIN cid_hn b ON a.HN = b.HN
    INNER JOIN population p ON b.CID = p.CID 
    LEFT JOIN refers r ON a.VISIT_ID = r.VISIT_ID AND r.IS_CANCEL = 0 AND r.rf_type = 2 
    LEFT JOIN opd_diagnosis od ON a.VISIT_ID = od.VISIT_ID AND od.IS_CANCEL = 0 AND DXT_ID = 1
    LEFT JOIN icd10new ic ON od.ICD10 = ic.ICD10 
    INNER JOIN ipd_reg i ON i.visit_id = a.visit_id AND i.IS_CANCEL = 0
    LEFT JOIN service_units u ON u.unit_id = a.unit_reg
    LEFT JOIN main_inscls m ON a.inscl = m.inscl
    WHERE a.IS_CANCEL = 0
      AND i.dsc_dt BETWEEN :start_date AND :end_date
      AND (:ward_no IS NULL OR i.ward_no = :ward_no)
      AND a.VISIT_ID NOT IN (SELECT mobile_visits.VISIT_ID FROM mobile_visits WHERE mobile_visits.IS_CANCEL = 0)
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
$ward_no = Yii::$app->request->get('ward_no', 'ALL'); // ค่าเริ่มต้นคือ 'ALL'

// ตรวจสอบและกำหนดพารามิเตอร์
$params = array_filter([
    ':start_date' => $startDate ?? '2025-01-14 00:01',
    ':end_date' => $endDate ?? '2025-01-19 23:59',
    ':ward_no' => ($ward_no !== 'ALL') ? $ward_no : null, // หากเป็น 'ALL' จะส่ง null
    ':icd_code1' => !empty($icdcode1) ? $icdcode1 : null,
    ':icd_code2' => !empty($icdcode2) ? $icdcode2 : null,
]);
// ตรวจสอบว่าเมื่อ ward_no เป็น null จะส่ง null จริงๆ
if ($ward_no === 'ALL') {
    $params[':ward_no'] = null;
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
