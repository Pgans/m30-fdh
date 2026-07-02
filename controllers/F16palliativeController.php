<?php

namespace app\controllers;

use Yii;
use yii\helpers\FileHelper;
use ZipArchive;
use yii\web\Controller;
use yii\web\Response;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\data\ArrayDataProvider;
use yii\httpclient\Client;

class F16palliativeController extends \yii\web\Controller
{
    public function actionIndex()
    {
        // =====================================================
        // รับค่าวันที่จาก GET (รองรับ POST เดิมด้วย)
        // =====================================================
        $req    = Yii::$app->request;
        $date1x = $req->get('date1', $req->post('date1', date('Y-m-01'))); // เริ่มต้นเดือน
        $date2x = $req->get('date2', $req->post('date2', date('Y-m-d')));
        $statusFilter = $req->get('status', 'all'); // all | success | waiting

        $date1 = date('Y-m-d 00:01', strtotime($date1x));
        $date2 = date('Y-m-d 23:59', strtotime($date2x));

        // =====================================================
        // SQL ฐาน (ไม่ filter status) — ใช้นับ Card เท่านั้น
        // =====================================================
        $sqlBase = "
            SELECT o.visit_id, log.messagecode
            FROM opd_visits o
            INNER JOIN cid_hn c ON o.HN = c.HN
            INNER JOIN population p ON c.CID = p.CID
            INNER JOIN opd_diagnosis d ON d.visit_id = o.visit_id AND d.is_cancel = 0
            LEFT JOIN log_fdh_opd_ck log ON log.visit_id = o.visit_id
            WHERE o.IS_CANCEL = 0
            AND o.REG_DATETIME BETWEEN '$date1' AND '$date2'
            AND o.INSCL IN ('03','04','33')
            AND (o.unit_reg = '72' OR o.unit_id = '72')
            AND o.visit_id NOT IN (SELECT ipd_reg.visit_id FROM ipd_reg WHERE ipd_reg.is_cancel = 0)
            GROUP BY o.visit_id
        ";
        $baseData = Yii::$app->db2->createCommand($sqlBase)->queryAll();

        // นับ Card จากข้อมูลทั้งหมด (ไม่ขึ้นกับ filter)
        $isSent    = function($r) { return isset($r['messagecode']) && $r['messagecode'] !== null && trim($r['messagecode']) !== ''; };
        $isWaiting = function($r) { return !isset($r['messagecode']) || $r['messagecode'] === null || trim($r['messagecode']) === ''; };

        $totalMonth     = count($baseData);
        $claimedMonth   = count(array_filter($baseData, $isSent));
        $remainingMonth = count(array_filter($baseData, $isWaiting));

        // =====================================================
        // WHERE filter สำหรับตาราง
        // =====================================================
        $whereStatus = '';
        if ($statusFilter === 'success') {
            $whereStatus = "AND (log.messagecode IS NOT NULL AND TRIM(log.messagecode) <> '')";
        } elseif ($statusFilter === 'waiting') {
            $whereStatus = "AND (log.messagecode IS NULL OR TRIM(log.messagecode) = '')";
        }

        // =====================================================
        // SQL หลัก (ORDER BY ASC เพื่อ array_reverse ทีหลัง)
        // =====================================================
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
		  cv.sub_fund AS fund,
		  ##cv.stm_claim AS amount,
          cv.ret_statement,
          log.messagecode,
          COALESCE((
    cv.cg01 + cv.cg02 + cv.cg03 + cv.cg04 + cv.cg05 +
    cv.cg06 + cv.cg07 + cv.cg08 + cv.cg09 + cv.cg10 +
    cv.cg11 + cv.cg12 + cv.cg13 + cv.cg14 + cv.cg15 +
    cv.cg16 + cv.cg17 + cv.cg18 + cv.cg19
    ), 0.00) AS amount,
          IFNULL(ak.claimcode, '') AS claimcode
          FROM (select @n := 0) m, opd_visits o 
          INNER JOIN cid_hn c on o.HN= c.HN
          INNER JOIN population p on c.CID=p.CID 
          INNER JOIN opd_diagnosis d ON d.visit_id = o.visit_id AND d.is_cancel = 0 
          LEFT JOIN icd10new icd ON icd.icd10 = d.icd10 AND icd.icd10 <> ''
          LEFT JOIN opd_diagnosis d1 ON d1.visit_id = o.visit_id AND d.is_cancel = 0  AND d1.dxt_id = 1
          LEFT JOIN icd10new icd1 ON icd1.icd10 = d1.icd10 AND icd1.icd10 <> ''
          LEFT JOIN ipd_reg ir ON ir.VISIT_ID = o.visit_id AND ir.IS_CANCEL = 0
          INNER JOIN service_units e ON o.UNIT_REG=e.unit_id
          LEFT JOIN lab_requests lr ON lr.visit_id = o.visit_id AND lr.is_cancel = 0 
          LEFT JOIN lab_lists l ON l.lab_id = lr.lab_id 
          LEFT JOIN prescriptions ps on ps.visit_id = o.visit_id AND ps.is_cancel = 0
          LEFT JOIN main_inscls f ON o.INSCL = f.INSCL
          LEFT JOIN uc_inscl g ON c.CID= g.CID AND (g.date_abort > date(o.REG_DATETIME) OR DAY(g.DATE_ABORT)=0) and trim(g.hospmain) <>''
          LEFT JOIN hosp_sss h ON c.CID=h.CID AND (h.date_abort > date(o.REG_DATETIME) OR DAY(h.DATE_ABORT) = 0) and trim(h.HOSP_ID) <>''  
          LEFT JOIN authen_kiosk ak ON p.CID = ak.cid AND date(o.REG_DATETIME)=date(ak.d_update)
          LEFT JOIN cost_visits cos ON cos.visit_id = o.visit_id AND cos.is_cancel = 0
          LEFT JOIN receipts re ON re.visit_id = o.visit_id AND re.is_cancel = 0
          LEFT JOIN log_fdh_opd_ck as log ON log.visit_id = o.visit_id
		  LEFT JOIN cost_visits cv ON cv.visit_id = o.visit_id AND cv.is_cancel = 0
          WHERE o.IS_CANCEL = 0
          AND o.REG_DATETIME BETWEEN '$date1' AND '$date2'
          AND o.INSCL in ('03','04','33')
          AND (o.unit_reg = '72' OR o.unit_id = '72')
          AND o.visit_id not in (SELECT ipd_reg.visit_id from ipd_reg WHERE ipd_reg.is_cancel=0)
          $whereStatus
          GROUP BY o.VISIT_ID
          ORDER BY No ASC, e.unit_id";

        $rawData = \Yii::$app->db2->createCommand($sqlData)->queryAll();

        // reverse ให้ใหม่สุดอยู่บน (#1 = visit ล่าสุด)
        $rawData = array_reverse($rawData);

        // =====================================================
        // ผ่านวันนี้
        // =====================================================
        $amount = \Yii::$app->db2->createCommand("
            SELECT COUNT(v.visit_id) as amount FROM log_fdh_opd_ck v 
            WHERE v.users = 'palliative' AND v.messagecode <> ''
            AND v.d_update BETWEEN CURDATE() AND NOW()
        ")->queryScalar();

        // =====================================================
        // DataProvider
        // =====================================================
        $dataProvider = new ArrayDataProvider([
            'allModels'  => $rawData,
            'pagination' => ['pageSize' => 400],
        ]);

        // =====================================================
        // Pass / Error Log
        // =====================================================
        $passProvider = new ArrayDataProvider([
            'allModels'  => \Yii::$app->db2->createCommand("
                SELECT l.id, l.visit_id, l.pid, l.messagecode, l.response, l.users, l.d_update
                FROM log_fdh_opd_ck l 
                WHERE l.d_update BETWEEN CURDATE() AND NOW()
                AND l.messagecode <> '' AND l.users = 'palliative'
                ORDER BY l.d_update DESC
            ")->queryAll(),
            'pagination' => ['pageSize' => 300],
        ]);

        $errorProvider = new ArrayDataProvider([
            'allModels'  => \Yii::$app->db2->createCommand("
                SELECT l.id, l.visit_id, l.pid, l.messagecode, l.response, l.users, l.d_update
                FROM log_fdh_opd_ck l 
                WHERE l.d_update BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()
                AND l.messagecode <> 'success' AND l.users = 'palliative'
                ORDER BY l.d_update DESC
            ")->queryAll(),
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

    // =====================================================
    // actionData
    // =====================================================
    public function actionData()
    {
        $vn      = Yii::$app->request->post('chkDel', []);
        $date1   = Yii::$app->request->post('date1', '');
        $date2   = Yii::$app->request->post('date2', '');
        $visits  = [];
        $fileData = [];

        foreach ($vn as $r) {
            $hn    = substr($r, 10);
            $visit = substr($r, 0, 10);
            $visits[] = $visit;
            $db2 = \Yii::$app->db2;
            $baseDirectory = 'uploads/fdh_opd/';
            $tables = ['adp', 'ins', 'odx', 'opd', 'pat', 'cha', 'cht'];

            foreach ($tables as $table) {
                $results = $db2->createCommand("SELECT main_query FROM fdh_palliative WHERE main_table = '$table'")->queryAll();
                foreach ($results as $result) {
                    $mainQueryResult = str_replace('$visit', $visit, $result['main_query']);
                    $data = $db2->createCommand($mainQueryResult)->queryAll();
                    if (!isset($fileData[$table])) $fileData[$table] = [];
                    $fileData[$table] = array_merge($fileData[$table], $data);
                }
            }
        }

        foreach ($fileData as $table => $data) {
            $filePath = $baseDirectory . strtoupper($table) . '.txt';
            $header   = $this->getHeaderForTable($table);
            $this->exportToTextFile($data, $filePath, $header);
            if ($table === 'pat') {
                $this->removeDuplicatesFromFile($filePath);
                $this->convertToWindowsCrLf($filePath);
            }
        }

        $this->sendDataToAPI($visit, $hn);
        Yii::$app->session->set('visits', $visits);
        Yii::$app->session->set('hn', $hn);
        return $this->redirect(['index', 'date1' => $date1, 'date2' => $date2, 'visit' => $visit, 'hn' => $hn]);
    }

    // =====================================================
    // actionCheckData
    // =====================================================
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

            $tables = ['adp', 'ins', 'odx', 'opd', 'pat', 'cha', 'cht'];
            $result = []; $hasError = false;

            foreach ($tables as $table) {
                $count = 0; $status = 'na'; $message = ''; $allData = []; $invoiceData = [];
                try {
                    $results = $db2->createCommand("SELECT main_query FROM fdh_palliative WHERE main_table = :t")->bindValue(':t', $table)->queryAll();
                    if (empty($results)) {
                        $status = 'no_config'; $message = 'ไม่พบ query config'; $hasError = true;
                    } else {
                        foreach ($results as $row) {
                            if (empty($row['main_query'])) continue;
                            $sql = str_replace('$visit', $visit, $row['main_query']);
                            $data = $db2->createCommand($sql)->queryAll();
                            $count += count($data); $allData = array_merge($allData, $data);
                        }
                        $status = $count > 0 ? 'ok' : 'empty';
                        if ($status === 'empty') $hasError = true;
                    }
                    if ($table === 'adp') {
                        try {
                            $invoiceData = $db2->createCommand("SELECT visit_id, record_dt, item, invoice, amount, subtotal FROM visit_invoice WHERE visit_id = :v AND is_cancel = 0 ORDER BY record_dt, invoice")->bindValue(':v', $visit)->queryAll();
                        } catch (\Exception $e) { $invoiceData = []; }
                    }
                } catch (\Exception $e) {
                    $status = 'error'; $message = $e->getMessage(); $hasError = true;
                }
                $result[] = ['table' => strtoupper($table), 'count' => $count, 'required' => true, 'status' => $status, 'message' => $message, 'rows' => $allData, 'rows_invoice' => $invoiceData];
            }
            return ['success' => true, 'hasError' => $hasError, 'visit' => $visit, 'hn' => $hn, 'data' => $result];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage(), 'file' => basename($e->getFile()), 'line' => $e->getLine()];
        }
    }

    private function getHeaderForTable($table)
    {
        switch ($table) {
            case 'adp': return ['HN','AN','DATEOPD','TYPE','CODE','QTY','RATE','SEQ','CAGCODE','DOSE','CA_TYPE','SERIALNO','TOTCOPAY','USE_STATUS','TOTAL','QTYDAY','TMLTCODE','STATUS1','BI','CLINIC','ITEMSRC','PROVIDER','GRAVIDA','GA_WEEK','DCIP/E_SCREEN','LMP'];
            case 'cha': return ['HN','AN','DATE','CHRGITEM','AMOUNT','PERSON_ID','SEQ'];
            case 'cht': return ['HN','AN','DATE','TOTAL','PAID','PTTYPE','PERSON_ID','SEQ'];
            case 'ins': return ['HN','INSCL','SUBTYPE','CID','HCODE','DATEEXP','HOSPMAIN','HOSPSUB','GOVCODE','GOVNAME','PERMITNO','DOCNO','OWNRPID','OWNNAME','AN','SEQ','SUBINSCL','RELINSCL','HTYPE'];
            case 'odx': return ['HN','DATEDX','CLINIC','DIAG','DXTYPE','DRDX','PERSON_ID','SEQ'];
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

    private function removeDuplicatesFromFile($filePath)
    {
        $lines  = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $unique = array_unique($lines);
        file_put_contents($filePath, implode("\n", $unique) . "\n");
    }

    private function convertToWindowsCrLf($filePath)
    {
        $content = file_get_contents($filePath);
        $content = str_replace("\n", "\r\n", $content);
        file_put_contents($filePath, $content);
    }

    private function sendDataToAPI($visit, $hn)
    {
        $data = Yii::$app->db2->createCommand("SELECT MAX(token) as token30 FROM fdh_token WHERE staff_id = 'nim'")->queryOne();
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
            ];

            $client  = new Client();
            $request = $client->createRequest()->setMethod('POST')->setUrl('https://fdh.moph.go.th/api/v2/data_hub/16_files')
                ->addHeaders(['Authorization' => 'Bearer ' . $token30, 'Content-Type' => 'multipart/form-data']);
            foreach ($filePaths as $fp) { if (file_exists($fp)) $request->addFile('file', $fp, ['content-type' => 'text/plain']); }
            $request->addData(['key' => 'value', 'type' => 'txt']);

            $response     = $request->send();
            $responseData = json_decode($response->getContent(), true);
            if ($response->isOk) { Yii::$app->session->setFlash('success', 'ส่งข้อมูลสำเร็จ.'); }
            else { Yii::$app->session->setFlash('error', "Error: " . $response->getStatusCode() . " สำหรับ visit: " . $visit); }

            $chtFile = __DIR__ . '/../web/uploads/fdh_opd/CHT.txt';
            if (!file_exists($chtFile)) return;
            $file   = fopen($chtFile, 'r');
            $header = fgetcsv($file, 0, "|");
            while ($row = fgetcsv($file, 0, "|")) {
                $rowData = array_combine($header, $row);
                $hn = $rowData['HN']; $visit = $rowData['SEQ']; $datereg = $rowData['DATE'];
                $postData = json_encode(["hcode" => "10953", "hn" => $hn, "seq" => $visit, "transaction_uid" => ""]);
                $curl = curl_init();
                curl_setopt_array($curl, [CURLOPT_URL => 'https://fdh.moph.go.th/api/v1/ucs/track_trans', CURLOPT_RETURNTRANSFER => true, CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_CUSTOMREQUEST => 'POST', CURLOPT_POSTFIELDS => $postData, CURLOPT_HTTPHEADER => ["Content-Type: application/json", "Authorization: Bearer " . $token30]]);
                $trackRes = curl_exec($curl); curl_close($curl);
                $dec = json_decode($trackRes, true);
                $messages = $dec['data'][0]['status'] ?? ''; $statusMessageTh = $dec['data'][0]['status_message_th'] ?? '';
                $cnt = Yii::$app->db2->createCommand("SELECT COUNT(*) FROM log_fdh_opd_ck WHERE visit_id = :v")->bindValue(':v', $visit)->queryScalar();
                if ($cnt > 0) {
                    Yii::$app->db2->createCommand("UPDATE log_fdh_opd_ck SET pid=:pid,messages=:messages,messagecode=:messagecode,response=:response,users='palliative',datereg=:datereg,d_update=NOW() WHERE visit_id=:v")
                        ->bindValues([':pid'=>$hn,':messages'=>$messages,':messagecode'=>$statusMessageTh,':response'=>$trackRes,':v'=>$visit,':datereg'=>$datereg])->execute();
                } else {
                    Yii::$app->db2->createCommand("INSERT INTO log_fdh_opd_ck (visit_id,pid,messages,messagecode,response,users,datereg,d_update) VALUES (:v,:pid,:messages,:messagecode,:response,'palliative',:datereg,NOW())")
                        ->bindValues([':v'=>$visit,':pid'=>$hn,':messages'=>$messages,':messagecode'=>$statusMessageTh,':response'=>$trackRes,':datereg'=>$datereg])->execute();
                }
            }
            fclose($file);
        } else {
            Yii::$app->session->setFlash('error', 'ไม่พบ token ในฐานข้อมูล.');
        }
    }

    public function actionRunCurl()
    {
        $req   = Yii::$app->request;
        $date1 = $req->get('date1', $req->post('date1', date('Y-m-d')));
        $date2 = $req->get('date2', $req->post('date2', date('Y-m-d')));
        Yii::$app->response->format = Response::FORMAT_JSON;
        $curl = curl_init();
        curl_setopt_array($curl, [CURLOPT_URL => 'https://fdh.moph.go.th/token?Action=get_moph_access_token', CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 30, CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_POST => true, CURLOPT_POSTFIELDS => json_encode(['user' => 'junmane.10953', 'password_hash' => '3F541928B150EAC5BDE327244143DC69E00E2D73426AB038D1D422646E42D499', 'hospital_code' => '10953']), CURLOPT_HTTPHEADER => ['Content-Type: application/json']]);
        $response = curl_exec($curl); $err = curl_error($curl); curl_close($curl);
        if ($err) { Yii::$app->session->setFlash('error', "cURL Error: $err"); return $this->redirect(['index']); }
        try {
            Yii::$app->db2->createCommand()->insert('fdh_token', ['token_dt' => date('Y-m-d H:i:s'), 'token' => $response, 'staff_id' => 'nim'])->execute();
            Yii::$app->session->setFlash('success', 'New token สร้างสำเร็จ');
        } catch (Exception $e) { Yii::$app->session->setFlash('error', "Database Error: " . $e->getMessage()); }
        return $this->redirect(['index', 'date1' => $date1, 'date2' => $date2]);
    }

    public function actionListFiles()
    {
        $this->view->params['showSidebar'] = false;
        return $this->render('listFiles', ['files' => scandir(Yii::getAlias('@webroot/uploads/fdh_opd'))]);
    }

    public function actionListFilesPartial()
    {
        return $this->renderPartial('listFiles', ['files' => scandir(Yii::getAlias('@webroot/uploads/fdh_opd'))]);
    }

    public function actionExports()
    {
        $baseDirectory = 'uploads/fdh_opd/';
        $zipFilename   = $baseDirectory . 'F16_10953_Palliative_' . date('Ymd_His') . '.zip';
        $zip = new \ZipArchive();
        if ($zip->open($zipFilename, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) return 'Cannot open zip file';
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($baseDirectory), \RecursiveIteratorIterator::LEAVES_ONLY);
        foreach ($files as $file) { if (!$file->isDir()) $zip->addFile($file->getRealPath(), 'fdh_opd/' . basename($file->getRealPath())); }
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

           $approvedStatuses = ['approved', 'paid', 'accepted', 'success', 'waited', 'claimed', 'processed', 'complete', 'completed','cut_off_batch'];
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