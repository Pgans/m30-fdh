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

class F16ipaeController extends \yii\web\Controller
{
	
    public function actionIndex()
    {
         $date1x = Yii::$app->request->get('date1', date('Y-m-d'));
	    $date2x = Yii::$app->request->get('date2', date('Y-m-d'));

	    $date1 = date('Y-m-d 00:01', strtotime($date1x));
	    $date2 = date('Y-m-d 23:59', strtotime($date2x));

        $sqlData = "SELECT 
        @n := @n + 1 AS 'No',
        data.*
      FROM 
        (SELECT DATE_FORMAT(o.reg_datetime, '%Y-%m-%d %H:%i') as 'regdate'
              ,ir.dsc_dt as dsc
              ,o.visit_id
              ,o.hn
              ,ir.adm_id as an 
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
                LEFT(GROUP_CONCAT(DISTINCT TRIM(icd.ICD10_TM)), 30) AS Diag
              ,left(e.unit_name,10) 'unit_name', 
              f.INSCL_NAME as 'inscl',
             #'' as amount,
              g.hospmain, g.hospsub,
               log.messagecode,
			    COALESCE((cg01 + cg02 + cg03 + cg04 + cg05 + cg06 + cg07 + cg08 + cg09 + cg10 + cg11 + cg12 + cg13 + cg14 + cg15 + cg16 + cg17 + cg18 + cg19), 00) AS amount,
              IFNULL(ak.claimcode, '') AS claimcode
                FROM  opd_visits o 
                INNER JOIN cid_hn c on o.HN= c.HN
                INNER JOIN population p on c.CID=p.CID AND left(p.cid,5) <> '00000'
                LEFT JOIN opd_diagnosis d ON d.visit_id = o.visit_id AND d.is_cancel = 0 
                LEFT JOIN icd10new icd ON icd.icd10 = d.icd10 AND icd.icd10 <> ''
                LEFT JOIN opd_diagnosis d1 ON d1.visit_id = o.visit_id AND d.is_cancel = 0  AND d1.dxt_id = 1
                LEFT JOIN icd10new icd1 ON icd1.icd10 = d1.icd10 AND icd1.icd10 <> ''
                LEFT JOIN ipd_reg ir ON ir.VISIT_ID = o.visit_id  AND ir.IS_CANCEL = 0
                LEFT JOIN service_units e ON ir.ward_no = e.unit_id
                LEFT JOIN lab_requests lr ON lr.visit_id = o.visit_id AND lr.is_cancel = 0 
                LEFT JOIN lab_lists l ON l.lab_id = lr.lab_id 
      LEFT JOIN main_inscls f ON o.INSCL = f.INSCL
      LEFT JOIN uc_inscl g ON c.CID= g.CID AND (g.date_abort > date(o.REG_DATETIME) OR DAY(g.DATE_ABORT)=0)  and trim(g.hospmain) <>''
      LEFT JOIN hosp_sss h ON c.CID=h.CID AND (h.date_abort > date(o.REG_DATETIME) OR DAY(h.DATE_ABORT) = 0 )and trim(h.HOSP_ID) <>''  
	  LEFT JOIN authen_kiosk ak ON ak.visit_id = o.visit_id
	  LEFT JOIN cost_visits cos ON cos.visit_id = o.visit_id AND cos.is_cancel = 0
	  LEFT JOIN receipts re ON re.visit_id = o.visit_id AND re.is_cancel = 0
      #LEFT JOIN authen_kiosk ak ON p.CID = ak.cid  AND date(o.REG_DATETIME)=date(ak.d_update)
      LEFT JOIN log_fdh_ipd_ck   as log ON log.visit_id = o.visit_id
      WHERE  o.IS_CANCEL = 0
      AND ir.dsc_dt BETWEEN '$date1' AND '$date2'
      AND ir.dsc_dt <> '0'
              AND o.INSCL in ('03','04','33','23')
              AND g.hospmain <> '10953'
              #AND o.PT_STATES not in (1,2)
              AND ir.WARD_NO != '50'
      GROUP BY o.VISIT_ID
      ORDER BY ir.adm_id           
      ) AS data,
        (SELECT @n := 0) AS init
      ORDER BY 
        No DESC 
            ";
        $rawData = \Yii::$app->db2->createCommand($sqlData)->queryAll();

        $sqlCount1 = "SELECT COUNT( v.visit_id) as amount
        FROM log_fdh_ipd_ck v 
        WHERE  v.users = 'ipae' and v.messagecode <> '' 
        AND v.d_update BETWEEN CURDATE() AND NOW()";

        $data = \yii::$app->db2->createCommand($sqlCount1)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $amount = $data[$i]['amount'];
        }

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);
        ########################################################################################################
        $sqlPass = "select l.id, l.visit_id, l.an , l.messagecode, l.response, l.users, l.d_update
        FROM log_fdh_ipd_ck l 
        WHERE l.d_update BETWEEN CURDATE() AND NOW()
        AND l.messagecode <> '' AND l.users = 'ipae'
        ORDER BY l.d_update DESC
        
         ";
        $rawData = \Yii::$app->db2->createCommand($sqlPass)->queryAll();

        // สร้าง Flash Alert
        //Yii::$app->session->setFlash('success', 'รายการที่ไม่ผ่านตามเงื่อนไข');

        $passProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);
        ########################################################################################################
        $sqlError = "select l.id, l.visit_id, l.an , l.messagecode, l.response, l.users, l.d_update
        FROM log_fdh_ipd_ck l 
        WHERE l.d_update BETWEEN CURDATE() AND NOW()
        AND l.messagecode <> 'success' AND l.users = 'ipae'
        ORDER BY l.d_update DESC
        
         ";
        $rawData = \Yii::$app->db2->createCommand($sqlError)->queryAll();

        // สร้าง Flash Alert
        //Yii::$app->session->setFlash('success', 'รายการที่ไม่ผ่านตามเงื่อนไข');

        $errorProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        return $this->render('index', [
            // 'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'passProvider' => $passProvider,
            'errorProvider' => $errorProvider,
            'amount' => $amount,
			'date1' => $date1,
			'date2' => $date2,

        ]);
    }
    private $visit;
    private $hn;
	#################################################################################################
    public function actionData()
    {
		$date1 = Yii::$app->request->post('date1');
	    $date2 = Yii::$app->request->post('date2');
		
        $vn = Yii::$app->request->post('chkDel', []);

        foreach ($vn as $r) {
            $an = substr($r, 10);
           // echo $an;
            $visit = substr($r, 0, 10);
            $visits[] = $visit;
            $db2 = \Yii::$app->db2;

            $baseDirectory = 'uploads/fdh_ipd/';
            $mode = 0777;

            $tables = ['adp', 'ins', 'pat', 'ipd', 'iop', 'irf', 'idx','aer', 'dru', 'cha', 'cht' ];
            foreach ($tables as $table) {
                $query = "SELECT main_query FROM fdh_ipae WHERE main_table = '$table'";
                $results = $db2->createCommand($query)->queryAll();
                foreach ($results as $result) {
                    $mainQueryResult = $result['main_query'];
                    $mainQueryResult = str_replace('$visit', $visit, $mainQueryResult);
                    $data = $db2->createCommand($mainQueryResult)->queryAll();
    
                    if (!isset($fileData[$table])) {
                        $fileData[$table] = [];
                    }
                    $fileData[$table] = array_merge($fileData[$table], $data);
                }
            }
        }
    
        foreach ($fileData as $table => $data) {
            $filePath = $baseDirectory . strtoupper($table) . '.txt';
            $header = $this->getHeaderForTable($table);
            $this->exportToTextFile($data, $filePath, $header);
        }
    
        $this->sendDataToAPI($visit, $an);
    
        // Store values in session
        Yii::$app->session->set('visits', $visits);
        Yii::$app->session->set('an', $an);
        return $this->redirect(['index', 'date1' => $date1, 'date2' => $date2, 'visit' => $visit, 'an' => $an]);
    }
    

    private function getHeaderForTable($table)
    {
        switch ($table) {
            case 'adp':
                return ['HN', 'AN', 'DATEOPD', 'TYPE', 'CODE', 'QTY', 'RATE', 'SEQ', 'CAGCODE', 'DOSE', 'CA_TYPE', 'SERIALNO', 'TOTCOPAY', 'USE_STATUS', 'TOTAL', 'QTYDAY', 'TMLTCODE', 'STATUS1', 'BI', 'CLINIC', 'ITEMSRC', 'PROVIDER', 'GRAVIDA', 'GA_WEEK', 'DCIP/E_SCREEN', 'LMP'];
            case 'cha':
                return ['HN', 'AN', 'DATE', 'CHRGITEM', 'AMOUNT', 'PERSON_ID', 'SEQ'];
            case 'cht':
                return ['HN', 'AN', 'DATE', 'TOTAL', 'PAID', 'PTTYPE', 'PERSON_ID', 'SEQ'];
               // return ['HN', 'AN', 'DATE', 'TOTAL', 'PAID', 'PTTYPE', 'PERSON_ID', 'SEQ', 'OPD_MEMO', 'INVOICE_NO', 'INVOICE_LT'];
            case 'dru':
                return ['HCODE', 'HN', 'AN', 'CLINIC', 'PERSON_ID', 'DATE_SERV', 'DID', 'DIDNAME', 'AMOUNT', 'DRUGPRICE', 'DRUGCOST', 'DIDSTD', 'UNIT', 'UNIT_PACK', 'SEQ', 'DRUGREMARK', 'PA_NO', 'TOTCOPAY', 'USE_STATUS', 'TOTAL', 'SIGCODE', 'SIGTEXT', 'PROVIDER'];
            case 'ins':
                return ['HN', 'INSCL', 'SUBTYPE', 'CID', 'HCODE', 'DATEEXP', 'HOSPMAIN', 'HOSPSUB', 'GOVCODE', 'GOVNAME', 'PERMITNO', 'DOCNO', 'OWNRPID', 'OWNNAME', 'AN', 'SEQ', 'SUBINSCL', 'RELINSCL', 'HTYPE'];
            // case 'odx':
            //     return ['HN', 'DATEDX', 'CLINIC', 'DIAG', 'DXTYPE', 'DRDX', 'PERSON_ID', 'SEQ'];
            // case 'oop':
            //     return ['HN', 'DATEOPD', 'CLINIC', 'OPER', 'DROPID', 'PERSON_ID', 'SEQ'];
            // case 'opd':
            //     return ['HN', 'CLINIC', 'DATEOPD', 'TIMEOPD', 'SEQ', 'UUC', 'DETAIL', 'BTEMP', 'SBP', 'DBP', 'PR', 'RR', 'OPTYPE', 'TYPEIN', 'TYPEOUT'];
            // case 'orf':
            //     return  ['HN', 'DATEOPD', 'CLINIC', 'REFER', 'REFERTYPE', 'SEQ', 'REFERDATE'];
            case 'pat':
                return ['HCODE', 'HN', 'CHANGWAT', 'AMPHUR', 'DOB', 'SEX', 'MARRIAGE', 'OCCUPA', 'NATION', 'PERSON_ID', 'NAMEPAT', 'TITLE', 'FNAME', 'LNAME', 'IDTYPE'];
            case 'aer':
                return ['HN', 'AN', 'DATEOPD', 'AUTHAE', 'AEDATE', 'AETIME', 'AETYPE', 'REFER_NO', 'REFMAINI', 'IREFTYPE', 'REFMAINO', 'OREFTYPE', 'UCAE', 'EMTYPE', 'SEQ', 'AESTATUS', 'DALERT', 'TALERT'];
            case 'ipd':
                return ['HN', 'AN', 'DATEADM', 'TIMEADM', 'DATEDSC', 'TIMEDSC', 'DISCHS', 'DISCHT', 'WARDDSC', 'DEPT', 'ADM_W', 'UUC', 'SVCTYPE'];
            case 'irf':
                return ['AN', 'REFER', 'REFERTYPE'];
            case 'iop':
                return ['AN', 'OPER', 'OPTYPE', 'DROPID', 'DATEIN', 'TIMEIN', 'DATEOUT', 'TIMEOUT'];
            case 'idx':
                return ['AN', 'DIAG', 'DXTYPE', 'DRDX'];
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

      private function sendDataToAPI($visit, $an)
        {
            // รับค่า token จากฐานข้อมูล
            $sqltoken = "SELECT MAX(token) as token30 FROM fdh_token WHERE staff_id = 'yoo'";
            $data = Yii::$app->db2->createCommand($sqltoken)->queryOne();
        
            if ($data && isset($data['token30'])) {
                $token30 = $data['token30'];
        
                // กำหนดเส้นทางของไฟล์
                $filePaths = [
                    __DIR__ . '/../web/uploads/fdh_ipd/PAT.txt',
                    __DIR__ . '/../web/uploads/fdh_ipd/INS.txt',
                    __DIR__ . '/../web/uploads/fdh_ipd/IPD.txt',
                    __DIR__ . '/../web/uploads/fdh_ipd/ADP.txt',
                    __DIR__ . '/../web/uploads/fdh_ipd/IDX.txt',
                    __DIR__ . '/../web/uploads/fdh_ipd/IRF.txt',
                    __DIR__ . '/../web/uploads/fdh_ipd/IOP.txt',
                    __DIR__ . '/../web/uploads/fdh_ipd/DRU.txt',
                    __DIR__ . '/../web/uploads/fdh_ipd/AER.txt',
                    __DIR__ . '/../web/uploads/fdh_ipd/CHA.txt',
                    __DIR__ . '/../web/uploads/fdh_ipd/CHT.txt',
                ];
        
                // สร้าง HTTP client และส่งคำขอ
                // สร้าง HTTP client และส่งคำขอ ## https://fdh.moph.go.th/api/v2/data_hub/16_files  ***  https://uat-fdh.inet.co.th/api/v2/data_hub/16_files
                $client = new Client();
                $request = $client->createRequest()
                    ->setMethod('POST')
                    ->setUrl('https://fdh.moph.go.th/api/v2/data_hub/16_files')
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
                $responseData = json_decode($response->getContent(), true);
        
                //$messages = isset($responseData['message']) ? $responseData['message'] : '';
                $message_th = isset($responseData['message_th']) ? $responseData['message_th'] : '';
        
                // ตรวจสอบสถานะของคำขอ
                if ($response->isOk) {
                    Yii::$app->session->setFlash('success', 'ส่งข้อมูลสำเร็จ.');
                } else {
                    $errorMessage = "Error: " . $response->getStatusCode() . " " . $response->getContent() . " สำหรับ visit: " . $visit;
                    Yii::$app->session->setFlash('error', $errorMessage);
                }
        
                // อ่านข้อมูลจากไฟล์ CHT.txt
                $chtFilePath = __DIR__ . '/../web/uploads/fdh_ipd/CHT.txt';
                if (file_exists($chtFilePath)) {
                    $file = fopen($chtFilePath, 'r');
                    $header = fgetcsv($file, 0, "|"); // Read the header
                    while ($row = fgetcsv($file, 0, "|")) {
                        $rowData = array_combine($header, $row); // Combine header and row to associative array
                        $an = $rowData['AN'];
                        $hn = $rowData['HN'];
                        $visit = $rowData['SEQ'];
        
                        // Prepare data for the API request
                        $postData = json_encode([
                            "hcode" => "10953",
                            "hn" => $hn,
                            "an" => $an,
                            "transaction_uid" => ""
                        ]);
        
                        // Initialize cURL
                        $curl = curl_init();
                        curl_setopt_array($curl, [
                            CURLOPT_URL => 'https://fdh.moph.go.th/api/v1/ucs/track_trans',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_SSL_VERIFYHOST => 0,
                            CURLOPT_SSL_VERIFYPEER => 0,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => $postData,
                            CURLOPT_HTTPHEADER => [
                                "Content-Type: application/json",
                                "Authorization: Bearer " . $token30
                            ],
                        ]);
        
                        $response = curl_exec($curl);
                curl_close($curl);

                // Extract status_message_th from the response
                $responseDecoded = json_decode($response, true);
				$messages = isset($responseDecoded['data'][0]['status']) ? $responseDecoded['data'][0]['status'] : '';
                $statusMessageTh = isset($responseDecoded['data'][0]['status_message_th']) ? $responseDecoded['data'][0]['status_message_th'] : '';

                 // ตรวจสอบว่ามี visit_id อยู่ในตารางหรือไม่
                 $logSQLCheck = "SELECT COUNT(*) FROM log_fdh_ipd_ck WHERE visit_id = :visit_id AND an = :an";
                 $visitCount = Yii::$app->db2->createCommand($logSQLCheck)
                     ->bindValue(':visit_id', $visit)
                     ->bindValue(':an', $an)
                     ->queryScalar();
 
                 if ($visitCount > 0) {
                     // Update ถ้ามี visit นี้อยู่แล้ว
                     $logSQLUpdate = "UPDATE log_fdh_ipd_ck SET pid = :pid, messages = :messages, messagecode = :messagecode, response = :response, users = 'ipae', d_update = NOW() WHERE visit_id = :visit_id AND an = :an";
                     Yii::$app->db2->createCommand($logSQLUpdate)
                         ->bindValue(':pid', $hn)
                         ->bindValue(':messages', $messages)
                         ->bindValue(':messagecode', $statusMessageTh)
                         ->bindValue(':response', $response)
                         ->bindValue(':visit_id', $visit)
                         ->bindValue(':an', $an)
                         ->execute();
                 } else {
                     // Insert ถ้าไม่มี visit นี้อยู่
                     $logSQLInsert = "INSERT INTO log_fdh_ipd_ck (visit_id, pid, an, messages, messagecode, response, users, d_update) VALUES (:visit_id, :pid, :an, :messages, :messagecode, :response, 'ipae', NOW())";
                     Yii::$app->db2->createCommand($logSQLInsert)
                         ->bindValue(':visit_id', $visit)
                         ->bindValue(':pid', $hn)
                         ->bindValue(':an', $an)
                         ->bindValue(':messages', $messages)
                         ->bindValue(':messagecode', $statusMessageTh)
                         ->bindValue(':response', $response)
                         ->execute();
                 }
             }
             fclose($file);
         }
 
         return $messages;
     } else {
         Yii::$app->session->setFlash('error', 'ไม่พบ token ในฐานข้อมูล.');
     }
 }

#########################################################################################################
    public function actionListFiles()
    {
        $this->view->params['showSidebar'] = false;
        $dirPath = Yii::getAlias('@webroot/uploads/fdh_ipd');
        $files = scandir($dirPath); // ใช้ scandir เพื่อแสดงรายการไฟล์ในโฟลเดอร์

        return $this->render('listFiles', ['files' => $files]);
    }

    public function actionListFilesPartial()
    {
        $dirPath = Yii::getAlias('@webroot/uploads/fdh_ipd');
        $files = scandir($dirPath); // แสดงรายการไฟล์

        // เรนเดอร์เฉพาะเนื้อหาโดยไม่ใช้ Layout
        return $this->renderPartial('listFiles', ['files' => $files]);
    }
    public function actionReadFile($fileName)
    {
        $filePath = Yii::getAlias('@webroot/uploads/fdh_ipd/' . $fileName);

        if (file_exists($filePath)) {
            // โหลดเนื้อหาจากไฟล์
            $fileContent = file_get_contents($filePath);

            // เรนเดอร์เฉพาะเนื้อหาโดยไม่ใช้ Layout
            return $this->renderPartial('readFile', ['content' => $fileContent]);
        } else {
            throw new \yii\web\NotFoundHttpException('File not found.');
        }
    }
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
    public function actionExportexcel()
    {
        $sql = "SELECT v.visit_id, v.pid, f.fullname,f.cid,
        f.age_year, f.height,f.weight,f.hospmain, f.hospsub, f.symptoms,
         f.`ผลตรวจ`,f.screen_date ,v.d_update,
        v.response
                FROM log_fdh_ipd_ck v 
        INNER JOIN jhcisdb.fittest f ON f.seq = v.visit_id
                WHERE v.users = 'homeward'
                AND v.d_update BETWEEN CURDATE() AND NOW()
         ORDER BY v.pid
            ";

        $rawData = \yii::$app->db2->createCommand($sql)->queryAll();

        //print_r($rawData);
        try {
            $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => FALSE,
            //'pagination' => ['pagesize' => 5],
        ]);

        return $this->render('export_excel', [
            'dataProvider' => $dataProvider,
            'sql' => $sql,

        ]);
    }
    public function actionRunCurl()
    {
		$request = Yii::$app->request;
		$date1 = $request->get('date1', $request->post('date1'));
		$date2 = $request->get('date2', $request->post('date2'));
		
		// 1. ลบข้อมูล token ทั้งหมดก่อน
		Yii::$app->db2->createCommand()->delete('fdh_token')->execute();
		
        // เริ่มต้นการตั้งค่า Flash
        Yii::$app->response->format = Response::FORMAT_JSON;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fdh.moph.go.th/token?Action=get_moph_access_token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
             //SSL USE
             CURLOPT_SSL_VERIFYHOST => 0,
             CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode([
				 'user' => 'saijai.10953',
                'password_hash' => '909978CEC718D8DFE5060D3B4262345FD98D5B497577694B6207B424A6D657BC',
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
            return $this->redirect(['index']); 
        }

        try {
            Yii::$app->db2->createCommand()->insert('fdh_token', [
                'token_dt' => date('Y-m-d H:i:s'),
                'token' => $response,
                'staff_id' => 'yoo',
            ])->execute();

            Yii::$app->session->setFlash('success', 'New token สร้างสำเร็จ- Yoo');
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', "Database Error: " . $e->getMessage());
        }

        return $this->redirect(['index', 'date1' => $date1, 'date2' => $date2]);
    }
	#################################################################################################
    public function actionExports()
    {
        $baseDirectory = 'uploads/fdh_ipd/';
        $currentDateTime = date('Ymd_His');
        $zipFilename = $baseDirectory . 'F16_10953_IpAE_' . $currentDateTime . '.zip';

        // Create a new ZipArchive instance
        $zip = new \ZipArchive();

        // Open the zip file for writing
        if ($zip->open($zipFilename, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return 'Cannot open zip file for writing';
        }

        // Add a 'fdh_opd' folder to the zip
        $folderInZip = 'fdh_ipd/';
        
        // Add files to the 'fdh_opd' folder in the zip file
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($baseDirectory),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            // Skip directories (they are added automatically)
            if (!$file->isDir()) {
                // Get real path for current file
                $filePath = $file->getRealPath();

                // Create a relative path inside the zip file
                $relativePath = $folderInZip . basename($filePath);

                // Add the file to the archive
                $zip->addFile($filePath, $relativePath);
            }
        }

        // Close the zip file
        $zip->close();

        // Set the headers to force download
        Yii::$app->response->sendFile($zipFilename, basename($zipFilename), [
            'mimeType' => 'application/zip',
            'inline' => false,
        ])->send();

        // Optional: Delete the zip file after sending it
         unlink($zipFilename);

        return;
    }
}
