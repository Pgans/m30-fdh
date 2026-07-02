<?php

namespace app\controllers;

use Yii;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\editable\Editable;
use yii\widgets\Pjax;
use app\models\Service;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;


class DrugopdController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $data = Yii::$app->request->post();
        $year = isset($data['txt_year'])  ? $data['txt_year'] : '';
        $month = isset($data['txt_month'])  ? $data['txt_month'] : '';
        $hospcode = isset($data['hospcode'])  ? $data['hospcode'] : '';

        $strSQL = "SELECT d.hospcode , d.didstd, d.dname, sum(d.amount) amount , day(d.date_serv) as dateserv
           FROM drug_opd d
           WHERE DATE_FORMAT(d.DATE_SERV,'%Y-%m') LIKE '$year-$month%'
           AND d.hospcode = '$hospcode'
           GROUP BY d.DIDSTD, d.date_serv ";

        $day = Yii::$app->db_host->createCommand($strSQL)->queryAll();
        foreach ($day as $row) {
            $allReportData[$row['didstd']][$row['dateserv']] = $row['amount'];
        }



        ################################################################################

        $hcode = " SELECT d.hospcode , d.didstd, d.dname, d.amount , day(d.date_serv) as dateserv
        FROM drug_opd d
        WHERE d.date_serv BETWEEN CURDATE()-2 AND NOW()
        AND d.hospcode = '03693'
        GROUP BY  d.didstd, d.date_serv ";

        $data = Yii::$app->db_host->createCommand($hcode)->queryAll();
        foreach ($data as $row) {
            $allEmpData[$row['didstd']] = $row['didstd'] = $row['dname'];
        }
        //echo "<pre>";
        // print_r($allEmpData);
        // echo "</pre>";
        $hcode = "";

        // ตรวจสอบค่าพารามิเตอร์ type เพื่อกำหนดข้อมูลที่ต้องการแสดง
        $type = Yii::$app->request->get('type');
        if ($type === 'allEmpData') {
            $dataToShow = $allEmpData;
        } elseif ($type === 'allReportData') {
            $dataToShow = $allReportData;
        } else {
            $dataToShow = []; // หรือกำหนดค่าเริ่มต้นที่คุณต้องการ
        }
        return $this->render('index', [
            'allEmpData' => $allEmpData,
            'allReportData' => $allReportData,
            'dataToShow' => $dataToShow,
        'hospcode' => $hospcode,

        ]);
    }
    public function actionGridview($type)
    {
        $dataProvider = null;
        $columns = [];
    
        if ($type === 'allEmpData') {
            // สร้าง DataProvider สำหรับ allEmpData และกำหนดคอลัมน์ที่ต้องการแสดง
            $dataProvider = new \yii\data\ArrayDataProvider([
                'allModels' => $allEmpData,
            ]);
            $columns = [
                'dname',
                // เพิ่มคอลัมน์เพิ่มเติมตามความต้องการ
            ];
        } elseif ($type === 'allReportData') {
            // สร้าง DataProvider สำหรับ allReportData และกำหนดคอลัมน์ที่ต้องการแสดง
            $dataProvider = new \yii\data\ArrayDataProvider([
                'allModels' => $allReportData,
            ]);
            $columns = [
                'dname',
                // เพิ่มคอลัมน์เพิ่มเติมตามความต้องการ
            ];
        }
    
        return $this->render('gridview', [
            'dataProvider' => $dataProvider,
            'columns' => $columns,
            'hospcode' => $hospcode,
        ]);
    }
    

    public function actionDrugzone()
    {

        $data = Yii::$app->request->post();
        // $date1 = "20230101";
        // $date2 = date('Y-m-d');
        $date1 = isset($data['date1']) ? $data['date1'] : '';
        $date2 = isset($data['date2']) ? $data['date2'] : '';
        $items = isset($data['items'])  ? $data['items'] : NUll;
        $items1 = isset($data['items1'])  ? $data['items1'] : NUll;
        $items2 = isset($data['items2'])  ? $data['items2'] : NUll;
        $items3 = isset($data['items3'])  ? $data['items3'] : NUll;

        if (count($items) > 0) {  // ตรวจสอบ checkbox ว่ามีการเลือกมาอย่างน้อย 1 รายการหรือไม่
            // $hcode = [];
            foreach ($items as $i => $hcode) {
                // var_dump($hcode, $items1[$i], $item2[$i]);
                // echo "$x = $hcode <br>";
                $code[] = $hcode;
                $hospcode =  implode("','", $code);
                // print_r($hospcode);
            }
        }
        if (count($items1) > 0) {
            $hcode1 = [];
            foreach ($items1 as $i => $hcode1) {
                $code1[] = $hcode1;
                $hospcode1 =  implode("','", $code1);
                //  print_r($hospcode1);
            }
        }
        if (count($items2) > 0) {
            $hcode1 = [];
            foreach ($items2 as $i => $hcode2) {
                $code2[] = $hcode2;
                $hospcode2 =  implode("','", $code2);
                //  print_r($hospcode1);
            }
        }
        if (count($items3) > 0) {
            $hcode3 = [];
            foreach ($items3 as $i => $hcode3) {
                $code3[] = $hcode3;
                $hospcode3 =  implode("','", $code3);
                //  print_r($hospcode1);
            }
        }
        $sql = "SELECT k.hospcode, k.hospname ,k.didstd ,k.dname , k.amount,  k.unit_packing, k.unit_packing, k.unit_name
                        FROM (
                        SELECT DISTINCT d.hospcode , c.hospname , d.didstd, d.dname, sum(d.amount) amount, d.unit , d.unit_packing,
                         IF(l.unit_name is null = '', l.unit_name,'') as unit_name
                        FROM drug_opd d
                        LEFT  JOIN l_unit_drugs l on l.unit_id = d.unit_packing
                        INNER JOIN chospital_muang c ON d.hospcode = c.hospcode
                        WHERE d.date_serv between  '$date1' and '$date2'
                        AND d.hospcode in ('$hospcode','$hospcode1','$hospcode2','$hospcode3')
                        GROUP BY  d.didstd, d.hospcode
                        ORDER BY HOSPCODE) as k
                        ";

        $rawData = \yii::$app->db_host->createCommand($sql)->queryAll();

        try {
            $rawData = \Yii::$app->db_host->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        //$model->date_admit = date('Y-m-d');
        $drugProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => FALSE,
        ]);
        // $sql1 = $sql;
        $sql1 = "SELECT k.date_serv, k.seq, k.hospcode, k.hospname ,k.didstd ,k.dname , k.amount,  k.unit_packing, k.unit_packing, k.unit_name
               FROM (
               SELECT DISTINCT d.date_serv,d.seq ,d.hospcode , c.hospname , d.didstd, d.dname, sum(d.amount) amount, d.unit , d.unit_packing,
                IF(l.unit_name is null = '', l.unit_name,'') as unit_name
               FROM drug_opd d
               LEFT  JOIN l_unit_drugs l on l.unit_id = d.unit_packing
               INNER JOIN chospital_muang c ON d.hospcode = c.hospcode
               WHERE d.date_serv >=  CURDATE() - INTERVAL 7 DAY
               #AND d.hospcode in ('$hospcode','$hospcode1','$hospcode2','$hospcode3')
               GROUP BY  d.date_serv ,d.didstd, d.hospcode
               ORDER BY DATE_SERV,HOSPCODE) as k
                  
                   
               ";
        $rawData1 = \yii::$app->db_host->createCommand($sql1)->queryAll();
        $sqlProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData1,
            'pagination' => FALSE,
        ]);
        // print_r($sqlProvider);
        return $this->render('drug_zone', [
            'drugProvider' => $drugProvider,
            'sqlProvider' => $sqlProvider,
            //'dataExport' => $dataExport,
            'sql' => $sql,
            'date1' => $date1,
            'date2' => $date2,


        ]);
    }
    public function actionDrugsday()
    {
        $data = Yii::$app->request->post();
        $year = isset($data['txt_year'])  ? $data['txt_year'] : '';
        $month = isset($data['txt_month'])  ? $data['txt_month'] : '';
        $hospcode = isset($data['hospcode'])  ? $data['hospcode'] : '';

        //$didstd = isset($data['didstd'])  ? $data['disstd'] : '';
        //$dname = isset($data['dname'])  ? $data['dname'] : '';

        $sql = "SELECT d.hospcode, d.pid, d.seq, d.date_serv, d.didstd, d.dname, d.amount, d.unit,d.provider, d.cid, d.d_update, d.usage_line1 
        FROM drug_opd d
        WHERE DATE_FORMAT(d.DATE_SERV,'%Y-%m') LIKE '$year-$month%'
        AND d.hospcode = '$hospcode'
        GROUP BY d.didstd, d.date_serv ";
        
        $rawData = \yii::$app->db_host->createCommand($sql)->queryAll();
        //print_r($rawData);
        try {
            $rawData = \Yii::$app->db_host->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => FALSE,
        ]);
       
        return $this->render('view', [
                    'dataProvider' => $dataProvider,
                    'sql'=>$sql,
                    

        ]);
    }
}
