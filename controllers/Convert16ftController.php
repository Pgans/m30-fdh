<?php

namespace app\controllers;

use app\models\YourModel;

use yii;
use yii\helpers\FileHelper;
use app\models\Adp;
use app\models\Cha;
use app\models\Cht;
use app\models\Dru;
use app\models\Ins;
use app\models\Odx;
use app\models\Oop;
use app\models\Opd;
use app\models\Orf;
use app\models\Pat;
use app\models\Labfu;
use yii\widgets\ProgressBar;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\helpers\Console;
use yii\db\Connection;
use yii\db\Command;
use yii\db\Transaction;
use yii\db\Expression;
use ZipArchive;
use yii\helpers\Url;


class Convert16ftController extends \yii\web\Controller
{
    // public function actionIndex()
    // {
    //     return $this->render('index');
    // }

    public function actionIndex()
    {
        $model = new \yii\base\DynamicModel(['uploadFiles']);

        // เพิ่มตัวแปรเพื่อเก็บชื่อไฟล์เดิม
        $originalFileNames = [];

        if (Yii::$app->request->isPost) {
            $model->uploadFiles = UploadedFile::getInstances($model, 'uploadFiles');

            if (!empty($model->uploadFiles)) {
                $uploadPath = Yii::getAlias('@webroot/uploads/file16/');

                // ตรวจสอบและสร้างไดเร็คทอรีหากไม่มี
                FileHelper::createDirectory($uploadPath);

                foreach ($model->uploadFiles as $file) {
                    // ตรวจสอบว่า MIME type ของไฟล์เป็น 'text/plain'
                    if ($file->type === 'text/plain') {
                        $originalFileNames[] = $file->name; // เก็บชื่อไฟล์เดิม
                        $fileName = Yii::$app->security->generateRandomString() . '.' . $file->getExtension();
                        $filePath = $uploadPath . $fileName;
                        $file->saveAs($filePath);

                        // เพิ่มโค้ดตรวจสอบไดเร็คทอรี
                        if (file_exists($uploadPath)) {
                            Yii::info("Directory exists: $uploadPath", 'app');
                        } else {
                            Yii::error("Directory does not exist: $uploadPath", 'app');
                        }

                        // เพิ่มโค้ดตรวจสอบไฟล์
                        if (file_exists($filePath)) {
                            Yii::info("File exists: $filePath", 'app');
                        } else {
                            Yii::error("File does not exist: $filePath", 'app');
                        }

                        Yii::$app->session->setFlash('success', "File saved to: $filePath");

                        // ระบุ Path ไฟล์ที่บันทึกแล้ว
                        return $this->redirect(['convert16/index', 'path' => $filePath]);
                    } else {
                        Yii::$app->session->setFlash('error', 'Only text files are allowed');
                    }
                }

                Yii::$app->session->setFlash('success', 'Upload success');
                return $this->redirect(['convert16/index']);
            } else {
                Yii::$app->session->setFlash('error', 'No files uploaded');
                return $this->redirect(['convert16/index']);
            }
        }

        return $this->render('index', ['model' => $model, 'originalFileNames' => $originalFileNames]);
    }
    #####################################################################################
    public function actionUpdateall()
    {
        try {
            $command = Yii::$app->db16->createCommand("CALL FitTest()");
            $rowsAffected = $command->execute();

            Yii::$app->session->setFlash('success', "เพิ่มเติมข้อมูลในตาราง FitTest สำเร็จ. จำนวน: $rowsAffected");
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'Error executing stored FitTest: ' . $e->getMessage());
        }

