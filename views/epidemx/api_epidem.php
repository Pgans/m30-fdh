
<?php
session_start();
header("location:main.php?menu=epidem_covid");
//header("location:main.php?menu=dose1");
require "config.php";
require "vaccine_token.php";


#$url = "https://cloud4.hosxp.net/api/moph/UpdateImmunization"; 
// $url = "https://epidemcenter.moph.go.th/epidem/api/SendEPIDEM"; 


if (!empty($_POST['chkDel'])) {
  $data_chk = serialize($_POST['chkDel']);
  //echo 'serialize => '.$data_chk.'<br />'; // เอาชุดนี้ไป insert เลยครับ
  //echo 'serialize => '.unserialize($data_chk).'<br /><br />';
  //echo 'วนลูปเอาค่าออกมาใช้ <br />';

  $rev_data = unserialize($data_chk);  // เวลา select ออกมาใช้ ใช้แบบนี้ครับ
  foreach ($rev_data  as $r) {
    $cid = substr($r, 10);
    $visit = substr($r, 0, 10);
    //echo $r.'<br />';


    // $r = "0002700161";
    // $pid = "1331001344541";
    ###############TEMP####################################
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $strSQL = "CREATE TEMPORARY TABLE pop_visit AS
            SELECT o.visit_id, o.hn, o.is_cancel, o.bp_syst, o.bp_dias, o.body_temp, o.height, o.weight, o.waist, o.reg_datetime,
    CASE
    WHEN o.INSCL = 04  AND u.UC_TYPE = '71' THEN 'AA'
    WHEN o.INSCL = 04  AND u.UC_TYPE = '72' THEN 'AB'
    WHEN o.INSCL = 04  AND u.UC_TYPE = '73' THEN 'AC'
    WHEN o.INSCL = 04  AND u.UC_TYPE = '74' THEN 'AD'
    WHEN o.INSCL = 04  AND u.UC_TYPE = '75' THEN 'AE'
    WHEN o.INSCL = 04  AND u.UC_TYPE = '76' THEN 'AF'
    WHEN o.INSCL = 04  AND u.UC_TYPE = '77' THEN 'AG'
    WHEN o.INSCL = 04  AND u.UC_TYPE = '81' THEN 'AK'
    WHEN o.INSCL = 04  AND u.UC_TYPE = '82' THEN 'AJ'
    WHEN o.INSCL = 04  THEN 'UB'
    WHEN o.INSCL in (23,00,33) THEN 'UB'
    WHEN o.INSCL = 03 THEN 'UC'
    WHEN o.INSCL in (01,11,12,14,22,25,35,36,37,38,40) THEN 'A2'
    WHEN o.INSCL in (08,09,21,30,31) THEN 'A7'
    WHEN o.INSCL in (18,19) THEN 'A9'
    WHEN o.INSCL in (05,16) THEN 'AL'
    ELSE 'A1'
    END as 'inscl', 
    b.CID as 'cid', b.PRENAME 'prename', b.FNAME 'fname', b.LNAME 'lname', b.BIRTHDATE 'birthdate', b.SEX 'sex', b.fname_e, b.lname_e, b.TELEPHONE 'telephone',
    b.NATN_ID 'natn_id', b.address_e,b.MARRIAGE 'marriage', b.prename_e, b.HOME_ADR 'home_adr', b.town_id, oc.oc_std
    FROM opd_visits o 
    INNER JOIN main_inscls m on o.INSCL = m.INSCL AND o.IS_CANCEL=0
    LEFT JOIN cid_hn c ON o.HN=c.HN
    LEFT JOIN population b ON c.cid = b.cid
    LEFT JOIN uc_inscl u ON u.CID=c.CID AND u.DATE_ABORT=0
    LEFT JOIN occupation_new oc ON oc.oc_id = b.oc_id
    WHERE o.VISIT_ID ='$visit' ";
    $objQuery = mysql_query($strSQL) or die(mysql_error());
    ########################Hospital#####################
    $hospital = [
      "hospital_code" => "10953",
      "hospital_name" => "รพ.ม่วงสามสิบ",
      "his_identifier" => "mbase version 2012"
    ];
    ############## Person #########################################################
    $strPerson = "SELECT DISTINCT
    pv.cid,
    '' passport_no,
    pv.HN as hn,
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
    pv.oc_std as 'occupation'
    
    FROM pop_visit pv
    LEFT JOIN towns t on pv.town_id = t.town_id
    LEFT JOIN towns t1 on CONCAT(LEFT(pv.town_id,6),'00')=t1.town_id 
    LEFT JOIN towns t2 ON CONCAT(LEFT(pv.town_id,4),'0000')= t2.town_id
    LEFT JOIN towns t3 ON CONCAT(LEFT(pv.town_id,2),'000000')=t3.town_id
    WHERE pv.visit_id ='$visit'
    AND pv.is_cancel = 0 ";
    $objQuery = mysql_query($strPerson) or die(mysql_error());
    while ($row_users = mysql_fetch_assoc($objQuery)) {
      $patients =  array(
        "cid" =>  $row_users['cid'],
        "passport_no" =>  $row_users['passport_no'],
        'prefix' => $row_users['prefix'],
        'first_name' => $row_users['first_name'],
        'last_name' => $row_users['last_name'],
        'nationality' => $row_users['nationality'],
        'gender' => $row_users['gender'],
        'birth_date' => $row_users['birthdate'],
        'age_y' => $row_users['year'],
        'age_m' => $row_users['month'],
        'age_d' => $row_users['day'],
        'marital_status_id' => $row_users['marriage'],
        'address' => $row_users['address'],
        'moo' => $row_users['moo'],
        'road' => $row_users['road'],
        'chw_code' => $row_users['chw_code'],
        'amp_code' => $row_users['amp_code'],
        'tmb_code' => $row_users['tmb_code'],
        'mobile_phone' => $row_users['mobile_phone'],
        'occupation' => $row_users['occupation'],
      );
    }
    ###########################Epidem Report#########################################
    $strEpidem = "SELECT
     #ac.cid anc,
     #cv.cid vaccine,
     a.visit_id,
     a.unit_reg,
     if(ip.ward_no is null ,'' ,ip.ward_no) ward_no,
     p.cid,
     concat('{',CASE 
     WHEN cv.uuid is null  THEN UUID()
     ELSE cv.uuid
     END,'-',a.visit_id,'}') as 'epidem_report_guid',
     '92' as'epidem_report_group_id',
     '10953' as 'treated_hospital_code' ,
     DATE_FORMAT(a.REG_DATETIME,'%Y-%m-%dT%T') as 'report_datetime',
     date(a.REG_DATETIME) as 'onset_date',
     date(a.REG_DATETIME) as 'treated_date' ,
     if(o.dx_dt is null , '',date(o.dx_dt))  as 'diagnosis_date' ,
     'นางสาวจุฑารัตน์ พิณโท' as 'informer_name' ,
     'U071' as 'principal_diagnosis_icd10' ,
     GROUP_CONCAT(DISTINCT i.ICD10_TM) as 'diagnosis_icd10_list',
     CASE
     WHEN a.FINISH_DATETIME = 0 THEN '1'
     WHEN a.FINISH_DATETIME != 0 THEN '2'
     ELSE '4'
     END as 'epidem_person_status_id',
     CASE
     WHEN ip.WARD_NO = '' THEN '1'
     WHEN ip.WARD_NO is null THEN '1'
     ELSE '2'
     END as 'epidem_symptom_type_id',
     'N' as 'pregnant_status' ,
     'N' as 'respirator_status',
      1 as 'epidem_accommodation_type_id',
			CASE
			WHEN cv.cid is null  THEN 'N'
			WHEN cv.cid = ''  THEN 'N'
			ELSE 'Y'
      END as 'vaccinated_status' ,
     'N' as 'exposure_epidemic_area_status',
     'N' as 'exposure_healthcare_worker_status' ,
     'N' as 'exposure_closed_contact_status' ,
     'N' as 'exposure_occupation_status' ,
     'N' as 'exposure_travel_status' ,
     10 as 'risk_history_type_id',
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
     END as 'patient_type'
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
  LEFT JOIN towns t on p.town_id = t.town_id
  LEFT JOIN towns t1 on CONCAT(LEFT(p.town_id,6),'00')=t1.town_id 
  LEFT JOIN towns t2 ON CONCAT(LEFT(p.town_id,4),'0000')= t2.town_id
  LEFT JOIN towns t3 ON CONCAT(LEFT(p.town_id,2),'000000')=t3.town_id
     WHERE #ip.ADM_DT BETWEEN CURDATE() AND NOW()
     #(ip.WARD_NO in ('38','57') OR a.UNIT_REG = '58')
      #ip.DSC_DT = 0 
     #AND ip.visit_id in ('0002695871', '0002695959','0002696944','0002696956')
      a.visit_id ='$visit'
      ";
    $objQuery = mysql_query($strEpidem) or die(mysql_error());
    while ($row_users = mysql_fetch_assoc($objQuery)) {
      $epidem_report =  array(
        "epidem_report_guid" =>  $row_users['epidem_report_guid'],
        'epidem_report_group_id' => $row_users['epidem_report_group_id'],
        'treated_hospital_code' => $row_users['treated_hospital_code'],
        'report_datetime' => $row_users['report_datetime'],
        'onset_date' => $row_users['onset_date'],
        'treated_date' => $row_users['treated_date'],
        'diagnosis_date' => $row_users['diagnosis_date'],
        'informer_name' => $row_users['informer_name'],
        'principal_diagnosis_icd10' => $row_users['principal_diagnosis_icd10'],
        'diagnosis_icd10_list' => $row_users['diagnosis_icd10_list'],
        'epidem_person_status_id' => $row_users['epidem_person_status_id'],
        'epidem_symptom_type_id' => $row_users['epidem_symptom_type_id'],
        'pregnant_status' => $row_users['pregnant_status'],
        #$user_array['installed_line_connect'] = $row_users['installed_line_connect'];
        'respirator_status' => $row_users['respirator_status'],
        'epidem_accommodation_type_id' => $row_users['epidem_accommodation_type_id'],
        'vaccinated_status' => $row_users['vaccinated_status'],
        'exposure_epidemic_area_status' => $row_users['exposure_epidemic_area_status'],
        'exposure_healthcare_worker_status' => $row_users['exposure_healthcare_worker_status'],
        'exposure_closed_contact_status' => $row_users['exposure_closed_contact_status'],
        'exposure_occupation_status' => $row_users['exposure_occupation_status'],
        'exposure_travel_status' => $row_users['exposure_travel_status'],
        'risk_history_type_id' => $row_users['risk_history_type_id'],
        'epidem_address' => $row_users['epidem_address'],
        'epidem_moo' => $row_users['epidem_moo'],
        'epidem_road' => $row_users['epidem_road'],
        'epidem_chw_code' => $row_users['epidem_chw_code'],
        'epidem_amp_code' => $row_users['epidem_amp_code'],
        'epidem_tmb_code' => $row_users['epidem_tmb_code'],
        'location_gis_latitude' => $row_users['location_gis_latitude'],
        'location_gis_longitude' => $row_users['location_gis_longitude'],
        'isolate_chw_code' => $row_users['isolate_chw_code'],
        'isolate_place_id' => $row_users['isolate_place_id'],
        'patient_type' => $row_users['patient_type'],
      );
    }
    ########################### Lab Report #########################################
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
      WHERE #o.REG_DATETIME BETWEEN CURDATE() AND NOW()
     # o.visit_id = '0002698931'
       o.visit_id ='$visit'
       ";
    $objQuery = mysql_query($strLab) or die(mysql_error());
    while ($row_users = mysql_fetch_assoc($objQuery)) {
      $lab_report =  array(
        "epidem_lab_confirm_type_id" =>  $row_users['epidem_lab_confirm_type_id'],
        'lab_report_date' => $row_users['lab_report_date'],
        'lab_report_result' => $row_users['lab_report_result'],
        'specimen_date' => $row_users['specimen_date'],
        'specimen_place_id' => $row_users['specimen_place_id'],
        'tests_reason_type_id' => $row_users['tests_reason_type_id'],
        'lab_his_ref_code' => $row_users['lab_his_ref_code'],
        'lab_his_ref_name' => $row_users['lab_his_ref_name'],
        'tmlt_code' => $row_users['tmlt_code'],

      );
    }
    ##########################LAB###############################
    ######################## VACCINE ###########################
    $vaccine = array();
    //$fetch_vaccine = mysql_query( " SELECT 
    $strSQL = "SELECT
    p.cid
    ,c.hn,
    '10953' as 'vaccine_hospital_code'
    ,date(a.REG_DATETIME) as 'vaccine_date'
    ,a.visit_id,
    CASE
    WHEN z.visit_id4 = a.VISIT_ID  THEN '4'
    WHEN z.visit_id3 = a.VISIT_ID  THEN '3'
    WHEN z.visit_id2 = a.VISIT_ID  THEN '2'
    ELSE  '1'
    END as 'dose'
    ,d.drug_name as 'vaccine_manufacturer'
    FROM opd_visits a 
    INNER JOIN cid_hn c ON a.HN=c.HN AND a.IS_CANCEL=0
    INNER JOIN population p ON p.CID = c.CID
    LEFT JOIN prescriptions k ON k.VISIT_ID = a.VISIT_ID AND k.IS_CANCEL=0
    LEFT JOIN drugs d ON d.DRUG_ID = k.DRUG_ID
    LEFT JOIN cid_vaccinate z ON p.cid = z.cid
    WHERE #date(a.REG_DATETIME) BETWEEN CURDATE()- AND NOW()
    z.cid = $cid
    AND k.drug_id in ('2813','2790','2244','2043','2332','2372')
    GROUP BY a.visit_id ";
    //$dbquery=mysql_query($sql);
    $objQuery = mysql_query($strSQL) or die(mysql_error());
    $num_rows = mysql_num_rows($objQuery);
    while ($row = mysql_fetch_assoc($objQuery)) {
      if ($num_rows > 0) {
        // $result = mysql_fetch_array($num_rows);
        $vac_array['vaccine_hospital_code'] = $row['vaccine_hospital_code'];
        $vac_array['vaccine_date'] = $row['vaccine_date'];
        $vac_array['dose'] = $row['dose'];
        $vac_array['vaccine_manufacturer'] = $row['vaccine_manufacturer'];
      } else {
        $vac_array['vaccine_hospital_code'] = $row[''];
        $vac_array['vaccine_date'] =  " ";
        $vac_array['dose'] =  " ";
        $vac_array['vaccine_manufacturer'] =  " ";
      }

      array_push($vaccine, $vac_array);
    }
    ###############################################
    mysql_close($objConnect);

    $e = (object)array(
      "hospital" => $hospital,
      "person" => $patients,
      "epidem_report" => $epidem_report,
      "lab_report" => $lab_report,
      "vaccination" => $vaccine,
      // "immunization_plan"=>$Immunization_plan,
      //"visit" =>$visits,
    );
    $resultText = json_encode($e, JSON_PRETTY_PRINT);
    $jsonData = $resultText;
    echo $jsonData;

    #######################################
    $_token = $token30;
    $curl = curl_init($url);
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => 1,
      //SSL USE
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,

      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $jsonData,
      CURLOPT_HTTPHEADER => array(
        "Content-type: application/json",
        "Authorization: Bearer " . $_token
      ),
    ));
    $response = curl_exec($curl);
    $epidem = json_decode($response, true);
    $err = curl_error($curl);
    curl_close($curl);
    $pid = $epidem['result']['cid'];
    echo "<pre>";
    print_r($epidem) . '</br>';
    $status = $epidem['Message'];
    $messagecode = $epidem['MessageCode'];
    /*
 if($status = 200) {
  echo "<script language=\"JavaScript\">";
  echo "alert('ส่งข้อมูลสำเร็จ')";
  echo "</script>";
 }*/
    //return  $response;
    require "config.php";
    if (strlen($response) > 0) {
      $strSQL = "REPLACE INTO log_epidem (visit_id, pid,status, messagecode ,response , users,d_update) VALUES ('$visit','$pid','$status','$messagecode','" . $response . "' ,'Pgans',NOW())";
      $objQuery = mysql_query($strSQL) or die("Error Query " . $strSQL . "<br>[" . mysql_error() . "]");
    }
  }
}
?>
