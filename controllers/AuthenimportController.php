<?php

namespace app\controllers;

use Yii;
use app\models\authenkiosk;
use app\models\edc;
//use app\models\AuthenkioskSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\UploadedFile;
use app\models\EdcImportForm;
use yii\base\Model;
use yii\db\Command;
use yii\helpers\Html;

class AuthenimportController extends \yii\web\Controller
{
    // public function actionIndex()
    // {
    //     return $this->render('index');
    // }
    public function actionImports()
    {
        $modelImport = new \yii\base\DynamicModel([
            'fileImport' => 'File Import',
        ]);
        $importedCount = 0; // เพิ่มตัวแปรเพื่อเก็บจำนวนรายการที่นำเข้าสำเร็จ
        $newCount = 0; // เพิ่มตัวแปรเพื่อเก็บจำนวนรายการที่เพิ่มใหม่
        $totalRows = 0; // เพิ่มตัวแปรเพื่อเก็บจำนวนรายการในไฟล์ที่นำเข้า

        if (\Yii::$app->request->isPost) {
            $modelImport->fileImport = \yii\web\UploadedFile::getInstance($modelImport, 'fileImport');

            if ($modelImport->fileImport) {
                // ตรวจสอบความถูกต้องของไฟล์ Excel
                $validExtensions = ['ods', 'xls', 'xlsx'];
                $maxSize = 1024 * 1024;

                if (
                    in_array($modelImport->fileImport->extension, $validExtensions) &&
                    $modelImport->fileImport->size <= $maxSize
                ) {
                    try {
                        $inputFileType = \PHPExcel_IOFactory::identify($modelImport->fileImport->tempName);
                        $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel = $objReader->load($modelImport->fileImport->tempName);
                        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                        $baseRow = 3;

                        while (!empty($sheetData[$baseRow]['C'])) {
                            $existingModel = \app\models\Authenkiosk::findOne(['claimcode' => $sheetData[$baseRow]['J']]);

                            if ($existingModel) {
                                // มีข้อมูลที่มีค่าซ้ำอยู่ ดำเนินการแทนที่ค่าแทนการเพิ่มข้อมูล
                                $existingModel->attributes = [
                                    'cid' => $sheetData[$baseRow]['C'],
                                    //'visit_id' => $sheetData[$baseRow]['N'],
                                    'claimtype' => $sheetData[$baseRow]['L'],
                                    'claimcode' => $sheetData[$baseRow]['J'],
                                    'mobile' => $sheetData[$baseRow]['F'],
                                    //'dep_name' => $sheetData[$baseRow]['T'],
                                    // 'd_update' => new Expression('NOW()'),
                                ];
                                $existingModel->save();
                                $importedCount++; // เพิ่มจำนวนรายการที่นำเข้าสำเร็จ
                            } else {
                                // ไม่มีข้อมูลที่มีค่าซ้ำอยู่ ดำเนินการเพิ่มข้อมูลใหม่
                                $model = new \app\models\Authenkiosk([
                                    'cid' => $sheetData[$baseRow]['C'],
                                    'visit_id' => $sheetData[$baseRow]['N'],
                                    'claimtype' => $sheetData[$baseRow]['L'],
                                    'claimcode' => $sheetData[$baseRow]['J'],
                                    'mobile' => $sheetData[$baseRow]['F'],
                                    'dep_name' => $sheetData[$baseRow]['T'],
                                    'd_update' => new Expression('NOW()'),
                                ]);
                               
                                $model->save();
                            $newCount++; // เพิ่มจำนวนรายการที่เพิ่มใหม่
                            }

                            $baseRow++;
                            //$totalRows = count($sheetData) - 2; // ลบ 2 เพื่อตัดหัวตารางและแถวว่างท้ายตาราง
                        }
                        $totalRows = count($sheetData) - 2; // ลบ 2 เพื่อตัดหัวตารางและแถวว่างท้ายตาราง
                        \Yii::$app->session->setFlash('success', 'นำเข้าข้อมูลสำเร็จ');
                    } catch (\Exception $e) {
                        \Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาดในการนำเข้าข้อมูล');
                        var_dump($e->getMessage()); // แสดงข้อผิดพลาดในกรณีที่เกิดข้อผิดพลาด
                    }
                } else {
                    \Yii::$app->session->setFlash('error', 'ไฟล์ Excel ไม่ถูกต้องหรือมีขนาดใหญ่เกินไป');
                }
            } else {
                \Yii::$app->session->setFlash('error', 'กรุณาเลือกไฟล์ Excel ที่ต้องการนำเข้า');
            }
        }
        $connection = \Yii::$app->db_mra;
        $datap = $connection->createCommand("
               SELECT  id, cid, if(ISNULL(visit_id),' ', visit_id) as visit_id, claimtype, claimcode,  mobile,  dep_name,  d_update
                FROM authen_kiosk
                WHERE authen_kiosk.d_update BETWEEN '2023-09-11'  AND NOW()
                ORDER BY d_update DESC
            ")->queryAll();

        $importdataProvider = new ArrayDataProvider([
            'allModels' => $datap,
        ]);



        return $this->render('imports', [
            'modelImport' => $modelImport,
            'dataimport' => $importdataProvider,
            'importedCount' => $importedCount,
            'totalRows' => $totalRows,
            'newCount' => $newCount,

        ]);
    }
    ########################################################################
   public function actionImportcsv()
{
        $model = new Edc();
        $csvFile = UploadedFile::getInstance($model, 'csvFile'); // 'csvFile' คือ attribute ที่ใช้สำหรับรับไฟล์ CSV จากฟอร์ม

        if ($csvFile !== null) {
            $path = 'uploads/' . $csvFile->baseName . '.' . $csvFile->extension;
            $csvFile->saveAs($path);

            $this->importCsvData($path);
            unlink($path); // ลบไฟล์ CSV หลังจาก import เสร็จ

            Yii::$app->getSession()->setFlash('success', 'CSV file imported successfully.');
        } else {
            Yii::$app->getSession()->setFlash('error', 'Please upload a CSV file.');
        }

        return $this->redirect(['importcsv']); // กลับไปยังหน้า index หรือหน้าที่ต้องการ
    }

    private function importCsvData($filePath)
    {
        $handle = fopen($filePath, "r");

        if ($handle !== false) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $command = Yii::$app->db->createCommand();

                while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                    $command->insert('edc', [
                        'trans_id' => $row[0],
                        'visit_id' => $row[1],
                        'cid' => $row[2],
                        'amount' => $row[3],
                        'approvecode' => $row[4],
                        'edc_date' => $row[5],
                        'edc_time' => $row[6],
                        'd_update' => $row[7],
                    ])->execute();
                }

                $transaction->commit();

                fclose($handle);
            } catch (\Exception $e) {
                $transaction->rollBack();
                fclose($handle);

                Yii::$app->getSession()->setFlash('error', 'Error importing CSV file: ' . Html::encode($e->getMessage()));
            }
        }
    }
}