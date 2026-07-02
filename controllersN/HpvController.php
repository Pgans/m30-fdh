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
use app\models\Dt;

class HpvController extends \yii\web\Controller
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
        $sqltoken ="SELECT MAX(token) as token30 FROM vaccine_token";

       $data = \yii::$app->db2->createCommand($sqltoken)->queryAll();
           for ($i = 0; $i < sizeof($data); $i++) {
               $token30 = $data[$i]['token30'];    
           }
    ##################################################################     
        $vn =  Yii::$app->request->post('chkDel');
       // $delete_ids = explode(',', \Yii::$app->request->post('chkDel'));
      //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
       //$vn = explode(',', Yii::$app->request->post('chkDel'));
       //$vn = explode("", $visit_id);
       //$rev_data = unserialize($visit_id);  // เวลา select ออกมาใช้ ใช้แบบนี้ครับ
       //set_time_limit(100);
       foreach ($vn  as $r) {
        $hn = substr($r, 10);
        //echo $hn.'<br />';
        $visit_id = substr($r, 0, 10);
     
        ############# Send Moph-claim #############
        #$token = "eyJhbGciOiJSUzUxMiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJva3AxMDk1M0AxMDk1MyIsImlhdCI6MTY3MTcwNzc4MSwiZXhwIjoxNjcxNzI1NzgxLCJpc3MiOiJNT1BIIEFjY291bnQgQ2VudGVyIiwiYXVkIjoiTU9QSCBBUEkiLCJjbGllbnQiOnsidXNlcl9pZCI6MTU2OSwidXNlcl9oYXNoIjoiMjlGMEQzRTY0ODlFM0ZCMkFGNDlBQzZCMkUxOUUyMTE3RTQ1OEVGNEVFRUQyMEJFNDRDMTNEMTgzREUxRTAwRDhFQ0RGMEFCIiwibG9naW4iOiJva3AxMDk1MyIsIm5hbWUiOiLguJnguLLguKLguIrguLLguJXguKPguLUg4Lia4Li44LiN4LiX4LiyIiwiaG9zcGl0YWxfbmFtZSI6IuC5guC4o-C4h-C4nuC4ouC4suC4muC4suC4peC4oeC5iOC4p-C4h-C4quC4suC4oeC4quC4tOC4miIsImhvc3BpdGFsX2NvZGUiOiIxMDk1MyIsImVtYWlsIjoibWhvc3AuZ2FuQGdtYWlsLmNvbSIsImFjY291bnRfYWN0aXZhdGVkIjp0cnVlLCJhY2NvdW50X3N1c3BlbmRlZCI6ZmFsc2UsImNpZF9oYXNoIjoiOUFDREQwRDg0Mzc1RTdERjcwMDhCNjM4QUZBNjc2QTI6MzEiLCJjaWRfZW5jcnlwdCI6IjQ4NjQ4QjU2MkQ2NTY2QUJFOUZBNTIyOUVENjUwNEUxMjY3NDk3REE4OUE1N0FDNjJGODdFMzQyM0YyNTZEQTU2QzZFQUI5QTk5RkMwM0UyMjQ2NjM5QTRGMyIsImNpZF9hZXMiOiJiTTZkUlpaMy9ETWZGVjB5UVNXd3lnPT0iLCJjbGllbnRfaXAiOiIxODMuODguMjE0LjEzMCIsInNjb3BlIjpbeyJjb2RlIjoiTU9QSF9QSFJfSElFOjEifSx7ImNvZGUiOiJNT1BIX0ZPUkVJR05fSURQOjEifSx7ImNvZGUiOiJNT1BIX0ZPUkVJR05fSURQOjEifSx7ImNvZGUiOiJNT1BIX1BIUl9EQVNIQk9BUkQ6MSJ9LHsiY29kZSI6Ik1PUEhfUEhSX0RBU0hCT0FSRF9SRVBPUlQ6MSJ9LHsiY29kZSI6Ik1PUEhfSURQX0FQSToxIn0seyJjb2RlIjoiTU9QSF9DTEFJTToxIn0seyJjb2RlIjoiTU9QSF9DTEFJTV9BUEk6MSJ9LHsiY29kZSI6IklNTVVOSVpBVElPTl9WSUVXOjIifSx7ImNvZGUiOiJJTU1VTklaQVRJT05fVVBEQVRFOjIifSx7ImNvZGUiOiJNT1BIX0FDQ09VTlRfQ0VOVEVSX0FETUlOOjIifSx7ImNvZGUiOiJJTU1VTklaQVRJT05fUEVSU09OX1VQTE9BRDoyIn0seyJjb2RlIjoiSU1NVU5JWkFUSU9OX0RBU0hCT0FSRDoyIn0seyJjb2RlIjoiSU1NVU5JWkFUSU9OX1NMT1Q6MiJ9LHsiY29kZSI6IklNTVVOSVpBVElPTl9RVU9UQToyIn0seyJjb2RlIjoiSU1NVU5JWkFUSU9OX1JFUE9SVDoyIn0seyJjb2RlIjoiSU1NVU5JWkFUSU9OX1JFUE9SVF9FWENFTDoyIn0seyJjb2RlIjoiSU1NVU5JWkFUSU9OX0NPTVBBTlk6MiJ9LHsiY29kZSI6IklNTVVOSVpBVElPTl9MQUI6MiJ9LHsiY29kZSI6IklNTVVOSVpBVElPTl9TTE9UX01BTkFHRVI6MiJ9LHsiY29kZSI6IkVQSURFTV9SRVBPUlQ6MiJ9LHsiY29kZSI6Ik1PUEhfRk9SRUlHTl9JRFA6MiJ9LHsiY29kZSI6Ik1PUEhfSURQX0FETUlOOjIifSx7ImNvZGUiOiJNT1BIX0NMQUlNX0FETUlOOjIifSx7ImNvZGUiOiJNT1BIX0lEUF9BUEk6MyJ9LHsiY29kZSI6IklNTVVOSVpBVElPTl9VUERBVEU6MSJ9LHsiY29kZSI6IklNTVVOSVpBVElPTl9QRVJTT05fVVBMT0FEOjEifSx7ImNvZGUiOiJJTU1VTklaQVRJT05fREFTSEJPQVJEOjEifSx7ImNvZGUiOiJJTU1VTklaQVRJT05fUkVQT1JUX0VYQ0VMOjEifSx7ImNvZGUiOiJJTU1VTklaQVRJT05fTEFCOjEifSx7ImNvZGUiOiJJTU1VTklaQVRJT05fRVBJREVNOjEifSx7ImNvZGUiOiJFUElERU1fVVBEQVRFREFUQToxIn0seyJjb2RlIjoiRVBJREVNX1JFUE9SVDoxIn1dLCJyb2xlIjpbIm1vcGgtYXBpIl0sInNjb3BlX2xpc3QiOiJbTU9QSF9QSFJfSElFOjFdW01PUEhfRk9SRUlHTl9JRFA6MV1bTU9QSF9GT1JFSUdOX0lEUDoxXVtNT1BIX1BIUl9EQVNIQk9BUkQ6MV1bTU9QSF9QSFJfREFTSEJPQVJEX1JFUE9SVDoxXVtNT1BIX0lEUF9BUEk6MV1bTU9QSF9DTEFJTToxXVtNT1BIX0NMQUlNX0FQSToxXVtJTU1VTklaQVRJT05fVklFVzoyXVtJTU1VTklaQVRJT05fVVBEQVRFOjJdW01PUEhfQUNDT1VOVF9DRU5URVJfQURNSU46Ml1bSU1NVU5JWkFUSU9OX1BFUlNPTl9VUExPQUQ6Ml1bSU1NVU5JWkFUSU9OX0RBU0hCT0FSRDoyXVtJTU1VTklaQVRJT05fU0xPVDoyXVtJTU1VTklaQVRJT05fUVVPVEE6Ml1bSU1NVU5JWkFUSU9OX1JFUE9SVDoyXVtJTU1VTklaQVRJT05fUkVQT1JUX0VYQ0VMOjJdW0lNTVVOSVpBVElPTl9DT01QQU5ZOjJdW0lNTVVOSVpBVElPTl9MQUI6Ml1bSU1NVU5JWkFUSU9OX1NMT1RfTUFOQUdFUjoyXVtFUElERU1fUkVQT1JUOjJdW01PUEhfRk9SRUlHTl9JRFA6Ml1bTU9QSF9JRFBfQURNSU46Ml1bTU9QSF9DTEFJTV9BRE1JTjoyXVtNT1BIX0lEUF9BUEk6M11bSU1NVU5JWkFUSU9OX1VQREFURToxXVtJTU1VTklaQVRJT05fUEVSU09OX1VQTE9BRDoxXVtJTU1VTklaQVRJT05fREFTSEJPQVJEOjFdW0lNTVVOSVpBVElPTl9SRVBPUlRfRVhDRUw6MV1bSU1NVU5JWkFUSU9OX0xBQjoxXVtJTU1VTklaQVRJT05fRVBJREVNOjFdW0VQSURFTV9VUERBVEVEQVRBOjFdW0VQSURFTV9SRVBPUlQ6MV0iLCJhY2Nlc3NfY29kZV9sZXZlbDEiOiInJyIsImFjY2Vzc19jb2RlX2xldmVsMiI6IiczNDE0MDAnIiwiYWNjZXNzX2NvZGVfbGV2ZWwzIjoiJyciLCJhY2Nlc3NfY29kZV9sZXZlbDQiOiInJyIsImFjY2Vzc19jb2RlX2xldmVsNSI6IicnIn19.j4ZVdl59SjKa7IwaHPl0amtNi3OerpaPofFlU7NQIZlv9379ZviGQ5ZO5kjKi4mozTzEheJisOBF_aT5bsZBLF3vCrHHa5TEIW2q0354Tuzn3J-0VA0MhUAYtmSB-N8ZKdAFBBlYv1jXGyIzKqDVTmixxERr2ZN-jGUurgU7Rnf-2TqKmexm_ia2yrB08KwGgAEuXviyo65vxwvVttz83QCy8Irgxy-JE4i8EJhYCXoYYGVW5VTznpfI4s9S-SyxHJF9Kc9kgMfl5v2qRBGRbtPX43XVCxGWxi6HijkT4lnIxZpabGzWyuSHjnzRu0q3e1THkUHsVfEOv2PslpdXH6Xz0o5RfpZBZqSSYZtNg1FFTW2WCzD9wOeteu0-yTLUI3Vr9cqW6rtsNgKjHp9542tiVE4XnX_5rEn-o7cmy__cKa8AAydSIh-D2581QoejqQHLUahnVJEQvQwGxBf77iRj8KGP-BVTkGTKmsa_7zL4k6nmwf0eQTdM-NxtnpNKEVxMMhLkL8GDqTYA0Ja2w9Z7lnSEzZ0OZn-RvYWr52Gc_rNGSr1EJtMm2R0gFMMgCMtbNF-ixY3QKNByO9bSb7oLF8bfJHhJyC724Wo-vVjvIibE-Df-1JfbOlvFIWUmRSX4aXd5npXtUeC0M6dT6n9HQLtP6Rb2eu_-s_Z8Q4Y";
        $token = $token30;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        //CURLOPT_URL => '192.168.200.63:30012/phr/export',
       # CURLOPT_URL => '192.168.200.80:30019/claimdmht/exportEpi',
        CURLOPT_URL => '192.168.200.92:30019/claimdmht/exportEpi',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        //SSL USE
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "hn":"'.$hn.'",
            "vn":"'.$visit_id.'",
            "token":  "'.$token.'"
            }',
            CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ0ZXh0IjoiSElTIEhJREVWVUJPTiIsImlhdCI6MTY2NjMyMjY5Mn0.p8s2dVY9NTAAFl6ewO5deOcLr1yFldQQtWfGWIbaLKQ',
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);
        $dmht = json_decode($response, true);
        $err = curl_error($curl);
        //curl_close($curl);
      //  echo $response;
        curl_close($curl);
        $pid = $dmht['results']['pid'];
        $message = $dmht['results_claim']['message'];
        $message_th = $dmht['results_claim']['message_th'];
        $status = $dmht['statusCode'];
        //echo $response;
