<?php

namespace app\controllers;

use yii;
use yii\helpers\FileHelper;
use ZipArchive;
use yii\helpers\Json;
use yii\web\UploadedFile;
use yii\httpclient\Client;
use yii\httpclient\Request;
use yii\helpers\BaseFileHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\db\Exception;
use yii\web\NotFoundHttpException;


class F16hurbController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $data = Yii::$app->request->post();
        $date1 = isset($data['date1']) ? date('Y-m-d 00:01', strtotime($data['date1'])) : '';
        $date2 = isset($data['date2']) ? date('Y-m-d 23:59', strtotime($data['date2'])) : '';
       
        // print_r($date1);
        $sqlData = "SELECT @n :=@n +1 'No'
        ,DATE_FORMAT(o.reg_datetime, '%Y-%m-%d %H:%i') as 'regdate'
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
          icd1.ICD10_TM as Diagx,
          LEFT(GROUP_CONCAT(DISTINCT TRIM(icd.ICD10_TM)), 30) AS Diag,
					GROUP_CONCAT(DISTINCT ps.drug_id) as drug,
					left(e.unit_name,10) 'unit_name', 
					f.INSCL_NAME as 'inscl',
					g.hospmain, g.hospsub,
					g.UC_REGISTER,g.UC_EXPIRE,
					IFNULL(ak.claimcode, '') AS claimcode
          FROM (select @n := 0) m, opd_visits o 
          INNER JOIN cid_hn c on o.HN= c.HN
          INNER JOIN population p on c.CID=p.CID AND left(p.cid,5) <> '00000'
          INNER JOIN opd_diagnosis d ON d.visit_id = o.visit_id AND d.is_cancel = 0 
          LEFT JOIN icd10new icd ON icd.icd10 = d.icd10 AND icd.icd10 <> ''
          INNER JOIN opd_diagnosis d1 ON d1.visit_id = o.visit_id AND d.is_cancel = 0  AND d1.dxt_id = 1
          LEFT JOIN icd10new icd1 ON icd1.icd10 = d1.icd10 AND icd1.icd10 <> ''
          LEFT JOIN ipd_reg ir ON ir.VISIT_ID = o.visit_id  AND ir.IS_CANCEL = 0
          INNER JOIN service_units e ON o.UNIT_REG=e.unit_id
          LEFT JOIN lab_requests lr ON lr.visit_id = o.visit_id AND lr.is_cancel = 0 
          LEFT JOIN lab_lists l ON l.lab_id = lr.lab_id 
					INNER JOIN prescriptions ps on ps.visit_id = o.visit_id AND ps.is_cancel = 0 AND ps.drug_id in ('2280','0664','0263','0491','2358','0262')
					LEFT JOIN main_inscls f ON o.INSCL = f.INSCL
					LEFT JOIN uc_inscl g ON c.CID= g.CID AND (g.date_abort > date(o.REG_DATETIME) OR DAY(g.DATE_ABORT)=0)  and trim(g.hospmain) <>''
					LEFT JOIN hosp_sss h ON c.CID=h.CID AND (h.date_abort > date(o.REG_DATETIME) OR DAY(h.DATE_ABORT) = 0 )and trim(h.HOSP_ID) <>''  
          LEFT JOIN authen_kiosk ak ON p.CID = ak.cid  AND date(o.REG_DATETIME)=date(ak.d_update)
					LEFT JOIN cost_visits cos ON cos.visit_id = o.visit_id 
          WHERE o.IS_CANCEL = 0
				AND o.REG_DATETIME BETWEEN '$date1' AND '$date2'
