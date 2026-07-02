<?php

namespace app\controllers;

class PhrjsonController extends \yii\web\Controller
{
    ##########################################################################
    ### PHR JSON API  #####################
    /*
    public function actionPhr()
    {
        $sql = "SELECT @n :=@n +1 'No'
        ,b.reg_datetime as 'regdate'
        #,time(b.reg_datetime) 'time'
        ,b.visit_id
        ,b.hn
        ,p.cid
        , CASE 
         WHEN cv1.cid is null THEN 'N'
         WHEN cv1.cid <> '' THEN 'Y'
         ELSE 'Yes'
         END as Vaccine
         , CASE 
         WHEN lr.LAB_RESULT is null THEN 'N'
         WHEN lr.LAB_RESULT <> '' THEN 'Y'
         ELSE 'Yes'
         END as Lab,
         CASE 
         WHEN ir.adm_id is null THEN 'ไม่มี'
         WHEN ir.adm_id <> '' THEN 'มี'
         ELSE 'ไม่รุนแรง'
         END as 'symtom',
         '' as 'pregnant',
				 
        #b.REG_DATETIME as adm_dt,
        #b.FINISH_DATETIME as'dsc_dt',
        CONCAT(
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
          TIMESTAMPDIFF(year,p.BIRTHDATE,b.REG_DATETIME) as 'age',
          #p.cid,
        GROUP_CONCAT(DISTINCT trim(icd.ICD10_TM)) as diag,
				icd.icd10_id,
				c506.code506,
				c506.code_min,
				c506.code_max,
        GROUP_CONCAT(DISTINCT 
        CASE
        WHEN lr.LAB_RESULT  LIKE '%RT-PCR%' THEN 'RT-PCR'
        WHEN lr.LAB_RESULT  LIKE '%Ag=Negative%' THEN 'Negative'
        WHEN lr.LAB_RESULT  LIKE '%Ag=Positive%' THEN 'Positive'
        ELSE LEFT(lr.LAB_RESULT,20) 
        END )as 'lab',
        GROUP_CONCAT(DISTINCT lr.lab_id) lab_id,
        if(ir.adm_id is null, '' ,ir.adm_id ) An,
        if(ir.ward_no is null, '' ,ir.ward_no ) ward,
        CASE
        WHEN b.INSCL in (03,04) AND uc.HOSPMAIN ='10953' THEN CONCAT(m.INSCL_NAME,'-ในเขต') 
        WHEN b.INSCL in (03,04) AND uc.HOSPMAIN !='10953' THEN CONCAT(m.INSCL_NAME,'-นอกเขต') 
        ELSE m.INSCL_NAME 
        END as 'inscl' ,
        m.inscl 'inscl_id', 
        CASE
        WHEN b.inscl in (03,04) THEN uc.hospmain
        WHEN b.inscl in (08,09,21,30,31) THEN h.hosp_id
        ELSE ''
        END as hospmain,
        left(e.unit_name,10) 'unit_name' 
        # p.TELEPHONE as 'เบอร์คนไข้'
          FROM (select @n := 0) m, opd_visits b 
          INNER JOIN cid_hn c on b.HN= c.HN
          INNER JOIN population p on c.CID=p.CID
          LEFT JOIN opd_diagnosis d ON d.visit_id = b.visit_id AND d.is_cancel = 0
          LEFT JOIN icd10new icd ON icd.icd10 = d.icd10
          LEFT  JOIN ipd_reg ir ON ir.VISIT_ID = b.visit_id  AND ir.IS_CANCEL = 0
          INNER JOIN service_units e ON b.UNIT_REG=e.unit_id
          LEFT JOIN refers r ON b.VISIT_ID=r.VISIT_ID AND r.IS_CANCEL='0'
          INNER JOIN main_inscls m ON m.inscl = b.inscl 
          LEFT JOIN uc_inscl uc ON uc.cid = p.cid AND (uc.date_abort = date(b.REG_DATETIME) or day(uc.date_abort)=0 and trim(uc.hospmain) <>'' )
          LEFT JOIN main_inscls m1 ON m1.inscl = b.inscl 
          LEFT JOIN hosp_sss h ON h.cid = p.cid AND h.DATE_ABORT = 0
          LEFT JOIN lab_requests lr ON lr.visit_id = b.visit_id AND lr.is_cancel = 0 AND lr.LAB_RESULT LIKE '%positive%'
          LEFT JOIN lab_lists l ON l.lab_id = lr.lab_id  
          LEFT JOIN cid_vaccinate_v2 cv1 ON cv1.cid = p.cid AND cv1.is_cancel = 0
		  LEFT  JOIN code506 c506 ON icd.ICD10_TM BETWEEN c506.code_min AND c506.code_max
          WHERE b.IS_CANCEL = 0
          AND b.visit_id not in (SELECT mv.visit_id FROM mobile_visits mv)
           #AND b.REG_DATETIME BETWEEN '2024-01-20 00:00' AND '2024-01-24 23:59'
		 AND b.REG_DATETIME BETWEEN SUBDATE(CURDATE() ,INTERVAL 5 DAY) AND NOW()
          AND b.visit_id NOT IN (SELECT VISIT_ID FROM log_all.log_epidem)
          AND (SELECT code506.code506 FROM code506 WHERE icd.ICD10_TM BETWEEN code506.code_min AND code506.code_max)
          #AND b.visit_id ='0003038676'
          GROUP BY b.VISIT_ID  ORDER BY @n DESC  ";
        $rawData = \yii::$app->db14->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db14->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        // Yii::$app->session['visit_id'] =$visit;
        // Yii::$app->session['date2'] =$date2;
        $epidem506Provider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $sqlCount1 = "SELECT COUNT(DISTINCT v.visit_id) as amount
        FROM log_epidem v 
        WHERE v.messagecode = '200' AND v.users = 'd506'
        AND v.d_update BETWEEN CURDATE() AND NOW()";
    
        $data = \yii::$app->db143->createCommand($sqlCount1)->queryAll();
         for ($i = 0; $i < sizeof($data); $i++) {
             $amount = $data[$i]['amount'];    
         }
         $total = "SELECT COUNT(DISTINCT v.visit_id) as total
         FROM log_epidem v 
         WHERE v.messagecode = '200'AND v.users = 'd506'
          ";
     
        $data = \yii::$app->db143->createCommand($total)->queryAll();
          for ($i = 0; $i < sizeof($data); $i++) {
              $total = $data[$i]['total'];    
          }
          $sqlCamount = "SELECT COUNT(DISTINCT v.visit_id) as amountx
          FROM log_epidem v 
          WHERE v.messagecode <> '200' AND v.users = 'd506'
          AND v.d_update BETWEEN CURDATE() AND NOW()";
          $data = \yii::$app->db143->createCommand($sqlCamount)->queryAll();
          for ($i = 0; $i < sizeof($data); $i++) {
              $amountx = $data[$i]['amountx'];    
          }
        return $this->render('d506', [
            // 'searchModel' => $searchModel,
            'epidem506Provider' => $epidem506Provider,
            'amount'=> $amount,
            'amountx'=> $amountx,
            'total'=> $total,

        ]);
    }
*/
    ###API PHR SEND #####################
    ################ ActionHt-> ActionCheck #########################
    public function actionCheck()
    {
        $sqltoken = "SELECT MAX(token) as token30 FROM vaccine_token";

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
            "type" => "Organization",
            "identifier" => [
                "use" => "official",
                "system" => "https://bps.moph.go.th/hcode/5",
                "value" => "10953"
            ],
            "display" => "โรงพยาบาลม่วงสามสิบ",
            "scope" => "",
            "agent" => "MBASE 2012"


        ];

