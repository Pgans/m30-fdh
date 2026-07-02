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
use  app\models\Fdhoplgo;
use app\models\LogFdhOpd;
use yii\data\ArrayDataProvider;
use yii\db\Expression;



class F16oplgoController extends \yii\web\Controller
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
					GROUP_CONCAT(DISTINCT pr.drug_id) as drug,
                    dr.drug_name,
					left(e.unit_name,10) 'unit_name', 
					f.INSCL_NAME as 'inscl',
					g.hospmain, left(hpt.hosp_name,30) as hospname,
					log.messagecode,
					COALESCE((cg01 + cg02 + cg03 + cg04 + cg05 + cg06 + cg07 + cg08 + cg09 + cg10 + cg11 + cg12 + cg13 + cg14 + cg15 + cg16 + cg17 + cg18 + cg19), 00) AS amount,
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
          LEFT JOIN ipd_reg ir ON ir.VISIT_ID = o.visit_id  AND ir.IS_CANCEL = 0
          LEFT JOIN service_units e ON o.UNIT_REG=e.unit_id
          LEFT JOIN lab_requests lr ON lr.visit_id = o.visit_id AND lr.is_cancel = 0 
          LEFT JOIN lab_lists l ON l.lab_id = lr.lab_id 
					LEFT JOIN prescriptions pr on o.visit_id=pr.visit_id AND pr.is_cancel=0 
					LEFT JOIN drugs dr on dr.drug_id= pr.drug_id
					LEFT JOIN main_inscls f ON o.INSCL = f.INSCL
					LEFT JOIN uc_inscl g ON c.CID= g.CID AND (g.date_abort > date(o.REG_DATETIME) OR DAY(g.DATE_ABORT)=0)  and trim(g.hospmain) <>''
					LEFT JOIN hosp_sss h ON c.CID=h.CID AND (h.date_abort > date(o.REG_DATETIME) OR DAY(h.DATE_ABORT) = 0 )and trim(h.HOSP_ID) <>''  
					LEFT JOIN authen_kiosk ak ON ak.visit_id = o.visit_id
          #LEFT JOIN authen_kiosk ak ON p.CID = ak.cid  AND date(o.REG_DATETIME)=date(ak.d_update)
					LEFT JOIN log_fdh_opd_ck   as log ON log.visit_id = o.visit_id
					LEFT JOIN hospitals hpt on hpt.hosp_id=g.hospmain AND hpt.is_ubon = 0
					LEFT JOIN cost_visits cos ON cos.visit_id = o.visit_id AND cos.is_cancel = 0
					LEFT JOIN close_visits cv ON cv.visit_id = o.visit_id
          WHERE o.IS_CANCEL = 0
				AND o.REG_DATETIME BETWEEN '$date1' AND '$date2'
				AND o.INSCL in ('11','12')
				AND o.unit_reg not in ( '42')
				#AND icd.icd10_tm not BETWEEN 'Z020' AND 'Z029' 
				#AND g.hospmain not in (SELECT hosp3400.HOSP_ID FROM hosp3400) 
				AND o.visit_id not in (SELECT ipd_reg.visit_id from ipd_reg WHERE ipd_reg.is_cancel=0)
	            AND o.visit_id  not in (SELECT visit_id from mobile_visits )
				#AND o.visit_id  not in (SELECT vs.visit_id from log_all.log_fdh_opd vs )
				GROUP BY o.VISIT_ID
				
				) AS data,
						(SELECT @n := 0) AS init
					ORDER BY 
						No DESC 
            ";
        $rawData = \Yii::$app->db2->createCommand($sqlData)->queryAll();

        $sqlCount1 = "SELECT COUNT( v.visit_id) as amount
        FROM log_fdh_opd_ck v 
        WHERE  v.users = 'oplgo' AND v.messagecode <> ''
		#AND v.messages <> ''
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
        AND l.messagecode <> '' AND l.users = 'oplgo'
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
        AND l.messagecode <> 'success' AND l.users = 'oplgo'
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

