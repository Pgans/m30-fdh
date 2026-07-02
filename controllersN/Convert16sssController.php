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


class Convert16sssController extends \yii\web\Controller
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

    ###############   #################################
    public function actionImports()
    {
        // Import file1.txt into table1
        adp::deleteAll();
        $filePath1 = 'uploads/file16/ADP.txt';
        $handle1 = fopen($filePath1, 'r');
        fgets($handle1); // Skip headers
        $recordCount1 = 0;
        #HN|AN|DATEOPD|TYPE|CODE|QTY|RATE|SEQ|CAGCODE|DOSE|CA_TYPE|SERIALNO|TOTCOPAY|
        #USE_STATUS|TOTAL|QTYDAY|TMLTCODE|STATUS1|BI|CLINIC|ITEMSRC|PROVIDER|GRAVIDA|GAWEEK|DCIP_E_screen|LMP
        while (($data1 = fgetcsv($handle1, 1000, '|')) !== false) {
            $model1 = new Adp();
            $model1->hn = $data1[0];
            $model1->an = $data1[1];
            $model1->dateopd = $data1[2];
            $model1->type = $data1[3];
            $model1->code = $data1[4];
            $model1->qty = $data1[5];
            $model1->rate = $data1[6];
            $model1->seq = $data1[7];
            $model1->cagcode = $data1[8];
            $model1->dose = $data1[9];
            $model1->ca_type = $data1[10];
            $model1->serialno = $data1[11];
            $model1->totcopay = $data1[12];
            $model1->use_status = $data1[13];
            $model1->total = $data1[14];
            $model1->qtyday = $data1[15];
            $model1->tmltcode = $data1[16];
            $model1->status1 = $data1[17];
            $model1->bi = $data1[18];
            $model1->clinic = $data1[19];
            $model1->itemsrc = $data1[20];
            $model1->provider = $data1[21];
            $model1->gravida = $data1[22];
            $model1->gaweek = $data1[23];
            $model1->dcip_e_screen = $data1[24];
            $model1->lmp = $data1[25];
            // $model1->save();  
            if ($model1->save()) {
                $recordCount1++;
                //echo ' ADP successfully.';
            } else {
                //echo 'Failed import data into ADP.';
                Yii::$app->session->setFlash('error', "Failed to import data into ADP.");
            }
        }

        fclose($handle1);
        $totalCount1 = Adp::find()->count();
        ####################################################################################
        // Import file2.txt into table2
        cht::deleteAll();
        $filePath2 = 'uploads/file16/CHT.txt';
        $handle2 = fopen($filePath2, 'r');
        fgets($handle2); // Skip headers
        $recordCount2 = 0;
        ##HN|AN|DATE|TOTAL|PAID|PTTYPE|PERSON_ID|SEQ|OPD_MEMO|INVOICE_NO|INVOICE_LT
        while (($data2 = fgetcsv($handle2, 1000, '|')) !== false) {
            $model2 = new Cht();
            $model2->hn = $data2[0];
            $model2->an = $data2[1];
            $model2->date = $data2[2];
            $model2->total = $data2[3];
            $model2->paid = $data2[4];
            $model2->pttype = $data2[5];
            $model2->person_id = $data2[6];
            $model2->seq = $data2[7];
            $model2->opd_memo = $data2[8];
            $model2->invoice_no = $data2[9];
            $model2->invoice_lt = $data2[10];
            //$model2->save();
            if ($model2->save()) {
                $recordCount2++;
                // echo ' CHT successfully.';
            } else {
                //echo 'Failed import data into CHT.';
                Yii::$app->session->setFlash('error', "Failed to import data into CHT.");
            }
        }
        fclose($handle2);
        $totalCount2 = Cht::find()->count();
        #####################################################################################
        // Import CHA.txt into Cha
        cha::deleteAll();
        $filePath3 = 'uploads/file16/CHA.txt';
        $handle3 = fopen($filePath3, 'r');
        fgets($handle3); // Skip headers
        $recordCount3 = 0;
        ## hn|an|date|chrgitem|amount|person_id|seq
        while (($data3 = fgetcsv($handle3, 1000, '|')) !== false) {
            $model3 = new Cha();
            $model3->hn = $data3[0];
            $model3->an = $data3[1];
            $model3->date = $data3[2];
            $model3->chrgitem = $data3[3];
            $model3->amount = $data3[4];
            $model3->person_id = $data3[5];
            $model3->seq = $data3[6];
            //$model3->save();
            if ($model3->save()) {
                $recordCount3++;
                // echo ' CHT successfully.';
            } else {
                //echo 'Failed import data into CHT.';
                Yii::$app->session->setFlash('error', "Failed to import data into CHA.");
            }
        }

        fclose($handle3);
        $totalCount3 = Cha::find()->count();
        #############################################################################
        // Import DRU.txt into Cha
        dru::deleteAll();
        $filePath4 = 'uploads/file16/DRU.txt';
        $handle4 = fopen($filePath4, 'r');
        fgets($handle4); // Skip headers
        $recordCount4 = 0;
        ## hcode|hn|an|clinic|person_id|date_serv|did|didname|amount|drugprice|drugcost|didstd|unit|unit_pack|seq|drugremark|pa_no|
        ## totcopay|use_status|total|sigcode|sigtext|provider
        while (($data4 = fgetcsv($handle4, 1000, '|')) !== false) {
            $model4 = new Dru();
            $model4->hcode = $data4[0];
            $model4->hn = $data4[1];
            $model4->an = $data4[2];
            $model4->clinic = $data4[3];
            $model4->person_id = $data4[4];
            $model4->date_serv = $data4[5];
            $model4->did = $data4[6];
            $model4->didname = $data4[7];
            $model4->amount = $data4[8];
            $model4->drugprice = $data4[9];
            $model4->drugcost = $data4[10];
            $model4->didstd = $data4[11];
            $model4->unit = $data4[12];
            $model4->unit_pack = $data4[13];
            $model4->seq = $data4[14];
            $model4->drugremark = $data4[15];
            $model4->pa_no = $data4[16];
            $model4->totcopay = $data4[17];
            $model4->use_status = $data4[18];
            $model4->total = $data4[19];
            $model4->sigcode = $data4[20];
            $model4->sigtext = $data4[21];
            $model4->provider = $data4[22];
            // $model4->save();
            if ($model4->save()) {
                $recordCount4++;
                // echo ' CHT successfully.';
            } else {
                //echo 'Failed import data into CHT.';
                Yii::$app->session->setFlash('error', "Failed to import data into DRU.");
            }
        }

        fclose($handle4);
        $totalCount4 = Dru::find()->count();
        ###############################################################################################################################  
        // Import INS.txt into Cha
        ins::deleteAll();
        $filePath5 = 'uploads/file16/INS.txt';
        $handle5 = fopen($filePath5, 'r');
        fgets($handle5); // Skip headers
        $recordCount5 = 0;
        ## hn|inscl|subtype|cid|hcode|dateexp|hospmain|hospsub|govcode|govname|permitno|docno|ownrpid|ownname|an|seq|subinscl|relinscl|htype
        while (($data5 = fgetcsv($handle5, 1000, '|')) !== false) {
            $model5 = new Ins();
            $model5->hn = $data5[0];
            $model5->inscl = $data5[1];
            $model5->subtype = $data5[2];
            $model5->cid = $data5[3];
            $model5->hcode = $data5[4];
            $model5->dateexp = $data5[5];
            $model5->hospmain = $data5[6];
            $model5->hospsub = $data5[7];
            $model5->govcode = $data5[8];
            $model5->govname = $data5[9];
            $model5->permitno = $data5[10];
            $model5->docno = $data5[11];
            $model5->ownrpid = $data5[12];
            $model5->ownname = $data5[13];
            $model5->an = $data5[14];
            $model5->seq = $data5[15];
            $model5->subinscl = $data5[16];
            $model5->relinscl = $data5[17];
            $model5->htype = $data5[18];
            //$model5->save();
            if ($model5->save()) {
                $recordCount5++;
                // echo ' CHT successfully.';
            } else {
                //echo 'Failed import data into CHT.';
                Yii::$app->session->setFlash('error', "Failed to import data into INS.");
            }
        }

        fclose($handle5);
        $totalCount5 = Ins::find()->count();
        #################################################################################################################
        // Import LABFU.txt into Cha
        labfu::deleteAll();
        $filePath6 = 'uploads/file16/LABFU.txt';
        $handle6 = fopen($filePath6, 'r');
        fgets($handle6); // Skip headers
        $recordCount6 = 0;
        ## HCODE', 'HN', 'PERSON_ID', 'DATESERV', 'SEQ', 'LABTEST', 'LABRESULT'
        while (($data6 = fgetcsv($handle6, 1000, '|')) !== false) {
            $model6 = new Labfu();
            $model6->hcode = $data6[0];
            $model6->hn = $data6[1];
            $model6->person_id = $data6[2];
            $model6->dateserv = $data6[3];
            $model6->seq = $data6[4];
            $model6->labtest = $data6[5];
            $model6->labresult = $data6[6];
            // $model6->save();
            if ($model6->save()) {
                $recordCount6++;
                // echo ' LABFU successfully.';
            } else {
                // echo 'Failed import data into LABFU.';
                Yii::$app->session->setFlash('error', "Failed to import data into LABFU.");
            }
        }
        fclose($handle6);
        $totalCount6 = Labfu::find()->count();
        ####################################################################################################
        // Import ODX.txt 
        odx::deleteAll();
        $filePath7 = 'uploads/file16/ODX.txt';
        $handle7 = fopen($filePath7, 'r');
        fgets($handle7); // Skip headers
        $recordCount7 = 0;
        ## HN|DATEDX|CLINIC|DIAG|DXTYPE|DRDX|PERSON_ID|SEQ
        while (($data7 = fgetcsv($handle7, 1000, '|')) !== false) {
            $model7 = new Odx();
            $model7->hn = $data7[0];
            $model7->datedx = $data7[1];
            $model7->clinic = $data7[2];
            $model7->diag = $data7[3];
            $model7->dxtype = $data7[4];
            $model7->drdx = $data7[5];
            $model7->person_id = $data7[6];
            $model7->seq = $data7[7];
            // $model6->save();
            if ($model7->save()) {
                $recordCount7++;
                // echo ' ODX successfully.';
            } else {
                //echo 'Failed import data into ODX.';
                Yii::$app->session->setFlash('error', "Failed to import data into ODX.");
            }
        }
        fclose($handle7);
        $totalCount7 = Odx::find()->count();
        ##################################################################################################################
        // Import OOP.txt 
        oop::deleteAll();
        $filePath8 = 'uploads/file16/OOP.txt';
        $handle8 = fopen($filePath8, 'r');
        fgets($handle8); // Skip headers
        $recordCount8 = 0;
        ## HN|DATEOPD|CLINIC|OPER|DROPID|PERSON_ID|SEQ|SERVPRICE
        while (($data8 = fgetcsv($handle8, 1000, '|')) !== false) {
            $model8 = new Oop();
            $model8->hn = $data8[0];
            $model8->dateopd = $data8[1];
            $model8->clinic = $data8[2];
            $model8->oper = $data8[3];
            $model8->dropid = $data8[4];
            $model8->person_id = $data8[5];
            $model8->seq = $data8[6];
            $model8->servprice = $data8[7];
            // $model8->save();
            if ($model8->save()) {
                $recordCount8++;
                // echo ' OOP successfully.';
            } else {
                //echo 'Failed import data into OOP.';
                Yii::$app->session->setFlash('error', "Failed to import data into OOP.");
            }
        }
        fclose($handle8);
        $totalCount8 = Oop::find()->count();
        #####################################################################################################################
        // Import OPD.txt 
        opd::deleteAll();
        $filePath9 = 'uploads/file16/OPD.txt';
        $handle9 = fopen($filePath9, 'r');
        fgets($handle9); // Skip headers
        $recordCount9 = 0;
        ## hn, clinic, dateopd, timeopd, seq, uuc, detail, btemp, sbp, dbp, pr, rr, optype, typein, typeout
        while (($data9 = fgetcsv($handle9, 1000, '|')) !== false) {
            $model9 = new Opd();
            $model9->hn = $data9[0];
            $model9->clinic = $data9[1];
            $model9->dateopd = $data9[2];
            $model9->timeopd = $data9[3];
            $model9->seq = $data9[4];
            $model9->uuc = $data9[5];
            $model9->detail = $data9[6];
            $model9->btemp = $data9[7];
            $model9->sbp = $data9[8];
            $model9->dbp = $data9[9];
            $model9->pr = $data9[10];
            $model9->rr = $data9[11];
            $model9->optype = $data9[12];
            $model9->typein = $data9[13];
            $model9->typeout = $data9[14];
            // $model9->save();
            if ($model9->save()) {
                $recordCount9++;
                //echo ' OPD successfully.\n';
            } else {
                //echo 'Failed import data into OPD.';
                Yii::$app->session->setFlash('error', "Failed to import data into OPD.");
            }
        }
        fclose($handle9);
        $totalCount9 = Opd::find()->count();
        ####################################################################################################################
        // Import ORF.txt 
        orf::deleteAll();
        $filePath10 = 'uploads/file16/ORF.txt';
        $handle10 = fopen($filePath10, 'r');
        fgets($handle10); // Skip headers
        $recordCount10 = 0;
        ## hn, dateopd, clinic, refer, refertype, seq, referdate
        while (($data10 = fgetcsv($handle10, 1000, '|')) !== false) {
            $model10 = new Orf();
            $model10->hn = $data10[0];
            $model10->dateopd = $data10[1];
            $model10->clinic = $data10[2];
            $model10->refer = $data10[3];
            $model10->refertype = $data10[4];
            $model10->seq = $data10[5];
            $model10->referdate = $data10[6];
            // $model10->save();
            if ($model10->save()) {
                $recordCount10++;
                //echo ' OPD successfully.\n';
                //echo "Data imported successfully for file: $filePath10\n";
            } else {
                //echo 'Failed import data into OPD.';
                Yii::$app->session->setFlash('error', "Failed to import data into ORF.");
            }
        }
        fclose($handle10);
        $totalCount10 = Orf::find()->count();
        ##########################################################################################
        // Import PAT.txt 
        pat::deleteAll();
        $filePath11 = 'uploads/file16/PAT.txt';
        $handle11 = fopen($filePath11, 'r');
        fgets($handle11); // Skip headers
        $recordCount11 = 0;
        ## hcode,hn, changwat, amphur, dob, sex, marriage, occupa, nation, person_id, namepat, title, fname, lname, idtype
        while (($data11 = fgetcsv($handle11, 1000, '|')) !== false) {
            $model11 = new Pat();
            $model11->hcode = $data11[0];
            $model11->hn = $data11[1];
            $model11->changwat = $data11[2];
            $model11->amphur = $data11[3];
            $model11->dob = $data11[4];
            $model11->sex = $data11[5];
            $model11->marriage = $data11[6];
            $model11->occupa = $data11[7];
            $model11->nation = $data11[8];
            $model11->person_id = $data11[9];
            $model11->namepat = $data11[10];
            $model11->title = $data11[11];
            $model11->fname = $data11[12];
            $model11->lname = $data11[13];
            $model11->idtype = $data11[14];
            // $model11->save();
            if ($model11->save()) {
                $recordCount11++;
                // echo ' PAT successfully.';
                // echo "Data imported successfully for file: $filename\n";

            } else {
                //echo 'Failed import data into PAT.';
                Yii::$app->session->setFlash('error', "Failed to import data into PAT.");
            }
        }
        fclose($handle11);
        $totalCount11 = Pat::find()->count();
        Yii::$app->session->setFlash('success', 'Data imported successfully.<br> 
               Total adp: ' . $totalCount1 . '<br> 
               Total cht: ' . $totalCount2 . '<br> 
               Total cha: ' . $totalCount3 . '<br> 
               Total dru: ' . $totalCount4 . '<br> 
               Total ins: ' . $totalCount5 . '<br> 
               Totallabfu:' . $totalCount6 . '<br> 
               Total odx: ' . $totalCount7 . '<br> 
               Total oop: ' . $totalCount8 . '<br> 
               Total opd: ' . $totalCount9 . '<br> 
               Total orf: ' . $totalCount10 . '<br> 
               Total pat: ' . $totalCount11);
        Yii::$app->session->setFlash(
            'success',
            'ข้อมูลจาก ADP: ' . $recordCount1 . '***นำเข้าได้: ' . $recordCount1 . '<br>
                ข้อมูลจาก CHT: ' . $recordCount2 . '***นำเข้าได้: ' . $recordCount2 . '<br>
                ข้อมูลจาก CHA: ' . $recordCount3 . '***นำเข้าได้: ' . $recordCount3 . '<br>
                ข้อมูลจาก DRU: ' . $recordCount4 . '***นำเข้าได้: ' . $recordCount4 . '<br>
                ข้อมูลจาก INS: ' . $recordCount5 . '***นำเข้าได้: ' . $recordCount5 . '<br>
                ข้อมูลจาก LABFU: ' . $recordCount6 . '***นำเข้าได้: ' . $recordCount6 . '<br>
                ข้อมูลจาก ODX: ' . $recordCount7 . '***นำเข้าได้: ' . $recordCount7 . '<br>
                ข้อมูลจาก OOP: ' . $recordCount8 . '***นำเข้าได้: ' . $recordCount8 . '<br>
                ข้อมูลจาก OPD: ' . $recordCount9 . '***นำเข้าได้: ' . $recordCount9 . '<br>
                ข้อมูลจาก ORF: ' . $recordCount10 . '***นำเข้าได้: ' . $recordCount10 . '<br>
                ข้อมูลจาก PAT: ' . $recordCount11 . '***นำเข้าได้: ' . $totalCount11
        );
        //  Yii::$app->session->setFlash('success', 'Record count in file1.txt: ' . $recordCount1 . '<br> Record count in file2.txt: ' . $recordCount2);
        return $this->redirect(['index']);
    }
    ###########################################################################################
    public function actionUpdate()
    {
        // Get an instance of the DB connection
        $db = Yii::$app->db16;

        // Begin a transaction
        $transaction = $db->beginTransaction();

        try {
            ### ลบข้อมูลไม่ตรงกับเงื่อนไขออกก่อน ###########################
            $sqlDel = "DELETE FROM non_ucs_ncd_screen WHERE (bsl <> ' ' AND age_year < '35')";
            $commandDel = $db->createCommand($sqlDel);
            $commandDel->execute();

            #############  ADP ###########################
            $sqlDelete = "DELETE FROM adp";
            $commandDelete = $db->createCommand($sqlDelete);
            $commandDelete->execute();

            $sql400 = "INSERT INTO adp (hn, an, dateopd, type, code, qty, rate, seq, cagcode, dose, ca_type, serialno, totcopay, use_status, total)
                    SELECT
                n.hn,
                '' AS an,
                replace(n.screen_date, '-','') as dateopd,
                '4' AS type,
                '12001' AS code,
                '1' AS qty,
                '100.00' AS rate,
                n.seq AS seq,
                '' AS cagcode,
                '' AS dose,
                '' AS ca_type,
                '' AS serialno,
                '0.00' AS totcopay,
                '' AS use_status,
                '100.00' AS total
            FROM
                non_ucs_ncd_screen n
            WHERE
                n.symptoms LIKE ('%อายุ15-34 ปี%')

            UNION

            SELECT
                n.hn,
                '' AS an,
                replace(n.screen_date, '-','') as dateopd,
                '4' AS type,
                '12002' AS code,
                '1' AS qty,
                '150.00' AS rate,
                n.seq AS seq,
                '' AS cagcode,
                '' AS dose,
                '' AS ca_type,
                '' AS serialno,
                '0.00' AS totcopay,
                '' AS use_status,
                '150.00' AS total
            FROM
                non_ucs_ncd_screen n
            WHERE
                n.symptoms LIKE ('%อายุ35-59 ปี%')

            UNION

            SELECT
                n.hn,
                '' AS an,
                replace(n.screen_date, '-','') as dateopd,
                '4' AS type,
                '12003' AS code,
                '1' AS qty,
                '40.00' AS rate,
                n.seq AS seq,
                '' AS cagcode,
                '' AS dose,
                '' AS ca_type,
                '' AS serialno,
                '0.00' AS totcopay,
                '' AS use_status,
                '40.00' AS total
            FROM
                non_ucs_ncd_screen n
            WHERE
                n.bsl <> '' AND n.age_year BETWEEN '35' AND '59'
            ";
            $command400 = $db->createCommand($sql400);
            $totaladp = $command400->execute();

            #############  PAT ###########
            $sqlDelete = "DELETE FROM pat";
            $commandDelete = $db->createCommand($sqlDelete);
            $commandDelete->execute();

            $sql401 = "INSERT INTO pat (hcode, hn, changwat, amphur, dob, sex, marriage, occupa, nation, person_id, namepat, title, fname, lname, idtype)
            SELECT 
                '10953' as hcode,
                n.hn,
                n.changwat,
                n.amphur,
                n.dob,
                n.sex,
                n.marriage,
                n.occupa,
                n.nation,
                n.cid as person_id,
                CONCAT(fname, ' ', lname) as namepat,
                n.title,
                n.fname,
                n.lname,
                '1' as idtype
            FROM non_ucs_ncd_screen n
            ";

            $command401 = $db->createCommand($sql401);
            $totalpat = $command401->execute();

            #############  INS ###########################
            $sqlDelete = "DELETE FROM ins";
            $commandDelete = $db->createCommand($sqlDelete);
            $commandDelete->execute();

            $sql402 = "INSERT INTO ins (hn, inscl, subtype, cid, hcode, dateexp, hospmain, hospsub, govcode, govname, permitno, docno, ownrpid, ownname, an, seq, subinscl, relinscl, htype)
            SELECT 
                n.hn,
                'UCS' as inscl,
                '' as subtype,
                n.cid,
                '10953' as hcode,
                DATE_FORMAT(STR_TO_DATE(n.dateexpire, '%m/%d/%Y'), '%Y%m%d') as dateexp,
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
            FROM non_ucs_ncd_screen n          
            ";
            $command402 = $db->createCommand($sql402);
            $totalins = $command402->execute();

            #############  ODX ###########################
            $sqlDelete = "DELETE FROM odx";
            $commandDelete = $db->createCommand($sqlDelete);
            $commandDelete->execute();

            $sql404 = "INSERT INTO odx (hn, datedx, clinic, diag, dxtype, drdx, person_id, seq)
            SELECT
                n.hn,
                replace(n.screen_date, '-','') as datedx,
                '015' as clinic,
                REPLACE(vd.diagcode, '.', '') AS diag,
                RIGHT(vd.dxtype, 1) as dxtype,
                '28234' as drdx,
                n.cid as person_id,
                n.seq
            FROM non_ucs_ncd_screen n
            LEFT JOIN visitdiag vd ON vd.visitno = n.seq                
            ";
            $command404 = $db->createCommand($sql404);
            $totalodx = $command404->execute();
            #############  OPD###########################
            $sqlDelete = "DELETE FROM opd";
            $commandDelete = $db->createCommand($sqlDelete);
            $commandDelete->execute();

            $sql405 = "INSERT INTO opd (hn, clinic, dateopd, timeopd, seq, uuc, detail, btemp, sbp, dbp, pr, rr, optype, typein, typeout)
            SELECT 
                n.hn,
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
            FROM non_ucs_ncd_screen n
            
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

            #####################################################
            $transaction->commit();
            Yii::$app->session->setFlash('success', 'นำเข้าข้อมูลสำเร็จ.<br> 
                pat: ' . $totalpat . '<br> 
                opd: ' . $totalopd . '<br> 
                adp: ' . $totaladp . '<br> 
                ins: ' . $totalins . '<br> 
                odx: ' . $totalodx);
        } catch (\Exception $e) {
            // Roll back the transaction if an error occurred
            $transaction->rollBack();

            //echo "Error executing SQL statements: " . $e->getMessage();
            Yii::$app->session->setFlash('Error', 'Convert ไม่สำเร็จ กรุณาตรวจสอบ.');
        }

        // Redirect back to the previous page or a specific route
        return $this->redirect(['index']);
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
        $zipFilename = $baseDirectory . 'F16_10953_NON_UCS' . $currentDateTime . '.zip';
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
        $sql = "SELECT o.hn, o.dateopd, o.seq,p.person_id,
            concat(p.fname, ' ' , p.lname) as fullname,
            o.detail 
            FROM opd o 
            LEFT JOIN pat p ON p.hn = o.hn
            WHERE o.detail LIKE '%สุขภาพจิต%'
            GROUP BY o.seq, o.dateopd
            ORDER BY hn 
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
