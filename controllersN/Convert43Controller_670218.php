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
use yii\web\Response;
use yii\helpers\Html;
use yii\db\Query;

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

        $tableCounts = [];

        foreach ($tablesAndFiles as $tableName => $filePath) {
            $modelClass = ucfirst($tableName);
            $importCount = $this->importFile($tableName, Yii::getAlias($filePath), $modelClass);

            if ($importCount !== false) {
                // Store the count for each table in the array
                $tableCounts[] = ['tableName' => $tableName, 'count' => $importCount];
            } else {
                // Handle the case where import failed for a table
                Yii::$app->session->setFlash('error', "ไม่สามารถนำเข้าได้ $tableName");
            }
        }

        // Sort the table counts by tableName
        usort($tableCounts, function ($a, $b) {
            return strcmp($a['tableName'], $b['tableName']);
        });

        // Display the individual counts for each table in four columns
        $flashMessage = 'นำเข้าข้อมูลเรียบร้อย.<br>';
        $column1 = $column2 = $column3 = $column4 = '';

        foreach ($tableCounts as $index => $tableData) {
            $tableName = $tableData['tableName'];
            $count = $tableData['count'];

            // Determine which column to append based on the index
            switch ($index % 4) {
                case 0:
                    $column1 .= "$tableName: $count <br>";
                    break;
                case 1:
                    $column2 .= "$tableName: $count <br>";
                    break;
                case 2:
                    $column3 .= "$tableName: $count <br>";
                    break;
                case 3:
                    $column4 .= "$tableName: $count <br>";
                    break;
            }
        }

        // Display the total counts at the end
        $totalCount = array_sum(array_column($tableCounts, 'count'));
        $flashMessage .= "<div style='column-count: 4;'>$column1$column2$column3$column4</div> ยอดรวมทั้งหมด imported: $totalCount";
        Yii::$app->session->setFlash('success', $flashMessage);

        return $this->redirect(['index']);
    }
    #########################################################################################################################
    public function actionUpdate()
    {
        // Get an instance of the DB connection
        $db = Yii::$app->db943;

        try {
            $transaction = $db->beginTransaction();
            ##################### ลบข้อมูลที่เกิน ################################
            $sqlDelete = "DELETE FROM service WHERE date_serv < '20231001'";
            $commandDelete = $db->createCommand($sqlDelete);
            $commandDelete->execute();
            ########## PERSON ##################
            $sqlDelete = "DELETE p FROM person p
            LEFT JOIN service s ON p.hn = s.hn
            WHERE s.hn IS NULL";
            $commandDelete = $db->createCommand($sqlDelete);
            $commandDelete->execute();

            $sql41 = "UPDATE person SET hospcode= '10953' WHERE hospcode = '99809'";
            $command41 = $db->createCommand($sql41);
            $command41->execute();
            $sql42 = "UPDATE person a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
            $command42 = $db->createCommand($sql42);
            $command42->execute();
            $sql43 = "UPDATE person a  INNER JOIN mathhn m ON a.hn = m.pid SET a.hn = m.hn ";
            $command43 = $db->createCommand($sql43);
            $command43->execute();

            ########## Accident ##################
            $sql01 = "UPDATE accident SET hospcode= '10953' WHERE hospcode = '99809'";
            $command01 = $db->createCommand($sql01);
            $command01->execute();
            $sql001 = "UPDATE accident a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
            $command001 = $db->createCommand($sql001);
            $command001->execute();
            ########## ANC ##################
            $sql1 = "UPDATE anc 
                 SET hospcode = '10953', ancplace = '10953' 
                 WHERE hospcode = '99809' AND (ancplace = '99809' OR ancplace = '00000')";
            $command1 = $db->createCommand($sql1);
            $command1->execute();
            $sql111 = "UPDATE anc a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
            $command111 = $db->createCommand($sql111);
            $command111->execute();
            ########## ADDRESS ##################
            $sql2 = "UPDATE address SET hospcode= '10953' WHERE hospcode = '99809'";
            $command2 = $db->createCommand($sql2);
            $command2->execute();
            $sql222 = "UPDATE address a  INNER JOIN mathhn m ON a.pid = m.pid SET a.pid = m.hn ";
            $command222 = $db->createCommand($sql222);
            $command222->execute();
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
            #### ลบข้อมูลส่วนไม่เท่ากัน #############
            $sqlDelete = "DELETE p.* FROM person p
                LEFT JOIN accident a ON p.pid = a.pid
                LEFT JOIN anc an ON p.pid = an.pid
                LEFT JOIN card c ON p.pid = c.pid
                LEFT JOIN address ad ON p.pid = ad.pid
                LEFT JOIN charge_opd co ON p.pid = co.pid
                LEFT JOIN chronic ch ON p.pid = ch.pid
                LEFT JOIN chronicfu cf ON p.pid = cf.pid
                LEFT JOIN community_service cs ON p.pid = cs.pid
                LEFT JOIN death d ON p.pid = d.pid
                LEFT JOIN dental de ON p.pid = de.pid
                LEFT JOIN diagnosis_opd dopd ON p.pid = dopd.pid
                LEFT JOIN disability dis ON p.pid = dis.pid
                LEFT JOIN drug_opd dro ON p.pid = dro.pid
                #LEFT JOIN drug_refer dr ON p.pid = dr.pid
                LEFT JOIN drugallergy dall ON p.pid = dall.pid
                LEFT JOIN epi e ON p.pid = e.pid
                LEFT JOIN fp f ON p.pid = f.pid
                #LEFT JOIN home h ON p.pid = h.pid
                LEFT JOIN labfu lf ON p.pid = lf.pid
                LEFT JOIN labor la ON p.pid = la.pid
                LEFT JOIN ncdscreen ns ON p.pid = ns.pid
                LEFT JOIN nutrition nu ON p.pid = nu.pid
                LEFT JOIN postnatal pn ON p.pid = pn.pid
                LEFT JOIN procedure_opd popd ON p.pid = popd.pid
                #LEFT JOIN procedure_refer pre ON p.pid = pre.pid
                #LEFT JOIN provider pv ON p.pid = pv.pid
                LEFT JOIN refer_history rh ON p.pid = rh.pid
                LEFT JOIN service se ON p.pid = se.pid
                LEFT JOIN specialpp spp ON p.pid = spp.pid
                LEFT JOIN student st ON p.pid = st.pid
                LEFT JOIN surveillance sur ON p.pid = sur.pid
                #LEFT JOIN village v ON p.pid = v.pid
                LEFT JOIN women wo ON p.pid = wo.pid
                WHERE a.pid IS NULL
                AND an.pid IS NULL
                AND c.pid IS NULL
                AND ad.pid IS NULL
                AND co.pid IS NULL
                AND ch.pid IS NULL
                AND cf.pid IS NULL
                AND cs.pid IS NULL
                AND d.pid IS NULL
                AND de.pid IS NULL
                AND dopd.pid IS NULL
                AND dis.pid IS NULL
                AND dro.pid IS NULL
                #AND dr.pid IS NULL
                AND dall.pid IS NULL
                AND e.pid IS NULL
                AND f.pid IS NULL
                #AND h.pid IS NULL
                AND lf.pid IS NULL
                AND la.pid IS NULL
                AND ns.pid IS NULL
                AND nu.pid IS NULL
                AND pn.pid IS NULL
                AND popd.pid IS NULL
                #AND pre.pid IS NULL
                #AND pv.pid IS NULL
                AND rh.pid IS NULL
                AND se.pid IS NULL
                AND spp.pid IS NULL
                AND st.pid IS NULL
                AND sur.pid IS NULL
                #AND v.pid IS NULL
                AND wo.pid IS NULL
            ";
            $commandDelete = $db->createCommand($sqlDelete);
            $commandDelete->execute();


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
    ############################################################################################################################
    public function actionExport()
    {
        // Get an instance of the DB connection
        $db = Yii::$app->db943;

        // Path to save the export files
        $exportPath = Yii::getAlias('@app/web/uploads/export43/');

        // Specify tables to export
        $tablesToExport = [
            'accident', 'anc', 'card', 'address', 'charge_opd', 'chronic', 'chronicfu', 'community_service', 'death', 'dental', 'diagnosis_opd',
            'disability', 'drug_opd', 'drug_refer', 'drugallergy', 'epi', 'fp', 'home',  'labfu', 'labor', 'ncdscreen', 'nutrition', 'person', 'postnatal',
            'procedure_opd', 'procedure_refer',  'provider', 'refer_history', 'service', 'specialpp',  'student',  'surveillance', 'village', 'women',
        ];


        try {
            $transaction = $db->beginTransaction();

            $currentDateTime = date('Ymd_His'); // Format: YYYYMMDD_HHmmss
            $folderName = "F43_10953_$currentDateTime";
            $folderPath = "$exportPath/$folderName";
            $zipFileName = "$folderName.zip";
            $zipFilePath = "$exportPath/$zipFileName";

            // Create the folder
            if (!file_exists($folderPath) && !mkdir($folderPath, 0777, true)) {
                throw new \Exception("Unable to create folder: $folderPath");
            }

            $zip = new ZipArchive();
            if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                foreach ($tablesToExport as $tableName) {
                    // Build the SQL query to select all data from the table
                    $sql = "SELECT * FROM $tableName";
                    $command = $db->createCommand($sql);

                    // Execute the SQL query and fetch all rows
                    $rows = $command->queryAll();

                    // Create the export file path within the folder
                    $filePath = "$folderPath/$tableName.txt";

                    // Convert rows to UTF-8 encoded string
                    $dataToWrite = implode('|', array_keys($rows[0])) . "\n";
                    foreach ($rows as $row) {
                        $dataToWrite .= implode('|', $row) . "\n";
                    }

                    // Write data to the file with UTF-8 encoding
                    file_put_contents($filePath, mb_convert_encoding($dataToWrite, 'UTF-8', 'UTF-8'));

                    // Add the file to the zip archive
                    $zip->addFile($filePath, "$folderName/$tableName.txt");

                    // Perform any additional operations for the exported table if needed
                    // ...

                    Yii::info("Exported data from $tableName to $filePath");
                }

                $zip->close();
                $transaction->commit();

                // Send the zip file as a response
                Yii::$app->response->sendFile($zipFilePath)->send();
                Yii::$app->end();
            } else {
                throw new \Exception("Unable to create zip archive");
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error("Error exporting data: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'ไม่สามารถส่งออกข้อมูลได้  กรุณาตรวจสอบ.');
        }

        return $this->redirect(['index']); // Redirect to the index page
    }
    ################################################################################################################
    public function actionCheckpid()
    {
        $db = Yii::$app->db943;


        // Array to store results for each table
        $results = [];

        // List of tables to check
        $tables = [
            'accident', 'anc', 'address', 'card', 'charge_opd', 'chronic', 'chronicfu', 'community_service',
            'death', 'dental', 'diagnosis_opd', 'disability', 'drug_opd', 'drug_refer', 'drugallergy',
            'epi', 'fp', 'home', 'labfu', 'labor', 'ncdscreen', 'newborn', 'newborncare', 'nutrition',
            'person', 'postnatal', 'procedure_opd', 'procedure_refer', 'provider', 'refer_history',
            'service', 'specialpp', 'student', 'surveillance', 'village', 'women'
        ];

        $totalCount = 0;

        foreach ($tables as $table) {
            // Check if the 'pid' column exists in the current table
            $columnExistsSql = "SELECT COUNT(*) AS count
                                FROM information_schema.columns
                                WHERE table_name = :table AND column_name = 'pid'";

            $columnExists = $db->createCommand($columnExistsSql, [':table' => $table])->queryScalar();

            if ($columnExists) {
                // If 'pid' column exists, proceed with the count query
                $countSql = "SELECT COUNT(*) AS count FROM $table WHERE pid IS NULL";

                $result = $db->createCommand($countSql)->queryOne();

                // Store the result for each table
                $results[$table] = $result['count'];
                $totalCount += $result['count'];
            }
        }
        // ตั้งค่า Flash Message
        $message = '<span style="background-color: green; color: white;">ตรวจสอบข้อมูล HN มีค่าว่าง.</span><br>';

        // Organize results into groups of four
        $tablesInGroups = array_chunk($results, 5, true);

        // Display each group in a row
        foreach ($tablesInGroups as $group) {
            $message .= '<div class="row">';
            foreach ($group as $table => $count) {
                $message .= "<div class='col'> $table: $count </div>";
            }
            $message .= '</div>';
        }

        $message .= 'รวม HN มีค่าว่างทั้งหมด: ' . array_sum($results);

        Yii::$app->session->setFlash('success', $message);

        // Redirect ไปที่หน้า index
        return $this->redirect(['index']);
    }
    ################################################################################
    public function actionHnmap()
    {
        $db = Yii::$app->db943;

        $sql = "SELECT m.cid , 
        IF(ISNULL(m.hn), ' ', m.hn) AS hn,
        m.pid ,p.name, p.lname ,m.birthdate 
        FROM mathhn m 
        INNER JOIN person p ON p.cid = m.cid
        WHERE ISNULL(m.hn)
        ";

        try {
            $rawData = $db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('SQL error');
        }

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => FALSE,
        ]);

        return $this->render('export_excel', [
            'dataProvider' => $dataProvider,
            'sql' => $sql,
        ]);
    }
}
