<?php

namespace app\controllers;

use Yii;
use app\models\Logdt;
use app\models\LogdtSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LogdtController implements the CRUD actions for Logdt model.
 */
class LogdtController extends Controller
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
     * Lists all Logdt models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogdtSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Logdt model.
     * @param integer $id
     * @param string $visit_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $visit_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $visit_id),
        ]);
    }

    /**
     * Creates a new Logdt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Logdt();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'visit_id' => $model->visit_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Logdt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param string $visit_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $visit_id)
    {
        $model = $this->findModel($id, $visit_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'visit_id' => $model->visit_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Logdt model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param string $visit_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $visit_id)
    {
        $this->findModel($id, $visit_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Logdt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $visit_id
     * @return Logdt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $visit_id)
    {
        if (($model = Logdt::findOne(['id' => $id, 'visit_id' => $visit_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
