<?php

namespace app\controllers;

use Yii;
use app\models\Visitinvoice;
use app\models\VisitinvoiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
/**
 * VisitinvoiceController implements the CRUD actions for Visitinvoice model.
 */
class VisitinvoiceController extends Controller
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
     * Lists all Visitinvoice models.
     * @return mixed
     */
    public function actionIndex()
{
    $searchModel = new VisitinvoiceSearch();
    $queryParams = Yii::$app->request->queryParams;

    // กำหนดช่วงเวลา
    $startDate = '2024-04-01';
    $endDate = date('Y-m-d'); // วันที่ปัจจุบัน

    // ตรวจสอบค่า visit_id
    if (empty($queryParams['visit_id'])) {
        $dataProvider = new ActiveDataProvider([
            'query' => Visitinvoice::find()->where('0=1'), // ไม่แสดง Record ใดๆ
        ]);
    } else {
        // เพิ่มเงื่อนไขในการค้นหา
        $queryParams['VisitinvoiceSearch']['visit_id'] = $queryParams['visit_id'];
        $queryParams['VisitinvoiceSearch']['date_range'] = $startDate . ' to ' . $endDate; // ส่งช่วงเวลาไปยัง search model

        $dataProvider = $searchModel->search($queryParams);
    }

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
}


    /**
     * Displays a single Visitinvoice model.
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
     * Creates a new Visitinvoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Visitinvoice();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->auto_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Visitinvoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->auto_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Visitinvoice model.
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
     * Finds the Visitinvoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Visitinvoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Visitinvoice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
