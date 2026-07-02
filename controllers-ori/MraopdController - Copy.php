<?php

namespace app\controllers;

use Yii;
use app\models\Mraopd;
use app\models\MraopdSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use kartik\mpdf\Pdf;
use mPDF;

/* เพิ่มคำสั่ง 3 บรรทัดต่อจากนี้ลงไป */
use yii\filters\AccessControl;        // เรียกใช้ คลาส AccessControl
use app\models\User;             // เรียกใช้ Model คลาส User ที่ปรับปรังปรุงไว้
use app\components\AccessRule;   // เรียกใช้ คลาส Component AccessRule ที่เราสร้างใหม่

/**
 * MraopdController implements the CRUD actions for Mraopd model.
 */
class MraopdController extends Controller
{
    /**
     * {@inheritdoc}
     */
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
                'only'=> ['index','admin','create','update','view','delete'],
                'ruleConfig'=>[
                    'class'=>AccessRule::className()
                ],
                'rules'=>[
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions'=>['index','create'],
                        'allow'=> true,
                        'roles' => [
                           User::ROLE_USER,
                         ]
                    ],
                    [
                        'actions'=>['index','create','update','view'],
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
     * Lists all Mraopd models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MraopdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['mra_id' => SORT_DESC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionPercent() {
        $data = Yii::$app->request->post();
        $date1 =isset($data['date1'])  ? $data['date1'] : '';
        $date2 =isset($data['date2'])  ? $data['date2'] : '';
        $unit =isset($data['unit_id'])  ? $data['unit_id'] : '';
       $sql = "SELECT
       s.hospcode, s.hosp_name,s.unit_id, s.unit_name,
       SUM(s.a1) as s1,
       SUM(s.a2) as s2,
       SUM(s.a3) as s3,
       SUM(s.a4) as s4,
       SUM(s.a5) as s5,
       SUM(s.a6) as s6,
       SUM(s.a7) as s7,
       SUM(s.a8) as s8,
       SUM(s.a9) as s9,
       SUM(s.a10) as s10,
       SUM(s.t1) as f1,
       SUM(s.t2) as f2,
       SUM(s.t3) as f3,
       SUM(s.t4) as f4,
       SUM(s.t5) as f5,
       SUM(s.t6) as f6,
       SUM(s.t7) as f7,
       SUM(s.t8) as f8,
       SUM(s.t9) as f9,
       SUM(s.t10) as f10,
       ROUND(SUM(s.a1/s.t1) * 100,2) as p1,
       ROUND(SUM(s.a2/s.t2) * 100,2) as p2,
       ROUND(SUM(s.a3/s.t3) * 100,2) as p3,
       ROUND(SUM(s.a4/s.t4) * 100,2) as p4,
       ROUND(SUM(s.a5/s.t5) * 100,2) as p5,
       ROUND(SUM(s.a6/s.t6) * 100,2) as p6,
       ROUND(SUM(s.a7/s.t7) * 100,2) as p7,
       ROUND(SUM(s.a8/s.t8) * 100,2) as p8,
       ROUND(SUM(s.a9/s.t9) * 100,2) as p9,
       ROUND(SUM(s.a9/s.t10) * 100,2) as p10,
       SUM(a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8 +a9+a10 ) as sum,
       SUM(t1 + t2 + t3 + t4 + t5 + t6 + t7 + t8 +t9 +t10) as full,
       ROUND((SUM(a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8 +a9+ a10) / SUM(t1 + t2 + t3 + t4 + t5 + t6 + t7 + t8 +t9+a10 )) * 100,2)  as percent,
	   s.amounts
       FROM (
       SELECT
       k.hospcode,k.hosp_name, k.unit_id, k.unit_name,
       SUM(k.total1) as t1,
       SUM(k.amount1) a1,
       SUM(k.total2) t2,
       SUM(k.amount2) a2,
       SUM(k.total3) t3,
       SUM(k.amount3) a3,
       SUM(k.total4) t4,
       SUM(k.amount4) a4,
       SUM(k.total5) t5,
       SUM(k.amount5) a5,
       SUM(k.total6) t6,
       SUM(k.amount6) a6,
       SUM(k.total7) t7,
       SUM(k.amount7) a7,
       SUM(k.total8) t8,
       SUM(k.amount8) a8,
       SUM(k.total9) t9,
       SUM(k.amount9) a9,
       SUM(k.total10) t10,
       SUM(k.amount10) a10,
	     count(k.hn) as amounts
       FROM (
       SELECT 
           d.unit_name,
               d.unit_id,
               m.hospcode,
               h.hosp_name,
           m.hn, m.date_audit, 
           m.na01, m.mi01, no01, m.sc011, m.sc012, m.sc013, m.sc014, m.sc015, m.sc016, m.sc017, m.dec01,
    SUM((IF(m.sc011 = 'N','','1') OR IF(m.sc011 = '0','1','0')) + 
    (IF(m.sc012 = 'N','','1') OR IF(m.sc012 = '0','1','0')) +
    (IF(m.sc013 = 'N','','1') OR IF(m.sc013 = '0','1','0')) +
    (IF(m.sc014 = 'N','','1') OR IF(m.sc014 = '0','1','0')) +
    (IF(m.sc015 = 'N','','1') OR IF(m.sc015 = '0','1','0')) +
    (IF(m.sc016 = 'N','','1') OR IF(m.sc016 = '0','1','0')) +
    (IF(m.sc017 = 'N','','1') OR IF(m.sc017 = '0','1','0'))) as total1,
    SUM(((m.sc011 + m.sc012 + m.sc013 + m.sc014 + m.sc015 + m.sc016 + m.sc017) - m.dec01) + m.no01) as amount1,
    m.na02, m.mi02, no02, m.sc021, m.sc022, m.sc023, m.sc024, m.sc025, m.sc026, m.sc027, m.dec02,
    SUM((IF(m.sc021 = 'N','','1') OR IF(m.sc021 = '0','1','0')) + 
    (IF(m.sc022 = 'N','','1') OR IF(m.sc022 = '0','1','0')) +
    (IF(m.sc023 = 'N','','1') OR IF(m.sc023 = '0','1','0')) +
    (IF(m.sc024 = 'N','','1') OR IF(m.sc024 = '0','1','0')) +
    (IF(m.sc025 = 'N','','1') OR IF(m.sc025 = '0','1','0')) +
    (IF(m.sc026 = 'N','','1') OR IF(m.sc026 = '0','1','0')) +
    (IF(m.sc027 = 'N','','1') OR IF(m.sc027 = '0','1','0'))) as total2,
    SUM(((m.sc021 + m.sc022 + m.sc023 + m.sc024 + m.sc025 + m.sc026 + m.sc027) - m.dec02) + m.no02) as amount2,
    m.na03, m.mi03, no03, m.sc031, m.sc032, m.sc033, m.sc034, m.sc035, m.sc036, m.sc037, m.dec03,
    SUM((IF(m.sc031 = 'N','','1') OR IF(m.sc031 = '0','1','0')) + 
    (IF(m.sc032 = 'N','','1') OR IF(m.sc032 = '0','1','0')) +
    (IF(m.sc033 = 'N','','1') OR IF(m.sc033 = '0','1','0')) +
    (IF(m.sc034 = 'N','','1') OR IF(m.sc034 = '0','1','0')) +
    (IF(m.sc035 = 'N','','1') OR IF(m.sc035 = '0','1','0')) +
    (IF(m.sc036 = 'N','','1') OR IF(m.sc036 = '0','1','0')) +
    (IF(m.sc037 = 'N','','1') OR IF(m.sc037 = '0','1','0'))) as total3,
    SUM(((m.sc031 + m.sc032 + m.sc033 + m.sc034 + m.sc035 + m.sc036 + m.sc037) - m.dec03) + m.no03) as amount3,
    m.na04, m.mi04, no04, m.sc041, m.sc042, m.sc043, m.sc044, m.sc045, m.sc046, m.sc047, m.dec04,
    SUM((IF(m.sc041 = 'N','','1') OR IF(m.sc041 = '0','1','0')) + 
    (IF(m.sc042 = 'N','','1') OR IF(m.sc042 = '0','1','0')) +
    (IF(m.sc043 = 'N','','1') OR IF(m.sc043 = '0','1','0')) +
    (IF(m.sc044 = 'N','','1') OR IF(m.sc044 = '0','1','0')) +
    (IF(m.sc045 = 'N','','1') OR IF(m.sc045 = '0','1','0')) +
    (IF(m.sc046 = 'N','','1') OR IF(m.sc046 = '0','1','0')) +
    (IF(m.sc047 = 'N','','1') OR IF(m.sc047 = '0','1','0'))) as total4,
    SUM(((m.sc041 + m.sc042 + m.sc043 + m.sc044 + m.sc045 + m.sc046 + m.sc047) - m.dec04) + m.no04) as amount4,
    m.na05, m.mi05, no05, m.sc051, m.sc052, m.sc053, m.sc054, m.sc055, m.sc056, m.sc057,m.dec05,
    SUM(
	    (IF(m.sc051 = 'N','','') OR IF(m.sc051 = '0','1','0')OR IF(m.sc051 = '1','1','')) + 
		(IF(m.sc052 = 'N','','') OR IF(m.sc052 = '0','1','0')OR IF(m.sc052 = '1','1','')) +
		(IF(m.sc053 = 'N','','') OR IF(m.sc053 = '0','1','0')OR IF(m.sc053 = '1','1','')) +
		(IF(m.sc054 = 'N','','') OR IF(m.sc054 = '0','1','0')OR IF(m.sc054 = '1','1','')) +
		(IF(m.sc055 = 'N','','') OR IF(m.sc055 = '0','1','0')OR IF(m.sc055 = '1','1','')) +
		(IF(m.sc056 = 'N','','') OR IF(m.sc056 = '0','1','0')OR IF(m.sc056 = '1','1','')) +
		(IF(m.sc067 = 'N','','') OR IF(m.sc067 = '0','1','0')OR IF(m.sc067 = '1','1',''))) as total5,
    SUM(((m.sc051 + m.sc052 + m.sc053 + m.sc054 + m.sc055 + m.sc056 + m.sc057) - m.dec05) + m.no05) as amount5,
    m.na06, m.mi06, no06, m.sc061, m.sc062, m.sc063, m.sc064, m.sc065, m.sc066, m.sc067, m.dec06,
    SUM(
        (IF(m.sc061 = 'N','','') OR IF(m.sc061 = '0','1','0')OR IF(m.sc061 = '1','1','')) + 
		(IF(m.sc062 = 'N','','') OR IF(m.sc062 = '0','1','0')OR IF(m.sc062 = '1','1','')) +
		(IF(m.sc063 = 'N','','') OR IF(m.sc063 = '0','1','0')OR IF(m.sc063 = '1','1','')) +
		(IF(m.sc064 = 'N','','') OR IF(m.sc064 = '0','1','0')OR IF(m.sc064 = '1','1','')) +
		(IF(m.sc065 = 'N','','') OR IF(m.sc065 = '0','1','0')OR IF(m.sc065 = '1','1','')) +
		(IF(m.sc066 = 'N','','') OR IF(m.sc066 = '0','1','0')OR IF(m.sc066 = '1','1','')) +
		(IF(m.sc067 = 'N','','') OR IF(m.sc067 = '0','1','0')OR IF(m.sc067 = '1','1',''))) as total6,
    SUM(((m.sc061 + m.sc062 + m.sc063 + m.sc064 + m.sc065 + m.sc066 + m.sc067) - m.dec06) + m.no06) as amount6,
    m.na07, m.mi07, no07, m.sc071, m.sc072, m.sc073, m.sc074, m.sc075, m.sc076, m.sc077, m.dec07,
    SUM(
	    (IF(m.sc071 = 'N','','') OR IF(m.sc071 = '0','1','0')OR IF(m.sc071 = '1','1','')) + 
		(IF(m.sc072 = 'N','','') OR IF(m.sc072 = '0','1','0')OR IF(m.sc072 = '1','1','')) +
		(IF(m.sc073 = 'N','','') OR IF(m.sc073 = '0','1','0')OR IF(m.sc073 = '1','1','')) +
		(IF(m.sc074 = 'N','','') OR IF(m.sc074 = '0','1','0')OR IF(m.sc074 = '1','1','')) +
		(IF(m.sc075 = 'N','','') OR IF(m.sc075 = '0','1','0')OR IF(m.sc075 = '1','1','')) +
		(IF(m.sc076 = 'N','','') OR IF(m.sc076 = '0','1','0')OR IF(m.sc076 = '1','1','')) +
		(IF(m.sc077 = 'N','','') OR IF(m.sc077 = '0','1','0')OR IF(m.sc077 = '1','1',''))) as total7,
    SUM(((m.sc071 + m.sc072 + m.sc073 + m.sc074 + m.sc075 + m.sc076 + m.sc077) - m.dec07) + m.no07) as amount7,
    m.na08, m.mi08, no08, m.sc081, m.sc082, m.sc083, m.sc084, m.sc085, m.sc086, m.sc087, m.dec08,
     SUM(
		(IF(m.sc081 = 'N','','') OR IF(m.sc081 = '0','1','0')OR IF(m.sc081 = '1','1','')) + 
		(IF(m.sc082 = 'N','','') OR IF(m.sc082 = '0','1','0')OR IF(m.sc082 = '1','1','')) +
		(IF(m.sc083 = 'N','','') OR IF(m.sc083 = '0','1','0') OR IF(m.sc083 = '1','1','')) +
		(IF(m.sc084 = 'N','','') OR IF(m.sc084 = '0','1','0')OR IF(m.sc084 = '1','1','')) +
		(IF(m.sc085 = 'N','','') OR IF(m.sc085 = '0','1','0')OR IF(m.sc085 = '1','1','')) +
		(IF(m.sc086 = 'N','','') OR IF(m.sc086 = '0','1','0')OR IF(m.sc086 = '1','1','')) +
		(IF(m.sc087 = 'N','','') OR IF(m.sc087 = '0','1','0')OR IF(m.sc087 = '1','1',''))) as total8,
     SUM(((m.sc081 + m.sc082 + m.sc083 + m.sc084 + m.sc085 + m.sc086 + m.sc087) - m.dec08) + m.no08) as amount8,
    m.na09, m.mi09, no09, m.sc091, m.sc092, m.sc093, m.sc094, m.sc095, m.sc096, m.sc097, m.dec09,
    SUM(
		(IF(m.sc091 = 'N','','') OR IF(m.sc091 = '0','1','0')OR IF(m.sc091 = '1','1','')) + 
		(IF(m.sc092 = 'N','','') OR IF(m.sc092 = '0','1','0')OR IF(m.sc092 = '1','1','')) +
		(IF(m.sc093 = 'N','','') OR IF(m.sc093 = '0','1','0')OR IF(m.sc093 = '1','1','')) +
		(IF(m.sc094 = 'N','','') OR IF(m.sc094 = '0','1','0')OR IF(m.sc094 = '1','1','')) +
		(IF(m.sc095 = 'N','','') OR IF(m.sc095 = '0','1','0')OR IF(m.sc095 = '1','1','')) +
		(IF(m.sc096 = 'N','','') OR IF(m.sc096 = '0','1','0')OR IF(m.sc096 = '1','1','')) +
		(IF(m.sc097 = 'N','','') OR IF(m.sc097 = '0','1','0')OR IF(m.sc097 = '1','1',''))) as total9,
     SUM(((m.sc091 + m.sc092 + m.sc093 + m.sc094 + m.sc095 + m.sc096 + m.sc097) - m.dec09) + m.no09) as amount9,
     m.na10, m.mi10, no10, m.sc101, m.sc102, m.sc103, m.sc104, m.sc105, m.sc106, m.sc107, m.dec10,
    SUM(
		(IF(m.sc101 = 'N','','') OR IF(m.sc101 = '0','1','0')OR IF(m.sc101 = '1','1',''))+ 
		(IF(m.sc102 = 'N','','') OR IF(m.sc102 = '0','1','0')OR IF(m.sc102 = '1','1','')) +
		(IF(m.sc103 = 'N','','') OR IF(m.sc103 = '0','1','0')OR IF(m.sc103 = '1','1','')) +
		(IF(m.sc104 = 'N','','') OR IF(m.sc104 = '0','1','0')OR IF(m.sc104 = '1','1','')) +
		(IF(m.sc105 = 'N','','') OR IF(m.sc105 = '0','1','0')OR IF(m.sc105 = '1','1','')) +
		(IF(m.sc106 = 'N','','') OR IF(m.sc106 = '0','1','0')OR IF(m.sc106 = '1','1','')) +
		(IF(m.sc107 = 'N','','') OR IF(m.sc107 = '0','1','0')OR IF(m.sc107 = '1','1',''))) as total10,
    SUM(((m.sc101 + m.sc102 + m.sc103 + m.sc104 + m.sc105 + m.sc106 + m.sc107) - m.dec10) + m.no10) as amount10
   
               FROM mra_opd m
               INNER JOIN mra_departmetns_opd d ON m.unit_id = d.unit_id
               LEFT JOIN hospitals h ON h.hospcode = m.hospcode
                WHERE        
			   m.date_audit BETWEEN '$date1' AND '$date2'
               AND m.unit_id = '$unit'
               GROUP BY m.HN ) as k ) as s
       ";
       $rawData = \yii::$app->db_mra->createCommand($sql)->queryAll();
       try {
           $rawData = \Yii::$app->db_mra->createCommand($sql)->queryAll();
       } catch (\yii\db\Exception $e) {
           throw new \yii\web\ConflictHttpException('sql error');
       }
     
       $dataProvider = new \yii\data\ArrayDataProvider([
           'allModels' => $rawData,
           'pagination' => [
            'pageSize' => FALSE,
            ],
       ]);
       $rawsData = \yii::$app->db_mra->createCommand($sql)->queryAll();
       try {
           $rawsData = \Yii::$app->db_mra->createCommand($sql)->queryAll();
       } catch (\yii\db\Exception $e) {
           throw new \yii\web\ConflictHttpException('sql error');
       }
       $pdfProvider = new \yii\data\ArrayDataProvider([
        'allModels' => $rawsData,
        'pagination' => [
         'pageSize' => FALSE,
         ],
    ]);
        Yii::$app->session['date1'] =$date1;
        Yii::$app->session['date2'] =$date2;
        Yii::$app->session['unit_id'] =$unit;
       return $this->render('percents', [
                   //'model' => $this->findModel($id),
                   //'model' => $this->findModel($AN),
                  // 'searchModel' => $searchModel,
                   'dataProvider' => $dataProvider,
                    'date1' => $date1,
                    'date2' => $date2,
                   'sql'=>$sql,
               ]);   
           }
        public function actionPercentpdf() {
            $date1 = Yii::$app->session['date1'];
            $date2 = Yii::$app->session['date2'];
            $unit = Yii::$app->session['unit_id'];
           
           $sql = "SELECT
           s.hospcode, s.hosp_name,s.unit_id, s.unit_name,s.date_audit,
           SUM(s.a1) as s1,
           SUM(s.a2) as s2,
           SUM(s.a3) as s3,
           SUM(s.a4) as s4,
           SUM(s.a5) as s5,
           SUM(s.a6) as s6,
           SUM(s.a7) as s7,
           SUM(s.a8) as s8,
           SUM(s.a9) as s9,
           
           SUM(s.t1) as f1,
           SUM(s.t2) as f2,
           SUM(s.t3) as f3,
           SUM(s.t4) as f4,
           SUM(s.t5) as f5,
           SUM(s.t6) as f6,
           SUM(s.t7) as f7,
           SUM(s.t8) as f8,
           SUM(s.t9) as f9,
           
           ROUND(SUM(s.a1/s.t1) * 100,2) as p1,
           ROUND(SUM(s.a2/s.t2) * 100,2) as p2,
           ROUND(SUM(s.a3/s.t3) * 100,2) as p3,
           ROUND(SUM(s.a4/s.t4) * 100,2) as p4,
           ROUND(SUM(s.a5/s.t5) * 100,2) as p5,
           ROUND(SUM(s.a6/s.t6) * 100,2) as p6,
           ROUND(SUM(s.a7/s.t7) * 100,2) as p7,
           ROUND(SUM(s.a8/s.t8) * 100,2) as p8,
           ROUND(SUM(s.a9/s.t9) * 100,2) as p9,
           
           SUM(a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8 +a9+a10 ) as sum,
           SUM(t1 + t2 + t3 + t4 + t5 + t6 + t7 + t8 +t9+t10 ) as full,
           ROUND((SUM(a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8 +a9+a10) / SUM(t1 + t2 + t3 + t4 + t5 + t6 + t7 + t8 +t9 +t10)) * 100,2)  as percent,
           s.amounts
           FROM (
           SELECT
           k.hospcode,k.hosp_name, k.unit_id, k.unit_name, k.date_audit,
           SUM(k.total1) as t1,
           SUM(k.amount1) a1,
           SUM(k.total2) t2,
           SUM(k.amount2) a2,
           SUM(k.total3) t3,
           SUM(k.amount3) a3,
           SUM(k.total4) t4,
           SUM(k.amount4) a4,
           SUM(k.total5) t5,
           SUM(k.amount5) a5,
           SUM(k.total6) t6,
           SUM(k.amount6) a6,
           SUM(k.total7) t7,
           SUM(k.amount7) a7,
           SUM(k.total8) t8,
           SUM(k.amount8) a8,
           SUM(k.total9) t9,
           SUM(k.amount9) a9,
           SUM(k.total10) t10,
           SUM(k.amount10) a10,
             count(k.hn) as amounts
           FROM (
           SELECT 
               d.unit_name,
                   d.unit_id,
                   m.hospcode,
                   h.hosp_name,
               m.hn, m.date_audit, 
               m.na01, m.mi01, no01, m.sc011, m.sc012, m.sc013, m.sc014, m.sc015, m.sc016, m.sc017, m.dec01,
        SUM((IF(m.sc011 = 'N','','1') OR IF(m.sc011 = '0','1','0')) + 
        (IF(m.sc012 = 'N','','1') OR IF(m.sc012 = '0','1','0')) +
        (IF(m.sc013 = 'N','','1') OR IF(m.sc013 = '0','1','0')) +
        (IF(m.sc014 = 'N','','1') OR IF(m.sc014 = '0','1','0')) +
        (IF(m.sc015 = 'N','','1') OR IF(m.sc015 = '0','1','0')) +
        (IF(m.sc016 = 'N','','1') OR IF(m.sc016 = '0','1','0')) +
        (IF(m.sc017 = 'N','','1') OR IF(m.sc017 = '0','1','0'))) as total1,
        SUM(((m.sc011 + m.sc012 + m.sc013 + m.sc014 + m.sc015 + m.sc016 + m.sc017) - m.dec01) + m.no01) as amount1,
        m.na02, m.mi02, no02, m.sc021, m.sc022, m.sc023, m.sc024, m.sc025, m.sc026, m.sc027, m.dec02,
        SUM((IF(m.sc021 = 'N','','1') OR IF(m.sc021 = '0','1','0')) + 
        (IF(m.sc022 = 'N','','1') OR IF(m.sc022 = '0','1','0')) +
        (IF(m.sc023 = 'N','','1') OR IF(m.sc023 = '0','1','0')) +
        (IF(m.sc024 = 'N','','1') OR IF(m.sc024 = '0','1','0')) +
        (IF(m.sc025 = 'N','','1') OR IF(m.sc025 = '0','1','0')) +
        (IF(m.sc026 = 'N','','1') OR IF(m.sc026 = '0','1','0')) +
        (IF(m.sc027 = 'N','','1') OR IF(m.sc027 = '0','1','0'))) as total2,
        SUM(((m.sc021 + m.sc022 + m.sc023 + m.sc024 + m.sc025 + m.sc026 + m.sc027) - m.dec02) + m.no02) as amount2,
        m.na03, m.mi03, no03, m.sc031, m.sc032, m.sc033, m.sc034, m.sc035, m.sc036, m.sc037, m.dec03,
        SUM((IF(m.sc031 = 'N','','1') OR IF(m.sc031 = '0','1','0')) + 
        (IF(m.sc032 = 'N','','1') OR IF(m.sc032 = '0','1','0')) +
        (IF(m.sc033 = 'N','','1') OR IF(m.sc033 = '0','1','0')) +
        (IF(m.sc034 = 'N','','1') OR IF(m.sc034 = '0','1','0')) +
        (IF(m.sc035 = 'N','','1') OR IF(m.sc035 = '0','1','0')) +
        (IF(m.sc036 = 'N','','1') OR IF(m.sc036 = '0','1','0')) +
        (IF(m.sc037 = 'N','','1') OR IF(m.sc037 = '0','1','0'))) as total3,
        SUM(((m.sc031 + m.sc032 + m.sc033 + m.sc034 + m.sc035 + m.sc036 + m.sc037) - m.dec03) + m.no03) as amount3,
        m.na04, m.mi04, no04, m.sc041, m.sc042, m.sc043, m.sc044, m.sc045, m.sc046, m.sc047, m.dec04,
        SUM((IF(m.sc041 = 'N','','1') OR IF(m.sc041 = '0','1','0')) + 
        (IF(m.sc042 = 'N','','1') OR IF(m.sc042 = '0','1','0')) +
        (IF(m.sc043 = 'N','','1') OR IF(m.sc043 = '0','1','0')) +
        (IF(m.sc044 = 'N','','1') OR IF(m.sc044 = '0','1','0')) +
        (IF(m.sc045 = 'N','','1') OR IF(m.sc045 = '0','1','0')) +
        (IF(m.sc046 = 'N','','1') OR IF(m.sc046 = '0','1','0')) +
        (IF(m.sc047 = 'N','','1') OR IF(m.sc047 = '0','1','0'))) as total4,
        SUM(((m.sc041 + m.sc042 + m.sc043 + m.sc044 + m.sc045 + m.sc046 + m.sc047) - m.dec04) + m.no04) as amount4,
        m.na05, m.mi05, no05, m.sc051, m.sc052, m.sc053, m.sc054, m.sc055, m.sc056, m.sc057,m.dec05,
        SUM(
            (IF(m.sc051 = 'N','','') OR IF(m.sc051 = '0','1','0')OR IF(m.sc051 = '1','1','')) + 
            (IF(m.sc052 = 'N','','') OR IF(m.sc052 = '0','1','0')OR IF(m.sc052 = '1','1','')) +
            (IF(m.sc053 = 'N','','') OR IF(m.sc053 = '0','1','0')OR IF(m.sc053 = '1','1','')) +
            (IF(m.sc054 = 'N','','') OR IF(m.sc054 = '0','1','0')OR IF(m.sc054 = '1','1','')) +
            (IF(m.sc055 = 'N','','') OR IF(m.sc055 = '0','1','0')OR IF(m.sc055 = '1','1','')) +
            (IF(m.sc056 = 'N','','') OR IF(m.sc056 = '0','1','0')OR IF(m.sc056 = '1','1','')) +
            (IF(m.sc067 = 'N','','') OR IF(m.sc067 = '0','1','0')OR IF(m.sc067 = '1','1',''))) as total5,
        SUM(((m.sc051 + m.sc052 + m.sc053 + m.sc054 + m.sc055 + m.sc056 + m.sc057) - m.dec05) + m.no05) as amount5,
        m.na06, m.mi06, no06, m.sc061, m.sc062, m.sc063, m.sc064, m.sc065, m.sc066, m.sc067, m.dec06,
        SUM(
            (IF(m.sc061 = 'N','','') OR IF(m.sc061 = '0','1','0')OR IF(m.sc061 = '1','1','')) + 
            (IF(m.sc062 = 'N','','') OR IF(m.sc062 = '0','1','0')OR IF(m.sc062 = '1','1','')) +
            (IF(m.sc063 = 'N','','') OR IF(m.sc063 = '0','1','0')OR IF(m.sc063 = '1','1','')) +
            (IF(m.sc064 = 'N','','') OR IF(m.sc064 = '0','1','0')OR IF(m.sc064 = '1','1','')) +
            (IF(m.sc065 = 'N','','') OR IF(m.sc065 = '0','1','0')OR IF(m.sc065 = '1','1','')) +
            (IF(m.sc066 = 'N','','') OR IF(m.sc066 = '0','1','0')OR IF(m.sc066 = '1','1','')) +
            (IF(m.sc067 = 'N','','') OR IF(m.sc067 = '0','1','0')OR IF(m.sc067 = '1','1',''))) as total6,
        SUM(((m.sc061 + m.sc062 + m.sc063 + m.sc064 + m.sc065 + m.sc066 + m.sc067) - m.dec06) + m.no06) as amount6,
        m.na07, m.mi07, no07, m.sc071, m.sc072, m.sc073, m.sc074, m.sc075, m.sc076, m.sc077, m.dec07,
        SUM(
            (IF(m.sc071 = 'N','','') OR IF(m.sc071 = '0','1','0')OR IF(m.sc071 = '1','1','')) + 
            (IF(m.sc072 = 'N','','') OR IF(m.sc072 = '0','1','0')OR IF(m.sc072 = '1','1','')) +
            (IF(m.sc073 = 'N','','') OR IF(m.sc073 = '0','1','0')OR IF(m.sc073 = '1','1','')) +
            (IF(m.sc074 = 'N','','') OR IF(m.sc074 = '0','1','0')OR IF(m.sc074 = '1','1','')) +
            (IF(m.sc075 = 'N','','') OR IF(m.sc075 = '0','1','0')OR IF(m.sc075 = '1','1','')) +
            (IF(m.sc076 = 'N','','') OR IF(m.sc076 = '0','1','0')OR IF(m.sc076 = '1','1','')) +
            (IF(m.sc077 = 'N','','') OR IF(m.sc077 = '0','1','0')OR IF(m.sc077 = '1','1',''))) as total7,
        SUM(((m.sc071 + m.sc072 + m.sc073 + m.sc074 + m.sc075 + m.sc076 + m.sc077) - m.dec07) + m.no07) as amount7,
        m.na08, m.mi08, no08, m.sc081, m.sc082, m.sc083, m.sc084, m.sc085, m.sc086, m.sc087, m.dec08,
         SUM(
            (IF(m.sc081 = 'N','','') OR IF(m.sc081 = '0','1','0')OR IF(m.sc081 = '1','1','')) + 
            (IF(m.sc082 = 'N','','') OR IF(m.sc082 = '0','1','0')OR IF(m.sc082 = '1','1','')) +
            (IF(m.sc083 = 'N','','') OR IF(m.sc083 = '0','1','0') OR IF(m.sc083 = '1','1','')) +
            (IF(m.sc084 = 'N','','') OR IF(m.sc084 = '0','1','0')OR IF(m.sc084 = '1','1','')) +
            (IF(m.sc085 = 'N','','') OR IF(m.sc085 = '0','1','0')OR IF(m.sc085 = '1','1','')) +
            (IF(m.sc086 = 'N','','') OR IF(m.sc086 = '0','1','0')OR IF(m.sc086 = '1','1','')) +
            (IF(m.sc087 = 'N','','') OR IF(m.sc087 = '0','1','0')OR IF(m.sc087 = '1','1',''))) as total8,
         SUM(((m.sc081 + m.sc082 + m.sc083 + m.sc084 + m.sc085 + m.sc086 + m.sc087) - m.dec08) + m.no08) as amount8,
        m.na09, m.mi09, no09, m.sc091, m.sc092, m.sc093, m.sc094, m.sc095, m.sc096, m.sc097, m.dec09,
        SUM(
            (IF(m.sc091 = 'N','','') OR IF(m.sc091 = '0','1','0')OR IF(m.sc091 = '1','1','')) + 
            (IF(m.sc092 = 'N','','') OR IF(m.sc092 = '0','1','0')OR IF(m.sc092 = '1','1','')) +
            (IF(m.sc093 = 'N','','') OR IF(m.sc093 = '0','1','0')OR IF(m.sc093 = '1','1','')) +
            (IF(m.sc094 = 'N','','') OR IF(m.sc094 = '0','1','0')OR IF(m.sc094 = '1','1','')) +
            (IF(m.sc095 = 'N','','') OR IF(m.sc095 = '0','1','0')OR IF(m.sc095 = '1','1','')) +
            (IF(m.sc096 = 'N','','') OR IF(m.sc096 = '0','1','0')OR IF(m.sc096 = '1','1','')) +
            (IF(m.sc097 = 'N','','') OR IF(m.sc097 = '0','1','0')OR IF(m.sc097 = '1','1',''))) as total9,
         SUM(((m.sc091 + m.sc092 + m.sc093 + m.sc094 + m.sc095 + m.sc096 + m.sc097) - m.dec09) + m.no09) as amount9,
         m.na10, m.mi10, no10, m.sc101, m.sc102, m.sc103, m.sc104, m.sc105, m.sc106, m.sc107, m.dec10,
    SUM(
		(IF(m.sc101 = 'N','','') OR IF(m.sc101 = '0','1','0')OR IF(m.sc101 = '1','1',''))+ 
		(IF(m.sc102 = 'N','','') OR IF(m.sc102 = '0','1','0')OR IF(m.sc102 = '1','1','')) +
		(IF(m.sc103 = 'N','','') OR IF(m.sc103 = '0','1','0')OR IF(m.sc103 = '1','1','')) +
		(IF(m.sc104 = 'N','','') OR IF(m.sc104 = '0','1','0')OR IF(m.sc104 = '1','1','')) +
		(IF(m.sc105 = 'N','','') OR IF(m.sc105 = '0','1','0')OR IF(m.sc105 = '1','1','')) +
		(IF(m.sc106 = 'N','','') OR IF(m.sc106 = '0','1','0')OR IF(m.sc106 = '1','1','')) +
		(IF(m.sc107 = 'N','','') OR IF(m.sc107 = '0','1','0')OR IF(m.sc107 = '1','1',''))) as total10,
    SUM(((m.sc101 + m.sc102 + m.sc103 + m.sc104 + m.sc105 + m.sc106 + m.sc107) - m.dec10) + m.no10) as amount10
       
                   FROM mra_opd m
                   INNER JOIN mra_departmetns_opd d ON m.unit_id = d.unit_id
                   LEFT JOIN hospitals h ON h.hospcode = m.hospcode
                  WHERE 
                    m.date_audit BETWEEN '$date1' AND '$date2'
                   AND m.unit_id = '$unit'
                   GROUP BY m.HN ) as k ) as s
           ";
           $rawData = \yii::$app->db_mra->createCommand($sql)->queryAll();
           try {
               $rawData = \Yii::$app->db_mra->createCommand($sql)->queryAll();
           } catch (\yii\db\Exception $e) {
               throw new \yii\web\ConflictHttpException('sql error');
           }
           
           $dataProvider = new \yii\data\ArrayDataProvider([
               'allModels' => $rawData,
               'pagination' => [
                'pageSize' => FALSE,
                ],
           ]);
						   
			Yii::$app->session['date1'] = $date1;
			Yii::$app->session['date2'] = $date2;
			
			$content = $this->renderPartial('pdf_view', ['model', 'dataProvider' => $dataProvider]);
            $destination = Pdf::DEST_BROWSER;
            //$destination = Pdf::DEST_DOWNLOAD;
           //$filename = $data->_reportView. ".pdf";
			$pdf = new Pdf([
			
			     //'default_font_size' => 13,
                // set to use core fonts only
                'mode' => Pdf::MODE_UTF8,
                // A4 paper format
                //'format' => Pdf::FORMAT_A4,
				'format' => 'A4-L',
                // portrait orientation
                'orientation' => Pdf::ORIENT_PORTRAIT,
                // stream to browser inline
                'destination' => $destination,
               // 'filename' => $filename,
                // your html content input
                'content' => $content,
				/*
				 'content' => $this->renderPartial('pdf', [
				'searchModel' => $searchModel,
				'atkProvider' => $atkProvider
                ]),
				*/
                // format content from your own css file if needed or use the
                // enhanced bootstrap css built by Krajee for mPDF formatting 
                //'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
                'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.css', 
                // any css to be embedded if required
                //'cssInline' => '.bd{border:1.5px solid; text-align: center;} .ar{text-align:right} .imgbd{border:1px solid}',
				//'cssInline' => '.kv-heading-1{font-size:28px}',
				'cssInline'=> '.kv-heading-1{font-size:20px}',
				'marginLeft' => 5, 'marginTop' => 5, 'marginRight' => 5, 'marginBottom' => 5,
                'marginFooter' => 5,
				'defaultFont' => 'Garuda',
				  // 'default_font_size' => 16, 
                 //call mPDF methods on the fly
                'methods' => [
                    'SetTitle' => ['MraOPD'],
                    //'SetHeader' => ['SAMPLE'],
                    'SetFooter' => ['{PAGENO}'],
                ]
            ]);
    
            // return the pdf output as per the destination setting
            return $pdf->render();
			
        }
           
    public function actionMrasum($id , $hn) {
        $sql = "SELECT 
        d.unit_name,
    m.hn, m.date_audit, 
    m.na01, m.mi01, no01, m.sc011, m.sc012, m.sc013, m.sc014, m.sc015, m.sc016, m.sc017, m.dec01,
    SUM((IF(m.sc011 = 'N','','1') OR IF(m.sc011 = '0','1','0')) + 
    (IF(m.sc012 = 'N','','1') OR IF(m.sc012 = '0','1','0')) +
    (IF(m.sc013 = 'N','','1') OR IF(m.sc013 = '0','1','0')) +
    (IF(m.sc014 = 'N','','1') OR IF(m.sc014 = '0','1','0')) +
    (IF(m.sc015 = 'N','','1') OR IF(m.sc015 = '0','1','0')) +
    (IF(m.sc016 = 'N','','1') OR IF(m.sc016 = '0','1','0')) +
    (IF(m.sc017 = 'N','','1') OR IF(m.sc017 = '0','1','0'))) as total1,
    SUM(((m.sc011 + m.sc012 + m.sc013 + m.sc014 + m.sc015 + m.sc016 + m.sc017) - m.dec01) + m.no01) as amount1,
    m.na02, m.mi02, no02, m.sc021, m.sc022, m.sc023, m.sc024, m.sc025, m.sc026, m.sc027, m.dec02,
    SUM((IF(m.sc021 = 'N','','1') OR IF(m.sc021 = '0','1','0')) + 
    (IF(m.sc022 = 'N','','1') OR IF(m.sc022 = '0','1','0')) +
    (IF(m.sc023 = 'N','','1') OR IF(m.sc023 = '0','1','0')) +
    (IF(m.sc024 = 'N','','1') OR IF(m.sc024 = '0','1','0')) +
    (IF(m.sc025 = 'N','','1') OR IF(m.sc025 = '0','1','0')) +
    (IF(m.sc026 = 'N','','1') OR IF(m.sc026 = '0','1','0')) +
    (IF(m.sc027 = 'N','','1') OR IF(m.sc027 = '0','1','0'))) as total2,
    SUM(((m.sc021 + m.sc022 + m.sc023 + m.sc024 + m.sc025 + m.sc026 + m.sc027) - m.dec02) + m.no02) as amount2,
    m.na03, m.mi03, no03, m.sc031, m.sc032, m.sc033, m.sc034, m.sc035, m.sc036, m.sc037, m.dec03,
    SUM((IF(m.sc031 = 'N','','1') OR IF(m.sc031 = '0','1','0')) + 
    (IF(m.sc032 = 'N','','1') OR IF(m.sc032 = '0','1','0')) +
    (IF(m.sc033 = 'N','','1') OR IF(m.sc033 = '0','1','0')) +
    (IF(m.sc034 = 'N','','1') OR IF(m.sc034 = '0','1','0')) +
    (IF(m.sc035 = 'N','','1') OR IF(m.sc035 = '0','1','0')) +
    (IF(m.sc036 = 'N','','1') OR IF(m.sc036 = '0','1','0')) +
    (IF(m.sc037 = 'N','','1') OR IF(m.sc037 = '0','1','0'))) as total3,
    SUM(((m.sc031 + m.sc032 + m.sc033 + m.sc034 + m.sc035 + m.sc036 + m.sc037) - m.dec03) + m.no03) as amount3,
    m.na04, m.mi04, no04, m.sc041, m.sc042, m.sc043, m.sc044, m.sc045, m.sc046, m.sc047, m.dec04,
    SUM((IF(m.sc041 = 'N','','1') OR IF(m.sc041 = '0','1','0')) + 
    (IF(m.sc042 = 'N','','1') OR IF(m.sc042 = '0','1','0')) +
    (IF(m.sc043 = 'N','','1') OR IF(m.sc043 = '0','1','0')) +
    (IF(m.sc044 = 'N','','1') OR IF(m.sc044 = '0','1','0')) +
    (IF(m.sc045 = 'N','','1') OR IF(m.sc045 = '0','1','0')) +
    (IF(m.sc046 = 'N','','1') OR IF(m.sc046 = '0','1','0')) +
    (IF(m.sc047 = 'N','','1') OR IF(m.sc047 = '0','1','0'))) as total4,
    SUM(((m.sc041 + m.sc042 + m.sc043 + m.sc044 + m.sc045 + m.sc046 + m.sc047) - m.dec04) + m.no04) as amount4,
    m.na05, m.mi05, no05, m.sc051, m.sc052, m.sc053, m.sc054, m.sc055, m.sc056, m.sc057,m.dec05,
    SUM(
	    (IF(m.sc051 = 'N','','') OR IF(m.sc051 = '0','1','0')OR IF(m.sc051 = '1','1','')) + 
		(IF(m.sc052 = 'N','','') OR IF(m.sc052 = '0','1','0')OR IF(m.sc052 = '1','1','')) +
		(IF(m.sc053 = 'N','','') OR IF(m.sc053 = '0','1','0')OR IF(m.sc053 = '1','1','')) +
		(IF(m.sc054 = 'N','','') OR IF(m.sc054 = '0','1','0')OR IF(m.sc054 = '1','1','')) +
		(IF(m.sc055 = 'N','','') OR IF(m.sc055 = '0','1','0')OR IF(m.sc055 = '1','1','')) +
		(IF(m.sc056 = 'N','','') OR IF(m.sc056 = '0','1','0')OR IF(m.sc056 = '1','1','')) +
		(IF(m.sc067 = 'N','','') OR IF(m.sc067 = '0','1','0')OR IF(m.sc067 = '1','1',''))) as total5,
    SUM(((m.sc051 + m.sc052 + m.sc053 + m.sc054 + m.sc055 + m.sc056 + m.sc057) - m.dec05) + m.no05) as amount5,
    m.na06, m.mi06, no06, m.sc061, m.sc062, m.sc063, m.sc064, m.sc065, m.sc066, m.sc067, m.dec06,
    SUM(
        (IF(m.sc061 = 'N','','') OR IF(m.sc061 = '0','1','0')OR IF(m.sc061 = '1','1','')) + 
		(IF(m.sc062 = 'N','','') OR IF(m.sc062 = '0','1','0')OR IF(m.sc062 = '1','1','')) +
		(IF(m.sc063 = 'N','','') OR IF(m.sc063 = '0','1','0')OR IF(m.sc063 = '1','1','')) +
		(IF(m.sc064 = 'N','','') OR IF(m.sc064 = '0','1','0')OR IF(m.sc064 = '1','1','')) +
		(IF(m.sc065 = 'N','','') OR IF(m.sc065 = '0','1','0')OR IF(m.sc065 = '1','1','')) +
		(IF(m.sc066 = 'N','','') OR IF(m.sc066 = '0','1','0')OR IF(m.sc066 = '1','1','')) +
		(IF(m.sc067 = 'N','','') OR IF(m.sc067 = '0','1','0')OR IF(m.sc067 = '1','1',''))) as total6,
    SUM(((m.sc061 + m.sc062 + m.sc063 + m.sc064 + m.sc065 + m.sc066 + m.sc067) - m.dec06) + m.no06) as amount6,
    m.na07, m.mi07, no07, m.sc071, m.sc072, m.sc073, m.sc074, m.sc075, m.sc076, m.sc077, m.dec07,
    SUM(
	    (IF(m.sc071 = 'N','','') OR IF(m.sc071 = '0','1','0')OR IF(m.sc071 = '1','1','')) + 
		(IF(m.sc072 = 'N','','') OR IF(m.sc072 = '0','1','0')OR IF(m.sc072 = '1','1','')) +
		(IF(m.sc073 = 'N','','') OR IF(m.sc073 = '0','1','0')OR IF(m.sc073 = '1','1','')) +
		(IF(m.sc074 = 'N','','') OR IF(m.sc074 = '0','1','0')OR IF(m.sc074 = '1','1','')) +
		(IF(m.sc075 = 'N','','') OR IF(m.sc075 = '0','1','0')OR IF(m.sc075 = '1','1','')) +
		(IF(m.sc076 = 'N','','') OR IF(m.sc076 = '0','1','0')OR IF(m.sc076 = '1','1','')) +
		(IF(m.sc077 = 'N','','') OR IF(m.sc077 = '0','1','0')OR IF(m.sc077 = '1','1',''))) as total7,
    SUM(((m.sc071 + m.sc072 + m.sc073 + m.sc074 + m.sc075 + m.sc076 + m.sc077) - m.dec07) + m.no07) as amount7,
    m.na08, m.mi08, no08, m.sc081, m.sc082, m.sc083, m.sc084, m.sc085, m.sc086, m.sc087, m.dec08,
     SUM(
		(IF(m.sc081 = 'N','','') OR IF(m.sc081 = '0','1','0')OR IF(m.sc081 = '1','1','')) + 
		(IF(m.sc082 = 'N','','') OR IF(m.sc082 = '0','1','0')OR IF(m.sc082 = '1','1','')) +
		(IF(m.sc083 = 'N','','') OR IF(m.sc083 = '0','1','0') OR IF(m.sc083 = '1','1','')) +
		(IF(m.sc084 = 'N','','') OR IF(m.sc084 = '0','1','0')OR IF(m.sc084 = '1','1','')) +
		(IF(m.sc085 = 'N','','') OR IF(m.sc085 = '0','1','0')OR IF(m.sc085 = '1','1','')) +
		(IF(m.sc086 = 'N','','') OR IF(m.sc086 = '0','1','0')OR IF(m.sc086 = '1','1','')) +
		(IF(m.sc087 = 'N','','') OR IF(m.sc087 = '0','1','0')OR IF(m.sc087 = '1','1',''))) as total8,
     SUM(((m.sc081 + m.sc082 + m.sc083 + m.sc084 + m.sc085 + m.sc086 + m.sc087) - m.dec08) + m.no08) as amount8,
    m.na09, m.mi09, no09, m.sc091, m.sc092, m.sc093, m.sc094, m.sc095, m.sc096, m.sc097, m.dec09,
    SUM(
		(IF(m.sc091 = 'N','','') OR IF(m.sc091 = '0','1','0')OR IF(m.sc091 = '1','1','')) + 
		(IF(m.sc092 = 'N','','') OR IF(m.sc092 = '0','1','0')OR IF(m.sc092 = '1','1','')) +
		(IF(m.sc093 = 'N','','') OR IF(m.sc093 = '0','1','0')OR IF(m.sc093 = '1','1','')) +
		(IF(m.sc094 = 'N','','') OR IF(m.sc094 = '0','1','0')OR IF(m.sc094 = '1','1','')) +
		(IF(m.sc095 = 'N','','') OR IF(m.sc095 = '0','1','0')OR IF(m.sc095 = '1','1','')) +
		(IF(m.sc096 = 'N','','') OR IF(m.sc096 = '0','1','0')OR IF(m.sc096 = '1','1','')) +
		(IF(m.sc097 = 'N','','') OR IF(m.sc097 = '0','1','0')OR IF(m.sc097 = '1','1',''))) as total9,
     SUM(((m.sc091 + m.sc092 + m.sc093 + m.sc094 + m.sc095 + m.sc096 + m.sc097) - m.dec09) + m.no09) as amount9,
    m.na10, m.mi10, no10, m.sc101, m.sc102, m.sc103, m.sc104, m.sc105, m.sc106, m.sc107, m.dec10,
    SUM(
		(IF(m.sc101 = 'N','','') OR IF(m.sc101 = '0','1','0')OR IF(m.sc101 = '1','1',''))+ 
		(IF(m.sc102 = 'N','','') OR IF(m.sc102 = '0','1','0')OR IF(m.sc102 = '1','1','')) +
		(IF(m.sc103 = 'N','','') OR IF(m.sc103 = '0','1','0')OR IF(m.sc103 = '1','1','')) +
		(IF(m.sc104 = 'N','','') OR IF(m.sc104 = '0','1','0')OR IF(m.sc104 = '1','1','')) +
		(IF(m.sc105 = 'N','','') OR IF(m.sc105 = '0','1','0')OR IF(m.sc105 = '1','1','')) +
		(IF(m.sc106 = 'N','','') OR IF(m.sc106 = '0','1','0')OR IF(m.sc106 = '1','1','')) +
		(IF(m.sc107 = 'N','','') OR IF(m.sc107 = '0','1','0')OR IF(m.sc107 = '1','1',''))) as total10,
    SUM(((m.sc101 + m.sc102 + m.sc103 + m.sc104 + m.sc105 + m.sc106 + m.sc107) - m.dec10) + m.no10) as amount10,
	m.visit, mv.overall_name, m.note
        FROM mra_opd m
        INNER JOIN mra_departmetns_opd d ON m.unit_id = d.unit_id
		INNER JOIN mra_overall mv on mv.overall_id = m.overall_id
        WHERE m.date_audit BETWEEN '2022-09-01' AND '2025-09-31'
         AND m.mra_id = $id
         AND m.HN = $hn
        
        ";
        $rawData = \yii::$app->db_mra->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db_mra->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
             'pageSize' => 400,
             ],
        ]);
        
