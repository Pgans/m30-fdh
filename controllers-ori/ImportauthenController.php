<?php

namespace app\controllers;

use Yii;
use app\models\Authenkiosk;
//use app\models\AuthenkioskSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;


class ImportauthenController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    /*********************************************Import Files Excel******************************************/
    
    public function actionImports(){
    $modelImport = new \yii\base\DynamicModel([
                'fileImport'=>'File Import',
            ]);
    $modelImport->addRule(['fileImport'],'required');
    $modelImport->addRule(['fileImport'],'file',['extensions'=>'ods,xls,xlsx'],['maxSize'=>1024*1024]);

    if(Yii::$app->request->post()){
        $modelImport->fileImport = \yii\web\UploadedFile::getInstance($modelImport,'fileImport');
        if($modelImport->fileImport && $modelImport->validate()){
            $inputFileType = \PHPExcel_IOFactory::identify($modelImport->fileImport->tempName);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($modelImport->fileImport->tempName);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            $baseRow = 3;
            while(!empty($sheetData[$baseRow]['B'])){
                $model = new \app\models\Repimport;
                $model->hospcode = (string)$sheetData[$baseRow]['A'];
                $model->cid = (string)$sheetData[$baseRow]['C'];
                $model->visit_id= (string)$sheetData[$baseRow][''];
                $model->claimtype = (string)$sheetData[$baseRow]['L'];
                $model->claimcode = (string)$sheetData[$baseRow]['J'];
                $model->mobile = (string)$sheetData[$baseRow]['F'];
                $model->dep_name = (string)$sheetData[$baseRow]['T'];
                $model->authen_date = (string)$sheetData[$baseRow]['Q'];
                $model->d_update = (string)$sheetData[$baseRow]['G'];
                $model->save();
                $baseRow++;
            }
            Yii::$app->getSession()->setFlash('success','Success');
        }else{
            Yii::$app->getSession()->setFlash('error','Error');
        }
    }
    $connection = \Yii::$app->db_mra;
    $datap = $connection->createCommand("
           SELECT  id, hospcode,  cid, visit_id, claimtype, claimcode,  mobile,  dep_name, authen_date,  d_update
            FROM authen_kiosk
            WHERE authen_kiosk.authen_date BETWEEN CURDATE()  AND NOW()
            ORDER BY d_update DESC
        ")->queryAll();

 $importdataProvider = new ArrayDataProvider([
     'allModels' => $datap,
 ]);



    return $this->render('imports',[
            'modelImport' => $modelImport,
            'dataimport' => $importdataProvider,
            
        ]);
}

}