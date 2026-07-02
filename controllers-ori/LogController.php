<?php
namespace app\controllers;

use yii\helpers\Html;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use Yii;
use kartik\mpdf\Pdf;
//use mpdf\src\Config\ConfigVariables;
//use mpdf\src\Config\FontVariables;
use mPDF;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UploadCSV;
use yii\web\UploadedFile;
use app\models\Vaccinetoken;
use app\models\Dmht;

class LogController extends \yii\web\Controller
{
    public function actionIndex()
    {
       // $_token = $model->token;
       

        return $this->render('index');
    }
    ################# LOG DT ###################################
    public function actionDt() {
        $data = Yii::$app->request->post();
		$date1 = isset($data['date1']) ? $data['date1'] : '';
		$date2 = isset($data['date2']) ? $data['date2'] : '';
		
        $sql = "SELECT distinct @n :=@n +1 'No',
        o.visit_id 
        ,o.hn
        ,p.cid as pid
        , CONCAT(
              CASE 
               WHEN p.PRENAME not in('') THEN TRIM(p.PRENAME)
                           WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW())< '20' AND p.sex='1' AND p.MARRIAGE = '4'THEN 'สามเณร'
                           WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '20' AND p.sex='1' AND p.MARRIAGE  = '4'THEN 'พระภิกษุ'
                           WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='1' THEN 'เด็กชาย'
                           WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='1' THEN 'นาย'
                           WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='2' THEN 'เด็กหญิง'
                           WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='2' AND p.MARRIAGE ='1' THEN 'นางสาว'
                           ELSE 'นาง' 
                    END ,TRIM(p.FNAME),'  ',TRIM(p.LNAME)) as 'fullname'
          ,oc.oc_name as nameoccptn
          ,CASE
          WHEN p.marriage = '1' THEN '1'
          WHEN p.marriage = '2' THEN '2'
          WHEN p.marriage = '3' THEN '3'
          WHEN p.marriage = '4' THEN '6'
          ELSE '9'
          END AS marriage
        ,p.birthdate as dob
        ,p.sex
        ,timestampdiff(year,p.birthdate,o.reg_datetime) as age
        ,concat('0',n.natn_id) as nation
        ,date(o.reg_datetime) as regdate
        ,'' as code_status
        ,d.drug_id 
        ,d.drug_name
				,dt.`status`
				,dt.response
				,dt.d_update
				,u.unit_name
				,i.icd10_tm Diag
				,dt.users
				,CASE
				WHEN r.HOSP_ID is null THEN ''
				ELSE r.HOSP_ID
				END as refers
       ,CASE
				WHEN ak.claimcode is null THEN 'ว่าง'
				WHEN ak.claimcode <> '' THEN ak.claimcode
        END AS claimcode
         FROM (select @n := 0) m, opd_visits o 
         INNER JOIN cid_hn c ON o.HN=c.HN AND o.IS_CANCEL=0
         INNER JOIN population p ON p.CID=c.CID
         LEFT JOIN opd_diagnosis dx on dx.visit_id= o.visit_id AND dx.is_cancel=0  AND dx.dxt_id = 1
         LEFT  JOIN icd10new i on i.icd10=dx.icd10
         INNER  JOIN prescriptions pr ON pr.visit_id  = o.visit_id and pr.IS_CANCEL = 0
         LEFT JOIN drugs d ON d.drug_id = pr.drug_id  
         LEFT JOIN occupation_new oc ON oc.oc_id = p.oc_id
         LEFT JOIN nations n ON n.natn_id = p.natn_id
         LEFT JOIN ipd_reg ipd ON ipd.visit_id = o.visit_id AND ipd.is_cancel = 0
         LEFT JOIN authen_kiosk ak ON p.CID = ak.cid  AND date(o.REG_DATETIME)=date(ak.d_update)
		 INNER JOIN log_dt dt ON dt.visit_id = o.visit_id
		 LEFT JOIN refers r ON o.VISIT_ID=r.VISIT_ID AND r.IS_CANCEL='0'
		 LEFT JOIN service_units u ON u.unit_id = o.unit_reg
         WHERE
         o.reg_datetime BETWEEN SUBDATE(CURDATE() ,INTERVAL 5 DAY) AND NOW()
         AND ipd.adm_id is null
         AND TIMESTAMPDIFF(year,p.birthdate,o.reg_datetime) >= 25
         AND d.drug_id = '1850'
        GROUP BY o.visit_id  ORDER BY NO DESC limit 10
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
    
