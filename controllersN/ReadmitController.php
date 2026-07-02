<?php

namespace app\controllers;


use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

//include Yii::getAlias('@common').'/config/thai_date.php';
class ReadmitController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
	public function actionReadmit(){
		$data = Yii::$app->request->post();
		$date1 = isset($data['date1']) ? $data['date1'] : '';
		$date2 = isset($data['date2']) ? $data['date2'] : '';
		
        $sql = "
			SELECT ip1.visit_id as vn1, date(ip1.adm_dt) as adm1, time(ip1.adm_dt) as time1 , c.hn , ip1.adm_id as an1,i1.icd10_tm as icd1, count(c.hn),
			 ip2.visit_id as vn2,ip2.adm_id as an2,date(ip2.adm_dt) as adm2, time(ip2.adm_dt) as time2,i2.icd10_tm as icd2,
			#((to_days(o2.REG_DATETIME)*24)- ((to_days(o1.REG_DATETIME)*24)) )
			#(date(o2.REG_DATETIME)- (date(o1.REG_DATETIME))) 
			timestampdiff(day,ip1.adm_dt,ip2.adm_dt)
			as revist_time
			FROM  opd_visits o1
			INNER JOIN cid_hn c ON o1.hn = c.hn
			INNER JOIN ipd_reg ip1 ON o1.visit_id = ip1.visit_id and ip1.is_cancel = 0
			LEFT OUTER JOIN opd_diagnosis dx1 ON ip1.visit_id = dx1.visit_id AND dx1.dxt_id = 1 AND dx1.is_cancel = 0 
			LEFT OUTER JOIN icd10new i1 ON dx1.icd10 = i1.icd10
			INNER JOIN opd_visits o2 ON o2.hn = c.hn AND o2.is_cancel = 0  
			LEFT OUTER JOIN ipd_reg ip2 ON o2.visit_id = ip2.visit_id AND ip2.is_cancel = 0 
			LEFT OUTER JOIN opd_diagnosis dx2 ON ip2.visit_id = dx2.visit_id AND dx2.dxt_id = 1 AND dx2.is_cancel = 0 AND dx2.icd10 is not null
			LEFT OUTER JOIN icd10new i2 ON dx2.icd10 = i2.icd10 AND i1.icd10_tm = i2.icd10_tm
			WHERE ip1.adm_dt BETWEEN '$date1' AND '$date2'
			#AND ((to_days(o2.REG_DATETIME)*24)- ((to_days(o1.REG_DATETIME)*24))) <=28
			#AND (date(o2.REG_DATETIME)- (date(o1.REG_DATETIME))) <=28
			AND timestampdiff(day,ip1.adm_dt,ip2.adm_dt) <=28
			AND ip2.visit_id > ip1.visit_id  
			AND i1.icd10_tm = i2.icd10_tm
			AND ip1.is_cancel = 0
			GROUP BY c.hn
			HAVING count(c.hn)>1     
         ";
        $rawData = \yii::$app->db2->createCommand($sql)->queryAll();
       try {
           $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
       } catch (\yii\db2\Exception $e) {
           throw new \yii\web\ConflictHttpException('sql error');
       }
       
       $dataProvider = new \yii\data\ArrayDataProvider([
           'allModels' => $rawData,
           'pagination' => [
            'pageSize' => 200,
            ],
       ]);
    
       return $this->render('readmit', [
					'searchModel'=>$searchModel,
                   'dataProvider' => $dataProvider,
                   'sql'=>$sql,
                    ]);   
   }
   public function actionRevisit(){
		$data = Yii::$app->request->post();
		$date1 = isset($data['date1']) ? $data['date1'] : '';
		$date2 = isset($data['date2']) ? $data['date2'] : '';
		
        $sql = "
			SELECT o1.visit_id as vn1,date(o1.REG_DATETIME) as d1,time(o1.REG_DATETIME) as time_1,i1.icd10_tm as icdname_1,
			 concat(trim(p.fname), '  ' ,p.lname) as ptname ,
			 c.hn,count(c.hn),
			o2.visit_id as vn_2,date(o2.reg_datetime) as d2 ,time(o2.REG_DATETIME) as time_2, i2.icd10_tm as icdname_2, #d2.name as doctor_name2 ,
			(((to_days(o2.REG_DATETIME)*24)- ((to_days(o1.REG_DATETIME)*24)) + (( time_to_sec(o2.REG_DATETIME))/3600)) - (( time_to_sec(o1.REG_DATETIME))/3600))
			as revist_time
			from opd_visits o1
			LEFT OUTER JOIN  cid_hn c on o1.hn = c.hn AND o1.is_cancel = 0
			LEFT OUTER JOIN population p on p.cid = c.cid
			LEFT OUTER JOIN opd_visits o2 on o2.hn = c.hn AND o2.is_cancel = 0 
			#left outer join vn_stat v2 on v2.vn=o.vn
			LEFT OUTER JOIN opd_diagnosis dx1 on o1.visit_id = dx1.visit_id AND dx1.DXT_ID = 1 AND dx1.is_cancel = 0
			LEFT OUTER JOIN opd_diagnosis dx2 on o2.visit_id = dx2.visit_id AND dx2.DXT_ID = 1 AND dx2.is_cancel = 0
			LEFT OUTER JOIN icd10new i1 on i1.icd10 = dx1.icd10
			LEFT OUTER JOIN icd10new i2 on i2.icd10 = dx2.icd10
			#left outer join icd101 i2 on i2.code=v2.pdx
			#left outer join doctor d1 on d1.code=v.dx_doctor
			#left outer join doctor d2 on d2.code=v2.dx_doctor
			#left outer join patient p on p.hn=o.hn  
			WHERE o1.REG_DATETIME between'$date1' AND  '$date2'
			AND o2.visit_id > o1.visit_id
			AND i1.icd10_tm = i2.icd10_tm  AND left(i1.icd10_tm,1) not in ('Z','U')
			AND (((to_days(o2.REG_DATETIME)*24)- ((to_days(o1.REG_DATETIME)*24)) + (( time_to_sec(o2.REG_DATETIME))/3600)) - (( time_to_sec(o1.REG_DATETIME))/3600)) between 0.001 and 48 
			group by c.hn
			having count(c.hn)>1
              ";
        $rawData = \yii::$app->db2->createCommand($sql)->queryAll();
       try {
           $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
       } catch (\yii\db2\Exception $e) {
           throw new \yii\web\ConflictHttpException('sql error');
       }
       
       $dataProvider = new \yii\data\ArrayDataProvider([
           'allModels' => $rawData,
           'pagination' => [
            'pageSize' => 200,
            ],
       ]);
    
       return $this->render('revisit', [
					'searchModel'=>$searchModel,
                   'dataProvider' => $dataProvider,
                   'sql'=>$sql,
                    ]);   
   }
    public function actionUnplan(){
		$data = Yii::$app->request->post();
		$date1 = isset($data['date1']) ? $data['date1'] : '';
		$date2 = isset($data['date2']) ? $data['date2'] : '';
		
        $sql = "
			SELECT i.VISIT_ID ,op.HN,i.ADM_ID as AN ,op.REG_DATETIME as REGDATE,i.ADM_DT, r.RF_DT ,
 ((to_days(r.RF_DT)*24)- (to_days(i.ADM_DT)*24))/24 AS DAYS, abs((time_to_sec(r.RF_DT)/3600) - (time_to_sec(i.ADM_DT)/3600)) as Times 
,i.P_DIAG  as Dxก่อนRefer, ic.ICD10_TM  as PostRefer
FROM ipd_reg i 
LEFT  JOIN opd_visits op ON op.visit_id = i.visit_id AND op.is_cancel = 0 
LEFT  JOIN refers r on i.VISIT_ID = r.VISIT_ID AND i.IS_CANCEL = 0 AND r.IS_CANCEL = 0 AND r.rf_type = 2 
INNER JOIN opd_diagnosis o ON i.VISIT_ID = o.VISIT_ID AND o.IS_CANCEL = 0 AND o.DXT_ID = 1 
INNER JOIN icd10new ic ON o.ICD10 = ic.ICD10 
#INNER JOIN opd_diagnosis o1 ON r.VISIT_ID = o1.VISIT_ID AND o1.IS_CANCEL = 0 AND o1.DXT_ID = 1
#INNER JOIN icd10new ic1 ON o1.ICD10 = ic1.ICD10 
WHERE r.RF_DT BETWEEN '$date1' AND '$date2' 
AND ((to_days(r.RF_DT)*24)- (to_days(i.ADM_DT)*24))/24 = '0' AND abs((time_to_sec(r.RF_DT)/3600) - (time_to_sec(i.ADM_DT)/3600)) <= '1.0'
              ";
        $rawData = \yii::$app->db2->createCommand($sql)->queryAll();
       try {
           $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
       } catch (\yii\db2\Exception $e) {
           throw new \yii\web\ConflictHttpException('sql error');
       }
       
       $dataProvider = new \yii\data\ArrayDataProvider([
           'allModels' => $rawData,
           'pagination' => [
            'pageSize' => 200,
            ],
       ]);
    
       return $this->render('unplanrefer', [
					'searchModel'=>$searchModel,
                   'dataProvider' => $dataProvider,
                   'sql'=>$sql,
                    ]);   
   }
}
