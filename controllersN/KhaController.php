<?php

namespace app\controllers;

use Yii;
use app\models\Kha;
use app\models\KhaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\web\UploadedFile;



/**
 * KhaController implements the CRUD actions for Kha model.
 */
class KhaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => ['create_date'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * Lists all Kha models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KhaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Kha model.
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
    public function actionCreate()
    {
        $model = new Kha();

        // Set the create_date attribute to the current date and time
        $model->create_date = date('Y-m-d H:i:s');

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->validate()) {
                $uploadPath = 'uploads/ha/';
                $filename = $model->file->baseName . '.' . $model->file->extension;
                $filePath = $uploadPath . $filename;

                // Save the filename to the database
                $model->filename = $filename;

                if ($model->save()) {
                    // Upload the file
                    $model->file->saveAs($filePath);

                    return $this->redirect(['index', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /*
    public function actionCreate()
    {
        $model = new Kha();

        // Set the create_date attribute to the current date and time
        $model->create_date = date('Y-m-d H:i:s');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Your save logic here

            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
*/
    /**
     * Creates a new Kha model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate($id)
{
    $model = Kha::findOne($id);

    // Assuming you have some logic to determine the update condition based on the current value in the database
    $currentUpdateCount = $model->is_update; // Get the current value from the database

    // Increment the value
    $updateCondition = $currentUpdateCount + 1;

    $model->is_update = $updateCondition;

    if ($model->load(Yii::$app->request->post())) {
        $model->file = UploadedFile::getInstance($model, 'file');

        if ($model->validate()) {
            if ($model->file) {
                // Set the new filename
                $model->filename = $model->file->baseName . '.' . $model->file->extension;

                // Specify the target directory for saving the file
                $uploadPath = 'uploads/ha/';
                $filePath = $uploadPath . $model->filename;

                // Save the model to update the filename in the database
                if ($model->save()) {
                    // Upload the new file
                    $model->file->saveAs($filePath);

                    // Your additional save logic here

                    return $this->redirect(['index', 'id' => $model->id]);
                }
            } else {
                // Handle the case where no new file is uploaded
                if ($model->save()) {
                    // Your additional save logic here

                    return $this->redirect(['index', 'id' => $model->id]);
                }
            }
        }
    }

    return $this->render('update', [
        'model' => $model,
    ]);
}



    /*
     public function actionUpdate($id)
     {
         $model = Kha::findOne($id);
 
         // Assuming you have some logic to determine the update condition based on the current value in the database
         $currentUpdateCount = $model->is_update; // Get the current value from the database
 
         // Increment the value
         $updateCondition = $currentUpdateCount + 1;
 
         $model->is_update = $updateCondition;
 
         if ($model->load(Yii::$app->request->post()) && $model->save()) {
             // Your save logic here
 
             return $this->redirect(['index', 'id' => $model->id]);
         }
 
         return $this->render('update', [
             'model' => $model,
         ]);
     }
     */
    /*
    public function actionUpdate($id)
    {
        $model = Kha::findOne($id);

        // Assuming you have some logic to determine the update condition based on the current value in the database
        $currentUpdateCount = $model->is_update; // Get the current value from the database

        // Increment the value
        $updateCondition = $currentUpdateCount + 1;

        $model->is_update = $updateCondition;

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file'); // Assuming you have a 'file' attribute in your model

            // Handling file upload
            if ($model->file) {
                $model->filename = $model->upload(); // Assuming you have an 'upload' method in your model
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Your save logic here

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    */
    public function actionDownload($id)
    {
        $model = Kha::findOne($id);

        if ($model && $model->filename) {
            $filePath = 'uploads/ha/' . $model->filename;

            if (file_exists($filePath)) {
                Yii::$app->response->sendFile($filePath, $model->filename, ['inline' => false])
                    ->send();
            } else {
                throw new NotFoundHttpException('The requested file does not exist.');
            }
        } else {
            throw new NotFoundHttpException('The requested model does not exist.');
        }
    }
    /*
    public function actionUpdate($id)
    {
        $model = Kha::findOne($id);

        // Assuming you have some logic to determine the update condition based on the current value in the database
        $currentUpdateCount = $model->is_update; // Get the current value from the database

        // Increment the value
        $updateCondition = $currentUpdateCount + 1;

        $model->is_update = $updateCondition;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Your save logic here

            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
*/

    /**
     * Updates an existing Kha model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    */

    /**
     * Deletes an existing Kha model.
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
     * Finds the Kha model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kha the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kha::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
