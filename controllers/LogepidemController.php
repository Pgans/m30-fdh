<?php

namespace app\controllers;

use Yii;
use app\models\Logepidem;
use app\models\LogepidemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LogepidemController implements the CRUD actions for Logepidem model.
 */
class LogepidemController extends Controller
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
     * Lists all Logepidem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogepidemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Logepidem model.
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
     * Creates a new Logepidem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Logepidem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'visit_id' => $model->visit_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Logepidem model.
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
     * Deletes an existing Logepidem model.
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
     * Finds the Logepidem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $visit_id
     * @return Logepidem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $visit_id)
    {
        if (($model = Logepidem::findOne(['id' => $id, 'visit_id' => $visit_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
