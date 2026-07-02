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
                        'actions'=>['reportall','reportipd','update','view'],
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
        $data = Yii::$app->db->createCommand($sql)->queryAll();

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
                COUNT(IF(MONTH(r.d_update) = 10 AND YEAR(r.d_update) = $fiscalYear, r.id, NULL)) AS r10,
                COUNT(IF(MONTH(r.d_update) = 11 AND YEAR(r.d_update) = $fiscalYear, r.id, NULL)) AS r11,
                COUNT(IF(MONTH(r.d_update) = 12 AND YEAR(r.d_update) = $fiscalYear, r.id, NULL)) AS r12,
                COUNT(IF(MONTH(r.d_update) = 1 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) AS r1,
                COUNT(IF(MONTH(r.d_update) = 2 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) AS r2,
                COUNT(IF(MONTH(r.d_update) = 3 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) AS r3,
                COUNT(IF(MONTH(r.d_update) = 4 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) AS r4,
                COUNT(IF(MONTH(r.d_update) = 5 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) AS r5,
                COUNT(IF(MONTH(r.d_update) = 6 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) AS r6,
                COUNT(IF(MONTH(r.d_update) = 7 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) AS r7,
                COUNT(IF(MONTH(r.d_update) = 8 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) AS r8,
                COUNT(IF(MONTH(r.d_update) = 9 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) AS r9,
                -- คำนวณผลรวม
                COUNT(IF(MONTH(r.d_update) = 10 AND YEAR(r.d_update) = $fiscalYear, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 11 AND YEAR(r.d_update) = $fiscalYear, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 12 AND YEAR(r.d_update) = $fiscalYear, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 1 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 2 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 3 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 4 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 5 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 6 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 7 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 8 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 9 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) AS total,
							
							-- แยกค่ารวมของ c.hosp_claim ตามเดือน
				SUM(CASE WHEN MONTH(r.d_update) = 10 AND YEAR(r.d_update) = $fiscalYear THEN c.hosp_claim ELSE 0 END) AS hosp_claim_10,
				SUM(CASE WHEN MONTH(r.d_update) = 11 AND YEAR(r.d_update) = $fiscalYear THEN c.hosp_claim ELSE 0 END) AS hosp_claim_11,
				SUM(CASE WHEN MONTH(r.d_update) = 12 AND YEAR(r.d_update) = $fiscalYear THEN c.hosp_claim ELSE 0 END) AS hosp_claim_12,
				SUM(CASE WHEN MONTH(r.d_update) = 1 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_1,
				SUM(CASE WHEN MONTH(r.d_update) = 2 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_2,
				SUM(CASE WHEN MONTH(r.d_update) = 3 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_3,
				SUM(CASE WHEN MONTH(r.d_update) = 4 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_4,
				SUM(CASE WHEN MONTH(r.d_update) = 5 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_5,
				SUM(CASE WHEN MONTH(r.d_update) = 6 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_6,
				SUM(CASE WHEN MONTH(r.d_update) = 7 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_7,
				SUM(CASE WHEN MONTH(r.d_update) = 8 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_8,
				SUM(CASE WHEN MONTH(r.d_update) = 9 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_9,

				-- แยกค่ารวมของ c.ret_statement ตามเดือน
				SUM(CASE WHEN MONTH(r.d_update) = 10 AND YEAR(r.d_update) = $fiscalYear THEN IFNULL(c.ret_statement, 0) ELSE 0 END) AS ret_statement_10,
				#SUM(CASE WHEN MONTH(r.d_update) = 10 AND YEAR(r.d_update) = $fiscalYear THEN c.ret_statement ELSE 0 END) AS ret_statement_10,
				SUM(CASE WHEN MONTH(r.d_update) = 11 AND YEAR(r.d_update) = $fiscalYear THEN c.ret_statement ELSE 0 END) AS ret_statement_11,
				SUM(CASE WHEN MONTH(r.d_update) = 12 AND YEAR(r.d_update) = $fiscalYear THEN c.ret_statement ELSE 0 END) AS ret_statement_12,
				SUM(CASE WHEN MONTH(r.d_update) = 1 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_1,
				SUM(CASE WHEN MONTH(r.d_update) = 2 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_2,
				SUM(CASE WHEN MONTH(r.d_update) = 3 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_3,
				SUM(CASE WHEN MONTH(r.d_update) = 4 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_4,
				SUM(CASE WHEN MONTH(r.d_update) = 5 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_5,
				SUM(CASE WHEN MONTH(r.d_update) = 6 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_6,
				SUM(CASE WHEN MONTH(r.d_update) = 7 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_7,
				SUM(CASE WHEN MONTH(r.d_update) = 8 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_8,
				SUM(CASE WHEN MONTH(r.d_update) = 9 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_9,
							
				-- เพิ่มค่ารวมของ c.hosp_claim และ c.ret_statement
                SUM(c.hosp_claim) AS total_hosp_claim,
                SUM(c.ret_statement) AS opd_ret_statement
				
				
            FROM log_fdh_opd_ck  as r
			LEFT JOIN mbase_data1.cost_visits as c ON c.visit_id = r.visit_id
            
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
                COUNT(IF(MONTH(r.d_update) = 10 AND YEAR(r.d_update) = $fiscalYear, r.id, NULL)) AS r10,
                COUNT(IF(MONTH(r.d_update) = 11 AND YEAR(r.d_update) = $fiscalYear, r.id, NULL)) AS r11,
                COUNT(IF(MONTH(r.d_update) = 12 AND YEAR(r.d_update) = $fiscalYear, r.id, NULL)) AS r12,
                COUNT(IF(MONTH(r.d_update) = 1 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) AS r1,
                COUNT(IF(MONTH(r.d_update) = 2 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) AS r2,
                COUNT(IF(MONTH(r.d_update) = 3 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) AS r3,
                COUNT(IF(MONTH(r.d_update) = 4 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) AS r4,
                COUNT(IF(MONTH(r.d_update) = 5 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) AS r5,
                COUNT(IF(MONTH(r.d_update) = 6 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) AS r6,
                COUNT(IF(MONTH(r.d_update) = 7 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) AS r7,
                COUNT(IF(MONTH(r.d_update) = 8 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) AS r8,
                COUNT(IF(MONTH(r.d_update) = 9 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) AS r9,
                -- คำนวณผลรวม
                COUNT(IF(MONTH(r.d_update) = 10 AND YEAR(r.d_update) = $fiscalYear, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 11 AND YEAR(r.d_update) = $fiscalYear, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 12 AND YEAR(r.d_update) = $fiscalYear, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 1 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 2 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 3 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 4 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 5 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 6 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 7 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 8 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) +
                COUNT(IF(MONTH(r.d_update) = 9 AND YEAR(r.d_update) = $fiscalYear + 1, r.id, NULL)) AS total,
							
							-- แยกค่ารวมของ c.hosp_claim ตามเดือน
				SUM(CASE WHEN MONTH(r.d_update) = 10 AND YEAR(r.d_update) = $fiscalYear THEN IFNULL(c.hosp_claim, 0) ELSE 0 END) AS hosp_claim_10,
				#SUM(CASE WHEN MONTH(r.d_update) = 10 AND YEAR(r.d_update) = $fiscalYear THEN c.hosp_claim ELSE 0 END) AS hosp_claim_10,
				SUM(CASE WHEN MONTH(r.d_update) = 11 AND YEAR(r.d_update) = $fiscalYear THEN c.hosp_claim ELSE 0 END) AS hosp_claim_11,
				SUM(CASE WHEN MONTH(r.d_update) = 12 AND YEAR(r.d_update) = $fiscalYear THEN c.hosp_claim ELSE 0 END) AS hosp_claim_12,
				SUM(CASE WHEN MONTH(r.d_update) = 1 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_1,
				SUM(CASE WHEN MONTH(r.d_update) = 2 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_2,
				SUM(CASE WHEN MONTH(r.d_update) = 3 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_3,
				SUM(CASE WHEN MONTH(r.d_update) = 4 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_4,
				SUM(CASE WHEN MONTH(r.d_update) = 5 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_5,
				SUM(CASE WHEN MONTH(r.d_update) = 6 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_6,
				SUM(CASE WHEN MONTH(r.d_update) = 7 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_7,
				SUM(CASE WHEN MONTH(r.d_update) = 8 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_8,
				SUM(CASE WHEN MONTH(r.d_update) = 9 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.hosp_claim ELSE 0 END) AS hosp_claim_9,

				-- แยกค่ารวมของ c.ret_statement ตามเดือน
				SUM(CASE WHEN MONTH(r.d_update) = 10 AND YEAR(r.d_update) = $fiscalYear THEN IFNULL(c.ret_statement, 0) ELSE 0 END) AS ret_statement_10,
				#SUM(CASE WHEN MONTH(r.d_update) = 10 AND YEAR(r.d_update) = $fiscalYear THEN c.ret_statement ELSE 0 END) AS ret_statement_10,
				SUM(CASE WHEN MONTH(r.d_update) = 11 AND YEAR(r.d_update) = $fiscalYear THEN c.ret_statement ELSE 0 END) AS ret_statement_11,
				SUM(CASE WHEN MONTH(r.d_update) = 12 AND YEAR(r.d_update) = $fiscalYear THEN c.ret_statement ELSE 0 END) AS ret_statement_12,
				SUM(CASE WHEN MONTH(r.d_update) = 1 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_1,
				SUM(CASE WHEN MONTH(r.d_update) = 2 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_2,
				SUM(CASE WHEN MONTH(r.d_update) = 3 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_3,
				SUM(CASE WHEN MONTH(r.d_update) = 4 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_4,
				SUM(CASE WHEN MONTH(r.d_update) = 5 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_5,
				SUM(CASE WHEN MONTH(r.d_update) = 6 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_6,
				SUM(CASE WHEN MONTH(r.d_update) = 7 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_7,
				SUM(CASE WHEN MONTH(r.d_update) = 8 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_8,
				SUM(CASE WHEN MONTH(r.d_update) = 9 AND YEAR(r.d_update) = $fiscalYear + 1 THEN c.ret_statement ELSE 0 END) AS ret_statement_9,
							
				-- เพิ่มค่ารวมของ c.hosp_claim และ c.ret_statement
                SUM(c.hosp_claim) AS total_hosp_claim,
                SUM(c.ret_statement) AS total_ret_statement
				
				
            FROM log_fdh_ipd_ck  as r
			LEFT JOIN mbase_data1.cost_visits as c ON c.visit_id = r.visit_id
            
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
$data = Yii::$app->db2->createCommand($sql)->queryAll();

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

}