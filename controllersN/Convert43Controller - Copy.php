<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Command;
use app\models\Address;
use app\models\Anc;
use app\models\Card;
use app\models\Charge_opd;
use app\models\Chronic;
use app\models\Chronicfu;
use app\models\Community_service;
use app\models\Death;
use app\models\Dental;
use app\models\Diagnosis_opd;
use app\models\Disability;
use app\models\Drug_opd;
//use app\models\drugrefer;
use app\models\Epi;
use app\models\Fp;
use app\models\Home;
use app\models\Labfu;
use app\models\Labor;
use app\models\Ncdscreen;
use app\models\Newborn;
use app\models\Newborncare;
use app\models\Nutrition;
use app\models\Person;
use app\models\Postnatal;
use app\models\Procedure_opd;
use app\models\Provider;
//use app\models\referhistory;
use app\models\Rehabilitation;
use app\models\Service;
use app\models\Spacialpp;
use app\models\Student;
//use app\models\surveillance;
use app\models\Village;
use app\models\Women;
use yii\widgets\ProgressBar;
use yii\web\UploadedFile;
use yii\helpers\Console;
use yii\db\Connection;
use yii\db\Transaction;
use yii\db\Expression;
use ZipArchive;

class Convert43Controller extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function importFile($tableName, $filePath, $modelClass)
    {
        $batchSize = 1000; // Number of rows to insert in each batch

        // Read the contents of the file
        $fileContents = file_get_contents($filePath);

        // Split the file contents into rows
        $rows = explode("\r\n", $fileContents);

        // Filter out empty rows
        $rows = array_filter($rows, 'strlen');

        // Delete existing data from the table
        $deleteSql = "DELETE FROM $tableName";
        $deleteCommand = Yii::$app->db943->createCommand($deleteSql);
        $deleteCommand->execute();

        // Get the columns of the table
        $columns = Yii::$app->db943->getTableSchema($tableName)->columnNames;

        // Import new data using Yii2 Active Record in a transaction
        $importCount = 0;
        $transaction = Yii::$app->db943->beginTransaction();

        try {
            $valuesBatch = [];

            for ($i = 1; $i < count($rows); $i++) {
                // Split each row into values
                $values = explode('|', $rows[$i]);

                // Ensure the number of columns matches the number of values
                if (count($columns) === count($values)) {
                    // Combine values with columns for batch insert
                    $valuesBatch[] = array_combine($columns, $values);

                    $importCount++;

                    // Batch insert in the specified batch size
                    if ($importCount % $batchSize === 0) {
                        Yii::$app->db943->createCommand()->batchInsert($tableName, $columns, $valuesBatch)->execute();
                        $valuesBatch = [];
                    }
                } else {
                    Yii::warning("Skipped row $i in $tableName due to column-value mismatch");
                }
            }

            // Insert any remaining records
            if (!empty($valuesBatch)) {
                Yii::$app->db943->createCommand()->batchInsert($tableName, $columns, $valuesBatch)->execute();
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $importCount;
    }


    public function actionImports()
    {
        $tablesAndFiles = [
            'accident' => '@app/web/uploads/file43/accident.txt',
            'address' => '@app/web/uploads/file43/address.txt',
            'anc' => '@app/web/uploads/file43/anc.txt',
            'card' => '@app/web/uploads/file43/card.txt',
            'charge_opd' => '@app/web/uploads/file43/charge_opd.txt',
            'chronic' => '@app/web/uploads/file43/chronic.txt',
            'chronicfu' => '@app/web/uploads/file43/chronicfu.txt',
            'community_service' => '@app/web/uploads/file43/community_service.txt',
            'death' => '@app/web/uploads/file43/death.txt',
            'dental' => '@app/web/uploads/file43/dental.txt',
            'diagnosis_opd' => '@app/web/uploads/file43/diagnosis_opd.txt',
            'disability' => '@app/web/uploads/file43/disability.txt',
            'drug_opd' => '@app/web/uploads/file43/drug_opd.txt',
            'drug_refer' => '@app/web/uploads/file43/drug_refer.txt',
            'drugallergy' => '@app/web/uploads/file43/drugallergy.txt',
            'epi' => '@app/web/uploads/file43/epi.txt',
            'fp' => '@app/web/uploads/file43/fp.txt',
            'home' => '@app/web/uploads/file43/home.txt',
            'labfu' => '@app/web/uploads/file43/labfu.txt',
            'labor' => '@app/web/uploads/file43/labor.txt',
            'ncdscreen' => '@app/web/uploads/file43/ncdscreen.txt',
            'newborn' => '@app/web/uploads/file43/newborn.txt',
            'newborncare' => '@app/web/uploads/file43/newborncare.txt',
            'nutrition' => '@app/web/uploads/file43/nutrition.txt',
            'person' => '@app/web/uploads/file43/person.txt',
            'postnatal' => '@app/web/uploads/file43/postnatal.txt',
            'procedure_opd' => '@app/web/uploads/file43/procedure_opd.txt',
            'procedure_refer' => '@app/web/uploads/file43/procedure_refer.txt',
            'provider' => '@app/web/uploads/file43/provider.txt',
            'refer_history' => '@app/web/uploads/file43/refer_history.txt',
            'rehabilitation' => '@app/web/uploads/file43/rehabilitation.txt',
            'service' => '@app/web/uploads/file43/service.txt',
            'specialpp' => '@app/web/uploads/file43/specialpp.txt',
            'student' => '@app/web/uploads/file43/student.txt',
            'surveillance' => '@app/web/uploads/file43/surveillance.txt',
            'village' => '@app/web/uploads/file43/village.txt',
            'women' => '@app/web/uploads/file43/women.txt',
        ];

        foreach ($tablesAndFiles as $tableName => $filePath) {
            $modelClass = ucfirst($tableName);
            $importCount = $this->importFile($tableName, Yii::getAlias($filePath), $modelClass);
            $flashMessage = "Imported $importCount records for $tableName";
            Yii::$app->session->addFlash('success', $flashMessage);
        }

        return $this->redirect(['index']); // Redirect to the index page after successful imports
    }
    public function actionUpdate()
{
    // Get an instance of the DB connection
    $db = Yii::$app->db943;

    try {
        $transaction = $db->beginTransaction();
        ########## ANC ##################
        $sql1 = "UPDATE anc 
                 SET hospcode = '10953', ancplace = '10953' 
                 WHERE hospcode = '99809' AND (ancplace = '99809' OR ancplace = '00000')";
        $command1 = $db->createCommand($sql1);
        $command1->execute();
        ########## ADDRESS ##################
        $sql2 = "UPDATE address SET hospcode= '10953' WHERE hospcode = '99809'";
        $command2 = $db->createCommand($sql2);
        $command2->execute();
        ########## CARD ##################
        $sql3 = "UPDATE card c  SET c.hospcode = '10953', c.sub = '10953' 
        WHERE c.hospcode = '99809' OR c.sub = '99809'";
        $command3 = $db->createCommand($sql3);
        $command3->execute();
        $sql4 = "UPDATE card a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command4 = $db->createCommand($sql4);
        $command4->execute();
        ########## CHARGE OPD ##################
        $sql5 = "UPDATE charge_opd c  SET c.hospcode = '10953', c.clinic = '01500' 
        WHERE c.hospcode = '99809' OR c.clinic = '00000' ";
        $command5 = $db->createCommand($sql5);
        $command5->execute();
        $sql6 = "UPDATE charge_opd a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command6 = $db->createCommand($sql6);
        $command6->execute();
        ########## CHRONIC ##################
        $sql7 = "UPDATE chronic SET hospcode= '10953' WHERE hospcode = '99809'";
        $command7 = $db->createCommand($sql7);
        $command7->execute();
        $sql8 = "UPDATE chronic a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command8 = $db->createCommand($sql8);
        $command8->execute();
        ########## CHRONICFU ##################
        $sql9 = "UPDATE chronicfu SET hospcode= '10953' , chronicfuplace= '10953'
        WHERE hospcode = '99809' AND '99809'";
        $command9 = $db->createCommand($sql9);
        $command9->execute();
        $sql10 = "UPDATE chronicfu a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command10 = $db->createCommand($sql10);
        $command10->execute();
        ########## Community Service ##################
        $sql11 = "UPDATE community_service SET hospcode= '10953' WHERE hospcode = '99809'";
        $command11 = $db->createCommand($sql11);
        $command11->execute();
        $sql12 = "UPDATE community_service a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command12 = $db->createCommand($sql12);
        $command12->execute();
        ########## DEATH ##################
        $sql13 = "UPDATE death SET hospcode= '10953' WHERE hospcode = '99809'";
        $command13 = $db->createCommand($sql13);
        $command13->execute();
        $sql14 = "UPDATE death a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command14 = $db->createCommand($sql14);
        $command14->execute();
        ########## DENTAL ##################
        $sql15 = "UPDATE dental SET hospcode= '10953' WHERE hospcode = '99809'";
        $command15 = $db->createCommand($sql15);
        $command15->execute();
        $sql16 = "UPDATE dental a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command16 = $db->createCommand($sql16);
        $command16->execute();
        ########## Diagnosis OPD ##################
        $sql17 = "UPDATE diagnosis_opd c  SET c.hospcode = '10953', c.clinic = '01500' 
        WHERE c.hospcode = '99809' OR c.clinic = '00000' ";
        $command17 = $db->createCommand($sql17);
        $command17->execute();
        $sql18 = "UPDATE diagnosis_opd a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command18 = $db->createCommand($sql18);
        $command18->execute();
        ########## Disability ##################
        $sql19 = "UPDATE disability SET hospcode= '10953' WHERE hospcode = '99809'";
        $command19 = $db->createCommand($sql19);
        $command19->execute();
        $sql20 = "UPDATE disability a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command20 = $db->createCommand($sql20);
        $command20->execute();
        ########## DRUG OPD ##################
        $sql21 = "UPDATE drug_opd c  SET c.hospcode = '10953', c.clinic = '01500' 
        WHERE c.hospcode = '99809' OR c.clinic = '00000' ";
        $command21 = $db->createCommand($sql21);
        $command21->execute();
        $sql22 = "UPDATE drug_opd a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command22 = $db->createCommand($sql22);
        $command22->execute();
        ########## Drug Refer ##################
        $sql23 = "UPDATE drug_refer SET hospcode= '10953' WHERE hospcode = '99809'";
        $command23 = $db->createCommand($sql23);
        $command23->execute();
        ########## Drugallergy ##################
        $sql24 = "UPDATE drugallergy SET hospcode= '10953' WHERE hospcode = '99809'";
        $command24 = $db->createCommand($sql24);
        $command24->execute();
        $sql25 = "UPDATE drugallergy a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command25 = $db->createCommand($sql25);
        $command25->execute();
        ##########EPI ##################
        $sql26 = "UPDATE epi c  SET c.hospcode = '10953', c.vaccineplace = '10953' 
        WHERE c.hospcode = '99809' AND c.vaccineplace = '99809' ";
        $command26 = $db->createCommand($sql26);
        $command26->execute();
        $sql27 = "UPDATE epi a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command27 = $db->createCommand($sql27);
        $command27->execute();
        ########## FP ##################
        $sql28 = "UPDATE fp c  SET c.hospcode = '10953', c.fpplace = '10953' 
        WHERE c.hospcode = '99809' OR c.fpplace = '99809' ";
        $command28 = $db->createCommand($sql28);
        $command28->execute();
        $sql29 = "UPDATE fp a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command29 = $db->createCommand($sql29);
        $command29->execute();
        ########## HOME ##################
        $sql30 = "UPDATE home SET hospcode= '10953' WHERE hospcode = '99809'";
        $command30 = $db->createCommand($sql30);
        $command30->execute();
        ########## LABFU ##################
        $sql31 = "UPDATE labfu c  SET c.hospcode = '10953', c.labplace = '10953' 
        WHERE c.hospcode = '99809' OR c.labplace = '99809' ";
        $command31 = $db->createCommand($sql31);
        $command31->execute();
        $sql32 = "UPDATE labfu a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command32 = $db->createCommand($sql32);
        $command32->execute();
        ########## LABOR ##################
        $sql33 = "UPDATE labor SET hospcode= '10953' WHERE hospcode = '99809'";
        $command33 = $db->createCommand($sql33);
        $command33->execute();
        $sql34 = "UPDATE labor a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command34 = $db->createCommand($sql34);
        $command34->execute();
        ########## NCDSCREEN ##################
        $sql35 = "UPDATE ncdscreen c  SET c.hospcode = '10953', c.screenplace = '10953' 
        WHERE c.hospcode = '99809' OR c.screenplace = '99809' ";
        $command35 = $db->createCommand($sql35);
        $command35->execute();
        $sql36 = "UPDATE ncdscreen a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command36 = $db->createCommand($sql36);
        $command36->execute();
         ########## NEWBORN ##################
         $sql37 = "UPDATE newborn SET hospcode= '10953' WHERE hospcode = '99809'";
         $command37 = $db->createCommand($sql37);
         $command37->execute();
         $sql38 = "UPDATE newborn a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
         $command38 = $db->createCommand($sql38);
         $command38->execute();
         ########## NEWBORNCARE ##################
         $sql37 = "UPDATE newborncare SET hospcode= '10953' WHERE hospcode = '99809'";
         $command37 = $db->createCommand($sql37);
         $command37->execute();
         $sql38 = "UPDATE newborncare a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
         $command38 = $db->createCommand($sql38);
         $command38->execute();
         ########## NUTRITION ##################
        $sql39 = "UPDATE nutrition c  SET c.hospcode = '10953', c.nutritionplace = '10953' 
        WHERE c.hospcode = '99809' OR c.nutritionplace = '99809' ";
        $command39 = $db->createCommand($sql39);
        $command39->execute();
        $sql40 = "UPDATE nutrition a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command40 = $db->createCommand($sql40);
        $command40->execute();
        ########## PERSON ##################
        $sql41 = "UPDATE person SET hospcode= '10953' WHERE hospcode = '99809'";
        $command41 = $db->createCommand($sql41);
        $command41->execute();
        $sql42 = "UPDATE person a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command42 = $db->createCommand($sql42);
        $command42->execute();
        $sql43 = "UPDATE person a  INNER JOIN mathhn m ON a.hn = m.pid SET a.hn = m.hn ";
        $command43 = $db->createCommand($sql43);
        $command43->execute();
         ########## POSTNATAL ##################
         $sql44 = "UPDATE postnatal c  SET c.hospcode = '10953', c.ppplace = '10953' 
         WHERE c.hospcode = '99809' OR c.ppplace = '99809' ";
         $command44 = $db->createCommand($sql44);
         $command44->execute();
         $sql45 = "UPDATE postnatal a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
         $command45 = $db->createCommand($sql45);
         $command45->execute();
         ########## PROCEDURE OPD ##################
        $sql46 = "UPDATE procedure_opd c  SET c.hospcode = '10953', c.clinic = '01500' 
        WHERE c.hospcode = '99809' OR c.clinic = '00000' ";
        $command46 = $db->createCommand($sql46);
        $command46->execute();
        $sql47 = "UPDATE procedure_opd a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command47 = $db->createCommand($sql47);
        $command47->execute();
        ########## PROCEDURE REFER ##################
        $sql48 = "UPDATE procedure_refer c  SET c.hospcode = '10953' ";
        $command48 = $db->createCommand($sql48);
        $command48->execute();
        ########## PROVIDER ##################
        $sql49 = "UPDATE provider c  SET c.hospcode = '10953' ";
        $command49 = $db->createCommand($sql49);
        $command49->execute();
        ########## REFER HISTORY ##################
        $sql50 = "UPDATE refer_history c  SET c.hospcode = '10953', c.clinic_refer = '01500' 
        WHERE c.hospcode = '99809' OR c.clinic_refer = '00000' ";
        $command50 = $db->createCommand($sql50);
        $command50->execute();
        ########## SERVICE ##################
        $sql51 = "UPDATE service SET hospcode= '10953' WHERE hospcode = '99809'";
        $command51 = $db->createCommand($sql51);
        $command51->execute();
        $sql52 = "UPDATE service a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command52 = $db->createCommand($sql52);
        $command52->execute();
        $sql53 = "UPDATE service a  INNER JOIN mathhn m ON a.hn = m.pid SET a.hn = m.hn ";
        $command53 = $db->createCommand($sql53);
        $command53->execute();
        ########## SPECIALPP ##################
        $sql54 = "UPDATE specialpp c  SET c.hospcode = '10953', c.ppsplace = '10953' 
        WHERE c.hospcode = '99809' OR c.ppsplace = '99809' ";
        $command54 = $db->createCommand($sql54);
        $command54->execute();
        $sql55 = "UPDATE specialpp a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command55 = $db->createCommand($sql55);
        $command55->execute();
        ########## STUDENT ##################
        $sql56 = "UPDATE student SET hospcode= '10953' WHERE hospcode = '99809'";
        $command56 = $db->createCommand($sql56);
        $command56->execute();
        $sql57 = "UPDATE student a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command57 = $db->createCommand($sql57);
        $command57->execute();
        ########## Surveillance ##################
        $sql58 = "UPDATE surveillance SET hospcode= '10953' WHERE hospcode = '99809'";
        $command58 = $db->createCommand($sql58);
        $command58->execute();
        $sql59 = "UPDATE surveillance a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command59 = $db->createCommand($sql59);
        $command59->execute();
        ########## Village ##################
        $sql60 = "UPDATE village SET hospcode= '10953' WHERE hospcode = '99809'";
        $command60 = $db->createCommand($sql60);
        $command60->execute();
        ########## WOMEN ##################
        $sql61 = "UPDATE women SET hospcode= '10953' WHERE hospcode = '99809'";
        $command61 = $db->createCommand($sql61);
        $command61->execute();
        $sql62 = "UPDATE women a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
        $command62 = $db->createCommand($sql62);
        $command62->execute();
        #####################################################
            // Commit the transaction if all SQL statements executed successfully
            $transaction->commit();

            //echo "SQL statements executed successfully.";
            Yii::$app->session->setFlash('success', 'Convert Data เรียบร้อยแล้ว.');
        } catch (\Exception $e) {
            // Roll back the transaction if an error occurred
            $transaction->rollBack();

            //echo "Error executing SQL statements: " . $e->getMessage();
            Yii::$app->session->setFlash('Error', 'Convert ไม่สำเร็จ กรุณาตรวจสอบ.');
        }

        // Redirect back to the previous page or a specific route
        return $this->redirect(['index']);
    }
}























        