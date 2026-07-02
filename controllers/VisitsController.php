<?php

namespace app\controllers;

use yii;
class VisitsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionAdjipd(){
		$data = Yii::$app->request->post();
		$date1 = isset($data['date1']) ? $data['date1'] : '';
		$date2 = isset($data['date2']) ? $data['date2'] : '';
		
        $sql = "SELECT  date(a.REG_DATETIME) as REGDATE,
        COUNT(CASE WHEN a.UNIT_REG  THEN '10' END) AS 'TOTAL',  
COUNT(CASE WHEN a.UNIT_REG =02 THEN '1' END) AS 'OPD',
COUNT(CASE WHEN (a.UNIT_REG in(11,53) AND HOUR(a.REG_DATETIME) BETWEEN 0 AND 7 ) THEN '2' END) AS 'ERดึก',
        COUNT(CASE WHEN (a.UNIT_REG in(11,53) AND HOUR(a.REG_DATETIME) BETWEEN 8 AND 15 ) THEN '2' END) AS 'ERเช้า',
        COUNT(CASE WHEN (a.UNIT_REG in(11,53) AND HOUR(a.REG_DATETIME) BETWEEN 16 AND 23 ) THEN '2' END) AS 'ERบ่าย',
        COUNT(CASE WHEN a.UNIT_REG =22 THEN '2' END) AS 'LR',
        COUNT(CASE WHEN a.UNIT_REG =31 THEN '3' END) AS 'PHISICAL',
                   COUNT(CASE WHEN a.UNIT_REG =26 THEN '4' END) AS 'THAIMED',
                   COUNT(CASE WHEN a.UNIT_REG in(03,04,05) THEN '5' END) AS 'DENT',
                   COUNT(CASE WHEN a.UNIT_REG in(12,14,15,16,34,51) THEN '6' END) AS 'NCD',
        COUNT(CASE WHEN a.UNIT_REG = 35 THEN '7' END ) AS 'ARI',
                        COUNT(CASE WHEN a.UNIT_REG = 40 THEN '8' END) AS 'VIP',
        COUNT(CASE WHEN a.UNIT_REG = 27 THEN '9' END) AS 'ANC',
        COUNT(CASE WHEN a.UNIT_REG in(13,17,18,20,37,44,46,49) THEN '10' END) AS 'AIDS',
        COUNT(CASE WHEN a.UNIT_REG = 19 THEN '11' END) AS 'TB',
        COUNT(CASE WHEN a.UNIT_REG = 45 THEN '12' END) AS 'PCU',
        COUNT(CASE WHEN a.UNIT_REG = 47 THEN '13' END) AS 'ACU',
        COUNT(CASE WHEN a.UNIT_REG in (36,43) THEN '14' END) AS 'CAPD',
        COUNT(CASE WHEN a.UNIT_REG = 42 THEN '15' END) AS 'HD',
        COUNT(CASE WHEN a.UNIT_REG = 28 THEN '16' END) AS 'elderly',
        COUNT(CASE WHEN a.UNIT_REG = 63 THEN '17' END) AS 'Telemed',
        COUNT(CASE WHEN a.UNIT_REG NOT IN (11,02,35,03,04,05,12,14,15,16,34,51,40,19,26,28,42,47,36,43,13,17,18,20,37,44,46,31,45,27,22,49,51,53,63)  THEN '18' END) AS 'ORTHER'
        FROM opd_visits a
        INNER JOIN opd_diagnosis od ON od.visit_id = a.visit_id AND dxt_id = 1 AND od.is_cancel = 0  
        AND a.VISIT_ID not in (select m.visit_id from mobile_visits m WHERE m.is_cancel = 0)
        AND a.IS_CANCEL = 0
           WHERE a.REG_DATETIME BETWEEN CURDATE() AND NOW()
        GROUP BY REGDATE
         ";
        $rawData = \yii::$app->db14->createCommand($sql)->queryAll();
       try {
           $rawData = \Yii::$app->db14->createCommand($sql)->queryAll();
       } catch (\yii\db\Exception $e) {
           throw new \yii\web\ConflictHttpException('sql error');
       }
       
       $dataProvider = new \yii\data\ArrayDataProvider([
           'allModels' => $rawData,
           'pagination' => [
            'pageSize' => 200,
            ],
       ]);
    
       return $this->render('adj_ipd', [
					//'searchModel'=>$searchModel,
                   'dataProvider' => $dataProvider,
                   'sql'=>$sql,
                   'date1'=>$date1,
                   'date2'=>$date2,
                    ]);   
   }
}
