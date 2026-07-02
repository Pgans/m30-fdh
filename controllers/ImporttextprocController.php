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
use ZipArchive;
use yii\helpers\FileHelper;



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

   
    public function actionIndex()
    {
        $searchModel = new ImporttextprocSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
#### Zip File ########################################################################################

  
public function actionImportZip()
{
    $model = new Importtxtproc();

    if (Yii::$app->request->isPost) {
        $zipFile = UploadedFile::getInstance($model, 'file');

        if (!$zipFile) {
            Yii::$app->session->setFlash('error', 'ไม่ได้เลือกไฟล์หรืออัปโหลดไฟล์ไม่สำเร็จ');
            return $this->redirect(['import-zip']);
        }

        if (strtolower($zipFile->extension) !== 'zip') {
            Yii::$app->session->setFlash('error', 'กรุณาอัปโหลดไฟล์ .zip เท่านั้น');
            return $this->redirect(['import-zip']);
        }

        $baseName = pathinfo($zipFile->name, PATHINFO_FILENAME);
        $uploadDir = Yii::getAlias('@webroot/uploads/file');
        $extractDir = Yii::getAlias("@webroot/uploads/extract/$baseName");
        $exportDir = Yii::getAlias("@webroot/uploads/export/$baseName");

        FileHelper::createDirectory($uploadDir);
        FileHelper::createDirectory($extractDir);
        FileHelper::createDirectory($exportDir);

        $uploadedPath = $uploadDir . '/' . $zipFile->name;
        if (!$zipFile->saveAs($uploadedPath)) {
            Yii::$app->session->setFlash('error', 'ไม่สามารถบันทึกไฟล์ zip ได้');
            Yii::error("Failed to save uploaded file to $uploadedPath. UploadedFile info: " . print_r($zipFile, true));
            return $this->redirect(['import-zip']);
        }

        $zip = new ZipArchive();
        $zipStatus = $zip->open($uploadedPath);

        if ($zipStatus !== true) {
            Yii::$app->session->setFlash('error', 'ไม่สามารถแตก zip ได้ (code: ' . $zipStatus . ')');
            return $this->redirect(['import-zip']);
        }

        $zip->extractTo($extractDir);
        $zip->close();

        // หา procedure_ipd.txt
        $files = FileHelper::findFiles($extractDir, [
            'only' => ['procedure_ipd.txt'],
            'recursive' => true,
        ]);

        if (empty($files)) {
            Yii::$app->session->setFlash('error', 'ไม่พบไฟล์ procedure_ipd.txt ใน zip');
            return $this->redirect(['import-zip']);
        }

        $procedureFile = $files[0];

        // Import ข้อมูลลงฐานข้อมูล
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();

        try {
            $handle = fopen($procedureFile, 'r');
            fgets($handle); // ข้าม header
            $connection->createCommand('DELETE FROM import_proc')->execute();

            $sql = 'INSERT INTO import_proc 
                    (HOSPCODE, PID, AN, DATETIME_ADMIT, WARDSTAY, PROCEDCODE, TIMESTART, TIMEFINISH, SERVICEPRICE, PROVIDER, D_UPDATE, CID) 
                    VALUES (:field1, :field2, :field3, :field4, :field5, :field6, :field7, :field8, :field9, :field10, :field11, :field12)';
            $command = $connection->createCommand($sql);

            while (($data = fgetcsv($handle, 0, '|')) !== false) {
                foreach ($data as &$field) {
                    $field = trim($field);
                }
                $command->bindValues([
                    ':field1' => $data[0],
                    ':field2' => $data[1],
                    ':field3' => $data[2],
                    ':field4' => $data[3],
                    ':field5' => $data[4],
                    ':field6' => $data[5],
                    ':field7' => $data[6],
                    ':field8' => $data[7],
                    ':field9' => $data[8],
                    ':field10' => $data[9],
                    ':field11' => $data[10],
                    ':field12' => $data[11],
                ])->execute();
            }
            fclose($handle);

            $connection->createCommand("UPDATE import_proc SET PROCEDCODE = 'HOMEWARD' WHERE RIGHT(wardstay,2) = '50'")->execute();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาดขณะ import: ' . $e->getMessage());
            return $this->redirect(['import-zip']);
        }

        // สร้างไฟล์ procedure_ipd.txt ใหม่ใน export folder
        $data = $connection->createCommand("
            SELECT HOSPCODE, PID, AN, DATETIME_ADMIT, WARDSTAY, PROCEDCODE, TIMESTART, TIMEFINISH, SERVICEPRICE, PROVIDER, D_UPDATE, CID
            FROM import_proc ORDER BY auto_id
        ")->queryAll();

        $newProcedurePath = $exportDir . '/procedure_ipd.txt';
        $content = "HOSPCODE|PID|AN|DATETIME_ADMIT|WARDSTAY|PROCEDCODE|TIMESTART|TIMEFINISH|SERVICEPRICE|PROVIDER|D_UPDATE|CID\r\n";

        foreach ($data as $row) {
            $row = array_map('trim', $row);
            $content .= implode('|', $row) . "\r\n";
        }

        file_put_contents($newProcedurePath, $content);

        // สร้าง zip ใหม่รวมไฟล์ทั้งหมดใน extractDir (ยกเว้น procedure_ipd.txt) และ procedure_ipd.txt ใหม่
        $dateTimeStr = date('YmdHis'); // วันที่และเวลา
        $zipFolderName = "F43_10953_" . $dateTimeStr; // ชื่อโฟลเดอร์ใน zip
        $zipFileName = $zipFolderName . '.zip';
        $finalZipPath = Yii::getAlias('@webroot/uploads/' . $zipFileName);

        $zip = new ZipArchive();
        if ($zip->open($finalZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
			
		/*	
            // เพิ่มไฟล์จาก extractDir (ยกเว้น procedure_ipd.txt)
            $extractedFiles = FileHelper::findFiles($extractDir);
            foreach ($extractedFiles as $file) {
				
				
				
				
                if (basename($file) === 'procedure_ipd.txt') {
                    continue;
                }
                $relativePath = $zipFolderName . '/extract/' . str_replace($extractDir . DIRECTORY_SEPARATOR, '', $file);
                $zip->addFile($file, $relativePath);
            }
			*/
			
			// เพิ่มไฟล์จาก extractDir (ยกเว้น procedure_ipd.txt)
$extractedFiles = FileHelper::findFiles($extractDir);
foreach ($extractedFiles as $file) {
    if (basename($file) === 'procedure_ipd.txt') {
        continue;
    }
    // ย้ายไฟล์จาก extractDir มาไว้ระดับเดียวกับ procedure_ipd.txt
    $relativePath = $zipFolderName . '/' . basename($file);
    $zip->addFile($file, $relativePath);
}

            // เพิ่ม procedure_ipd.txt ใหม่จาก exportDir
            if (file_exists($newProcedurePath)) {
                $relativeNewProcedure = $zipFolderName . '/procedure_ipd.txt';
                $zip->addFile($newProcedurePath, $relativeNewProcedure);
            } else {
                Yii::$app->session->setFlash('error', 'ไม่พบไฟล์ procedure_ipd.txt ในโฟลเดอร์ export');
                return $this->redirect(['import-zip']);
            }

            $zip->close();
        } else {
            Yii::$app->session->setFlash('error', 'ไม่สามารถสร้าง zip ได้');
            return $this->redirect(['import-zip']);
        }

        // ลบโฟลเดอร์ extract และ uploads/file หลังเสร็จงาน
        if (is_dir($extractDir)) {
            FileHelper::removeDirectory($extractDir);
        }

        $fileDir = Yii::getAlias('@webroot/uploads/file');
        if (is_dir($fileDir)) {
            FileHelper::removeDirectory($fileDir);
        }

        // ส่งไฟล์ zip ให้ดาวน์โหลด
        return Yii::$app->response->sendFile($finalZipPath)->send();
    }

    // แสดง form upload
    return $this->render('import-zip', ['model' => $model]);
}


/*
$zip = new ZipArchive();
if ($zip->open($newZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
    // 1. เพิ่มไฟล์ทั้งหมดจาก extractDir (ยกเว้น procedure_ipd.txt)
    $extractedFiles = FileHelper::findFiles($extractDir);

    foreach ($extractedFiles as $file) {
        if (basename($file) === 'procedure_ipd.txt') {
            continue; // ข้ามไฟล์เก่า
        }

        // ทำ path ให้สัมพันธ์จากโฟลเดอร์ export (หรือใส่เป็นโฟลเดอร์ extract/)
        $relativePath = 'extract/' . str_replace($extractDir . DIRECTORY_SEPARATOR, '', $file);
        $zip->addFile($file, $relativePath);
    }

    // 2. เพิ่ม procedure_ipd.txt ใหม่จาก exportDir
    $relativeNewProcedure = 'procedure_ipd.txt';
    $zip->addFile($newProcedurePath, $relativeNewProcedure);

    $zip->close();

    // ลบไฟล์และโฟลเดอร์ใน extractDir
    if (is_dir($extractDir)) {
        FileHelper::removeDirectory($extractDir);
    }

    // ลบไฟล์และโฟลเดอร์ใน @webroot/uploads/file
    $fileDir = Yii::getAlias('@webroot/uploads/file');
    if (is_dir($fileDir)) {
        FileHelper::removeDirectory($fileDir);
    }

} else {
    Yii::$app->session->setFlash('error', 'สร้างไฟล์ zip ใหม่ไม่สำเร็จ');
    return $this->redirect(['import-zip']);
}
*?

/*
$zip = new ZipArchive();
if ($zip->open($newZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
    // 1. เพิ่มไฟล์ทั้งหมดจาก extractDir (ยกเว้น procedure_ipd.txt)
    $extractedFiles = FileHelper::findFiles($extractDir);

    foreach ($extractedFiles as $file) {
        if (basename($file) === 'procedure_ipd.txt') {
            continue; // ข้ามไฟล์เก่า
        }

        // ทำ path ให้สัมพันธ์จากโฟลเดอร์ export (หรือใส่เป็นโฟลเดอร์ extract/)
        $relativePath = 'extract/' . str_replace($extractDir . DIRECTORY_SEPARATOR, '', $file);
        $zip->addFile($file, $relativePath);
    }

    // 2. เพิ่ม procedure_ipd.txt ใหม่จาก exportDir
    $relativeNewProcedure = 'procedure_ipd.txt';
    $zip->addFile($newProcedurePath, $relativeNewProcedure);

    $zip->close();
} else {
    Yii::$app->session->setFlash('error', 'สร้างไฟล์ zip ใหม่ไม่สำเร็จ');
    return $this->redirect(['import-zip']);
}


            // ส่งไฟล์ zip กลับดาวน์โหลด
            return Yii::$app->response->sendFile($newZipPath);
        }

        return $this->render('import-zip', ['model' => $model]);
    }

*/


######################################################################################################
public function actionImport()
{
    $model = new Importtxtproc();
    $extractedPath = null;

    if (Yii::$app->request->isPost) {
        $model->uploadFile = UploadedFile::getInstance($model, 'uploadFile');

        if ($model->uploadFile && $model->validate()) {
            $uploadPath = Yii::getAlias('@webroot/uploads/');
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $zipFile = $uploadPath . $model->uploadFile->baseName . '.' . $model->uploadFile->extension;
            $model->uploadFile->saveAs($zipFile);

            // Extract
            $zip = new \ZipArchive;
            if ($zip->open($zipFile) === true) {
                $extractTo = $uploadPath . $model->uploadFile->baseName;
                if (!is_dir($extractTo)) {
                    mkdir($extractTo, 0777, true);
                }
                $zip->extractTo($extractTo);
                $zip->close();

                Yii::$app->session->setFlash('success', 'ZIP extracted successfully.');
                $extractedPath = $extractTo;
            } else {
                Yii::$app->session->setFlash('error', 'Failed to open ZIP file.');
            }
        }
    }

    return $this->render('import', [
        'model' => $model,
        'extractedPath' => $extractedPath
    ]);
}

public function actionProcess()
{
    $path = Yii::$app->request->post('extractedPath');
    // ทำการอ่านและประมวลผลไฟล์ .txt หรืออื่น ๆ ใน $path

    Yii::$app->session->setFlash('success', 'Text file imported successfully.');
    return $this->redirect(['import']);
}
}
