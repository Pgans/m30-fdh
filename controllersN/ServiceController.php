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

class ServiceController extends \yii\web\Controller
{
    public function actionIndex( )
    {
        $data = Yii::$app->request->post();
        $year =isset($data['txt_year'])  ? $data['txt_year'] : '';
        $month =isset($data['txt_month'])  ? $data['txt_month'] : '';

           $strSQL = "SELECT  s.hospcode , c.hosname as hospname,day(s.date_serv) as dateserv, COUNT(s.seq) as seq
           FROM service s
           INNER JOIN chospital c ON s.hospcode = c.hoscode
           WHERE DATE_FORMAT(s.DATE_SERV,'%Y-%m') LIKE '$year-$month%'
           #WHERE  s.DATE_SERV LIKE '23-01'--LIKE '$year-$month%'
           GROUP BY s.HOSPCODE, DAY(s.DATE_SERV) ";
            
                    $day = Yii::$app->db_host->createCommand($strSQL)->queryAll();
                    foreach($day as $row){
                        $allReportData[$row['hospcode']][$row['dateserv']] = $row['seq'];
                      }
                   // echo $year;
                    echo $month;
                    //    echo "<pre>";
                    //    print_r($allReportData);
                    //    echo "</pre>";
      //yii2 dropdownlist no model        
################################################################################
        
        $hcode = " SELECT distinct s.hospcode, c.hosname as hospname
        FROM service s
        INNER JOIN chospital c ON s.hospcode = c.hoscode
         --  WHERE DATE_FORMAT(s.DATE_SERV,'%Y-%m') LIKE '$year-$month%'
         WHERE s.DATE_SERV between '2023-01-01' and NOW()
        GROUP BY s.HOSPCODE, s.DATE_SERV";
         
         $data = Yii::$app->db_host->createCommand($hcode)->queryAll();
         foreach($data as $row){
            $allEmpData[$row['hospcode']] = $row['hospname'];
           }
           // echo "<pre>";
          //  print_r($allEmpData);
          //  echo "</pre>";

                    return $this->render('index',[
                        'allEmpData'=> $allEmpData,
                        'allReportData'=> $allReportData,
                        
                    ]);
                }
    
 public function actionCheck(){
    
     $strSQL = "SELECT  s.hospcode , c.hosname as hospname,day(s.date_serv) as dateserv, COUNT(s.seq) as seq
     FROM service s
     INNER JOIN chospital c ON s.hospcode = c.hoscode
     WHERE s.DATE_SERV between '2023-01-01 00:00' and NOW()
     GROUP BY s.HOSPCODE, DAY(s.DATE_SERV) ";
 //$strSQL.= "WHERE `bk_date` LIKE '$year-$month%' ";
 //$strSQL.= "GROUP by bk_user_code,DAY(`bk_date`)";
 $data = \yii::$app->db_host->createCommand($strSQL)->queryAll();
 
       print_r($data);
       //print_r($allReportData);

    }
    public function actionAlldata(){
        
        $strSQL = "SELECT  s.hospcode , c.hosname as hospname,day(s.date_serv) as dateserv, COUNT(s.seq) as seq
        FROM service s
        INNER JOIN chospital c ON s.hospcode = c.hoscode
        WHERE s.DATE_SERV between '2023-01-20 00:00' and NOW()
        GROUP BY s.HOSPCODE, DAY(s.DATE_SERV) ";
         
        
                 $data = Yii::$app->db_host->createCommand($strSQL)->queryAll();
                 foreach($data as $row){
                    $allEmpData[$row['hospcode']] = $row['hospname'];
                   }
                    echo "<pre>";
                    print_r($allEmpData);
                    echo "</pre>";
                   
               // print_r($allEmpData);
    }
}
   
