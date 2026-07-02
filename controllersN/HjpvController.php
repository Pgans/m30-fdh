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

class HjpvController extends \yii\web\Controller
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
        $hn = substr($r, 6);
        //echo $hn.'<br />';
        $visit_id = substr($r, 0, 6);
     
        ############# Send Moph-claim #############
        #$token = "eyJhbGciOiJSUzUxMiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJva3AxMDk1M0AxMDk1MyIsImlhdCI6MTY3MTcwNzc4MSwiZXhwIjoxNjcxNzI1NzgxLCJpc3MiOiJNT1BIIEFjY291bnQgQ2VudGVyIiwiYXVkIjoiTU9QSCBBUEkiLCJjbGllbnQiOnsidXNlcl9pZCI6MTU2OSwidXNlcl9oYXNoIjoiMjlGMEQzRTY0ODlFM0ZCMkFGNDlBQzZCMkUxOUUyMTE3RTQ1OEVGNEVFRUQyMEJFNDRDMTNEMTgzREUxRTAwRDhFQ0RGMEFCIiwibG9naW4iOiJva3AxMDk1MyIsIm5hbWUiOiLguJnguLLguKLguIrguLLguJXguKPguLUg4Lia4Li44LiN4LiX4LiyIiwiaG9zcGl0YWxfbmFtZSI6IuC5guC4o-C4h-C4nuC4ouC4suC4muC4suC4peC4oeC5iOC4p-C4h-C4quC4suC4oeC4quC4tOC4miIsImhvc3BpdGFsX2NvZGUiOiIxMDk1MyIsImVtYWlsIjoibWhvc3AuZ2FuQGdtYWlsLmNvbSIsImFjY291bnRfYWN0aXZhdGVkIjp0cnVlLCJhY2NvdW50X3N1c3BlbmRlZCI6ZmFsc2UsImNpZF9oYXNoIjoiOUFDREQwRDg0Mzc1RTdERjcwMDhCNjM4QUZBNjc2QTI6MzEiLCJjaWRfZW5jcnlwdCI6IjQ4NjQ4QjU2MkQ2NTY2QUJFOUZBNTIyOUVENjUwNEUxMjY3NDk3REE4OUE1N0FDNjJGODdFMzQyM0YyNTZEQTU2QzZFQUI5QTk5RkMwM0UyMjQ2NjM5QTRGMyIsImNpZF9hZXMiOiJiTTZkUlpaMy9ETWZGVjB5UVNXd3lnPT0iLCJjbGllbnRfaXAiOiIxODMuODguMjE0LjEzMCIsInNjb3BlIjpbeyJjb2RlIjoiTU9QSF9QSFJfSElFOjEifSx7ImNvZGUiOiJNT1BIX0ZPUkVJR05fSURQOjEifSx7ImNvZGUiOiJNT1BIX0ZPUkVJR05fSURQOjEifSx7ImNvZGUiOiJNT1BIX1BIUl9EQVNIQk9BUkQ6MSJ9LHsiY29kZSI6Ik1PUEhfUEhSX0RBU0hCT0FSRF9SRVBPUlQ6MSJ9LHsiY29kZSI6Ik1PUEhfSURQX0FQSToxIn0seyJjb2RlIjoiTU9QSF9DTEFJTToxIn0seyJjb2RlIjoiTU9QSF9DTEFJTV9BUEk6MSJ9LHsiY29kZSI6IklNTVVOSVpBVElPTl9WSUVXOjIifSx7ImNvZGUiOiJJTU1VTklaQVRJT05fVVBEQVRFOjIifSx7ImNvZGUiOiJNT1BIX0FDQ09VTlRfQ0VOVEVSX0FETUlOOjIifSx7ImNvZGUiOiJJTU1VTklaQVRJT05fUEVSU09OX1VQTE9BRDoyIn0seyJjb2RlIjoiSU1NVU5JWkFUSU9OX0RBU0hCT0FSRDoyIn0seyJjb2RlIjoiSU1NVU5JWkFUSU9OX1NMT1Q6MiJ9LHsiY29kZSI6IklNTVVOSVpBVElPTl9RVU9UQToyIn0seyJjb2RlIjoiSU1NVU5JWkFUSU9OX1JFUE9SVDoyIn0seyJjb2RlIjoiSU1NVU5JWkFUSU9OX1JFUE9SVF9FWENFTDoyIn0seyJjb2RlIjoiSU1NVU5JWkFUSU9OX0NPTVBBTlk6MiJ9LHsiY29kZSI6IklNTVVOSVpBVElPTl9MQUI6MiJ9LHsiY29kZSI6IklNTVVOSVpBVElPTl9TTE9UX01BTkFHRVI6MiJ9LHsiY29kZSI6IkVQSURFTV9SRVBPUlQ6MiJ9LHsiY29kZSI6Ik1PUEhfRk9SRUlHTl9JRFA6MiJ9LHsiY29kZSI6Ik1PUEhfSURQX0FETUlOOjIifSx7ImNvZGUiOiJNT1BIX0NMQUlNX0FETUlOOjIifSx7ImNvZGUiOiJNT1BIX0lEUF9BUEk6MyJ9LHsiY29kZSI6IklNTVVOSVpBVElPTl9VUERBVEU6MSJ9LHsiY29kZSI6IklNTVVOSVpBVElPTl9QRVJTT05fVVBMT0FEOjEifSx7ImNvZGUiOiJJTU1VTklaQVRJT05fREFTSEJPQVJEOjEifSx7ImNvZGUiOiJJTU1VTklaQVRJT05fUkVQT1JUX0VYQ0VMOjEifSx7ImNvZGUiOiJJTU1VTklaQVRJT05fTEFCOjEifSx7ImNvZGUiOiJJTU1VTklaQVRJT05fRVBJREVNOjEifSx7ImNvZGUiOiJFUElERU1fVVBEQVRFREFUQToxIn0seyJjb2RlIjoiRVBJREVNX1JFUE9SVDoxIn1dLCJyb2xlIjpbIm1vcGgtYXBpIl0sInNjb3BlX2xpc3QiOiJbTU9QSF9QSFJfSElFOjFdW01PUEhfRk9SRUlHTl9JRFA6MV1bTU9QSF9GT1JFSUdOX0lEUDoxXVtNT1BIX1BIUl9EQVNIQk9BUkQ6MV1bTU9QSF9QSFJfREFTSEJPQVJEX1JFUE9SVDoxXVtNT1BIX0lEUF9BUEk6MV1bTU9QSF9DTEFJTToxXVtNT1BIX0NMQUlNX0FQSToxXVtJTU1VTklaQVRJT05fVklFVzoyXVtJTU1VTklaQVRJT05fVVBEQVRFOjJdW01PUEhfQUNDT1VOVF9DRU5URVJfQURNSU46Ml1bSU1NVU5JWkFUSU9OX1BFUlNPTl9VUExPQUQ6Ml1bSU1NVU5JWkFUSU9OX0RBU0hCT0FSRDoyXVtJTU1VTklaQVRJT05fU0xPVDoyXVtJTU1VTklaQVRJT05fUVVPVEE6Ml1bSU1NVU5JWkFUSU9OX1JFUE9SVDoyXVtJTU1VTklaQVRJT05fUkVQT1JUX0VYQ0VMOjJdW0lNTVVOSVpBVElPTl9DT01QQU5ZOjJdW0lNTVVOSVpBVElPTl9MQUI6Ml1bSU1NVU5JWkFUSU9OX1NMT1RfTUFOQUdFUjoyXVtFUElERU1fUkVQT1JUOjJdW01PUEhfRk9SRUlHTl9JRFA6Ml1bTU9QSF9JRFBfQURNSU46Ml1bTU9QSF9DTEFJTV9BRE1JTjoyXVtNT1BIX0lEUF9BUEk6M11bSU1NVU5JWkFUSU9OX1VQREFURToxXVtJTU1VTklaQVRJT05fUEVSU09OX1VQTE9BRDoxXVtJTU1VTklaQVRJT05fREFTSEJPQVJEOjFdW0lNTVVOSVpBVElPTl9SRVBPUlRfRVhDRUw6MV1bSU1NVU5JWkFUSU9OX0xBQjoxXVtJTU1VTklaQVRJT05fRVBJREVNOjFdW0VQSURFTV9VUERBVEVEQVRBOjFdW0VQSURFTV9SRVBPUlQ6MV0iLCJhY2Nlc3NfY29kZV9sZXZlbDEiOiInJyIsImFjY2Vzc19jb2RlX2xldmVsMiI6IiczNDE0MDAnIiwiYWNjZXNzX2NvZGVfbGV2ZWwzIjoiJyciLCJhY2Nlc3NfY29kZV9sZXZlbDQiOiInJyIsImFjY2Vzc19jb2RlX2xldmVsNSI6IicnIn19.j4ZVdl59SjKa7IwaHPl0amtNi3OerpaPofFlU7NQIZlv9379ZviGQ5ZO5kjKi4mozTzEheJisOBF_aT5bsZBLF3vCrHHa5TEIW2q0354Tuzn3J-0VA0MhUAYtmSB-N8ZKdAFBBlYv1jXGyIzKqDVTmixxERr2ZN-jGUurgU7Rnf-2TqKmexm_ia2yrB08KwGgAEuXviyo65vxwvVttz83QCy8Irgxy-JE4i8EJhYCXoYYGVW5VTznpfI4s9S-SyxHJF9Kc9kgMfl5v2qRBGRbtPX43XVCxGWxi6HijkT4lnIxZpabGzWyuSHjnzRu0q3e1THkUHsVfEOv2PslpdXH6Xz0o5RfpZBZqSSYZtNg1FFTW2WCzD9wOeteu0-yTLUI3Vr9cqW6rtsNgKjHp9542tiVE4XnX_5rEn-o7cmy__cKa8AAydSIh-D2581QoejqQHLUahnVJEQvQwGxBf77iRj8KGP-BVTkGTKmsa_7zL4k6nmwf0eQTdM-NxtnpNKEVxMMhLkL8GDqTYA0Ja2w9Z7lnSEzZ0OZn-RvYWr52Gc_rNGSr1EJtMm2R0gFMMgCMtbNF-ixY3QKNByO9bSb7oLF8bfJHhJyC724Wo-vVjvIibE-Df-1JfbOlvFIWUmRSX4aXd5npXtUeC0M6dT6n9HQLtP6Rb2eu_-s_Z8Q4Y";
        $token = $token30;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        //CURLOPT_URL => '192.168.200.63:30012/phr/export',
        CURLOPT_URL => '192.168.200.92:30014/claimdmht/exportEpi',
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
       // echo $response;
