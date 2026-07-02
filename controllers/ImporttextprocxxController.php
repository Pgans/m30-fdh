<?php

namespace app\controllers;

use Yii;
use app\models\Importtxtproc;
use app\models\ImporttextprocSearch;
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
class ImporttextprocController extends Controller
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
        $searchModel = new ImporttextprocSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

  public function actionImport()
{
    $model = new Importtxtproc();

    if ($model->load(Yii::$app->request->post())) {
        $file = UploadedFile::getInstance($model, 'file');
        $filePath = 'uploads/file/' . $file->name;
        $file->saveAs($filePath);

        // Open the file
        if (($handle = fopen($filePath, 'r')) !== false) {
            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();

            try {
                // DELETE data before import
                $connection->createCommand('DELETE FROM import_proc')->execute();

                // Skip the first line if the file has a header
                fgets($handle);

                // Prepare SQL for insert
                $sql = 'INSERT INTO import_proc 
                        (HOSPCODE, PID, AN, DATETIME_ADMIT, WARDSTAY, PROCEDCODE, TIMESTART, TIMEFINISH, SERVICEPRICE, PROVIDER, D_UPDATE, CID) 
                        VALUES (:field1, :field2, :field3, :field4, :field5, :field6, :field7, :field8, :field9, :field10, :field11, :field12)';
                $command = $connection->createCommand($sql);

                // Process each line
                while (($data = fgetcsv($handle, 0, '|')) !== false) {
                    // Trim the fields to remove any extra spaces
                    foreach ($data as &$field) {
                        $field = trim($field);
                    }

                    // Bind the values to the SQL statement
                    $command->bindValue(':field1', $data[0]);
                    $command->bindValue(':field2', $data[1]);
                    $command->bindValue(':field3', $data[2]);
                    $command->bindValue(':field4', $data[3]);
                    $command->bindValue(':field5', $data[4]);
                    $command->bindValue(':field6', $data[5]);
                    $command->bindValue(':field7', $data[6]);
                    $command->bindValue(':field8', $data[7]);
                    $command->bindValue(':field9', $data[8]);
                    $command->bindValue(':field10', $data[9]);
                    $command->bindValue(':field11', $data[10]);
                    $command->bindValue(':field12', $data[11]);
                    $command->execute();
                }

                // Update PROCEDCODE to 'HOMEWARD' where wardstay = '10150'
                $updateSql = "UPDATE import_proc SET PROCEDCODE = 'HOMEWARD' WHERE right(wardstay,2) = '50'";
                $connection->createCommand($updateSql)->execute();

                // Commit the transaction
                $transaction->commit();

                // Generate the text file
                $data = $connection->createCommand("
                    SELECT HOSPCODE, PID, AN, DATETIME_ADMIT, WARDSTAY, PROCEDCODE, TIMESTART, TIMEFINISH, SERVICEPRICE, PROVIDER, D_UPDATE, CID
                    FROM import_proc
                    ORDER BY auto_id DESC
                ")->queryAll();

                // Prepare file content with Windows line endings (CRLF)
                $fileContent = "HOSPCODE|PID|AN|DATETIME_ADMIT|WARDSTAY|PROCEDCODE|TIMESTART|TIMEFINISH|SERVICEPRICE|PROVIDER|D_UPDATE|CID\r\n";
                foreach ($data as $row) {
                    // Trim each field and join them with "|"
                    $row = array_map('trim', $row);
                    $fileContent .= implode('|', $row) . "\r\n"; // CRLF for Windows line breaks
                }

                // Create the text file and send it for download
                $fileName = 'procedure_ipd.txt';
                Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
                Yii::$app->response->headers->add('Content-Type', 'text/plain');
                Yii::$app->response->headers->add('Content-Disposition', 'attachment; filename="' . $fileName . '"');
                Yii::$app->response->data = $fileContent;
                return Yii::$app->response->send();
            } catch (Exception $e) {
                // Rollback the transaction on exception
                $transaction->rollBack();
                throw $e;
            } finally {
                fclose($handle);
            }
        }
    }

    // Query data for display
    $connection = Yii::$app->db;
    $datap = $connection->createCommand("
        SELECT HOSPCODE, PID, AN, DATETIME_ADMIT, WARDSTAY, PROCEDCODE, TIMESTART, TIMEFINISH, SERVICEPRICE, PROVIDER, D_UPDATE, CID
        FROM import_proc
        WHERE right(wardstay,2) = '50'
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
        if (($model = Importtxtproc::findOne(['auto_id' => $auto_id, 'train_id' => $train_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
