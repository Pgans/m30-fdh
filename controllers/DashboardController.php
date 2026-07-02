<?php

namespace app\controllers;

use Yii;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\editable\Editable;
use yii\widgets\Pjax;
use app\models\Service;
class DashboardController extends \yii\web\Controller
{
    public function actionIndex()
    {
    
        $data = Yii::$app->request->post();
        $year =isset($data['txt_year'])  ? $data['txt_year'] : '';
        $month =isset($data['txt_month'])  ? $data['txt_month'] : '';

           $strSQL = "SELECT '01' as code,'phr' as name,day((p.d_update)) as dateserv,
           COUNT(CASE WHEN p.status = '200' THEN '1' END) as 'T',
           COUNT(CASE WHEN p.status <> '200' THEN '2'END) as 'F' 
           FROM log_phr p
           WHERE DATE_FORMAT(p.d_update,'%Y-%m') LIKE '$year-$month%'
           GROUP BY day(p.d_update)
           UNION
           SELECT '02' as code,'dm'as name,day((p.d_update)) as dateserv,
           COUNT(CASE WHEN p.messagecode = 'success' THEN '1' END) as 'T',
           COUNT(CASE WHEN p.messagecode <> 'success' THEN '2'END) as 'F' 
           FROM log_dm p
           WHERE DATE_FORMAT(p.d_update,'%Y-%m') LIKE '$year-$month%'
           GROUP BY day(p.d_update)
           UNION
           SELECT '03' as code,'ht'as name,day((p.d_update)) as dateserv,
           COUNT(CASE WHEN p.messagecode = 'success' THEN '1' END) as 'T',
           COUNT(CASE WHEN p.messagecode <> 'success' THEN '2'END) as 'F' 
           FROM log_dmht p
           WHERE DATE_FORMAT(p.d_update,'%Y-%m') LIKE '$year-$month%'
           GROUP BY day(p.d_update)
           UNION
           SELECT '04' as code,'dt'as name,day((p.d_update)) as dateserv,
           COUNT(CASE WHEN p.messagecode = 'success' THEN '1' END) as 'T',
           COUNT(CASE WHEN p.messagecode <> 'success' THEN '2'END) as 'F' 
           FROM log_dt p
           WHERE DATE_FORMAT(p.d_update,'%Y-%m') LIKE '$year-$month%'
           GROUP BY day(p.d_update)
           UNION
           SELECT '05' as code,'epidem'as name,day((p.d_update)) as dateserv,
           COUNT(CASE WHEN p.messagecode = '200' THEN '1' END) as 'T',
           COUNT(CASE WHEN p.messagecode <> '200' THEN '2'END) as 'F' 
           FROM log_epidem p
           WHERE DATE_FORMAT(p.d_update,'%Y-%m') LIKE '$year-$month%'
           GROUP BY day(p.d_update) ";
            
                    $day = Yii::$app->db2->createCommand($strSQL)->queryAll();
                    foreach($day as $row){
                        $allReportData[$row['code']][$row['dateserv']] = $row['T'];
                      }
                 
################################################################################
        
        $hcode = " SELECT '01' as code,'phr' as name,day((p.d_update)) as dateserv,
        COUNT(CASE WHEN p.status = '200' THEN '1' END) as 'T',
        COUNT(CASE WHEN p.status <> '200' THEN '2'END) as 'F' 
        FROM log_phr p
        WHERE p.d_update BETWEEN '2023-01-01' AND NOW()
        GROUP BY day(p.d_update)
        UNION
        SELECT '02' as code,'dm'as name,day((p.d_update)) as dateserv,
        COUNT(CASE WHEN p.messagecode = 'success' THEN '1' END) as 'T',
        COUNT(CASE WHEN p.messagecode <> 'success' THEN '2'END) as 'F' 
        FROM log_dm p
        WHERE p.d_update BETWEEN '2023-01-01' AND NOW()
        GROUP BY day(p.d_update)
        UNION
        SELECT '03' as code,'ht'as name,day((p.d_update)) as dateserv,
        COUNT(CASE WHEN p.messagecode = 'success' THEN '1' END) as 'T',
        COUNT(CASE WHEN p.messagecode <> 'success' THEN '2'END) as 'F' 
        FROM log_dmht p
        WHERE p.d_update BETWEEN '2023-01-01' AND NOW()
        GROUP BY day(p.d_update)
        UNION
        SELECT '04' as code,'dt'as name,day((p.d_update)) as dateserv,
        COUNT(CASE WHEN p.messagecode = 'success' THEN '1' END) as 'T',
        COUNT(CASE WHEN p.messagecode <> 'success' THEN '2'END) as 'F' 
        FROM log_dt p
        WHERE p.d_update BETWEEN '2023-01-01' AND NOW()
        GROUP BY day(p.d_update)
        UNION
        SELECT '05' as code,'epidem'as name,day((p.d_update)) as dateserv,
        COUNT(CASE WHEN p.messagecode = '200' THEN '1' END) as 'T',
        COUNT(CASE WHEN p.messagecode <> '200' THEN '2'END) as 'F' 
        FROM log_epidem p
        WHERE p.d_update BETWEEN '2023-01-01' AND NOW()
        GROUP BY day(p.d_update)";
         
         $data = Yii::$app->db2->createCommand($hcode)->queryAll();
         foreach($data as $row){
            $allEmpData[$row['code']] = $row['name'];
           }
           // echo "<pre>";
          //  print_r($allEmpData);
          //  echo "</pre>";

                    return $this->render('index',[
                        'allEmpData'=> $allEmpData,
                        'allReportData'=> $allReportData,
                        
                    ]);
                }
    
    }