############################INSERT TABLE Log_dmht#############################

         if (strlen($response) > 0 ) {
               $strSQL = "REPLACE INTO log_dt (visit_id, pid,status, messagecode ,response , users,d_update) VALUES ('$visit_id','$hn',$status,'$message','$message_th' ,'hjpv',NOW())";
             //  $strSQL = "REPLACE INTO log_dt (visit_id, pid, cid,status, messagecode ,response , users,d_update) VALUES ('$visit_id','$hn','$pid',$status,'$message','$message_th' ,'dt',NOW())";
               Yii::$app->db142->createCommand($strSQL)->execute();
           // Yii::$app->db2->createCommand()->insert('log_dmht', $strSQL)->execute();
            }
          }
          return $this->redirect(['hjpv']);
        }
      
                
    ################# ดึงข้อมูลให้ฟอร์ม HPV ########################
    public function actionHjpv() {
        $sql ="  SELECT DISTINCT @n :=@n +1 'No',
            TRIM( visitepi.pcucodeperson ) AS HOSPCODE, 
          person.idcard,
          m.hn,
            visitepi.pid AS PID, 
            visitepi.visitno AS visit_id, 
            IF( visitepi.dateepi IS NULL OR TRIM( visitepi.dateepi ) = '' OR visitepi.dateepi LIKE '0000-00-00%', '', DATE_FORMAT( visitepi.dateepi, '%Y%m%d' ) ) AS DATE_SERV,
            cdrug.files18epi AS VCCTYPE,
            CONCAT(person.fname,' ',person.lname) as fullname ,
            timestampdiff(year,person.birth,visitepi.dateupdate) as age,
          cdrug.drugcode,
          visitepi.lotno,
          visitepi.datevacineexpire,
          visitepi.dateepi,
          visitepi.dateupdate,
          a.claimcode,
            IF( visitepi.hosservice IS NULL OR visitepi.hosservice = '', IFNULL( visitepi.pcucode, '00000' ), TRIM( visitepi.hosservice ) ) AS VCCPLACE, 
          IF( u.idcard IS NULL OR TRIM( u.idcard ) = '', '', u.idcard ) AS PROVIDER, 
            IF( visitepi.dateupdate IS NULL OR TRIM( visitepi.dateupdate ) = '' OR  visitepi.dateupdate LIKE '0000-00-00%', DATE_FORMAT( visitepi.dateepi, '%Y%m%d%H%i%s' ), DATE_FORMAT( visitepi.dateupdate, '%Y%m%d%H%i%s' ) ) AS D_UPDATE
        FROM 
        (select @n := 0) m, visitepi 
            LEFT JOIN person ON visitepi.pcucodeperson = person.pcucodeperson and visitepi.pid = person.pid 
            INNER  JOIN cdrug ON ( visitepi.vaccinecode=cdrug.drugcode AND cdrug.drugtype='05' AND left(drugcode,3 )= 'HPV' ) 
          LEFT  JOIN mathhn m ON m.cid = person.idcard
          LEFT JOIN mbase_data1.authen_kiosk as a on a.cid = person.idcard AND date(a.d_update) = visitepi.dateepi
          LEFT JOIN visit AS v ON visitepi.pcucode=v.pcucode   and visitepi.visitno=v.visitno 
          LEFT JOIN `userx` AS u ON v.pcucode = u.pcucode  AND v.username = u.username 
        WHERE 
            visitepi.dateepi IS NOT NULL 
            AND TRIM( visitepi.dateepi ) <> '' 
            AND TRIM( visitepi.pcucodeperson ) <> '' 
            AND ( ( visitepi.dateepi >= ( DATE_SUB( CURDATE(), INTERVAL 10 YEAR ) ) ) OR ( DATE( visitepi.dateupdate ) >= ( DATE_SUB( CURDATE(), INTERVAL 10 YEAR ) ) ) )
            AND DATE_FORMAT( visitepi.dateepi, '%Y-%m-%d' ) BETWEEN '2023-10-01'  AND '2023-12-31'
            AND visitepi.visitno  not in (SELECT vs.visit_id from log_dt vs )
        ORDER BY NO DESC limit 10
        ";
            $rawData = \yii::$app->db142->createCommand($sql)->queryAll();
            try {
                $rawData = \Yii::$app->db142->createCommand($sql)->queryAll();
            } catch (\yii\db\Exception $e) {
                throw new \yii\web\ConflictHttpException('sql error');
            }
            $hjpvProvider = new \yii\data\ArrayDataProvider([
                'allModels' => $rawData,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
         $sqlCount1 = "SELECT COUNT(DISTINCT v.visit_id) as amount
            FROM log_dt v 
            WHERE v.messagecode = 'success'
            AND v.d_update BETWEEN CURDATE() AND NOW()
            AND v.users = 'hjpv'
            ";
        
         $data = \yii::$app->db142->createCommand($sqlCount1)->queryAll();
             for ($i = 0; $i < sizeof($data); $i++) {
                 $amount = $data[$i]['amount'];    
             }
             $sqlCamount = "SELECT COUNT(DISTINCT v.visit_id) as amountx
             FROM log_dt v 
             WHERE v.messagecode <> 'success'
             AND v.d_update BETWEEN CURDATE() AND NOW()
             AND v.users = 'hjpv'
             ";
             $data = \yii::$app->db142->createCommand($sqlCamount)->queryAll();
             for ($i = 0; $i < sizeof($data); $i++) {
                 $amountx = $data[$i]['amountx'];    
             }
             $total = "SELECT COUNT(DISTINCT v.visit_id) as total
            FROM log_dt v 
            WHERE v.messagecode = 'success'
            AND v.users = 'hjpv'
             ";
        
         $data = \yii::$app->db142->createCommand($total)->queryAll();
             for ($i = 0; $i < sizeof($data); $i++) {
                 $total = $data[$i]['total'];    
             }
      
            return $this->render('hpv', [
                // 'searchModel' => $searchModel,
                'hjpvProvider' => $hjpvProvider,
                 'amount'=>$amount,  
                'amountx'=>$amountx, 
                'total'=>$total,      
    
            ]);
          }
          public function actionLoghpv()  {
            $sql = "SELECT l.id, c.cid,l.visit_id, l.pid, l.`status`, l.messagecode, l.response, l.users, l.d_update
            FROM log_dt l 
            INNER JOIN mathhn c ON c.hn = l.pid
            WHERE l.d_update >= CURDATE()-5
            AND l.users = 'hjpv' 
            ORDER BY l.d_update DESC
            ";
            $rawData = \yii::$app->db142->createCommand($sql)->queryAll();
            try {
                $rawData = \Yii::$app->db142->createCommand($sql)->queryAll();
            } catch (\yii\db\Exception $e) {
                throw new \yii\web\ConflictHttpException('sql error');
            }
            
            $loghpvProvider = new \yii\data\ArrayDataProvider([
                'allModels' => $rawData,
                'pagination' => [
                    'pageSize' => 200,
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
                    INNER JOIN mathhn c ON c.hn = l.pid
                    WHERE l.d_update >= CURDATE()-5
                    AND l.users = 'hjpv' AND l.messagecode <> 'success'
                    ORDER BY l.d_update DESC
                    ";
                    $rawData = \yii::$app->db142->createCommand($sql)->queryAll();
                    try {
                        $rawData = \Yii::$app->db142->createCommand($sql)->queryAll();
                    } catch (\yii\db\Exception $e) {
                        throw new \yii\web\ConflictHttpException('sql error');
                    }
                    
                    $logerrProvider = new \yii\data\ArrayDataProvider([
                        'allModels' => $rawData,
                        'pagination' => [
                            'pageSize' => 200,
                        ],
                    ]);
                    
            
                    return $this->render('log_error', [
                        // 'searchModel' => $searchModel,
                        'logerrProvider' => $logerrProvider,
            
                    ]);
                        }
        }
    
    

