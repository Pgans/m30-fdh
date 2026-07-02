<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class OpucsController extends Controller
{
	
	
	 public function actionOpucin(){
		$data = Yii::$app->request->post();
		 $data = Yii::$app->request->post();
		$date1 = isset($data['date1']) && $data['date1'] !== ''
		? date('Y-m-d 00:01', strtotime($data['date1']))
		: date('Y-m-d 00:01'); // วันนี้ตอน 00:01

		 $date2 = isset($data['date2']) && $data['date2'] !== ''
		? date('Y-m-d 23:59', strtotime($data['date2']))
		: date('Y-m-d 23:59'); // วันนี้ตอน 23:59

		
        $sql = "SELECT c.CID, a.HN,a.VISIT_ID, a.REG_DATETIME, c.FNAME, c.LNAME,
			CASE 
			WHEN a.INSCL in (03,04) AND g.HOSPMAIN ='10953' THEN CONCAT(m.INSCL_NAME,' --ในเขต') 
			WHEN a.INSCL in (03,04) AND g.HOSPMAIN !='10953' THEN CONCAT(m.INSCL_NAME,' --นอกเขต  ในจังหวัด') 
			ELSE m.INSCL_NAME 
			END as 'สิทธิ์',
			CASE 
			 WHEN a.INSCL in ('18','19','00','23') THEN ''
			 when g.HOSPMAIN !='' THEN g.HOSPMAIN
			ELSE ''
			END as Hmain,
			case 
			 when a.INSCL not in ('03','04','33') THEN ''
			 when g.HOSPSUB !='' THEN g.HOSPSUB
			ELSE ''
			END as Hsub,
			h.HOSP_NAME,
			CASE 
			 WHEN a.INSCL in ('18','19','00','23') THEN ''
			 WHEN g.UC_REGISTER !='' THEN g.UC_REGISTER
			ELSE ''
			END as Start_date,
			CASE
			 when a.INSCL in ('18','19','00','23') THEN ''
			 when g.UC_EXPIRE !='' THEN g.UC_EXPIRE
			ELSE ''
			END as Expire_date
			#, g.HOSPSUB,g.UC_REGISTER,g.UC_EXPIRE, h.HOSP_ID as 'รพ.ปกส.',h.SSS_DATE,h.EXP_DATE
			FROM opd_visits a LEFT JOIN cid_hn b on a.HN = b.HN
			LEFT JOIN population c on b.CID = c.CID
			LEFT JOIN main_inscls m ON a.INSCL = m.INSCL
			LEFT JOIN uc_inscl g ON c.CID= g.CID AND (g.date_abort > date(a.REG_DATETIME) OR DAY(g.DATE_ABORT)=0)  and trim(g.hospmain) <>''
			INNER JOIN hosp3400 j ON j.HOSP_ID = g.HOSPMAIN
			LEFT JOIN hospitals h ON h.HOSP_ID = g.HOSPMAIN
			WHERE a.IS_CANCEL = 0
			AND a.REG_DATETIME BETWEEN '$date1' AND '$date2'
			AND g.HOSPMAIN <> '10953'
			GROUP BY a.VISIT_ID
			ORDER BY a.INSCL
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
    
       return $this->render('opucin', [
					//'searchModel'=>$searchModel,
                   'dataProvider' => $dataProvider,
                   'sql'=>$sql,
                   'date1'=>$date1,
                   'date2'=>$date2,
                    ]);   
   }
   ##############################################################################################################################
    public function actionOpucout(){
		$data = Yii::$app->request->post();
		$data = Yii::$app->request->post();
		$date1 = isset($data['date1']) && $data['date1'] !== ''
		? date('Y-m-d 00:01', strtotime($data['date1']))
		: date('Y-m-d 00:01'); // วันนี้ตอน 00:01

		 $date2 = isset($data['date2']) && $data['date2'] !== ''
		? date('Y-m-d 23:59', strtotime($data['date2']))
		: date('Y-m-d 23:59'); // วันนี้ตอน 23:59

		 //$date1 = isset($data['date1']) ? date('Y-m-d 00:01', strtotime($data['date1'])) : '';
         //$date2 = isset($data['date2']) ? date('Y-m-d 23:59', strtotime($data['date2'])) : '';
		
        $sql = "SELECT c.CID, a.HN,a.VISIT_ID, a.REG_DATETIME, c.FNAME, c.LNAME,
			CASE 
			WHEN a.INSCL in (03,04) AND g.HOSPMAIN ='10953' THEN CONCAT(m.INSCL_NAME,' --ในเขต') 
			WHEN a.INSCL in (03,04) AND g.HOSPMAIN !='10953' THEN CONCAT(m.INSCL_NAME,' --นอกเขต  นอกจังหวัด') 
			ELSE m.INSCL_NAME 
			END as 'สิทธิ์',
			CASE 
			 WHEN a.INSCL in ('18','19','00','23') THEN ''
			 when g.HOSPMAIN !='' THEN g.HOSPMAIN
			ELSE ''
			END as Hmain,
			case 
			 when a.INSCL not in ('03','04','33') THEN ''
			 when g.HOSPSUB !='' THEN g.HOSPSUB
			ELSE ''
			END as Hsub,
			h.HOSP_NAME,
			CASE 
			 WHEN a.INSCL in ('18','19','00','23') THEN ''
			 WHEN g.UC_REGISTER !='' THEN g.UC_REGISTER
			ELSE ''
			END as Start_date,
			CASE
			 when a.INSCL in ('18','19','00','23') THEN ''
			 when g.UC_EXPIRE !='' THEN g.UC_EXPIRE
			ELSE ''
			END as Expire_date
			#, g.HOSPSUB,g.UC_REGISTER,g.UC_EXPIRE, h.HOSP_ID as 'รพ.ปกส.',h.SSS_DATE,h.EXP_DATE
			FROM opd_visits a LEFT JOIN cid_hn b on a.HN = b.HN
			LEFT JOIN population c on b.CID = c.CID
			LEFT JOIN main_inscls m ON a.INSCL = m.INSCL
			LEFT JOIN uc_inscl g ON c.CID= g.CID AND (g.date_abort > date(a.REG_DATETIME) OR DAY(g.DATE_ABORT)=0)  and trim(g.hospmain) <>''
			#LEFT JOIN JOIN hosp3400 j ON j.HOSP_ID = g.HOSPMAIN
			LEFT JOIN hospitals h ON h.HOSP_ID = g.HOSPMAIN
			WHERE a.IS_CANCEL = 0
			AND a.REG_DATETIME BETWEEN '$date1' AND '$date2'
			AND g.HOSPMAIN <> '10953'
			AND g.HOSPMAIN NOT IN (SELECT hos.HOSP_ID FROM hosp3400 hos)
			GROUP BY a.VISIT_ID
			ORDER BY a.INSCL
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
    
       return $this->render('opucout', [
					//'searchModel'=>$searchModel,
                   'dataProvider' => $dataProvider,
                   'sql'=>$sql,
                   'date1'=>$date1,
                   'date2'=>$date2,
                    ]);   
   }
   
}

