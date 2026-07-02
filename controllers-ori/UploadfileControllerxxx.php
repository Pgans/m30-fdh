<?php

namespace app\controllers;

use Yii;
use app\models\Uploadfile;
use yii\web\Uploadedfile;
use app\models\UploadfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UploadfileController implements the CRUD actions for Uploadfile model.
 */
class UploadfileController extends Controller
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
     * Lists all Uploadfile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UploadfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Uploadfile model.
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
     * Creates a new Uploadfile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Uploadfile();

        if (Yii::$app->request->isPost) {
            $model->file = Uploadedfile::getInstance($model, 'file');

            if ($model->upload()) {
                Yii::$app->session->setFlash('success', 'File uploaded สำเร็จ.');
                return $this->redirect(['view', 'id' => $model->key_id]);
            }
        }

        return $this->render('create', 
        ['model' => $model]);
    }
    // public function actionCreate()
    // {
    //     $model = new Uploadfile();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->key_id]);
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Updates an existing Uploadfile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->key_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Uploadfile model.
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
    public function actionDownload($id)
    {
        $model = UploadFile::findOne($id);
        $filePath = Yii::getAlias('@webroot') . '/' . $model->path;
        
        if (file_exists($filePath)) {
            Yii::$app->response->sendFile($filePath, $model->filename);
        } else {
            // Handle file not found
            // For example, redirect to an error page
            // or show an error message
        }
    }
    // public function actionDownload($id)
    // {
    //     $model = $this->findModel($id);
    //     $file = Yii::getAlias('@webroot') . '/' . $model->path;

    //     if (file_exists($file)) {
    //         return Yii::$app->response->sendFile($file, $model->filename);
    //     } else {
    //         throw new NotFoundHttpException('The requested file does not exist.');
    //     }
    // }
    /**
     * Finds the Uploadfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Uploadfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Uploadfile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