        ######################################################## 
        $strPersonQuery = "SELECT DISTINCT
        trim(p.cid) as cid,
        c.hn,
        trim(p.fname) as fname,
        trim(p.lname) as lname,
        CASE
            WHEN p.PRENAME not in('') THEN TRIM(p.PRENAME)
            WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='1' THEN 'ด.ช.'
            WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='1' THEN 'นาย'
            WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='2' THEN 'ด.ญ.'
            WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='2' AND p.MARRIAGE ='1' THEN 'น.ส.'
            ELSE 'นาง'  
        END as prename,
        trim(p.lname) as family,
        p.prename_e as prefix,
        '' as suffix,
        p.prename_e as pname_eng,
        p.fname_e as engfname,
        p.lname_e as englname,
        IF(prename_e <> '', CONCAT(IF(prename_e <> '', CONCAT(prename_e,'.'),prename_e), p.fname_e,' ',p.lname_e),'') as fullname_eng,
        p.telephone as hometel,
        IF(SUBSTR(p.telephone,0,2) IN ('08','09'), 'home', 'mobile') as phone_type,
        IF(p.sex = '1', 'male', 'female') as gender,
        DATE_FORMAT(p.birthdate, '%Y-%m-%dT%H:%i:%s.000Z') as brthdate,
        p.natn_id as nation,
        REPLACE(REPLACE(REPLACE(ns.NATN_NAME, '\r', ''), '\n', ''), '\"', '') as nation_name,
        t3.TOWN_NAME as province_name,
        t2.TOWN_NAME as district_name,
        t1.TOWN_NAME as subdistrict_name,
        trim(t.TOWN_NAME) as village_name,
        LEFT(p.HOME_ADR,3) as addrpart,
        LEFT(p.TOWN_ID,6) as address_code,
        (CASE p.marriage 
            WHEN '1' THEN 'S' 
            WHEN '2' THEN 'M' 
            WHEN '3' THEN 'W' 
            WHEN '4' THEN 'D' 
            WHEN '5' THEN 'A' 
            WHEN '6' THEN 'U'
            ELSE 'S' END
        ) as marital_status,
        lm.mstatus_name as martial_status_name,
        IF(p.contact is null, IF(p.father is null, p.mother, ''), p.contact) as contact_name,
        IF(re.rl_name is null, 'ญาติ', REPLACE(re.rl_name, CHAR(13), '')) as relation,
        p.rl_phone as contact_phone,
        CONCAT(TRIM(p.HOME_ADR),' บ้าน', trim(t.TOWN_NAME), 'ตำบล', trim(t1.TOWN_NAME), ' อำเภอ', t2.TOWN_NAME, ' จังหวัด', t3.TOWN_NAME) as contact_address,
        DATE_FORMAT(p.mod_date, '%Y-%m-%dT%H:%i:%s.000Z') as period_start,
        YEAR(p.mod_date) as visit_start,
        YEAR(p.birthdate) as cid_start
    FROM 
        population p 
        INNER JOIN cid_hn c ON p.cid = c.cid 
        INNER JOIN l_mstatus lm ON p.marriage = lm.mstatus_id
        LEFT JOIN relatives re ON re.rl_id = p.rl_id
        LEFT JOIN nations ns ON ns.natn_id = p.natn_id
        LEFT JOIN towns t on p.town_id = t.town_id
        LEFT JOIN towns t1 on CONCAT(LEFT(p.town_id,6),'00')=t1.town_id 
        LEFT JOIN towns t2 ON CONCAT(LEFT(p.town_id,4),'0000')= t2.town_id
        LEFT JOIN towns t3 ON CONCAT(LEFT(p.town_id,2),'000000')=t3.town_id
    WHERE 
        c.hn = '047607'  AND LEFT(p.cid, 5) <> '00000'
";

        $data = \yii::$app->db14->createCommand($strPersonQuery)->queryAll();

