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
use yii\web\Response;

class FittestController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $sqlData = "SELECT @n :=@n +1 'No'
        ,f.screen_date 
        ,f.seq
        ,f.hn
		,f.cid
        ,f.fullname as 'fullname'
        ,f.age_year as 'age'
        ,f.weight
		,f.height
        ,left(f.rightname,50) as rightname
        ,'60.00' as price
        ,f.symptoms
        ,f.hospmain
        ,f.hospsub
        ,f.uc_cardid
		,f.claimcode_nhso
		,f.ผลตรวจ
		,f.uc_expire
		,log.messagecode
          FROM (select @n := 0) m, fittest f
		  LEFT JOIN mbase_data1.log_fdh_opd_ck   as log ON log.visit_id = f.seq
            WHERE f.screen_date BETWEEN '2024-10-01' AND NOW() 
            AND f.seq not in (SELECT visit_id FROM log_all.log_fdh_jhcis)
            ORDER BY No DESC
            ";
        $rawData = \Yii::$app->db14j->createCommand($sqlData)->queryAll();
        
        $sqlCount1 = "SELECT COUNT( v.visit_id) as amount
        FROM log_fdh_jhcis_ck v 
        WHERE v.messagecode = 'success' AND v.users = 'fittest'
        AND v.d_update BETWEEN CURDATE() AND NOW()";
    
        $data = \yii::$app->db143->createCommand($sqlCount1)->queryAll();
         for ($i = 0; $i < sizeof($data); $i++) {
             $amount = $data[$i]['amount']; 
         }

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 700,
            ],
        ]);

        return $this->render('index', [
            // 'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'amount'=> $amount,

        ]);
    }
    private $visit;
    private $hn;
    public function actionData()
    {
        $vn = Yii::$app->request->post('chkDel');

        foreach ($vn as $r) {
            $hn = substr($r, 6);
            //echo $hn;
            $visit = substr($r, 0, 6);
            echo $visit;
            $visits[] = $visit;
            $db14j = \Yii::$app->db14j;

            $baseDirectory = 'uploads/fdh_fittest/';
            $mode = 0777;

            $tables = ['adp', 'ins', 'odx', 'opd', 'pat'];
            foreach ($tables as $table) {
                $query = "SELECT main_query FROM fdh_fittest WHERE main_table = '$table'";
                $results = $db14j->createCommand($query)->queryAll();
                foreach ($results as $result) {
                    $mainQueryResult = $result['main_query'];
                    $mainQueryResult = str_replace('$visit', $visit, $mainQueryResult);
                    $data = $db14j->createCommand($mainQueryResult)->queryAll();
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
    Yii::$app->session->set('message_th', $message_th);
        return $this->redirect(['index', 'visit' => $visit,'hn' => $hn,'responseData' => $responseData]);
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
        $data = Yii::$app->db2->createCommand($sqltoken)->queryOne();

        if ($data && isset($data['token30'])) {
            $token30 = $data['token30'];

            // กำหนดเส้นทางของไฟล์
            $filePaths = [
                __DIR__ . '/../web/uploads/fdh_fittest/PAT.txt',
                __DIR__ . '/../web/uploads/fdh_fittest/INS.txt',
                __DIR__ . '/../web/uploads/fdh_fittest/OPD.txt',
                __DIR__ . '/../web/uploads/fdh_fittest/ADP.txt',
                __DIR__ . '/../web/uploads/fdh_fittest/ODX.txt',
            ];
            // สร้าง HTTP client และส่งคำขอ  https://uat-fdh.inet.co.th/api/v2/data_hub/16_files   https://fdh.moph.go.th/api/v2/data_hub/16_files 
            $client = new Client();
            $request = $client->createRequest()
                ->setMethod('POST')
                ->setUrl('https://uat-fdh.inet.co.th/api/v2/data_hub/16_files')
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
$responseContent = $response->getContent();
$responseData = json_decode($responseContent, true);

// ตรวจสอบและดึงค่าที่ต้องการจาก response
$messages = $responseData['data'][0]['status'] ?? '';
$statusMessageTh = $responseData['data'][0]['status_message_th'] ?? '';

// ตรวจสอบว่า visit_id มีอยู่ใน log_fdh_opd_ck หรือไม่
$visitExists = Yii::$app->db2->createCommand("
    SELECT COUNT(*) FROM log_fdh_opd_ck WHERE visit_id = :visit_id
")
    ->bindValue(':visit_id', $visit)
    ->queryScalar();

$params = [
    ':visit_id'     => $visit,
    ':pid'          => $hn,
    ':messages'     => $messages,
    ':messagecode'  => $statusMessageTh,
    ':response'     => $responseContent,
    ':datereg'      => $datereg,
];

if ($visitExists > 0) {
    // ถ้ามีอยู่แล้ว อัปเดต
    Yii::$app->db2->createCommand("
        UPDATE log_fdh_opd_ck
        SET pid = :pid, messages = :messages, messagecode = :messagecode,
            response = :response, users = 'fittest', datereg = :datereg, d_update = NOW()
        WHERE visit_id = :visit_id
    ")->bindValues($params)->execute();
} else {
    // ถ้ายังไม่มี ให้ insert
    Yii::$app->db2->createCommand("
        INSERT INTO log_fdh_opd_ck (visit_id, pid, messages, messagecode, response, users, datereg, d_update)
        VALUES (:visit_id, :pid, :messages, :messagecode, :response, 'fittest', :datereg, NOW())
    ")->bindValues($params)->execute();
}

// ปิดไฟล์ (หากเปิดไว้ก่อนหน้านี้)
if (isset($file) && is_resource($file)) {
    fclose($file);
}

return $messages;

        } else {
            Yii::$app->session->setFlash('error', 'ไม่พบ token ในฐานข้อมูล.');
        }
    }

    public function actionListFiles()
    {
        $this->view->params['showSidebar'] = false;
        $dirPath = Yii::getAlias('@webroot/uploads/fdh_fittest');
        $files = scandir($dirPath); // ใช้ scandir เพื่อแสดงรายการไฟล์ในโฟลเดอร์

        return $this->render('listFiles', ['files' => $files]);
    }

    public function actionListFilesPartial()
{
    $dirPath = Yii::getAlias('@webroot/uploads/fdh_fittest');
    $files = scandir($dirPath); // แสดงรายการไฟล์

    // เรนเดอร์เฉพาะเนื้อหาโดยไม่ใช้ Layout
    return $this->renderPartial('listFiles', ['files' => $files]);
}
public function actionReadFile($fileName)
{
    $filePath = Yii::getAlias('@webroot/uploads/fdh_fittest/' . $fileName);

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
                FROM log_fdh_jhcis v 
        INNER JOIN jhcisdb.fittest f ON f.seq = v.visit_id
                WHERE v.users = 'fittest'
                AND v.d_update BETWEEN CURDATE() AND NOW()
         ORDER BY v.pid
            ";

        $rawData = \yii::$app->db143->createCommand($sql)->queryAll();

        //print_r($rawData);
        try {
            $rawData = \Yii::$app->db143->createCommand($sql)->queryAll();
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
            // Insert the new token into the fdh_token table
            Yii::$app->db2->createCommand()->insert('fdh_token', [
                'token_dt' => new \yii\db\Expression('NOW()'),
                'token' => $response,
                'staff_id' => 'pgans',
            ])->execute();

            // Retrieve the latest token for the staff_id 'pgans'
            $sqltoken = "SELECT MAX(token) as token30, staff_id FROM fdh_token WHERE staff_id = 'pgans'";
            $latestToken = Yii::$app->db2->createCommand($sqltoken)->queryOne();

            // Use the retrieved staff_id in the flash message
            $staff_id = $latestToken['staff_id'];

            Yii::$app->session->setFlash('success', "สร้าง token สำหรับผู้ใช้ $staff_id ...สำเร็จ  ใช้งานได้ต่อเนื่อง 3 ชั่วโมง");
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', "Database Error: " . $e->getMessage());
        }

        return $this->redirect(['index']); // Redirect to the desired page
    }
}
