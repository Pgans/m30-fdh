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
use  app\models\Fdhancus;
use app\models\LogFdhOpd;
use yii\data\ArrayDataProvider;
use yii\db\Expression;



class F16ancusController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $data = Yii::$app->request->post();
        $date1 = isset($data['date1']) ? date('Y-m-d 00:01', strtotime($data['date1'])) : '';
        $date2 = isset($data['date2']) ? date('Y-m-d 23:59', strtotime($data['date2'])) : '';

        // print_r($date1);
        $sqlData = "SELECT 
        @n := @n + 1 AS 'No',
        data.*
      FROM 
      (SELECT
        DATE_FORMAT(o.reg_datetime, '%Y-%m-%d %H:%i') as 'regdate'
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
					log.messagecode,
                    left(o.claim_code,9) as claim_code,
					IFNULL(ak.claimcode, '') AS claimcode
          FROM  opd_visits o 
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
		  LEFT JOIN prescriptions ps on ps.visit_id = o.visit_id AND ps.is_cancel = 0 AND ps.drug_id in ('2280','0664','0263','0491','2358','0262')
		  LEFT JOIN main_inscls f ON o.INSCL = f.INSCL
		  LEFT JOIN uc_inscl g ON c.CID= g.CID AND (g.date_abort > date(o.REG_DATETIME) OR DAY(g.DATE_ABORT)=0)  and trim(g.hospmain) <>''
		  LEFT JOIN hosp_sss h ON c.CID=h.CID AND (h.date_abort > date(o.REG_DATETIME) OR DAY(h.DATE_ABORT) = 0 )and trim(h.HOSP_ID) <>''  
          LEFT JOIN authen_kiosk ak ON p.CID = ak.cid  AND date(o.REG_DATETIME)=date(ak.d_update)
		  LEFT JOIN log_fdh_opd_ck   as log ON log.visit_id = o.visit_id
          WHERE o.IS_CANCEL = 0
				AND o.REG_DATETIME BETWEEN '$date1' AND '$date2'
				AND o.INSCL in ('03','04','33')
                #AND g.hospmain = '10953'
                AND icd.icd10_tm in ('z340','z348') 
                AND SUBSTRING(o.claim_code,9,1) = '/'   
				AND o.visit_id not in (SELECT ipd_reg.visit_id from ipd_reg WHERE ipd_reg.is_cancel=0)
				#AND o.visit_id  not in (SELECT vs.visit_id from log_all.log_fdh_opd vs )
				GROUP BY o.VISIT_ID
				#ORDER BY No DESC , e.unit_id
                ) AS data,
                (SELECT @n := 0) AS init
        ORDER BY  No DESC 
            ";
			 $rawData = \Yii::$app->db2->createCommand($sqlData)->queryAll();

        $sqlCount1 = "SELECT COUNT( v.visit_id) as amount
        FROM log_fdh_opd_ck v 
        WHERE  v.users = 'ancus' AND v.messagecode <> ''
				#AND v.messages = 'waited'
        AND v.d_update BETWEEN CURDATE() AND NOW()";

        $data = \yii::$app->db2->createCommand($sqlCount1)->queryAll();
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
        FROM log_fdh_opd_ck l 
        WHERE l.d_update BETWEEN CURDATE() AND NOW()
        AND l.messagecode <> '' AND l.users = 'ancus'
        ORDER BY l.d_update DESC
         ";
        $rawData = \Yii::$app->db2->createCommand($sqlPass)->queryAll();
       $sqlPass = "select l.id, l.visit_id, l.pid , l.messagecode, l.response, l.users, l.d_update
       FROM log_fdh_opd_ck l 
       WHERE l.d_update BETWEEN CURDATE() AND NOW()
       AND l.messagecode <> '' AND l.users = 'ancus'
       ORDER BY l.d_update DESC
       
        ";
       $rawData = \Yii::$app->db2->createCommand($sqlPass)->queryAll();

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
       AND l.messagecode <> 'success' AND l.users = 'ancus'
       ORDER BY l.d_update DESC
       
        ";
         
        $rawData = \Yii::$app->db2->createCommand($sqlPass)->queryAll();

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
        FROM log_fdh_opd_ck l 
        WHERE l.d_update BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()
        AND l.messagecode <> 'success' AND l.users = 'ancus'
        ORDER BY l.d_update DESC
        
         ";
        $rawData = \Yii::$app->db2->createCommand($sqlError)->queryAll();

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
###################################################################################################
  public function actionData()
{
    $vn = Yii::$app->request->post('chkDel', []);
    $visits = [];

    foreach ($vn as $r) {
        $hn = substr($r, 10);
        $visit = substr($r, 0, 10);
        $visits[] = $visit;
        $db2 = \Yii::$app->db2;

        $baseDirectory = 'uploads/fdh_opd/';
        $mode = 0777;

        $tables = ['adp', 'ins', 'odx', 'oop', 'opd', 'pat', 'cha', 'cht'];
        $fileData = [];
        $emptyTables = []; // ใช้เก็บชื่อแฟ้มที่ว่าง
/*
        foreach ($tables as $table) {
            $query = "SELECT main_query FROM fdh_ancus WHERE main_table = '$table'";
            $results = $db2->createCommand($query)->queryAll();
*/
##################################################################
    foreach ($tables as $table) {
    // ตรวจสอบเงื่อนไขพิเศษ
    if ($table === 'pat') {
        $query = "SELECT main_query FROM fdh_pat WHERE main_table = 'pat'";
        $results = $db2->createCommand($query)->queryAll();
    } else {
        // ตรวจสอบว่ามีใน fdh_ins หรือไม่
        $queryIns = "SELECT main_query FROM fdh_ins WHERE main_table = :table";
        $results = $db2->createCommand($queryIns)
            ->bindValue(':table', $table)
            ->queryAll();

        // ถ้าไม่มีข้อมูลใน fdh_ins ให้ใช้จาก fdh_herb
        if (empty($results)) {
            $queryHerb = "SELECT main_query FROM fdh_ancus WHERE main_table = :table";
            $results = $db2->createCommand($queryHerb)
                ->bindValue(':table', $table)
                ->queryAll();
        }
    }
#############################################################################
            foreach ($results as $result) {
                $mainQueryResult = $result['main_query'];
                $mainQueryResult = str_replace('$visit', $visit, $mainQueryResult);
                $data = $db2->createCommand($mainQueryResult)->queryAll();

                // Store data
                if (!isset($fileData[$table])) {
                    $fileData[$table] = [];
                }
                $fileData[$table] = array_merge($fileData[$table], $data);
            }

            // ตรวจสอบว่าข้อมูลในแฟ้มว่างหรือไม่
            if (empty($fileData[$table])) {
                $emptyTables[] = $table; // เพิ่มชื่อแฟ้มที่ว่าง
            }
        }

        // แจ้งเตือนถ้ามีแฟ้มว่าง
        if (!empty($emptyTables)) {
            $emptyTablesList = implode(', ', $emptyTables);
            Yii::$app->session->setFlash(
                'error',
                "❌ ไม่มีข้อมูลในแฟ้ม: [$emptyTablesList] สำหรับ HN: $hn, Visit ID: $visit"
            );
            return $this->redirect(['index']); // กลับหน้าเดิม
        }

        // Export ข้อมูลไปยังไฟล์
        foreach ($fileData as $table => $data) {
            $filePath = $baseDirectory . strtoupper($table) . '.txt';
            $header = $this->getHeaderForTable($table);
            $this->exportToTextFile($data, $filePath, $header);

            // Remove duplicates and convert to Windows CRLF for PAT.txt after exporting
            if ($table === 'pat') {
                $this->removeDuplicatesFromFile($filePath);
                $this->convertToWindowsCrLf($filePath);
            }
        }

        // ส่งข้อมูลไปยัง API สำหรับ visit ปัจจุบัน
        $this->sendDataToAPI($visit, $hn);
    }

    // เก็บค่าไว้ใน session
    Yii::$app->session->set('visits', $visits);
    Yii::$app->session->set('hn', $hn);

    return $this->redirect(['index']);
}



