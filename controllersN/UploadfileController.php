<?php

namespace app\controllers;

use Yii;
use yii\web\Uploadedfile;
use app\models\Uploadfile;
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
        $model = new UploadFile();

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file && $model->validate()) {
                $path = 'uploads/' . $model->file->baseName . '.' . $model->file->extension;
                $model->file->saveAs($path);
                $model->path = $path;

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'File uploaded successfully.');
                    return $this->redirect(['view', 'id' => $model->key_id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to save the model.');
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
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
    public function upload()
    {
        if ($this->validate()) {
            $this->file1->saveAs('uploads/agenda/' . $this->file1->extension);
            $this->file2->saveAs('uploads/agenda/' . $this->file2->extension);
            //$this->file2->saveAs('path/to/save/file2.' . $this->file2->extension);
            // ตัวอย่างนี้เป็นการบันทึกไฟล์ที่อัปโหลดในตำแหน่งที่กำหนด โปรดแก้ไขเพื่อให้ตรงกับความต้องการของคุณ
            return true;
        } else {
            return false;
        }
    }
}