        $patients = array();

        foreach ($data as $patientData) {
            $patient = [
                "identifier" => [
                    [
                        "use" => "official",
                        "system" => "https://www.dopa.go.th",
                        "type" => "CID",
                        "value" => $patientData['cid'],
                        "period" => [
                            "start" => $patientData['cid_start']
                        ]
                    ],
                    [
                        "use" => "official",
                        "system" => "https://sil-th.org/hn",
                        "assigner" => [
                            "use" => "official",
                            "system" => "https://bps.moph.go.th/hcode/5",
                            "value" => "10953",
                            "display" => "โรงพยาบาลม่วงสามสิบ"
                        ],
                        "type" => "HN",
                        "value" => $patientData['hn'],
                        "period" => [
                            "start" => $patientData['cid_start']
                        ]
                    ]
                ],
                "active" => true,
                "name" => [
                    [
                        "use" => "official",
                        "text" => "{$patientData['prename']}{$patientData['fname']} {$patientData['lname']}",
                        "languageCode" => "TH",
                        "family" => "{$patientData['lname']}",
                        "given" => [$patientData['fname']],
                        "prefix" => [$patientData['prename']],
                        "suffix" => [$patientData['lname']],
                        "period" => [
                            "start" => $patientData['period_start']
                        ]
                    ],
                    [
                        "use" => "official",
                        "text" => "{$patientData['engfname']} {$patientData['englname']}",
                        "languageCode" => "EN",
                        "family" => "{$patientData['englname']}",
                        "given" => [$patientData['engfname']],
                        "prefix" => [$patientData['prefix']],
                        "suffix" => [$patientData['englname']],
                        "period" => [
                            "start" => $patientData['period_start']
                        ]
                    ]
                ],
                "telecom" => [
                    [
                        "system" => "phone",
                        "value" => $patientData['hometel'],
                        "use" => "mobile",
                        "rank" => "1",
                        "period" => [
                            "start" => $patientData['period_start']
                        ]
                    ]
                ],
                "gender" => $patientData['gender'],
                "birthDate" => $patientData['brthdate'],
                "deceasedBoolean" => false,
                "nationality" => [
                    "coding" => [
                        [
                            "system" => "http://www.thcc.or.th/download/nationalitycode.xls",
                            "code" => "99",
                            "display" => "ไทย"
                        ]
                    ],
                    "text" => "ไทย"
                ],
                "address" => [
                    [
                        "use" => "home",
                        "type" => "both",
                        "text" => "ที่อยู่",
                        "line" => [$patientData['addrpart']],
                        "city" => $patientData['district_name'],
                        "district" => $patientData['district_name'],
                        "state" => $patientData['province_name'],
                        "postalCode" => $patientData['address_code'],
                        "country" => "TH",
                        "period" => [
                            "start" => $patientData['period_start']
                        ],
                        "address_code" => $patientData['address_code']
                    ]
                ],
                "maritalStatus" => [
                    "coding" => [
                        [
                            "system" => "http://terminology.hl7.org/CodeSystem/v3-MaritalStatus",
                            "code" => $patientData['marital_status'],
                            "display" => $patientData['martial_status_name']
                        ]
                    ],
                    "text" => $patientData['martial_status_name']
                ],
                "contact" => [
                    [
                        "relationship" => [
                            [
                                "coding" => [
                                    [
                                        "system" => "https://www.this.or.th",
                                        "code" => "1",
                                        "display" => "ญาติ"
                                    ]
                                ],
                                "text" => "ญาติ"
                            ]
                        ],
                        "name" => [
                            [
                                "use" => "official",
                                "text" => "{$patientData['contact_name']}",
                                "family" => "{$patientData['contact_name']}",
                                "languageCode" => "TH",
                                "given" => [""],
                                "prefix" => [""],
                                "suffix" => [],
                                "period" => [
                                    "start" => $patientData['period_start']
                                ]
                            ]
                        ],
                        "telecom" => [
                            [
                                "system" => "phone",
                                "value" => $patientData['contact_phone'],
                                "use" => "mobile",
                                "rank" => "1",
                                "period" => [
                                    "start" => $patientData['period_start']
                                ]
                            ]
                        ],
                        "address" => [
                            [
                                "use" => "home",
                                "type" => "both",
                                "text" => "ที่อยู่",
                                "line" => explode(" ", $patientData['contact_address']),
                                "city" => $patientData['district_name'],
                                "district" => $patientData['district_name'],
                                "state" => $patientData['province_name'],
                                "postalCode" => $patientData['address_code'],
                                "country" => "TH",
                                "period" => [
                                    "start" => $patientData['period_start']
                                ],
                                "address_code" => $patientData['address_code']
                            ]
                        ],
                        "gender" => $patientData['gender']
                    ]
                ]
            ];
            ###################### Encounter ##########################################################
            $strEncounter = "SELECT  
    o.hn,
          o.visit_id as vn,
          CONCAT(CASE
          WHEN p.PRENAME not in('') THEN TRIM(p.PRENAME)
              #WHEN TIMESTAMPDIFF(year,pv.BIRTHDATE,NOW())< '20' AND pv.sex='1' AND pv.MARRIAGE = '4'THEN 'สามเณร'
              #WHEN TIMESTAMPDIFF(year,pv.BIRTHDATE,NOW()) >= '20' AND pv.sex='1' AND pv.MARRIAGE  = '4'THEN 'พระภิกษุ'
              WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='1' THEN 'ด.ช.'
              WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='1' THEN 'นาย'
              WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='2' THEN 'ด.ญ.'
              WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='2' AND p.MARRIAGE ='1' THEN 'น.ส.'
              ELSE 'นาง' END ,'',TRIM(p.fname),'  ',p.lname) as ptname
            ,year(p.mod_date) as start_period
            , if(o.past_hx = '','ไม่ทราบ/ไม่สามารถซักประวัติได้',if(o.past_hx like 'ไม่%' or o.past_hx like 'ปฏิเสธ%','ไม่แพ้ยา','ปฏิเสธแพ้ยา')) as screen_allergy
            ,if(o.past_hx = '','9',if(o.past_hx like 'ไม่มี%' ,'1','2')) as screen_allergy_code
            ,(CASE 
                when  o.pt_states = 1 then 'EMER'
                when  o.pt_states = 2 then 'AMB'
                when  o.pt_states = 6 then 'HH'
                when  o.pt_states = 3 then 'IMP'
                when  o.pt_states = 4 then 'ACUTE'
                ELSE 'AMB'
                END ) as 'class'
           ,(case 
                when o.pt_states = 1 then 'emergency'
                when o.pt_states = 2 then 'ambulatory'
                when o.pt_states = 6 then 'Home Healthcare'
                when o.pt_states = 3 then 'Inpatient'
                when o.pt_states = 4 then 'Inpatient acute'
                else 'ambulatory'
                end ) as 'class_name'
              ,if(ipd.adm_id = 0 ,ipd.ward_no, o.unit_reg) as subclass
              ,if(ipd.adm_id = 0 ,s1.unit_name,s.unit_name) as subclass_name

              ,if(ipd.adm_id = 0 ,ipd.ward_no, o.unit_reg) as division
              ,if(ipd.adm_id = 0 ,s1.unit_name,s.unit_name) as division_name
              ,if(o.history like '%มาเอง%','1','3') as type_code
      ,if(o.history like '%มาเอง%','มารับบริการเอง','ส่งต่อจากหน่วยบริการอื่น') as type_name
                 ,(case o.pt_states 
          when 1 then 'S'
          when 2 then 'EM'
          when 3 then 'UR'
          when 4 then 'PRN'
          else 'R' end) as piority_code
      ,(case o.pt_states  
          when 1 then 'stat'
          when 2 then 'emergency'
          when 3 then 'urgent'
          when 4 then 'as needed'
          else 'routine' end) as piority_name
     ,(case o.pt_states 
          when 1 then 'จำเป็นต้องรักษาทันที'
          when 2 then 'ฉุกเฉิน'
          when 3 then 'เร่งด่วน'
          when 4 then 'ตามความจำเป็น'
          else 'ไม่เร่งด่วน' end) as piority_text
        ,if(o.history like '%ไม่สูบ%','2','1') as screen_smoke_code
      ,if(o.history like '%ไม่ดื่ม%','2','1') as screen_drink_code
      ,if(o.history like '%ไม่สูบ%','สูบบุหรี่','ไม่สูบบุหรี่') as screen_smoke
      ,if(o.history like '%ไม่ดื่ม%','ดื่มสุรา','ไม่ดื่มสุรา') as screen_drink
          ,concat(trim(p1.fname), ' ' ,p1.lname) as participant
      ,st.licence as participant_reference
      ,if(st.pos_id = '001','ว.','') as reference_code
      ,ps.pos_name as participant_type
      ,replace(replace(replace(replace(SUBSTR(o.HISTORY, LOCATE('chief complaint' ,o.HISTORY)+17, LOCATE('present illness',o.HISTORY)-LOCATE('chief complaint',o.HISTORY)), char(13),''),char(10),''),':',''),'/','') as reason
       ,'0' as total_amount
       ,'0' as paid_amount
      ,date_format(o.reg_datetime,'%Y-%m-%dT%H:%i:%s.000Z') as period_start
      ,date_format(o.finish_datetime,'%Y-%m-%dT%H:%i:%s.000Z') as period_end
      FROM 
      opd_visits o
  INNER JOIN cid_hn c ON o.hn = c.hn 
  INNER JOIN population p ON p.cid = c.cid
  LEFT JOIN opd_diagnosis d ON o.visit_id = d.visit_id AND d.is_cancel = 0 AND d.dxt_id = 1
  LEFT JOIN staff st ON st.staff_id = d.staff_id
  INNER JOIN positions ps ON ps.pos_id = st.pos_id
  INNER JOIN population p1 ON p1.cid = st.cid
  LEFT JOIN ipd_reg ipd ON ipd.visit_id = o.visit_id AND ipd.is_cancel = 0
  LEFT JOIN service_units s ON s.unit_id = o.unit_reg
  LEFT JOIN service_units s1 ON s1.unit_id = ipd.ward_no
  INNER JOIN pt_states pt ON pt.pt_states = o.pt_states
WHERE o.visit_id = '0003058181'
";

            $data = \yii::$app->db14->createCommand($strEncounter)->queryAll();

            $encounters = [];

            foreach ($data as $encounterData) {
                $encounter = [
                    "managingOrganization" => [
                        "type" => "Organization",
                        "identifier" => [
                            "use" => "official",
                            "system" => "https://bps.moph.go.th/hcode/5",
                            "value" => "10953"
                        ],
                        "display" => "โรงพยาบาลม่วงสามสิบ"
                    ],
                    "identifier" => [
                        [
                            "use" => "official",
                            "system" => "https://bps.moph.go.th/vn",
                            "value" => $encounterData['vn']
                        ],
                        [
                            "use" => "official",
                            "system" => "https://sil-th.org/hn",
                            "value" => $encounterData['hn'],
                            "period" => [
                                "start" => $encounterData['start_period']
                            ]
                        ]
                    ],
                    "status" => "finished",
                    "class" => [
                        "system" => "https://terminology.hl7.org/CodeSystem/v3-ActCode",
                        "code" => $encounterData['class'],
                        "display" => $encounterData['class_name']
                    ],
                    "subclass" => [
                        "system" => "https://bps.moph.go.th/subclass",
                        "code" => $encounterData['subclass'],
                        "display" => $encounterData['subclass_name']
                    ],
                    "division" => [
                        "system" => "https://bps.moph.go.th/division",
                        "code" => $encounterData['division'],
                        "display" => $encounterData['division_name']
                    ],
                    "type" => [
                        "coding" => [
                            [
                                "system" => "https://spd.moph.go.th/new_bps/43file_version2.3",
                                "code" => $encounterData['type_code'],
                                "display" => $encounterData['type_name']
                            ]
                        ],
                        "text" => $encounterData['type_name']
                    ],
                    "priority" => [
                        "coding" => [
                            [
                                "system" => "http://terminology.hl7.org/CodeSystem/v3-ActPriority",
                                "code" => $encounterData['piority_code'],
                                "display" => $encounterData['piority_name']
                            ]
                        ],
                        "text" => $encounterData['piority_text']
                    ],
                    "period" => [
                        "start" => $encounterData['period_start'],
                        "end" => $encounterData['period_end']
                    ],
                    "subject" => [
                        "reference" => "Patient/{$encounterData['hn']}",
                        "display" => $encounterData['ptname']
                    ],
                    "screen_allergy" => [
                        "system" => "https://bps.moph.go.th/screen_allergy",
                        "code" => $encounterData['screen_allergy_code'],
                        "display" => $encounterData['screen_allergy']
                    ],
                    "screen_smoking" => [
                        "system" => "https://bps.moph.go.th/screen_smoking",
                        "code" => $encounterData['screen_smoke_code'],
                        "display" => $encounterData['screen_smoke']
                    ],
                    "screen_drinking" => [
                        "system" => "https://bps.moph.go.th/screen_drinking",
                        "code" => $encounterData['screen_drink_code'],
                        "display" => $encounterData['screen_drink']
                    ],
                    "participant" => [
                        [
                            "individual" => [
                                "type" => [
                                    "text" => $encounterData['participant_type']
                                ],
                                "reference" => $encounterData['participant_reference'],
                                "display" => $encounterData['participant']
                            ]
                        ]
                    ],
                    "reason" => [
                        [
                            "text" => $encounterData['reason']
                        ]
                    ],
                    "financeTotalAmount" => $encounterData['total_amount'],
                    "financeReimbursementAmount" => $encounterData['paid_amount'],
                    "financePaidAmount" => $encounterData['paid_amount'],

                    // ... (add more fields as needed)
                ];

                # $encounters[] = $encounter;

            }
            ##################### COverage ###########################################
            $strCoverage = "SELECT
         p.cid
        ,date_format(uc.uc_register,'%Y-%m-%d') as period_start
        ,date_format(if(uc.uc_expire is null,'',uc.uc_expire),'%Y-%m-%d') as period_end
        ,m.nhso_code as group_value
        ,(case 
            when m.inscl in ('01', '25') then 'สิทธิข้าราชการ'
            when m.inscl in ('03', '04') then 'สิทธิหลักประกันสุขภาพแห่งชาติ'
            when m.inscl in ('11', '12') then 'ข้าราชการ อปท'
            when m.inscl in ('08','09')then 'สิทธิประกันสังคม'
            when m.inscl = '30' then 'ประกันสังคมกรณีทุพลภาพ'
            else m.inscl_name 
            end) as group_name
           ,CASE
         WHEN o.INSCL = 04  AND uc.UC_TYPE = '71' THEN 'AA'
         WHEN o.INSCL = 04  AND uc.UC_TYPE = '72' THEN 'AB'
         WHEN o.INSCL = 04  AND uc.UC_TYPE = '73' THEN 'AC'
         WHEN o.INSCL = 04  AND uc.UC_TYPE = '74' THEN 'AD'
         WHEN o.INSCL = 04  AND uc.UC_TYPE = '75' THEN 'AE'
         WHEN o.INSCL = 04  AND uc.UC_TYPE = '76' THEN 'AF'
         WHEN o.INSCL = 04  AND uc.UC_TYPE = '77' THEN 'AG'
         WHEN o.INSCL = 04  AND uc.UC_TYPE = '81' THEN 'AK'
         WHEN o.INSCL = 04  AND uc.UC_TYPE = '82' THEN 'AJ'
         WHEN o.INSCL = 04  THEN 'UB'
         WHEN o.INSCL in (23,00,33) THEN 'UB'
         WHEN o.INSCL = 03 THEN 'UC'
         WHEN o.INSCL in (01,11,12,14,22,25,35,36,37,38,40) THEN 'A2'
         WHEN o.INSCL in (08,09,21,30,31) THEN 'A7'
         WHEN o.INSCL in (18,19) THEN 'A9'
         WHEN o.INSCL in (05,16) THEN 'AL'
         ELSE 'A1'
         END  as subgroup_value
        ,(case 
            when m.inscl in ('01', '25') then m.inscl_name
            when m.inscl in ('03', '04') then m.inscl_name
            when m.inscl in ('11', '12') then m.inscl_name
            when m.inscl in ('08')then m.inscl_name
						when m.inscl in ('09')then m.inscl_name
            when m.inscl = '30' then m.inscl_name
            else m.inscl_name 
            end) as subgroup_name
        ,CASE
				WHEN o.inscl in ('03','04') THEN if(uc.hospmain is null,'',uc.hospmain)
				WHEN o.inscl in (08,09,21,30,31) THEN h.hosp_id
				WHEN o.inscl in (01,11,12,14,22,25,35,36,37,38,40) THEN ''
        END as main_hospital
        ,if(hs.hosp_name is null,'',hs.hosp_name) as main_hospital_name
				,if(uc.hospsub is null,'',uc.hospsub) as sub_hospital
        ,if(hs1.hosp_name is null,'',hs1.hosp_name) as sub_hospital_name
        ,o.paid as amount       
        FROM 
        opd_visits o
    INNER JOIN cid_hn c ON o.hn = c.hn 
    INNER JOIN population p ON p.cid = c.cid
    LEFT JOIN opd_diagnosis d ON o.visit_id = d.visit_id AND d.is_cancel = 0 AND d.dxt_id = 1
		LEFT JOIN uc_inscl uc ON uc.cid = p.cid AND (uc.date_abort = date(o.REG_DATETIME) or day(uc.date_abort)=0 and trim(uc.hospmain) <>'' )
		LEFT JOIN main_inscls m ON m.inscl = o.inscl 
		LEFT JOIN hosp_sss h ON h.cid = p.cid AND h.DATE_ABORT = 0
    LEFT JOIN hospitals hs ON (hs.hosp_id = uc.hospmain OR hs.hosp_id = h.hosp_id)
    LEFT JOIN hospitals hs1 ON hs1.hosp_id = uc.hospsub
       where o.visit_id = '0003058181'";
            $coverages = [];

            // Execute your SQL query to get coverage information
            $dataCoverage = \yii::$app->db14->createCommand($strCoverage)->queryAll();

            foreach ($dataCoverage as $coverageData) {
                $coverage = [
                    "identifier" => [
                        [
                            "system" => "https://www.nhso.go.th/certificate"
                        ],
                        [
                            "system" => "https://www.nhso.go.th/authcode",
                            "value" => ""
                        ]
                    ],
                    "status" => "active",
                    "type" => [
                        "coding" => [
                            [
                                "system" => "http://terminology.hl7.org/CodeSystem/v3-ActCode",
                                "code" => "PUBLICPOL",
                                "display" => "public healthcare"
                            ]
                        ]
                    ],
                    "relationship" => [
                        "coding" => [
                            [
                                "system" => "http://terminology.hl7.org/CodeSystem/subscriber-relationship",
                                "code" => "self",
                                "display" => "Self"
                            ]
                        ]
                    ],
                    "period" => [
                        "start" => $coverageData['period_start'],
                        "end" => $coverageData['period_end']
                    ],
                    "payor" => [
                        [
                            "reference" => "สำนักงานหลักประกันสุขภาพแห่งชาติ"
                        ]
                    ],
                    "class" => [
                        [
                            "type" => [
                                "coding" => [
                                    [
                                        "system" => "http://terminology.hl7.org/CodeSystem/coverage-class",
                                        "code" => "group"
                                    ]
                                ]
                            ],
                            "value" => "UCS",
                            "name" => "สิทธิหลักประกันสุขภาพแห่งชาติ"
                        ],
                        [
                            "type" => [
                                "coding" => [
                                    [
                                        "system" => "http://terminology.hl7.org/CodeSystem/coverage-class",
                                        "code" => "subgroup"
                                    ]
                                ]
                            ],
                            "value" => "UC",
                            "name" => "ประกันสุขภาพถ้วนหน้า"
                        ]
                    ],
                    "reimbursementAmount" => $coverageData['amount'],
                    "contract" => [
                        [
                            "reference" => "MainHospital",
                            "identifier" => $coverageData['main_hospital'],
                            "display" => $coverageData['main_hospital_name']
                        ],
                        [
                            "reference" => "SubHospital",
                            "identifier" => $coverageData['sub_hospital'],
                            "display" => $coverageData['sub_hospital_name']
                        ]
                    ]
                ];

                $coverages[] = $coverage;
            }

            // Add the "Coverage" section to the encounter
            $encounter["Coverage"] = $coverages;
        }
        ########### Vitual Signs ####################################################
        $strVituals = " SELECT 
     o.weight as bw
    ,o.BP_SYST as sbp
    ,o.BP_DIAS as bp_diastolic
     ,o.BODY_TEMP as tt
     ,if(o.BP_SYST  between 60 and 120,'normal',if(o.BP_SYST  > 120,'High',if(o.BP_SYST = 0,'ไม่ได้วัด','Low'))) as sbp_interpretation
     ,if(o.BP_DIAS between 40 and 90,'normal',if(o.BP_DIAS > 90,'High',if(o.BP_DIAS = 0,'ไม่ได้วัด','Low'))) as dbp_interpretation
     ,o.RESP_RATE as rr 
     ,o.PULSE_RATE as pr
     ,o.height as height
     FROM opd_visits o 
     WHERE o.visit_id='0003058181'
     ";
        $dataEncounter = \yii::$app->db14->createCommand($strVituals)->queryAll();