/*
				AND (
								(o.UNIT_REG NOT IN ('11') AND o.UNIT_ID NOT IN ('11')) 
								OR (
										(o.UNIT_REG IN ('11') OR o.UNIT_ID IN ('11')) 
										AND NOT (
												(TIME(o.REG_DATETIME) BETWEEN '16:30' AND '23:59') 
												OR (TIME(o.REG_DATETIME) BETWEEN '00:00' AND '08:30') 
												OR (DAYOFWEEK(o.reg_datetime) IN (1, 7)) 
												OR (DATE(o.reg_datetime) IN (SELECT holidays.h_date FROM holidays))
										)
								)
						)
*/
						 # o.REG_DATETIME BETWEEN '$date1' AND '$date2'
				AND o.INSCL in ('03','04','33','00','23')
				AND o.visit_id not in (SELECT ipd_reg.visit_id from ipd_reg WHERE ipd_reg.is_cancel=0)
				AND o.visit_id  not in (SELECT vs.visit_id from log_all.log_fdh_opd vs )
				GROUP BY o.VISIT_ID
				ORDER BY No DESC , e.unit_id
            ";
        $rawData = \Yii::$app->db14->createCommand($sqlData)->queryAll();

        $sqlCount1 = "SELECT COUNT( v.visit_id) as amount
        FROM log_fdh_opd v 
        WHERE v.messagecode = 'success' AND v.users = 'hurb'
        AND v.d_update BETWEEN date_sub(NOW(), INTERVAL 1 DAY) AND NOW()";

        $data = \yii::$app->db143->createCommand($sqlCount1)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $amount = $data[$i]['amount'];
        }

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 400,
            ],
        ]);
        ########################################################################################################
        $sqlPass = "select l.id, l.visit_id, l.pid , l.messagecode, l.response, l.users, l.d_update
        FROM log_fdh_opd l 
        WHERE l.d_update BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()
        AND l.messagecode = 'success' AND l.users = 'hurb'
        ORDER BY l.d_update DESC
        
         ";
        $rawData = \Yii::$app->db143->createCommand($sqlPass)->queryAll();

        // สร้าง Flash Alert
        //Yii::$app->session->setFlash('success', 'รายการที่ไม่ผ่านตามเงื่อนไข');

        $passProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 300,
            ],
        ]);
        ########################################################################################################
        $sqlError = "select l.id, l.visit_id, l.pid , l.messagecode, l.response, l.users, l.d_update
        FROM log_fdh_opd l 
        WHERE l.d_update BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()
        AND l.messagecode <> 'success' AND l.users = 'hurb'
        ORDER BY l.d_update DESC
        
         ";
        $rawData = \Yii::$app->db143->createCommand($sqlError)->queryAll();

        // สร้าง Flash Alert
        //Yii::$app->session->setFlash('success', 'รายการที่ไม่ผ่านตามเงื่อนไข');

        $errorProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 350,
            ],
        ]);
        return $this->render('index', [
            // 'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'passProvider' => $passProvider,
            'errorProvider' => $errorProvider,
            'amount' => $amount,
          
        ]);
    }
    private $visit;
    private $hn;
    public function actionData()
    {
        $vn = Yii::$app->request->post('chkDel', []);

        foreach ($vn as $r) {
            $hn = substr($r, 10);
            $visit = substr($r, 0, 10);
            $visits[] = $visit;
            $db14 = \Yii::$app->db14;

            $baseDirectory = 'uploads/fdh_opd/';
            $mode = 0777;

            $tables = ['adp', 'ins', 'odx', 'opd', 'pat', 'cha', 'cht','aer'];
            foreach ($tables as $table) {
                $query = "SELECT main_query FROM fdh_hurb WHERE main_table = '$table'";
                $results = $db14->createCommand($query)->queryAll();
                foreach ($results as $result) {
                    $mainQueryResult = $result['main_query'];
                    $mainQueryResult = str_replace('$visit', $visit, $mainQueryResult);
                    $data = $db14->createCommand($mainQueryResult)->queryAll();
                    $filePath = $baseDirectory . strtoupper($table) . '.txt';
                    $header = $this->getHeaderForTable($table);
                    $this->exportToTextFile($data, $filePath, $header);
                }
            }

            $this->sendDataToAPI($visit, $hn);
        }

        // Store values in session
        Yii::$app->session->set('visits', $visits);
        Yii::$app->session->set('hn', $hn);
        //Yii::$app->session->set('message_th', $message_th);
        return $this->redirect(['index', 'visit' => $visit, 'hn' => $hn]);
        // return $this->redirect(['index']);
    }

    private function getHeaderForTable($table)
    {
        switch ($table) {
            case 'adp':
                return ['HN', 'AN', 'DATEOPD', 'TYPE', 'CODE', 'QTY', 'RATE', 'SEQ', 'CAGCODE', 'DOSE', 'CA_TYPE', 'SERIALNO', 'TOTCOPAY', 'USE_STATUS', 'TOTAL', 'QTYDAY', 'TMLTCODE', 'STATUS1', 'BI', 'CLINIC', 'ITEMSRC', 'PROVIDER', 'GRAVIDA', 'GA_WEEK', 'DCIP/E_SCREEN', 'LMP'];
            case 'cha':
                return ['HN', 'AN', 'DATE', 'CHRGITEM', 'AMOUNT', 'PERSON_ID', 'SEQ'];
            case 'cht':
                return ['HN', 'AN', 'DATE', 'TOTAL', 'PAID', 'PTTYPE', 'PERSON_ID', 'SEQ', 'OPD_MEMO', 'INVOICE_NO', 'INVOICE_LT'];
            case 'dru':
                return ['HCODE', 'HN', 'AN', 'CLINIC', 'PERSON_ID', 'DATE_SERV', 'DID', 'DIDNAME', 'AMOUNT', 'DRUGPRICE', 'DRUGCOST', 'DIDSTD', 'UNIT', 'UNIT_PACK', 'SEQ', 'DRUGREMARK', 'PA_NO', 'TOTCOPAY', 'USE_STATUS', 'TOTAL', 'SIGCODE', 'SIGTEXT', 'PROVIDER'];
            case 'ins':
                return ['HN', 'INSCL', 'SUBTYPE', 'CID', 'HCODE', 'DATEEXP', 'HOSPMAIN', 'HOSPSUB', 'GOVCODE', 'GOVNAME', 'PERMITNO', 'DOCNO', 'OWNRPID', 'OWNNAME', 'AN', 'SEQ', 'SUBINSCL', 'RELINSCL', 'HTYPE'];
            case 'odx':
                return ['HN', 'DATEDX', 'CLINIC', 'DIAG', 'DXTYPE', 'DRDX', 'PERSON_ID', 'SEQ'];
            case 'oop':
                return ['HN', 'DATEOPD', 'CLINIC', 'OPER', 'DROPID', 'PERSON_ID', 'SEQ'];
            case 'opd':
                return ['HN', 'CLINIC', 'DATEOPD', 'TIMEOPD', 'SEQ', 'UUC', 'DETAIL', 'BTEMP', 'SBP', 'DBP', 'PR', 'RR', 'OPTYPE', 'TYPEIN', 'TYPEOUT'];
            case 'orf':
                return  ['HN', 'DATEOPD', 'CLINIC', 'REFER', 'REFERTYPE', 'SEQ', 'REFERDATE'];
            case 'pat':
                return ['HCODE', 'HN', 'CHANGWAT', 'AMPHUR', 'DOB', 'SEX', 'MARRIAGE', 'OCCUPA', 'NATION', 'PERSON_ID', 'NAMEPAT', 'TITLE', 'FNAME', 'LNAME', 'IDTYPE'];
            case 'aer':
                return ['HN', 'AN', 'DATEOPD', 'AUTHAE', 'AEDATE', 'AETIME', 'AETYPE', 'REFER_NO', 'REFMAINI', 'IREFTYPE', 'REFMAINO', 'OREFTYPE', 'UCAE', 'EMTYPE', 'SEQ', 'AESTATUS', 'DALERT', 'TALERT'];
            default:
                return [];
        }
    }

    private function exportToTextFile($data, $filePath, $header = [])
    {
        $file = fopen($filePath, 'wb');
        if (!empty($header)) {
            fputcsv($file, $header, "|");
        }
        foreach ($data as $row) {
            array_walk($row, function (&$value) {
                $value = mb_convert_encoding($value, 'UTF-8', mb_detect_encoding($value));
            });
            fputcsv($file, $row, "|");
        }
        fclose($file);
        $this->convertToWindowsCrLf($filePath);
    }

    private function convertToWindowsCrLf($filePath)
    {
        $content = file_get_contents($filePath);
        $content = str_replace("\n", "\r\n", $content);
        file_put_contents($filePath, $content);
    }

    private function sendDataToAPI($visit, $hn)
    {
        // รับค่า token จากฐานข้อมูล
        $sqltoken = "SELECT MAX(token) as token30 FROM fdh_token";
        $data = Yii::$app->db14->createCommand($sqltoken)->queryOne();

        if ($data && isset($data['token30'])) {
            $token30 = $data['token30'];

            // กำหนดเส้นทางของไฟล์
            $filePaths = [
                __DIR__ . '/../web/uploads/fdh_opd/PAT.txt',
                __DIR__ . '/../web/uploads/fdh_opd/INS.txt',
                __DIR__ . '/../web/uploads/fdh_opd/OPD.txt',
                __DIR__ . '/../web/uploads/fdh_opd/ADP.txt',
                __DIR__ . '/../web/uploads/fdh_opd/ODX.txt',
                __DIR__ . '/../web/uploads/fdh_opd/CHA.txt',
                __DIR__ . '/../web/uploads/fdh_opd/CHT.txt',
                __DIR__ . '/../web/uploads/fdh_opd/AER.txt',
            ];
            // สร้าง HTTP client และส่งคำขอ   
            ## https://fdh.moph.go.th/api/v2/data_hub/16_files/
            ##  https://uat-fdh.inet.co.th/api/v2/data_hub/16_files/
            $client = new Client();
            $request = $client->createRequest()
                ->setMethod('POST')
                ->setUrl('##  https://uat-fdh.inet.co.th/api/v2/data_hub/16_files/')
                ->addHeaders([
                    'Authorization' => 'Bearer ' . $token30,
                    'Content-Type' => 'multipart/form-data',
                ]);

            // เพิ่มไฟล์เข้าไปในคำขอ
            foreach ($filePaths as $filePath) {
                if (file_exists($filePath)) {
                    $request->addFile('file', $filePath, ['content-type' => 'text/plain']);
                }
            }

            // เพิ่มข้อมูลเพิ่มเติมที่จะส่งไปด้วย
            $request->addData([
                'key' => 'value',
                'type' => 'txt',
            ]);

            // ส่งคำขอและรับผลลัพธ์
            $response = $request->send();
            //return $response;
            $responseData = json_decode($response->getContent(), true);


            $message = isset($responseData['message']) ? $responseData['message'] : ''; // ใช้ isset() เพื่อหลีกเลี่ยงข้อผิดพลาด
            $message_th = isset($responseData['message_th']) ? $responseData['message_th'] : '';

            // ตรวจสอบสถานะของคำขอ
            if ($response->isOk) {
                Yii::$app->session->setFlash('success', 'ส่งข้อมูลสำเร็จ.');
            } else {
                $errorMessage = "Error: " . $response->getStatusCode() . " " . $response->getContent() . " สำหรับ visit: " . $visit;
                Yii::$app->session->setFlash('error', $errorMessage);
            }

            // บันทึกผลลัพธ์ลงใน log
            $logSQL = "REPLACE INTO log_fdh_opd(visit_id, pid, messagecode, response, users, d_update) 
            VALUES ('$visit', '$hn', '$message', '$message_th', 'hurb', NOW())";
            Yii::$app->db143->createCommand($logSQL)->execute();
            return $message;
            return $message_th;
            //  // บันทึกข้อมูลลงใน log ของ Yii
            //  Yii::info("Visit: $visit, HN: $hn", __METHOD__);
        } else {
            Yii::$app->session->setFlash('error', 'ไม่พบ token ในฐานข้อมูล.');
        }
    }


    public function actionListFiles()
    {
        $this->view->params['showSidebar'] = false;
        $dirPath = Yii::getAlias('@webroot/uploads/fdh_opd');
        $files = scandir($dirPath); // ใช้ scandir เพื่อแสดงรายการไฟล์ในโฟลเดอร์

        return $this->render('listFiles', ['files' => $files]);
    }

    public function actionListFilesPartial()
    {
        $dirPath = Yii::getAlias('@webroot/uploads/fdh_opd');
        $files = scandir($dirPath); // แสดงรายการไฟล์

        // เรนเดอร์เฉพาะเนื้อหาโดยไม่ใช้ Layout
        return $this->renderPartial('listFiles', ['files' => $files]);
    }

    public function actionReadFile($fileName)
{
    $filePath = Yii::getAlias('@webroot/uploads/fdh_opd/' . $fileName);

    try {
        if (file_exists($filePath)) {
            // โหลดเนื้อหาจากไฟล์
            $fileContent = file_get_contents($filePath);

            // แปลง CRLF เป็น LF แล้วแปลง LF เป็น <br>
            $fileContent = nl2br(Html::encode($fileContent));

            // เรนเดอร์เฉพาะเนื้อหาโดยไม่ใช้ Layout
            return $this->renderPartial('readFile', [
                'content' => $fileContent,
                'fileName' => $fileName
            ]);
        } else {
            throw new NotFoundHttpException('File not found.');
        }
    } catch (Exception $e) {
        Yii::error('Error reading file: ' . $e->getMessage());
        throw new \yii\web\NotFoundHttpException('Error reading file.');
    }
}

    
    // public function actionReadFile($fileName)
    // {
    //     $filePath = Yii::getAlias('@webroot/uploads/fdh_opd/' . $fileName);

    //     if (file_exists($filePath)) {
    //         // โหลดเนื้อหาจากไฟล์
    //         $fileContent = file_get_contents($filePath);

    //         // เรนเดอร์เฉพาะเนื้อหาโดยไม่ใช้ Layout
    //         return $this->renderPartial('readFile', ['content' => $fileContent]);
    //     } else {
    //         throw new \yii\web\NotFoundHttpException('File not found.');
    //     }
    // }
    // In your controller, add an action to return the current status
    public function actionGetVisitStatus()
    {
        $visits = [];

        // Check session data and add it to the visits array
        foreach ($_SESSION as $key => $value) {
            if (strpos($key, 'visit_') === 0) { // Check if the key starts with 'visit_'
                $visit_id = str_replace('visit_', '', $key);
                $visits[] = [
                    'id' => $visit_id,
                    'status' => isset($value['status']) ? $value['status'] : 'unknown',
                    'message' => isset($value['message']) ? $value['message'] : 'No message',
                    'message_th' => isset($value['message_th']) ? $value['message_th'] : 'ไม่มีข้อความ',
                ];
            }
        }

        return $this->asJson($visits); // Return data as JSON
    }
    // public function actionExportexcel()
    // {
    //     $sql = "SELECT v.visit_id, v.pid, f.fullname,f.cid,
    //     f.age_year, f.height,f.weight,f.hospmain, f.hospsub, f.symptoms,
    //      f.`ผลตรวจ`,f.screen_date ,v.d_update,
    //     v.response
    //             FROM log_fdh_opd v 
    //     INNER JOIN jhcisdb.fittest f ON f.seq = v.visit_id
    //             WHERE v.users = 'hurb'
    //             AND v.d_update BETWEEN CURDATE() AND NOW()
    //      ORDER BY v.pid
    //         ";

    //     $rawData = \yii::$app->db143->createCommand($sql)->queryAll();

    //     //print_r($rawData);
    //     try {
    //         $rawData = \Yii::$app->db143->createCommand($sql)->queryAll();
    //     } catch (\yii\db\Exception $e) {
    //         throw new \yii\web\ConflictHttpException('sql error');
    //     }
    //     $dataProvider = new \yii\data\ArrayDataProvider([
    //         'allModels' => $rawData,
    //         'pagination' => FALSE,
    //         //'pagination' => ['pagesize' => 5],
    //     ]);

    //     return $this->render('export_excel', [
    //         'dataProvider' => $dataProvider,
    //         'sql' => $sql,

    //     ]);
    // }
    public function actionRunCurl()
    {
        // เริ่มต้นการตั้งค่า Flash
        Yii::$app->response->format = Response::FORMAT_JSON;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fdh.moph.go.th/token?Action=get_moph_access_token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode([
                'user' => 'chatree.10953',
                'password_hash' => 'EA83F69D2E86DD5DB0EFEDFA4580F37D147477460C1703E466474B2C2DD7FC69',
                'hospital_code' => '10953'
            ]),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
        ));

        $response = curl_exec($curl);  // รัน cURL และเก็บผลลัพธ์
        $err = curl_error($curl);     // ใช้ตัวแปร $curl ที่ถูกต้อง
        curl_close($curl);            // ปิด cURL


        if ($err) {
            Yii::$app->session->setFlash('error', "cURL Error: $err");
            return $this->redirect(['index']); // เปลี่ยนให้ตรงกับหน้าเว็บที่ต้องการ
        }

        try {
            Yii::$app->db->createCommand()->insert('fdh_token', [
                'token_dt' => date('Y-m-d H:i:s'),
                'token' => $response,
                'staff_id' => 'gan',
            ])->execute();

            Yii::$app->session->setFlash('success', 'New token created successfully');
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', "Database Error: " . $e->getMessage());
        }

        return $this->redirect(['index']); // กลับไปยังหน้าเว็บที่ต้องการ
    }
}