        return $this->render('mrasum', [
                    'model' => $this->findModel($id),
                    //'model' => $this->findModel($AN),
                   // 'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sql'=>$sql,               
                 
        ]);   
      }
    /**
     * Displays a single Mraopd model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Mraopd model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mraopd();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			 Yii::$app->session->setFlash('success', 'เพิ่มข้อมูลข้อมูลสำเร็จ');
            return $this->redirect(['index', 'id' => $model->mra_id]);
        }
		$model->date_audit = date('Y-m-d');
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Mraopd model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			 Yii::$app->session->setFlash('info', 'แก้ไขข้อมูลข้อมูลสำเร็จ');
            return $this->redirect(['index', 'id' => $model->mra_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Mraopd model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

		//return $this->redirect(['index', 'id' => $model->mra_id]);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Mraopd model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mraopd the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mraopd::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
	
	public function actionPdf($id , $hn) {
        $sql = "SELECT
        s.hospcode, s.hosp_name,s.unit_id, s.unit_name,s.date_audit,
        SUM(s.a1) as s1,
        SUM(s.a2) as s2,
        SUM(s.a3) as s3,
        SUM(s.a4) as s4,
        SUM(s.a5) as s5,
        SUM(s.a6) as s6,
        SUM(s.a7) as s7,
        SUM(s.a8) as s8,
        SUM(s.a9) as s9,
        
        SUM(s.t1) as f1,
        SUM(s.t2) as f2,
        SUM(s.t3) as f3,
        SUM(s.t4) as f4,
        SUM(s.t5) as f5,
        SUM(s.t6) as f6,
        SUM(s.t7) as f7,
        SUM(s.t8) as f8,
        SUM(s.t9) as f9,
        
        ROUND(SUM(s.a1/s.t1) * 100,2) as p1,
        ROUND(SUM(s.a2/s.t2) * 100,2) as p2,
        ROUND(SUM(s.a3/s.t3) * 100,2) as p3,
        ROUND(SUM(s.a4/s.t4) * 100,2) as p4,
        ROUND(SUM(s.a5/s.t5) * 100,2) as p5,
        ROUND(SUM(s.a6/s.t6) * 100,2) as p6,
        ROUND(SUM(s.a7/s.t7) * 100,2) as p7,
        ROUND(SUM(s.a8/s.t8) * 100,2) as p8,
        ROUND(SUM(s.a9/s.t9) * 100,2) as p9,
        
        SUM(a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8 +a9+a10 ) as sum,
        SUM(t1 + t2 + t3 + t4 + t5 + t6 + t7 + t8 +t9+t10 ) as full,
        ROUND((SUM(a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8 +a9+a10) / SUM(t1 + t2 + t3 + t4 + t5 + t6 + t7 + t8 +t9 +t10)) * 100,2)  as percent,
        s.amounts
        FROM (
        SELECT
        k.hospcode,k.hosp_name, k.unit_id, k.unit_name, k.date_audit,
        SUM(k.total1) as t1,
        SUM(k.amount1) a1,
        SUM(k.total2) t2,
        SUM(k.amount2) a2,
        SUM(k.total3) t3,
        SUM(k.amount3) a3,
        SUM(k.total4) t4,
        SUM(k.amount4) a4,
        SUM(k.total5) t5,
        SUM(k.amount5) a5,
        SUM(k.total6) t6,
        SUM(k.amount6) a6,
        SUM(k.total7) t7,
        SUM(k.amount7) a7,
        SUM(k.total8) t8,
        SUM(k.amount8) a8,
        SUM(k.total9) t9,
        SUM(k.amount9) a9,
        SUM(k.total10) t10,
        SUM(k.amount10) a10,
          count(k.hn) as amounts
        FROM (
        SELECT 
            d.unit_name,
                d.unit_id,
                m.hospcode,
                h.hosp_name,
            m.hn, m.date_audit, 
            m.na01, m.mi01, no01, m.sc011, m.sc012, m.sc013, m.sc014, m.sc015, m.sc016, m.sc017, m.dec01,
     SUM((IF(m.sc011 = 'N','','1') OR IF(m.sc011 = '0','1','0')) + 
     (IF(m.sc012 = 'N','','1') OR IF(m.sc012 = '0','1','0')) +
     (IF(m.sc013 = 'N','','1') OR IF(m.sc013 = '0','1','0')) +
     (IF(m.sc014 = 'N','','1') OR IF(m.sc014 = '0','1','0')) +
     (IF(m.sc015 = 'N','','1') OR IF(m.sc015 = '0','1','0')) +
     (IF(m.sc016 = 'N','','1') OR IF(m.sc016 = '0','1','0')) +
     (IF(m.sc017 = 'N','','1') OR IF(m.sc017 = '0','1','0'))) as total1,
     SUM(((m.sc011 + m.sc012 + m.sc013 + m.sc014 + m.sc015 + m.sc016 + m.sc017) - m.dec01) + m.no01) as amount1,
     m.na02, m.mi02, no02, m.sc021, m.sc022, m.sc023, m.sc024, m.sc025, m.sc026, m.sc027, m.dec02,
     SUM((IF(m.sc021 = 'N','','1') OR IF(m.sc021 = '0','1','0')) + 
     (IF(m.sc022 = 'N','','1') OR IF(m.sc022 = '0','1','0')) +
     (IF(m.sc023 = 'N','','1') OR IF(m.sc023 = '0','1','0')) +
     (IF(m.sc024 = 'N','','1') OR IF(m.sc024 = '0','1','0')) +
     (IF(m.sc025 = 'N','','1') OR IF(m.sc025 = '0','1','0')) +
     (IF(m.sc026 = 'N','','1') OR IF(m.sc026 = '0','1','0')) +
     (IF(m.sc027 = 'N','','1') OR IF(m.sc027 = '0','1','0'))) as total2,
     SUM(((m.sc021 + m.sc022 + m.sc023 + m.sc024 + m.sc025 + m.sc026 + m.sc027) - m.dec02) + m.no02) as amount2,
     m.na03, m.mi03, no03, m.sc031, m.sc032, m.sc033, m.sc034, m.sc035, m.sc036, m.sc037, m.dec03,
     SUM((IF(m.sc031 = 'N','','1') OR IF(m.sc031 = '0','1','0')) + 
     (IF(m.sc032 = 'N','','1') OR IF(m.sc032 = '0','1','0')) +
     (IF(m.sc033 = 'N','','1') OR IF(m.sc033 = '0','1','0')) +
     (IF(m.sc034 = 'N','','1') OR IF(m.sc034 = '0','1','0')) +
     (IF(m.sc035 = 'N','','1') OR IF(m.sc035 = '0','1','0')) +
     (IF(m.sc036 = 'N','','1') OR IF(m.sc036 = '0','1','0')) +
     (IF(m.sc037 = 'N','','1') OR IF(m.sc037 = '0','1','0'))) as total3,
     SUM(((m.sc031 + m.sc032 + m.sc033 + m.sc034 + m.sc035 + m.sc036 + m.sc037) - m.dec03) + m.no03) as amount3,
     m.na04, m.mi04, no04, m.sc041, m.sc042, m.sc043, m.sc044, m.sc045, m.sc046, m.sc047, m.dec04,
     SUM((IF(m.sc041 = 'N','','1') OR IF(m.sc041 = '0','1','0')) + 
     (IF(m.sc042 = 'N','','1') OR IF(m.sc042 = '0','1','0')) +
     (IF(m.sc043 = 'N','','1') OR IF(m.sc043 = '0','1','0')) +
     (IF(m.sc044 = 'N','','1') OR IF(m.sc044 = '0','1','0')) +
     (IF(m.sc045 = 'N','','1') OR IF(m.sc045 = '0','1','0')) +
     (IF(m.sc046 = 'N','','1') OR IF(m.sc046 = '0','1','0')) +
     (IF(m.sc047 = 'N','','1') OR IF(m.sc047 = '0','1','0'))) as total4,
     SUM(((m.sc041 + m.sc042 + m.sc043 + m.sc044 + m.sc045 + m.sc046 + m.sc047) - m.dec04) + m.no04) as amount4,
     m.na05, m.mi05, no05, m.sc051, m.sc052, m.sc053, m.sc054, m.sc055, m.sc056, m.sc057,m.dec05,
     SUM(
         (IF(m.sc051 = 'N','','') OR IF(m.sc051 = '0','1','0')OR IF(m.sc051 = '1','1','')) + 
         (IF(m.sc052 = 'N','','') OR IF(m.sc052 = '0','1','0')OR IF(m.sc052 = '1','1','')) +
         (IF(m.sc053 = 'N','','') OR IF(m.sc053 = '0','1','0')OR IF(m.sc053 = '1','1','')) +
         (IF(m.sc054 = 'N','','') OR IF(m.sc054 = '0','1','0')OR IF(m.sc054 = '1','1','')) +
         (IF(m.sc055 = 'N','','') OR IF(m.sc055 = '0','1','0')OR IF(m.sc055 = '1','1','')) +
         (IF(m.sc056 = 'N','','') OR IF(m.sc056 = '0','1','0')OR IF(m.sc056 = '1','1','')) +
         (IF(m.sc067 = 'N','','') OR IF(m.sc067 = '0','1','0')OR IF(m.sc067 = '1','1',''))) as total5,
     SUM(((m.sc051 + m.sc052 + m.sc053 + m.sc054 + m.sc055 + m.sc056 + m.sc057) - m.dec05) + m.no05) as amount5,
     m.na06, m.mi06, no06, m.sc061, m.sc062, m.sc063, m.sc064, m.sc065, m.sc066, m.sc067, m.dec06,
     SUM(
         (IF(m.sc061 = 'N','','') OR IF(m.sc061 = '0','1','0')OR IF(m.sc061 = '1','1','')) + 
         (IF(m.sc062 = 'N','','') OR IF(m.sc062 = '0','1','0')OR IF(m.sc062 = '1','1','')) +
         (IF(m.sc063 = 'N','','') OR IF(m.sc063 = '0','1','0')OR IF(m.sc063 = '1','1','')) +
         (IF(m.sc064 = 'N','','') OR IF(m.sc064 = '0','1','0')OR IF(m.sc064 = '1','1','')) +
         (IF(m.sc065 = 'N','','') OR IF(m.sc065 = '0','1','0')OR IF(m.sc065 = '1','1','')) +
         (IF(m.sc066 = 'N','','') OR IF(m.sc066 = '0','1','0')OR IF(m.sc066 = '1','1','')) +
         (IF(m.sc067 = 'N','','') OR IF(m.sc067 = '0','1','0')OR IF(m.sc067 = '1','1',''))) as total6,
     SUM(((m.sc061 + m.sc062 + m.sc063 + m.sc064 + m.sc065 + m.sc066 + m.sc067) - m.dec06) + m.no06) as amount6,
     m.na07, m.mi07, no07, m.sc071, m.sc072, m.sc073, m.sc074, m.sc075, m.sc076, m.sc077, m.dec07,
     SUM(
         (IF(m.sc071 = 'N','','') OR IF(m.sc071 = '0','1','0')OR IF(m.sc071 = '1','1','')) + 
         (IF(m.sc072 = 'N','','') OR IF(m.sc072 = '0','1','0')OR IF(m.sc072 = '1','1','')) +
         (IF(m.sc073 = 'N','','') OR IF(m.sc073 = '0','1','0')OR IF(m.sc073 = '1','1','')) +
         (IF(m.sc074 = 'N','','') OR IF(m.sc074 = '0','1','0')OR IF(m.sc074 = '1','1','')) +
         (IF(m.sc075 = 'N','','') OR IF(m.sc075 = '0','1','0')OR IF(m.sc075 = '1','1','')) +
         (IF(m.sc076 = 'N','','') OR IF(m.sc076 = '0','1','0')OR IF(m.sc076 = '1','1','')) +
         (IF(m.sc077 = 'N','','') OR IF(m.sc077 = '0','1','0')OR IF(m.sc077 = '1','1',''))) as total7,
     SUM(((m.sc071 + m.sc072 + m.sc073 + m.sc074 + m.sc075 + m.sc076 + m.sc077) - m.dec07) + m.no07) as amount7,
     m.na08, m.mi08, no08, m.sc081, m.sc082, m.sc083, m.sc084, m.sc085, m.sc086, m.sc087, m.dec08,
      SUM(
         (IF(m.sc081 = 'N','','') OR IF(m.sc081 = '0','1','0')OR IF(m.sc081 = '1','1','')) + 
         (IF(m.sc082 = 'N','','') OR IF(m.sc082 = '0','1','0')OR IF(m.sc082 = '1','1','')) +
         (IF(m.sc083 = 'N','','') OR IF(m.sc083 = '0','1','0') OR IF(m.sc083 = '1','1','')) +
         (IF(m.sc084 = 'N','','') OR IF(m.sc084 = '0','1','0')OR IF(m.sc084 = '1','1','')) +
         (IF(m.sc085 = 'N','','') OR IF(m.sc085 = '0','1','0')OR IF(m.sc085 = '1','1','')) +
         (IF(m.sc086 = 'N','','') OR IF(m.sc086 = '0','1','0')OR IF(m.sc086 = '1','1','')) +
         (IF(m.sc087 = 'N','','') OR IF(m.sc087 = '0','1','0')OR IF(m.sc087 = '1','1',''))) as total8,
      SUM(((m.sc081 + m.sc082 + m.sc083 + m.sc084 + m.sc085 + m.sc086 + m.sc087) - m.dec08) + m.no08) as amount8,
     m.na09, m.mi09, no09, m.sc091, m.sc092, m.sc093, m.sc094, m.sc095, m.sc096, m.sc097, m.dec09,
     SUM(
         (IF(m.sc091 = 'N','','') OR IF(m.sc091 = '0','1','0')OR IF(m.sc091 = '1','1','')) + 
         (IF(m.sc092 = 'N','','') OR IF(m.sc092 = '0','1','0')OR IF(m.sc092 = '1','1','')) +
         (IF(m.sc093 = 'N','','') OR IF(m.sc093 = '0','1','0')OR IF(m.sc093 = '1','1','')) +
         (IF(m.sc094 = 'N','','') OR IF(m.sc094 = '0','1','0')OR IF(m.sc094 = '1','1','')) +
         (IF(m.sc095 = 'N','','') OR IF(m.sc095 = '0','1','0')OR IF(m.sc095 = '1','1','')) +
         (IF(m.sc096 = 'N','','') OR IF(m.sc096 = '0','1','0')OR IF(m.sc096 = '1','1','')) +
         (IF(m.sc097 = 'N','','') OR IF(m.sc097 = '0','1','0')OR IF(m.sc097 = '1','1',''))) as total9,
      SUM(((m.sc091 + m.sc092 + m.sc093 + m.sc094 + m.sc095 + m.sc096 + m.sc097) - m.dec09) + m.no09) as amount9,
      m.na10, m.mi10, no10, m.sc101, m.sc102, m.sc103, m.sc104, m.sc105, m.sc106, m.sc107, m.dec10,
 SUM(
     (IF(m.sc101 = 'N','','') OR IF(m.sc101 = '0','1','0')OR IF(m.sc101 = '1','1',''))+ 
     (IF(m.sc102 = 'N','','') OR IF(m.sc102 = '0','1','0')OR IF(m.sc102 = '1','1','')) +
     (IF(m.sc103 = 'N','','') OR IF(m.sc103 = '0','1','0')OR IF(m.sc103 = '1','1','')) +
     (IF(m.sc104 = 'N','','') OR IF(m.sc104 = '0','1','0')OR IF(m.sc104 = '1','1','')) +
     (IF(m.sc105 = 'N','','') OR IF(m.sc105 = '0','1','0')OR IF(m.sc105 = '1','1','')) +
     (IF(m.sc106 = 'N','','') OR IF(m.sc106 = '0','1','0')OR IF(m.sc106 = '1','1','')) +
     (IF(m.sc107 = 'N','','') OR IF(m.sc107 = '0','1','0')OR IF(m.sc107 = '1','1',''))) as total10,
 SUM(((m.sc101 + m.sc102 + m.sc103 + m.sc104 + m.sc105 + m.sc106 + m.sc107) - m.dec10) + m.no10) as amount10,
    
    m.visit, mv.overall_name, m.note
               FROM mra_opd m
               INNER JOIN mra_departmetns_opd d ON m.unit_id = d.unit_id
               LEFT JOIN hospitals h ON h.hospcode = m.hospcode
			   INNER JOIN mra_overall mv on mv.overall_id = m.overall_id
               WHERE  m.mra_id = $id
			   #m.date_audit BETWEEN '$date1' AND '$date2'
               #AND m.unit_id = '13'
			   AND m.hn = '$hn'
               GROUP BY m.HN ) as k ) as s";
		 $rawData = \yii::$app->db_mra->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db_mra->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
             'pageSize' => 10,
             ],
        ]);
        
        return $this->render('hn_pdf', [
                    'model' => $this->findModel($id),
                    //'model' => $this->findModel($AN),
                   // 'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sql'=>$sql,               
                 
        ]);   
      }
}
