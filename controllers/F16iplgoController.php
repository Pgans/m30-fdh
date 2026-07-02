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

class F16iplgoController extends \yii\web\Controller
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
              '' as amount,
              g.hospmain, g.hospsub,
               log.messagecode,
			   IFNULL(o.claim_code, '') AS claim_code,
              IFNULL(ak.claimcode, '') AS claimcode,
			  IFNULL(cv.claimcode, '') AS enpoint
                FROM  opd_visits o 
                INNER JOIN cid_hn c on o.HN= c.HN
                INNER JOIN population p on c.CID=p.CID AND left(p.cid,5) <> '00000'
                LEFT JOIN opd_diagnosis d ON d.visit_id = o.visit_id AND d.is_cancel = 0 
                LEFT JOIN icd10new icd ON icd.icd10 = d.icd10 AND icd.icd10 <> ''
                LEFT JOIN opd_diagnosis d1 ON d1.visit_id = o.visit_id AND d.is_cancel = 0  AND d1.dxt_id = 1
                LEFT JOIN icd10new icd1 ON icd1.icd10 = d1.icd10 AND icd1.icd10 <> ''
                INNER JOIN ipd_reg ir ON ir.VISIT_ID = o.visit_id  AND ir.IS_CANCEL = 0
                LEFT JOIN service_units e ON ir.ward_no = e.unit_id
                LEFT JOIN lab_requests lr ON lr.visit_id = o.visit_id AND lr.is_cancel = 0 
                LEFT JOIN lab_lists l ON l.lab_id = lr.lab_id 
      LEFT JOIN main_inscls f ON o.INSCL = f.INSCL
      LEFT JOIN uc_inscl g ON c.CID= g.CID AND (g.date_abort > date(o.REG_DATETIME) OR DAY(g.DATE_ABORT)=0)  and trim(g.hospmain) <>''
      LEFT JOIN hosp_sss h ON c.CID=h.CID AND (h.date_abort > date(o.REG_DATETIME) OR DAY(h.DATE_ABORT) = 0 )and trim(h.HOSP_ID) <>''  
      LEFT JOIN authen_kiosk ak ON ak.visit_id = o.visit_id
	  LEFT JOIN close_visits cv ON cv.visit_id = o.visit_id
      LEFT JOIN log_fdh_ipd_ck   as log ON log.visit_id = o.visit_id
      WHERE  o.IS_CANCEL = 0
      AND ir.dsc_dt BETWEEN '$date1' AND '$date2'
      AND ir.dsc_dt <> '0'
              AND o.INSCL in ('11','12')
              #AND g.hospmain = '10953'
              #AND o.PT_STATES not in (1,2)
              AND ir.WARD_NO != '50'
      #AND o.visit_id  not in (SELECT vs.visit_id from log_all.log_fdh_ipd vs where vs.users='iplgo' )
	  #AND o.visit_id  not in (SELECT visit_id from ipd_reg )
	  #AND o.visit_id  not in (SELECT visit_id from mobile_visits )
      GROUP BY o.VISIT_ID
      ORDER BY ir.adm_id           
      ) AS data,
        (SELECT @n := 0) AS init
      ORDER BY 
        No DESC 
            ";
        $rawData = \Yii::$app->db2->createCommand($sqlData)->queryAll();

        $sqlCount1 = "SELECT  COUNT( v.visit_id) as amount
        FROM log_fdh_ipd_ck v 
        WHERE  v.users = 'iplho' AND v.messagecode <> ' '
        AND v.d_update BETWEEN CURDATE() AND NOW() ";

        $data = \yii::$app->db2->createCommand($sqlCount1)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $amount = $data[$i]['amount'];
        }

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 900,
            ],
        ]);
        ########################################################################################################
        $sqlPass = "select l.id, l.visit_id, l.an , l.messagecode, l.response, l.users, l.d_update
        FROM log_fdh_ipd_ck l 
        WHERE l.d_update BETWEEN CURDATE() AND NOW()
        AND l.messagecode <> ' ' AND l.users = 'iplgo'
        ORDER BY l.d_update DESC
        
         ";
        $rawData = \Yii::$app->db2->createCommand($sqlPass)->queryAll();

        // สร้าง Flash Alert
        //Yii::$app->session->setFlash('success', 'รายการที่ไม่ผ่านตามเงื่อนไข');

        $passProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 150,
            ],
        ]);
        ########################################################################################################
        $sqlError = "select l.id, l.visit_id, l.an , l.messagecode, l.response, l.users, l.d_update
        FROM log_fdh_ipd_ck l 
        WHERE l.d_update BETWEEN CURDATE() AND NOW()
        AND l.messagecode <> '' AND l.users = 'iplgo'
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
	#########################################################################################
     
 
   public function actionData()
{
	$date1 = Yii::$app->request->post('date1');
	$date2 = Yii::$app->request->post('date2');
    $vn = Yii::$app->request->post('chkDel', []);
    $visits = [];
    $fileData = [];
    $baseDirectory = 'uploads/fdh_ipd/';
    @mkdir($baseDirectory, 0777, true);

    $tables = ['adp', 'ins', 'pat', 'ipd', 'iop', 'irf', 'idx', 'aer', 'dru', 'cha', 'cht'];
    $db2 = Yii::$app->db2;

    foreach ($vn as $r) {
        $an = substr($r, 10);
        $visit = substr($r, 0, 10);
        $visits[] = $visit;

        foreach ($tables as $table) {
            $results = $db2->createCommand("SELECT main_query FROM fdh_iplgo WHERE main_table = :table")
                ->bindValue(':table', $table)
                ->queryAll();

            foreach ($results as $result) {
                $mainQuery = str_replace('$visit', $visit, $result['main_query']);
                $data = $db2->createCommand($mainQuery)->queryAll();

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

    // อ่านข้อมูลจาก CHT.txt เพื่อเอา seq, an, hn
    $chtFilePath = Yii::getAlias('@webroot/' . $baseDirectory . 'CHT.txt');
    if (file_exists($chtFilePath)) {
        $file = fopen($chtFilePath, 'r');
        $header = fgetcsv($file, 0, "|"); // อ่าน header

        while ($row = fgetcsv($file, 0, "|")) {
            $rowData = array_combine($header, $row);

            $an = $rowData['AN'];
            $hn = $rowData['HN'];
            $visit = $rowData['SEQ'];

            $fileList = [
                'ins' => 'UTF-8',
                'pat' => 'UTF-8',
                'ipd' => 'UTF-8',
                'iop' => 'UTF-8',
                'irf' => 'UTF-8',
                'idx' => 'UTF-8',
                'aer' => 'UTF-8',
                'dru' => 'CP874',
                'cha' => 'UTF-8',
                'cht' => 'UTF-8',
                'adp' => 'UTF-8',
            ];

            $payload = $this->buildApiPayload($baseDirectory, $fileList);

            // เรียกฟังก์ชันพร้อมส่งค่าครบ 4 ตัว
            $response = $this->sendToNhsoApi($payload, $visit, $an, $hn);
        }

        fclose($file);
    }

    Yii::$app->session->setFlash('info', 'ส่งข้อมูลเรียบร้อย');
    Yii::$app->session->set('visits', $visits);
    Yii::$app->session->set('an', $an);
	
	return $this->redirect(['index', 'date1' => $date1, 'date2' => $date2, 'visit' => $visit, 'an' => $an]);
    
}


private function sendToNhsoApi($payload, $visit, $an, $hn)
{
    // ดึง token ล่าสุด
    $sqltoken = "SELECT MAX(token) as token30 FROM claim_token";
    $data = Yii::$app->db2->createCommand($sqltoken)->queryOne();

    if (!$data || !isset($data['token30'])) {
        return false;
    }

    $token = $data['token30'];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://nhsoapi.nhso.go.th/FMU/ecimp/v1/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            "Authorization: Bearer $token",
            'User-Agent: <mbase>/<2025> <10953>',
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    // วิเคราะห์ผลลัพธ์
    $responseData = json_decode($response, true);
    $messages = $responseData['message'] ?? '-';
    $statusMessageTh = $responseData['messageCode'] ?? '-';

    // ตรวจว่ามีอยู่ใน log แล้วหรือยัง
    $logSQLCheck = "SELECT COUNT(*) FROM log_fdh_ipd_ck WHERE visit_id = :visit_id AND an = :an";
    $visitCount = Yii::$app->db2->createCommand($logSQLCheck)
        ->bindValue(':visit_id', $visit)
        ->bindValue(':an', $an)
        ->queryScalar();

    if ($visitCount > 0) {
        // อัปเดต log
        $logSQLUpdate = "UPDATE log_fdh_ipd_ck SET pid = :pid, messages = :messages, messagecode = :messagecode, response = :response, users = 'ipolgo', d_update = NOW() WHERE visit_id = :visit_id AND an = :an";
        Yii::$app->db2->createCommand($logSQLUpdate)
            ->bindValue(':pid', $hn)
            ->bindValue(':messages', $messages)
            ->bindValue(':messagecode', $statusMessageTh)
            ->bindValue(':response', $response)
            ->bindValue(':visit_id', $visit)
            ->bindValue(':an', $an)
            ->execute();
    } else {
        // เพิ่ม log ใหม่
        $logSQLInsert = "INSERT INTO log_fdh_ipd_ck (visit_id, pid, an, messages, messagecode, response, users, d_update) VALUES (:visit_id, :pid, :an, :messages, :messagecode, :response, 'ipolgo', NOW())";
        Yii::$app->db2->createCommand($logSQLInsert)
            ->bindValue(':visit_id', $visit)
            ->bindValue(':pid', $hn)
            ->bindValue(':an', $an)
            ->bindValue(':messages', $messages)
            ->bindValue(':messagecode', $statusMessageTh)
            ->bindValue(':response', $response)
            ->execute();
    }

    return $response;
}


  private function getHeaderForTable($table)
{
    $headers = [
        'adp' => ['HN', 'AN', 'DATEOPD', 'TYPE', 'CODE', 'QTY', 'RATE', 'SEQ', 'CAGCODE', 'DOSE', 'CA_TYPE', 'SERIALNO', 'TOTCOPAY', 'USE_STATUS', 'TOTAL', 'QTYDAY', 'TMLTCODE', 'STATUS1', 'BI', 'CLINIC', 'ITEMSRC', 'PROVIDER', 'GRAVIDA', 'GA_WEEK', 'DCIP/E_SCREEN', 'LMP'],
        'cha' => ['HN', 'AN', 'DATE', 'CHRGITEM', 'AMOUNT', 'PERSON_ID', 'SEQ'],
        'cht' => ['HN', 'AN', 'DATE', 'TOTAL', 'PAID', 'PTTYPE', 'PERSON_ID', 'SEQ'],
        'dru' => ['HCODE', 'HN', 'AN', 'CLINIC', 'PERSON_ID', 'DATE_SERV', 'DID', 'DIDNAME', 'AMOUNT', 'DRUGPRICE', 'DRUGCOST', 'DIDSTD', 'UNIT', 'UNIT_PACK', 'SEQ', 'DRUGREMARK', 'PA_NO', 'TOTCOPAY', 'USE_STATUS', 'TOTAL', 'SIGCODE', 'SIGTEXT', 'PROVIDER'],
        'ins' => ['HN', 'INSCL', 'SUBTYPE', 'CID', 'HCODE', 'DATEEXP', 'HOSPMAIN', 'HOSPSUB', 'GOVCODE', 'GOVNAME', 'PERMITNO', 'DOCNO', 'OWNRPID', 'OWNNAME', 'AN', 'SEQ', 'SUBINSCL', 'RELINSCL', 'HTYPE'],
        'pat' => ['HCODE', 'HN', 'CHANGWAT', 'AMPHUR', 'DOB', 'SEX', 'MARRIAGE', 'OCCUPA', 'NATION', 'PERSON_ID', 'NAMEPAT', 'TITLE', 'FNAME', 'LNAME', 'IDTYPE'],
        'aer' => ['HN', 'AN', 'DATEOPD', 'AUTHAE', 'AEDATE', 'AETIME', 'AETYPE', 'REFER_NO', 'REFMAINI', 'IREFTYPE', 'REFMAINO', 'OREFTYPE', 'UCAE', 'EMTYPE', 'SEQ', 'AESTATUS', 'DALERT', 'TALERT'],
        'ipd' => ['HN', 'AN', 'DATEADM', 'TIMEADM', 'DATEDSC', 'TIMEDSC', 'DISCHS', 'DISCHT', 'WARDDSC', 'DEPT', 'ADM_W', 'UUC', 'SVCTYPE'],
        'irf' => ['AN', 'REFER', 'REFERTYPE'],
        'iop' => ['AN', 'OPER', 'OPTYPE', 'DROPID', 'DATEIN', 'TIMEIN', 'DATEOUT', 'TIMEOUT'],
        'idx' => ['AN', 'DIAG', 'DXTYPE', 'DRDX'],
    ];

    return $headers[$table] ?? [];
}


   private function exportToTextFile($data, $filePath, $headers)
{
    $fp = fopen($filePath, 'w');

    // เขียนหัวตารางก่อน
    fwrite($fp, implode('|', $headers) . "\r\n");

    foreach ($data as $row) {
        $line = [];
        foreach ($headers as $key) {
            $line[] = $row[$key] ?? '';
        }
        fwrite($fp, implode('|', $line) . "\r\n");
    }

    fclose($fp);
}


    private function buildApiPayload($baseDirectory, $fileList)
    {
        $filePayload = [];

        foreach ($fileList as $filename => $encoding) {
            $filePath = Yii::getAlias('@webroot/' . $baseDirectory . strtoupper($filename) . '.txt');

            if (file_exists($filePath)) {
                $fileContent = file_get_contents($filePath);
                $base64Content = base64_encode($fileContent);
                $fileSize = filesize($filePath);

                $filePayload[$filename] = [
                    'blobName' => strtoupper($filename) . '.txt',
                    'blobType' => 'text/plain',
                    'blob' => $base64Content,
                    'size' => $fileSize,
                    'encoding' => $encoding
                ];
            }
        }

        $payload = [
            'fileType' => 'txt',
            'maininscl' => 'LGO',
            'importDup' => false,
            'assignToMe' => false,
            'dataTypes' => ['IP'],
            'opRefer' => false,
            'file' => $filePayload
        ];

        Yii::info(json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), __METHOD__);
        return $payload;
    }

#########################################################################################################
    public function actionListFiles()
    {
        $this->view->params['showSidebar'] = false;
        $dirPath = Yii::getAlias('@webroot/uploads/nhso_ipd');
        $files = scandir($dirPath); // ใช้ scandir เพื่อแสดงรายการไฟล์ในโฟลเดอร์

        return $this->render('listFiles', ['files' => $files]);
    }

    public function actionListFilesPartial()
    {
        $dirPath = Yii::getAlias('@webroot/uploads/nhso_ipd');
        $files = scandir($dirPath); // แสดงรายการไฟล์

        // เรนเดอร์เฉพาะเนื้อหาโดยไม่ใช้ Layout
        return $this->renderPartial('listFiles', ['files' => $files]);
    }
    public function actionReadFile($fileName)
    {
        $filePath = Yii::getAlias('@webroot/uploads/nhso_ipd/' . $fileName);

        if (file_exists($filePath)) {
            // โหลดเนื้อหาจากไฟล์
            $fileContent = file_get_contents($filePath);

            // เรนเดอร์เฉพาะเนื้อหาโดยไม่ใช้ Layout
            return $this->renderPartial('readFile', ['content' => $fileContent]);
        } else {
            throw new \yii\web\NotFoundHttpException('File not found.');
        }
    }
   ################################################################################################################
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
   
   ########################################################################################
  public function actionRunCurl()
{
    $request = Yii::$app->request;
    $date1 = $request->get('date1', $request->post('date1'));
    $date2 = $request->get('date2', $request->post('date2'));

    // 1. ลบข้อมูล token ทั้งหมดก่อน
    Yii::$app->db2->createCommand()->delete('claim_token')->execute();

    // 2. เรียก Token ใหม่จาก API
    $curl = curl_init();
    $payload = json_encode([
        "username" => "541303359577",
        "password" => "h10953",
    ]);

    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://nhsoapi.nhso.go.th/FMU/ecimp/v1/auth',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'User-Agent: dcenter/1.0 10953',
        ],
    ]);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curlError = curl_error($curl);
    curl_close($curl);

    if ($httpCode == 200) {
        $data = json_decode($response, true);

        if (isset($data['token'])) {
            try {
                Yii::$app->db2->createCommand()->insert('claim_token', [
                    'token_dt' => date('Y-m-d H:i:s'),
                    'token' => $data['token'],
                    'staff_id' => 'yoo',
                ])->execute();

                Yii::$app->session->setFlash('success', "สร้าง token สำเร็จแล้วและลบข้อมูลเก่าทั้งหมดเรียบร้อย");
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', "เกิดข้อผิดพลาดในการบันทึก token: " . $e->getMessage());
            }
        } else {
            Yii::$app->session->setFlash('error', 'ไม่สามารถรับ token ได้จากระบบ NHSO');
        }
    } else {
        Yii::$app->session->setFlash('error', "HTTP ERROR $httpCode: $curlError");
    }

    return $this->redirect(['index', 'date1' => $date1, 'date2' => $date2]);
}

}

