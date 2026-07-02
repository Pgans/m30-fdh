<?php

namespace app\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
//use yii2mod\alert\Alert;
/* เพิ่มคำสั่ง 3 บรรทัดต่อจากนี้ลงไป */
use yii\filters\AccessControl;        // เรียกใช้ คลาส AccessControl
use app\models\User;             // เรียกใช้ Model คลาส User ที่ปรับปรังปรุงไว้
use app\components\AccessRule;   // เรียกใช้ คลาส Component AccessRule ที่เราสร้างใหม่


class RptfdhController extends \yii\web\Controller
{
	/*
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
                'only'=> ['index','reportall','reportipd','update','view','delete'],
                'ruleConfig'=>[
                    'class'=>AccessRule::className()
                ],
                'rules'=>[
                    [
                        'actions' => ['index', 'view','create'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions'=>['index','create','view'],
                        'allow'=> true,
                        'roles' => [
                           User::ROLE_USER,
                         ]
                    ],
                    [
                        'actions'=>['update','view'],
                        'allow'=> true,
                        'roles'=>[
                            User::ROLE_EMPLOYEE,
                            User::ROLE_ADMIN
                        ]
                    ],
                    [
                        'actions'=>['reportall','reportipd','create','update','view'],
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
	*/
    public function actionIndex() {
        $y = date("Y", time());
        $m = date("m", time());

        if ($m == '01') {
            $trans_m = 'มกราคม';
        } elseif ($m == '02') {
            $trans_m = 'กุมภาพันธ์';
        } elseif ($m == '03') {
            $trans_m = 'มีนาคม';
        } elseif ($m == '04') {
            $trans_m = 'เมษายน';
        } elseif ($m == '05') {
            $trans_m = 'พฤษภาคม';
        } elseif ($m == '06') {
            $trans_m = 'มิถุนายน';
        } elseif ($m == '07') {
            $trans_m = 'กรกฎาคม';
        } elseif ($m == '08') {
            $trans_m = 'สิงหาคม';
        } elseif ($m == '09') {
            $trans_m = 'กันยายน';
        } elseif ($m == '10') {
            $trans_m = 'ตุลาคม';
        } elseif ($m == '11') {
            $trans_m = 'พฤศจิกายน';
        } else {
            $trans_m = 'ธันวาคม';
        }
        /*
         * คำสั่ง sql ดึงข้อมูลการส่งเคลม FDH ของเดือนปัจจุบัน
         */
        $sql = "
        SELECT v.license, d.driver_id ,d.driver_name,
        r.date_start AS start,
        r.date_end AS end,
        p.firstname AS fn,
        p.lastname AS ln
        FROM rental r
         LEFT JOIN vehicle v ON v.vehicle_id = r.vehicle_id
		INNER JOIN drivers d ON d.driver_id = r.driver_id 
        LEFT JOIN person p ON p.user_id = r.user_id
        WHERE MONTH(r.date_start)= '" . $m . "' AND YEAR(r.date_start) = '" . $y . " ' AND r.status = '1'
         ORDER BY r.date_start DESC ";
        $data = Yii::$app->db70->createCommand($sql)->queryAll();

        /*
         * ส่งข้อมูลให้ตาราง
         */
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);

        return $this->render('index', [
                    'month' => $trans_m,
                    'dataProvider' => $dataProvider,
                    $dataProvider->pagination = [
                        'pageSize' => 15,
                    
                    ]
        ]);
		
	}
