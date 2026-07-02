<?php

namespace app\controllers;

use Yii;
use app\models\Repimport2;
use app\models\Repimport2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\db\Exception;

/**
 * Repimport2Controller implements the CRUD actions for Repimport2 model.
 */
class Repimport2Controller extends Controller
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
     * Lists all Repimport2 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Repimport2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionImportx()
    {
    $model = new Repimport2();

    if ($model->load(Yii::$app->request->post())) {
        $file = UploadedFile::getInstance($model, 'file');
        $filePath = 'uploads/file/' . $file->name;
        $file->saveAs($filePath);

        // Load the Excel file
        $spreadsheet = IOFactory::load($filePath);

        // Get the first sheet
        $sheet = $spreadsheet->getActiveSheet();

        // Get the highest row number
        $highestRow = $sheet->getHighestRow();

        // Get the database connection
        $connection = Yii::$app->db;

        // Begin a transaction for bulk insert
        $transaction = $connection->beginTransaction();
        try {
            // Prepare the SQL statement
            //$sql = 'INSERT INTO rep_import (field1, field2, field3, status) VALUES (:field1, :field2, :field3, :status)';
            $sql = 'INSERT INTO rep_imports2 (rep, id, train_id, hn, an, pid, fullname, main, regdate, discharge, ins, pp, errorcode, sub) 
                VALUES (:field1, :field2, :field3,:field4,:field5,:field6,:field7,:field8,:field9,:field10,:field11,:field12,:field13,:field14)';
            $command = $connection->createCommand($sql);

            // Start from row 2 (assuming row 1 is the header)
            for ($row = 2; $row <= $highestRow; $row++) {
                // Assuming the columns are: A, B, C, D
                $field1 = $sheet->getCell('A' . $row)->getValue();
                $field2 = $sheet->getCell('B' . $row)->getValue();
                $field3 = $sheet->getCell('C' . $row)->getValue();
                $field4 = $sheet->getCell('D' . $row)->getValue();
                $field5 = $sheet->getCell('E' . $row)->getValue();
                $field6 = $sheet->getCell('F' . $row)->getValue();
                $field7 = $sheet->getCell('G' . $row)->getValue();
                $field8 = $sheet->getCell('H' . $row)->getValue();
                $field9 = $sheet->getCell('I' . $row)->getValue();
                $field10 = $sheet->getCell('J' . $row)->getValue();
                $field11 = $sheet->getCell('K' . $row)->getValue();
                $field12 = $sheet->getCell('L' . $row)->getValue();
                $field13 = $sheet->getCell('M' . $row)->getValue();
                $field14 = $sheet->getCell('N' . $row)->getValue();
                
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
            return $this->redirect(['import2']);
        } catch (Exception $e) {
            // Rollback the transaction on exception
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Failed to import file.');
        }

         return $this->render('view', [
             'model' => $model,
        ]);
       }
       $connection = \Yii::$app->db;
       $datap = $connection->createCommand("
    SELECT auto_id, rep, id, train_id, hn, an, pid, fullname, main, regdate, discharge, ins,pp, errorcode,sub
    FROM rep_import2
    ORDER BY auto_id DESC
    ")->queryAll();

    $importdataProvider = new ArrayDataProvider([
        'allModels' => $datap,
    ]);

       return $this->render('import2',[
               'model' => $model,
               'dataimport' => $importdataProvider,
               
           ]);
   }
        
    public function actionView($auto_id, $train_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($auto_id, $train_id),
        ]);
    }

    /**
     * Creates a new Repimport2 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Repimport2();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'auto_id' => $model->auto_id, 'train_id' => $model->train_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Repimport2 model.
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
     * Deletes an existing Repimport2 model.
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
     * Finds the Repimport2 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $auto_id
     * @param string $train_id
     * @return Repimport2 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($auto_id, $train_id)
    {
        if (($model = Repimport2::findOne(['auto_id' => $auto_id, 'train_id' => $train_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