################################################################################################
public function actionData()
{
    $vn = Yii::$app->request->post('chkDel', []);
$visits = [];
$fileData = [];

$baseDirectory = 'uploads/fdh_opd/';
$fullPath = Yii::getAlias('@webroot/' . $baseDirectory);

if (!is_dir($fullPath)) {
    if (!mkdir($fullPath, 0777, true)) {
        throw new \Exception("ไม่สามารถสร้างโฟลเดอร์ $fullPath ได้");
    }
}
    $tables = ['adp', 'ins', 'odx', 'opd', 'pat', 'cha', 'cht', 'oop', 'dru', 'orf'];
    $db2 = Yii::$app->db2;

    foreach ($vn as $r) {
        $hn = substr($r, 10);
        $visit = substr($r, 0, 10);
        $visits[] = $visit;

        foreach ($tables as $table) {
            $results = $db2->createCommand("SELECT main_query FROM fdh_opofc WHERE main_table = :table")
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

    // สร้างไฟล์ txt ทุกตารางแม้ไม่มีข้อมูล
    foreach ($tables as $table) {
        $filePath = $fullPath . strtoupper($table) . '.txt';
        $header = $this->getHeaderForTable($table);
        $data = $fileData[$table] ?? [];
        $this->exportToTextFile($data, $filePath, $header);
    }

    // รายการแฟ้มและ encoding สำหรับส่ง API
    $fileList = [
        'ins' => 'UTF-8',
        'pat' => 'UTF-8',
        'opd' => 'CP874',
        'oop' => 'UTF-8',
        'orf' => 'UTF-8',
        'odx' => 'UTF-8',
        'dru' => 'CP874',
        'cha' => 'UTF-8',
        'cht' => 'UTF-8',
        'adp' => 'UTF-8',
    ];

    // ส่งออก API ทีละไฟล์
    $results = $this->buildApiPayload($baseDirectory, $fileList);

    Yii::$app->session->setFlash('info', 'ส่งข้อมูลเรียบร้อย');
    Yii::$app->session->set('visits', $visits);
    Yii::$app->session->set('hn', $hn ?? null);

    return $this->redirect(['index', 'visit' => end($visits), 'hn' => $hn ?? null]);
}



    private function sendToNhsoApi($payload)
    {
       	// รับค่า token จากฐานข้อมูล
        $sqltoken = "SELECT MAX(token) as token30 FROM claim_token";
        $data = Yii::$app->db2->createCommand($sqltoken)->queryOne();

        if ($data && isset($data['token30'])) {
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
				'User-Agent: <mbase>/<2025> <10953>'
            ],
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
	}

  private function getHeaderForTable($table)
{
    $headers = [
        'adp' => ['HN', 'AN', 'DATEOPD', 'TYPE', 'CODE', 'QTY', 'RATE', 'SEQ', 'CAGCODE', 'DOSE', 'CA_TYPE', 'SERIALNO', 'TOTCOPAY', 'USE_STATUS', 'TOTAL', 'QTYDAY', 'TMLTCODE', 'STATUS1', 'BI', 'CLINIC', 'ITEMSRC', 'PROVIDER', 'GRAVIDA', 'GA_WEEK', 'DCIP/E_SCREEN', 'LMP'],
        'cha' => ['HN', 'AN', 'DATE', 'CHRGITEM', 'AMOUNT', 'PERSON_ID', 'SEQ'],
        'cht' => ['HN', 'AN', 'DATE', 'TOTAL', 'PAID', 'PTTYPE', 'PERSON_ID', 'SEQ'],
        'dru' => ['HCODE', 'HN', 'AN', 'CLINIC', 'PERSON_ID', 'DATE_SERV', 'DID', 'DIDNAME', 'AMOUNT', 'DRUGPRICE', 'DRUGCOST', 'DIDSTD', 'UNIT', 'UNIT_PACK', 'SEQ', 'DRUGREMARK', 'PA_NO', 'TOTCOPAY', 'USE_STATUS', 'TOTAL', 'SIGCODE', 'SIGTEXT', 'PROVIDER'],
        'ins' => ['HN', 'INSCL', 'SUBTYPE', 'CID', 'HCODE','DATEEXP', 'HOSPMAIN', 'HOSPSUB', 'GOVCODE', 'GOVNAME', 'PERMITNO', 'DOCNO', 'OWNRPID', 'OWNNAME', 'AN', 'SEQ', 'SUBINSCL', 'RELINSCL', 'HTYPE'],
        'pat' => ['HCODE', 'HN', 'CHANGWAT', 'AMPHUR', 'DOB', 'SEX', 'MARRIAGE', 'OCCUPA', 'NATION', 'PERSON_ID', 'NAMEPAT', 'TITLE', 'FNAME', 'LNAME', 'IDTYPE'],
        'aer' => ['HN', 'AN', 'DATEOPD', 'AUTHAE', 'AEDATE', 'AETIME', 'AETYPE', 'REFER_NO', 'REFMAINI', 'IREFTYPE', 'REFMAINO', 'OREFTYPE', 'UCAE', 'EMTYPE', 'SEQ', 'AESTATUS', 'DALERT', 'TALERT'],
        'ipd' => ['HN', 'AN', 'DATEADM', 'TIMEADM', 'DATEDSC', 'TIMEDSC', 'DISCHS', 'DISCHT', 'WARDDSC', 'DEPT', 'ADM_W', 'UUC', 'SVCTYPE'],
        'irf' => ['AN', 'REFER', 'REFERTYPE'],
        'iop' => ['AN', 'OPER', 'OPTYPE', 'DROPID', 'DATEIN', 'TIMEIN', 'DATEOUT', 'TIMEOUT'],
        'idx' => ['AN', 'DIAG', 'DXTYPE', 'DRDX'],
        'opd' => ['HN', 'CLINIC', 'DATEOPD', 'TIMEOPD', 'SEQ', 'UUC', 'DETAIL', 'BTEMP', 'SBP', 'DBP', 'PR', 'RR', 'OPTYPE', 'TYPEIN', 'TYPEOUT'],
        'orf' => ['HN', 'DATEOPD', 'CLINIC', 'REFER', 'REFERTYPE', 'SEQ', 'REFERDATE'],
        'oop' => ['HN', 'DATEOPD', 'CLINIC', 'OPER', 'DROPID', 'PERSON_ID', 'SEQ'],
        'odx' => ['HN', 'DATEDX', 'CLINIC', 'DIAG', 'DXTYPE', 'DRDX', 'PERSON_ID', 'SEQ'],
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

private function buildApiPayload($baseDirectory, $fileList, $dataType = 'OP')
{
    $filePayload = [];

    foreach ($fileList as $filename => $encoding) {
        $filePath = Yii::getAlias('@webroot/' . $baseDirectory . strtoupper($filename) . '.txt');

        if (file_exists($filePath)) {
            // อ่านไฟล์แบบตัด \n ออก และตัด header (บรรทัดแรก)
            $fileLines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            if (count($fileLines) > 1) {
                array_shift($fileLines); // ลบ header
            }
            $cleanContent = implode("\n", $fileLines);
            $base64Content = base64_encode($cleanContent);
            $fileSize = strlen($cleanContent);

            $filePayload[$filename] = [
                'blobName' => strtoupper($filename) . '.txt',
                'blobType' => 'text/plain',
                'blob' => $base64Content,
                'size' => $fileSize,
                'encoding' => $encoding
            ];
        } else {
            Yii::warning("⚠️ ไม่พบไฟล์: $filePath", __METHOD__);
        }
    }

    $payload = [
        'fileType' => 'txt',
        'maininscl' => 'OFC', 
        'importDup' => false,
        'assignToMe' => false,
        'dataTypes' => [$dataType],
        'opRefer' => false,
        'file' => $filePayload
    ];

    Yii::info("📤 ส่ง Payload สำหรับ $dataType: " . json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), __METHOD__);

    return $this->sendToNhsoApi($payload);
}



########################################################################################################################

     
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