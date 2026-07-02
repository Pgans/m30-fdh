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
use app\models\LogCovid;
//use app\models\User; 
//use yii\filters\AccessControl;        // เรียกใช้ คลาส AccessControl
//use app\models\User;             // เรียกใช้ Model คลาส User ที่ปรับปรังปรุงไว้
//use app\components\AccessRule;   // เรียกใช้ คลาส Component AccessRule ที่เราสร้างใหม่


class D506tController extends \yii\web\Controller
{
   
##########################################################################
 
    public function actionCheck()
    {
        $sqltoken ="SELECT MAX(token) as token30 FROM vaccine_token";

       $data = \yii::$app->db2->createCommand($sqltoken)->queryAll();
           for ($i = 0; $i < sizeof($data); $i++) {
               $token30 = $data[$i]['token30'];    
           }
    ##################################################################   
    /*  
        $vn =  Yii::$app->request->post('chkDel');
       // $delete_ids = explode(',', \Yii::$app->request->post('chkDel'));
      //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
       //$vn = explode(',', Yii::$app->request->post('chkDel'));
       //$vn = explode("", $visit_id);
       //$rev_data = unserialize($visit_id);  // เวลา select ออกมาใช้ ใช้แบบนี้ครับ
       //set_time_limit(100);
       foreach ($vn  as $r) {
        $cid = substr($r, 10);
       // echo $cid;
        $visit = substr($r, 0, 10);
        //echo $visit;
        //$visit_id;
        //return $visit_id.'<br />';
        // echo $r.'<br />';
        */
     ####################################################       
$hospital = [
    "hospital_code" => "10953",
    "hospital_name" => "รพ.ม่วงสามสิบ",
    "his_identifier" => "mbase version 2012"
    ];  
 ######################################################## 
 
$strPerson = "SELECT DISTINCT
pv.cid,
'' passport_no,
c.HN as hn,
CASE
WHEN pv.PRENAME not in('') THEN TRIM(pv.PRENAME)
    #WHEN TIMESTAMPDIFF(year,pv.BIRTHDATE,NOW())< '20' AND pv.sex='1' AND pv.MARRIAGE = '4'THEN 'สามเณร'
    #WHEN TIMESTAMPDIFF(year,pv.BIRTHDATE,NOW()) >= '20' AND pv.sex='1' AND pv.MARRIAGE  = '4'THEN 'พระภิกษุ'
    WHEN TIMESTAMPDIFF(year,pv.BIRTHDATE,NOW()) < '15'  AND pv.sex='1' THEN 'ด.ช.'
    WHEN TIMESTAMPDIFF(year,pv.BIRTHDATE,NOW()) >= '15' AND pv.sex='1' THEN 'นาย'
    WHEN TIMESTAMPDIFF(year,pv.BIRTHDATE,NOW()) < '15'  AND pv.sex='2' THEN 'ด.ญ.'
    WHEN TIMESTAMPDIFF(year,pv.BIRTHDATE,NOW()) >= '15' AND pv.sex='2' AND pv.MARRIAGE ='1' THEN 'น.ส.'
    ELSE 'นาง' 
END as 'prefix',
TRIM(pv.fname) as 'first_name',
TRIM(pv.lname) as 'last_name',
CONCAT('0','',pv.natn_id)as nationality,
pv.sex as 'gender',
pv.BIRTHDATE as 'birthdate',
pv.marriage as 'marriage',
timestampdiff(year,pv.birthdate,CURDATE()) as year,
timestampdiff(month,pv.birthdate,curdate())-(timestampdiff(year,pv.birthdate,curdate())*12) as month,
timestampdiff(day,date_add(pv.birthdate,interval (timestampdiff(month,pv.birthdate,curdate())) month),curdate()) as day,

left(pv.HOME_ADR,3) as 'address',
right(pv.town_id,2) as moo,
'' road,
left(pv.town_id,2) as chw_code,
SUBSTR(pv.town_id,3,2) amp_code,
SUBSTR(pv.town_id,5,2) tmb_code,
pv.TELEPHONE as 'mobile_phone',
oc.oc_std  as 'occupation'

FROM opd_visits o
INNER JOIN cid_hn c ON o.hn = c.hn 
    INNER JOIN population pv ON pv.cid = c.cid
    LEFT JOIN uc_inscl u ON u.CID = c.CID AND u.DATE_ABORT=0
LEFT JOIN occupation_new oc ON oc.oc_id = pv.oc_id
LEFT JOIN towns t on pv.town_id = t.town_id
LEFT JOIN towns t1 on CONCAT(LEFT(pv.town_id,6),'00')=t1.town_id 
LEFT JOIN towns t2 ON CONCAT(LEFT(pv.town_id,4),'0000')= t2.town_id
LEFT JOIN towns t3 ON CONCAT(LEFT(pv.town_id,2),'000000')=t3.town_id
WHERE o.visit_id ='0002906087'
AND o.is_cancel = 0 ";
//$data = Yii::$app->db14->createCommand($strPerson)->execute();
$data = \yii::$app->db14->createCommand($strPerson)->queryAll();
$result = array();
$i=0;
while($i < count($data)){
    $patients = [
     'cid' => $data[$i]['cid'],
     "passport_no" => $data[$i]['passport_no'],
     'prefix' => $data[$i]['prefix'],
    'first_name' => $data[$i]['first_name'],
    'last_name' => $data[$i]['last_name'],
    'nationality' =>$data[$i]['nationality'],
    'gender' => $data[$i]['gender'],
    'birth_date' => $data[$i]['birthdate'],
    'age_y' => $data[$i]['year'],//
    'age_m' => $data[$i]['month'],
    'age_d' => $data[$i]['day'],
    'marital_status_id' => $data[$i]['marriage'],
    'address' => $data[$i]['address'],
    'moo' => $data[$i]['moo'],
    'road' => $data[$i]['road'],
    'chw_code' =>$data[$i]['chw_code'],
    'amp_code' => $data[$i]['amp_code'],
    'tmb_code' => $data[$i]['tmb_code'],
    'mobile_phone' => $data[$i]['mobile_phone'],
    'occupation' => $data[$i]['occupation'],
    ];
    $i++;
}
    

//$json = json_encode($result);
//echo $json;
 ###########################Epidem Report#########################################
 $strEpidem = "SELECT
 a.visit_id,
 a.unit_reg,
 if(ip.ward_no is null ,'' ,ip.ward_no) ward_no,
 p.cid,
 concat('{',CASE 
 WHEN cv.uuid is null  THEN UUID()
 ELSE cv.uuid
 END,'}') as 'epidem_report_guid',
 i5.R506_ID as'epidem_report_group_code',
 '10953' as 'treated_hospital_code' ,
 DATE_FORMAT(a.REG_DATETIME,'%Y-%m-%dT%T') as 'report_datetime',
 date(a.REG_DATETIME) as 'onset_date',
 date(a.REG_DATETIME) as 'treated_date' ,
 if(o.dx_dt is null , '',date(o.dx_dt))  as 'diagnosis_date' ,
 if(de.death_date is null,'',de.death_date) as 'death_date',
 if(de.cdeath is null,'',de.cdeath) as 'cdeath',
 'นางสาวจุฑารัตน์ พิณโท' as 'informer_name' ,
 'U071' as 'principal_diagnosis_icd10' ,
 GROUP_CONCAT(DISTINCT i.ICD10_TM) as 'diagnosis_icd10_list',
'' as 'organism' ,
'' as 'complication',
 CASE
 WHEN a.FINISH_DATETIME = 0 THEN '3'
 WHEN a.FINISH_DATETIME != 0 THEN '1'
 ELSE '4'
 END as 'epidem_person_status_id',
 CASE
 WHEN ip.WARD_NO = '' THEN '1'
 WHEN ip.WARD_NO is null THEN '1'
 ELSE '2'
 END as 'epidem_symptom_type_id',
 3 as 'municipal',
 'N' as 'respirator_status',
  1 as 'epidem_accommodation_type_id',
        CASE
        WHEN cv.cid is null  THEN 'N'
        WHEN cv.cid = ''  THEN 'N'
        ELSE 'Y'
  END as 'vaccinated_status' ,
--  'N' as 'exposure_epidemic_area_status',
--  'N' as 'exposure_healthcare_worker_status' ,
--  'N' as 'exposure_closed_contact_status' ,
--  'N' as 'exposure_occupation_status' ,
--  'N' as 'exposure_travel_status' ,
--  10 as 'risk_history_type_id',
 left(p.HOME_ADR,8) as 'epidem_address' ,
 right(p.TOWN_ID,2) as 'epidem_moo' ,
 '' as 'epidem_road',
 left(p.TOWN_ID,2) as 'epidem_chw_code',
 SUBSTR(p.town_id,3,2) as 'epidem_amp_code',
 SUBSTR(p.town_id,5,2) as 'epidem_tmb_code',
 0 as 'location_gis_latitude',
 0 as 'location_gis_longitude',
 '34' as 'isolate_chw_code',
 3 as 'isolate_place_id',
 CASE
 WHEN ip.WARD_NO = '' THEN 'OPD'
 WHEN ip.WARD_NO is null THEN 'OPD'
 ELSE 'IPD'
 END as 'patient_type',
'ชุมชนตลาด' 'active_case_finding',
'' as 'epidem_cluster_type_id',
'' as 'cluster_latitude',
'' as 'cluster_longitude',
'' as 'comment'
 FROM opd_visits a 
 INNER JOIN cid_hn c ON a.HN=c.HN AND a.IS_CANCEL=0  
 INNER JOIN population p ON p.CID=c.CID
 LEFT JOIN opd_diagnosis o ON o.visit_id = a.visit_id AND o.is_cancel = 0
LEFT JOIN icd10new i ON i.icd10 = o.icd10
INNER JOIN service_units e ON a.UNIT_REG=e.unit_id
LEFT JOIN refers r ON a.VISIT_ID=r.VISIT_ID AND r.IS_CANCEL='0'
INNER JOIN main_inscls m ON m.inscl = a.inscl 
LEFT JOIN uc_inscl uc ON uc.cid = p.cid AND (uc.date_abort = date(a.REG_DATETIME) or day(uc.date_abort)=0 and trim(uc.hospmain) <>'' )
LEFT JOIN main_inscls m1 ON m1.inscl = a.inscl 
LEFT JOIN hosp_sss h ON h.cid = p.cid AND h.DATE_ABORT = 0
LEFT JOIN lab_requests lr ON lr.visit_id = a.visit_id AND lr.is_cancel = 0 
LEFT JOIN lab_lists l ON l.lab_id = lr.lab_id  
LEFT JOIN ipd_reg ip ON ip.VISIT_ID = a.visit_id  AND ip.IS_CANCEL = 0
LEFT JOIN cid_vaccinate cv ON cv.cid = p.cid
LEFT JOIN deaths de ON de.cid = p.cid
INNER  JOIN icd10_506 i5 ON i5.icd10_id = i.icd10_id AND i5.is_cancel = 0
LEFT JOIN towns t on p.town_id = t.town_id
LEFT JOIN towns t1 on CONCAT(LEFT(p.town_id,6),'00')=t1.town_id 
LEFT JOIN towns t2 ON CONCAT(LEFT(p.town_id,4),'0000')= t2.town_id
LEFT JOIN towns t3 ON CONCAT(LEFT(p.town_id,2),'000000')=t3.town_id
 WHERE 
  a.visit_id ='0002906087'
  ";
  $data = \yii::$app->db14->createCommand($strEpidem)->queryAll();
  //$epidem = array();
  $i=0;
while($i < count($data)){
  $epidem_report =  [
    "epidem_report_guid" =>  $data[$i]['epidem_report_guid'],
    'epidem_report_group_code' => $data[$i]['epidem_report_group_code'],
    'treated_hospital_code' => $data[$i]['treated_hospital_code'],
    'report_datetime' => $data[$i]['report_datetime'],
    'onset_date' => $data[$i]['onset_date'],
    'treated_date' => $data[$i]['treated_date'],
    'diagnosis_date' =>$data[$i]['diagnosis_date'],
    'death_date' =>$data[$i]['death_date'],
    'organism' =>$data[$i]['organism'],
    'complication' =>$data[$i]['complication'],
    'epidem_person_status_id' =>$data[$i]['epidem_person_status_id'],
    'cdeath' =>$data[$i]['cdeath'],
    'informer_name' => $data[$i]['informer_name'],
    'principal_diagnosis_icd10' => $data[$i]['principal_diagnosis_icd10'],
    'diagnosis_icd10_list' => $data[$i]['diagnosis_icd10_list'],
    'municipal' => $data[$i]['municipal'],
    'respirator_status' => $data[$i]['respirator_status'],
    'vaccinated_status' => $data[$i]['vaccinated_status'],
    // 'exposure_epidemic_area_status' => $data[$i]['exposure_epidemic_area_status'],
    // 'exposure_healthcare_worker_status' => $data[$i]['exposure_healthcare_worker_status'],
    // 'exposure_closed_contact_status' => $data[$i]['exposure_closed_contact_status'],
    // 'exposure_occupation_status' => $data[$i]['exposure_occupation_status'],
    // 'exposure_travel_status' => $data[$i]['exposure_travel_status'],
    // 'risk_history_type_id' => $data[$i]['risk_history_type_id'],
    'epidem_address' => $data[$i]['epidem_address'],
    'epidem_moo' => $data[$i]['epidem_moo'],
    'epidem_road' =>$data[$i]['epidem_road'],
    'epidem_chw_code' => $data[$i]['epidem_chw_code'],
    'epidem_amp_code' => $data[$i]['epidem_amp_code'],
    'epidem_tmb_code' => $data[$i]['epidem_tmb_code'],
    'location_gis_latitude' => $data[$i]['location_gis_latitude'],
    'location_gis_longitude' => $data[$i]['location_gis_longitude'],
    'isolate_chw_code' => $data[$i]['isolate_chw_code'],
    // 'isolate_place_id' => $data[$i]['isolate_place_id'],
    'patient_type' => $data[$i]['patient_type'],
    'active_case_finding' => $data[$i]['active_case_finding'],
    'epidem_cluster_type_id' => $data[$i]['epidem_cluster_type_id'],
    'cluster_latitude' => $data[$i]['cluster_latitude'],
    'cluster_longitude' => $data[$i]['cluster_longitude'],
    'comment' => $data[$i]['comment'],
  ];
  $i++;
}
######################## END EPIDEM #########################
########################### Lab Report #########################################
$lab_report = [];
$strLab = "SELECT
        o.visit_id, 
        CASE
        WHEN l2.lab_id = '394' THEN '1'
        WHEN l2.lab_id in ('410','411') THEN '2' 
        WHEN l2.lab_id in ('396','397') THEN '3' 
        END as 'epidem_lab_confirm_type_id',
        date(l.LREQ_DT) as 'lab_report_date' ,
        CASE
        WHEN l.LAB_RESULT  LIKE '%=Detected%' THEN 'positive'
        WHEN l.LAB_RESULT  LIKE '%Not Detected' THEN 'negative'
        WHEN l.LAB_RESULT  LIKE '%Negative%' THEN 'negative'
        WHEN l.LAB_RESULT  LIKE '%Positive%' THEN 'positive'
        ELSE ''
        END as 'lab_report_result' ,
        l.LAB_RESULT as 'lab_resultxx' ,
        date(l.LREQ_DT) as 'specimen_date' ,
        2 as 'specimen_place_id',
        5 as'tests_reason_type_id',
        l.visit_id  as 'lab_his_ref_code' ,
        l2.lab_name as 'lab_his_ref_name' ,
        l2.TMLT_code as 'tmlt_code' 
        FROM opd_visits o
        INNER  JOIN lab_requests l ON o.visit_id = l.visit_id AND o.is_cancel = 0 AND l.is_cancel = 0
        INNER  JOIN lab_lists l2 ON l2.lab_id = l.lab_id AND l.lab_id in ('394','396','397','410','411')
        WHERE 
        o.visit_id ='0002906087'
        ";
        $data = \yii::$app->db14->createCommand($strLab)->queryAll();
        foreach($data as $row){
            if(count($data) > 0){
               $lab_report =  array(
                   "epidem_lab_confirm_type_id" =>  $row['epidem_lab_confirm_type_id'],
                   'lab_report_date' =>$row['lab_report_date'],
                   'lab_report_result' => $row['lab_report_result'],
                   'specimen_date' => $row['specimen_date'],
                   'specimen_place_id' => $row['specimen_place_id'],
                   'tests_reason_type_id' => $row['tests_reason_type_id'],
                   'lab_his_ref_code' => $row['lab_his_ref_code'],
                   'lab_his_ref_name' => $row['lab_his_ref_name'],
                   'tmlt_code' => $row['tmlt_code'],
           
                 );
               }
           }
//print_r($lab_report);
##########################LAB###############################
######################## VACCINE ###########################

$vaccine = [];
    $strSQL = "SELECT DISTINCT
    cv.cid,
    '10953' as 'vaccine_hospital_code'
    ,cv.vac_date as 'vaccine_date'
    ,cv.visit_id,
    cv.dose_time  as 'dose'
    ,d.drug_name as 'vaccine_manufacturer'
    FROM cid_vaccinate_v2 cv  
    INNER JOIN prescriptions k ON cv.VISIT_ID = k.VISIT_ID AND k.IS_CANCEL=0
    LEFT JOIN drugs d ON d.DRUG_ID = k.DRUG_ID
    WHERE #date(a.REG_DATETIME) BETWEEN CURDATE()- AND NOW()
    cv.cid = '3341400473685s'
    AND k.drug_id in ('2813','2790','2244','2043','2332','2372')";
    $data = \yii::$app->db14->createCommand($strSQL)->queryAll();
    foreach($data as $row){
        if(count($row) > 0){
        $vaccinex = [
        'vaccine_hospital_code' => $row['vaccine_hospital_code'],
        'vaccine_date' => $row['vaccine_date'],
        'dose' => $row['dose'],
        'vaccine_manufacturer'=> $row['vaccine_manufacturer'], 
        ];
     }
     array_push($vaccine, $vaccinex);
    }
    ###############################################
$e = [
    "hospital" => $hospital,
    "person" => $patients,
    "epidem_report" => $epidem_report,
    "lab_report" => $lab_report,
    "vaccination" => $vaccine,
    // "immunization_plan"=>$Immunization_plan,
    //"visit" =>$visits,
    ];
    $resultText = json_encode($e, JSON_PRETTY_PRINT);
    $jsonData = $resultText;
    
    //print_r($jsonData);
   // echo $jsonData;

   }
}
