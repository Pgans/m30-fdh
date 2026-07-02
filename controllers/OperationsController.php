<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class OperationsController extends Controller
{
	
	
	 public function actionIndex(){
		$data = Yii::$app->request->post();
		$date1 = isset($data['date1']) && $data['date1'] !== ''
    ? date('Y-m-d 00:01', strtotime($data['date1']))
    : date('Y-m-d 00:01'); // วันนี้ตอน 00:01

     $date2 = isset($data['date2']) && $data['date2'] !== ''
    ? date('Y-m-d 23:59', strtotime($data['date2']))
    : date('Y-m-d 23:59'); // วันนี้ตอน 23:59

		 //$date1 = isset($data['date1']) ? date('Y-m-d 00:01', strtotime($data['date1'])) : '';
        // $date2 = isset($data['date2']) ? date('Y-m-d 23:59', strtotime($data['date2'])) : '';
		
        $sql = "SELECT DISTINCT
                  a.hn as hn, a.visit_id,
                  CONCAT(trim(fname),' ',lname) as fullname,
				  TIMESTAMPDIFF(year,p.BIRTHDATE,a.REG_DATETIME) as age,
				  u.unit_name,
                  DATE(a.REG_DATETIME) AS date_serv,
                  TIME(a.REG_DATETIME) AS time_serv,
                  c.CODE AS procedure_code,
                  IF(c.TNAME = '', c.NICKNAME, c.TNAME) AS procedure_name,
				  m.inscl_name,
				  ak.claimcode,
				  cv.claimcode as closeclaim
								
              FROM
                 opd_visits a
				 INNER JOIN cid_hn e ON e.hn = a.HN
				 LEFT JOIN population p ON p.cid = e.cid
				 LEFT JOIN opd_operations b ON a.VISIT_ID = b.VISIT_ID AND b.IS_CANCEL = 0 
                 LEFT JOIN icd9cm c ON b.icd9 = c.ICD9 AND left(c.code,4) <> 'XXXX' AND c.code <> '' 
			     LEFT JOIN service_units u ON u.UNIT_ID = a.UNIT_REG 
				 LEFT JOIN main_inscls m ON a.INSCL = m.INSCL
				 LEFT JOIN authen_kiosk ak ON p.CID=ak.cid  AND date(a.REG_DATETIME)=date(ak.d_update)
				 LEFT JOIN close_visits cv ON  cv.visit_id = a.visit_id   AND cv.is_cancel = 0
                 WHERE a.REG_DATETIME BETWEEN '$date1' AND '$date2'
				AND a.is_cancel = 0
				AND c.CODE IN ('92.02')
				#AND (a.unit_reg = '11' OR a.unit_id = '11' OR a.unit_reg = '53' )
							
         ";
        $rawData = \yii::$app->db2->createCommand($sql)->queryAll();
       try {
           $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
       } catch (\yii\db\Exception $e) {
           throw new \yii\web\ConflictHttpException('sql error');
       }
       
       $dataProvider = new \yii\data\ArrayDataProvider([
           'allModels' => $rawData,
           'pagination' => [
            'pageSize' => 200,
            ],
       ]);
    
       return $this->render('index', [
					//'searchModel'=>$searchModel,
                   'dataProvider' => $dataProvider,
                   'sql'=>$sql,
                   'date1'=>$date1,
                   'date2'=>$date2,
                    ]);   
   }
   ##############################################################################################################################
    public function actionIcd8838(){
		$data = Yii::$app->request->post();
		 $date1 = isset($data['date1']) && $data['date1'] !== ''
		? date('Y-m-d 00:01', strtotime($data['date1']))
		: date('Y-m-d 00:01'); // วันนี้ตอน 00:01

		 $date2 = isset($data['date2']) && $data['date2'] !== ''
		? date('Y-m-d 23:59', strtotime($data['date2']))
		: date('Y-m-d 23:59'); // วันนี้ตอน 23:59
		
        $sql = "SELECT DISTINCT
                  a.hn as hn, a.visit_id,
                  CONCAT(trim(fname),' ',lname) as fullname,
				  TIMESTAMPDIFF(year,p.BIRTHDATE,a.REG_DATETIME) as age,
				  u.unit_name,
                  DATE(a.REG_DATETIME) AS date_serv,
                  TIME(a.REG_DATETIME) AS time_serv,
                  c.CODE AS procedure_code,
                  IF(c.TNAME = '', c.NICKNAME, c.TNAME) AS procedure_name,
				  m.inscl_name,
				  ak.claimcode,
				  cv.claimcode as closeclaim
								
              FROM
                 opd_visits a
				 INNER JOIN cid_hn e ON e.hn = a.HN
				 LEFT JOIN population p ON p.cid = e.cid
				 LEFT JOIN opd_operations b ON a.VISIT_ID = b.VISIT_ID AND b.IS_CANCEL = 0 
                 LEFT JOIN icd9cm c ON b.icd9 = c.ICD9 AND left(c.code,4) <> 'XXXX' AND c.code <> '' 
			     LEFT JOIN service_units u ON u.UNIT_ID = a.UNIT_REG 
				 LEFT JOIN main_inscls m ON a.INSCL = m.INSCL
				 LEFT JOIN authen_kiosk ak ON p.CID=ak.cid  AND date(a.REG_DATETIME)=date(ak.d_update)
				 LEFT JOIN close_visits cv ON  cv.visit_id = a.visit_id   AND cv.is_cancel = 0
                 WHERE a.REG_DATETIME BETWEEN '$date1' AND '$date2'
				AND a.is_cancel = 0
				AND c.CODE IN ('88.38')
				  ";
        $rawData = \yii::$app->db2->createCommand($sql)->queryAll();
       try {
           $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
       } catch (\yii\db\Exception $e) {
           throw new \yii\web\ConflictHttpException('sql error');
       }
       
       $dataProvider = new \yii\data\ArrayDataProvider([
           'allModels' => $rawData,
           'pagination' => [
            'pageSize' => 200,
            ],
       ]);
    
       return $this->render('icd8838', [
					//'searchModel'=>$searchModel,
                   'dataProvider' => $dataProvider,
                   'sql'=>$sql,
                   'date1'=>$date1,
                   'date2'=>$date2,
                    ]);   
   }
   
}

