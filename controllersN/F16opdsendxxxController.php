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

class F16opdsendController extends \yii\web\Controller
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
         # AND o.visit_id  not in (SELECT vs.visit_id from log_all.log_closevisits vs )
          GROUP BY o.VISIT_ID ORDER BY NO DESC LIMIT 8
            ";
        $rawData = \Yii::$app->db14->createCommand($sqlData)->queryAll();


        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 8,
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
        ##################################################################     
        $vn =  Yii::$app->request->post('chkDel');

        foreach ($vn  as $r) {
            $hn = substr($r, 10);
            //echo $hn.'<br />';
            $visit = substr($r, 0, 10);
            $this->visit = $visit;
            $this->hn = $hn;
            //echo $visit . '<br />';
            $db14 = \Yii::$app->db14;
            ##### ดึงข้อมูลให้แสดงรายการผู้มารับบริการ ###############################################
            ################### ADP ##################################################################################
            $adp0 = "SELECT main_query FROM f16_fdh_visit WHERE main_table = 'adp'";
            $results = $db14->createCommand($adp0)->queryAll();
            foreach ($results as $result2) {
                $mainQueryResult = $result2['main_query'];
                $mainQueryResult = str_replace('$visit', $visit, $mainQueryResult);
                //echo $mainQueryResult;
            }
            $adp = $mainQueryResult;
            ################### CHA ##################################################################################
            $cha0 = "SELECT main_query FROM f16_fdh_visit WHERE main_table = 'cha'";
            $results = $db14->createCommand($cha0)->queryAll();
            foreach ($results as $result3) {
                $mainQueryResult = $result3['main_query'];
                $mainQueryResult = str_replace('$visit', $visit, $mainQueryResult);
                //  echo $mainQueryResult;
            }
            $cha = $mainQueryResult;
            // $results2 = $db14->createCommand($cha)->queryAll();

            ######################################################################
            $cht0 = "SELECT main_query FROM f16_fdh_visit WHERE main_table = 'cht'";
            $results = $db14->createCommand($cht0)->queryAll();
            foreach ($results as $result4) {
                $mainQueryResult = $result4['main_query'];
                $mainQueryResult = str_replace('$visit', $visit, $mainQueryResult);
            }
            $cht = $mainQueryResult;
            ######################################################################
            $dru0 = "SELECT main_query FROM f16_fdh_visit WHERE main_table = 'dru'";
            $results = $db14->createCommand($dru0)->queryAll();
            foreach ($results as $result5) {
                $mainQueryResult = $result5['main_query'];
                $mainQueryResult = str_replace('$visit', $visit, $mainQueryResult);
            }
            $dru = $mainQueryResult;

            ################### INS ##################################################################################
            $ins0 = "SELECT main_query FROM f16_fdh_visit WHERE main_table = 'ins'";
            $results = $db14->createCommand($ins0)->queryAll();
            foreach ($results as $result6) {
                $mainQueryResult = $result6['main_query'];
                $mainQueryResult = str_replace('$visit', $visit, $mainQueryResult);
            }
            $ins = $mainQueryResult;
            ################### LABFU ################################################################################
            $labfu = " ";
            ################### AER ################################################################################
            $aer0 = "SELECT main_query FROM f16_fdh_visit WHERE main_table = 'aer'";
            $results = $db14->createCommand($aer0)->queryAll();
            foreach ($results as $result7) {
                $mainQueryResult = $result7['main_query'];
                $mainQueryResult = str_replace('$visit', $visit, $mainQueryResult);
            }
            $aer = $mainQueryResult;
            ################### LVD ################################################################################
            $lvd = "SELECT '' as 'SEQLVD', '' as 'AN', '' as 'DATEOUT', '' as 'TIMEOUT','' as 'DATEIN', '' as 'TIMEIN', '' as 'QYTDAY' ";
            ################### an ################################################################################
            $ipd0 = "SELECT main_query FROM f16_fdh_visit WHERE main_table = 'ipd'";
            $results = $db14->createCommand($ipd0)->queryAll();
            foreach ($results as $result8) {
                $mainQueryResult = $result8['main_query'];
                $mainQueryResult = str_replace('$visit', $visit, $mainQueryResult);
                // echo $mainQueryResult;
            }
            $ipd = $mainQueryResult;

            ################### IDX ################################################################################
            $idx0 = "SELECT main_query FROM f16_fdh_visit WHERE main_table = 'idx'";
            $results = $db14->createCommand($idx0)->queryAll();
            foreach ($results as $result9) {
                $mainQueryResult = $result9['main_query'];
                $mainQueryResult = str_replace('$visit', $visit, $mainQueryResult);
            }
            $idx = $mainQueryResult;

            ################### IOP ################################################################################
            $iop0 = "SELECT main_query FROM f16_fdh_visit WHERE main_table = 'iop'";
            $results = $db14->createCommand($iop0)->queryAll();
            foreach ($results as $result10) {
                $mainQueryResult = $result10['main_query'];
                $mainQueryResult = str_replace('$visit', $visit, $mainQueryResult);
            }
            $iop = $mainQueryResult;

            ################### ODX ##################################################################################
            $odx0 = "SELECT main_query FROM f16_fdh_visit WHERE main_table = 'odx'";
            $results = $db14->createCommand($odx0)->queryAll();
            foreach ($results as $result11) {
                $mainQueryResult = $result11['main_query'];
                $mainQueryResult = str_replace('$visit', $visit, $mainQueryResult);
            }
            $odx = $mainQueryResult;

            ################### OOP ##################################################################################
            $oop0 = "SELECT main_query FROM f16_fdh_visit WHERE main_table = 'oop'";
            $results = $db14->createCommand($oop0)->queryAll();
            foreach ($results as $result12) {
                $mainQueryResult = $result12['main_query'];
                $mainQueryResult = str_replace('$visit', $visit, $mainQueryResult);
                // echo $mainQueryResult;
            }
            $oop = $mainQueryResult;

            ################### OPD ##################################################################################  
            $opd0 = "SELECT main_query FROM f16_fdh_visit WHERE main_table = 'opd'";
            $results = $db14->createCommand($opd0)->queryAll();
            foreach ($results as $result13) {
                $mainQueryResult = $result13['main_query'];
                $mainQueryResult = str_replace('$visit', $visit, $mainQueryResult);
            }
            $opd = $mainQueryResult;

            ################### ORF ##################################################################################
            $orf0 = "SELECT main_query FROM f16_fdh_visit WHERE main_table = 'orf'";
            $results = $db14->createCommand($orf0)->queryAll();
            foreach ($results as $result14) {
                $mainQueryResult = $result14['main_query'];
                $mainQueryResult = str_replace('$visit', $visit, $mainQueryResult);
            }
            $orf = $mainQueryResult;

            ################### IRF ################################################################################## 
            $irf0 = "SELECT main_query FROM f16_fdh_visit WHERE main_table = 'irf'";
            $results = $db14->createCommand($irf0)->queryAll();
            foreach ($results as $result15) {
                $mainQueryResult = $result15['main_query'];
                $mainQueryResult = str_replace('$visit', $visit, $mainQueryResult);
            }
            $irf = $mainQueryResult;

            #################### PAT ##################################################################################
            $pat0 = "SELECT main_query FROM f16_fdh_visit WHERE main_table = 'pat'";
            $results = $db14->createCommand($pat0)->queryAll();
            foreach ($results as $result16) {
                $mainQueryResult = $result16['main_query'];
                $mainQueryResult = str_replace('$visit', $visit, $mainQueryResult);
            }
            $pat = $mainQueryResult;
            ###########################################################################################################
            $results2 = $db14->createCommand($cha)->queryAll();
            $results3 = $db14->createCommand($cht)->queryAll();
            $results4 =  $db14->createCommand($dru)->queryAll();
            $results5 =  $db14->createCommand($ins)->queryAll();
            //$results6 =  $db14->createCommand($labfu)->queryAll();
            $results7 =  $db14->createCommand($odx)->queryAll();
            $results8 =  $db14->createCommand($oop)->queryAll();
            $results9 =  $db14->createCommand($opd)->queryAll();
            $results10 = $db14->createCommand($orf)->queryAll();
            $results11 = $db14->createCommand($pat)->queryAll();
            // $results12 = $db14->createCommand($irf)->queryAll();
            // $results13 = $db14->createCommand($iop)->queryAll();
            // $results14 = $db14->createCommand($idx)->queryAll();
            // $results15 = $db14->createCommand($ipd)->queryAll();
            $results16 = $db14->createCommand($aer)->queryAll();
            //$results17 = $db14->createCommand($lvd)->queryAll();
            $results18 = $db14->createCommand($adp)->queryAll();

            $baseDirectory = 'uploads/fdh_opd/';
            $mode = 0777; // Set the desired mode (permissions)

            // Export the results of the CHA query to a text file
            $chaFile = $baseDirectory . 'CHA.txt';
            $this->exportToTextFile($results2, $chaFile, ['HN', 'AN', 'DATE', 'CHRGITEM', 'AMOUNT', 'PERSON_ID', 'SEQ']);

            // Export the results of the CHT query to a text file
            $chtFile = $baseDirectory . 'CHT.txt';
            $this->exportToTextFile(
                $results3,
                $chtFile,
                ['HN', 'AN', 'DATE', 'TOTAL', 'PAID', 'PTTYPE', 'PERSON_ID', 'SEQ', 'OPD_MEMO', 'INVOICE_NO', 'INVOICE_LT']
            );

            $this->exportToTextFile(
                $results4,
                $baseDirectory . 'DRU.txt',
                ['HCODE', 'HN', 'AN', 'CLINIC', 'PERSON_ID', 'DATE_SERV', 'DID', 'DIDNAME', 'AMOUNT', 'DRUGPRICE', 'DRUGCOST', 'DIDSTD', 'UNIT', 'UNIT_PACK', 'SEQ', 'DRUGREMARK', 'PA_NO', 'TOTCOPAY', 'USE_STATUS', 'TOTAL', 'SIGCODE', 'SIGTEXT', 'PROVIDER']
            );

            $this->exportToTextFile(
                $results5,
                $baseDirectory . 'INS.txt',
                ['HN', 'INSCL', 'SUBTYPE', 'CID', 'HCODE', 'DATEEXP', 'HOSPMAIN', 'HOSPSUB', 'GOVCODE', 'GOVNAME', 'PERMITNO', 'DOCNO', 'OWNRPID', 'OWNNAME', 'AN', 'SEQ', 'SUBINSCL', 'RELINSCL', 'HTYPE']
            );

            // $this->exportToTextFile($results6, $baseDirectory . 'LABFU.txt',
            // ['HCODE', 'HN', 'PERSON_ID', 'DATESERV', 'SEQ', 'LABTEST', 'LABRESULT']); 

            $this->exportToTextFile(
                $results7,
                $baseDirectory . 'ODX.txt',
                ['HN', 'DATEDX', 'CLINIC', 'DIAG', 'DXTYPE', 'DRDX', 'PERSON_ID', 'SEQ']
            );

            $this->exportToTextFile(
                $results8,
                $baseDirectory . 'OOP.txt',
                ['HN', 'DATEOPD', 'CLINIC', 'OPER', 'DROPID', 'PERSON_ID', 'SEQ']
            );

            $this->exportToTextFile(
                $results9,
                $baseDirectory . 'OPD.txt',
                //['HN', 'CLINIC', 'DATEOPD', 'TIMEOPD', 'SEQ', 'UUC']
                ['HN', 'CLINIC', 'DATEOPD', 'TIMEOPD', 'SEQ', 'UUC', 'DETAIL', 'BTEMP', 'SBP', 'DBP', 'PR', 'RR', 'OPTYPE', 'TYPEIN', 'TYPEOUT']

            );

            $this->exportToTextFile(
                $results10,
                $baseDirectory . 'ORF.txt',
                ['HN', 'DATEOPD', 'CLINIC', 'REFER', 'REFERTYPE', 'SEQ', 'REFERDATE']
            );

            $this->exportToTextFile(
                $results11,
                $baseDirectory . 'PAT.txt',
                ['HCODE', 'HN', 'CHANGWAT', 'AMPHUR', 'DOB', 'SEX', 'MARRIAGE', 'OCCUPA', 'NATION', 'PERSON_ID', 'NAMEPAT', 'TITLE', 'FNAME', 'LNAME', 'IDTYPE']
            );

            $this->exportToTextFile(
                $results16,
                $baseDirectory . 'AER.txt',
                ['HN', 'AN', 'DATEOPD', 'AUTHAE', 'AEDATE', 'AETIME', 'AETYPE', 'REFER_NO', 'REFMAINI', 'IREFTYPE', 'REFMAINO', 'OREFTYPE', 'UCAE', 'EMTYPE', 'SEQ', 'AESTATUS', 'DALERT', 'TALERT']
            );

            $this->exportToTextFile(
                $results18,
                $baseDirectory . 'ADP.txt',
                [
                    'HN', 'AN', 'DATEOPD', 'TYPE', 'CODE', 'QTY', 'RATE', 'SEQ', 'CAGCODE', 'DOSE', 'CA_TYPE', 'SERIALNO', 'TOTCOPAY', 'USE_STATUS', 'TOTAL', 'QTYDAY', 'TMLTCODE',
                    'STATUS1', 'BI', 'CLINIC', 'ITEMSRC', 'PROVIDER', 'GRAVIDA', 'GA_WEEK', 'DCIP/E_SCREEN', 'LMP'
                ]
            );
        }
    }

    private function exportToTextFile($data, $filePath, $header = [])
    {
        // เปิดไฟล์เพื่อเขียนโดยลบเนื้อหาเก่าทั้งหมดและเปลี่ยนโหมดเป็น 'wb' เพื่อให้สามารถเขียนข้อมูลในโหมด binary
        $file = fopen($filePath, 'wb');

        // Write the header row to the file
        if (!empty($header)) {
            fputcsv($file, $header, "|");
        }

        // Write the data rows to the file
        foreach ($data as $row) {
            array_walk($row, function (&$value) {
                // แปลงค่าให้เป็น UTF-8 หากยังไม่ได้เป็น
                $value = mb_convert_encoding($value, 'UTF-8', mb_detect_encoding($value));
            });
            fputcsv($file, $row, "|");
        }

        // ปิดไฟล์
        fclose($file);

        // แปลงไฟล์เป็นรูปแบบ Windows (CR LF)
        $this->convertToWindowsCrLf($filePath);
    }

    private function convertToWindowsCrLf($filePath)
    {
        // อ่านเนื้อหาของไฟล์เป็น string
        $content = file_get_contents($filePath);

        // แทนที่ระบบขึ้นบรรทัดใหม่ให้เป็นรูปแบบ Windows (CR LF)
        $content = str_replace("\n", "\r\n", $content);

        // เขียนเนื้อหากลับไปยังไฟล์
        file_put_contents($filePath, $content);
        $this->actionSend($this->visit, $this->hn);
    }

    public function actionSend($visit, $hn)
    {
        $sqltoken = "SELECT MAX(token) as token30 FROM fdh_token";
        $data = Yii::$app->db14->createCommand($sqltoken)->queryOne();

        if ($data && isset($data['token30'])) {
            $token30 = $data['token30'];

            // Array of file paths to be uploaded
            $file_paths = [
                __DIR__ . '/../web/uploads/fdh_opd/PAT.txt',
                __DIR__ . '/../web/uploads/fdh_opd/INS.txt',
                __DIR__ . '/../web/uploads/fdh_opd/OPD.txt',
                __DIR__ . '/../web/uploads/fdh_opd/ADP.txt',
                __DIR__ . '/../web/uploads/fdh_opd/AER.txt',
                __DIR__ . '/../web/uploads/fdh_opd/CHA.txt',
                //__DIR__ . '/../web/uploads/fdh_opd/CHT.txt',
                //__DIR__ . '/../web/uploads/fdh_opd/DRU.txt',
                __DIR__ . '/../web/uploads/fdh_opd/OOP.txt',
                __DIR__ . '/../web/uploads/fdh_opd/ODX.txt',
                __DIR__ . '/../web/uploads/fdh_opd/ORF.txt',

            ];

            $client = new Client();
            $request = $client->createRequest()
                ->setMethod('POST')
                ->setUrl('https://uat-fdh.inet.co.th/api/v2/data_hub/16_files/')
                ->addHeaders([
                    'Authorization' => 'Bearer ' . $token30,
                    'Content-Type' => 'multipart/form-data',
                ]);
            foreach ($file_paths as $file_path) {
                // Check if file exists
                if (file_exists($file_path)) {
                    $request->addFile('file', $file_path, [
                        'content-type' => 'text/plain'
                    ]);
                }
            }
            $request->addData([
                'key' => 'value',
                'type' => 'txt',
            ]);

            // Send request and get response
            $response = $request->send();
            // Decode JSON response
            $ofdh = json_decode($response->getContent(), true); 
            $message = $ofdh['message']; 
            $message_th = $ofdh['message_th']; 

            // Check for errors
            if ($response->isOk) {
                // Process response
                $responseData = $response->getData();
                Yii::$app->session->setFlash('success', 'ส่งข้อมูลสำเร็จ.');
            } else {
                $errorMessage = "Error: " . $response->getStatusCode() . " " . $response->getContent() . " for visit: " . $visit;
                Yii::$app->session->setFlash('error', $errorMessage);
            }
            ############################INSERT TABLE Log_dmht#############################
            echo $visit;
            if (strlen($response) > 0) {
                $strSQL = "REPLACE INTO log_fdh_opd (visit_id, pid, messagecode ,response , users,d_update) VALUES ('$visit','$hn','$message','$message_th' ,'ofdh',NOW())";
                Yii::$app->db143->createCommand($strSQL)->execute();
            }
        }
        return $this->redirect(['index']);
    }
}
