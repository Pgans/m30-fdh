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

class DmhtController extends \yii\web\Controller
{
    public function actionIndex()
    {
        // $_token = $model->token;


        return $this->render('index');
    }
    public function actionDelete_all()
    {
        //return 'นายชาตรี บุญทา';

        //$selection = \Yii::$app->request->post('selection');
        $visits =  Yii::$app->request->post('chkDel');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $visits;
    }

    ################ ActionHt-> ActionCheck #########################
    public function actionCheck()
    {
        $sqltoken = "SELECT MAX(token) as token30 FROM vaccine_token";

        $data = \yii::$app->db14->createCommand($sqltoken)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $token30 = $data[$i]['token30'];
        }
        ##################################################################     
        $vn =  Yii::$app->request->post('chkDel');
        foreach ($vn  as $r) {
            $hn = substr($r, 10);
            //echo $hn.'<br />';
            $visit_id = substr($r, 0, 10);

        ############# Send Moph-claim HT #############
        $strHt = "SELECT distinct 
            o.visit_id as seq
            ,o.hn
            ,p.cid as pid
            ,'1' as id_type
            ,CASE
              WHEN p.PRENAME not in('') THEN TRIM(p.PRENAME)
              WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='1' THEN 'ด.ช.'
              WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='1' THEN 'นาย'
              WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='2' THEN 'ด.ญ.'
              WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='2' AND p.MARRIAGE ='1' THEN 'น.ส.'
              ELSE 'นาง'  
              END as title
            ,trim(p.fname) as fname
            ,trim(p.lname) as lname
            ,oc.oc_name as occupa
            ,CASE
            WHEN p.marriage = '1' THEN '1'
            WHEN p.marriage = '2' THEN '2'
            WHEN p.marriage = '3' THEN '3'
            WHEN p.marriage = '4' THEN '6'
            ELSE '9'
            END AS marriage
            ,p.birthdate as dob
            ,p.sex
            ,concat('0',n.natn_id) as nation
            ,h.hospcode as hcode
            ,concat('โรงพยาบาล',h.hospname) as hospital_name
            ,DATE_FORMAT(o.reg_datetime,'%Y-%m-%dT%T.000Z') as visit_date_time
            ,'1' as uuc
            ,'0' as is_used_dm
            ,'1' as is_used_ht
            ,'' as dm_diag
            ,'I10' as ht_diag
            ,'' as dm_dx_type
            ,'1' as ht_dx_type
            ,l.lab_result as hba1c2
            ,'' as hba1c
           , CAST(SUBSTR(l.lab_result,LOCATE('Chloride=', l.lab_result)+9,3) AS DECIMAL) AS creatinine
            ,CAST(SUBSTR(l.lab_result,LOCATE('Potassium=', l.lab_result)+10,3) AS DECIMAL) AS k
            ,'Creatinine (Cr)' as name_cr
            ,'32202' as code_cr
			,'Potassium (K)' as name_k	
            ,'32103' as code_k
            FROM address_hosp h, opd_visits o 
           INNER JOIN cid_hn c ON o.HN=c.HN AND o.IS_CANCEL=0
           INNER JOIN population p ON p.CID=c.CID
           LEFT JOIN opd_diagnosis dx on dx.visit_id= o.visit_id AND dx.is_cancel=0
           LEFT  JOIN icd10new i on i.icd10=dx.icd10
           LEFT JOIN lab_requests l ON l.visit_id = o.visit_id AND l.is_cancel = 0
           INNER JOIN lab_lists ll ON ll.lab_id = l.lab_id
            LEFT JOIN occupation_new oc ON oc.oc_id = p.oc_id
           LEFT JOIN nations n ON n.natn_id = p.natn_id
           WHERE  o.visit_id = '$visit_id'#${info . vn}
          # AND o.visit_id not in (SELECT ipd_reg.VISIT_ID FROM ipd_reg WHERE ipd_reg.IS_CANCEL=0)
           AND left(i.icd10_tm,2) = 'I1'
           AND l.lab_id in ('081','047')
           AND o.inscl in ('03','04')
           GROUP BY o.visit_id, l.lab_id 
             ";
        $data = \yii::$app->db14->createCommand($strHt)->queryAll();
        $result = [];

        foreach ($data as $row) {
            $ht_report = [
                "seq" => $row['seq'],
                'hn' => $row['hn'],
                'pid' => $row['pid'],
                'id_type' => $row['id_type'],
                'title' => $row['title'],
                'fname' => $row['fname'],
                'lname' => $row['lname'],
                'occupa' => $row['occupa'],
                'marriage' => $row['marriage'],
                'dob' => $row['dob'],
                'sex' => $row['sex'],
                'nation' => $row['nation'],
                'uuc' => $row['uuc'],
                'hcode' => $row['hcode'],
                'hospital_name' => $row['hospital_name'],
                'visit_date_time' => $row['visit_date_time'],
                'is_used_dm' => $row['is_used_dm'],
                'is_used_ht' => $row['is_used_ht'],
                'diagnosis' => [
                    [
                        "dx_date_time" => $row['visit_date_time'],
                        "icd10" => $row['ht_diag'],
                        "dx_type" => $row['ht_dx_type']
                    ]
                ],
                'claim_services' => [
                    [
                        "name" => $row['name_cr'],
                        "code" => $row['code_cr'],
                        "lab_result" => $row['creatinine']
                    ],
                    [
                        "name" => $row['name_k'],
                        "code" => $row['code_k'],
                        "lab_result" => $row['k']
                    ]
                ]
            ];

            $result = $ht_report;
        }

        // Convert to JSON
        $jsonResult = json_encode($result, JSON_PRETTY_PRINT);
       // echo $jsonResult;


        #############################################################################################################
        $url = "https://claim-nhso.moph.go.th/api/v1/opd/service-admissions/dmht";
        # $url = "https://epidemcenter.moph.go.th/epidem506";

        $curl = curl_init($url);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            //SSL USE
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,

            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $jsonResult,
            CURLOPT_HTTPHEADER => array(
                "Content-type: application/json",
                "Authorization: Bearer " . $token30
            ),
        ));

        $response = curl_exec($curl);
        $ht = json_decode($response, true);
        $err = curl_error($curl);
        //curl_close($curl);
        //  echo $response;
        curl_close($curl);
        $pid = $ht['results']['pid'];
        $message = $ht['message'];
        $message_th = $ht['message_th'];
        //  echo $message_th;
        $status = $ht['status'];
      // echo $response;
        ############################INSERT TABLE Log_dmht#############################

        if (strlen($response) > 0) {
            $strSQL = "REPLACE INTO log_dmht (visit_id, pid, cid,status, messagecode ,response , users,d_update) VALUES ('$visit_id','$hn','$pid',$status,'$message','$message_th' ,'ht',NOW())";
            Yii::$app->db143->createCommand($strSQL)->execute();
        }
           }
             return $this->redirect(['ht']);
    }


    ################# ดึงข้อมูลให้ฟอร์ม HT ########################
    public function actionHt()
    {
        $sql = "SELECT @n :=@n +1 'No'
        ,date(o.reg_datetime) 'regdate'
        ,o.visit_id
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
          TIMESTAMPDIFF(year,p.BIRTHDATE,o.REG_DATETIME) as 'age',
          p.cid,
        GROUP_CONCAT(DISTINCT trim(icd.ICD10_TM)) as Diag
        ,left(e.unit_name,10) 'unit_name' 
        ,GROUP_CONCAT(DISTINCT l.lab_id) as lab
        ,GROUP_CONCAT(DISTINCT l.lab_name) as labname
        ,CASE
	    WHEN ak.claimcode = '' THEN 'ว่าง'
	    WHEN ak.claimcode <> '' THEN ak.claimcode
        END AS claimcode
          FROM (select @n := 0) m, opd_visits o 
          INNER JOIN cid_hn c on o.HN= c.HN
          INNER JOIN population p on c.CID=p.CID AND left(p.cid,5) <> '00000'
          INNER JOIN opd_diagnosis d ON d.visit_id = o.visit_id AND d.is_cancel = 0 
          LEFT JOIN icd10new icd ON icd.icd10 = d.icd10 AND icd.icd10 <> ''
          INNER JOIN service_units e ON o.UNIT_REG=e.unit_id
          LEFT JOIN lab_requests lr ON lr.visit_id = o.visit_id AND lr.is_cancel = 0 
          LEFT JOIN lab_lists l ON l.lab_id = lr.lab_id  
          LEFT JOIN authen_kiosk ak ON p.CID = ak.cid  AND date(o.REG_DATETIME)=date(ak.d_update)
          WHERE o.IS_CANCEL = 0
          #AND o.REG_DATETIME BETWEEN '2023-10-01 00:01' AND CURDATE()-1
          AND o.REG_DATETIME BETWEEN SUBDATE(CURDATE() ,INTERVAL 5 DAY) AND NOW()
          AND left(icd.icd10_tm, 2) = 'I1' 
          AND l.lab_id in ('047','081')
          AND o.inscl in ('03','04')
          AND o.visit_id not in (SELECT ipd_reg.VISIT_ID FROM ipd_reg WHERE ipd_reg.IS_CANCEL=0)
          AND o.visit_id  not in (SELECT vs.visit_id from log_all.log_dmht vs )
          GROUP BY o.VISIT_ID ORDER BY NO DESC limit 5
        ";
        $rawData = \yii::$app->db14->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db14->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $htProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        $sqlCount1 = "SELECT COUNT(DISTINCT v.visit_id) as amount
         FROM log_dmht v 
         WHERE v.messagecode = 'success'
         AND v.d_update BETWEEN CURDATE() AND NOW()";

        $data = \yii::$app->db143->createCommand($sqlCount1)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $amount = $data[$i]['amount'];
        }

        $sqlCamount = "SELECT COUNT(DISTINCT v.visit_id) as amountx
          FROM log_dmht v 
          WHERE v.messagecode <> 'success'
          AND v.d_update BETWEEN CURDATE() AND NOW()";
        $data = \yii::$app->db143->createCommand($sqlCamount)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $amountx = $data[$i]['amountx'];
        }
        $total = "SELECT COUNT(DISTINCT v.visit_id) as total
          FROM log_dmht v 
          WHERE v.messagecode = 'success' 
          AND v.d_update BETWEEN '2023-10-01' AND NOW()
          ";

        $data = \yii::$app->db143->createCommand($total)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $total = $data[$i]['total'];
        }
        ########################################################################################################
        $sqlPass = "select l.id, l.visit_id, l.pid, l.`status`, l.messagecode, l.response, l.users, l.d_update
        FROM log_dmht l 
        WHERE l.d_update BETWEEN CURDATE() AND NOW() AND l.messagecode = 'success'
        ORDER BY l.d_update DESC
            ";
            $rawData = \Yii::$app->db143->createCommand($sqlPass)->queryAll();

            // สร้าง Flash Alert
            //Yii::$app->session->setFlash('success', 'รายการที่ไม่ผ่านตามเงื่อนไข');
            
            $passProvider = new \yii\data\ArrayDataProvider([
                'allModels' => $rawData,
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
        ########################################################################################################
        $sqlError = "select l.id, l.visit_id, l.pid, l.`status`, l.messagecode, l.response, l.users, l.d_update
        FROM log_dmht l 
        WHERE l.d_update BETWEEN CURDATE() AND NOW() AND l.messagecode <> 'success'
        ORDER BY l.d_update DESC
            ";
            $rawData = \Yii::$app->db143->createCommand($sqlError)->queryAll();

            // สร้าง Flash Alert
            //Yii::$app->session->setFlash('success', 'รายการที่ไม่ผ่านตามเงื่อนไข');
            
            $loghtProvider = new \yii\data\ArrayDataProvider([
                'allModels' => $rawData,
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);
            
        return $this->render('ht', [
            // 'searchModel' => $searchModel,
            'htProvider' => $htProvider,
            'loghtProvider' => $loghtProvider,
            'passProvider' => $passProvider,
            'amount' => $amount,
            'amountx' => $amountx,
            'total' => $total,

        ]);
    }

    // public function actionLoghterror()
    // {
    //     $sql = "select l.id, l.visit_id, l.pid, l.`status`, l.messagecode, l.response, l.users, l.d_update
    //     FROM log_dmht l WHERE l.d_update BETWEEN CURDATE() AND NOW()
    //     ORDER BY l.d_update DESC
    //         ";
    //         $rawData = \Yii::$app->db143->createCommand($sql)->queryAll();

    //         // สร้าง Flash Alert
    //         \Yii::$app->session->setFlash('success', 'รายการที่ไม่ผ่านตามเงื่อนไข');
            
    //         $loghtProvider = new \yii\data\ArrayDataProvider([
    //             'allModels' => $rawData,
    //             'pagination' => [
    //                 'pageSize' => 15,
    //             ],
    //         ]);
            

    //     return $this->render('ht', [
    //         // 'searchModel' => $searchModel,
    //         'loghtProvider' => $loghtProvider,

    //     ]);
    // }
}
