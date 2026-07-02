<?php

namespace app\controllers;

use Yii;
use app\models\Mraipd;
use app\models\Mraoverall;
use app\models\Mrafinding;
use app\models\MraipdSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use mPDF;
/* เพิ่มคำสั่ง 3 บรรทัดต่อจากนี้ลงไป */
use yii\filters\AccessControl;        // เรียกใช้ คลาส AccessControl
use app\models\User;             // เรียกใช้ Model คลาส User ที่ปรับปรังปรุงไว้
use app\components\AccessRule;   // เรียกใช้ คลาส Component AccessRule ที่เราสร้างใหม่
/**
 * MraipdController implements the CRUD actions for Mraipd model.
 */
class MraipdController extends Controller
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
     * Lists all Mraipd models.
     * @return mixed
     */
    public function actionIndex()
    {
        $data = Yii::$app->request->post();
        $an =isset($data['an'])  ? $data['an'] : '';

        $searchModel = new MraipdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['mra_id' => SORT_DESC];
        Yii::$app->session['an'] = $an;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'an'=> $an,
        ]);
    }
    

    /**
     * Displays a single Mraipd model.
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
     * Creates a new Mraipd model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	  public function actionCreate()
    {
        $model = new Mraipd();

        if ($model->load(Yii::$app->request->post())) {
            //ตรวจสอบการจองซ้ำ
            $rent = Mraipd::find()
                    ->where(['AN' => $model->AN])
                    //->andWhere(['AN' => $model->AN])
                    ->one();
				//	 Yii::$app->getSession()->setFlash('danger', 'การจองไม่สำเร็จ!! พาหนะถูกจองในวันและเวลาที่ระบุแล้ว');
               // return $this->redirect(['create']);
            if(empty($rent)){ //เมื่อไม่มีการจองซ้ำ
			 $model->load(Yii::$app->request->post())  ;
				 $model->save();
			 Yii::$app->session->setFlash('success', 'เพิ่มข้อมูลข้อมูลสำเร็จ');
            return $this->redirect(['index', 'id' => $model->mra_id, 'AN'=>$model->AN]);
                //$model->user_id = Yii::$app->user->getId();
               // $model->save();
               // $vid = $model->vehicle_id;
               // $vehicle = Vehicle::findOne($vid);
               
               // Yii::$app->getSession()->setFlash('info', 'การจองสำเร็จ!! ระบบจะส่งข้อความทางไลน์แก่ผู้รับผิดชอบอัตโนมัติคะ่');
               // return $this->redirect(['rental/userindex','id' => $model->id]); //ไปยังหน้าวิวuser
            }else{
                Yii::$app->getSession()->setFlash('danger', 'การจองไม่สำเร็จ!! พาหนะถูกจองในวันและเวลาที่ระบุแล้ว');
                return $this->redirect(['create']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	
	 /*
    public function actionCreate()
    {
        $model = new Mraipd();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			 Yii::$app->session->setFlash('success', 'เพิ่มข้อมูลข้อมูลสำเร็จ');
            return $this->redirect(['index', 'id' => $model->mra_id, 'AN'=>$model->AN]);
        
       } else {
        $model->date_admit = date('Y-m-d');
        $model->date_discharge = date('Y-m-d');
        $model->date_audit = date('Y-m-d');
       }
        //$model->ss_date = date('Y-m-d');
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Mraipd model.
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
     * Deletes an existing Mraipd model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Mraipd model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mraipd the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mraipd::findOne($id)) !== null) {
            return $model;
        }
        $model->date_admit = date('Y-m-d');
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionPercent() {
         $p = array(1,2,3,4,5,6,7,8,9,10,11,11,12,13,14);
         $data = Yii::$app->request->post();
		 $date1 =isset($data['date1'])  ? $data['date1'] : '';
		 $date2 =isset($data['date2'])  ? $data['date2'] : '';
         $unit =isset($data['unit_id'])  ? $data['unit_id'] : '';
         $visits =isset($data['txt_visit'])  ? $data['txt_visit'] : '';
         if (empty($unit)) {
			//$units = $unitx;	
			//$code[] = $p;
			$units = implode(",", $p);
			//print_r($units);
		}else{
			$units = $unit;
		}
        $sql = "SELECT
s.hospcode, s.hosp_name,s.unit_id, s.unit_name,
 s.No,
CASE 
       WHEN s.dep > 30 THEN 'IPD'
	   WHEN s.dep < 30 THEN s.unit_name
       ELSE s.unit_name
	   END as unit_name,
 s.amounts,
-- s.date_audit,
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
SUM(s.a11) as s11,
SUM(s.a12) as s12,
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
SUM(s.t11) as f11,
SUM(s.t12) as f12,
ROUND(SUM(s.a1/s.t1) * 100,2) as p1,
ROUND(SUM(s.a2/s.t2) * 100,2) as p2,
ROUND(SUM(s.a3/s.t3) * 100,2) as p3,
ROUND(SUM(s.a4/s.t4) * 100,2) as p4,
ROUND(SUM(s.a5/s.t5) * 100,2) as p5,
ROUND(SUM(s.a6/s.t6) * 100,2) as p6,
ROUND(SUM(s.a7/s.t7) * 100,2) as p7,
ROUND(SUM(s.a8/s.t8) * 100,2) as p8,
ROUND(SUM(s.a9/s.t9) * 100,2) as p9,
ROUND(SUM(s.a10/s.t10) * 100,2) as p10,
ROUND(SUM(s.a11/s.t11) * 100,2) as p11,
ROUND(SUM(s.a12/s.t12) * 100,2) as p12,
SUM(a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8 +a9 +a10 + a11 + a12) as sum,
SUM(t1 + t2 + t3 + t4 + t5 + t6 + t7 + t8 +t9 +t10 + t11 + t12) as full,
ROUND((SUM(a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8 +a9 +a10 + a11 + a12) / SUM(t1 + t2 + t3 + t4 + t5 + t6 + t7 + t8 +t9 +t10 + t11 + t12)) * 100,2)  as percent

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
SUM(k.total11) t11,
SUM(k.amount11) a11,
SUM(k.total12) t12,
SUM(k.amount12) a12,
count(k.hn) as amounts,
count(k.unit_id) as dep,
k.No
FROM (
SELECT 
m.hospcode,h.hosp_name, m.unit_id, d.unit_name,
m.hn, m.an, m.date_admit, m.date_audit, m.date_discharge,
CONCAT(m.visits,'/',date_format(date_add(m.date_audit, INTERVAL 543 YEAR),'%Y')) No,
m.na1, m.missing1, no1, m.dxop1, m.dxop2, m.dxop3, m.dxop4, m.dxop5, m.dxop6, m.dxop7, m.dxop8, m.dxop9, m.dxop_huk,
SUM((IF(m.dxop1 = 'N','','1') OR IF(m.dxop1 = '0','1','0')) + 
(IF(m.dxop2 = 'N','','1') OR IF(m.dxop2 = '0','1','0')) +
(IF(m.dxop3 = 'N','','1') OR IF(m.dxop3 = '0','1','0')) +
(IF(m.dxop4 = 'N','','1') OR IF(m.dxop4 = '0','1','0')) +
(IF(m.dxop5 = 'N','','1') OR IF(m.dxop5 = '0','1','0')) +
(IF(m.dxop6 = 'N','','1') OR IF(m.dxop6 = '0','1','0')) +
(IF(m.dxop7 = 'N','','1') OR IF(m.dxop7 = '0','1','0')) +
(IF(m.dxop8 = 'N','','1') OR IF(m.dxop8 = '0','1','0')) +
(IF(m.dxop9 = 'N','','1') OR IF(m.dxop9 = '0','1','0'))) as total1,
SUM((m.dxop1 + m.dxop2 + m.dxop3 + m.dxop4 + m.dxop5 + m.dxop6 + m.dxop7+ m.dxop8+ m.dxop9) - m.dxop_huk) as amount1,
m.na2, m.missing2,m.no2, m.other1, m.other2, m.other3, m.other4, m.other5, m.other6, m.other7, m.other8, m.other9, m.other_huk,
SUM((IF(m.other1 = 'N','','1') OR IF(m.other1 = '0','1','0')) + 
(IF(m.other2 = 'N','','1') OR IF(m.other2 = '0','1','0')) +
(IF(m.other3 = 'N','','1') OR IF(m.other3 = '0','1','0')) +
(IF(m.other4 = 'N','','1') OR IF(m.other4 = '0','1','0')) +
(IF(m.other5 = 'N','','1') OR IF(m.other5= '0','1','0')) +
(IF(m.other6 = 'N','','1') OR IF(m.other6= '0','1','0')) +
(IF(m.other7 = 'N','','1') OR IF(m.other7= '0','1','0')) +
(IF(m.other8 = 'N','','1') OR IF(m.other8= '0','1','0')) +
(IF(m.other9 = 'N','','1') OR IF(m.other9= '0','1','0')) 
) as total2,
SUM(m.other1 + m.other2 + m.other3+ m.other4 + m.other5 + m.other6+ m.other7 + m.other8 + m.other9 - m.other_huk) as amount2,
m.na3, m.missing3, m.no3, m.infc1, m.infc2, m.infc3, m.infc4, m.infc5, m.infc6, m.infc7, m.infc8, m.infc9, m.infc_huk,
SUM(
(IF(m.infc1 = 'N','','1') OR IF(m.infc1 = '0','1','0')) + 
(IF(m.infc2 = 'N','','1') OR IF(m.infc2 = '0','1','0')) + 
(IF(m.infc3 = 'N','','1') OR IF(m.infc3 = '0','1','0')) + 
(IF(m.infc4 = 'N','','1') OR IF(m.infc4 = '0','1','0')) + 
(IF(m.infc5 = 'N','','1') OR IF(m.infc5 = '0','1','0')) + 
(IF(m.infc6 = 'N','','1') OR IF(m.infc6 = '0','1','0')) + 
(IF(m.infc7 = 'N','','1') OR IF(m.infc7 = '0','1','0')) + 
(IF(m.infc8 = 'N','','1') OR IF(m.infc8 = '0','1','0')) + 
(IF(m.infc9 = 'N','','1') OR IF(m.infc9 = '0','1','0'))  
) total3,
SUM(m.infc1 + m.infc2+ m.infc3 + m.infc4+ m.infc5 + m.infc6 + m.infc7 + m.infc8 + m.infc9 - m.infc_huk) as amount3,
m.na4, m.missing4, m.no4, m.hist1, m.hist2, m.hist3, m.hist4, m.hist5, m.hist6, m.hist7, m.hist8, m.hist9, m.hist_huk,
SUM(
(IF(m.hist1 = 'N','','1') OR IF(m.hist1 = '0','1','0')) + 
(IF(m.hist2 = 'N','','1') OR IF(m.hist2 = '0','1','0')) + 
(IF(m.hist3 = 'N','','1') OR IF(m.hist3 = '0','1','0')) + 
(IF(m.hist4 = 'N','','1') OR IF(m.hist4 = '0','1','0')) + 
(IF(m.hist5 = 'N','','1') OR IF(m.hist5 = '0','1','0')) + 
(IF(m.hist6 = 'N','','1') OR IF(m.hist6 = '0','1','0')) + 
(IF(m.hist7 = 'N','','1') OR IF(m.hist7 = '0','1','0')) + 
(IF(m.hist8 = 'N','','1') OR IF(m.hist8 = '0','1','0')) + 
(IF(m.hist9 = 'N','','1') OR IF(m.hist9 = '0','1','0'))  
) as total4,
SUM(m.hist1 + m.hist2 + m.hist3 + m.hist4 + m.hist5 + m.hist6 + m.hist7 + m.hist8 + m.hist9 - m.hist_huk) as amount4,
m.na5, m.missing5, m.no5, m.pe1, m.pe2, m.pe3, m.pe4, m.pe5, m.pe6, m.pe7, m.pe8, m.pe9, m.pe_huk, 
SUM(
(IF(m.pe1 = 'N','','1') OR IF(m.pe1 = '0','1','0')) + 
(IF(m.pe2 = 'N','','1') OR IF(m.pe2 = '0','1','0')) + 
(IF(m.pe3 = 'N','','1') OR IF(m.pe3 = '0','1','0')) + 
(IF(m.pe4 = 'N','','1') OR IF(m.pe4 = '0','1','0')) + 
(IF(m.pe5 = 'N','','1') OR IF(m.pe5 = '0','1','0')) + 
(IF(m.pe6 = 'N','','1') OR IF(m.pe6 = '0','1','0')) + 
(IF(m.pe7 = 'N','','1') OR IF(m.pe7 = '0','1','0')) + 
(IF(m.pe8 = 'N','','1') OR IF(m.pe8 = '0','1','0')) + 
(IF(m.pe9 = 'N','','1') OR IF(m.pe9 = '0','1','0')) 
)  as total5,
SUM(m.pe1 + m.pe2 + m.pe3 + m.pe4 + m.pe5 + m.pe6 + m.pe7 + m.pe8 + m.pe9 - m.pe_huk) as amount5,
m.na6, m.missing6, m.no6, m.pn1, m.pn2, m.pn3, m.pn4, m.pn5, m.pn6, m.pn7, m.pn8, m.pn9 , m.pn_huk,
SUM(
(IF(m.pn1 = 'N','','1') OR IF(m.pn1 = '0','1','0')) + 
(IF(m.pn2 = 'N','','1') OR IF(m.pn2 = '0','1','0')) + 
(IF(m.pn3 = 'N','','1') OR IF(m.pn3 = '0','1','0')) + 
(IF(m.pn4 = 'N','','1') OR IF(m.pn4 = '0','1','0')) + 
(IF(m.pn5 = 'N','','1') OR IF(m.pn5 = '0','1','0')) + 
(IF(m.pn6 = 'N','','1') OR IF(m.pn6 = '0','1','0')) + 
(IF(m.pn7 = 'N','','1') OR IF(m.pn7 = '0','1','0')) + 
(IF(m.pn8 = 'N','','1') OR IF(m.pn8 = '0','1','0')) + 
(IF(m.pn9 = 'N','','1') OR IF(m.pn9 = '0','1','0')) 
 ) as total6,
SUM(m.pn1 + m.pn2 + m.pn3 + m.pn4 + m.pn5 + m.pn6 + m.pn7 + m.pn8 + m.pn9 - m.pn_huk) as amount6,
m.na7, m.missing7, m.no7, m.cr1, m.cr2, m.cr3, m.cr4, m.cr5, m.cr6, m.cr7, m.cr8, m.cr9, m.cr_huk,
SUM(
(IF(ISNULL(m.cr1),'-','0') OR IF(m.cr1 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr2),'-','0') OR IF(m.cr2 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr3),'-','0') OR IF(m.cr3 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr4),'-','0') OR IF(m.cr4 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr5),'-','0') OR IF(m.cr5 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr6),'-','0') OR IF(m.cr6 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr7),'-','0') OR IF(m.cr7 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr8),'-','0') OR IF(m.cr8 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr9),'-','0') OR IF(m.cr9 >= '0' ,'1','0')) 
) as total7,
SUM(
(IF(ISNULL(m.cr1), '-',m.cr1)) +
(IF(ISNULL(m.cr2), '-',m.cr2)) +
(IF(ISNULL(m.cr3), '-',m.cr3)) +
(IF(ISNULL(m.cr4), '-',m.cr4)) +
(IF(ISNULL(m.cr5), '-',m.cr5)) +
(IF(ISNULL(m.cr6), '-',m.cr6)) +
(IF(ISNULL(m.cr7), '-',m.cr7)) +
(IF(ISNULL(m.cr8), '-',m.cr8)) +
(IF(ISNULL(m.cr9), '-',m.cr9)) -
(IF(ISNULL(m.cr_huk), '-',m.cr_huk))
) as amount7,
m.na8, m.missing8, m.no8, m.ar1, m.ar2, m.ar3, m.ar4, m.ar5, m.ar6, m.ar7, m.ar8, m.ar9, m.ar_huk,
SUM(
(IF(ISNULL(m.ar1),'-','0') OR IF(m.ar1 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar2),'-','0') OR IF(m.ar2 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar3),'-','0') OR IF(m.ar3 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar4),'-','0') OR IF(m.ar4 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar5),'-','0') OR IF(m.ar5 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar6),'-','0') OR IF(m.ar6 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar7),'-','0') OR IF(m.ar7 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar8),'-','0') OR IF(m.ar8 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar9),'-','0') OR IF(m.ar9 >= '0' ,'1','0')) 
) as total8,
SUM(
(IF(ISNULL(m.ar1), '-',m.ar1)) +
(IF(ISNULL(m.ar2), '-',m.ar2)) +
(IF(ISNULL(m.ar3), '-',m.ar3)) +
(IF(ISNULL(m.ar4), '-',m.ar4)) +
(IF(ISNULL(m.ar5), '-',m.ar5)) +
(IF(ISNULL(m.ar6), '-',m.ar6)) +
(IF(ISNULL(m.ar7), '-',m.ar7)) +
(IF(ISNULL(m.ar8), '-',m.ar8)) +
(IF(ISNULL(m.ar9), '-',m.ar9)) -
(IF(ISNULL(m.ar_huk), '-',m.ar_huk))
) as amount8,
m.na9, m.missing9, m.no9, m.on1, m.on2, m.on3, m.on4, m.on5, m.on6, m.on7, m.on8, m.on9, m.on_huk,
SUM(
(IF(ISNULL(m.on1),'-','0') OR IF(m.on1 >= '0' ,'1','0')) +
(IF(ISNULL(m.on2),'-','0') OR IF(m.on2 >= '0' ,'1','0')) +
(IF(ISNULL(m.on3),'-','0') OR IF(m.on3 >= '0' ,'1','0')) +
(IF(ISNULL(m.on4),'-','0') OR IF(m.on4 >= '0' ,'1','0')) +
(IF(ISNULL(m.on5),'-','0') OR IF(m.on5 >= '0' ,'1','0')) +
(IF(ISNULL(m.on6),'-','0') OR IF(m.on6 >= '0' ,'1','0')) +
(IF(ISNULL(m.on7),'-','0') OR IF(m.on7 >= '0' ,'1','0')) +
(IF(ISNULL(m.on8),'-','0') OR IF(m.on8 >= '0' ,'1','0')) +
(IF(ISNULL(m.on9),'-','0') OR IF(m.on9 >= '0' ,'1','0')) 
) as total9,
SUM(
(IF(ISNULL(m.on1), '-',m.on1)) +
(IF(ISNULL(m.on2), '-',m.on2)) +
(IF(ISNULL(m.on3), '-',m.on3)) +
(IF(ISNULL(m.on4), '-',m.on4)) +
(IF(ISNULL(m.on5), '-',m.on5)) +
(IF(ISNULL(m.on6), '-',m.on6)) +
(IF(ISNULL(m.on7), '-',m.on7)) +
(IF(ISNULL(m.on8), '-',m.on8)) +
(IF(ISNULL(m.on9), '-',m.on9)) -
(IF(ISNULL(m.on_huk), '-',m.on_huk))
) as amount9,
m.na10, m.missing10, m.no10, m.lr1, m.lr2, m.lr3, m.lr4, m.lr5, m.lr6, m.lr7, m.lr8, m.lr9, m.lr_huk, 
SUM(
(IF(ISNULL(m.lr1),'-','0') OR IF(m.lr1 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr2),'-','0') OR IF(m.lr2 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr3),'-','0') OR IF(m.lr3 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr4),'-','0') OR IF(m.lr4 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr5),'-','0') OR IF(m.lr5 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr6),'-','0') OR IF(m.lr6 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr7),'-','0') OR IF(m.lr7 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr8),'-','0') OR IF(m.lr8 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr9),'-','0') OR IF(m.lr9 >= '0' ,'1','0')) 
) as total10,
SUM(
(IF(ISNULL(m.lr1), '-',m.lr1)) +
(IF(ISNULL(m.lr2), '-',m.lr2)) +
(IF(ISNULL(m.lr3), '-',m.lr3)) +
(IF(ISNULL(m.lr4), '-',m.lr4)) +
(IF(ISNULL(m.lr5), '-',m.lr5)) +
(IF(ISNULL(m.lr6), '-',m.lr6)) +
(IF(ISNULL(m.lr7), '-',m.lr7)) +
(IF(ISNULL(m.lr8), '-',m.lr8)) +
(IF(ISNULL(m.lr9), '-',m.lr9)) -
(IF(ISNULL(m.lr_huk), '-',m.lr_huk))
) as amount10,
m.na11, m.missing11, m.no11, m.rr1, m.rr2, m.rr3, m.rr4, m.rr5, m.rr6, m.rr7, m.rr8, m.rr9, m.rr_huk,
SUM(
(IF(ISNULL(m.rr1),'-','0') OR IF(m.rr1 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr2),'-','0') OR IF(m.rr2 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr3),'-','0') OR IF(m.rr3 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr4),'-','0') OR IF(m.rr4 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr5),'-','0') OR IF(m.rr5 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr6),'-','0') OR IF(m.rr6 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr7),'-','0') OR IF(m.rr7 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr8),'-','0') OR IF(m.rr8 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr9),'-','0') OR IF(m.rr9 >= '0' ,'1','0')) 
) as total11,
SUM(
(IF(ISNULL(m.rr1), '-',m.rr1)) +
(IF(ISNULL(m.rr2), '-',m.rr2)) +
(IF(ISNULL(m.rr3), '-',m.rr3)) +
(IF(ISNULL(m.rr4), '-',m.rr4)) +
(IF(ISNULL(m.rr5), '-',m.rr5)) +
(IF(ISNULL(m.rr6), '-',m.rr6)) +
(IF(ISNULL(m.rr7), '-',m.rr7)) +
(IF(ISNULL(m.rr8), '-',m.rr8)) +
(IF(ISNULL(m.rr9), '-',m.rr9)) -
(IF(ISNULL(m.rr_huk), '-',m.rr_huk))
) as amount11,
m.na12, m.missing12, m.no12, m.nn1, m.nn2, m.nn3, m.nn4, m.nn5, m.nn6, m.nn7, m.nn8, m.nn9, m.nn_huk ,
SUM(
(IF(ISNULL(m.nn1),'-','0') OR IF(m.nn1 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn2),'-','0') OR IF(m.nn2 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn3),'-','0') OR IF(m.nn3 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn4),'-','0') OR IF(m.nn4 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn5),'-','0') OR IF(m.nn5 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn6),'-','0') OR IF(m.nn6 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn7),'-','0') OR IF(m.nn7 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn8),'-','0') OR IF(m.nn8 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn9),'-','0') OR IF(m.nn9 >= '0' ,'1','0')) 
) as total12,
SUM(
(IF(ISNULL(m.nn1), '-',m.nn1)) +
(IF(ISNULL(m.nn2), '-',m.nn2)) +
(IF(ISNULL(m.nn3), '-',m.nn3)) +
(IF(ISNULL(m.nn4), '-',m.nn4)) +
(IF(ISNULL(m.nn5), '-',m.nn5)) +
(IF(ISNULL(m.nn6), '-',m.nn6)) +
(IF(ISNULL(m.nn7), '-',m.nn7)) +
(IF(ISNULL(m.nn8), '-',m.nn8)) +
(IF(ISNULL(m.nn9), '-',m.nn9)) -
(IF(ISNULL(m.nn_huk), '-',m.nn_huk))
) as amount12
FROM mra_ipd m
INNER JOIN mra_departmetns_ipd d ON m.unit_id = d.unit_id
LEFT JOIN hospitals h ON h.hospcode = m.hospcode
WHERE m.date_audit BETWEEN '$date1' AND '$date2'
AND m.unit_id in ($units) 
AND m.visits = '$visits'	 
GROUP BY m.AN ) as k ) as s
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
        Yii::$app->session['date1'] =$date1;
        Yii::$app->session['date2'] =$date2;
        Yii::$app->session['unit_id'] =$units;
		Yii::$app->session['visit'] =$visits;
        return $this->render('percents', [
                    //'model' => $this->findModel($id),
                    //'model' => $this->findModel($AN),
                   // 'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sql'=>$sql,
                ]);   
            }
            public function actionPercentpdf() {
                $date1 = Yii::$app->session['date1'];
                $date2 = Yii::$app->session['date2'];
                $units = Yii::$app->session['unit_id'];
                $visits = Yii::$app->session['visit'];
                    
                $sql = "SELECT
                s.hospcode, s.hosp_name,s.unit_id, s.unit_name, 
                s.No,
                CASE 
                    WHEN s.dep > 30 THEN 'IPD'
                    WHEN s.dep < 30 THEN s.unit_name
                    ELSE s.unit_name
                    END as unit_name,
                s.amounts,
               # s.date_audit,
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
                SUM(s.a11) as s11,
                SUM(s.a12) as s12,
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
                SUM(s.t11) as f11,
                SUM(s.t12) as f12,
                ROUND(SUM(s.a1/s.t1) * 100,2) as p1,
                ROUND(SUM(s.a2/s.t2) * 100,2) as p2,
                ROUND(SUM(s.a3/s.t3) * 100,2) as p3,
                ROUND(SUM(s.a4/s.t4) * 100,2) as p4,
                ROUND(SUM(s.a5/s.t5) * 100,2) as p5,
                ROUND(SUM(s.a6/s.t6) * 100,2) as p6,
                ROUND(SUM(s.a7/s.t7) * 100,2) as p7,
                ROUND(SUM(s.a8/s.t8) * 100,2) as p8,
                ROUND(SUM(s.a9/s.t9) * 100,2) as p9,
                ROUND(SUM(s.a10/s.t10) * 100,2) as p10,
                ROUND(SUM(s.a11/s.t11) * 100,2) as p11,
                ROUND(SUM(s.a12/s.t12) * 100,2) as p12,
                SUM(a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8 +a9 +a10 + a11 + a12) as sum,
                SUM(t1 + t2 + t3 + t4 + t5 + t6 + t7 + t8 +t9 +t10 + t11 + t12) as full,
                ROUND((SUM(a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8 +a9 +a10 + a11 + a12) / SUM(t1 + t2 + t3 + t4 + t5 + t6 + t7 + t8 +t9 +t10 + t11 + t12)) * 100,2)  as percent
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
                SUM(k.total11) t11,
                SUM(k.amount11) a11,
                SUM(k.total12) t12,
                SUM(k.amount12) a12,
                count(k.hn) as amounts,
                count(k.unit_id) as dep,
                k.No
                FROM (
                SELECT 
                m.hospcode,h.hosp_name, m.unit_id, d.unit_name,
                m.hn, m.an, m.date_admit, m.date_audit, m.date_discharge,
                CONCAT(m.visits,'/',date_format(date_add(m.date_audit, INTERVAL 543 YEAR),'%Y')) No,
                m.na1, m.missing1, no1, m.dxop1, m.dxop2, m.dxop3, m.dxop4, m.dxop5, m.dxop6, m.dxop7, m.dxop8, m.dxop9, m.dxop_huk,
                SUM((IF(m.dxop1 = 'N','','1') OR IF(m.dxop1 = '0','1','0')) + 
                (IF(m.dxop2 = 'N','','1') OR IF(m.dxop2 = '0','1','0')) +
                (IF(m.dxop3 = 'N','','1') OR IF(m.dxop3 = '0','1','0')) +
                (IF(m.dxop4 = 'N','','1') OR IF(m.dxop4 = '0','1','0')) +
                (IF(m.dxop5 = 'N','','1') OR IF(m.dxop5 = '0','1','0')) +
                (IF(m.dxop6 = 'N','','1') OR IF(m.dxop6 = '0','1','0')) +
                (IF(m.dxop7 = 'N','','1') OR IF(m.dxop7 = '0','1','0')) +
                (IF(m.dxop8 = 'N','','1') OR IF(m.dxop8 = '0','1','0')) +
                (IF(m.dxop9 = 'N','','1') OR IF(m.dxop9 = '0','1','0'))) as total1,
                SUM((m.dxop1 + m.dxop2 + m.dxop3 + m.dxop4 + m.dxop5 + m.dxop6 + m.dxop7+ m.dxop8+ m.dxop9) - m.dxop_huk) as amount1,
                m.na2, m.missing2,m.no2, m.other1, m.other2, m.other3, m.other4, m.other5, m.other6, m.other7, m.other8, m.other9, m.other_huk,
                SUM((IF(m.other1 = 'N','','1') OR IF(m.other1 = '0','1','0')) + 
                (IF(m.other2 = 'N','','1') OR IF(m.other2 = '0','1','0')) +
                (IF(m.other3 = 'N','','1') OR IF(m.other3 = '0','1','0')) +
                (IF(m.other4 = 'N','','1') OR IF(m.other4 = '0','1','0')) +
                (IF(m.other5 = 'N','','1') OR IF(m.other5= '0','1','0')) +
                (IF(m.other6 = 'N','','1') OR IF(m.other6= '0','1','0')) +
                (IF(m.other7 = 'N','','1') OR IF(m.other7= '0','1','0')) +
                (IF(m.other8 = 'N','','1') OR IF(m.other8= '0','1','0')) +
                (IF(m.other9 = 'N','','1') OR IF(m.other9= '0','1','0')) 
                ) as total2,
                SUM(m.other1 + m.other2 + m.other3+ m.other4 + m.other5 + m.other6+ m.other7 + m.other8 + m.other9 - m.other_huk) as amount2,
                m.na3, m.missing3, m.no3, m.infc1, m.infc2, m.infc3, m.infc4, m.infc5, m.infc6, m.infc7, m.infc8, m.infc9, m.infc_huk,
                SUM(
                (IF(m.infc1 = 'N','','1') OR IF(m.infc1 = '0','1','0')) + 
                (IF(m.infc2 = 'N','','1') OR IF(m.infc2 = '0','1','0')) + 
                (IF(m.infc3 = 'N','','1') OR IF(m.infc3 = '0','1','0')) + 
                (IF(m.infc4 = 'N','','1') OR IF(m.infc4 = '0','1','0')) + 
                (IF(m.infc5 = 'N','','1') OR IF(m.infc5 = '0','1','0')) + 
                (IF(m.infc6 = 'N','','1') OR IF(m.infc6 = '0','1','0')) + 
                (IF(m.infc7 = 'N','','1') OR IF(m.infc7 = '0','1','0')) + 
                (IF(m.infc8 = 'N','','1') OR IF(m.infc8 = '0','1','0')) + 
                (IF(m.infc9 = 'N','','1') OR IF(m.infc9 = '0','1','0'))  
                ) total3,
                SUM(m.infc1 + m.infc2+ m.infc3 + m.infc4+ m.infc5 + m.infc6 + m.infc7 + m.infc8 + m.infc9 - m.infc_huk) as amount3,
                m.na4, m.missing4, m.no4, m.hist1, m.hist2, m.hist3, m.hist4, m.hist5, m.hist6, m.hist7, m.hist8, m.hist9, m.hist_huk,
                SUM(
                (IF(m.hist1 = 'N','','1') OR IF(m.hist1 = '0','1','0')) + 
                (IF(m.hist2 = 'N','','1') OR IF(m.hist2 = '0','1','0')) + 
                (IF(m.hist3 = 'N','','1') OR IF(m.hist3 = '0','1','0')) + 
                (IF(m.hist4 = 'N','','1') OR IF(m.hist4 = '0','1','0')) + 
                (IF(m.hist5 = 'N','','1') OR IF(m.hist5 = '0','1','0')) + 
                (IF(m.hist6 = 'N','','1') OR IF(m.hist6 = '0','1','0')) + 
                (IF(m.hist7 = 'N','','1') OR IF(m.hist7 = '0','1','0')) + 
                (IF(m.hist8 = 'N','','1') OR IF(m.hist8 = '0','1','0')) + 
                (IF(m.hist9 = 'N','','1') OR IF(m.hist9 = '0','1','0'))  
                ) as total4,
                SUM(m.hist1 + m.hist2 + m.hist3 + m.hist4 + m.hist5 + m.hist6 + m.hist7 + m.hist8 + m.hist9 - m.hist_huk) as amount4,
                m.na5, m.missing5, m.no5, m.pe1, m.pe2, m.pe3, m.pe4, m.pe5, m.pe6, m.pe7, m.pe8, m.pe9, m.pe_huk, 
                SUM(
                (IF(m.pe1 = 'N','','1') OR IF(m.pe1 = '0','1','0')) + 
                (IF(m.pe2 = 'N','','1') OR IF(m.pe2 = '0','1','0')) + 
                (IF(m.pe3 = 'N','','1') OR IF(m.pe3 = '0','1','0')) + 
                (IF(m.pe4 = 'N','','1') OR IF(m.pe4 = '0','1','0')) + 
                (IF(m.pe5 = 'N','','1') OR IF(m.pe5 = '0','1','0')) + 
                (IF(m.pe6 = 'N','','1') OR IF(m.pe6 = '0','1','0')) + 
                (IF(m.pe7 = 'N','','1') OR IF(m.pe7 = '0','1','0')) + 
                (IF(m.pe8 = 'N','','1') OR IF(m.pe8 = '0','1','0')) + 
                (IF(m.pe9 = 'N','','1') OR IF(m.pe9 = '0','1','0')) 
                )  as total5,
                SUM(m.pe1 + m.pe2 + m.pe3 + m.pe4 + m.pe5 + m.pe6 + m.pe7 + m.pe8 + m.pe9 - m.pe_huk) as amount5,
                m.na6, m.missing6, m.no6, m.pn1, m.pn2, m.pn3, m.pn4, m.pn5, m.pn6, m.pn7, m.pn8, m.pn9 , m.pn_huk,
                SUM(
                (IF(m.pn1 = 'N','','1') OR IF(m.pn1 = '0','1','0')) + 
                (IF(m.pn2 = 'N','','1') OR IF(m.pn2 = '0','1','0')) + 
                (IF(m.pn3 = 'N','','1') OR IF(m.pn3 = '0','1','0')) + 
                (IF(m.pn4 = 'N','','1') OR IF(m.pn4 = '0','1','0')) + 
                (IF(m.pn5 = 'N','','1') OR IF(m.pn5 = '0','1','0')) + 
                (IF(m.pn6 = 'N','','1') OR IF(m.pn6 = '0','1','0')) + 
                (IF(m.pn7 = 'N','','1') OR IF(m.pn7 = '0','1','0')) + 
                (IF(m.pn8 = 'N','','1') OR IF(m.pn8 = '0','1','0')) + 
                (IF(m.pn9 = 'N','','1') OR IF(m.pn9 = '0','1','0')) 
                 ) as total6,
                SUM(m.pn1 + m.pn2 + m.pn3 + m.pn4 + m.pn5 + m.pn6 + m.pn7 + m.pn8 + m.pn9 - m.pn_huk) as amount6,
                m.na7, m.missing7, m.no7, m.cr1, m.cr2, m.cr3, m.cr4, m.cr5, m.cr6, m.cr7, m.cr8, m.cr9, m.cr_huk,
                SUM(
                (IF(ISNULL(m.cr1),'-','0') OR IF(m.cr1 >= '0' ,'1','0')) +
                (IF(ISNULL(m.cr2),'-','0') OR IF(m.cr2 >= '0' ,'1','0')) +
                (IF(ISNULL(m.cr3),'-','0') OR IF(m.cr3 >= '0' ,'1','0')) +
                (IF(ISNULL(m.cr4),'-','0') OR IF(m.cr4 >= '0' ,'1','0')) +
                (IF(ISNULL(m.cr5),'-','0') OR IF(m.cr5 >= '0' ,'1','0')) +
                (IF(ISNULL(m.cr6),'-','0') OR IF(m.cr6 >= '0' ,'1','0')) +
                (IF(ISNULL(m.cr7),'-','0') OR IF(m.cr7 >= '0' ,'1','0')) +
                (IF(ISNULL(m.cr8),'-','0') OR IF(m.cr8 >= '0' ,'1','0')) +
                (IF(ISNULL(m.cr9),'-','0') OR IF(m.cr9 >= '0' ,'1','0')) 
                ) as total7,
                SUM(
                (IF(ISNULL(m.cr1), '-',m.cr1)) +
                (IF(ISNULL(m.cr2), '-',m.cr2)) +
                (IF(ISNULL(m.cr3), '-',m.cr3)) +
                (IF(ISNULL(m.cr4), '-',m.cr4)) +
                (IF(ISNULL(m.cr5), '-',m.cr5)) +
                (IF(ISNULL(m.cr6), '-',m.cr6)) +
                (IF(ISNULL(m.cr7), '-',m.cr7)) +
                (IF(ISNULL(m.cr8), '-',m.cr8)) +
                (IF(ISNULL(m.cr9), '-',m.cr9)) -
                (IF(ISNULL(m.cr_huk), '-',m.cr_huk))
                ) as amount7,
                m.na8, m.missing8, m.no8, m.ar1, m.ar2, m.ar3, m.ar4, m.ar5, m.ar6, m.ar7, m.ar8, m.ar9, m.ar_huk,
                SUM(
                (IF(ISNULL(m.ar1),'-','0') OR IF(m.ar1 >= '0' ,'1','0')) +
                (IF(ISNULL(m.ar2),'-','0') OR IF(m.ar2 >= '0' ,'1','0')) +
                (IF(ISNULL(m.ar3),'-','0') OR IF(m.ar3 >= '0' ,'1','0')) +
                (IF(ISNULL(m.ar4),'-','0') OR IF(m.ar4 >= '0' ,'1','0')) +
                (IF(ISNULL(m.ar5),'-','0') OR IF(m.ar5 >= '0' ,'1','0')) +
                (IF(ISNULL(m.ar6),'-','0') OR IF(m.ar6 >= '0' ,'1','0')) +
                (IF(ISNULL(m.ar7),'-','0') OR IF(m.ar7 >= '0' ,'1','0')) +
                (IF(ISNULL(m.ar8),'-','0') OR IF(m.ar8 >= '0' ,'1','0')) +
                (IF(ISNULL(m.ar9),'-','0') OR IF(m.ar9 >= '0' ,'1','0')) 
                ) as total8,
                SUM(
                (IF(ISNULL(m.ar1), '-',m.ar1)) +
                (IF(ISNULL(m.ar2), '-',m.ar2)) +
                (IF(ISNULL(m.ar3), '-',m.ar3)) +
                (IF(ISNULL(m.ar4), '-',m.ar4)) +
                (IF(ISNULL(m.ar5), '-',m.ar5)) +
                (IF(ISNULL(m.ar6), '-',m.ar6)) +
                (IF(ISNULL(m.ar7), '-',m.ar7)) +
                (IF(ISNULL(m.ar8), '-',m.ar8)) +
                (IF(ISNULL(m.ar9), '-',m.ar9)) -
                (IF(ISNULL(m.ar_huk), '-',m.ar_huk))
                ) as amount8,
                m.na9, m.missing9, m.no9, m.on1, m.on2, m.on3, m.on4, m.on5, m.on6, m.on7, m.on8, m.on9, m.on_huk,
                SUM(
                (IF(ISNULL(m.on1),'-','0') OR IF(m.on1 >= '0' ,'1','0')) +
                (IF(ISNULL(m.on2),'-','0') OR IF(m.on2 >= '0' ,'1','0')) +
                (IF(ISNULL(m.on3),'-','0') OR IF(m.on3 >= '0' ,'1','0')) +
                (IF(ISNULL(m.on4),'-','0') OR IF(m.on4 >= '0' ,'1','0')) +
                (IF(ISNULL(m.on5),'-','0') OR IF(m.on5 >= '0' ,'1','0')) +
                (IF(ISNULL(m.on6),'-','0') OR IF(m.on6 >= '0' ,'1','0')) +
                (IF(ISNULL(m.on7),'-','0') OR IF(m.on7 >= '0' ,'1','0')) +
                (IF(ISNULL(m.on8),'-','0') OR IF(m.on8 >= '0' ,'1','0')) +
                (IF(ISNULL(m.on9),'-','0') OR IF(m.on9 >= '0' ,'1','0')) 
                ) as total9,
                SUM(
                (IF(ISNULL(m.on1), '-',m.on1)) +
                (IF(ISNULL(m.on2), '-',m.on2)) +
                (IF(ISNULL(m.on3), '-',m.on3)) +
                (IF(ISNULL(m.on4), '-',m.on4)) +
                (IF(ISNULL(m.on5), '-',m.on5)) +
                (IF(ISNULL(m.on6), '-',m.on6)) +
                (IF(ISNULL(m.on7), '-',m.on7)) +
                (IF(ISNULL(m.on8), '-',m.on8)) +
                (IF(ISNULL(m.on9), '-',m.on9)) -
                (IF(ISNULL(m.on_huk), '-',m.on_huk))
                ) as amount9,
                m.na10, m.missing10, m.no10, m.lr1, m.lr2, m.lr3, m.lr4, m.lr5, m.lr6, m.lr7, m.lr8, m.lr9, m.lr_huk, 
                SUM(
                (IF(ISNULL(m.lr1),'-','0') OR IF(m.lr1 >= '0' ,'1','0')) +
                (IF(ISNULL(m.lr2),'-','0') OR IF(m.lr2 >= '0' ,'1','0')) +
                (IF(ISNULL(m.lr3),'-','0') OR IF(m.lr3 >= '0' ,'1','0')) +
                (IF(ISNULL(m.lr4),'-','0') OR IF(m.lr4 >= '0' ,'1','0')) +
                (IF(ISNULL(m.lr5),'-','0') OR IF(m.lr5 >= '0' ,'1','0')) +
                (IF(ISNULL(m.lr6),'-','0') OR IF(m.lr6 >= '0' ,'1','0')) +
                (IF(ISNULL(m.lr7),'-','0') OR IF(m.lr7 >= '0' ,'1','0')) +
                (IF(ISNULL(m.lr8),'-','0') OR IF(m.lr8 >= '0' ,'1','0')) +
                (IF(ISNULL(m.lr9),'-','0') OR IF(m.lr9 >= '0' ,'1','0')) 
                ) as total10,
                SUM(
                (IF(ISNULL(m.lr1), '-',m.lr1)) +
                (IF(ISNULL(m.lr2), '-',m.lr2)) +
                (IF(ISNULL(m.lr3), '-',m.lr3)) +
                (IF(ISNULL(m.lr4), '-',m.lr4)) +
                (IF(ISNULL(m.lr5), '-',m.lr5)) +
                (IF(ISNULL(m.lr6), '-',m.lr6)) +
                (IF(ISNULL(m.lr7), '-',m.lr7)) +
                (IF(ISNULL(m.lr8), '-',m.lr8)) +
                (IF(ISNULL(m.lr9), '-',m.lr9)) -
                (IF(ISNULL(m.lr_huk), '-',m.lr_huk))
                ) as amount10,
                m.na11, m.missing11, m.no11, m.rr1, m.rr2, m.rr3, m.rr4, m.rr5, m.rr6, m.rr7, m.rr8, m.rr9, m.rr_huk,
                SUM(
                (IF(ISNULL(m.rr1),'-','0') OR IF(m.rr1 >= '0' ,'1','0')) +
                (IF(ISNULL(m.rr2),'-','0') OR IF(m.rr2 >= '0' ,'1','0')) +
                (IF(ISNULL(m.rr3),'-','0') OR IF(m.rr3 >= '0' ,'1','0')) +
                (IF(ISNULL(m.rr4),'-','0') OR IF(m.rr4 >= '0' ,'1','0')) +
                (IF(ISNULL(m.rr5),'-','0') OR IF(m.rr5 >= '0' ,'1','0')) +
                (IF(ISNULL(m.rr6),'-','0') OR IF(m.rr6 >= '0' ,'1','0')) +
                (IF(ISNULL(m.rr7),'-','0') OR IF(m.rr7 >= '0' ,'1','0')) +
                (IF(ISNULL(m.rr8),'-','0') OR IF(m.rr8 >= '0' ,'1','0')) +
                (IF(ISNULL(m.rr9),'-','0') OR IF(m.rr9 >= '0' ,'1','0')) 
                ) as total11,
                SUM(
                (IF(ISNULL(m.rr1), '-',m.rr1)) +
                (IF(ISNULL(m.rr2), '-',m.rr2)) +
                (IF(ISNULL(m.rr3), '-',m.rr3)) +
                (IF(ISNULL(m.rr4), '-',m.rr4)) +
                (IF(ISNULL(m.rr5), '-',m.rr5)) +
                (IF(ISNULL(m.rr6), '-',m.rr6)) +
                (IF(ISNULL(m.rr7), '-',m.rr7)) +
                (IF(ISNULL(m.rr8), '-',m.rr8)) +
                (IF(ISNULL(m.rr9), '-',m.rr9)) -
                (IF(ISNULL(m.rr_huk), '-',m.rr_huk))
                ) as amount11,
                m.na12, m.missing12, m.no12, m.nn1, m.nn2, m.nn3, m.nn4, m.nn5, m.nn6, m.nn7, m.nn8, m.nn9, m.nn_huk ,
                SUM(
                (IF(ISNULL(m.nn1),'-','0') OR IF(m.nn1 >= '0' ,'1','0')) +
                (IF(ISNULL(m.nn2),'-','0') OR IF(m.nn2 >= '0' ,'1','0')) +
                (IF(ISNULL(m.nn3),'-','0') OR IF(m.nn3 >= '0' ,'1','0')) +
                (IF(ISNULL(m.nn4),'-','0') OR IF(m.nn4 >= '0' ,'1','0')) +
                (IF(ISNULL(m.nn5),'-','0') OR IF(m.nn5 >= '0' ,'1','0')) +
                (IF(ISNULL(m.nn6),'-','0') OR IF(m.nn6 >= '0' ,'1','0')) +
                (IF(ISNULL(m.nn7),'-','0') OR IF(m.nn7 >= '0' ,'1','0')) +
                (IF(ISNULL(m.nn8),'-','0') OR IF(m.nn8 >= '0' ,'1','0')) +
                (IF(ISNULL(m.nn9),'-','0') OR IF(m.nn9 >= '0' ,'1','0')) 
                ) as total12,
                SUM(
                (IF(ISNULL(m.nn1), '-',m.nn1)) +
                (IF(ISNULL(m.nn2), '-',m.nn2)) +
                (IF(ISNULL(m.nn3), '-',m.nn3)) +
                (IF(ISNULL(m.nn4), '-',m.nn4)) +
                (IF(ISNULL(m.nn5), '-',m.nn5)) +
                (IF(ISNULL(m.nn6), '-',m.nn6)) +
                (IF(ISNULL(m.nn7), '-',m.nn7)) +
                (IF(ISNULL(m.nn8), '-',m.nn8)) +
                (IF(ISNULL(m.nn9), '-',m.nn9)) -
                (IF(ISNULL(m.nn_huk), '-',m.nn_huk))
                ) as amount12
                FROM mra_ipd m
                INNER JOIN mra_departmetns_ipd d ON m.unit_id = d.unit_id
                LEFT JOIN hospitals h ON h.hospcode = m.hospcode
                WHERE m.date_audit BETWEEN '$date1' AND '$date2'
                AND m.unit_id = '$units'
                GROUP BY m.AN ) as k ) as s
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
                        'SetTitle' => ['MraIPD'],
                        //'SetHeader' => ['SAMPLE'],
                        'SetFooter' => ['{PAGENO}'],
                    ]
                ]);
        
                // return the pdf output as per the destination setting
                return $pdf->render();
                
            }
            
    public function actionPdf($id , $an) {
                // $data = Yii::$app->request->post();
                // $date1 =isset($data['date1'])  ? $data['date1'] : '';
                // $date2 =isset($data['date2'])  ? $data['date2'] : '';
                // $unit =isset($data['unit_id'])  ? $data['unit_id'] : '';
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
       SUM(s.a11) as s11,
       SUM(s.a12) as s12,
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
       SUM(s.t11) as f11,
       SUM(s.t12) as f12,
       ROUND(SUM(s.a1/s.t1) * 100,2) as p1,
       ROUND(SUM(s.a2/s.t2) * 100,2) as p2,
       ROUND(SUM(s.a3/s.t3) * 100,2) as p3,
       ROUND(SUM(s.a4/s.t4) * 100,2) as p4,
       ROUND(SUM(s.a5/s.t5) * 100,2) as p5,
       ROUND(SUM(s.a6/s.t6) * 100,2) as p6,
       ROUND(SUM(s.a7/s.t7) * 100,2) as p7,
       ROUND(SUM(s.a8/s.t8) * 100,2) as p8,
       ROUND(SUM(s.a9/s.t9) * 100,2) as p9,
       ROUND(SUM(s.a10/s.t10) * 100,2) as p10,
       ROUND(SUM(s.a11/s.t11) * 100,2) as p11,
       ROUND(SUM(s.a12/s.t12) * 100,2) as p12,
       SUM(a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8 +a9 +a10 + a11 + a12) as sum,
       SUM(t1 + t2 + t3 + t4 + t5 + t6 + t7 + t8 +t9 +t10 + t11 + t12) as full,
       ROUND((SUM(a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8 +a9 +a10 + a11 + a12) / SUM(t1 + t2 + t3 + t4 + t5 + t6 + t7 + t8 +t9 +t10 + t11 + t12)) * 100,2)  as percent
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
       SUM(k.total11) t11,
       SUM(k.amount11) a11,
       SUM(k.total12) t12,
       SUM(k.amount12) a12
       FROM (
       SELECT 
       m.hospcode,h.hosp_name, m.unit_id, d.unit_name,
       m.hn, m.an, m.date_admit, m.date_audit, m.date_discharge,
       m.na1, m.missing1, no1, m.dxop1, m.dxop2, m.dxop3, m.dxop4, m.dxop5, m.dxop6, m.dxop7, m.dxop8, m.dxop9, m.dxop_huk,
       SUM(
(IF(m.dxop1 = 'N','','1') OR IF(m.dxop1 = '0','1','0')OR IF(m.dxop1 = '1','1','')) + 
(IF(m.dxop2 = 'N','','1') OR IF(m.dxop2 = '0','1','0')OR IF(m.dxop2 = '1','1','')) + 
(IF(m.dxop3 = 'N','','1') OR IF(m.dxop3 = '0','1','0')OR IF(m.dxop3 = '1','1','')) + 
(IF(m.dxop4 = 'N','','1') OR IF(m.dxop4 = '0','1','0')OR IF(m.dxop4 = '1','1','')) + 
(IF(m.dxop5 = 'N','','1') OR IF(m.dxop5 = '0','1','0')OR IF(m.dxop5 = '1','1','')) + 
(IF(m.dxop6 = 'N','','1') OR IF(m.dxop6 = '0','1','0')OR IF(m.dxop6 = '1','1','')) + 
(IF(m.dxop7 = 'N','','1') OR IF(m.dxop7 = '0','1','0')OR IF(m.dxop7 = '1','1','')) + 
(IF(m.dxop8 = 'N','','1') OR IF(m.dxop8 = '0','1','0')OR IF(m.dxop8 = '1','1','')) + 
(IF(m.dxop9 = 'N','','1') OR IF(m.dxop9 = '0','1','0')OR IF(m.dxop1 = '1','1','')) ) as total1,
SUM((m.dxop1 + m.dxop2 + m.dxop3 + m.dxop4 + m.dxop5 + m.dxop6 + m.dxop7+ m.dxop8+ m.dxop9) - m.dxop_huk) as amount1,
m.na2, m.missing2,m.no2, m.other1, m.other2, m.other3, m.other4, m.other5, m.other6, m.other7, m.other8, m.other9, m.other_huk,
SUM(
(IF(m.other1 = 'N','','1') OR IF(m.other1 = '0','1','0')OR IF(m.other1 = '1','1','')) + 
(IF(m.other2 = 'N','','1') OR IF(m.other2 = '0','1','0')OR IF(m.other2 = '1','1','')) + 
(IF(m.other3 = 'N','','1') OR IF(m.other3 = '0','1','0')OR IF(m.other3 = '1','1','')) + 
(IF(m.other4 = 'N','','1') OR IF(m.other4 = '0','1','0')OR IF(m.other4 = '1','1','')) + 
(IF(m.other5 = 'N','','1') OR IF(m.other5 = '0','1','0')OR IF(m.other5 = '1','1','')) + 
(IF(m.other6 = 'N','','1') OR IF(m.other6 = '0','1','0')OR IF(m.other6 = '1','1','')) + 
(IF(m.other7 = 'N','','1') OR IF(m.other7 = '0','1','0')OR IF(m.other7 = '1','1','')) + 
(IF(m.other8 = 'N','','1') OR IF(m.other8 = '0','1','0')OR IF(m.other8 = '1','1','')) + 
(IF(m.other9 = 'N','','1') OR IF(m.other9 = '0','1','0')OR IF(m.other9 = '1','1','')) ) as total2,
SUM(m.other1 + m.other2 + m.other3+ m.other4 + m.other5 + m.other6+ m.other7 + m.other8 + m.other9 - m.other_huk) as amount2,
m.na3, m.missing3, m.no3, m.infc1, m.infc2, m.infc3, m.infc4, m.infc5, m.infc6, m.infc7, m.infc8, m.infc9, m.infc_huk,
SUM(
(IF(m.infc1 = 'N','','1') OR IF(m.infc1 = '0','1','0')OR IF(m.infc1 = '1','1','')) + 
(IF(m.infc2 = 'N','','1') OR IF(m.infc2 = '0','1','0')OR IF(m.infc2 = '1','1','')) + 
(IF(m.infc3 = 'N','','1') OR IF(m.infc3 = '0','1','0')OR IF(m.infc3 = '1','1','')) +  
(IF(m.infc4 = 'N','','1') OR IF(m.infc4 = '0','1','0')OR IF(m.infc4 = '1','1','')) + 
(IF(m.infc5 = 'N','','1') OR IF(m.infc5 = '0','1','0')OR IF(m.infc5 = '1','1','')) + 
(IF(m.infc6 = 'N','','1') OR IF(m.infc6 = '0','1','0')OR IF(m.infc6 = '1','1','')) + 
(IF(m.infc7 = 'N','','1') OR IF(m.infc7 = '0','1','0')OR IF(m.infc7 = '1','1','')) + 
(IF(m.infc8 = 'N','','1') OR IF(m.infc8 = '0','1','0')OR IF(m.infc8 = '1','1','')) + 
(IF(m.infc9 = 'N','','1') OR IF(m.infc9 = '0','1','0')OR IF(m.infc9 = '1','1','')) ) total3,
SUM(m.infc1 + m.infc2+ m.infc3 + m.infc4+ m.infc5 + m.infc6 + m.infc7 + m.infc8 + m.infc9 - m.infc_huk) as amount3,
m.na4, m.missing4, m.no4, m.hist1, m.hist2, m.hist3, m.hist4, m.hist5, m.hist6, m.hist7, m.hist8, m.hist9, m.hist_huk,
SUM(
(IF(m.hist1 = 'N','','1') OR IF(m.hist1 = '0','1','0')OR IF(m.hist1 = '1','1','')) + 
(IF(m.hist2 = 'N','','1') OR IF(m.hist2 = '0','1','0')OR IF(m.hist2 = '1','1','')) + 
(IF(m.hist3 = 'N','','1') OR IF(m.hist3 = '0','1','0')OR IF(m.hist3 = '1','1','')) + 
(IF(m.hist4 = 'N','','1') OR IF(m.hist4 = '0','1','0')OR IF(m.hist4 = '1','1','')) + 
(IF(m.hist5 = 'N','','1') OR IF(m.hist5 = '0','1','0')OR IF(m.hist5 = '1','1','')) + 
(IF(m.hist6 = 'N','','1') OR IF(m.hist6 = '0','1','0')OR IF(m.hist6 = '1','1','')) + 
(IF(m.hist7 = 'N','','1') OR IF(m.hist7 = '0','1','0')OR IF(m.hist7 = '1','1','')) + 
(IF(m.hist8 = 'N','','1') OR IF(m.hist8 = '0','1','0')OR IF(m.hist8 = '1','1','')) + 
(IF(m.hist9 = 'N','','1') OR IF(m.hist9 = '0','1','0')OR IF(m.hist9 = '1','1','')) ) as total4,
SUM(m.hist1 + m.hist2 + m.hist3 + m.hist4 + m.hist5 + m.hist6 + m.hist7 + m.hist8 + m.hist9 - m.hist_huk) as amount4,
m.na5, m.missing5, m.no5, m.pe1, m.pe2, m.pe3, m.pe4, m.pe5, m.pe6, m.pe7, m.pe8, m.pe9, m.pe_huk, 
SUM(
(IF(m.pe1 = 'N','','1') OR IF(m.pe1 = '0','1','0')OR IF(m.pe1 = '1','1','')) + 
(IF(m.pe2 = 'N','','1') OR IF(m.pe2 = '0','1','0')OR IF(m.pe2 = '1','1','')) + 
(IF(m.pe3 = 'N','','1') OR IF(m.pe3 = '0','1','0')OR IF(m.pe3 = '1','1','')) + 
(IF(m.pe4 = 'N','','1') OR IF(m.pe4 = '0','1','0')OR IF(m.pe4 = '1','1','')) + 
(IF(m.pe5 = 'N','','1') OR IF(m.pe5 = '0','1','0')OR IF(m.pe5 = '1','1','')) + 
(IF(m.pe6 = 'N','','1') OR IF(m.pe6 = '0','1','0')OR IF(m.pe6 = '1','1','')) + 
(IF(m.pe7 = 'N','','1') OR IF(m.pe7 = '0','1','0')OR IF(m.pe7 = '1','1','')) + 
(IF(m.pe8 = 'N','','1') OR IF(m.pe8 = '0','1','0')OR IF(m.pe8 = '1','1','')) + 
(IF(m.pe9 = 'N','','1') OR IF(m.pe9 = '0','1','0')OR IF(m.pe9 = '1','1','')))  as total5,
SUM(m.pe1 + m.pe2 + m.pe3 + m.pe4 + m.pe5 + m.pe6 + m.pe7 + m.pe8 + m.pe9 - m.pe_huk) as amount5,
m.na6, m.missing6, m.no6, m.pn1, m.pn2, m.pn3, m.pn4, m.pn5, m.pn6, m.pn7, m.pn8, m.pn9 , m.pn_huk,
SUM(
(IF(m.pn1 = 'N','','1') OR IF(m.pn1 = '0','1','0')OR IF(m.pn1 = '1','1','')) + 
(IF(m.pn2 = 'N','','1') OR IF(m.pn2 = '0','1','0')OR IF(m.pn2 = '1','1','')) +  
(IF(m.pn3 = 'N','','1') OR IF(m.pn3 = '0','1','0')OR IF(m.pn3 = '1','1','')) + 
(IF(m.pn4 = 'N','','1') OR IF(m.pn4 = '0','1','0')OR IF(m.pn4 = '1','1','')) + 
(IF(m.pn5 = 'N','','1') OR IF(m.pn5 = '0','1','0')OR IF(m.pn5 = '1','1','')) +  
(IF(m.pn6 = 'N','','1') OR IF(m.pn6 = '0','1','0')OR IF(m.pn6 = '1','1','')) + 
(IF(m.pn7 = 'N','','1') OR IF(m.pn7 = '0','1','0')OR IF(m.pn7 = '1','1','')) +  
(IF(m.pn8 = 'N','','1') OR IF(m.pn8 = '0','1','0')OR IF(m.pn8 = '1','1','')) + 
(IF(m.pn9 = 'N','','1') OR IF(m.pn9 = '0','1','0')OR IF(m.pn9 = '1','1','')) ) as total6,
SUM(m.pn1 + m.pn2 + m.pn3 + m.pn4 + m.pn5 + m.pn6 + m.pn7 + m.pn8 + m.pn9 - m.pn_huk) as amount6,
m.na7, m.missing7, m.no7, m.cr1, m.cr2, m.cr3, m.cr4, m.cr5, m.cr6, m.cr7, m.cr8, m.cr9, m.cr_huk,
SUM(
(IF(ISNULL(m.cr1),'-','0') OR IF(m.cr1 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr2),'-','0') OR IF(m.cr2 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr3),'-','0') OR IF(m.cr3 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr4),'-','0') OR IF(m.cr4 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr5),'-','0') OR IF(m.cr5 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr6),'-','0') OR IF(m.cr6 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr7),'-','0') OR IF(m.cr7 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr8),'-','0') OR IF(m.cr8 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr9),'-','0') OR IF(m.cr9 >= '0' ,'1','0')) 
) as total7,
SUM(
(IF(ISNULL(m.cr1), '-',m.cr1)) +
(IF(ISNULL(m.cr2), '-',m.cr2)) +
(IF(ISNULL(m.cr3), '-',m.cr3)) +
(IF(ISNULL(m.cr4), '-',m.cr4)) +
(IF(ISNULL(m.cr5), '-',m.cr5)) +
(IF(ISNULL(m.cr6), '-',m.cr6)) +
(IF(ISNULL(m.cr7), '-',m.cr7)) +
(IF(ISNULL(m.cr8), '-',m.cr8)) +
(IF(ISNULL(m.cr9), '-',m.cr9)) -
(IF(ISNULL(m.cr_huk), '-',m.cr_huk))
) as amount7,
m.na8, m.missing8, m.no8, m.ar1, m.ar2, m.ar3, m.ar4, m.ar5, m.ar6, m.ar7, m.ar8, m.ar9, m.ar_huk,
SUM(
(IF(ISNULL(m.ar1),'-','0') OR IF(m.ar1 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar2),'-','0') OR IF(m.ar2 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar3),'-','0') OR IF(m.ar3 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar4),'-','0') OR IF(m.ar4 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar5),'-','0') OR IF(m.ar5 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar6),'-','0') OR IF(m.ar6 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar7),'-','0') OR IF(m.ar7 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar8),'-','0') OR IF(m.ar8 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar9),'-','0') OR IF(m.ar9 >= '0' ,'1','0')) 
) as total8,
SUM(
(IF(ISNULL(m.ar1), '-',m.ar1)) +
(IF(ISNULL(m.ar2), '-',m.ar2)) +
(IF(ISNULL(m.ar3), '-',m.ar3)) +
(IF(ISNULL(m.ar4), '-',m.ar4)) +
(IF(ISNULL(m.ar5), '-',m.ar5)) +
(IF(ISNULL(m.ar6), '-',m.ar6)) +
(IF(ISNULL(m.ar7), '-',m.ar7)) +
(IF(ISNULL(m.ar8), '-',m.ar8)) +
(IF(ISNULL(m.ar9), '-',m.ar9)) -
(IF(ISNULL(m.ar_huk), '-',m.ar_huk))
) as amount8,
m.na9, m.missing9, m.no9, m.on1, m.on2, m.on3, m.on4, m.on5, m.on6, m.on7, m.on8, m.on9, m.on_huk,
SUM(
(IF(ISNULL(m.on1),'-','0') OR IF(m.on1 >= '0' ,'1','0')) +
(IF(ISNULL(m.on2),'-','0') OR IF(m.on2 >= '0' ,'1','0')) +
(IF(ISNULL(m.on3),'-','0') OR IF(m.on3 >= '0' ,'1','0')) +
(IF(ISNULL(m.on4),'-','0') OR IF(m.on4 >= '0' ,'1','0')) +
(IF(ISNULL(m.on5),'-','0') OR IF(m.on5 >= '0' ,'1','0')) +
(IF(ISNULL(m.on6),'-','0') OR IF(m.on6 >= '0' ,'1','0')) +
(IF(ISNULL(m.on7),'-','0') OR IF(m.on7 >= '0' ,'1','0')) +
(IF(ISNULL(m.on8),'-','0') OR IF(m.on8 >= '0' ,'1','0')) +
(IF(ISNULL(m.on9),'-','0') OR IF(m.on9 >= '0' ,'1','0')) 
) as total9,
SUM(
(IF(ISNULL(m.on1), '-',m.on1)) +
(IF(ISNULL(m.on2), '-',m.on2)) +
(IF(ISNULL(m.on3), '-',m.on3)) +
(IF(ISNULL(m.on4), '-',m.on4)) +
(IF(ISNULL(m.on5), '-',m.on5)) +
(IF(ISNULL(m.on6), '-',m.on6)) +
(IF(ISNULL(m.on7), '-',m.on7)) +
(IF(ISNULL(m.on8), '-',m.on8)) +
(IF(ISNULL(m.on9), '-',m.on9)) -
(IF(ISNULL(m.on_huk), '-',m.on_huk))
) as amount9,
m.na10, m.missing10, m.no10, m.lr1, m.lr2, m.lr3, m.lr4, m.lr5, m.lr6, m.lr7, m.lr8, m.lr9, m.lr_huk, 
SUM(
(IF(ISNULL(m.lr1),'-','0') OR IF(m.lr1 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr2),'-','0') OR IF(m.lr2 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr3),'-','0') OR IF(m.lr3 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr4),'-','0') OR IF(m.lr4 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr5),'-','0') OR IF(m.lr5 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr6),'-','0') OR IF(m.lr6 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr7),'-','0') OR IF(m.lr7 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr8),'-','0') OR IF(m.lr8 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr9),'-','0') OR IF(m.lr9 >= '0' ,'1','0')) 
) as total10,
SUM(
(IF(ISNULL(m.lr1), '-',m.lr1)) +
(IF(ISNULL(m.lr2), '-',m.lr2)) +
(IF(ISNULL(m.lr3), '-',m.lr3)) +
(IF(ISNULL(m.lr4), '-',m.lr4)) +
(IF(ISNULL(m.lr5), '-',m.lr5)) +
(IF(ISNULL(m.lr6), '-',m.lr6)) +
(IF(ISNULL(m.lr7), '-',m.lr7)) +
(IF(ISNULL(m.lr8), '-',m.lr8)) +
(IF(ISNULL(m.lr9), '-',m.lr9)) -
(IF(ISNULL(m.lr_huk), '-',m.lr_huk))
) as amount10,
m.na11, m.missing11, m.no11, m.rr1, m.rr2, m.rr3, m.rr4, m.rr5, m.rr6, m.rr7, m.rr8, m.rr9, m.rr_huk,
SUM(
(IF(ISNULL(m.rr1),'-','0') OR IF(m.rr1 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr2),'-','0') OR IF(m.rr2 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr3),'-','0') OR IF(m.rr3 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr4),'-','0') OR IF(m.rr4 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr5),'-','0') OR IF(m.rr5 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr6),'-','0') OR IF(m.rr6 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr7),'-','0') OR IF(m.rr7 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr8),'-','0') OR IF(m.rr8 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr9),'-','0') OR IF(m.rr9 >= '0' ,'1','0')) 
) as total11,
SUM(
(IF(ISNULL(m.rr1), '-',m.rr1)) +
(IF(ISNULL(m.rr2), '-',m.rr2)) +
(IF(ISNULL(m.rr3), '-',m.rr3)) +
(IF(ISNULL(m.rr4), '-',m.rr4)) +
(IF(ISNULL(m.rr5), '-',m.rr5)) +
(IF(ISNULL(m.rr6), '-',m.rr6)) +
(IF(ISNULL(m.rr7), '-',m.rr7)) +
(IF(ISNULL(m.rr8), '-',m.rr8)) +
(IF(ISNULL(m.rr9), '-',m.rr9)) -
(IF(ISNULL(m.rr_huk), '-',m.rr_huk))) as amount11,
m.na12, m.missing12, m.no12, m.nn1, m.nn2, m.nn3, m.nn4, m.nn5, m.nn6, m.nn7, m.nn8, m.nn9, m.nn_huk ,
SUM(
(IF(ISNULL(m.nn1),'-','0') OR IF(m.nn1 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn2),'-','0') OR IF(m.nn2 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn3),'-','0') OR IF(m.nn3 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn4),'-','0') OR IF(m.nn4 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn5),'-','0') OR IF(m.nn5 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn6),'-','0') OR IF(m.nn6 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn7),'-','0') OR IF(m.nn7 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn8),'-','0') OR IF(m.nn8 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn9),'-','0') OR IF(m.nn9 >= '0' ,'1','0')))  as total12,
SUM(
(IF(ISNULL(m.nn1), '-',m.nn1)) +
(IF(ISNULL(m.nn2), '-',m.nn2)) +
(IF(ISNULL(m.nn3), '-',m.nn3)) +
(IF(ISNULL(m.nn4), '-',m.nn4)) +
(IF(ISNULL(m.nn5), '-',m.nn5)) +
(IF(ISNULL(m.nn6), '-',m.nn6)) +
(IF(ISNULL(m.nn7), '-',m.nn7)) +
(IF(ISNULL(m.nn8), '-',m.nn8)) +
(IF(ISNULL(m.nn9), '-',m.nn9)) -
(IF(ISNULL(m.nn_huk), '-',m.nn_huk))) as amount12
       FROM mra_ipd m
       INNER JOIN mra_departmetns_ipd d ON m.unit_id = d.unit_id
       LEFT JOIN hospitals h ON h.hospcode = m.hospcode
       WHERE  m.mra_id = '$id'
       AND m.an = '$an'
       GROUP BY m.AN ) as k ) as s
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
               
               return $this->render('hn_pdf', [
                           'model' => $this->findModel($id),
                           //'model' => $this->findModel($AN),
                          // 'searchModel' => $searchModel,
                           'dataProvider' => $dataProvider,
                           'sql'=>$sql,
                       ]);   
                   }      
    public function actionMrasum($id , $an) {
    $sql = "SELECT 
    d.unit_name,
m.hn, m.an, m.date_admit, m.date_audit, m.date_discharge, o .overall_name, f.finding_name , m.visits, m.note,
m.na1, m.missing1, no1, m.dxop1, m.dxop2, m.dxop3, m.dxop4, m.dxop5, m.dxop6, m.dxop7, m.dxop8, m.dxop9, m.dxop_huk,
SUM((IF(m.dxop1 = 'N','','1') OR IF(m.dxop1 = '0','1','0')) + 
(IF(m.dxop2 = 'N','','1') OR IF(m.dxop2 = '0','1','0')) +
(IF(m.dxop3 = 'N','','1') OR IF(m.dxop3 = '0','1','0')) +
(IF(m.dxop4 = 'N','','1') OR IF(m.dxop4 = '0','1','0')) +
(IF(m.dxop5 = 'N','','1') OR IF(m.dxop5 = '0','1','0')) +
(IF(m.dxop6 = 'N','','1') OR IF(m.dxop6 = '0','1','0')) +
(IF(m.dxop7 = 'N','','1') OR IF(m.dxop7 = '0','1','0')) +
(IF(m.dxop8 = 'N','','1') OR IF(m.dxop8 = '0','1','0')) +
(IF(m.dxop9 = 'N','','1') OR IF(m.dxop9 = '0','1','0'))) as total1,
SUM((m.dxop1 + m.dxop2 + m.dxop3 + m.dxop4 + m.dxop5 + m.dxop6 + m.dxop7+ m.dxop8+ m.dxop9) - m.dxop_huk) as amount1,
m.na2, m.missing2,m.no2, m.other1, m.other2, m.other3, m.other4, m.other5, m.other6, m.other7, m.other8, m.other9, m.other_huk,
SUM((IF(m.other1 = 'N','','1') OR IF(m.other1 = '0','1','0')) + 
(IF(m.other2 = 'N','','1') OR IF(m.other2 = '0','1','0')) +
(IF(m.other3 = 'N','','1') OR IF(m.other3 = '0','1','0')) +
(IF(m.other4 = 'N','','1') OR IF(m.other4 = '0','1','0')) +
(IF(m.other5 = 'N','','1') OR IF(m.other5= '0','1','0')) +
(IF(m.other6 = 'N','','1') OR IF(m.other6= '0','1','0')) +
(IF(m.other7 = 'N','','1') OR IF(m.other7= '0','1','0')) +
(IF(m.other8 = 'N','','1') OR IF(m.other8= '0','1','0')) +
(IF(m.other9 = 'N','','1') OR IF(m.other9= '0','1','0')) 
) as total2,
SUM(m.other1 + m.other2 + m.other3+ m.other4 + m.other5 + m.other6+ m.other7 + m.other8 + m.other9 - m.other_huk) as amount2,
m.na3, m.missing3, m.no3, m.infc1, m.infc2, m.infc3, m.infc4, m.infc5, m.infc6, m.infc7, m.infc8, m.infc9, m.infc_huk,
SUM(
(IF(m.infc1 = 'N','','1') OR IF(m.infc1 = '0','1','0')) + 
(IF(m.infc2 = 'N','','1') OR IF(m.infc2 = '0','1','0')) + 
(IF(m.infc3 = 'N','','1') OR IF(m.infc3 = '0','1','0')) + 
(IF(m.infc4 = 'N','','1') OR IF(m.infc4 = '0','1','0')) + 
(IF(m.infc5 = 'N','','1') OR IF(m.infc5 = '0','1','0')) + 
(IF(m.infc6 = 'N','','1') OR IF(m.infc6 = '0','1','0')) + 
(IF(m.infc7 = 'N','','1') OR IF(m.infc7 = '0','1','0')) + 
(IF(m.infc8 = 'N','','1') OR IF(m.infc8 = '0','1','0')) + 
(IF(m.infc9 = 'N','','1') OR IF(m.infc9 = '0','1','0'))  
) total3,
SUM(m.infc1 + m.infc2+ m.infc3 + m.infc4+ m.infc5 + m.infc6 + m.infc7 + m.infc8 + m.infc9 - m.infc_huk) as amount3,
m.na4, m.missing4, m.no4, m.hist1, m.hist2, m.hist3, m.hist4, m.hist5, m.hist6, m.hist7, m.hist8, m.hist9, m.hist_huk,
SUM(
(IF(m.hist1 = 'N','','1') OR IF(m.hist1 = '0','1','0')) + 
(IF(m.hist2 = 'N','','1') OR IF(m.hist2 = '0','1','0')) + 
(IF(m.hist3 = 'N','','1') OR IF(m.hist3 = '0','1','0')) + 
(IF(m.hist4 = 'N','','1') OR IF(m.hist4 = '0','1','0')) + 
(IF(m.hist5 = 'N','','1') OR IF(m.hist5 = '0','1','0')) + 
(IF(m.hist6 = 'N','','1') OR IF(m.hist6 = '0','1','0')) + 
(IF(m.hist7 = 'N','','1') OR IF(m.hist7 = '0','1','0')) + 
(IF(m.hist8 = 'N','','1') OR IF(m.hist8 = '0','1','0')) + 
(IF(m.hist9 = 'N','','1') OR IF(m.hist9 = '0','1','0'))  
) as total4,
SUM(m.hist1 + m.hist2 + m.hist3 + m.hist4 + m.hist5 + m.hist6 + m.hist7 + m.hist8 + m.hist9 - m.hist_huk) as amount4,
m.na5, m.missing5, m.no5, m.pe1, m.pe2, m.pe3, m.pe4, m.pe5, m.pe6, m.pe7, m.pe8, m.pe9, m.pe_huk, 
SUM(
(IF(m.pe1 = 'N','','1') OR IF(m.pe1 = '0','1','0')) + 
(IF(m.pe2 = 'N','','1') OR IF(m.pe2 = '0','1','0')) + 
(IF(m.pe3 = 'N','','1') OR IF(m.pe3 = '0','1','0')) + 
(IF(m.pe4 = 'N','','1') OR IF(m.pe4 = '0','1','0')) + 
(IF(m.pe5 = 'N','','1') OR IF(m.pe5 = '0','1','0')) + 
(IF(m.pe6 = 'N','','1') OR IF(m.pe6 = '0','1','0')) + 
(IF(m.pe7 = 'N','','1') OR IF(m.pe7 = '0','1','0')) + 
(IF(m.pe8 = 'N','','1') OR IF(m.pe8 = '0','1','0')) + 
(IF(m.pe9 = 'N','','1') OR IF(m.pe9 = '0','1','0')) 
)  as total5,
SUM(m.pe1 + m.pe2 + m.pe3 + m.pe4 + m.pe5 + m.pe6 + m.pe7 + m.pe8 + m.pe9 - m.pe_huk) as amount5,
m.na6, m.missing6, m.no6, m.pn1, m.pn2, m.pn3, m.pn4, m.pn5, m.pn6, m.pn7, m.pn8, m.pn9 , m.pn_huk,
SUM(
(IF(m.pn1 = 'N','','1') OR IF(m.pn1 = '0','1','0')) + 
(IF(m.pn2 = 'N','','1') OR IF(m.pn2 = '0','1','0')) + 
(IF(m.pn3 = 'N','','1') OR IF(m.pn3 = '0','1','0')) + 
(IF(m.pn4 = 'N','','1') OR IF(m.pn4 = '0','1','0')) + 
(IF(m.pn5 = 'N','','1') OR IF(m.pn5 = '0','1','0')) + 
(IF(m.pn6 = 'N','','1') OR IF(m.pn6 = '0','1','0')) + 
(IF(m.pn7 = 'N','','1') OR IF(m.pn7 = '0','1','0')) + 
(IF(m.pn8 = 'N','','1') OR IF(m.pn8 = '0','1','0')) + 
(IF(m.pn9 = 'N','','1') OR IF(m.pn9 = '0','1','0')) 
 ) as total6,
SUM(m.pn1 + m.pn2 + m.pn3 + m.pn4 + m.pn5 + m.pn6 + m.pn7 + m.pn8 + m.pn9 - m.pn_huk) as amount6,
m.na7, m.missing7, m.no7, m.cr1, m.cr2, m.cr3, m.cr4, m.cr5, m.cr6, m.cr7, m.cr8, m.cr9, m.cr_huk,
SUM(
(IF(ISNULL(m.cr1),'-','0') OR IF(m.cr1 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr2),'-','0') OR IF(m.cr2 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr3),'-','0') OR IF(m.cr3 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr4),'-','0') OR IF(m.cr4 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr5),'-','0') OR IF(m.cr5 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr6),'-','0') OR IF(m.cr6 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr7),'-','0') OR IF(m.cr7 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr8),'-','0') OR IF(m.cr8 >= '0' ,'1','0')) +
(IF(ISNULL(m.cr9),'-','0') OR IF(m.cr9 >= '0' ,'1','0')) 
) as total7,
SUM(
(IF(ISNULL(m.cr1), '-',m.cr1)) +
(IF(ISNULL(m.cr2), '-',m.cr2)) +
(IF(ISNULL(m.cr3), '-',m.cr3)) +
(IF(ISNULL(m.cr4), '-',m.cr4)) +
(IF(ISNULL(m.cr5), '-',m.cr5)) +
(IF(ISNULL(m.cr6), '-',m.cr6)) +
(IF(ISNULL(m.cr7), '-',m.cr7)) +
(IF(ISNULL(m.cr8), '-',m.cr8)) +
(IF(ISNULL(m.cr9), '-',m.cr9)) -
(IF(ISNULL(m.cr_huk), '-',m.cr_huk))
) as amount7,
m.na8, m.missing8, m.no8, m.ar1, m.ar2, m.ar3, m.ar4, m.ar5, m.ar6, m.ar7, m.ar8, m.ar9, m.ar_huk,
SUM(
(IF(ISNULL(m.ar1),'-','0') OR IF(m.ar1 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar2),'-','0') OR IF(m.ar2 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar3),'-','0') OR IF(m.ar3 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar4),'-','0') OR IF(m.ar4 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar5),'-','0') OR IF(m.ar5 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar6),'-','0') OR IF(m.ar6 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar7),'-','0') OR IF(m.ar7 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar8),'-','0') OR IF(m.ar8 >= '0' ,'1','0')) +
(IF(ISNULL(m.ar9),'-','0') OR IF(m.ar9 >= '0' ,'1','0')) 
) as total8,
SUM(
(IF(ISNULL(m.ar1), '-',m.ar1)) +
(IF(ISNULL(m.ar2), '-',m.ar2)) +
(IF(ISNULL(m.ar3), '-',m.ar3)) +
(IF(ISNULL(m.ar4), '-',m.ar4)) +
(IF(ISNULL(m.ar5), '-',m.ar5)) +
(IF(ISNULL(m.ar6), '-',m.ar6)) +
(IF(ISNULL(m.ar7), '-',m.ar7)) +
(IF(ISNULL(m.ar8), '-',m.ar8)) +
(IF(ISNULL(m.ar9), '-',m.ar9)) -
(IF(ISNULL(m.ar_huk), '-',m.ar_huk))
) as amount8,
m.na9, m.missing9, m.no9, m.on1, m.on2, m.on3, m.on4, m.on5, m.on6, m.on7, m.on8, m.on9, m.on_huk,
SUM(
(IF(ISNULL(m.on1),'-','0') OR IF(m.on1 >= '0' ,'1','0')) +
(IF(ISNULL(m.on2),'-','0') OR IF(m.on2 >= '0' ,'1','0')) +
(IF(ISNULL(m.on3),'-','0') OR IF(m.on3 >= '0' ,'1','0')) +
(IF(ISNULL(m.on4),'-','0') OR IF(m.on4 >= '0' ,'1','0')) +
(IF(ISNULL(m.on5),'-','0') OR IF(m.on5 >= '0' ,'1','0')) +
(IF(ISNULL(m.on6),'-','0') OR IF(m.on6 >= '0' ,'1','0')) +
(IF(ISNULL(m.on7),'-','0') OR IF(m.on7 >= '0' ,'1','0')) +
(IF(ISNULL(m.on8),'-','0') OR IF(m.on8 >= '0' ,'1','0')) +
(IF(ISNULL(m.on9),'-','0') OR IF(m.on9 >= '0' ,'1','0')) 
) as total9,
SUM(
(IF(ISNULL(m.on1), '-',m.on1)) +
(IF(ISNULL(m.on2), '-',m.on2)) +
(IF(ISNULL(m.on3), '-',m.on3)) +
(IF(ISNULL(m.on4), '-',m.on4)) +
(IF(ISNULL(m.on5), '-',m.on5)) +
(IF(ISNULL(m.on6), '-',m.on6)) +
(IF(ISNULL(m.on7), '-',m.on7)) +
(IF(ISNULL(m.on8), '-',m.on8)) +
(IF(ISNULL(m.on9), '-',m.on9)) -
(IF(ISNULL(m.on_huk), '-',m.on_huk))
) as amount9,
m.na10, m.missing10, m.no10, m.lr1, m.lr2, m.lr3, m.lr4, m.lr5, m.lr6, m.lr7, m.lr8, m.lr9, m.lr_huk, 
SUM(
(IF(ISNULL(m.lr1),'-','0') OR IF(m.lr1 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr2),'-','0') OR IF(m.lr2 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr3),'-','0') OR IF(m.lr3 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr4),'-','0') OR IF(m.lr4 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr5),'-','0') OR IF(m.lr5 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr6),'-','0') OR IF(m.lr6 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr7),'-','0') OR IF(m.lr7 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr8),'-','0') OR IF(m.lr8 >= '0' ,'1','0')) +
(IF(ISNULL(m.lr9),'-','0') OR IF(m.lr9 >= '0' ,'1','0')) 
) as total10,
SUM(
(IF(ISNULL(m.lr1), '-',m.lr1)) +
(IF(ISNULL(m.lr2), '-',m.lr2)) +
(IF(ISNULL(m.lr3), '-',m.lr3)) +
(IF(ISNULL(m.lr4), '-',m.lr4)) +
(IF(ISNULL(m.lr5), '-',m.lr5)) +
(IF(ISNULL(m.lr6), '-',m.lr6)) +
(IF(ISNULL(m.lr7), '-',m.lr7)) +
(IF(ISNULL(m.lr8), '-',m.lr8)) +
(IF(ISNULL(m.lr9), '-',m.lr9)) -
(IF(ISNULL(m.lr_huk), '-',m.lr_huk))
) as amount10,
m.na11, m.missing11, m.no11, m.rr1, m.rr2, m.rr3, m.rr4, m.rr5, m.rr6, m.rr7, m.rr8, m.rr9, m.rr_huk,
SUM(
(IF(ISNULL(m.rr1),'-','0') OR IF(m.rr1 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr2),'-','0') OR IF(m.rr2 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr3),'-','0') OR IF(m.rr3 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr4),'-','0') OR IF(m.rr4 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr5),'-','0') OR IF(m.rr5 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr6),'-','0') OR IF(m.rr6 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr7),'-','0') OR IF(m.rr7 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr8),'-','0') OR IF(m.rr8 >= '0' ,'1','0')) +
(IF(ISNULL(m.rr9),'-','0') OR IF(m.rr9 >= '0' ,'1','0')) 
) as total11,
SUM(
(IF(ISNULL(m.rr1), '-',m.rr1)) +
(IF(ISNULL(m.rr2), '-',m.rr2)) +
(IF(ISNULL(m.rr3), '-',m.rr3)) +
(IF(ISNULL(m.rr4), '-',m.rr4)) +
(IF(ISNULL(m.rr5), '-',m.rr5)) +
(IF(ISNULL(m.rr6), '-',m.rr6)) +
(IF(ISNULL(m.rr7), '-',m.rr7)) +
(IF(ISNULL(m.rr8), '-',m.rr8)) +
(IF(ISNULL(m.rr9), '-',m.rr9)) -
(IF(ISNULL(m.rr_huk), '-',m.rr_huk))
) as amount11,
m.na12, m.missing12, m.no12, m.nn1, m.nn2, m.nn3, m.nn4, m.nn5, m.nn6, m.nn7, m.nn8, m.nn9, m.nn_huk ,
SUM(
(IF(ISNULL(m.nn1),'-','0') OR IF(m.nn1 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn2),'-','0') OR IF(m.nn2 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn3),'-','0') OR IF(m.nn3 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn4),'-','0') OR IF(m.nn4 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn5),'-','0') OR IF(m.nn5 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn6),'-','0') OR IF(m.nn6 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn7),'-','0') OR IF(m.nn7 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn8),'-','0') OR IF(m.nn8 >= '0' ,'1','0')) +
(IF(ISNULL(m.nn9),'-','0') OR IF(m.nn9 >= '0' ,'1','0')) 
) as total12,
SUM(
(IF(ISNULL(m.nn1), '-',m.nn1)) +
(IF(ISNULL(m.nn2), '-',m.nn2)) +
(IF(ISNULL(m.nn3), '-',m.nn3)) +
(IF(ISNULL(m.nn4), '-',m.nn4)) +
(IF(ISNULL(m.nn5), '-',m.nn5)) +
(IF(ISNULL(m.nn6), '-',m.nn6)) +
(IF(ISNULL(m.nn7), '-',m.nn7)) +
(IF(ISNULL(m.nn8), '-',m.nn8)) +
(IF(ISNULL(m.nn9), '-',m.nn9)) -
(IF(ISNULL(m.nn_huk), '-',m.nn_huk))
) as amount12
    FROM mra_ipd m
    INNER JOIN mra_departmetns_ipd d ON m.unit_id = d.unit_id
    INNER JOIN mra_overall o ON o.overall_id = m.overall_id
    LEFT JOIN mra_finding f ON f.finding_id = m.finding_id
    WHERE -- m.date_admit BETWEEN '2022-09-01' AND '2025-09-31'
      m.mra_id = $id
     AND m.AN = $an
    
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
  
}
