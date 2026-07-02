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

class F16ancdentController extends \yii\web\Controller
{
    public function actionIndex()
    {
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
        GROUP_CONCAT(DISTINCT trim(icd.ICD10_TM)) as Diag
        ,left(e.unit_name,10) 'unit_name', 
        f.INSCL_NAME as 'inscl',
        (cg01+cg02+cg03+ cg04+ cg05 + cg06+ cg07+ cg08+ cg08+ cg09+ cg10+ cg11+ cg12+ cg13+ cg14+ cg15+ cg16+cg17+ cg18+ cg19 ) as amount,
        g.hospmain, g.hospsub,
        g.UC_REGISTER,g.UC_EXPIRE,
        h.HOSP_ID as 'sss',
        h.SSS_DATE,h.EXP_DATE
        ,IFNULL(ak.claimcode, '') AS claimcode
          FROM (select @n := 0) m, opd_visits o 
          INNER JOIN cid_hn c on o.HN= c.HN
          INNER JOIN population p on c.CID=p.CID AND left(p.cid,5) <> '00000'
          INNER JOIN opd_diagnosis d ON d.visit_id = o.visit_id AND d.is_cancel = 0 
          LEFT JOIN icd10new icd ON icd.icd10 = d.icd10 AND icd.icd10 <> ''
          LEFT JOIN ipd_reg ir ON ir.VISIT_ID = o.visit_id  AND ir.IS_CANCEL = 0
          INNER JOIN service_units e ON o.UNIT_REG=e.unit_id
          LEFT JOIN lab_requests lr ON lr.visit_id = o.visit_id AND lr.is_cancel = 0 
          LEFT JOIN lab_lists l ON l.lab_id = lr.lab_id 
LEFT JOIN main_inscls f ON o.INSCL = f.INSCL
LEFT JOIN uc_inscl g ON c.CID= g.CID AND (g.date_abort > date(o.REG_DATETIME) OR DAY(g.DATE_ABORT)=0)  and trim(g.hospmain) <>''
LEFT JOIN hosp_sss h ON c.CID=h.CID AND (h.date_abort > date(o.REG_DATETIME) OR DAY(h.DATE_ABORT) = 0 )and trim(h.HOSP_ID) <>''  
          LEFT JOIN authen_kiosk ak ON p.CID = ak.cid  AND date(o.REG_DATETIME)=date(ak.d_update)
LEFT JOIN cost_visits cos ON cos.visit_id = o.visit_id 
          WHERE o.IS_CANCEL = 0
            AND o.REG_DATETIME BETWEEN CURDATE()-5 AND CURDATE()
AND o.unit_reg <> '42'
AND o.inscl in ('03','04')
AND (cg01+cg02+cg03+ cg04+ cg05 + cg06+ cg07+ cg08+ cg08+ cg09+ cg10+ cg11+ cg12+ cg13+ cg14+ cg15+ cg16+cg17+ cg18+ cg19 )<> ''
          AND o.visit_id not in (SELECT ipd_reg.VISIT_ID FROM ipd_reg WHERE ipd_reg.IS_CANCEL=0)
          AND o.visit_id  not in (SELECT vs.visit_id from log_all.log_fdh_opd vs )
          GROUP BY o.VISIT_ID ORDER BY NO DESC LIMIT 3
            ";
        $rawData = \Yii::$app->db14->createCommand($sqlData)->queryAll();


        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 3,
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
                $hn = substr($r, 10);
                $visit = substr($r, 0, 10);
    
                $db14 = \Yii::$app->db14;
    
                $baseDirectory = 'uploads/fdh_opd/';
                $mode = 0777;
    
                $tables = ['adp', 'cha', 'cht', 'dru', 'ins', 'odx', 'oop', 'opd', 'orf', 'pat', 'aer'];
                foreach ($tables as $table) {
                    $query = "SELECT main_query FROM f16_fdh_visit WHERE main_table = '$table'";
                    $results = $db14->createCommand($query)->queryAll();
                    foreach ($results as $result) {
                        $mainQueryResult = $result['main_query'];
                        $mainQueryResult = str_replace('$visit', $visit, $mainQueryResult);
                        $data = $db14->createCommand($mainQueryResult)->queryAll();
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
            $sqltoken = "SELECT MAX(token) as token30 FROM fdh_token";
            $data = Yii::$app->db14->createCommand($sqltoken)->queryOne();
    
            if ($data && isset($data['token30'])) {
                $token30 = $data['token30'];
    
                $filePaths = [
                    __DIR__ . '/../web/uploads/fdh_opd/PAT.txt',
                    __DIR__ . '/../web/uploads/fdh_opd/INS.txt',
                    __DIR__ . '/../web/uploads/fdh_opd/OPD.txt',
                    __DIR__ . '/../web/uploads/fdh_opd/ADP.txt',
                    __DIR__ . '/../web/uploads/fdh_opd/AER.txt',
                    __DIR__ . '/../web/uploads/fdh_opd/CHA.txt',
                    __DIR__ . '/../web/uploads/fdh_opd/OOP.txt',
                    __DIR__ . '/../web/uploads/fdh_opd/ODX.txt',
                    __DIR__ . '/../web/uploads/fdh_opd/ORF.txt',
                    __DIR__ . '/../web/uploads/fdh_opd/CHT.txt',
                    __DIR__ . '/../web/uploads/fdh_opd/DRU.txt',
                   // __DIR__ . '/../web/uploads/fdh_opd/LABFU.txt',
                ];
    
                $client = new Client();
                $request = $client->createRequest()
                    ->setMethod('POST')
                    ->setUrl('https://uat-fdh.inet.co.th/api/v2/data_hub/16_files/')
                    ->addHeaders([
                        'Authorization' => 'Bearer ' . $token30,
                        'Content-Type' => 'multipart/form-data',
                    ]);
                foreach ($filePaths as $filePath) {
                    if (file_exists($filePath)) {
                        $request->addFile('file', $filePath, ['content-type' => 'text/plain']);
                    }
                }
                $request->addData([
                    'key' => 'value',
                    'type' => 'txt',
                ]);
    
                $response = $request->send();
                $ofdh = json_decode($response->getContent(), true);
                $message = $ofdh['message'];
                $message_th = $ofdh['message_th'];
    
                if ($response->isOk) {
                    $responseData = $response->getData();
                    Yii::$app->session->setFlash('success', 'ส่งข้อมูลสำเร็จ.');
                } else {
                    $errorMessage = "Error: " . $response->getStatusCode() . " " . $response->getContent() . " for visit: " . $visit;
                    Yii::$app->session->setFlash('error', $errorMessage);
                }
    
                if (strlen($response) > 0) {
                    $strSQL = "REPLACE INTO log_fdh_opd (visit_id, pid, messagecode ,response , users,d_update) VALUES ('$visit','$hn','$message','$message_th' ,'ofdh',NOW())";
                    Yii::$app->db143->createCommand($strSQL)->execute();
                }
            }
        }
    }