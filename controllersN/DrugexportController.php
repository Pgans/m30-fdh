<?php

namespace app\controllers;

use Yii;
use app\models\Drugexport;
use app\models\DrugexportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DrugexportController implements the CRUD actions for Drugexport model.
 */
class DrugexportController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Drugexport models.
     * @return mixed
     */
    public function actionIndex()
    {
        $data = Yii::$app->request->post();
        // $date1 = "20230101";
        // $date2 = date('Y-m-d');
         $date1 = isset($data['date1']) ? $data['date1'] : '';
         $date2 = isset($data['date2']) ? $data['date2'] : '';
         $items =isset($data['items'])  ? $data['items'] : NUll;
         $items1 =isset($data['items1'])  ? $data['items1'] : NUll;
         $items2 =isset($data['items2'])  ? $data['items2'] : NUll;
         $items3 =isset($data['items3'])  ? $data['items3'] : NUll;
         
         if(count($items)>0){  // ตรวจสอบ checkbox ว่ามีการเลือกมาอย่างน้อย 1 รายการหรือไม่
            // $hcode = [];
             foreach($items as $i => $hcode) {
                // var_dump($hcode, $items1[$i], $item2[$i]);
                // echo "$x = $hcode <br>";
                $code[] = $hcode;
                 $hospcode =  implode("','", $code);
                // print_r($hospcode);
             } 
         }
         if(count($items1)>0){
             $hcode1 = []; 
             foreach($items1 as $i => $hcode1) {
                 $code1[] = $hcode1;
                  $hospcode1 =  implode("','", $code1);
                //  print_r($hospcode1);
              }  
         }
         if(count($items2)>0){
             $hcode1 = []; 
             foreach($items2 as $i => $hcode2) {
                 $code2[] = $hcode2;
                  $hospcode2 =  implode("','", $code2);
                //  print_r($hospcode1);
              }  
         }
         if(count($items3)>0){
             $hcode3 = []; 
             foreach($items3 as $i => $hcode3) {
                 $code3[] = $hcode3;
                  $hospcode3 =  implode("','", $code3);
                  print_r($hospcode1);
              }  
         }
       // $searchModel = new DrugexportSearch();

       // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       $sql = "SELECT k.hospcode, k.hospname ,k.didstd ,k.dname , k.amount,  k.unit_packing, k.unit_packing, k.unit_name
       FROM (
       SELECT DISTINCT d.hospcode , c.hospname , d.didstd, d.dname, sum(d.amount) amount, d.unit , d.unit_packing,
        IF(l.unit_name is null = '', l.unit_name,'') as unit_name
       FROM drug_opd d
       LEFT  JOIN l_unit_drugs l on l.unit_id = d.unit_packing
       INNER JOIN chospital_muang c ON d.hospcode = c.hospcode
       WHERE d.date_serv between  '2023-01-01' and '2023-01-31'
       AND d.hospcode in ('03698')
       GROUP BY  d.didstd, d.hospcode
       ORDER BY HOSPCODE) as k
       ";
       
$rawData = \yii::$app->db_host->createCommand($sql)->queryAll();

try {
  $rawData = \Yii::$app->db_host->createCommand($sql)->queryAll();
} catch (\yii\db\Exception $e) {
  throw new \yii\web\ConflictHttpException('sql error');
}
//$model->date_admit = date('Y-m-d');
$dataProvider = new \yii\data\ArrayDataProvider([
  'allModels' => $rawData,
  'pagination' => FALSE,
]);

        return $this->render('index', [
           // 'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Drugexport model.
     * @param string $HOSPCODE
     * @param string $PID
     * @param string $SEQ
     * @param string $DIDSTD
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($HOSPCODE, $PID, $SEQ, $DIDSTD)
    {
        return $this->render('view', [
            'model' => $this->findModel($HOSPCODE, $PID, $SEQ, $DIDSTD),
        ]);
    }
//Yii2 kartik-v/yii2-grid   excel2007 
    /**
     * Creates a new Drugexport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Drugexport();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'HOSPCODE' => $model->HOSPCODE, 'PID' => $model->PID, 'SEQ' => $model->SEQ, 'DIDSTD' => $model->DIDSTD]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Drugexport model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $HOSPCODE
     * @param string $PID
     * @param string $SEQ
     * @param string $DIDSTD
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($HOSPCODE, $PID, $SEQ, $DIDSTD)
    {
        $model = $this->findModel($HOSPCODE, $PID, $SEQ, $DIDSTD);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'HOSPCODE' => $model->HOSPCODE, 'PID' => $model->PID, 'SEQ' => $model->SEQ, 'DIDSTD' => $model->DIDSTD]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Drugexport model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $HOSPCODE
     * @param string $PID
     * @param string $SEQ
     * @param string $DIDSTD
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($HOSPCODE, $PID, $SEQ, $DIDSTD)
    {
        $this->findModel($HOSPCODE, $PID, $SEQ, $DIDSTD)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Drugexport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $HOSPCODE
     * @param string $PID
     * @param string $SEQ
     * @param string $DIDSTD
     * @return Drugexport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($HOSPCODE, $PID, $SEQ, $DIDSTD)
    {
        if (($model = Drugexport::findOne(['HOSPCODE' => $HOSPCODE, 'PID' => $PID, 'SEQ' => $SEQ, 'DIDSTD' => $DIDSTD])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
