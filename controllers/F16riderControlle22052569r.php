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


class F16riderController extends \yii\web\Controller
{
    public function actionIndex()
    {
       $date1x = Yii::$app->request->get('date1', date('Y-m-d'));
	   $date2x = Yii::$app->request->get('date2', date('Y-m-d'));

	   $date1 = date('Y-m-d 00:01', strtotime($date1x));
	   $date2 = date('Y-m-d 23:59', strtotime($date2x));
       
        // print_r($date1);
        $sqlData = "SELECT 
        @n := @n + 1 AS 'No',
        data.*
      FROM 
(SELECT 
        DATE_FORMAT(o.reg_datetime, '%Y-%m-%d %H:%i') AS 'regdate',
        o.visit_id,
        o.hn,
        CONCAT(
           CASE 
              WHEN p.PRENAME != '' THEN TRIM(p.PRENAME)
              WHEN TIMESTAMPDIFF(year, p.BIRTHDATE, NOW()) < 20 AND p.sex = '1' AND p.MARRIAGE = '4' THEN 'สามเณร'
              WHEN TIMESTAMPDIFF(year, p.BIRTHDATE, NOW()) >= 20 AND p.sex = '1' AND p.MARRIAGE = '4' THEN 'พระภิกษุ'
              WHEN TIMESTAMPDIFF(year, p.BIRTHDATE, NOW()) < 15 AND p.sex = '1' THEN 'เด็กชาย'
              WHEN TIMESTAMPDIFF(year, p.BIRTHDATE, NOW()) >= 15 AND p.sex = '1' THEN 'นาย'
              WHEN TIMESTAMPDIFF(year, p.BIRTHDATE, NOW()) < 15 AND p.sex = '2' THEN 'เด็กหญิง'
              WHEN TIMESTAMPDIFF(year, p.BIRTHDATE, NOW()) >= 15 AND p.sex = '2' AND p.MARRIAGE = '1' THEN 'นางสาว'
              ELSE 'นาง'
           END,
           TRIM(p.FNAME), ' ', TRIM(p.LNAME)) AS 'fullname',
        TIMESTAMPDIFF(year, p.BIRTHDATE, o.REG_DATETIME) AS 'age',
        p.cid,
        icd1.ICD10_TM AS Diagx,
		o.BP_SYST as SBP,
		o.BP_DIAS as DBP,
		SUBSTRING(
    SUBSTRING_INDEX(lr.lab_result, '=', -1),
    1,
    LOCATE(' ', SUBSTRING_INDEX(lr.lab_result, '=', -1)) - 1
  ) AS 'FBS',
        LEFT(GROUP_CONCAT(DISTINCT TRIM(icd.ICD10_TM)), 30) AS Diag,
        LEFT(e.unit_name, 10) AS 'unit_name',
        f.INSCL_NAME AS 'inscl',
        '50.00' AS amount,
        g.hospmain, g.hospsub,
         log.messagecode,
		 IFNULL(cl.claimcode, '') AS endpoint,
        IFNULL(ak.claimcode, '') AS claimcode
 FROM 
      opd_visits o
      INNER JOIN cid_hn c ON o.HN = c.HN
      INNER JOIN population p ON c.CID = p.CID AND LEFT(p.cid, 5) <> '00000'
      INNER JOIN opd_diagnosis d ON d.visit_id = o.visit_id AND d.is_cancel = 0
      LEFT JOIN icd10new icd ON icd.icd10 = d.icd10 AND icd.icd10 <> ''
      INNER JOIN opd_diagnosis d1 ON d1.visit_id = o.visit_id AND d1.is_cancel = 0 AND d1.dxt_id = 1
      LEFT JOIN icd10new icd1 ON icd1.icd10 = d1.icd10 AND icd1.icd10 <> ''
      LEFT JOIN ipd_reg ir ON ir.VISIT_ID = o.visit_id AND ir.IS_CANCEL = 0
	  LEFT JOIN lab_requests lr ON lr.visit_id = o.visit_id AND lr.is_cancel = 0 
      LEFT JOIN lab_lists l ON l.lab_id = lr.lab_id 
      LEFT JOIN service_units e ON o.UNIT_REG = e.unit_id
      LEFT JOIN main_inscls f ON o.INSCL = f.INSCL
      LEFT JOIN uc_inscl g ON c.CID = g.CID AND (g.date_abort > DATE(o.REG_DATETIME) OR DAY(g.DATE_ABORT) = 0) AND TRIM(g.hospmain) <> ''
      LEFT JOIN authen_kiosk ak ON p.CID = ak.cid AND ak.visit_id = o.visit_id
      INNER JOIN opd_operations op ON o.VISIT_ID=op.VISIT_ID AND op.IS_CANCEL = 0 AND op.icd9 = '0000016301'
      LEFT JOIN log_fdh_opd_ck   as log ON log.visit_id = o.visit_id
	  LEFT JOIN close_visits  cl ON cl.visit_id = o.visit_id
 WHERE o.IS_CANCEL = 0
       AND o.REG_DATETIME BETWEEN '$date1' AND '$date2'
       AND o.INSCL in ('03','04','33','00','23')
       AND o.visit_id NOT IN (SELECT ipd_reg.visit_id FROM ipd_reg WHERE ipd_reg.is_cancel = 0)
 GROUP BY o.visit_id
 ) AS data,
        (SELECT @n := 0) AS init
      ORDER BY 
        No DESC  

 
            ";
        $rawData = \Yii::$app->db2->createCommand($sqlData)->queryAll();
		
		$sqlDup = "SELECT k.hn, COUNT(k.visit_id) AS count_hn
FROM
(
    SELECT o.hn, o.visit_id
    FROM opd_visits o
    INNER JOIN cid_hn c ON o.HN = c.HN
    INNER JOIN population p ON c.CID = p.CID AND LEFT(p.cid, 5) <> '00000'
    INNER JOIN opd_diagnosis d ON d.visit_id = o.visit_id AND d.is_cancel = 0
    INNER JOIN opd_diagnosis d1 ON d1.visit_id = o.visit_id AND d1.is_cancel = 0 AND d1.dxt_id = 1
    INNER JOIN opd_operations op ON o.visit_id = op.visit_id AND op.is_cancel = 0 AND op.icd9 = '0000016301'
    LEFT JOIN icd10new icd ON icd.icd10 = d.icd10 AND icd.icd10 <> ''
    LEFT JOIN icd10new icd1 ON icd1.icd10 = d1.icd10 AND icd1.icd10 <> ''
    LEFT JOIN ipd_reg ir ON ir.visit_id = o.visit_id AND ir.is_cancel = 0
    LEFT JOIN service_units e ON o.unit_reg = e.unit_id
    LEFT JOIN main_inscls f ON o.inscl = f.inscl
    LEFT JOIN uc_inscl g ON c.cid = g.cid 
        AND (g.date_abort > DATE(o.reg_datetime) OR DAY(g.date_abort) = 0) 
        AND TRIM(g.hospmain) <> ''
    LEFT JOIN authen_kiosk ak ON p.cid = ak.cid
    LEFT JOIN log_fdh_opd_ck log ON log.visit_id = o.visit_id
    WHERE o.is_cancel = 0
      AND o.reg_datetime BETWEEN '$date1' AND '$date2'
      AND o.inscl IN ('03','04','33','00','23')
      AND o.visit_id NOT IN (
            SELECT visit_id FROM ipd_reg WHERE is_cancel = 0
      )
    GROUP BY o.visit_id
) AS k
GROUP BY k.hn
HAVING count_hn > 1
ORDER BY count_hn DESC;
";

        $dupHns = Yii::$app->db2->createCommand($sqlDup)->queryAll();


        $sqlCount1 = "SELECT COUNT( v.visit_id) as amount
        FROM log_fdh_opd_ck v 
        WHERE  v.users = 'rider' AND v.messagecode <> ''
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
        AND l.messagecode <> '' AND l.users = 'rider'
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
        AND l.messagecode <> 'success' AND l.users = 'rider'
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
			'data' => $data,
			'dupHns' => $dupHns,
            'total' => count($data),
			'date1' => $date1,
			'date2' => $date2,
          
        ]);
    }
    private $visit;
    private $hn;
    #############################################################################################
  public function actionData()
{
    $date1 = Yii::$app->request->post('date1');
    $date2 = Yii::$app->request->post('date2'); 
	
    $vn = Yii::$app->request->post('chkDel', []);
    $baseDirectory = 'uploads/fdh_opd/';
    $tables = ['adp', 'ins', 'dru', 'odx', 'oop', 'opd', 'pat', 'cha', 'cht'];
    
    $db2 = Yii::$app->db2;

    $lastVisit = null;
    $lastHn = null;

    foreach ($vn as $r) {
        $hn = substr($r, 10);
        $visit = substr($r, 0, 10);
        $lastVisit = $visit; // เก็บไว้ใช้หลังลูป
        $lastHn = $hn;

        $fileData = [];

        foreach ($tables as $table) {
            if ($table === 'pat') {
                $query = "SELECT main_query FROM fdh_pat WHERE main_table = 'pat'";
                $results = $db2->createCommand($query)->queryAll();
            } else {
                $queryIns = "SELECT main_query FROM fdh_ins WHERE main_table = :table";
                $results = $db2->createCommand($queryIns)
                    ->bindValue(':table', $table)
                    ->queryAll();

                if (empty($results)) {
                    $queryRider = "SELECT main_query FROM fdh_rider WHERE main_table = :table";
                    $results = $db2->createCommand($queryRider)
                        ->bindValue(':table', $table)
                        ->queryAll();
                }
            }

            foreach ($results as $result) {
                $mainQuery = str_replace('$visit', $visit, $result['main_query']);
                $data = $db2->createCommand($mainQuery)->queryAll();

                if ($table === 'pat') {
                    $uniqueData = [];
                    foreach ($data as $row) {
                        $personId = $row['person_id'];
                        if (!isset($uniqueData[$personId])) {
                            $uniqueData[$personId] = $row;
                        }
                    }
                    $data = array_values($uniqueData);
                }

                if (!isset($fileData[$table])) {
                    $fileData[$table] = [];
                }
                $fileData[$table] = array_merge($fileData[$table], $data);
            }
        }

        foreach ($fileData as $table => $data) {
            $filePath = $baseDirectory . strtoupper($table) . '.txt';
            $header = $this->getHeaderForTable($table);
            $this->exportToTextFile($data, $filePath, $header);
        }

        $this->sendDataToAPI($visit, $hn, $baseDirectory);
    }

    Yii::$app->session->setFlash('success', 'ส่งข้อมูลสำเร็จ');

    // Redirect กลับพร้อม date1, date2, visit ล่าสุด, hn ล่าสุด
    return $this->redirect([ 'index',   'date1' => $date1, 'date2' => $date2,  'visit' => $lastVisit, 'hn' => isset($lastHn) ? $lastHn : null]);
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

   private function sendDataToAPI($visit, $hn, $baseDirectory)
{
    $sqltoken = "SELECT MAX(token) as token30 FROM fdh_token WHERE staff_id = 'nim'";
    $data = Yii::$app->db2->createCommand($sqltoken)->queryOne();

    if ($data && isset($data['token30'])) {
        $token30 = $data['token30'];

        $tables = ['PAT', 'INS', 'DRU', 'OPD', 'OOP', 'ADP', 'ODX', 'CHA', 'CHT'];
        $filePaths = [];
        foreach ($tables as $t) {
            $file = $baseDirectory . "$t.txt";
            if (file_exists($file)) {
                $filePaths[] = $file;
            }
        }
// สร้าง HTTP client และส่งคำขอ ## https://fdh.moph.go.th/api/v2/data_hub/16_files  ***  https://uat-fdh.inet.co.th/api/v2/data_hub/16_files
        $client = new Client();
        $request = $client->createRequest()
            ->setMethod('POST')
            ->setUrl('https://fdh.moph.go.th/api/v2/data_hub/16_files')
            ->addHeaders([
                'Authorization' => 'Bearer ' . $token30,
                'Content-Type' => 'multipart/form-data',
            ]);

        foreach ($filePaths as $filePath) {
            $request->addFile('file', $filePath, ['content-type' => 'text/plain']);
        }

        $request->addData([
            'type' => 'txt',
        ]);

        $response = $request->send();
        $responseData = json_decode($response->getContent(), true);
        $message_th = $responseData['message_th'] ?? '';

        if (!$response->isOk) {
            Yii::$app->session->addFlash('error', "ส่งข้อมูลไม่สำเร็จ: $message_th ($visit)");
            return;
        }

        // อ่าน CHT.txt เพื่อเก็บ log
        $chtFile = $baseDirectory . 'CHT.txt';
        if (!file_exists($chtFile)) return;

        $file = fopen($chtFile, 'r');
        $header = fgetcsv($file, 0, "|");

        while ($row = fgetcsv($file, 0, "|")) {
            $rowData = array_combine($header, $row);
            $hn = $rowData['HN'];
            $visit_id = $rowData['SEQ'];
            $datereg = $rowData['DATE'];

            $trackPayload = json_encode([
                "hcode" => "10953",
                "hn" => $hn,
                "seq" => $visit_id,
                "transaction_uid" => ""
            ]);

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://fdh.moph.go.th/api/v1/ucs/track_trans',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_POSTFIELDS => $trackPayload,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "Authorization: Bearer " . $token30
                ],
            ]);
            $trackRes = curl_exec($curl);
            curl_close($curl);

            $resDecoded = json_decode($trackRes, true);
            $messages = $resDecoded['data'][0]['status'] ?? '';
            $statusMessageTh = $resDecoded['data'][0]['status_message_th'] ?? '';

            // Insert or update log
            $db = Yii::$app->db2;
            $visitExists = $db->createCommand("SELECT COUNT(*) FROM log_fdh_opd_ck WHERE visit_id = :visit_id")
                ->bindValue(':visit_id', $visit_id)
                ->queryScalar();

            if ($visitExists) {
                $db->createCommand("UPDATE log_fdh_opd_ck SET pid=:pid, messages=:messages, messagecode=:messagecode, response=:response, users='rider', datereg=:datereg, d_update=NOW() WHERE visit_id=:visit_id")
                    ->bindValues([
                        ':pid' => $hn,
                        ':messages' => $messages,
                        ':messagecode' => $statusMessageTh,
                        ':response' => $trackRes,
                        ':visit_id' => $visit_id,
                        ':datereg' => $datereg
                    ])->execute();
            } else {
                $db->createCommand("INSERT INTO log_fdh_opd_ck (visit_id, pid, messages, messagecode, response, users, datereg, d_update) VALUES (:visit_id, :pid, :messages, :messagecode, :response, 'rider', :datereg, NOW())")
                    ->bindValues([
                        ':visit_id' => $visit_id,
                        ':pid' => $hn,
                        ':messages' => $messages,
                        ':messagecode' => $statusMessageTh,
                        ':response' => $trackRes,
                        ':datereg' => $datereg
                    ])->execute();
            }
        }

        fclose($file);
    } else {
        Yii::$app->session->addFlash('error', 'ไม่พบ token สำหรับส่งข้อมูล');
    }
}



    
################################################################################################
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
                FROM log_fdh_opd v 
        INNER JOIN jhcisdb.fittest f ON f.seq = v.visit_id
                WHERE v.users = 'rider'
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

            Yii::$app->session->setFlash('success', 'New token สร้างสำเร็จ-NIM');
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', "Database Error: " . $e->getMessage());
        }

    return $this->redirect(['index', 'date1' => $date1, 'date2' => $date2]);
}
}