protected function removeDuplicatesFromFile($filePath)
{
    // Read the file
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    // Initialize variables
    $header = array_shift($lines); // Assuming the first line is the header
    $uniqueData = [];
    $newLines = [$header]; // Start with header line

    // Process lines
    foreach ($lines as $line) {
        $fields = explode("|", $line); // Assuming pipe-separated values
        $personId = $fields[9]; // Adjust index if 'person_id' is not the 10th field (index 9)
        if (!isset($uniqueData[$personId])) {
            $uniqueData[$personId] = $line;
            $newLines[] = $line;
        }
    }

    // Write back the unique data to the file
    file_put_contents($filePath, implode("\n", $newLines));
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
    $sqltoken = "SELECT MAX(token) as token30 FROM fdh_token WHERE staff_id = 'nim'";
    $data = Yii::$app->db2->createCommand($sqltoken)->queryOne();

    if ($data && isset($data['token30'])) {
        $token30 = $data['token30'];

        $filePaths = [
            __DIR__ . '/../web/uploads/fdh_opd/PAT.txt',
            __DIR__ . '/../web/uploads/fdh_opd/INS.txt',
            __DIR__ . '/../web/uploads/fdh_opd/OPD.txt',
            __DIR__ . '/../web/uploads/fdh_opd/ADP.txt',
            __DIR__ . '/../web/uploads/fdh_opd/ODX.txt',
		    __DIR__ . '/../web/uploads/fdh_opd/OOP.txt',
            __DIR__ . '/../web/uploads/fdh_opd/CHA.txt',
            __DIR__ . '/../web/uploads/fdh_opd/CHT.txt',
        ];
// สร้าง HTTP client และส่งคำขอ ## https://fdh.moph.go.th/api/v2/data_hub/16_files  ***  https://uat-fdh.inet.co.th/api/v2/data_hub/16_files
        $client = new Client();
        $request = $client->createRequest()
            ->setMethod('POST')
            ->setUrl('https://fdh.moph.go.th/api/v2/data_hub/16_files')
            ->addHeaders([
                'Authorization' => 'Bearer ' . $token30,
                'Content-Type' => 'multipart/form-data',
            ]);

        // Add files to the request
        foreach ($filePaths as $filePath) {
            if (file_exists($filePath)) {
                $request->addFile('file', $filePath, ['content-type' => 'text/plain']);
            }
        }

        // Add additional data to the request
        $request->addData([
            'key' => 'value',
            'type' => 'txt',
        ]);

        // Send the request and get the response
        $response = $request->send();
        $responseData = json_decode($response->getContent(), true);

        $message_th = isset($responseData['message_th']) ? $responseData['message_th'] : '';

        // Check the status of the request
        if ($response->isOk) {
            Yii::$app->session->setFlash('success', 'ส่งข้อมูลสำเร็จ.');
        } else {
            $errorMessage = "Error: " . $response->getStatusCode() . " " . $response->getContent() . " สำหรับ visit: " . $visit;
            Yii::$app->session->setFlash('error', $errorMessage);
        }

        // Read data from CHT.txt
        $chtFilePath = __DIR__ . '/../web/uploads/fdh_opd/CHT.txt';
        if (file_exists($chtFilePath)) {
            $file = fopen($chtFilePath, 'r');
            $header = fgetcsv($file, 0, "|"); // Read the header
            while ($row = fgetcsv($file, 0, "|")) {
                $rowData = array_combine($header, $row); // Combine header and row to associative array
                $hn = $rowData['HN'];
                $visit = $rowData['SEQ'];
                $datereg = $rowData['DATE'];

                // Prepare data for the API request
                $postData = json_encode([
                    "hcode" => "10953",
                    "hn" => $hn,
                    "seq" => $visit,
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

                // Check if visit_id exists in the table
                $logSQLCheck = "SELECT COUNT(*) FROM log_fdh_opd_ck WHERE visit_id = :visit_id";
                $visitCount = Yii::$app->db2->createCommand($logSQLCheck)
                    ->bindValue(':visit_id', $visit)
                    ->queryScalar();

                    if ($visitCount > 0) {
                        // Update if the visit exists
                        $logSQLUpdate = "UPDATE log_fdh_opd_ck SET pid = :pid, messages = :messages, messagecode = :messagecode, response = :response,
                         users = 'ancus', datereg = :datereg, d_update = NOW() WHERE visit_id = :visit_id";
                        Yii::$app->db2->createCommand($logSQLUpdate)
                            ->bindValue(':pid', $hn)
                            ->bindValue(':messages', $messages)
                            ->bindValue(':messagecode', $statusMessageTh)
                            ->bindValue(':response', $response)
                            ->bindValue(':visit_id', $visit)
                            ->bindValue(':datereg', $datereg)
                            ->execute();
                    } else {
                        // Insert if the visit does not exist
                        $logSQLInsert = "INSERT INTO log_fdh_opd_ck (visit_id, pid, messages, messagecode, response, users, datereg, d_update) 
                        VALUES (:visit_id, :pid, :messages, :messagecode, :response, 'ancus',:datereg ,NOW())";
                        Yii::$app->db2->createCommand($logSQLInsert)
                            ->bindValue(':visit_id', $visit)
                            ->bindValue(':pid', $hn)
                            ->bindValue(':messages', $messages)
                            ->bindValue(':messagecode', $statusMessageTh)
                            ->bindValue(':response', $response)
                            ->bindValue(':datereg', $datereg)
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

    

   ############################## เปิดการอ่านไฟล์ ################################################
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

if (file_exists($filePath)) {
    // โหลดเนื้อหาจากไฟล์
    $fileContent = file_get_contents($filePath);

    // เรนเดอร์เฉพาะเนื้อหาโดยไม่ใช้ Layout
    return $this->renderPartial('readFile', ['content' => $fileContent]);
} else {
    throw new \yii\web\NotFoundHttpException('File not found.');
}
}
###########################################################################################################
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

        return $this->asJson($visits); 
    }

    public function actionRunCurl()
    {
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
                'user' => 'junmane.10953',
                'password_hash' => '3F541928B150EAC5BDE327244143DC69E00E2D73426AB038D1D422646E42D499',
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
                'staff_id' => 'nim',
            ])->execute();

            Yii::$app->session->setFlash('success', 'New token สร้างสำเร็จ');
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', "Database Error: " . $e->getMessage());
        }

        return $this->redirect(['index']); // กลับไปยังหน้าเว็บที่ต้องการ
    }
	public function actionExports()
    {
        $baseDirectory = 'uploads/fdh_opd/';
        $currentDateTime = date('Ymd_His');
        $zipFilename = $baseDirectory . 'F16_10953_Ancus_' . $currentDateTime . '.zip';

        // Create a new ZipArchive instance
        $zip = new \ZipArchive();

        // Open the zip file for writing
        if ($zip->open($zipFilename, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return 'Cannot open zip file for writing';
        }

        // Add a 'fdh_opd' folder to the zip
        $folderInZip = 'fdh_opd/';
        
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
