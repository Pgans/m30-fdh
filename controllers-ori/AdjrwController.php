<?php

namespace app\controllers;
use yii;

class AdjrwController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionRefer(){
		$data = Yii::$app->request->post();
		$date1 = isset($data['date1']) ? $data['date1'] : '';
		$date2 = isset($data['date2']) ? $data['date2'] : '';
		
        $sql = "SELECT a.rf_dt,a.VISIT_ID as seq,
        if(b.ADM_ID is null,'', b.adm_id) as an,
        c.hn as pid, c.hn as hn, 
        a.REFER_ID as referno,
        GROUP_CONCAT(DISTINCT a.HOSP_ID) as to_hcode,
        GROUP_CONCAT(DISTINCT a.rf_type) as type,     
        a.UNIT_ID as location_name,
        GROUP_CONCAT(DISTINCT trim(h.HOSP_NAME)) as to_hcode_name,
        a.crf_reason as refer_cause,
        a.STAFF_ID as doctor,
        CONCAT(trim(e.fname),' ',e.lname) as doctor_name
        FROM refers a
        LEFT JOIN ipd_reg b ON a.visit_id = b.visit_id AND b.is_cancel = 0
        LEFT JOIN opd_visits c ON a.visit_id = c.visit_id AND c.is_cancel =0
        LEFT JOIN cid_hn d ON c.hn = d.hn 
        LEFT JOIN population e ON d.cid = d.cid
        LEFT JOIN hospitals h ON a.hosp_id = h.hosp_id
        LEFT JOIN opd_diagnosis od ON c.VISIT_ID = od.VISIT_ID AND od.IS_CANCEL = 0  AND od.DXT_ID = 1
        INNER JOIN staff s ON od.STAFF_ID = s.staff_id AND s.cid = e.cid 
        WHERE  a.RF_DT >= CURDATE() - INTERVAL 6 DAY
        GROUP BY a.visit_id
        HAVING COUNT(a.hosp_id) >= 2
        ORDER BY a.visit_id DESC
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
    
       return $this->render('refer', [
					//'searchModel'=>$searchModel,
                   'dataProvider' => $dataProvider,
                   'sql'=>$sql,
                   'date1'=>$date1,
                   'date2'=>$date2,
                    ]);   
   }
    public function actionAdjipd(){
		$data = Yii::$app->request->post();
		$date1 = isset($data['date1']) ? $data['date1'] : '';
		$date2 = isset($data['date2']) ? $data['date2'] : '';
		
        $sql = "SELECT e.INSCL_NAME, COUNT(a.VISIT_ID) visits, SUM(a.ADJRW) Adjrw
        FROM ipd_reg a LEFT JOIN opd_visits b on a.VISIT_ID=b.VISIT_ID AND a.IS_CANCEL =0 
        LEFT JOIN cid_hn c ON c.HN=b.HN 
        LEFT JOIN population d on c.CID= d.CID
        LEFT JOIN main_inscls e on e.INSCL=b.INSCL
        WHERE a.DSC_DT BETWEEN '$date1' AND '$date2'
        AND b.IS_CANCEL = 0
        AND a.WARD_NO != 57
        GROUP BY b.INSCL
        ORDER BY e.INSCL_NAME	
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
   public function actionOpdtotal(){
    $data = Yii::$app->request->post();
    $date1 = isset($data['date1']) ? $data['date1'] : '';
    $date2 = isset($data['date2']) ? $data['date2'] : '';
    
    $sql = "SELECT f.INSCL_NAME as 'inscl', COUNT(DISTINCT a.VISIT_ID) as 'Visit',COUNT(DISTINCT a.HN) as 'amount'
    FROM opd_visits a LEFT JOIN cid_hn b on a.HN = b.HN
    LEFT JOIN population c on b.CID = c.CID
    LEFT JOIN main_inscls f ON a.INSCL=f.INSCL
    INNER JOIN opd_diagnosis h on h.VISIT_ID=a.VISIT_ID AND h.DXT_ID=1 AND h.IS_CANCEL = 0
    WHERE a.IS_CANCEL = 0
    AND a.REG_DATETIME BETWEEN '$date1'  AND '$date2'
    #AND HOUR(a.REG_DATETIME) BETWEEN 7 AND 15
    #AND DATE(a.REG_DATETIME) NOT in (SELECT holidays.H_DATE FROM holidays)
    #AND DAYOFWEEK(DATE(a.REG_DATETIME)) not in (1,7)
    AND a.VISIT_ID NOT in (SELECT ipd_reg.VISIT_ID FROM ipd_reg WHERE ipd_reg.IS_CANCEL = 0)
    and a.VISIT_ID not in (SELECT mobile_visits.VISIT_ID from mobile_visits WHERE mobile_visits.is_cancel = 0)
    and a.IS_CANCEL = 0
    GROUP BY f.INSCL_NAME
    ORDER BY amount DESC
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

   return $this->render('opd_total', [
                //'searchModel'=>$searchModel,
               'dataProvider' => $dataProvider,
               'sql'=>$sql,
               'date1'=>$date1,
               'date2'=>$date2,
                ]);   
}
}
