<?php

namespace app\controllers;

use Yii;
use app\models\Importtxt;
use app\models\ImporttextSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\db\Exception;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;


use yii\helpers\ArrayHelper;


/**
 * ImporttextController implements the CRUD actions for Importtxt model.
 */
class ImporttextController extends Controller
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
     * Lists all Importtxt models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImporttextSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionImport()
    {
        $model = new Importtxt();


        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'file');
            $filePath = 'uploads/file/' . $file->name;
            $file->saveAs($filePath);

            // Open the file
            if (($handle = fopen($filePath, 'r')) !== false) {
                // Get the database connection
                $connection = Yii::$app->db;

                // Begin a transaction for bulk insert
                $transaction = $connection->beginTransaction();
                try {

                    // Skip the first line
                    fgets($handle);

                    // Prepare the SQL statement
                    $sql = 'INSERT INTO import_txt (rep, id, train_id, hn, an, pid, fullname, main, regdate, discharge, ins, pp, errorcode, sub, d_update) 
                VALUES (:field1, :field2, :field3,:field4,:field5,:field6,:field7,:field8,:field9,:field10,:field11,:field12,:field13,:field14, now())';
                    #$sql = 'INSERT INTO your_table (field1, field2, field3, status) VALUES (:field1, :field2, :field3, :field3)';
                    $command = $connection->createCommand($sql);

                    // Process each line
                    while (($data = fgetcsv($handle, 0, '|')) !== false) {
                        // Assuming the fields are: field1, field2, field3, status
                        $field1 = $data[0];
                        $field2 = $data[1];
                        $field3 = $data[2];
                        $field4 = $data[3];
                        $field5 = $data[4];
                        $field6 = $data[5];
                        $field7 = $data[6];
                        $field8 = $data[7];
                        $field9 = $data[8];
                        $field10 = $data[9];
                        $field11 = $data[10];
                        $field12 = $data[11];
                        $field13 = $data[12];
                        $field14 = $data[13];

                        // Bind the values to the SQL statement
                        $command->bindValue(':field1', $field1);
                        $command->bindValue(':field2', $field2);
                        $command->bindValue(':field3', $field3);
                        $command->bindValue(':field4', $field4);
                        $command->bindValue(':field5', $field5);
                        $command->bindValue(':field6', $field6);
                        $command->bindValue(':field7', $field7);
                        $command->bindValue(':field8', $field8);
                        $command->bindValue(':field9', $field9);
                        $command->bindValue(':field10', $field10);
                        $command->bindValue(':field11', $field11);
                        $command->bindValue(':field12', $field12);
                        $command->bindValue(':field13', $field13);
                        $command->bindValue(':field14', $field14);

                        // Execute the SQL statement
                        $command->execute();
                    }

                    // Commit the transaction
                    $transaction->commit();

                    // File processed successfully
                    Yii::$app->session->setFlash('success', 'File imported successfully.');
                    return $this->redirect(['import']);
                } catch (Exception $e) {
                    // Rollback the transaction on exception
                    $transaction->rollBack();
                    throw $e;
                } finally {
                    // Close the file
                    fclose($handle);
                }
            }
        }
        $connection = \Yii::$app->db;
        $datap = $connection->createCommand("
     SELECT auto_id, rep, id, train_id, hn, an, pid, fullname, main, regdate, discharge, ins,pp, errorcode,sub,d_update
     FROM import_txt
     ORDER BY auto_id DESC
     ")->queryAll();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $datap,
        ]);

        // Render the view
        return $this->render('import', [
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }
    ##########################################################################
    public function actionImportcsv()
    {
        $model = new Importtxt();
    
        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'file');
            
            // Check if the file is a CSV file
            if ($file && pathinfo($file->name, PATHINFO_EXTENSION) === 'csv') {
                $filePath = 'uploads/file/' . $file->name;
                $file->saveAs($filePath);
    
                try {
                    // Get the database connection
                    $connection = Yii::$app->db;
    
                    // Begin a transaction for bulk insert
                    $transaction = $connection->beginTransaction();
    
                    try {
                        // Open the file
                        if (($handle = fopen($filePath, 'r')) !== false) {
                            // Skip the first line
                            fgets($handle);
    
                            // Prepare the SQL statement
                            $sql = 'INSERT INTO import_txt (rep, id, train_id, hn, an, pid, fullname, main, regdate, discharge, ins, pp, errorcode, sub, d_update) 
                                    VALUES (:field1, :field2, :field3, :field4, :field5, :field6, :field7, :field8, :field9, :field10, :field11, :field12, :field13, :field14, now())';
                            $command = $connection->createCommand($sql);
    
                            // Process each line
                            while (($data = fgetcsv($handle, 0, ',')) !== false) {
                                // Assuming the fields are: field1, field2, field3, ..., field14
                                $command->bindValues([
                                    ':field1' => $data[0],
                                    ':field2' => $data[1],
                                    // ... bind other fields ...
                                    ':field14' => $data[13],
                                ]);
    
                                // Execute the SQL statement
                                $command->execute();
                            }
    
                            // Commit the transaction
                            $transaction->commit();
    
                            Yii::$app->session->setFlash('success', 'File imported successfully.');
                        } else {
                            Yii::$app->session->setFlash('error', 'Unable to open the file.');
                        }
                    } catch (Exception $e) {
                        // Rollback the transaction in case of an error
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error', 'Error importing file: ' . $e->getMessage());
                    }
                } catch (Exception $e) {
                    Yii::$app->session->setFlash('error', 'Error saving the file: ' . $e->getMessage());
                }
            } else {
                Yii::$app->session->setFlash('error', 'Invalid file format. Please upload a CSV file.');
            }
        }
        $connection = \Yii::$app->db;
        $datap = $connection->createCommand("
     SELECT auto_id, rep, id, train_id, hn, an, pid, fullname, main, regdate, discharge, ins,pp, errorcode,sub,d_update
     FROM import_txt
     ORDER BY auto_id DESC
     ")->queryAll();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $datap,
        ]);

    
        return $this->render('importcsv', [
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }
#################################################################################################    
    /**
     * Updates an existing Importtxt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $auto_id
     * @param string $train_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($auto_id, $train_id)
    {
        $model = $this->findModel($auto_id, $train_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'auto_id' => $model->auto_id, 'train_id' => $model->train_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Importtxt model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $auto_id
     * @param string $train_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($auto_id, $train_id)
    {
        $this->findModel($auto_id, $train_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Importtxt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $auto_id
     * @param string $train_id
     * @return Importtxt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($auto_id, $train_id)
    {
        if (($model = Importtxt::findOne(['auto_id' => $auto_id, 'train_id' => $train_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