        return $this->redirect(['index']); // Redirect to the desired page after execution
    }

    ###########################################################################################
    public function actionUpdate()
    {
        $data = Yii::$app->request->post();
        $date1 = isset($data['date1'])  ? $data['date1'] : '';
        $date2 = isset($data['date2'])  ? $data['date2'] : '';

        $db = Yii::$app->db16;

        $transaction = $db->beginTransaction();

        try {
            ### ลบข้อมูลไม่ตรงกับเงื่อนไขออกก่อน ###########################
            // $sqlDel = "DELETE FROM all_ucs_ncd_screen WHERE (bsl <> ' ' AND age_year < '35')";
            // $commandDel = $db->createCommand($sqlDel);
            // $commandDel->execute();

            #############  ADP ###########################
            $sqlDelete = "DELETE FROM adp";
            $commandDelete = $db->createCommand($sqlDelete);
            $rowsDeleted = $commandDelete->execute();

            Yii::$app->session->setFlash('success', 'Deleted ' . $rowsDeleted . ' rows from adp table.');

            // ... (rest of your code)

            $sql400 = "INSERT INTO adp (hn, an, dateopd, type, code, qty, rate, seq, cagcode, dose, ca_type, serialno, totcopay, use_status, total)
                  SELECT
                m.hn,
                '' AS an,
                replace(n.screen_date, '-','') as dateopd,
                '4' AS type,
                '90005' AS code,
                '1' AS qty,
                '60.00' AS rate,
                n.seq AS seq,
                '' AS cagcode,
                '' AS dose,
                '' AS ca_type,
                '' AS serialno,
                '0.00' AS totcopay,
                '' AS use_status,
                '60.00' AS total
            FROM
                fittest n
						INNER JOIN mathhn m ON m.cid = n.cid
            WHERE
              n.screen_date BETWEEN '$date1' AND '$date2' 
               
            ";

            $command400 = $db->createCommand($sql400);
            $totaladp = $command400->execute();
            ###############################################################################
            $sqlDelete = "DELETE FROM pat";
            $commandDelete = $db->createCommand($sqlDelete);
            $commandDelete->execute();

            $sql401 = "INSERT INTO pat (hcode, hn, changwat, amphur, dob, sex, marriage, occupa, nation, person_id, namepat, title, fname, lname, idtype)
        SELECT 
            '10953' as hcode,
            m.hn,
            IFNULL(n.changwat, '34140') AS changwat,
            n.amphur,
            n.dob,
            n.sex,
            n.marriage,
            n.occupa,
            IFNULL(n.nation, '099') AS nation,
            n.cid as person_id,
            CONCAT(fname, ' ', lname) as namepat,
            n.title,
            n.fname,
            n.lname,
            '1' as idtype
            FROM fittest n
            INNER JOIN mathhn m ON m.cid = n.cid
        ";

            $command401 = $db->createCommand($sql401);
            $totalpat = $command401->execute();

            #############  INS ###########################
            $sqlDelete = "DELETE FROM ins";
            $commandDelete = $db->createCommand($sqlDelete);
            $commandDelete->execute();

            $sql402 = "INSERT INTO ins (hn, inscl, subtype, cid, hcode, dateexp, hospmain, hospsub, govcode, govname, permitno, docno, ownrpid, ownname, an, seq, subinscl, relinscl, htype)
            SELECT 
                m.hn,
                'UCS' as inscl,
                '' as subtype,
                n.cid,
                '10953' as hcode,
                DATE_FORMAT(n.dateexpire, '%Y%m%d') as dateexp,
                COALESCE(n.hosmain, '10953') AS hospmain,
                COALESCE(n.hossub, '10953') AS hospsub,
                '' as govcode,
                '' as govname,
                '' as permitno,
                '' as docno,
                '' as ownrpid,
                '' as ownname,
                '' as an,
                n.seq,
                '' as subinscl,
                '' as relinscl,
                '' as htype
            FROM fittest n           
			INNER JOIN mathhn m ON m.cid = n.cid    
            ";
            $command402 = $db->createCommand($sql402);
            $totalins = $command402->execute();

            #############  ODX ###########################
            $sqlDelete = "DELETE FROM odx";
            $commandDelete = $db->createCommand($sqlDelete);
            $commandDelete->execute();

            $sql404 = "INSERT INTO odx (hn, datedx, clinic, diag, dxtype, drdx, person_id, seq)
SELECT
    m.hn,
    replace(n.screen_date, '-','') as datedx,
    '01500' as clinic,
    COALESCE(REPLACE(vd.diagcode, '.', ''), 'Z131') AS diag,
   COALESCE(RIGHT(vd.dxtype, 1), '1') AS dxtype,
    '28234' as drdx,
    n.cid as person_id,
    n.seq
FROM fittest n
LEFT JOIN visitdiag vd ON vd.visitno = n.seq  
INNER JOIN mathhn m ON m.cid = n.cid  
WHERE 
n.screen_date BETWEEN '$date1' AND '$date2'         
";
            $command404 = $db->createCommand($sql404);
            $totalodx = $command404->execute();

#############  OPD #############################################################################
            $sqlDelete = "DELETE FROM opd";
            $commandDelete = $db->createCommand($sqlDelete);
            $commandDelete->execute();

            $sql405 = "INSERT INTO opd (hn, clinic, dateopd, timeopd, seq, uuc, detail, btemp, sbp, dbp, pr, rr, optype, typein, typeout)
SELECT 
    m.hn,
    '01500' as clinic,
    DATE_FORMAT(n.screen_date, '%Y%m%d') as dateopd,
    LEFT(REPLACE(n.timestart, ':',''), 4) as timeopd,
   # replace(n.timestart, ':','') as timeopd,
    #n.timestart as timeopd,
    n.seq,
    '1' as uuc,
    n.symptoms as detail,
    n.btemp,
    n.sbp as sbp,
    n.dbp as dbp,
    n.pr as pr,
    n.rr as rr,
    '5' as optype,
    '1' as typein,
    '1' as typeout 
FROM fittest n 
INNER JOIN mathhn m ON m.cid = n.cid 
WHERE 
n.screen_date BETWEEN '$date1' AND '$date2' 

  ";
            $command405 = $db->createCommand($sql405);
            $totalopd = $command405->execute();
            ######## DELETE #####################################
            $sqlDelete = "DELETE FROM cha";
            $commandDelete = $db->createCommand($sqlDelete);
            $commandDelete->execute();
            $sqlDelete = "DELETE FROM cht";
            $commandDelete = $db->createCommand($sqlDelete);
            $commandDelete->execute();
            $sqlDelete = "DELETE FROM dru";
            $commandDelete = $db->createCommand($sqlDelete);
            $commandDelete->execute();
            $sqlDelete = "DELETE FROM labfu";
            $commandDelete = $db->createCommand($sqlDelete);
            $commandDelete->execute();
            $sqlDelete = "DELETE FROM oop";
            $commandDelete = $db->createCommand($sqlDelete);
            $commandDelete->execute();
            $sqlDelete = "DELETE FROM orf";
            $commandDelete = $db->createCommand($sqlDelete);
            $commandDelete->execute();

            ###############################################################################################################################
            Yii::$app->session->setFlash('success', 'นำเข้าข้อมูลสำเร็จ.<br> 
    pat: ' . $totalpat . '<br> 
    opd: ' . $totalopd . '<br> 
    adp: ' . $totaladp . '<br> 
    ins: ' . $totalins . '<br> 
    odx: ' . $totalodx);


            // Commit the transaction
            $transaction->commit();
            return $this->redirect(['convert16ft/index']);
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            $transaction->rollBack();

            Yii::$app->session->setFlash('error', 'Error: ' . $e->getMessage());
        }

        return $this->render('index', [
            'date1' => $date1,
            'date2' => $date2,
        ]);
        return $this->redirect(['convert16ft/index']);
    }


    ##################### Export 16 แฟ้ม --> Zipไฟล์ ####################################
    public function actionExports()
    {
        // Get the Yii2 database connection
        $db16 = \Yii::$app->db16;

        // Execute your multiple queries
        $adp = "SELECT hn, an, dateopd, type, code, qty, rate, seq, cagcode, dose, ca_type, serialno, totcopay, use_status, total, qtyday, tmltcode,
      status1, bi, clinic, itemsrc, provider, gravida, gaweek, dcip_e_screen,lmp 
      from adp ";
        #  $cha = " SELECT hn, an, date, chrgitem, amount, person_id, seq FROM cha ";
        #  $cht = " SELECT hn, an, date, total, paid, pttype, person_id, seq, opd_memo, invoice_no, invoice_lt FROM cht";
        #  $dru = " SELECT hcode, hn, an, clinic, person_id, date_serv, did, didname, amount, drugprice, drugcost, didstd, unit, unit_pack, seq, drugremark, pa_no, totcopay, use_status, total, sigcode, sigtext, provider FROM dru ";
        $ins = " SELECT hn,inscl, subtype, cid, hcode, dateexp, hospmain, hospsub, govcode, govname, permitno, docno, ownrpid, ownname, an, seq, subinscl,relinscl, htype FROM ins ";
        #  $labfu = "SELECT hcode, hn, person_id, dateserv, seq, labtest, labresult FROM labfu ";
        $odx = " SELECT hn, datedx, clinic, diag, dxtype, drdx, person_id, seq FROM odx ";
        #  $oop = " SELECT hn, dateopd, clinic, oper, dropid, person_id, seq  FROM oop";
        $opd = " SELECT hn, clinic, dateopd, timeopd, seq, uuc, detail, btemp, sbp, dbp, pr, rr, optype, typein, typeout FROM opd ";
        #  $orf = " SELECT hn, dateopd, clinic, refer, refertype, seq, referdate FROM orf ";
        $pat = " SELECT hcode,hn, changwat, amphur, dob, sex, marriage, occupa, nation, person_id, namepat, title, fname, lname, idtype FROM pat ";
        $results1 = $db16->createCommand($adp)->queryAll();
        # $results2 = $db16->createCommand($cha)->queryAll();
        # $results3 = $db16->createCommand($cht)->queryAll();
        # $results4 = $db16->createCommand($dru)->queryAll();
        $results5 = $db16->createCommand($ins)->queryAll();
        # $results6 = $db16->createCommand($labfu)->queryAll();
        $results7 = $db16->createCommand($odx)->queryAll();
        # $results8 = $db16->createCommand($oop)->queryAll();
        $results9 = $db16->createCommand($opd)->queryAll();
        #  $results10 = $db16->createCommand($orf)->queryAll();
        $results11 = $db16->createCommand($pat)->queryAll();
        //$results10 = $db14->createCommand($query3)->queryAll();
        $results11 = array_map(function ($result) {
            $result['fname'] = str_replace(' ', '', $result['fname']);
            return $result;
        }, $results11);
        $baseDirectory = 'uploads/export16/';
        $mode = 0777; // Set the desired mode (permissions)
        //$baseDirectory1 = 'exports/palliative/all/';
        //$mode = 0777; // Set the desired mode (permissions)

        // Export the results of each query to separate text files
        $this->exportToTextFile(
            $results1,
            $baseDirectory . 'ADP.txt',
            ['HN', 'AN', 'DATEOPD', 'TYPE', 'CODE', 'QTY', 'RATE', 'SEQ', 'CAGCODE', 'DOSE', 'CA_TYPE', 'SERIALNO', 'TOTCOPAY', 'USE_STATUS', 'TOTAL', 'QTYDAY', 'TMTLTCODE', 'STATUS1', 'BI', 'CLINIC', 'ITEMSRC', 'PROVIDER', 'GRAVIDA', 'GAWEEK', 'DCIP_E_screen', 'LMP']
        );



        $this->exportToTextFile(
            $results5,
            $baseDirectory . 'INS.txt',
            ['HN', 'INSCL', 'SUBTYPE', 'CID', 'HCODE', 'DATEEXP', 'HOSPMAIN', 'HOSPSUB', 'GOVCODE', 'GOVNAME', 'PERMITNO', 'DOCNO', 'OWNRPID', 'OWNNAME', 'AN', 'SEQ', 'SUBINSCL', 'RELINSCL', 'HTYPE']
        );

        $this->exportToTextFile(
            $results7,
            $baseDirectory . 'ODX.txt',
            ['HN', 'DATEDX', 'CLINIC', 'DIAG', 'DXTYPE', 'DRDX', 'PERSON_ID', 'SEQ']
        );


        $this->exportToTextFile(
            $results9,
            $baseDirectory . 'OPD.txt',
            ['HN', 'CLINIC', 'DATEOPD', 'TIMEOPD', 'SEQ', 'UUC', 'DETAL', 'BTEMP', 'SBP', 'DBP', 'PR', 'RR', 'OPTYPE', 'TYPEIN', 'TYPEOUT']
        );


        $this->exportToTextFile(
            $results11,
            $baseDirectory . 'PAT.txt',
            ['HCODE', 'HN', 'CHANGWAT', 'AMPHUR', 'DOB', 'SEX', 'MARRIAGE', 'OCCUPA', 'NATION', 'PERSON_ID', 'NAMEPAT', 'TITLE', 'FNAME', 'LNAME', 'IDTYPE']
        ); // Specify header column names


        $currentDateTime = date('YmdHis');
        $zipFilename = $baseDirectory . 'F16_10953_FitTest' . $currentDateTime . '.zip';
        $zip = new ZipArchive();
        $zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $files = FileHelper::findFiles($baseDirectory);

        foreach ($files as $file) {
            // Exclude files from the "uploads" folder
            if (strpos($file, $baseDirectory . '/uploads') !== 0) {
                $relativePath = str_replace($baseDirectory . '/', '', $file);
                $zip->addFile($file, $relativePath);
            }
        }

        $zip->close();

        // Set appropriate headers for downloading the ZIP file
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . basename($zipFilename) . '"');
        header('Content-Length: ' . filesize($zipFilename));

        // Output the contents of the ZIP file
        readfile($zipFilename);

        // Delete the ZIP file after it's downloaded
        unlink($zipFilename);

        // Return to the desired view
        return $this->render('index', ['baseDirectory' => $baseDirectory]);
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
    public function actionExportexcel()
    {
        $sql = "SELECT m.hn, f.screen_date, f.seq, f.cid,
        f.fullname, f.age_year ,f.`ผลตรวจfit test`
         
        FROM fittest f
        LEFT JOIN mathhn m ON m.cid = f.cid
       ORDER BY m.hn
            ";

        $rawData = \yii::$app->db16->createCommand($sql)->queryAll();

        //print_r($rawData);
        try {
            $rawData = \Yii::$app->db16->createCommand($sql)->queryAll();
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
