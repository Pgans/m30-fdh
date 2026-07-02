<?php

namespace app\controllers;

use Yii;
use app\models\Importcsv;
use app\models\Edc;
use app\models\ImportcsvSearch;
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
class ImportcsvController extends Controller
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
    /*
    public function actionIndex()
    {
        $searchModel = new ImportcsvSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    */
    public function actionImportcsv()
    {
        $model = new Edc();
        
            if ($model->load(Yii::$app->request->post())) {
                $file = UploadedFile::getInstance($model, 'file');
                $filePath = 'uploads/file/' . $file->name;
                $file->saveAs($filePath);
    
                // Open the file
                if (($handle = fopen($filePath, 'r')) !== false) {
                    // Get the database connection
                    $connection = Yii::$app->db_mra;
    
                    // Begin a transaction for bulk insert
                    $transaction = $connection->beginTransaction();
                    try {
    
                        // Skip the first line
                        fgets($handle);
    
                        // Prepare the SQL statement
                        $connection = Yii::$app->db_mra;
                        $sql  = 'INSERT INTO edc (trans_id, visit_id, cid, amount, approvecode, edc_date, edc_time, d_update)
                        VALUES (:field1, :field2, :field3, :field4, :field5, :field6, :field7, now())';
                        $command = $connection->createCommand($sql);
    
                        // Process each line
                        while (($data = fgetcsv($handle, 0, ',')) !== false) {
                            // Assuming the fields are: field1, field2, field3, status
                            $field1 = $data[15];
                            $field2 = $data[1];
                            $field3 = $data[6];
                            $field4 = $data[12];
                            $field5 = $data[17];
                            $field6 = $data[2];
                            $field7 = $data[3];
    
                            // Bind the values to the SQL statement
                            $command->bindValue(':field1', $field1);
                            $command->bindValue(':field2', $field2);
                            $command->bindValue(':field3', $field3);
                            $command->bindValue(':field4', $field4);
                            $command->bindValue(':field5', $field5);
                            $command->bindValue(':field6', $field6);
                            $command->bindValue(':field7', $field7);
                           
    
                            // Execute the SQL statement
                            $command->execute();
                        }
    
                        // Commit the transaction
                        $transaction->commit();
    
                        // File processed successfully
                        Yii::$app->session->setFlash('success', 'File imported successfully.');
                        return $this->redirect(['importcsv']);
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
            SELECT id, trans_id, visit_id, cid, amount, approvecode, edc_date, edc_time, d_update
            FROM edc
            ORDER BY id DESC
         ")->queryAll();
    
            $dataProvider = new ArrayDataProvider([
                'allModels' => $datap,
            ]);
    
            // Render the view
            return $this->render('importcsv', [
                'model' => $model,
                'dataProvider' => $dataProvider
            ]);
        }

    }