        foreach ($dataEncounter as $encounterData) {

            $vitalSigns = [
                "body_weight" => [
                    "status" => "final",
                    "valueQuantity" => [
                        "value" => $encounterData['bw'],  // Replace with the actual weight value
                        "unit" => "kg"
                    ]
                ],
                "body_height" => [
                    "status" => "final",
                    "valueQuantity" => [
                        "value" => $encounterData['height'],  // Replace with the actual height value
                        "unit" => "cm"
                    ]
                ],
                "body_temp" => [
                    "status" => "final",
                    "valueQuantity" => [
                        "value" => $encounterData['tt'],  // Replace with the actual temperature value
                        "unit" => "cel"
                    ]
                ],
                "bp_systolic" => [
                    "status" => "final",
                    "valueQuantity" => [
                        "value" => $encounterData['sbp'],  // Replace with the actual systolic BP value
                        "unit" => "mmHg"
                    ],
                    "interpretation" => [
                        "text" => $encounterData['sbp_interpretation']
                    ]
                ],
                "bp_diastolic" => [
                    "status" => "final",
                    "valueQuantity" => [
                        "value" => $encounterData['bp_diastolic'],  // Replace with the actual diastolic BP value
                        "unit" => "mmHg"
                    ],
                    "interpretation" => [
                        "text" => $encounterData['dbp_interpretation']
                    ]
                ],
                // "vital_sign_body_mass_index" ,
                //"vital_sign_respiratory_rate",
                //"vital_sign_pulse",

            ];

            // Add the "Vital Signs" section to the encounter
            $encounter["vital_signs"] = $vitalSigns;
            ################# ObServe ###########################################
            $strObservation = "SELECT
            l.visit_id as vn
            ,l.lab_no as ln
            ,ll.LAB_SNAME as lab_code_local
            ,ll.LAB_NAME as lab_name
            ,ll.lab_code as labcode
            ,RTRIM(LTRIM(SUBSTRING_INDEX(trim(l.lab_result),'[',1))) as lab_result
            ,'' as unit
            ,ll.NORMAL_VAL as normal
            ,'' as comment
            ,'' as labcomment
            ,concat(date(l.lreq_dt),'T',time(l.LREQ_DT),'.000Z') as issued
            ,if(l.LRPT_DT = 1 , 'final','final') as status
            ,ll.TMLT_code as tmlt_code
            ,ll.LOINC_num as loinc_code
            ,'' as loinc_name
            ,'' as ref_min
            ,'' as ref_max
            FROM lab_requests as l 
            INNER JOIN lab_lists ll ON l.lab_id = ll.lab_id AND ll.is_cancel = 0 AND ll.is_secret = 0
            where l.visit_id = '0003055696' #'0003055717'
            AND l.LAB_RESULT <> ''
            AND l.LAB_ID not in ('145','277','081','232')
            AND l.IS_CANCEL = 0
            ";

            $dataObservation = \yii::$app->db14->createCommand($strObservation)->queryAll();

            $observations = [];

            foreach ($dataObservation as $observationData) {
                $observation = [
                    "status" => "final",
                    "issued" => $observationData['issued'],
                    "category" => [
                        "coding" => [
                            [
                                "system" => "http://terminology.hl7.org/CodeSystem/observation-category",
                                "code" => "laboratory",
                                "display" => "Laboratory"
                            ]
                        ]
                    ],
                    "code" => [
                        "coding" => [
                            [
                                "system" => "http://snomed.info/id",
                                "code" => $observationData['loinc_code'],
                                "display" => $observationData['loinc_name']
                            ]
                        ],
                        "text" => $observationData['lab_name']
                    ],
                    "valueQuantity" => [
                        "value" => (float)$observationData['lab_result'],
                        "unit" => $observationData['unit']
                    ],
                    "profile_group" => "AAA",
                    "asserter" => [
                        "reference" => "Practitioner/0000000000000",
                        "display" => "นพ.ทดสอบ ระบบ"
                    ]
                ];
            
               
                $observations[] = $observation;
            }
            
            $encounter["Observation"] = $observations;

            ##### Condition ##############################################################################
            $strCondition = "SELECT  
            if(length(i.icd10_tm) > 3,concat(substr(i.icd10_tm,1,3),'.',substr(i.icd10_tm,4,4)),i.icd10_tm) as diag_code
            ,i.icd_name as diag_name
            ,concat(date_format(date(d.dx_dt),'%Y-%m-%dT'),time(d.dx_dt),'.000Z') as record_time
            FROM opd_visits o 
            INNER JOIN opd_diagnosis d ON o.visit_id = d.visit_id AND d.is_cancel = 0
            INNER JOIN icd10new i ON d.icd10 = i.icd10
            where o.visit_id = '0003055662'
            ";
            $dataCondition = \yii::$app->db14->createCommand($strCondition)->queryAll();

            $conditions = [];
            
            foreach ($dataCondition as $conditionData) {
                $condition = [
                    "clinicalStatus" => [
                        "coding" => [
                            [
                                "system" => "http://terminology.hl7.org/CodeSystem/conditionclinical",
                                "code" => "active",
                                "display" => "Active"
                            ]
                        ]
                    ],
                    "verificationStatus" => [
                        "coding" => [
                            [
                                "system" => "http://terminology.hl7.org/CodeSystem/condition-verstatus",
                                "code" => "confirmed",
                                "display" => "Confirmed"
                            ]
                        ]
                    ],
                    "category" => [
                        [
                            "coding" => [
                                [
                                    "system" => "http://snomed.info/sct",
                                    "code" => "439401001",
                                    "display" => "Diagnosis"
                                ]
                            ]
                        ]
                    ],
                    "severity" => [
                        "coding" => [
                            [
                                "system" => "http://snomed.info/sct",
                                "code" => "24484000",
                                "display" => "Severe"
                            ]
                        ]
                    ],
                    "code" => [
                        "coding" => [
                            [
                                "system" => "http://hl7.org/fhir/sid/icd-10",
                                "code" => $conditionData['diag_code'],
                                "display" => $conditionData['diag_name']
                            ]
                        ],
                        "text" => $conditionData['diag_name']
                    ],
                    "bodySite" => [
                        [
                            "coding" => [
                                [
                                    "system" => "http://snomed.info/sct",
                                    "code" => "",
                                    "display" => ""
                                ]
                            ],
                            "text" => ""
                        ]
                    ],
                    "recordedDate" => $conditionData['record_time']
                ];
                $conditions[] = $condition;
            }
            
            $encounter["Condition"] = $conditions;

            
            ################ Medication ################################################################################
            $strMedication = "SELECT DISTINCT
            o.visit_id
                   , CASE
                       WHEN o.visit_id not in (SELECT visit_id FROM ipd_reg) THEN 'outpatient'
                       WHEN o.visit_id  in (SELECT visit_id FROM ipd_reg) THEN 'inpatient'					 
                       END AS category
                   , CASE
                       WHEN o.visit_id not in (SELECT visit_id FROM ipd_reg) THEN 'ผู้ป่วยนอก'
                       WHEN o.visit_id  in (SELECT visit_id FROM ipd_reg) THEN 'ผู้ป่วยใน'					 
                       END AS category_display
            ,concat(date(o.reg_datetime),'T',time(o.reg_datetime),'.000Z') as prsc_time
            ,CASE
                       WHEN ps.visit_id THEN trim(d.drug_name)
                       WHEN i.visit_id THEN trim(d1.drug_name)
             END as drug_name
             ,CONCAT(trim(d.DRUG_NAME),' ',df.DFORM_SNAME,' (',cast(d.STRENGTH as DECIMAL(8,0)),' ',s.strength_name,'/',cast(d.ST_NUM_UUNIT as DECIMAL(8,0)),'',un.UUNIT_NAME,')') as generic_name
             ,if(tm.tmtid is null, '',tm.tmtid ) as tmt_code
             ,replace(replace((d.attention),char(13),''),char(10),'') as med_use
             ,replace(replace(r.route_thai,char(13),''),char(10),'') as use_route
            ,r.route_name as use_code
            ,ps.rx_amount as qty
            ,un.uunit_id as unit
            ,un.UUNIT_NAME as pres_unt
           FROM opd_visits as o
           LEFT  JOIN prescriptions ps ON ps.visit_id = o.visit_id AND o.is_cancel = 0 AND ps.is_cancel = 0  AND o.is_cancel = 0
           LEFT JOIN drugs d ON d.drug_id = ps.drug_id
           LEFT JOIN ipd_reg i ON i.visit_id = o.visit_id AND i.is_cancel = 0
           LEFT JOIN ipd_cont ic ON ic.visit_id = i.visit_id
           LEFT JOIN drugs d1 ON d1.drug_id = ic.drug_id
           LEFT JOIN tmt10953 tm ON tm.drug_id = d.drug_id
           LEFT JOIN usage_units un ON d.PACKAGE = un.UUNIT_ID
           INNER JOIN routes r ON r.route_id = ps.route_id 
           INNER JOIN strength_units s ON s.strength_unit = d.strength_unit
           INNER JOIN frequency f on f.frq_id = ps.frq_id
           INNER JOIN dosage_forms df ON df.DFORM_ID = d.DFORM_ID
           INNER JOIN usage_units u ON d.ST_TXT_UUNIT = u.UUNIT_ID
           INNER JOIN usage_units us ON d.UUNIT_ID = us.UUNIT_ID 
           WHERE o.visit_id = '0003055657'
            ";
            $dataMedication = \yii::$app->db14->createCommand($strMedication)->queryAll();

            // Initialize the Encounter array
            $encounter = [];
            
            // Initialize the Medication array
            $medications = [];
            
            foreach ($dataMedication as $medicationData) {
                $medication = [
                    "code" => [
                        "coding" => [
                            [
                                "system" => "https://www.this.or.th/tmt/gp",
                                "code" => $medicationData['tmt_code'],
                                "display" => $medicationData['generic_name']
                            ]
                        ],
                        "text" => $medicationData['drug_name']
                    ],
                    "category" => "medication", // or "non-medication" if needed
                    "form" => [
                        "coding" => [
                            [
                                "system" => "http://snomed.info/sct",
                                "code" => "732937005",
                                "display" => "Capsule"
                            ]
                        ]
                    ],
                    "finance" => [
                        "qty" => 10.0,
                        "unitPrice" => 0.5
                    ],
                    "statement" => [
                        "status" => "active",
                        "category" => [
                            "coding" => [
                                [
                                    "system" => "http://terminology.hl7.org/CodeSystem/medication-statement-category",
                                    "code" => "outpatient",
                                    "display" => "Outpatient"
                                ]
                            ]
                        ],
                        "effectiveDateTime" => "2016-01-01T08:00:00.000Z",
                        "note" => [
                            [
                                "time" => "2016-01-01T08:00:00.000Z",
                                "text" => "ทดสอบ Note"
                            ]
                        ],
                        "dosage" => [
                            [
                                "sequence" => 1,
                                "text" => "PO 2 TID PC",
                                "patientInstruction" => "ทานครั้งละ 2 เม็ด วันละ 3 ครั้ง หลังอาหาร เช้า เที่ยง เย็น",
                                "timing" => [
                                    "repeat" => [
                                        "frequency" => 3,
                                        "period" => 1,
                                        "periodUnit" => "d"
                                    ]
                                ],
                                "route" => [
                                    "coding" => [
                                        [
                                            "system" => "http://standardterms.edqm.eu",
                                            "code" => "20053000",
                                            "display" => "Oral use"
                                        ]
                                    ]
                                ],
                                "doseAndRate" => [
                                    [
                                        "type" => [
                                            "coding" => [
                                                [
                                                    "system" => "http://terminology.hl7.org/CodeSystem/dose-rate-type",
                                                    "code" => "ordered",
                                                    "display" => "Ordered"
                                                ]
                                            ]
                                        ],
                                        "doseQuantity" => [
                                            "value" => 1,
                                            "unit" => "tablet",
                                            "system" => "http://snomed.info/sct",
                                            "code" => "732936001"
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ];
            
                // Add this medication to the medications array
                $medications[] = $medication;
            }
            
            // Add the "Medication" array to the Encounter
            $encounter[] = [
                "Medication" => $medications
            ];
            
            ####################แสดง Encounter #########################################################################
            $encounters[] = $encounter;
        }
        $result = [
            "managingOrganization" => $hospital,
            "Patient" => $patient,
            "AllergyIntolerance" => [],
            "Encounter" => $encounters,
        ];

        $resultText = json_encode($result, JSON_PRETTY_PRINT);
        echo $resultText;
    }
}
