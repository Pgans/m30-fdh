<?php

namespace app\controllers;

use yii;
use yii\helpers\FileHelper;
use ZipArchive;

class F16onlyController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $sqlData = "SELECT DISTINCT 
        @n :=@n +1 'No',
        o.visit_id,
				o.hn ,
        ip.ADM_ID as an,
				CONCAT(    CASE
            WHEN p.PRENAME not in('') THEN TRIM(p.PRENAME)
                #WHEN TIMESTAMPDIFF(year,pv.BIRTHDATE,NOW())< '20' AND pv.sex='1' AND pv.MARRIAGE = '4'THEN 'สามเณร'
                #WHEN TIMESTAMPDIFF(year,pv.BIRTHDATE,NOW()) >= '20' AND pv.sex='1' AND pv.MARRIAGE  = '4'THEN 'พระภิกษุ'
                WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='1' THEN 'ด.ช.'
                WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='1' THEN 'นาย'
                WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='2' THEN 'ด.ญ.'
                WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='2' AND p.MARRIAGE ='1' THEN 'น.ส.'
                ELSE 'นาง' END ,'',TRIM(p.fname),'  ',p.lname) as fullname,
        TIMESTAMPDIFF(year,p.BIRTHDATE,o.REG_DATETIME) as age,
				s.unit_name,
				j.ICD10_TM as Diag,
				ip.adm_dt as admit,
				ip.dsc_dt as dsc,
				CASE 
				WHEN o.INSCL in (03,04) AND g.HOSPMAIN ='10953' THEN CONCAT(f.INSCL_NAME,' -ในเขต') 
				WHEN o.INSCL in (03,04) AND g.HOSPMAIN !='10953' THEN CONCAT(f.INSCL_NAME,' -นอกเขต') 
				ELSE f.INSCL_NAME 
				END as 'inscl'

        FROM (select @n := 0) m1,opd_visits o 
        LEFT JOIN cid_hn b on o.HN = b.HN
        LEFT JOIN population p on b.CID = p.CID
        LEFT JOIN opd_diagnosis i ON o.VISIT_ID = i.VISIT_ID AND i.IS_CANCEL = 0 AND i.DXT_ID = '1'
        LEFT JOIN icd10new j ON i.ICD10 = j.ICD10
        LEFT JOIN ipd_reg ip on ip.VISIT_ID = o.VISIT_ID AND ip.IS_CANCEL = 0
        LEFT JOIN service_units s ON s.unit_id = o.unit_reg
				LEFT JOIN main_inscls f ON o.INSCL = f.INSCL
				LEFT JOIN uc_inscl g ON p.CID = g.CID AND (g.date_abort > date(o.REG_DATETIME) OR DAY(g.DATE_ABORT)= 0)  and trim(g.hospmain) <>''
				LEFT JOIN hosp_sss h ON p.CID = h.CID AND (h.date_abort > date(o.REG_DATETIME) OR DAY(h.DATE_ABORT) = 0 )and trim(h.HOSP_ID) <>'' 
        WHERE o.IS_CANCEL = 0
        AND o.REG_DATETIME BETWEEN '2024-01-01 00:01' AND '2024-01-01 23:01'
        GROUP BY o.VISIT_ID
        ORDER BY NO DESC
            ";
        $rawData = \Yii::$app->db14->createCommand($sqlData)->queryAll();


        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        return $this->render('index', [
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider, 

        ]);
    }
    public function actionData()
    {
        $data = Yii::$app->request->post();
        //$date1 =isset($data['date1'])  ? $data['date1'] : '';
        // $date2 =isset($data['date2'])  ? $data['date2'] : '';

        $date1 = isset($data['date1']) ? date('Y-m-d 00:01', strtotime($data['date1'])) : '';
        $date2 = isset($data['date2']) ? date('Y-m-d 23:59', strtotime($data['date2'])) : '';
        //echo $date1;
        //echo $date2;

        $db14 = \Yii::$app->db14;
        ##### ดึงข้อมูลให้แสดงรายการผู้มารับบริการ ###############################################
        ################### ADP ##################################################################################
        $adp0 = "SELECT main_query FROM f16_fdh_ipd WHERE main_table = 'adp'";
        $results = $db14->createCommand($adp0)->queryAll();
        foreach ($results as $result2) {
            $mainQueryResult = $result2['main_query'];
            $mainQueryResult = str_replace('$date1', $date1, $mainQueryResult);
            $mainQueryResult = str_replace('$date2', $date2, $mainQueryResult);
            // echo $mainQueryResult;
        }
        $adp = $mainQueryResult;
        ################### CHA ##################################################################################
        $cha0 = "SELECT main_query FROM f16_fdh_ipd WHERE main_table = 'cha'";
        $results = $db14->createCommand($cha0)->queryAll();
        foreach ($results as $result3) {
            $mainQueryResult = $result3['main_query'];
            $mainQueryResult = str_replace('$date1', $date1, $mainQueryResult);
            $mainQueryResult = str_replace('$date2', $date2, $mainQueryResult);
            // echo $mainQueryResult;
        }
        $cha = $mainQueryResult;
        // $results2 = $db14->createCommand($cha)->queryAll();

        ######################################################################
        $cht0 = "SELECT main_query FROM f16_fdh_ipd WHERE main_table = 'cht'";
        $results = $db14->createCommand($cht0)->queryAll();
        foreach ($results as $result4) {
            $mainQueryResult = $result4['main_query'];
            $mainQueryResult = str_replace('$date1', $date1, $mainQueryResult);
            $mainQueryResult = str_replace('$date2', $date2, $mainQueryResult);
        }
        $cht = $mainQueryResult;
        ######################################################################
        $dru0 = "SELECT main_query FROM f16_fdh_ipd WHERE main_table = 'dru'";
        $results = $db14->createCommand($dru0)->queryAll();
        foreach ($results as $result5) {
            $mainQueryResult = $result5['main_query'];
            $mainQueryResult = str_replace('$date1', $date1, $mainQueryResult);
            $mainQueryResult = str_replace('$date2', $date2, $mainQueryResult);
        }
        $dru = $mainQueryResult;

        ################### INS ##################################################################################
        $ins0 = "SELECT main_query FROM f16_fdh_ipd WHERE main_table = 'ins'";
        $results = $db14->createCommand($ins0)->queryAll();
        foreach ($results as $result6) {
            $mainQueryResult = $result6['main_query'];
            $mainQueryResult = str_replace('$date1', $date1, $mainQueryResult);
            $mainQueryResult = str_replace('$date2', $date2, $mainQueryResult);
        }
        $ins = $mainQueryResult;
        ################### LABFU ################################################################################
        $labfu = " ";
        ################### AER ################################################################################
        $aer0 = "SELECT main_query FROM f16_fdh_ipd WHERE main_table = 'aer'";
        $results = $db14->createCommand($aer0)->queryAll();
        foreach ($results as $result7) {
            $mainQueryResult = $result7['main_query'];
            $mainQueryResult = str_replace('$date1', $date1, $mainQueryResult);
            $mainQueryResult = str_replace('$date2', $date2, $mainQueryResult);
        }
        $aer = $mainQueryResult;
        ################### LVD ################################################################################
        $lvd = "SELECT '' as 'SEQLVD', '' as 'AN', '' as 'DATEOUT', '' as 'TIMEOUT','' as 'DATEIN', '' as 'TIMEIN', '' as 'QYTDAY' ";
        ################### IPD ################################################################################
        $ipd0 = "SELECT main_query FROM f16_fdh_ipd WHERE main_table = 'ipd'";
        $results = $db14->createCommand($ipd0)->queryAll();
        foreach ($results as $result8) {
            $mainQueryResult = $result8['main_query'];
            $mainQueryResult = str_replace('$date1', $date1, $mainQueryResult);
            $mainQueryResult = str_replace('$date2', $date2, $mainQueryResult);
           // echo $mainQueryResult;
        }
        $ipd = $mainQueryResult;

        ################### IDX ################################################################################
        $idx0 = "SELECT main_query FROM f16_fdh_ipd WHERE main_table = 'idx'";
        $results = $db14->createCommand($idx0)->queryAll();
        foreach ($results as $result9) {
            $mainQueryResult = $result9['main_query'];
            $mainQueryResult = str_replace('$date1', $date1, $mainQueryResult);
            $mainQueryResult = str_replace('$date2', $date2, $mainQueryResult);
        }
        $idx = $mainQueryResult;

        ################### IOP ################################################################################
        $iop0 = "SELECT main_query FROM f16_fdh_ipd WHERE main_table = 'iop'";
        $results = $db14->createCommand($iop0)->queryAll();
        foreach ($results as $result10) {
            $mainQueryResult = $result10['main_query'];
            $mainQueryResult = str_replace('$date1', $date1, $mainQueryResult);
            $mainQueryResult = str_replace('$date2', $date2, $mainQueryResult);
        }
        $iop = $mainQueryResult;

        ################### ODX ##################################################################################
        $odx0 = "SELECT main_query FROM f16_fdh_ipd WHERE main_table = 'odx'";
        $results = $db14->createCommand($odx0)->queryAll();
        foreach ($results as $result11) {
            $mainQueryResult = $result11['main_query'];
            $mainQueryResult = str_replace('$date1', $date1, $mainQueryResult);
            $mainQueryResult = str_replace('$date2', $date2, $mainQueryResult);
        }
        $odx = $mainQueryResult;

        ################### OOP ##################################################################################
        $oop0 = "SELECT main_query FROM f16_fdh_ipd WHERE main_table = 'oop'";
        $results = $db14->createCommand($oop0)->queryAll();
        foreach ($results as $result12) {
            $mainQueryResult = $result12['main_query'];
            $mainQueryResult = str_replace('$date1', $date1, $mainQueryResult);
            $mainQueryResult = str_replace('$date2', $date2, $mainQueryResult);
        }
        $oop = $mainQueryResult;

        ################### OPD ##################################################################################  
        $opd0 = "SELECT main_query FROM f16_fdh_ipd WHERE main_table = 'opd'";
        $results = $db14->createCommand($opd0)->queryAll();
        foreach ($results as $result13) {
            $mainQueryResult = $result13['main_query'];
            $mainQueryResult = str_replace('$date1', $date1, $mainQueryResult);
            $mainQueryResult = str_replace('$date2', $date2, $mainQueryResult);
        }
        $opd = $mainQueryResult;

        ################### ORF ##################################################################################
        $orf0 = "SELECT main_query FROM f16_fdh_ipd WHERE main_table = 'orf'";
        $results = $db14->createCommand($orf0)->queryAll();
        foreach ($results as $result14) {
            $mainQueryResult = $result14['main_query'];
            $mainQueryResult = str_replace('$date1', $date1, $mainQueryResult);
            $mainQueryResult = str_replace('$date2', $date2, $mainQueryResult);
        }
        $orf = $mainQueryResult;

        ################### IRF ################################################################################## 
        $irf0 = "SELECT main_query FROM f16_fdh_ipd WHERE main_table = 'irf'";
        $results = $db14->createCommand($irf0)->queryAll();
        foreach ($results as $result15) {
            $mainQueryResult = $result15['main_query'];
            $mainQueryResult = str_replace('$date1', $date1, $mainQueryResult);
            $mainQueryResult = str_replace('$date2', $date2, $mainQueryResult);
        }
        $irf = $mainQueryResult;

        #################### PAT ##################################################################################
        $pat0 = "SELECT main_query FROM f16_fdh_ipd WHERE main_table = 'pat'";
        $results = $db14->createCommand($pat0)->queryAll();
        foreach ($results as $result16) {
            $mainQueryResult = $result16['main_query'];
            $mainQueryResult = str_replace('$date1', $date1, $mainQueryResult);
            $mainQueryResult = str_replace('$date2', $date2, $mainQueryResult);
        }
        $pat = $mainQueryResult;
        ###########################################################################################################
        $results2 = $db14->createCommand($cha)->queryAll();
        $results3 = $db14->createCommand($cht)->queryAll();
        $results4 =  $db14->createCommand($dru)->queryAll();
        $results5 =  $db14->createCommand($ins)->queryAll();
        // $results6 =  $db14->createCommand($labfu)->queryAll();
        //$results7 =  $db14->createCommand($odx)->queryAll();
        // $results8 =  $db14->createCommand($oop)->queryAll();
        // $results9 =  $db14->createCommand($opd)->queryAll();
        // $results10 = $db14->createCommand($orf)->queryAll();
        $results11 = $db14->createCommand($pat)->queryAll();
        $results12 = $db14->createCommand($irf)->queryAll();
        $results13 = $db14->createCommand($iop)->queryAll();
        $results14 = $db14->createCommand($idx)->queryAll();
        $results15 = $db14->createCommand($ipd)->queryAll();
        $results16 = $db14->createCommand($aer)->queryAll();
        //$results17 = $db14->createCommand($lvd)->queryAll();
        $results18 = $db14->createCommand($adp)->queryAll();

        $baseDirectory = 'uploads/F16_claim/';
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
        //['HCODE', 'HN', 'PERSON_ID', 'DATESERV', 'SEQ', 'LABTEST', 'LABRESULT']); 

        // $this->exportToTextFile(
        //     $results7,
        //     $baseDirectory . 'ODX.txt',
        //     ['HN', 'DATEDX', 'CLINIC', 'DIAG', 'DXTYPE', 'DRDX', 'PERSON_ID', 'SEQ']
        // );

        // $this->exportToTextFile(
        //     $results8,
        //     $baseDirectory . 'OOP.txt',
        //     ['HN', 'DATEOPD', 'CLINIC', 'PER', 'DROPID', 'PERSON_ID', 'SEQ']
        // );

        // $this->exportToTextFile(
        //     $results9,
        //     $baseDirectory . 'OPD.txt',
        //     ['HN', 'CLINIC', 'DATEOPD', 'TIMEOPD', 'SEQ', 'UUC', 'DETAL', 'BTEMP', 'SBP', 'DBP', 'PR', 'RR', 'OPTYPE', 'TYPEIN', 'TYPEOUT']
        // );

        // $this->exportToTextFile(
        //     $results10,
        //     $baseDirectory . 'ORF.txt',
        //     ['HN', 'DATEOPD', 'CLINIC', 'REFER', 'REFERTYPE', 'SEQ', 'REFERDATE']
        // );

        $this->exportToTextFile(
            $results11,
            $baseDirectory . 'PAT.txt',
            ['HCODE', 'HN', 'CHANGWAT', 'AMPHUR', 'DOB', 'SEX', 'MARRIAGE', 'OCCUPA', 'NATION', 'PERSON_ID', 'NAMEPAT', 'TITLE', 'FNAME', 'LNAME', 'IDTYPE']
        );

        $this->exportToTextFile(
            $results12,
            $baseDirectory . 'IRF.txt',
            ['AN', 'REFER', 'REFERTYPE']
        );

        $this->exportToTextFile(
            $results13,
            $baseDirectory . 'IOP.txt',
            ['AN', 'OPER', 'OPTYPE', 'DROPID', 'DATEIN', 'TIMEIN', 'DATEOUT', 'TIMEOUT']
        );

        $this->exportToTextFile(
            $results14,
            $baseDirectory . 'IDX.txt',
            ['AN', 'DIAG', 'DXTYPE', 'DRDX']
        );

        $this->exportToTextFile(
            $results15,
            $baseDirectory . 'IPD.txt',
            ['HN', 'AN', 'DATEADM', 'TIMEADM', 'DATEDSC', 'TIMEDSC', 'DISCHS', 'DISCHT', 'WARDDSC', 'DEPT', 'ADM_W', 'UUC', 'SVCTYPE']
        );
        #
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

        Yii::$app->session->setFlash(
            'success',
            'นับจำนวนในไฟล์.<br>' .
                'Total cha: ' . count($results2) . '<br>' .
                'Total cht: ' . count($results3) . '<br>' .
                'Total dru: ' . count($results4) . '<br>' .
                'Total ins: ' . count($results5) . '<br>' .
                // 'Total labfu: ' . count($results6) . '<br>' .
                // 'Total odx: ' . count($results7) . '<br>' .
                // 'Total oop: ' . count($results8) . '<br>' .
                // 'Total opd: ' . count($results9) . '<br>' .
                // 'Total orf: ' . count($results10) . '<br>' .
                'Total pat: ' . count($results11) . '<br>' .
                'Total irf: ' . count($results12) . '<br>' .
                'Total iop: ' . count($results13) . '<br>' .
                'Total idx: ' . count($results14) . '<br>' .
                'Total ipd: ' . count($results15) . '<br>' .
                'Total aer: ' . count($results16) . '<br>' .
                // 'Total lvd: ' . count($results17) . '<br>' .
                'Total adp: ' . count($results18) . '<br>'
        );
        Yii::$app->session->setFlash('timeout', 50000);

        return $this->redirect(['index']);

    }



    public function actionExports()
    {
        $baseDirectory = 'uploads/F16_claim/';
        $mode = 0777; // Set the desired mode (permissions)
        $currentDateTime = date('Ymd_His');
        $zipFilename = $baseDirectory . 'F16_10953_IPD' . $currentDateTime . '.zip';
        // Open the ZIP file
        $zip = new ZipArchive();
        $zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // Find all files in the specified directory and add them to the ZIP archive
        $files = FileHelper::findFiles($baseDirectory);
        foreach ($files as $file) {
            $relativePath = str_replace($baseDirectory . '/', '', $file);
            $zip->addFile($file, $relativePath);
        }

        // Close the ZIP archive
        $zip->close();

        // Set appropriate headers for downloading
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . basename($zipFilename) . '"');
        header('Content-Length: ' . filesize($zipFilename));

        // Serve the ZIP file
        readfile($zipFilename);

        // Delete the ZIP file after it's downloaded
        unlink($zipFilename);

        // Redirect to f16only/index after the download
        //header('Location: /f16only/index');
        //exit; // Make sure to exit to prevent further execution
        // return $this->render('data', ['baseDirectory' => $baseDirectory]);
    }

    private function exportToTextFile($data, $filePath, $header = [])
    {
        $file = fopen($filePath, 'w');

        // Set the file encoding to UTF-8
        fprintf($file, "\xEF\xBB\xBF");

        // Write the header row to the file
        if (!empty($header)) {
            fputcsv($file, $header, "|");
        }

        // Write the data rows to the file
        foreach ($data as $row) {
            array_walk($row, function (&$value) {
                $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            });
            fputcsv($file, $row, "|");
        }

        fclose($file);
    }
}
