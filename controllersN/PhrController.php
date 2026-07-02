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
use app\models\Phr;

// /* เพิ่มคำสั่ง 3 บรรทัดต่อจากนี้ลงไป */
// use yii\filters\AccessControl;        // เรียกใช้ คลาส AccessControl
// use app\models\User;             // เรียกใช้ Model คลาส User ที่ปรับปรังปรุงไว้
// use app\components\AccessRule;   // เรียกใช้ คลาส Component AccessRule ที่เราสร้างใหม่



class PhrController extends \yii\web\Controller
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
            $hn = substr($r, 10, 6);
            //echo $hn.'<br />';
            $visit = substr($r, 0, 10);
            //echo $visit.'<br />';
             $cid = substr($r, 16, 13);
           // echo $cid . '<br />';
             $regdate = substr($r, -19);
            //echo $regdate . '<br />';
            //echo $r.'<br />';
                 //echo $cid . '<br />';
                // echo $r.'<br />';
            //return $visit_id.'<br />';
            // echo $r.'<br />';

            ############# Send Moph-claim #############
            #$token = "eyJhbGciOiJSUzUxMiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJva3AxMDk1M0AxMDk1MyIsImlhdCI6MTY3MTcwNzc4MSwiZXhwIjoxNjcxNzI1NzgxLCJpc3MiOiJNT1BIIEFjY291bnQgQ2VudGVyIiwiYXVkIjoiTU9QSCBBUEkiLCJjbGllbnQiOnsidXNlcl9pZCI6MTU2OSwidXNlcl9oYXNoIjoiMjlGMEQzRTY0ODlFM0ZCMkFGNDlBQzZCMkUxOUUyMTE3RTQ1OEVGNEVFRUQyMEJFNDRDMTNEMTgzREUxRTAwRDhFQ0RGMEFCIiwibG9naW4iOiJva3AxMDk1MyIsIm5hbWUiOiLguJnguLLguKLguIrguLLguJXguKPguLUg4Lia4Li44LiN4LiX4LiyIiwiaG9zcGl0YWxfbmFtZSI6IuC5guC4o-C4h-C4nuC4ouC4suC4muC4suC4peC4oeC5iOC4p-C4h-C4quC4suC4oeC4quC4tOC4miIsImhvc3BpdGFsX2NvZGUiOiIxMDk1MyIsImVtYWlsIjoibWhvc3AuZ2FuQGdtYWlsLmNvbSIsImFjY291bnRfYWN0aXZhdGVkIjp0cnVlLCJhY2NvdW50X3N1c3BlbmRlZCI6ZmFsc2UsImNpZF9oYXNoIjoiOUFDREQwRDg0Mzc1RTdERjcwMDhCNjM4QUZBNjc2QTI6MzEiLCJjaWRfZW5jcnlwdCI6IjQ4NjQ4QjU2MkQ2NTY2QUJFOUZBNTIyOUVENjUwNEUxMjY3NDk3REE4OUE1N0FDNjJGODdFMzQyM0YyNTZEQTU2QzZFQUI5QTk5RkMwM0UyMjQ2NjM5QTRGMyIsImNpZF9hZXMiOiJiTTZkUlpaMy9ETWZGVjB5UVNXd3lnPT0iLCJjbGllbnRfaXAiOiIxODMuODguMjE0LjEzMCIsInNjb3BlIjpbeyJjb2RlIjoiTU9QSF9QSFJfSElFOjEifSx7ImNvZGUiOiJNT1BIX0ZPUkVJR05fSURQOjEifSx7ImNvZGUiOiJNT1BIX0ZPUkVJR05fSURQOjEifSx7ImNvZGUiOiJNT1BIX1BIUl9EQVNIQk9BUkQ6MSJ9LHsiY29kZSI6Ik1PUEhfUEhSX0RBU0hCT0FSRF9SRVBPUlQ6MSJ9LHsiY29kZSI6Ik1PUEhfSURQX0FQSToxIn0seyJjb2RlIjoiTU9QSF9DTEFJTToxIn0seyJjb2RlIjoiTU9QSF9DTEFJTV9BUEk6MSJ9LHsiY29kZSI6IklNTVVOSVpBVElPTl9WSUVXOjIifSx7ImNvZGUiOiJJTU1VTklaQVRJT05fVVBEQVRFOjIifSx7ImNvZGUiOiJNT1BIX0FDQ09VTlRfQ0VOVEVSX0FETUlOOjIifSx7ImNvZGUiOiJJTU1VTklaQVRJT05fUEVSU09OX1VQTE9BRDoyIn0seyJjb2RlIjoiSU1NVU5JWkFUSU9OX0RBU0hCT0FSRDoyIn0seyJjb2RlIjoiSU1NVU5JWkFUSU9OX1NMT1Q6MiJ9LHsiY29kZSI6IklNTVVOSVpBVElPTl9RVU9UQToyIn0seyJjb2RlIjoiSU1NVU5JWkFUSU9OX1JFUE9SVDoyIn0seyJjb2RlIjoiSU1NVU5JWkFUSU9OX1JFUE9SVF9FWENFTDoyIn0seyJjb2RlIjoiSU1NVU5JWkFUSU9OX0NPTVBBTlk6MiJ9LHsiY29kZSI6IklNTVVOSVpBVElPTl9MQUI6MiJ9LHsiY29kZSI6IklNTVVOSVpBVElPTl9TTE9UX01BTkFHRVI6MiJ9LHsiY29kZSI6IkVQSURFTV9SRVBPUlQ6MiJ9LHsiY29kZSI6Ik1PUEhfRk9SRUlHTl9JRFA6MiJ9LHsiY29kZSI6Ik1PUEhfSURQX0FETUlOOjIifSx7ImNvZGUiOiJNT1BIX0NMQUlNX0FETUlOOjIifSx7ImNvZGUiOiJNT1BIX0lEUF9BUEk6MyJ9LHsiY29kZSI6IklNTVVOSVpBVElPTl9VUERBVEU6MSJ9LHsiY29kZSI6IklNTVVOSVpBVElPTl9QRVJTT05fVVBMT0FEOjEifSx7ImNvZGUiOiJJTU1VTklaQVRJT05fREFTSEJPQVJEOjEifSx7ImNvZGUiOiJJTU1VTklaQVRJT05fUkVQT1JUX0VYQ0VMOjEifSx7ImNvZGUiOiJJTU1VTklaQVRJT05fTEFCOjEifSx7ImNvZGUiOiJJTU1VTklaQVRJT05fRVBJREVNOjEifSx7ImNvZGUiOiJFUElERU1fVVBEQVRFREFUQToxIn0seyJjb2RlIjoiRVBJREVNX1JFUE9SVDoxIn1dLCJyb2xlIjpbIm1vcGgtYXBpIl0sInNjb3BlX2xpc3QiOiJbTU9QSF9QSFJfSElFOjFdW01PUEhfRk9SRUlHTl9JRFA6MV1bTU9QSF9GT1JFSUdOX0lEUDoxXVtNT1BIX1BIUl9EQVNIQk9BUkQ6MV1bTU9QSF9QSFJfREFTSEJPQVJEX1JFUE9SVDoxXVtNT1BIX0lEUF9BUEk6MV1bTU9QSF9DTEFJTToxXVtNT1BIX0NMQUlNX0FQSToxXVtJTU1VTklaQVRJT05fVklFVzoyXVtJTU1VTklaQVRJT05fVVBEQVRFOjJdW01PUEhfQUNDT1VOVF9DRU5URVJfQURNSU46Ml1bSU1NVU5JWkFUSU9OX1BFUlNPTl9VUExPQUQ6Ml1bSU1NVU5JWkFUSU9OX0RBU0hCT0FSRDoyXVtJTU1VTklaQVRJT05fU0xPVDoyXVtJTU1VTklaQVRJT05fUVVPVEE6Ml1bSU1NVU5JWkFUSU9OX1JFUE9SVDoyXVtJTU1VTklaQVRJT05fUkVQT1JUX0VYQ0VMOjJdW0lNTVVOSVpBVElPTl9DT01QQU5ZOjJdW0lNTVVOSVpBVElPTl9MQUI6Ml1bSU1NVU5JWkFUSU9OX1NMT1RfTUFOQUdFUjoyXVtFUElERU1fUkVQT1JUOjJdW01PUEhfRk9SRUlHTl9JRFA6Ml1bTU9QSF9JRFBfQURNSU46Ml1bTU9QSF9DTEFJTV9BRE1JTjoyXVtNT1BIX0lEUF9BUEk6M11bSU1NVU5JWkFUSU9OX1VQREFURToxXVtJTU1VTklaQVRJT05fUEVSU09OX1VQTE9BRDoxXVtJTU1VTklaQVRJT05fREFTSEJPQVJEOjFdW0lNTVVOSVpBVElPTl9SRVBPUlRfRVhDRUw6MV1bSU1NVU5JWkFUSU9OX0xBQjoxXVtJTU1VTklaQVRJT05fRVBJREVNOjFdW0VQSURFTV9VUERBVEVEQVRBOjFdW0VQSURFTV9SRVBPUlQ6MV0iLCJhY2Nlc3NfY29kZV9sZXZlbDEiOiInJyIsImFjY2Vzc19jb2RlX2xldmVsMiI6IiczNDE0MDAnIiwiYWNjZXNzX2NvZGVfbGV2ZWwzIjoiJyciLCJhY2Nlc3NfY29kZV9sZXZlbDQiOiInJyIsImFjY2Vzc19jb2RlX2xldmVsNSI6IicnIn19.j4ZVdl59SjKa7IwaHPl0amtNi3OerpaPofFlU7NQIZlv9379ZviGQ5ZO5kjKi4mozTzEheJisOBF_aT5bsZBLF3vCrHHa5TEIW2q0354Tuzn3J-0VA0MhUAYtmSB-N8ZKdAFBBlYv1jXGyIzKqDVTmixxERr2ZN-jGUurgU7Rnf-2TqKmexm_ia2yrB08KwGgAEuXviyo65vxwvVttz83QCy8Irgxy-JE4i8EJhYCXoYYGVW5VTznpfI4s9S-SyxHJF9Kc9kgMfl5v2qRBGRbtPX43XVCxGWxi6HijkT4lnIxZpabGzWyuSHjnzRu0q3e1THkUHsVfEOv2PslpdXH6Xz0o5RfpZBZqSSYZtNg1FFTW2WCzD9wOeteu0-yTLUI3Vr9cqW6rtsNgKjHp9542tiVE4XnX_5rEn-o7cmy__cKa8AAydSIh-D2581QoejqQHLUahnVJEQvQwGxBf77iRj8KGP-BVTkGTKmsa_7zL4k6nmwf0eQTdM-NxtnpNKEVxMMhLkL8GDqTYA0Ja2w9Z7lnSEzZ0OZn-RvYWr52Gc_rNGSr1EJtMm2R0gFMMgCMtbNF-ixY3QKNByO9bSb7oLF8bfJHhJyC724Wo-vVjvIibE-Df-1JfbOlvFIWUmRSX4aXd5npXtUeC0M6dT6n9HQLtP6Rb2eu_-s_Z8Q4Y";
            $token = $token30;
            $curl = curl_init();

            curl_setopt_array($curl, array(
                //CURLOPT_URL => '192.168.200.63:30012/phr/export',
                CURLOPT_URL => '192.168.200.80:30016/phr/export',
               #CURLOPT_URL => '192.168.200.92:30016/phr/export',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 200, // Set timeout to 300 seconds
                CURLOPT_FOLLOWLOCATION => true,
                //SSL USE
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
            "hn":"' . $hn . '",
            "vn":"' . $visit . '",
            "token":  "' . $token . '"
            }',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ0ZXh0IjoiSElTIEhJREVWVUJPTiIsImlhdCI6MTY2NjMyMjY5Mn0.p8s2dVY9NTAAFl6ewO5deOcLr1yFldQQtWfGWIbaLKQ',
                    'Content-Type: application/json'
                ),
            ));
            sleep(5);
            $response = curl_exec($curl);
            $phr = json_decode($response, true);
            $err = curl_error($curl);
            curl_close($curl);
           // $cid = isset($phr['results_phr']['CID']) ? $phr['results_phr']['CID'] : null;
           //$messages = isset($phr['results_phr']['CID']) ? $phr['results_phr']['CID'] : null;
            $messages = $phr['results_phr']['Message'];
            $result = $phr['results_phr']['processing_warning'][0];
            $scode = $phr['results_phr']['MessageCode'];
            #echo $response;
            /*
            {"statusCode":200,"results":{"managingOrganization":{"type":"Organization","identifier":{"use":"official",
                "system":"https://bps.moph.go.th/hcode/5","value":"10953"},"display":"โรงพยาบาลรพ.ม่วงสามสิบ"}
                ,"Patient":{"identifier":[{"use":"official","system":"https://www.dopa.go.th",
                    "type":"CID","value":"3341400295787","period":{"start":"1971"}},
                    {"use":"official","system":"https://sil-th.org/hn","assigner":{"use":"official"
                        ,"system":"https://bps.moph.go.th/hcode/5","value":"10953","display":"โรงพยาบาลรพ.ม่วงสามสิบ"},
                        "type":"HN","value":"066088","period":{"start":"2022"}}],"active":true,"name":[{"use":"official",
                            "text":"ด.ต.สัมพันธ์ เข็มคุณ","languageCode":"TH","family":"สัมพันธ์ เข็มคุณ","given":["สัมพันธ์"],"prefix":["ด.ต."],
                            "suffix":["เข็มคุณ"],"period":{"start":"2022-08-05T00:00:00.000Z"}},{"use":"official","text":"undefined.Samphun Kamkhun",
                                "languageCode":"EN","family":"Samphun Kamkhun","given":["Samphun"],"prefix":["-"],"suffix":["Kamkhun"],
                                "period":{"start":"2022-08-05T00:00:00.000Z"}}],"telecom":[{"system":"phone","value":"0862064337","use":"mobile",
                                    "rank":"1","period":{"start":"2022-08-05T00:00:00.000Z"}}],"gender":"male",
                                    "birthDate":"1971-01-27T00:00:00.000Z","deceasedBoolean":false,"nationality":
                                    {"coding":[{"system":"http://www.thcc.or.th/download/nationalitycode.xls",
                                        "code":"99","display":"ไทย"}],"text":"ไทย"},"address":[{"use":"home","type":"both","text":"ที่อยู่",
                                            "line":["2 ","เตย หมู่ 1"],"city":"เตย","district":"ม่วงสามสิบ","state":"อุบลราชธานี","postalCode":"",
                                            "country":"TH","period":{"start":"2022-08-05T00:00:00.000Z"},"address_code":"341406"}],
                                            "maritalStatus":{"coding":[{"system":"http://terminology.hl7.org/CodeSystem/v3-MaritalStatus",
                                                "code":"M","display":"คู่"}],"text":"คู่"},"contact":[{"relationship":[{"coding":[{"system":
                                                    "https://www.this.or.th","code":"1","display":"คู่สมรส"}],"text":"คู่สมรส"}],"name":[{"use":"official","text":"3660700147933","family":"3660700147933","languageCode":"TH","given":[""],"prefix":[""],"suffix":[],"period":{"start":"2022-08-05T00:00:00.000Z"}}],"telecom":[{"system":"phone","value":"0862064337","use":"mobile","rank":"1","period":{"start":"2022-08-05T00:00:00.000Z"}}],"address":[{"use":"home","type":"both","text":"ที่อยู่","line":["2 บ้านเตย หมู่ 1ตำบลเตย อำเภอม่วงสามสิบ จังหวัดอุบลราชธานี"],"city":"เตย","district":"ม่วงสามสิบ","state":"อุบลราชธานี","postalCode":"","country":"TH","period":{"start":"2022-08-05T00:00:00.000Z"},"address_code":"341406"}],"gender":"male"}]},"AllergyIntolerance":[],"Encounter":[{"managingOrganization":{"type":"Organization","identifier":{"use":"official","system":"https://bps.moph.go.th/hcode/5","value":"10953"},"display":"โรงพยาบาลรพ.ม่วงสามสิบ"},"identifier":[{"use":"official","system":"https://bps.moph.go.th/vn","value":"0003019074"},{"use":"official","system":"https://sil-th.org/hn","value":"066088","period":{"start":"2022"}}],"status":"finished","class":{"system":"https://terminology.hl7.org/CodeSystem/v3-ActCode","code":"AMB","display":"ambulatory"},"subclass":{"system":"https://bps.moph.go.th/subclass","code":"40","display":"ศูนย์ตรวจสุขภาพ"},"division":{"system":"https://bps.moph.go.th/division","code":"40","display":"ศูนย์ตรวจสุขภาพ"},"type":{"coding":[{"system":"https://spd.moph.go.th/new_bps/43file_version2.3","code":"1","display":"มารับบริการเอง"}],"text":"มารับบริการเอง"},"priority":{"coding":[{"system":"http://terminology.hl7.org/CodeSystem/v3-ActPriority","code":"R","display":"routine"}],"text":"ไม่เร่งด่วน"},"period":{"start":"2023-12-14T14:33:04.000Z","end":"2023-12-14T14:42:19.000Z"},"subject":{"reference":"Patient/066088","display":"ด.ต.สัมพันธ์ เข็มคุณ "},"screen_allergy":{"system":"https://bps.moph.go.th/screen_allergy","code":"2","display":"ปฏิเสธแพ้ยา"},"screen_smoking":{"system":"https://bps.moph.go.th/screen_smoking","code":"1","display":"ไม่สูบบุหรี่"},"screen_drinking":{"system":"https://bps.moph.go.th/screen_smoking","code":"1","display":"ไม่ดื่มสุรา"},"participant":[{"individual":{"type":{"text":"นายแพทย์"},"reference":"ว.51590 ","display":"วัชรพงษ์ เถาว์โท "}}],"reason":[{"text":" มาขอใบรับรองแพทย์Present Illness "}],"financeTotalAmount":0,"financeReimbursementAmount":0,"financePaidAmount":0,"Coverage":[{"identifier":[{"system":"https://www.nhso.go.th/certificate"},{"system":"https://www.nhso.go.th/authcode","value":""}],"status":"active","type":{"coding":[{"system":"http://terminology.hl7.org/CodeSystem/v3-ActCode","code":"PUBLICPOL","display":"public healthcare"}]},"relationship":{"coding":[{"system":"http://terminology.hl7.org/CodeSystem/subscriber-relationship","code":"self","display":"Self"}]},"period":{"start":null,"end":null},"payor":[{"reference":"สำนักงานหลักประกันสุขภาพแห่งชาติ"}],"class":[{"type":{"coding":[{"system":"http://terminology.hl7.org/CodeSystem/coverage-class","code":"group"}]},"value":"OFC","name":"สิทธิข้าราชการ"},{"type":{"coding":[{"system":"http://terminology.hl7.org/CodeSystem/coverage-class","code":"subgroup"}]},"value":"A2","name":"ข้าราชการกรมบัญชีกลาง (EDC,จ่ายตรง) "}],"reimbursementAmount":"0","contract":[{"reference":"MainHospital","identifier":"","display":""},{"reference":"SubHospital","identifier":"","display":""}]}],"vital_signs":[{"body_weight":{"status":"final","valueQuantity":{"unit":"kg"}},"body_height":{"status":"final","valueQuantity":{"unit":"cm"}},"body_temp":{"status":"final","valueQuantity":{"unit":"cel"}},"bp_systolic":{"status":"final","valueQuantity":{"unit":"mmHg"},"interpretation":{}},"bp_diastolic":{"status":"final","valueQuantity":{"unit":"mmHg"},"interpretation":{}}}],"Observation":[],"Condition":[{"clinicalStatus":{"coding":[{"system":"http://terminology.hl7.org/CodeSystem/conditionclinical","code":"active","display":"Active"}]},"verificationStatus":{"coding":[{"system":"http://terminology.hl7.org/CodeSystem/condition-verstatus","code":"confirmed","display":"Confirmed"}]},"category":[{"coding":[{"system":"http://snomed.info/sct","code":"439401001","display":"Diagnosis"}]}],"severity":{"coding":[{"system":"http://snomed.info/sct","code":"24484000","display":"Severe"}]},"code":{"coding":[{"system":"http://hl7.org/fhir/sid/icd-10","code":"Z02.6","display":"EXAMINATION FOR INSURANCE PURPOSES"}],"text":"EXAMINATION FOR INSURANCE PURPOSES"},"bodySite":[{"coding":[{"system":"http://snomed.info/sct","code":"","display":""}],"text":""}],"recordedDate":"2023-12-14T14:36:46.000Z"}],"Medication":[],"Appointment":[{"status":"booked","serviceCategory":[{"coding":[{"system":"http://example.org/service-category","code":"","display":""}]}],"serviceType":[{"coding":[{"code":"40","display":"ศูนย์ตรวจสุขภาพ"}]}],"specialty":[{"coding":[{"system":"http://snomed.info/sct","code":"","display":""}]}],"appointmentType":{"coding":[{"system":"http://terminology.hl7.org/CodeSystem/v2-0276","code":"","display":""}]},"reason":[{"reference":{"reference":"40","display":"ศูนย์ตรวจสุขภาพ"}}],"description":"เพื่อประเมินอาการซ้ำ DELAY SPEECH [F809] เพื่อรับยาต่อ เพื่อรับยาต่อ","start":"2023-12-21T00:00:00.000Z","end":"2023-12-21T00:00:00.000Z","created":"2023-12-14","note":[{"text":"เพื่อประเมินอาการซ้ำ DELAY SPEECH [F809] เพื่อรับยาต่อ เพื่อรับยาต่อ"}],"patientInstruction":[{"concept":{"text":"ศูนย์ตรวจสุขภาพ"}}],"basedOn":[{"reference":"ServiceRequest/myringotomy"}],"subject":{"reference":"Patient/example","display":"ด.ต.สัมพันธ์ เข็มคุณ "},"participant":[{"actor":{"reference":"Patient/example","display":"ด.ต.สัมพันธ์ เข็มคุณ "},"required":true,"status":"accepted"},{"type":[{"coding":[{"system":"http://terminology.hl7.org/CodeSystem/v3-ParticipationType","code":"ATND"}]}],"actor":{"reference":"Practitioner/example","display":"สุทธิพงษ์ สุขสิงห์ "},"required":true,"status":"accepted"},{"actor":{"reference":"40","display":"ศูนย์ตรวจสุขภาพ"},"required":true,"status":"accepted"}]}],"Immunization":[],"Claim":[]}]},"results_phr":{"result":{},"MessageCode":200,"Message":"OK","RequestTime":"2023-12-14T16:15:38.177Z","EndpointIP":"192.168.86.1","EndpointPort":15050,"profiler":[{"patient":2250},{"patient_key_ids":{"patient":[15032795],"patient_name":[15541551,15541556],"patient_telecom":[13236936],"patient_address":[17246967],"patient_identifier":[30069957,30069975],"patient_contact":[1234273],"patient_contact_address":[]}},{"medications_10953:0003019074":16},{"observations_10953:0003019074":0},{"observations_ids":{"observation_code":[]}},{"appointments_10953:0003019074":531}],"processing_warning":[],"note":"Normal processing","processing_time_ms":12312}}

            */
            ############################INSERT TABLE Log_dmht#############################

            if (strlen($response) > 0) {
                $strSQL = "REPLACE INTO log_phr (visit_id, cid , pid,status, messagecode ,response , users, regdate,d_update) VALUES ('$visit','$cid','$hn','$scode','$messages','$result' ,'yii','$regdate',NOW())";
                Yii::$app->db143->createCommand($strSQL)->execute();
                // Yii::$app->db2->createCommand()->insert('log_dmht', $strSQL)->execute();
            }
        }
        return $this->redirect(['phr']);
    }


    ################# ดึงข้อมูลให้ฟอร์ม PHR ########################
    public function actionPhr()
    {
        $sql = "SELECT @n :=@n +1 'No'
        ,b.reg_datetime as 'regdate'
        ,b.visit_id
        ,b.hn
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
          TIMESTAMPDIFF(year,p.BIRTHDATE,b.REG_DATETIME) as 'age',
          p.cid,
        GROUP_CONCAT(DISTINCT trim(icd.ICD10_TM)) as Diag
        ,left(e.unit_name,10) 'unit_name', 
         p.TELEPHONE as 'Telephone'
          FROM (select @n := 0) m, opd_visits b 
          INNER JOIN cid_hn c on b.HN= c.HN
          INNER JOIN population p on c.CID=p.CID AND left(p.cid,5) <> '00000'
          INNER JOIN opd_diagnosis d ON d.visit_id = b.visit_id AND d.is_cancel = 0 
          LEFT JOIN icd10new icd ON icd.icd10 = d.icd10 AND icd.icd10 <> ''
          LEFT JOIN ipd_reg ir ON ir.VISIT_ID = b.visit_id  AND ir.IS_CANCEL = 0
          INNER JOIN service_units e ON b.UNIT_REG=e.unit_id
          LEFT JOIN refers r ON b.VISIT_ID=r.VISIT_ID AND r.IS_CANCEL='0'
          LEFT JOIN lab_requests lr ON lr.visit_id = b.visit_id AND lr.is_cancel = 0 
          LEFT JOIN lab_lists l ON l.lab_id = lr.lab_id  
          WHERE b.IS_CANCEL = 0 
          AND b.REG_DATETIME BETWEEN SUBDATE(CURDATE(), INTERVAL 1 DAY) AND CURDATE()
          #AND b.REG_DATETIME BETWEEN SUBDATE(CURDATE() ,INTERVAL 5 DAY) AND CURDATE()-1
          #AND b.REG_DATETIME BETWEEN SUBDATE(CURDATE() ,INTERVAL 5 DAY) AND NOW()
          #AND b.REG_DATETIME BETWEEN '2021-03-01 00:01' AND '2021-03-31 23:59'
		  AND b.visit_id not in (SELECT mv.visit_id FROM mobile_visits mv)
          AND b.visit_id  not in (SELECT vs.visit_id from log_all.log_phr vs )
          GROUP BY b.VISIT_ID  ORDER BY @n DESC LIMIT 1
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
                'pageSize' => 1,
            ],
        ]);
        $sqlCount1 = "SELECT COUNT(DISTINCT v.visit_id) as amount
            FROM log_phr v 
            WHERE v.status = '200'
            AND v.d_update BETWEEN CURDATE() AND NOW()";

        $data = \yii::$app->db143->createCommand($sqlCount1)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $amount = $data[$i]['amount'];
        }
        $sqlCamount = "SELECT COUNT(DISTINCT v.visit_id) as amountx
             FROM log_phr v 
             WHERE v.status <> '200'
             AND v.d_update BETWEEN CURDATE() AND NOW()";
        $data = \yii::$app->db143->createCommand($sqlCamount)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $amountx = $data[$i]['amountx'];
        }
        $total = "SELECT COUNT(DISTINCT v.visit_id) as total
             FROM log_phr v 
             WHERE v.status = '200' ";

        $data = \yii::$app->db143->createCommand($total)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $total = $data[$i]['total'];
        }

        return $this->render('phr', [
            // 'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'amount' => $amount,
            'amountx' => $amountx,
            'total' => $total,

        ]);
    }
    public function actionSendphr()  {
        $sql = "SELECT v.visit_id, v.status, v.pid, v.messagecode, v.response, v.users, v.d_update
        FROM log_phr v 
        WHERE v.status = '200'
        AND v.d_update BETWEEN CURDATE() AND NOW()
        GROUP BY v.visit_id ORDER BY d_update DESC
        ";
        $rawData = \yii::$app->db143->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db143->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        
        $logProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        return $this->render('sendphr', [
            // 'searchModel' => $searchModel,
            'logProvider' => $logProvider,

        ]);
            }
            public function actionLogerr()  {
                $sql = "SELECT l.id, l.visit_id, l.pid, l.`status`, l.messagecode, l.response, l.users, l.d_update
                FROM log_phr l 
                WHERE l.d_update >= CURDATE()
                AND l.messagecode <> 'success'
                ORDER BY l.d_update DESC
                ";
                $rawData = \yii::$app->db143->createCommand($sql)->queryAll();
                try {
                    $rawData = \Yii::$app->db143->createCommand($sql)->queryAll();
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