       return $this->render('logdt', [
					//'searchModel'=>$searchModel,
                   'dataProvider' => $dataProvider,
                   'sql'=>$sql,
                  
                    ]);   
   }
    ################# LOG HT ###################################
    public function actionHt() {
        $data = Yii::$app->request->post();
		$date1 = isset($data['date1']) ? $data['date1'] : '';
		$date2 = isset($data['date2']) ? $data['date2'] : '';
		
        $sql = "SELECT @n :=@n +1 'No'
        ,date_format(date(o.reg_datetime),'%d-%m-%Y') 'regdate'
        ,o.visit_id
				,p.cid
        ,o.hn
        , CONCAT(
          CASE 
                 WHEN p.PRENAME not in('') THEN TRIM(p.PRENAME)
                       WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW())< '20' AND p.sex='1' AND p.MARRIAGE = '4'THEN 'สามเณร'
                       WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '20' AND p.sex='1' AND p.MARRIAGE  = '4'THEN 'พระภิกษุ'
                       WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='1' THEN 'เด็กชาย'
                       WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='1' THEN 'นาย'
                       WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='2' THEN 'เด็กหญิง'
                       WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='2' AND p.MARRIAGE ='1' THEN 'นางสาว'
                       ELSE 'นาง' 
                END ,TRIM(p.FNAME),'  ',TRIM(p.LNAME)) as 'fullname',
         # TIMESTAMPDIFF(year,p.BIRTHDATE,o.REG_DATETIME) as 'age',
        GROUP_CONCAT(DISTINCT trim(icd.ICD10_TM)) as Diag
        ,left(e.unit_name,10) 'unit_name' 
        #,GROUP_CONCAT(DISTINCT l.lab_id) as lab
		,dm.`status`
		,dm.response
        ,dm.users
        ,GROUP_CONCAT(l.lab_name) as labname
        ,CASE
	    WHEN ak.claimcode = '' THEN 'ว่าง'
	    WHEN ak.claimcode <> '' THEN ak.claimcode
        END AS claimcode
			,CASE
			WHEN r.visit_id is null THEN ''
			WHEN r.visit_id <> '' THEN r.hosp_id
			END as refers
			,dm.d_update
          FROM (select @n := 0) m, opd_visits o 
          INNER JOIN cid_hn c on o.HN= c.HN
          INNER JOIN population p on c.CID=p.CID AND left(p.cid,5) <> '00000'
          INNER JOIN opd_diagnosis d ON d.visit_id = o.visit_id AND d.is_cancel = 0 
          LEFT JOIN icd10new icd ON icd.icd10 = d.icd10 AND icd.icd10 <> ''
          LEFT JOIN ipd_reg ir ON ir.VISIT_ID = o.visit_id  AND ir.IS_CANCEL = 0
          INNER JOIN service_units e ON o.UNIT_REG=e.unit_id
          LEFT JOIN refers r ON o.VISIT_ID=r.VISIT_ID AND r.IS_CANCEL='0'
          LEFT JOIN lab_requests lr ON lr.visit_id = o.visit_id AND lr.is_cancel = 0 
          LEFT JOIN lab_lists l ON l.lab_id = lr.lab_id  
          LEFT JOIN authen_kiosk ak ON p.CID = ak.cid  AND date(o.REG_DATETIME)=date(ak.d_update)
		  INNER JOIN log_dmht dm ON dm.visit_id = o.visit_id
          WHERE o.IS_CANCEL = 0
            AND o.REG_DATETIME BETWEEN SUBDATE(CURDATE() ,INTERVAL 5 DAY) AND NOW()
           AND (left(icd.icd10_tm, 2) = 'I1')
             AND l.lab_id in ('047','081')
            #AND l.lab_id in ('123','047','081','221')
          AND o.inscl in ('03','04')
          AND o.visit_id not in (SELECT ipd_reg.VISIT_ID FROM ipd_reg WHERE ipd_reg.IS_CANCEL=0)
         # AND o.visit_id  in (SELECT vs.visit_id from log_dm vs )
          GROUP BY o.VISIT_ID ORDER BY NO DESC  	 	
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
    
       return $this->render('loght', [
					//'searchModel'=>$searchModel,
                   'dataProvider' => $dataProvider,
                   'sql'=>$sql,
                  
                    ]);   
   }
    ######################### LOG DM #######################################################
    public function actionDm() {
        $data = Yii::$app->request->post();
		$date1 = isset($data['date1']) ? $data['date1'] : '';
		$date2 = isset($data['date2']) ? $data['date2'] : '';
		
        $sql = "SELECT @n :=@n +1 'No'
        ,date_format(date(o.reg_datetime),'%d-%m-%Y') 'regdate'
        ,o.visit_id
				,p.cid
        ,o.hn
        , CONCAT(
          CASE 
                 WHEN p.PRENAME not in('') THEN TRIM(p.PRENAME)
                       WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW())< '20' AND p.sex='1' AND p.MARRIAGE = '4'THEN 'สามเณร'
                       WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '20' AND p.sex='1' AND p.MARRIAGE  = '4'THEN 'พระภิกษุ'
                       WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='1' THEN 'เด็กชาย'
                       WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='1' THEN 'นาย'
                       WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='2' THEN 'เด็กหญิง'
                       WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='2' AND p.MARRIAGE ='1' THEN 'นางสาว'
                       ELSE 'นาง' 
                END ,TRIM(p.FNAME),'  ',TRIM(p.LNAME)) as 'fullname',
         # TIMESTAMPDIFF(year,p.BIRTHDATE,o.REG_DATETIME) as 'age',
        GROUP_CONCAT(DISTINCT trim(icd.ICD10_TM)) as Diag
        ,left(e.unit_name,10) 'unit_name' 
        #,GROUP_CONCAT(DISTINCT l.lab_id) as lab
		,dm.`status`
		,dm.response
        ,dm.users
        ,GROUP_CONCAT(l.lab_name) as labname
        ,CASE
	    WHEN ak.claimcode = '' THEN 'ว่าง'
	    WHEN ak.claimcode <> '' THEN ak.claimcode
        END AS claimcode
			,CASE
			WHEN r.visit_id is null THEN ''
			WHEN r.visit_id <> '' THEN r.hosp_id
			END as refers
			,dm.d_update
          FROM (select @n := 0) m, opd_visits o 
          INNER JOIN cid_hn c on o.HN= c.HN
          INNER JOIN population p on c.CID=p.CID AND left(p.cid,5) <> '00000'
          INNER JOIN opd_diagnosis d ON d.visit_id = o.visit_id AND d.is_cancel = 0 
          LEFT JOIN icd10new icd ON icd.icd10 = d.icd10 AND icd.icd10 <> ''
          LEFT JOIN ipd_reg ir ON ir.VISIT_ID = o.visit_id  AND ir.IS_CANCEL = 0
          INNER JOIN service_units e ON o.UNIT_REG=e.unit_id
          LEFT JOIN refers r ON o.VISIT_ID=r.VISIT_ID AND r.IS_CANCEL='0'
          LEFT JOIN lab_requests lr ON lr.visit_id = o.visit_id AND lr.is_cancel = 0 
          LEFT JOIN lab_lists l ON l.lab_id = lr.lab_id  
          LEFT JOIN authen_kiosk ak ON p.CID = ak.cid  AND date(o.REG_DATETIME)=date(ak.d_update)
					INNER JOIN log_dm dm ON dm.visit_id = o.visit_id
          WHERE o.IS_CANCEL = 0
            AND o.REG_DATETIME BETWEEN SUBDATE(CURDATE() ,INTERVAL 5 DAY) AND NOW()
            AND (left(icd.icd10_tm, 3) = 'E11')
            AND l.lab_id in ('123')
            #AND l.lab_id in ('123','047','081','221')
          AND o.inscl in ('03','04')
          AND o.visit_id not in (SELECT ipd_reg.VISIT_ID FROM ipd_reg WHERE ipd_reg.IS_CANCEL=0)
         # AND o.visit_id  in (SELECT vs.visit_id from log_dm vs )
          GROUP BY o.VISIT_ID ORDER BY NO DESC  	
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
    
       return $this->render('logdm', [
					//'searchModel'=>$searchModel,
                   'dataProvider' => $dataProvider,
                   'sql'=>$sql,
                  
                    ]);   
   }
  ##########################################################################  
    public function actionDelete_all()
    {
        //return 'นายชาตรี บุญทา';

        //$selection = \Yii::$app->request->post('selection');
        $visits =  Yii::$app->request->post('chkDel');
         \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $visits;
    
    }
        
        public function actionSend() {
            $sql ="select l.id, l.visit_id, l.pid,l.cid, l.`status`, l.messagecode, l.response, l.users, l.d_update
            FROM log_dmht l WHERE l.d_update >= CURDATE()
            #AND l.users = 'dmhtyii'
            ORDER BY l.d_update DESC
            ";
            $rawData = \yii::$app->db14->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db14->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        
        $sendProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('send', [
            // 'searchModel' => $searchModel,
            'sendProvider' => $sendProvider,

        ]);
            }
            public function actionSendphr() {
                $sql ="SELECT p.id, p.visit_id, p.pid, p.status, p.messagecode, p.response, p.users, p.d_update
                FROM log_phr p 
                WHERE p.d_update >= CURDATE()
                ORDER BY p.d_update DESC
                ";
                $rawData = \yii::$app->db14->createCommand($sql)->queryAll();
            try {
                $rawData = \Yii::$app->db14->createCommand($sql)->queryAll();
            } catch (\yii\db\Exception $e) {
                throw new \yii\web\ConflictHttpException('sql error');
            }
            
            $sendphrProvider = new \yii\data\ArrayDataProvider([
                'allModels' => $rawData,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
    
            return $this->render('sendphr', [
                // 'searchModel' => $searchModel,
                'sendphrProvider' => $sendphrProvider,
    
            ]);
                }
                public function actionLogepidem() {
                    $sql ="SELECT p.id, p.visit_id, p.pid, p.status, p.messagecode, p.response, p.users, p.d_update
                    FROM log_epidem p 
                    WHERE p.d_update >= CURDATE()
                    ORDER BY p.d_update DESC
                    ";
                    $rawData = \yii::$app->db14->createCommand($sql)->queryAll();
                try {
                    $rawData = \Yii::$app->db14->createCommand($sql)->queryAll();
                } catch (\yii\db\Exception $e) {
                    throw new \yii\web\ConflictHttpException('sql error');
                }
                
                $logepidemProvider = new \yii\data\ArrayDataProvider([
                    'allModels' => $rawData,
                    'pagination' => [
                        'pageSize' => 15,
                    ],
                ]);
        
                return $this->render('log_epidem', [
                    // 'searchModel' => $searchModel,
                    'logepidemProvider' => $logepidemProvider,
        
                ]);
                    }
        }
    
    

