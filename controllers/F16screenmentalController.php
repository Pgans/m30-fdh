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

class F16screenmentalController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $sqlData = "SELECT @n :=@n +1 'No',
    n.hn,
    '01500' as clinic,
    DATE_FORMAT(n.screen_date, '%Y%m%d') as screen_date,
    n.seq,
    n.cid,
    n.fullname,
    n.age_year,
    left(n.symptoms,60) as symptoms,
    left(n.สิทธิ์การรักษา,50) as inscl,
    n.height,
    n.weight,
    n.hosmain,
    n.hossub,
    n.dateexpire  
FROM (select @n := 0) m, all_ucs_ncd_screen n  
WHERE 
n.screen_date BETWEEN '2024-01-01' AND '2024-01-25' 
AND n.rightcode in( '89')
ORDER BY No DESC
            ";
        $rawData = \Yii::$app->db14j->createCommand($sqlData)->queryAll();
        
        $sqlCount1 = "SELECT COUNT( v.visit_id) as amount
        FROM log_fdh_jhcis v 
        WHERE v.messagecode = 'success' AND v.users = 'screen'
        AND v.d_update BETWEEN CURDATE() AND NOW()
        #GROUP BY v.visit_id
        ";
    
        $data = \yii::$app->db2->createCommand($sqlCount1)->queryAll();
         for ($i = 0; $i < sizeof($data); $i++) {
             $amount = $data[$i]['amount']; 
         }

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 3,
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
                $query = "SELECT main_query FROM qr_screen_mental WHERE main_table = '$table'";
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
            // สร้าง HTTP client และส่งคำขอ
            $client = new Client();
            $request = $client->createRequest()
                ->setMethod('POST')
                ->setUrl('https://uat-fdh.inet.co.th/api/v2/data_hub/16_files/')
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
            $logSQL = "REPLACE INTO log_fdh_jhcis (visit_id, pid, messagecode, response, users, d_update) 
            VALUES ('$visit', '$hn', '$message', '$message_th', 'screen', NOW())";
            Yii::$app->db2->createCommand($logSQL)->execute();
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
        f.age_year, f.height,f.weight,f.hosmain, f.hossub, f.symptoms,
         f.screen_date ,v.d_update,
        v.response
                FROM log_fdh_jhcis v 
        INNER JOIN jhcisdb.all_ucs_ncd_screen f ON f.seq = v.visit_id
                WHERE v.users = 'screen'
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

}
