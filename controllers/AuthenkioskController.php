<?php

namespace app\controllers;

use Yii;
use app\models\Authenkiosk;
use app\models\AuthenkioskSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuthenkioskController implements the CRUD actions for Authenkiosk model.
 */
class AuthenkioskController extends Controller
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
     * Lists all Authenkiosk models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthenkioskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Authenkiosk model.
     * @param string $id
     * @param string $cid
     * @param string $claimtype
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $cid, $claimtype)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $cid, $claimtype),
        ]);
    }

    /**
     * Creates a new Authenkiosk model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Authenkiosk();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'cid' => $model->cid, 'claimtype' => $model->claimtype]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Authenkiosk model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @param string $cid
     * @param string $claimtype
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $cid, $claimtype)
    {
        $model = $this->findModel($id, $cid, $claimtype);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'cid' => $model->cid, 'claimtype' => $model->claimtype]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Authenkiosk model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @param string $cid
     * @param string $claimtype
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $cid, $claimtype)
    {
        $this->findModel($id, $cid, $claimtype)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Authenkiosk model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @param string $cid
     * @param string $claimtype
     * @return Authenkiosk the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $cid, $claimtype)
    {
        if (($model = Authenkiosk::findOne(['id' => $id, 'cid' => $cid, 'claimtype' => $claimtype])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
