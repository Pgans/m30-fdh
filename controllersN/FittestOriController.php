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
        ,f.symptoms
        ,f.hospmain
        ,f.hospsub
		,f.ผลตรวจ
        ,f.uc_type
				,f.uc_expire
          FROM (select @n := 0) m, fittest f
            WHERE f.screen_date BETWEEN '2024-03-01' AND '2024-09-30' 


            ";
        $rawData = \Yii::$app->db14j->createCommand($sqlData)->queryAll();


        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        return $this->render('index', [
            // 'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

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
    
        return $this->redirect(['index']);
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
            VALUES ('$visit', '$hn', '$message', '$message_th', 'fittest', NOW())";
            Yii::$app->db143->createCommand($logSQL)->execute();

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
public function actionStream() {
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    
    $messages = ["กำลังประมวลผล...", "ส่งข้อมูล...", "การส่งสำเร็จ"];
    foreach ($messages as $index => $message) {
        echo "id: $index\n";
        echo "data: $message\n\n";
        ob_flush();
        flush();
        sleep(1); // รอระยะเวลาหนึ่งระหว่างเหตุการณ์
    }
}

}