###############################   REP  ##############################################################
 public function actionRep() 
{
    $sql = "SELECT pt_type, tran_id, rep_no, dt_rep, dt_statement 
            FROM cost_visits 
            WHERE dt_timestamp >= 0
            AND rep_no BETWEEN '671000001' AND '681200100'
            GROUP BY rep_no
            ORDER BY dt_rep DESC";

    $data = Yii::$app->db70->createCommand($sql)->queryAll(); 

    // ใช้ ArrayDataProvider เพื่อให้ GridView ใช้ข้อมูลได้
    $dataProvider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => [
            'pageSize' => 800, // กำหนดจำนวนข้อมูลต่อหน้า
        ],
        'sort' => [
            'attributes' => ['dt_rep', 'rep_no'], // กำหนดคอลัมน์ที่สามารถ sort ได้
        ],
    ]);

    return $this->render('rep', [
        'dataProvider' => $dataProvider,
    ]);
}
  
 ##############################################################################################
  public function actionReportall() {
    $currentYear = date("Y", time());
    $currentMonth = date("m", time());
    
    // คำนวณปีงบประมาณ
    if ($currentMonth >= 10) {
        $fiscalYear = $currentYear;
    } else {
        $fiscalYear = $currentYear - 1;
    }

    $sql = "SELECT r.users,
                 -- นับจำนวน visit_id ตามเดือนที่ไม่ถูก reject หรือค่าว่าง
    COUNT(IF(MONTH(o.reg_datetime) = 1 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r1,
    COUNT(IF(MONTH(o.reg_datetime) = 1, o.visit_id, NULL)) AS t1,
    COUNT(IF(MONTH(o.reg_datetime) = 2 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r2,
    COUNT(IF(MONTH(o.reg_datetime) = 2, o.visit_id, NULL)) AS t2,
    COUNT(IF(MONTH(o.reg_datetime) = 3 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r3,
    COUNT(IF(MONTH(o.reg_datetime) = 3, o.visit_id, NULL)) AS t3,
    COUNT(IF(MONTH(o.reg_datetime) = 4 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r4,
    COUNT(IF(MONTH(o.reg_datetime) = 4, o.visit_id, NULL)) AS t4,
    COUNT(IF(MONTH(o.reg_datetime) = 5 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r5,
    COUNT(IF(MONTH(o.reg_datetime) = 5, o.visit_id, NULL)) AS t5,
    COUNT(IF(MONTH(o.reg_datetime) = 6 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r6,
    COUNT(IF(MONTH(o.reg_datetime) = 6, o.visit_id, NULL)) AS t6,
    COUNT(IF(MONTH(o.reg_datetime) = 7 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r7,
    COUNT(IF(MONTH(o.reg_datetime) = 7, o.visit_id, NULL)) AS t7,
    COUNT(IF(MONTH(o.reg_datetime) = 8 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r8,
    COUNT(IF(MONTH(o.reg_datetime) = 8, o.visit_id, NULL)) AS t8,
    COUNT(IF(MONTH(o.reg_datetime) = 9 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r9,
    COUNT(IF(MONTH(o.reg_datetime) = 9, o.visit_id, NULL)) AS t9,
    COUNT(IF(MONTH(o.reg_datetime) = 10 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r10,
    COUNT(IF(MONTH(o.reg_datetime) = 10, o.visit_id, NULL)) AS t10,
    COUNT(IF(MONTH(o.reg_datetime) = 11 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r11,
    COUNT(IF(MONTH(o.reg_datetime) = 11, o.visit_id, NULL)) AS t11,
    COUNT(IF(MONTH(o.reg_datetime) = 12 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r12,
    COUNT(IF(MONTH(o.reg_datetime) = 12, o.visit_id, NULL)) AS t12,


	 -- เปรียบเทียบค่า t กับ r และให้ผลลัพธ์เป็น 1 ถ้าค่าต่างกัน
    IF(SUM(CASE WHEN MONTH(o.reg_datetime) = 1 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(o.reg_datetime) = 1 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_1,
       
    IF(SUM(CASE WHEN MONTH(o.reg_datetime) = 2 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(o.reg_datetime) = 2 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_2,

    IF(SUM(CASE WHEN MONTH(o.reg_datetime) = 3 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(o.reg_datetime) = 3 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_3,

    IF(SUM(CASE WHEN MONTH(o.reg_datetime) = 4 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(o.reg_datetime) = 4 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_4,

    IF(SUM(CASE WHEN MONTH(o.reg_datetime) = 5 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(o.reg_datetime) = 5 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_5,

    IF(SUM(CASE WHEN MONTH(o.reg_datetime) = 6 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(o.reg_datetime) = 6 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_6,

    IF(SUM(CASE WHEN MONTH(o.reg_datetime) = 7 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(o.reg_datetime) = 7 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_7,

    IF(SUM(CASE WHEN MONTH(o.reg_datetime) = 8 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(o.reg_datetime) = 8 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_8,

    IF(SUM(CASE WHEN MONTH(o.reg_datetime) = 9 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(o.reg_datetime) = 9 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_9,

    IF(SUM(CASE WHEN MONTH(o.reg_datetime) = 10 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(o.reg_datetime) = 10 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_10,

    IF(SUM(CASE WHEN MONTH(o.reg_datetime) = 11 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(o.reg_datetime) = 11 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_11,

    IF(SUM(CASE WHEN MONTH(o.reg_datetime) = 12 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(o.reg_datetime) = 12 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_12,

    -- คำนวณผลรวมทั้งหมด
    COUNT(o.visit_id) AS total,
							-- แยกค่ารวมของ c.hosp_claim ตามเดือน
SUM(CASE WHEN MONTH(r.datereg) = 10 AND YEAR(r.datereg) = $fiscalYear THEN c.hosp_claim ELSE 0 END) AS hosp_claim_10,
SUM(CASE WHEN MONTH(r.datereg) = 11 AND YEAR(r.datereg) = $fiscalYear THEN c.hosp_claim ELSE 0 END) AS hosp_claim_11,
SUM(CASE WHEN MONTH(r.datereg) = 12 AND YEAR(r.datereg) = $fiscalYear THEN c.hosp_claim ELSE 0 END) AS hosp_claim_12,
SUM(CASE WHEN MONTH(r.datereg) = 1 AND YEAR(r.datereg) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_1,
SUM(CASE WHEN MONTH(r.datereg) = 2 AND YEAR(r.datereg) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_2,
SUM(CASE WHEN MONTH(r.datereg) = 3 AND YEAR(r.datereg) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_3,
SUM(CASE WHEN MONTH(r.datereg) = 4 AND YEAR(r.datereg) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_4,
SUM(CASE WHEN MONTH(r.datereg) = 5 AND YEAR(r.datereg) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_5,
SUM(CASE WHEN MONTH(r.datereg) = 6 AND YEAR(r.datereg) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_6,
SUM(CASE WHEN MONTH(r.datereg) = 7 AND YEAR(r.datereg) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_7,
SUM(CASE WHEN MONTH(r.datereg) = 8 AND YEAR(r.datereg) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_8,
SUM(CASE WHEN MONTH(r.datereg) = 9 AND YEAR(r.datereg) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_9,

-- แยกค่ารวมของ c.ret_statement ตามเดือน
SUM(CASE WHEN MONTH(r.datereg) = 10 AND YEAR(r.datereg) = $fiscalYear THEN IFNULL(c.ret_statement, 0) ELSE 0 END) AS ret_statement_10,
SUM(CASE WHEN MONTH(r.datereg) = 11 AND YEAR(r.datereg) = $fiscalYear THEN c.ret_statement ELSE 0 END) AS ret_statement_11,
SUM(CASE WHEN MONTH(r.datereg) = 12 AND YEAR(r.datereg) = $fiscalYear THEN c.ret_statement ELSE 0 END) AS ret_statement_12,
SUM(CASE WHEN MONTH(r.datereg) = 1 AND YEAR(r.datereg) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_1,
SUM(CASE WHEN MONTH(r.datereg) = 2 AND YEAR(r.datereg) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_2,
SUM(CASE WHEN MONTH(r.datereg) = 3 AND YEAR(r.datereg) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_3,
SUM(CASE WHEN MONTH(r.datereg) = 4 AND YEAR(r.datereg) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_4,
SUM(CASE WHEN MONTH(r.datereg) = 5 AND YEAR(r.datereg) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_5,
SUM(CASE WHEN MONTH(r.datereg) = 6 AND YEAR(r.datereg) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_6,
SUM(CASE WHEN MONTH(r.datereg) = 7 AND YEAR(r.datereg) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_7,
SUM(CASE WHEN MONTH(r.datereg) = 8 AND YEAR(r.datereg) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_8,
SUM(CASE WHEN MONTH(r.datereg) = 9 AND YEAR(r.datereg) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_9,

							
				-- เพิ่มค่ารวมของ c.hosp_claim และ c.ret_statement
                SUM(c.hosp_claim) AS total_hosp_claim,
                SUM(c.ret_statement) AS opd_ret_statement
				
				
            FROM opd_visits o
			LEFT JOIN log_fdh_opd_ck r ON o.visit_id = r.visit_id
			LEFT JOIN mbase_data1.cost_visits AS c ON c.visit_id = o.visit_id
			LEFT JOIN cid_hn ch ON ch.HN = o.HN 
			LEFT JOIN population d ON ch.CID = d.CID

			WHERE o.REG_DATETIME BETWEEN '2024-10-01 00:01' AND '2025-09-30 23:59'
			  AND o.IS_CANCEL = 0
			  AND o.inscl IN ('03','04','33','00','23')
			  AND r.users IS NOT NULL  -- เพิ่มเงื่อนไขนี้เพื่อไม่รวมค่าที่เป็น NULL ของ r.users
			GROUP BY r.users";


    $data = Yii::$app->db70->createCommand($sql)->queryAll();


    $graph = [];
    foreach ($data as $d) {
        $graph[] = [
            'type' => 'line',
            'name' => $d['users'],
            'data' => [
                intval($d['r10']),
                intval($d['r11']),
                intval($d['r12']),
                intval($d['r1']),
                intval($d['r2']),
                intval($d['r3']),
                intval($d['r4']),
                intval($d['r5']),
                intval($d['r6']),
                intval($d['r7']),
                intval($d['r8']),
                intval($d['r9']),
            ]
        ];
    }

    $dataProvider = new ArrayDataProvider([
        'allModels' => $data,
		 'pagination' => false, // ✅ ปิดการแบ่งหน้า
        'sort' => [
            'attributes' => ['users', 'r1', 'r2', 'r3', 'r4', 'r5', 'r6', 'r7', 'r8', 'r9', 'r10', 'r11', 'r12', 'total']
        ]
    ]);
#######################################################################	
$sql = "SELECT 
            SUM(c.hosp_claim) AS total_hosp_claim,
            SUM(c.ret_statement) AS total_ret_statement
        FROM log_fdh_opd_ck r
        LEFT JOIN mbase_data1.cost_visits c ON c.visit_id = r.visit_id";

// ดึงข้อมูลจากฐานข้อมูล db2-> samba 200.7
$data = Yii::$app->db2->createCommand($sql)->queryAll();

// ดึงค่าผลลัพธ์จากฐานข้อมูล
$total_hosp_claim = $data[0]['total_hosp_claim'] ?? 0;
$total_ret_statement = $data[0]['total_ret_statement'] ?? 0;

// คำนวณค่าผลต่าง
$total_difference = $total_hosp_claim - $total_ret_statement;


// ส่งค่าผ่าน render ไปยัง View
return $this->render('reportall', [
    'y' => $fiscalYear + 543, // ปีงบประมาณแบบพุทธศักราช
    'graph' => $graph,
    'dataProvider' => $dataProvider,
    'total_hosp_claim' => $total_hosp_claim,  // ส่งค่าไป View
    'total_ret_statement' => $total_ret_statement,      // ส่งค่าไป View
	'total_difference' => $total_difference
	
	
]);
  }
  ##############################################################################################
  public function actionReportipd() {
    $currentYear = date("Y", time());
    $currentMonth = date("m", time());
    
    // คำนวณปีงบประมาณ
    if ($currentMonth >= 10) {
        $fiscalYear = $currentYear;
    } else {
        $fiscalYear = $currentYear - 1;
    }
$sql = "SELECT r.users,
             COUNT(IF(MONTH(i.dsc_dt) = 1, r.visit_id, NULL)) AS r1,
COUNT(IF(MONTH(i.dsc_dt) = 1 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r1,
    COUNT(IF(MONTH(i.dsc_dt) = 1, i.visit_id, NULL)) AS t1,
    COUNT(IF(MONTH(i.dsc_dt) = 2 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r2,
    COUNT(IF(MONTH(i.dsc_dt) = 2, i.visit_id, NULL)) AS t2,
    COUNT(IF(MONTH(i.dsc_dt) = 3 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r3,
    COUNT(IF(MONTH(i.dsc_dt) = 3, i.visit_id, NULL)) AS t3,
    COUNT(IF(MONTH(i.dsc_dt) = 4 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r4,
    COUNT(IF(MONTH(i.dsc_dt) = 4, i.visit_id, NULL)) AS t4,
    COUNT(IF(MONTH(i.dsc_dt) = 5 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r5,
    COUNT(IF(MONTH(i.dsc_dt) = 5, i.visit_id, NULL)) AS t5,
    COUNT(IF(MONTH(i.dsc_dt) = 6 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r6,
    COUNT(IF(MONTH(i.dsc_dt) = 6, i.visit_id, NULL)) AS t6,
    COUNT(IF(MONTH(i.dsc_dt) = 7 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r7,
    COUNT(IF(MONTH(i.dsc_dt) = 7, i.visit_id, NULL)) AS t7,
    COUNT(IF(MONTH(i.dsc_dt) = 8 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r8,
    COUNT(IF(MONTH(i.dsc_dt) = 8, i.visit_id, NULL)) AS t8,
    COUNT(IF(MONTH(i.dsc_dt) = 9 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r9,
    COUNT(IF(MONTH(i.dsc_dt) = 9, i.visit_id, NULL)) AS t9,
    COUNT(IF(MONTH(i.dsc_dt) = 10 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r10,
    COUNT(IF(MONTH(i.dsc_dt) = 10, i.visit_id, NULL)) AS t10,
    COUNT(IF(MONTH(i.dsc_dt) = 11 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r11,
    COUNT(IF(MONTH(i.dsc_dt) = 11, i.visit_id, NULL)) AS t11,
    COUNT(IF(MONTH(i.dsc_dt) = 12 AND (r.messages <> 'rejected' AND r.messages <> ''), r.visit_id, NULL)) AS r12,
    COUNT(IF(MONTH(i.dsc_dt) = 12, i.visit_id, NULL)) AS t12,
	
	
	 -- เปรียบเทียบค่า t กับ r และให้ผลลัพธ์เป็น 1 ถ้าค่าต่างกัน
    IF(SUM(CASE WHEN MONTH(i.dsc_dt) = 1 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(i.dsc_dt) = 1 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_1,
       
    IF(SUM(CASE WHEN MONTH(i.dsc_dt) = 2 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(i.dsc_dt) = 2 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_2,

    IF(SUM(CASE WHEN MONTH(i.dsc_dt) = 3 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(i.dsc_dt) = 3 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_3,

    IF(SUM(CASE WHEN MONTH(i.dsc_dt) = 4 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(i.dsc_dt) = 4 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_4,

    IF(SUM(CASE WHEN MONTH(i.dsc_dt) = 5 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(i.dsc_dt) = 5 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_5,

    IF(SUM(CASE WHEN MONTH(i.dsc_dt) = 6 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(i.dsc_dt) = 6 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_6,

    IF(SUM(CASE WHEN MONTH(i.dsc_dt) = 7 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(i.dsc_dt) = 7 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_7,

    IF(SUM(CASE WHEN MONTH(i.dsc_dt) = 8 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(i.dsc_dt) = 8 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_8,

    IF(SUM(CASE WHEN MONTH(i.dsc_dt) = 9 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(i.dsc_dt) = 9 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_9,

    IF(SUM(CASE WHEN MONTH(i.dsc_dt) = 10 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(i.dsc_dt) = 10 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_10,

    IF(SUM(CASE WHEN MONTH(i.dsc_dt) = 11 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(i.dsc_dt) = 11 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_11,

    IF(SUM(CASE WHEN MONTH(i.dsc_dt) = 12 THEN 1 ELSE 0 END) <> 
       SUM(CASE WHEN MONTH(i.dsc_dt) = 12 AND r.messages NOT IN ('rejected', '') THEN 1 ELSE 0 END), 1, 0) AS color_12,
       
            -- คำนวณผลรวม
            COUNT(*) AS total,
            
            -- คำนวณค่ารวมของ hosp_claim และ ret_statement ตามเดือน
            SUM(CASE WHEN MONTH(i.dsc_dt) = 10 AND YEAR(i.dsc_dt) = $fiscalYear THEN IFNULL(c.hosp_claim, 0) ELSE 0 END) AS hosp_claim_10,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 11 AND YEAR(i.dsc_dt) = $fiscalYear THEN c.hosp_claim ELSE 0 END) AS hosp_claim_11,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 12 AND YEAR(i.dsc_dt) = $fiscalYear THEN c.hosp_claim ELSE 0 END) AS hosp_claim_12,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 1 AND YEAR(i.dsc_dt) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_1,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 2 AND YEAR(i.dsc_dt) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_2,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 3 AND YEAR(i.dsc_dt) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_3,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 4 AND YEAR(i.dsc_dt) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_4,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 5 AND YEAR(i.dsc_dt) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_5,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 6 AND YEAR(i.dsc_dt) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_6,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 7 AND YEAR(i.dsc_dt) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_7,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 8 AND YEAR(i.dsc_dt) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_8,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 9 AND YEAR(i.dsc_dt) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_9,

            SUM(CASE WHEN MONTH(i.dsc_dt) = 10 AND YEAR(i.dsc_dt) = $fiscalYear THEN IFNULL(c.ret_statement, 0) ELSE 0 END) AS ret_statement_10,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 11 AND YEAR(i.dsc_dt) = $fiscalYear THEN c.ret_statement ELSE 0 END) AS ret_statement_11,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 12 AND YEAR(i.dsc_dt) = $fiscalYear THEN c.ret_statement ELSE 0 END) AS ret_statement_12,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 1 AND YEAR(i.dsc_dt) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_1,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 2 AND YEAR(i.dsc_dt) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_2,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 3 AND YEAR(i.dsc_dt) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_3,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 4 AND YEAR(i.dsc_dt) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_4,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 5 AND YEAR(i.dsc_dt) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_5,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 6 AND YEAR(i.dsc_dt) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_6,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 7 AND YEAR(i.dsc_dt) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_7,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 8 AND YEAR(i.dsc_dt) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_8,
            SUM(CASE WHEN MONTH(i.dsc_dt) = 9 AND YEAR(i.dsc_dt) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_9,
            
            -- เพิ่มค่ารวมของ c.hosp_claim และ c.ret_statement
            SUM(c.hosp_claim) AS total_hosp_claim,
            SUM(c.ret_statement) AS total_ret_statement
            
        FROM ipd_reg i
        LEFT JOIN log_fdh_ipd_ck r ON i.visit_id = r.visit_id
        LEFT JOIN mbase_data1.cost_visits AS c ON c.visit_id = i.visit_id
        LEFT JOIN opd_visits o ON i.VISIT_ID = o.VISIT_ID AND i.IS_CANCEL = 0 
        LEFT JOIN cid_hn ch ON ch.HN = o.HN 
        LEFT JOIN population d ON ch.CID = d.CID
        WHERE i.dsc_dt BETWEEN '2024-10-01 00:01' AND '2025-09-30 23:59'
          AND i.IS_CANCEL = 0
          AND o.inscl IN ('03','04','33','00','23')
        
        GROUP BY r.users";



    $data = Yii::$app->db2->createCommand($sql)->queryAll();


    $graph = [];
    foreach ($data as $d) {
        $graph[] = [
            'type' => 'line',
            'name' => $d['users'],
            'data' => [
                intval($d['r10']),
                intval($d['r11']),
                intval($d['r12']),
                intval($d['r1']),
                intval($d['r2']),
                intval($d['r3']),
                intval($d['r4']),
                intval($d['r5']),
                intval($d['r6']),
                intval($d['r7']),
                intval($d['r8']),
                intval($d['r9']),
            ]
        ];
    }

    $dataProvider = new ArrayDataProvider([
        'allModels' => $data,
        'sort' => [
            'attributes' => ['users', 'r1', 'r2', 'r3', 'r4', 'r5', 'r6', 'r7', 'r8', 'r9', 'r10', 'r11', 'r12', 'total']
        ]
    ]);
#######################################################################	
$sql = "SELECT 
            SUM(c.hosp_claim) AS total_hosp_claim,
            SUM(c.ret_statement) AS total_ret_statement
        FROM log_fdh_ipd_ck r
        LEFT JOIN mbase_data1.cost_visits c ON c.visit_id = r.visit_id";

// ดึงข้อมูลจากฐานข้อมูล 200.7
$data = Yii::$app->db70->createCommand($sql)->queryAll();

// ดึงค่าผลลัพธ์จากฐานข้อมูล
$total_hosp_claim = $data[0]['total_hosp_claim'] ?? 0;
$total_ret_statement = $data[0]['total_ret_statement'] ?? 0;

// คำนวณค่าผลต่าง
$total_difference = $total_hosp_claim - $total_ret_statement;


// ส่งค่าผ่าน render ไปยัง View
return $this->render('reportipd', [
    'y' => $fiscalYear + 543, // ปีงบประมาณแบบพุทธศักราช
    'graph' => $graph,
    'dataProvider' => $dataProvider,
    'total_hosp_claim' => $total_hosp_claim,  // ส่งค่าไป View
    'total_ret_statement' => $total_ret_statement,      // ส่งค่าไป View
	'total_difference' => $total_difference
	
]);
  }
 public function actionNoUserDetail($month)
{
    $sql = "
        SELECT 
            i.adm_id AS AN,
            i.ward_no,
            o.hn AS HN,
            d.fname,
            d.lname,
            i.dsc_dt
        FROM ipd_reg i
        LEFT JOIN log_fdh_ipd_ck r ON i.visit_id = r.visit_id
        LEFT JOIN opd_visits o ON i.visit_id = o.visit_id
        LEFT JOIN cid_hn ch ON ch.hn = o.hn
        LEFT JOIN population d ON ch.cid = d.cid
        WHERE i.dsc_dt BETWEEN '2024-10-01 00:01' AND '2025-09-30 23:59'
          AND i.IS_CANCEL = 0
          AND (r.users IS NULL OR r.users = '')
          AND o.inscl IN ('03','04','33','00','23')
    ";

    // กรองเฉพาะเดือน ถ้าไม่ใช่ 'all'
    if ($month !== 'all') {
        $sql .= " AND MONTH(i.dsc_dt) = :month";
        $command = Yii::$app->db70->createCommand($sql)->bindValue(':month', (int)$month);
    } else {
        $command = Yii::$app->db70->createCommand($sql); // ไม่ bind เดือน
    }

    $data = $command->queryAll();

    return $this->render('no_user_detail', [
        'data' => $data,
        'month' => $month,
    ]);
}





}