############################INSERT TABLE Log_dmht#############################

         if (strlen($response) > 0 ) {
               $strSQL = "REPLACE INTO log_dt (visit_id, pid,status, messagecode ,response , users,d_update) VALUES ('$visit_id','$hn',$status,'$message','$message_th' ,'hpv',NOW())";
             //  $strSQL = "REPLACE INTO log_dt (visit_id, pid, cid,status, messagecode ,response , users,d_update) VALUES ('$visit_id','$hn','$pid',$status,'$message','$message_th' ,'dt',NOW())";
               Yii::$app->db2->createCommand($strSQL)->execute();
           // Yii::$app->db2->createCommand()->insert('log_dmht', $strSQL)->execute();
            }
          }
          return $this->redirect(['hpv']);
        }
      
                
    ################# ดึงข้อมูลให้ฟอร์ม HPV ########################
    public function actionHpv() {
        $sql =" SELECT distinct @n :=@n +1 'No',
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
        ,vc.lot_no
        ,d.drug_id 
        ,d.drug_name
        ,cv.dose_time
        ,CASE
	    WHEN ak.claimcode = '' THEN 'ว่าง'
	    WHEN ak.claimcode <> '' THEN ak.claimcode
        END AS claimcode
         FROM (select @n := 0) m, opd_visits o 
         INNER JOIN cid_hn c ON o.HN=c.HN AND o.IS_CANCEL=0
         INNER JOIN population p ON p.CID=c.CID
         LEFT JOIN opd_diagnosis dx on dx.visit_id= o.visit_id AND dx.is_cancel=0
         LEFT  JOIN icd10new i on i.icd10=dx.icd10
         INNER  JOIN prescriptions pr ON pr.visit_id  = o.visit_id and pr.IS_CANCEL = 0
         LEFT JOIN drugs d ON d.drug_id = pr.drug_id  
         LEFT JOIN occupation_new oc ON oc.oc_id = p.oc_id
         LEFT JOIN nations n ON n.natn_id = p.natn_id
         LEFT JOIN ipd_reg ipd ON ipd.visit_id = o.visit_id AND ipd.is_cancel = 0
         LEFT JOIN authen_kiosk ak ON p.CID = ak.cid  AND date(o.REG_DATETIME)=date(ak.d_update)
         INNER JOIN cid_vaccinate_v2 cv ON cv.visit_id = o.visit_id
         INNER JOIN vaccinecovid vc ON vc.vaccine_id = cv.vaccine_id 
        LEFT JOIN vaccinate_plan vp ON vp.vac_plan_id = cv.vac_plan_id
         where 
		# o.reg_datetime BETWEEN '2022-10-01 00:00' AND NOW()
         o.reg_datetime BETWEEN SUBDATE(CURDATE() ,INTERVAL 5 DAY) AND NOW()
         AND ipd.adm_id is null
         #AND TIMESTAMPDIFF(year,p.birthdate,o.reg_datetime) >= 25
		 AND o.visit_id  not in (SELECT vs.visit_id from log_dt vs )
         AND d.drug_id in ('2386','2475')
         AND o.visit_id <> '0003038570'
        GROUP BY o.visit_id  ORDER BY NO DESC limit 30
        ";
            $rawData = \yii::$app->db2->createCommand($sql)->queryAll();
            try {
                $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
            } catch (\yii\db\Exception $e) {
                throw new \yii\web\ConflictHttpException('sql error');
            }
            $hpvProvider = new \yii\data\ArrayDataProvider([
                'allModels' => $rawData,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
         $sqlCount1 = "SELECT COUNT(DISTINCT v.visit_id) as amount
            FROM log_dt v 
            WHERE v.messagecode = 'success'
            AND v.d_update BETWEEN CURDATE() AND NOW()
            AND v.users = 'hpv'
            ";
        
         $data = \yii::$app->db2->createCommand($sqlCount1)->queryAll();
             for ($i = 0; $i < sizeof($data); $i++) {
                 $amount = $data[$i]['amount'];    
             }
             $sqlCamount = "SELECT COUNT(DISTINCT v.visit_id) as amountx
             FROM log_dt v 
             WHERE v.messagecode <> 'success'
             AND v.d_update BETWEEN CURDATE() AND NOW()
             AND v.users = 'hpv'
             ";
             $data = \yii::$app->db2->createCommand($sqlCamount)->queryAll();
             for ($i = 0; $i < sizeof($data); $i++) {
                 $amountx = $data[$i]['amountx'];    
             }
             $total = "SELECT COUNT(DISTINCT v.visit_id) as total
            FROM log_dt v 
            WHERE v.messagecode = 'success'
            AND v.users = 'hpv'
             ";
        
         $data = \yii::$app->db2->createCommand($total)->queryAll();
             for ($i = 0; $i < sizeof($data); $i++) {
                 $total = $data[$i]['total'];    
             }
      
            return $this->render('hpv', [
                // 'searchModel' => $searchModel,
                'hpvProvider' => $hpvProvider,
                 'amount'=>$amount,  
                'amountx'=>$amountx, 
                'total'=>$total,      
    
            ]);
          }
          public function actionLoghpv()  {
            $sql = "SELECT l.id, c.cid,l.visit_id, l.pid, l.`status`, l.messagecode, l.response, l.users, l.d_update
            FROM log_dt l 
            INNER JOIN cid_hn c ON c.hn = l.pid
            WHERE l.d_update >= CURDATE()
            AND l.users = 'hpv' 
            ORDER BY l.d_update DESC
            ";
            $rawData = \yii::$app->db2->createCommand($sql)->queryAll();
            try {
                $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
            } catch (\yii\db\Exception $e) {
                throw new \yii\web\ConflictHttpException('sql error');
            }
            
            $loghpvProvider = new \yii\data\ArrayDataProvider([
                'allModels' => $rawData,
                'pagination' => [
                    'pageSize' => 30,
                ],
            ]);
            
    
            return $this->render('log_hpv', [
                // 'searchModel' => $searchModel,
                'loghpvProvider' => $loghpvProvider,
    
            ]);
                }
                public function actionLogerr()  {
                    $sql = "SELECT l.id, c.cid,l.visit_id, l.pid, l.`status`, l.messagecode, l.response, l.users, l.d_update
                    FROM log_dt l 
                    INNER JOIN cid_hn c ON c.hn = l.pid
                    WHERE l.d_update >= CURDATE()-5
                    AND l.users = 'hpv' AND l.messagecode <> 'success'
                    ORDER BY l.d_update DESC
                    ";
                    $rawData = \yii::$app->db2->createCommand($sql)->queryAll();
                    try {
                        $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
                    } catch (\yii\db\Exception $e) {
                        throw new \yii\web\ConflictHttpException('sql error');
                    }
                    
                    $logerrProvider = new \yii\data\ArrayDataProvider([
                        'allModels' => $rawData,
                        'pagination' => [
                            'pageSize' => 20,
                        ],
                    ]);
                    
            
                    return $this->render('log_error', [
                        // 'searchModel' => $searchModel,
                        'logerrProvider' => $logerrProvider,
            
                    ]);
                        }
        }
    
    

