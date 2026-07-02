<?php

namespace app\controllers;

use Yii;
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
use app\models\FdhHurbnew;
use app\models\LogFdhOpd;
use yii\data\ArrayDataProvider;
use yii\db\Expression;

class F16herbnewController extends \yii\web\Controller
{
    public function actionIndex()
{
    // ย้อนหลัง 5 วัน
    $date1x = Yii::$app->request->get('date1', date('Y-m-d', strtotime('-5 days')));
    $date2x = Yii::$app->request->get('date2', date('Y-m-d'));

    $statusFilter = Yii::$app->request->get('status', 'all'); // all | success | waiting

    $date1 = date('Y-m-d 00:01', strtotime($date1x));
    $date2 = date('Y-m-d 23:59', strtotime($date2x));

        // ==========================================
        // SQL หลัก: ดึงข้อมูลทั้งหมดในช่วงวันที่
        // ==========================================
        $sqlData = "SELECT 
    @n := @n + 1 AS 'No',
    data.*
FROM (
    SELECT *
    FROM (
        SELECT 
            o.REG_DATETIME,
            o.HN,
            GROUP_CONCAT(DISTINCT TRIM(d.DRUG_NAME)) AS 'Herb',
            cv.ret_statement,
            cv.hosp_claim,
            cv.stm_claim,
            cv.tran_id,
            cv.rep_no,
            o.VISIT_ID,
            CONCAT(
                CASE 
                    WHEN c.PRENAME <> '' THEN TRIM(c.PRENAME)
                    WHEN TIMESTAMPDIFF(YEAR,c.BIRTHDATE,NOW()) < 20 AND c.sex='1' AND c.MARRIAGE='4' THEN 'สามเณร'
                    WHEN TIMESTAMPDIFF(YEAR,c.BIRTHDATE,NOW()) >= 20 AND c.sex='1' AND c.MARRIAGE='4' THEN 'พระภิกษุ'
                    WHEN TIMESTAMPDIFF(YEAR,c.BIRTHDATE,NOW()) < 15 AND c.sex='1' THEN 'เด็กชาย'
                    WHEN TIMESTAMPDIFF(YEAR,c.BIRTHDATE,NOW()) >= 15 AND c.sex='1' THEN 'นาย'
                    WHEN TIMESTAMPDIFF(YEAR,c.BIRTHDATE,NOW()) < 15 AND c.sex='2' THEN 'เด็กหญิง'
                    WHEN TIMESTAMPDIFF(YEAR,c.BIRTHDATE,NOW()) >= 15 AND c.sex='2' AND c.MARRIAGE='1' THEN 'นางสาว'
                    ELSE 'นาง'
                END,
                TRIM(c.FNAME),'  ',TRIM(c.LNAME)
            ) AS fullname,
            TIMESTAMPDIFF(YEAR,c.BIRTHDATE,o.REG_DATETIME) AS age,
            icd.ICD10_TM AS Diagx,
			cv.sub_fund AS fund,
			 COALESCE((
			cv.cg01 + cv.cg02 + cv.cg03 + cv.cg04 + cv.cg05 +
			cv.cg06 + cv.cg07 + cv.cg08 + cv.cg09 + cv.cg10 +
			cv.cg11 + cv.cg12 + cv.cg13 + cv.cg14 + cv.cg15 +
			cv.cg16 + cv.cg17 + cv.cg18 + cv.cg19
			), 0.00) AS amount,
            f.INSCL_NAME AS inscl,
            hp.hosp_name,
            g.hospmain,
            g.hospsub,
            LEFT(e.unit_name,10) AS unit_name,
            log.messagecode,
            IFNULL(cl.claimcode,'') AS endpoint,
            IFNULL(ak.claimcode,'') AS claimcode
        FROM opd_visits o 
        LEFT JOIN cost_visits cv ON o.VISIT_ID=cv.visit_id  AND cv.is_cancel = 0
        LEFT JOIN cid_hn b ON o.HN=b.HN
        LEFT JOIN population c ON b.CID=c.CID
        INNER JOIN prescriptions p ON p.visit_id=o.visit_id AND p.DRUG_ID NOT IN ('0371','0372','0369')
        INNER JOIN visit_invoice v ON v.visit_id=o.visit_id  
        INNER JOIN drugs d ON d.drug_id=p.DRUG_ID AND d.drug_id=v.drug_id
        INNER JOIN opd_diagnosis od ON od.visit_id=o.visit_id AND od.is_cancel=0 AND od.dxt_id=1
        LEFT JOIN icd10new icd ON icd.icd10=od.icd10 AND icd.icd10<>''
        LEFT JOIN main_inscls f ON o.INSCL=f.INSCL
        LEFT JOIN service_units e ON o.UNIT_REG=e.unit_id
        LEFT JOIN authen_kiosk ak ON c.CID=ak.cid AND o.visit_id=ak.visit_id
        LEFT JOIN log_fdh_opd_ck log ON log.visit_id=o.visit_id
        LEFT JOIN close_visits cl ON cl.visit_id=o.visit_id
        LEFT JOIN uc_inscl g ON c.CID=g.CID AND (g.date_abort > date(o.REG_DATETIME) OR DAY(g.DATE_ABORT)=0) AND trim(g.hospmain)<>''
        LEFT JOIN hospitals hp ON hp.hosp_id=g.hospmain
        WHERE o.REG_DATETIME BETWEEN '$date1' AND '$date2'
          AND o.visit_id NOT IN (SELECT visit_id FROM ipd_reg WHERE is_cancel=0)
          AND o.visit_id NOT IN (SELECT visit_id FROM mobile_visits WHERE is_cancel=0)
          AND (d.is_herb='1' OR v.chrgitem='21' OR v.drug_id='1791')
          AND p.RX_AMOUNT<>'0'
          AND p.is_cancel=0
          AND o.INSCL IN ('03','04','33','00','23')
          AND v.is_cancel=0
          AND o.IS_CANCEL=0
        GROUP BY o.VISIT_ID
        ORDER BY cv.ret_statement, o.REG_DATETIME
    ) T
    WHERE T.Herb <> ''
) data,
(SELECT @n := 0) init
ORDER BY No ASC";

        $allData = \Yii::$app->db2->createCommand($sqlData)->queryAll();

        // ==========================================
        // นับสรุปสำหรับ Card
        // ==========================================
        $isSent    = function($r) { return isset($r['messagecode']) && $r['messagecode'] !== null && $r['messagecode'] !== ''; };
        $isWaiting = function($r) { return !isset($r['messagecode']) || $r['messagecode'] === null || $r['messagecode'] === ''; };

        $totalMonth     = count($allData);
        $claimedMonth   = count(array_filter($allData, $isSent));
        $remainingMonth = count(array_filter($allData, $isWaiting));

        // ==========================================
        // กรองรายการตาม status + reverse (ใหม่สุดบน)
        // ==========================================
        $filteredData = array_reverse($allData);
        if ($statusFilter === 'success') {
            $filteredData = array_reverse(array_values(array_filter($allData, $isSent)));
        } elseif ($statusFilter === 'waiting') {
            $filteredData = array_reverse(array_values(array_filter($allData, $isWaiting)));
        }

        // ==========================================
        // นับผ่านวันนี้
        // ==========================================
        $sqlCount1 = "SELECT COUNT(v.visit_id) as amount
            FROM log_fdh_opd_ck v 
            WHERE v.users = 'herbnew' AND v.messagecode <> ''
            AND v.d_update BETWEEN CURDATE() AND NOW()";
        $dataToday = \Yii::$app->db2->createCommand($sqlCount1)->queryAll();
        $amount = $dataToday[0]['amount'] ?? 0;

        // ==========================================
        // DataProvider (กรองแล้ว)
        // ==========================================
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels'  => $filteredData,
            'pagination' => ['pageSize' => 1000],
        ]);

        // ==========================================
        // Pass / Error Log
        // ==========================================
        $sqlPass = "SELECT l.id, l.visit_id, l.pid, l.messagecode, l.response, l.users, l.d_update
            FROM log_fdh_opd_ck l 
            WHERE l.d_update BETWEEN CURDATE() AND NOW()
            AND l.messagecode <> '' AND l.users = 'herbnew'
            ORDER BY l.d_update DESC";
        $passProvider = new \yii\data\ArrayDataProvider([
            'allModels'  => \Yii::$app->db2->createCommand($sqlPass)->queryAll(),
            'pagination' => ['pageSize' => 300],
        ]);

        $sqlError = "SELECT l.id, l.visit_id, l.pid, l.messagecode, l.response, l.users, l.d_update
            FROM log_fdh_opd_ck l 
            WHERE l.d_update BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()
            AND l.messagecode <> 'success' AND l.users = 'herbnew'
            ORDER BY l.d_update DESC";
        $errorProvider = new \yii\data\ArrayDataProvider([
            'allModels'  => \Yii::$app->db2->createCommand($sqlError)->queryAll(),
            'pagination' => ['pageSize' => 350],
        ]);

        return $this->render('index', [
            'dataProvider'   => $dataProvider,
            'passProvider'   => $passProvider,
            'errorProvider'  => $errorProvider,
            'amount'         => $amount,
            'totalMonth'     => $totalMonth,
            'claimedMonth'   => $claimedMonth,
            'remainingMonth' => $remainingMonth,
            'statusFilter'   => $statusFilter,
            'date1'          => substr($date1x, 0, 10),
            'date2'          => substr($date2x, 0, 10),
        ]);
    }

    // ==========================================
    // actionCheckData
    // ==========================================
    public function actionCheckData()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        try {
            $visit = Yii::$app->request->get('visit');
            $hn    = Yii::$app->request->get('hn');
            if (!$visit || !$hn) return ['success' => false, 'message' => 'ไม่พบ visit หรือ hn'];

            $db2 = \Yii::$app->get('db2', false);
            if (!$db2) return ['success' => false, 'message' => 'ไม่พบ db2 component'];
            try { $db2->open(); } catch (\Exception $e) {
                return ['success' => false, 'message' => 'เชื่อมต่อ db2 ไม่ได้: ' . $e->getMessage()];
            }

            $tables      = ['adp', 'ins', 'odx', 'opd', 'pat', 'cha', 'cht', 'dru'];
            $notRequired = ['dru'];
            $result      = [];
            $hasError    = false;

            foreach ($tables as $table) {
                $count = 0; $status = 'na'; $message = ''; $allData = [];
                try {
                    $results = $db2->createCommand("SELECT main_query FROM fdh_herbnew WHERE main_table = :t")
                        ->bindValue(':t', $table)->queryAll();
                    if (empty($results)) {
                        $required = !in_array($table, $notRequired);
                        $status   = $required ? 'no_config' : 'na';
                        $message  = 'ไม่พบ query config ใน fdh_herbnew';
                        if ($required) $hasError = true;
                    } else {
                        foreach ($results as $result_row) {
                            if (empty($result_row['main_query'])) continue;
                            $sql     = str_replace('$visit', $visit, $result_row['main_query']);
                            $data    = $db2->createCommand($sql)->queryAll();
                            $count  += count($data);
                            $allData = array_merge($allData, $data);
                        }
                        $required = !in_array($table, $notRequired);
                        if ($count > 0)      { $status = 'ok'; }
                        elseif ($required)   { $status = 'empty'; $hasError = true; }
                        else                 { $status = 'na'; }
                    }
                } catch (\Exception $e) {
                    $required = !in_array($table, $notRequired);
                    $status   = 'error'; $message = $e->getMessage();
                    if ($required) $hasError = true;
                }
                $result[] = ['table' => strtoupper($table), 'count' => $count,
                    'required' => !in_array($table, $notRequired),
                    'status' => $status, 'message' => $message, 'rows' => $allData];
            }
            return ['success' => true, 'hasError' => $hasError, 'visit' => $visit, 'hn' => $hn, 'data' => $result];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage(),
                'file' => basename($e->getFile()), 'line' => $e->getLine()];
        }
    }

    // ==========================================
    // actionData
    // ==========================================
    public function actionData()
    {
        $date1 = Yii::$app->request->post('date1');
        $date2 = Yii::$app->request->post('date2');
        $vn    = Yii::$app->request->post('chkDel', []);
        $visits = [];

        foreach ($vn as $r) {
            $hn    = substr($r, 10);
            $visit = substr($r, 0, 10);
            $visits[] = $visit;
            $db2 = \Yii::$app->db2;

            $baseDirectory = 'uploads/fdh_opd/';
            $tables   = ['adp', 'ins', 'odx', 'opd', 'pat', 'cha', 'cht', 'dru'];
            $fileData = [];
            $emptyTables = [];

            foreach ($tables as $table) {
                $query   = "SELECT main_query FROM fdh_herbnew WHERE main_table = '$table'";
                $results = $db2->createCommand($query)->queryAll();
                foreach ($results as $result) {
                    $mainQueryResult = str_replace('$visit', $visit, $result['main_query']);
                    $data = $db2->createCommand($mainQueryResult)->queryAll();
                    if (!isset($fileData[$table])) $fileData[$table] = [];
                    $fileData[$table] = array_merge($fileData[$table], $data);
                }
                if (!in_array($table, ['adp', 'dru']) && empty($fileData[$table])) {
                    $emptyTables[] = $table;
                }
            }

            if (!empty($emptyTables)) {
                $emptyTablesList = implode(', ', $emptyTables);
                Yii::$app->session->setFlash('error', "❌ ไม่มีข้อมูลในแฟ้ม: [$emptyTablesList] สำหรับ HN: $hn, VisitID: $visit");
                return $this->redirect(['index']);
            }

            foreach ($fileData as $table => $data) {
                $filePath = $baseDirectory . strtoupper($table) . '.txt';
                $header   = $this->getHeaderForTable($table);
                $this->exportToTextFile($data, $filePath, $header);
            }

            $this->sendDataToAPI($visit, $hn);
        }

        Yii::$app->session->set('visits', $visits);
        Yii::$app->session->set('hn', $hn);
        return $this->redirect(['index', 'date1' => $date1, 'date2' => $date2, 'visit' => $visit, 'hn' => $hn]);
    }

    private function getHeaderForTable($table)
    {
        switch ($table) {
            case 'adp': return ['HN','AN','DATEOPD','TYPE','CODE','QTY','RATE','SEQ','CAGCODE','DOSE','CA_TYPE','SERIALNO','TOTCOPAY','USE_STATUS','TOTAL','QTYDAY','TMLTCODE','STATUS1','BI','CLINIC','ITEMSRC','PROVIDER','GRAVIDA','GA_WEEK','DCIP/E_SCREEN','LMP'];
            case 'cha': return ['HN','AN','DATE','CHRGITEM','AMOUNT','PERSON_ID','SEQ'];
            case 'cht': return ['HN','AN','DATE','TOTAL','PAID','PTTYPE','PERSON_ID','SEQ'];
            case 'dru': return ['HCODE','HN','AN','CLINIC','PERSON_ID','DATE_SERV','DID','DIDNAME','AMOUNT','DRUGPRICE','DRUGCOST','DIDSTD','UNIT','UNIT_PACK','SEQ','DRUGREMARK','PA_NO','TOTCOPAY','USE_STATUS','TOTAL','SIGCODE','SIGTEXT','PROVIDER'];
            case 'ins': return ['HN','INSCL','SUBTYPE','CID','HCODE','DATEEXP','HOSPMAIN','HOSPSUB','GOVCODE','GOVNAME','PERMITNO','DOCNO','OWNRPID','OWNNAME','AN','SEQ','SUBINSCL','RELINSCL','HTYPE'];
            case 'odx': return ['HN','DATEDX','CLINIC','DIAG','DXTYPE','DRDX','PERSON_ID','SEQ'];
            case 'oop': return ['HN','DATEOPD','CLINIC','OPER','DROPID','PERSON_ID','SEQ'];
            case 'opd': return ['HN','CLINIC','DATEOPD','TIMEOPD','SEQ','UUC','DETAIL','BTEMP','SBP','DBP','PR','RR','OPTYPE','TYPEIN','TYPEOUT'];
            case 'pat': return ['HCODE','HN','CHANGWAT','AMPHUR','DOB','SEX','MARRIAGE','OCCUPA','NATION','PERSON_ID','NAMEPAT','TITLE','FNAME','LNAME','IDTYPE'];
            default:    return [];
        }
    }

    private function exportToTextFile($data, $filePath, $header = [])
    {
        $file = fopen($filePath, 'wb');
        if (!empty($header)) fputcsv($file, $header, "|");
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
        $data     = Yii::$app->db2->createCommand($sqltoken)->queryOne();

        if ($data && isset($data['token30'])) {
            $token30 = $data['token30'];
            $filePaths = [
                __DIR__ . '/../web/uploads/fdh_opd/PAT.txt',
                __DIR__ . '/../web/uploads/fdh_opd/INS.txt',
                __DIR__ . '/../web/uploads/fdh_opd/OPD.txt',
                __DIR__ . '/../web/uploads/fdh_opd/ADP.txt',
                __DIR__ . '/../web/uploads/fdh_opd/ODX.txt',
                __DIR__ . '/../web/uploads/fdh_opd/CHA.txt',
                __DIR__ . '/../web/uploads/fdh_opd/CHT.txt',
                __DIR__ . '/../web/uploads/fdh_opd/DRU.txt',
            ];

            $client  = new Client();
            $request = $client->createRequest()
                ->setMethod('POST')
                ->setUrl('https://fdh.moph.go.th/api/v2/data_hub/16_files')
                ->addHeaders(['Authorization' => 'Bearer ' . $token30, 'Content-Type' => 'multipart/form-data']);

            foreach ($filePaths as $filePath) {
                if (file_exists($filePath)) $request->addFile('file', $filePath, ['content-type' => 'text/plain']);
            }
            $request->addData(['key' => 'value', 'type' => 'txt']);

            $response     = $request->send();
            $responseData = json_decode($response->getContent(), true);
            $message_th   = $responseData['message_th'] ?? '';

            if ($response->isOk) {
                Yii::$app->session->setFlash('success', 'ส่งข้อมูลสำเร็จ.');
            } else {
                Yii::$app->session->setFlash('error', "Error: " . $response->getStatusCode() . " " . $response->getContent() . " สำหรับ visit: " . $visit);
            }

            $chtFilePath = __DIR__ . '/../web/uploads/fdh_opd/CHT.txt';
            if (!file_exists($chtFilePath)) return;

            $file   = fopen($chtFilePath, 'r');
            $header = fgetcsv($file, 0, "|");
            while ($row = fgetcsv($file, 0, "|")) {
                $rowData = array_combine($header, $row);
                $hn      = $rowData['HN'];
                $visit   = $rowData['SEQ'];
                $datereg = $rowData['DATE'];

                $postData = json_encode(["hcode" => "10953", "hn" => $hn, "seq" => $visit, "transaction_uid" => ""]);
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL            => 'https://fdh.moph.go.th/api/v1/ucs/track_trans',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_CUSTOMREQUEST  => 'POST',
                    CURLOPT_POSTFIELDS     => $postData,
                    CURLOPT_HTTPHEADER     => ["Content-Type: application/json", "Authorization: Bearer " . $token30],
                ]);
                $trackRes = curl_exec($curl);
                curl_close($curl);

                $responseDecoded = json_decode($trackRes, true);
                $messages        = $responseDecoded['data'][0]['status'] ?? '';
                $statusMessageTh = $responseDecoded['data'][0]['status_message_th'] ?? '';

                $visitCount = Yii::$app->db2->createCommand("SELECT COUNT(*) FROM log_fdh_opd_ck WHERE visit_id = :visit_id")
                    ->bindValue(':visit_id', $visit)->queryScalar();

                if ($visitCount > 0) {
                    Yii::$app->db2->createCommand("UPDATE log_fdh_opd_ck SET pid=:pid, messages=:messages, messagecode=:messagecode, response=:response, users='herbnew', datereg=:datereg, d_update=NOW() WHERE visit_id=:visit_id")
                        ->bindValues([':pid' => $hn, ':messages' => $messages, ':messagecode' => $statusMessageTh, ':response' => $trackRes, ':visit_id' => $visit, ':datereg' => $datereg])->execute();
                } else {
                    Yii::$app->db2->createCommand("INSERT INTO log_fdh_opd_ck (visit_id, pid, messages, messagecode, response, users, datereg, d_update) VALUES (:visit_id, :pid, :messages, :messagecode, :response, 'herbnew', :datereg, NOW())")
                        ->bindValues([':visit_id' => $visit, ':pid' => $hn, ':messages' => $messages, ':messagecode' => $statusMessageTh, ':response' => $trackRes, ':datereg' => $datereg])->execute();
                }
            }
            fclose($file);
            return $messages;
        } else {
            Yii::$app->session->setFlash('error', 'ไม่พบ token ในฐานข้อมูล.');
        }
    }

    public function actionListFiles()
    {
        $this->view->params['showSidebar'] = false;
        $dirPath = Yii::getAlias('@webroot/uploads/fdh_opd');
        $files   = scandir($dirPath);
        return $this->render('listFiles', ['files' => $files]);
    }

    public function actionListFilesPartial()
    {
        $dirPath = Yii::getAlias('@webroot/uploads/fdh_opd');
        $files   = scandir($dirPath);
        return $this->renderPartial('listFiles', ['files' => $files]);
    }

    public function actionRunCurl()
    {
        $request = Yii::$app->request;
        $date1   = $request->get('date1', $request->post('date1'));
        $date2   = $request->get('date2', $request->post('date2'));
        Yii::$app->response->format = Response::FORMAT_JSON;

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => 'https://fdh.moph.go.th/token?Action=get_moph_access_token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode([
                'user'          => 'junmane.10953',
                'password_hash' => '3F541928B150EAC5BDE327244143DC69E00E2D73426AB038D1D422646E42D499',
                'hospital_code' => '10953'
            ]),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        ]);
        $response = curl_exec($curl);
        $err      = curl_error($curl);
        curl_close($curl);

        if ($err) {
            Yii::$app->session->setFlash('error', "cURL Error: $err");
            return $this->redirect(['index']);
        }
        try {
            Yii::$app->db2->createCommand()->insert('fdh_token', [
                'token_dt' => date('Y-m-d H:i:s'),
                'token'    => $response,
                'staff_id' => 'nim',
            ])->execute();
            Yii::$app->session->setFlash('success', 'New token สร้างสำเร็จ-NIM');
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', "Database Error: " . $e->getMessage());
        }
        return $this->redirect(['index', 'date1' => $date1, 'date2' => $date2]);
    }

    public function actionExports()
    {
        $baseDirectory  = 'uploads/fdh_opd/';
        $currentDateTime = date('Ymd_His');
        $zipFilename    = $baseDirectory . 'F16_10953_Herb_' . $currentDateTime . '.zip';
        $zip = new \ZipArchive();
        if ($zip->open($zipFilename, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) return 'Cannot open zip file';
        $folderInZip = 'fdh_opd/';
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($baseDirectory), \RecursiveIteratorIterator::LEAVES_ONLY);
        foreach ($files as $file) {
            if (!$file->isDir()) {
                $zip->addFile($file->getRealPath(), $folderInZip . basename($file->getRealPath()));
            }
        }
        $zip->close();
        Yii::$app->response->sendFile($zipFilename, basename($zipFilename), ['mimeType' => 'application/zip', 'inline' => false])->send();
        unlink($zipFilename);
        return;
    }
	######################################################################################################
	public function actionCheck()
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    $data = Yii::$app->db2->createCommand("
        SELECT MAX(token) as token30 FROM fdh_token
    ")->queryOne();

    $tokenFdh = $data['token30'] ?? null;

    if (!$tokenFdh) {
        return ['success' => false, 'message' => 'ไม่พบ token'];
    }

    $vn = Yii::$app->request->post('chkDel', []);

    if (empty($vn)) {
        return ['success' => false, 'message' => 'ไม่ได้เลือกรายการ'];
    }

    $results = [];

    foreach ($vn as $r) {
        $visitId = substr($r, 0, 10);
        $hn      = substr($r, 10, 6);

        if (empty($visitId)) continue;

        $postData = json_encode([
            "hcode"           => "10953",
            "hn"              => $hn,
            "seq"             => $visitId,
            "transaction_uid" => ""
        ]);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => 'https://fdh.moph.go.th/api/v1/ucs/track_trans',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_HTTPHEADER     => [
                "Content-Type: application/json",
                "Authorization: Bearer " . $tokenFdh
            ],
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $results[$visitId] = [
                'success'  => false,
                'status'   => 'curl_error',
                'message'  => curl_error($curl),
                'visit_id' => $visitId,
                'hn'       => $hn,
            ];
            curl_close($curl);
            continue;
        }
        curl_close($curl);

        // ✅ ลบ debug return ออกแล้ว
        $res = json_decode($response, true);

        $status          = 'not_found';
        $statusMessageTh = 'ไม่พบข้อมูลการส่ง';
        $stmPeriod       = '';
        $success         = false;

        if (!empty($res['data']) && is_array($res['data'])) {

            $apiItem         = $res['data'][0];
            $status          = $apiItem['status']            ?? 'unknown';
            $statusMessageTh = $apiItem['status_message_th'] ?? 'ส่งข้อมูลแล้ว';
            $stmPeriod       = !empty($apiItem['stm_period'])
                                ? ' (' . $apiItem['stm_period'] . ')'
                                : '';

            $approvedStatuses = ['approved', 'paid', 'accepted', 'success','waited'];
            $success = in_array(strtolower($status), $approvedStatuses);

            $results[$visitId] = [
                'success'  => $success,
                'status'   => $status,
                'message'  => $statusMessageTh . $stmPeriod,
                'visit_id' => $visitId,
                'hn'       => $hn,
            ];

        } else {

            $apiMessage      = $res['message_th'] ?? 'ไม่พบข้อมูลในระบบ FDH';
            $statusMessageTh = ($apiMessage === 'ไม่มีรายการนี้ส่งเข้ามาในระบบ')
                ? ''
                : $apiMessage;

            $results[$visitId] = [
                'success'  => false,
                'status'   => 'not_found',
                'message'  => $apiMessage,
                'visit_id' => $visitId,
                'hn'       => $hn,
            ];
        }

        // ── UPDATE log ──
        try {
            Yii::$app->db2->createCommand("
                UPDATE log_fdh_opd_ck
                SET
                    response    = :response,
                    messagecode = :status_message_th,
                    messages    = :status,
                    d_update    = NOW()
                WHERE visit_id = :visit_id
                AND   pid      = :pid
            ")
            ->bindValue(':response',          $response)
            ->bindValue(':status_message_th', $statusMessageTh)
            ->bindValue(':status',            $status)
            ->bindValue(':visit_id',          $visitId)
            ->bindValue(':pid',               $hn)
            ->execute();

        } catch (\yii\db\Exception $e) {
            Yii::error('DB Error: ' . $e->getMessage(), 'fdh-db-error');
        }
    }

    return [
        'success' => true,
        'results' => $results,
    ];
}
}