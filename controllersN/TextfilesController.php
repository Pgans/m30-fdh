<?php

namespace app\controllers;
use yii;
use yii\db\Query;
use yii\helpers\FileHelper;
use app\models\Importpalliative;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\db\Expression;
use yii\db\Connection;
use ZipArchive;


class TextfilesController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionBrowse()
    {
        // Perform operations to browse the folder
        // ...
    }
    ######################################################
    public function actionImporttest() {
        // Get the uploaded Excel file
    $excelFile = UploadedFile::getInstanceByName('excelFile');

    // Load the file using PhpSpreadsheet
    $spreadsheet = IOFactory::load($excelFile->tempName);

    // Get the first worksheet
    $worksheet = $spreadsheet->getActiveSheet();

    // Get the highest row and column indexes
    $highestRow = $worksheet->getHighestRow();
    $highestColumn = $worksheet->getHighestColumn();

    // Delete existing data from the table
    Importpalliative::deleteAll(); // Replace 'YourModel' with your actual model name

    // Iterate through rows and insert data into the table
    for ($row = 2; $row <= $highestRow; $row++) { // Assuming the first row is the header
        $rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);

        // Create a new instance of your model
        $model = new Importpalliative();

        // Set the attributes with the imported data
        $model->attribute1 = $rowData[0][0]; // Replace 'attribute1' with your actual attribute names
        $model->attribute2 = $rowData[0][1];
        // Set other attributes accordingly

        // Save the model
        $model->save();
    }

    // Render a view after the import process
    return $this->render('import2'); // Replace 'import-success' with your actual view name

    }
      ################ IMPORT EXCEL ##################################
public function actionImports(){
    
    $modelImport = new \yii\base\DynamicModel([
                'fileImport'=>'File Import',
            ]);
    $modelImport->addRule(['fileImport'],'required');
    $modelImport->addRule(['fileImport'],'file',['extensions'=>'ods,xls,xlsx'],['maxSize'=>1024*1024]);
    
    $db14 = Yii::$app->db14;
    $connection = new Connection($db14);
    $connection->open();
    //$connection = Yii::$app->db14;
    $transaction = $connection->beginTransaction();

    if(Yii::$app->request->post()){
        $modelImport->fileImport = \yii\web\UploadedFile::getInstance($modelImport,'fileImport');
        if($modelImport->fileImport && $modelImport->validate()){
            $inputFileType = \PHPExcel_IOFactory::identify($modelImport->fileImport->tempName);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($modelImport->fileImport->tempName);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            $baseRow = 3;
            while(!empty($sheetData[$baseRow]['B'])){
                $model = new \app\models\Importpalliative();
                $model->hospcode = (string)$sheetData[$baseRow]['A'];
                $model->date_serv = (string)$sheetData[$baseRow]['B'];
                $model->hn = (string)$sheetData[$baseRow]['C'];
                $model->cid = (string)$sheetData[$baseRow]['D'];
                $model->fullname = (string)$sheetData[$baseRow]['E'];
                $model->age = (string)$sheetData[$baseRow]['F'];
                $model->diag_primary = (string)$sheetData[$baseRow]['G'];
                $model->diag_comor = (string)$sheetData[$baseRow]['H'];
                $model->address = (string)$sheetData[$baseRow]['I'];
                $model->telephone = (string)$sheetData[$baseRow]['J'];
                $model->status = (string)$sheetData[$baseRow]['K'];
                $model->d_update = new Expression('NOW()');
                $model->save();
                $baseRow++;
            }

         
            Yii::$app->getSession()->setFlash('success','Success');
        }else{
            
            Yii::$app->getSession()->setFlash('error','Error');
        }
    }
//$connection = \Yii::$app->db14;
$datap = $connection->createCommand("
 SELECT auto_id, hospcode, date_serv, hn, cid, fullname, age, diag_primary, diag_comor, address, telephone, status, d_update
FROM import_palliative
ORDER BY auto_id DESC
 ")->queryAll();

 $importdataProvider = new ArrayDataProvider([
     'allModels' => $datap,
 ]);

    return $this->render('import',[
            'modelImport' => $modelImport,
            'importdataProvider' => $importdataProvider,
            
        ]);
}
// #############################################################################
    
    public function actionExporttextnon(){
        // Get the Yii2 database connection
        $db14 = \Yii::$app->db14;

        // Execute your multiple queries
        $query1 = " SELECT
        '10953' as 'HCODE',
        o.hn 'HN',
        LEFT( p.TOWN_ID, 2 ) 'CHANGWAT',
        SUBSTR( p.TOWN_ID, 3, 2 ) 'AMPHUR',
        DATE_FORMAT(p.BIRTHDATE,'%Y%m%d') 'DOB',
        p.SEX 'SEX',
        p.MARRIAGE 'MARRIAGE',
        oc.OC_ID  'OCCUPA',
        CONCAT(0,'',p.NATN_ID) 'NATION',
        p.CID 'PERSON_ID',
        CONCAT(trim(p.fname),' ',trim(p.lname),',',
        CASE
                    WHEN p.PRENAME not in('') THEN TRIM(p.PRENAME)
                        #WHEN TIMESTAMPDIFF(year,pv.BIRTHDATE,NOW())< '20' AND pv.sex='1' AND pv.MARRIAGE = '4'THEN 'สามเณร'
                        #WHEN TIMESTAMPDIFF(year,pv.BIRTHDATE,NOW()) >= '20' AND pv.sex='1' AND pv.MARRIAGE  = '4'THEN 'พระภิกษุ'
                        WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='1' THEN 'ด.ช.'
                        WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='1' THEN 'นาย'
                        WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='2' THEN 'ด.ญ.'
                        WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='2' AND p.MARRIAGE ='1' THEN 'น.ส.'
                        ELSE 'นาง'
                                        END ) AS 'NAMEPAT',
        CASE
                    WHEN p.PRENAME not in('') THEN TRIM(p.PRENAME)
                        #WHEN TIMESTAMPDIFF(year,pv.BIRTHDATE,NOW())< '20' AND pv.sex='1' AND pv.MARRIAGE = '4'THEN 'สามเณร'
                        #WHEN TIMESTAMPDIFF(year,pv.BIRTHDATE,NOW()) >= '20' AND pv.sex='1' AND pv.MARRIAGE  = '4'THEN 'พระภิกษุ'
                        WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='1' THEN 'ด.ช.'
                        WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='1' THEN 'นาย'
                        WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='2' THEN 'ด.ญ.'
                        WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='2' AND p.MARRIAGE ='1' THEN 'น.ส.'
                        ELSE 'นาง'
                                        END  AS 'TITLE',
        trim(p.fname) AS 'FNAME',
        trim(p.lname) AS 'LNAME',
        '1' AS 'IDTYPE'
        FROM gcoffice g, opd_visits o
        INNER JOIN cid_hn c ON o.hn = c.hn 
        INNER JOIN population p ON p.cid = c.cid
        INNER JOIN towns  t ON p.town_id = t.town_id
        LEFT JOIN occupations oc ON oc.OC_ID = p.OC_ID
        WHERE p.cid in (SELECT cid from import_palliative)
        GROUP BY p.cid
        ";
        #######################################
        $query2 = " SELECT if(g.offid is null ,' ', '') as offid FROM gcoffice g  WHERE g.offid = '10953' limit 1 ";
        $query3 = " SELECT if(g.offid is null ,' ', '') as offid FROM gcoffice g  WHERE g.offid = '10953' limit 1 ";
        $query4 = " SELECT if(g.offid is null ,' ', '') as offid FROM gcoffice g  WHERE g.offid = '10953' limit 1 ";
        $query5 = " SELECT if(g.offid is null ,' ', '') as offid FROM gcoffice g  WHERE g.offid = '10953' limit 1 ";
        #######################################
        $query6 = "SELECT o.hn 'HN',
        CASE
            WHEN o.INSCL in (03,04) THEN 'UCS'
            WHEN o.INSCL in (01,25,35,37,40) THEN 'OFC'
            WHEN o.INSCL in (08,09,21,30,31) THEN 'SSS'
            WHEN o.INSCL in (11,12,21,30,31) THEN 'LGO'
            ELSE 'XXX'
          END AS 'INSCL',
        '' AS 'SUBTYPE',
        p.cid AS 'CID',
        g.offid AS 'HCODE',
        '' AS 'DATEEXP',
        ''  AS 'GOVCODE',
        '' AS 'GOVNAME',
        '' AS 'PERMITNO',
        '' AS 'OWNRPID',
        '' AS 'OWNNAME',
        '' AS 'AN',
        '' AS 'SEQ',
        '' AS 'SUBINSCL',
        '' AS 'RELINSCL',
        '' AS 'HTYPE'
        FROM gcoffice g, opd_visits o
        INNER JOIN cid_hn c ON o.hn = c.hn 
        INNER JOIN population p ON p.cid = c.cid
        INNER JOIN towns  t ON p.town_id = t.town_id
        LEFT JOIN occupations oc ON oc.OC_ID = p.OC_ID
        LEFT JOIN uc_inscl uc ON uc.cid = p.cid AND (uc.date_abort = date(o.REG_DATETIME) or day(uc.date_abort)=0 and trim(uc.hospmain) <>'' )
        LEFT JOIN main_inscls m ON m.inscl = o.inscl 
        LEFT JOIN hosp_sss h ON h.cid = p.cid AND h.DATE_ABORT = 0
        WHERE o.REG_DATETIME BETWEEN '2023-06-18 00:00' AND '2023-06-20 23:59'
        AND o.hn in ('014006','103713','057786','010936','036167')
        GROUP BY p.cid
        LIMIT 200";
        ##################################################################
        $query7 = " SELECT if(g.offid is null ,' ', '') as offid FROM gcoffice g  WHERE g.offid = '10953' limit 1 ";
        $query8 = " SELECT if(g.offid is null ,' ', '') as offid FROM gcoffice g  WHERE g.offid = '10953' limit 1 ";
        $query9 = " SELECT if(g.offid is null ,' ', '') as offid FROM gcoffice g  WHERE g.offid = '10953' limit 1 ";
       
        $results1 = $db14->createCommand($query1)->queryAll();
        $results2 = $db14->createCommand($query2)->queryAll();
        $results3 = $db14->createCommand($query3)->queryAll();
        $results4 = $db14->createCommand($query4)->queryAll();
        $results5 = $db14->createCommand($query5)->queryAll();
        $results6 = $db14->createCommand($query6)->queryAll();
        $results7 = $db14->createCommand($query7)->queryAll();
        $results8 = $db14->createCommand($query8)->queryAll();
        $results9 = $db14->createCommand($query9)->queryAll();
        //$results10 = $db14->createCommand($query3)->queryAll();
        // Define the base directory path where you want to export the text files
        
        $baseDirectory = 'exports/palliative/all/';
        $mode = 0777; // Set the desired mode (permissions)
        //$baseDirectory1 = 'exports/palliative/all/';
        //$mode = 0777; // Set the desired mode (permissions)

        // Export the results of each query to separate text files
        
        $this->exportToTextFile($results1, $baseDirectory . 'PAT.txt',
         ['HCODE','HN','CHANGWAT','AMPHUR','DOB','SEX','MARRIAGE','OCCUPA','NATION','PERSON_ID','NAMEPAT','TITLE','FNAME','LNAME','IDTYPE']); // Specify header column names
        
         $this->exportToTextFile($results2, $baseDirectory . 'OPD.txt',
         ['HN','CLINIC','DATEOPD','TIMEOPD','SEQ','UUC','DETAL','BTEMP','SBP','DBP','PR','RR','OPTYPE','TYPEIN','TYPEOUT']); // Specify header column names
       
         $this->exportToTextFile($results3, $baseDirectory . 'CHA.txt',
         ['HN','AN','DATE','CHRGITEM','AMOUNT','PERSON_ID','SEQ']); 
         
         $this->exportToTextFile($results4, $baseDirectory . 'CHT.txt',
         ['HN','AN','DATE','TOTAL','PAID','PTTYPE','PERSON_ID','SEQ','OPD_MEMO','INVOICE_NO','INVOICE_LT']); 

         $this->exportToTextFile($results5, $baseDirectory . 'DRU.txt',
         ['HCODE','HN','AN','CLINIC','PERSON_ID','DATE_SERV','DID','DIDNAME','AMOUNT','DRUGPRICE','DRUGCOST','DIDSTD','UNIT','UNIT_PACK','SEQ','DRUGREMARK','PA_NO','TOTCOPAY','USE_STATUS','TOTAL','SIGCODE','SIGTEXT','PROVIDER']); 

         $this->exportToTextFile($results6, $baseDirectory . 'INS.txt',
         ['HN','INSCL','SUBTYPE','CID','HCODE','DATEEXP','HOSPMAIN','HOSPSUB','GOVCODE','GOVNAME','PERMITNO','DOCNO','OWNRPID','OWNNAME','AN','SEQ','SUBINSCL','RELINSCL','HTYPE']); 

         $this->exportToTextFile($results7, $baseDirectory . 'ODX.txt',
         ['HN','DATEDX','CLINIC','DIAG','DXTYPE','DRDX','PERSON_ID','SEQ']); 

         $this->exportToTextFile($results8, $baseDirectory . 'OOP.txt',
         ['HN','DATEOPD','CLINIC','PER','DROPID','PERSON_ID','SEQ']); 

         $this->exportToTextFile($results9, $baseDirectory . 'ORF.txt',
         ['HN','DATEOPD','CLINIC','REFER','REFERTYPE','SEQ','REFERDATE']); 
        // $baseDirectory1 = 'exports/palliative/3/';   
         // Create a ZIP archive
         //$zipFilename = $baseDirectory . 'xDownload.zip';
         //$currentDateTime = date('YmdHis');
         //$zipFilename = $baseDirectory . '_F16_Paliiative_' . $currentDateTime . '.zip';
         $zipFilename = $baseDirectory . '_F16-Palliative.zip';
         $zip = new ZipArchive();
         $zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE);
         
         $files = FileHelper::findFiles($baseDirectory);
         foreach ($files as $file) {
             $relativePath = str_replace($baseDirectory . '/', '', $file);
             $zip->addFile($file, $relativePath);
         }
         
         $zip->close();
         // Set appropriate headers  ดาวน์โหลดไฟล์ ##########################
         header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . basename($zipFilename) . '"');
        header('Content-Length: ' . filesize($zipFilename));
        readfile($zipFilename);
        // Serve the ZIP file
        //readfile($zipFilename);

        // Delete the ZIP file after it's downloaded
        unlink($zipFilename);

        //return $this->render('export-success');
        return $this->render('export', ['baseDirectory' => $baseDirectory]);
        
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
    
    ###################################################################################
    public function actionMultitextfiles()
    {
    $db14 = \Yii::$app->db14;
    $queries = [
        [
            'name' => 'PAT',
            'query' => (new Query())->select(['o.unit_reg as HCODE',
             'o.hn HN',
             'LEFT( p.TOWN_ID, 2 ) CHANGWAT'
              ])
            ->from('opd_visits o')
            ->innerJoin('cid_hn c', 'c.hn = o.hn')
            ->innerJoin('population p', 'p.cid = c.cid')
            ->innerJoin('towns t', 't.town_id = p.town_id')
            ->innerJoin('occupations oc', 'oc.oc_id = p.oc_id')
            ->where(['o.hn' => '015006'])
            ->andWhere(['o.hn' => '015009'])
            ->groupBy(['p.cid']),
            'filename' => 'PAT.txt',
            'header' => ['HCODE','HN','CHANGWAT','AMPHUR','DOB','SEX','MARRIAGE','OCCUPA','NATION','PERSON_ID','NAMEPAT','TITLE','FNAME','LNAME','IDTYPE'],
        ],
        [
            'name' => 'OPD',
            'query' => (new Query())->select('*')->from('setup_jwt')->where(['id' => 1]),
            'filename' => 'OPD.txt',
            'header' => ['HN','CLINIC','DATEOPD','TIMEOPD','SEQ','UUC','DETAL','BTEMP','SBP','DBP','PR','RR','OPTYPE','TYPEIN','TYPEOUT'],
        ],
        // Add more queries as needed
    ];

    // Define the base directory path where you want to export the text files
    $baseDirectory = 'exports/palliative/3/';

    // Create the base directory if it doesn't exist
    FileHelper::createDirectory($baseDirectory);

    // Loop through the queries and export each result as a separate text file
    foreach ($queries as $queryData) {
        // Execute the query and fetch all the results
       // $results = \yii::$app->db14->createCommand($query)->queryAll();
        $results = $queryData['query']->all($db14);

        // Create the full file path by combining the base directory and filename
        $filePath = $baseDirectory . $queryData['filename'];

        // Open the file in write mode
        $file = fopen($filePath, 'w');
        fwrite($file, "\xEF\xBB\xBF"); // Add UTF-8 BOM
        // Write the header to the file
        fwrite($file, implode("|", $queryData['header']) . PHP_EOL);
        // Loop through the results and write them to the file
        foreach ($results as $result) {
            fwrite($file, implode("|", $result) . PHP_EOL);
        }

        // Close the file
        fclose($file);
    }

        // Render the view that displays the links to download the exported files
        return $this->render('export', ['baseDirectory' => $baseDirectory, 'queries' => $queries]);
    }

    public function actionExporttext()
    {
        // Create PAT.text
        $query = new Query();
        $query->select('*')
            ->from('room')
            ->where(['is_cancel' => 1]);
        // Execute the query and fetch all the results
        $results = $query->all();
        // Define the file path where you want to export the text file
        $filePath = 'exports/palliative/PAT.txt';  //'uploads/booking/pdf';
        $baseDirectory = 'exports/palliative/all/';
        FileHelper::createDirectory($baseDirectory);
        // Define custom headers
        $headers = ['HCODE','HN','CHANGWAT','AMPHUR','DOB','SEX','MARRIAGE','OCCUPA','NATION','PERSON_ID','NAMEPAT','TITLE','FNAME','LNAME','IDTYPE'];
        // Open the file in write mode
        $file = fopen($filePath, 'w');

         // Write the headers to the file
         fwrite($file, implode("|", $headers) . PHP_EOL);

        // Loop through the results and write them to the file
        foreach ($results as $result) {
            fwrite($file, implode("|", $result) . PHP_EOL);
        }
        // Close the file
        fclose($file);
        // Set the appropriate headers to force download the file
        Yii::$app->response->headers->set('Content-Type', 'text/plain');
        Yii::$app->response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filePath) . '"');
        Yii::$app->response->sendFile($filePath);
        return $this->render('index', ['baseDirectory' => $baseDirectory]);
           //return $this->render('index');
        } 
########################### CHA #######################################        
 public function actionCha()
        {
            // Create PAT.text
            $query = new Query();
            $query->select('*')
                ->from('room')
                ->where(['is_cancel' => 1]);
            // Execute the query and fetch all the results
            $results = $query->all();
            // Define the file path where you want to export the text file
            $filePath = 'exports/palliative/CHA.txt';  //'uploads/booking/pdf';
            #$filePath = '/path/to/your/file.txt';
            // Define custom headers
            $headers = ['HN','AN','DATE','CHRGITEM','AMOUNT','PERSON_ID','SEQ'];
            // Open the file in write mode
            $file = fopen($filePath, 'w');

            // Write the headers to the file
            fwrite($file, implode("|", $headers) . PHP_EOL);

            // Loop through the results and write them to the file
            foreach ($results as $result) {
                fwrite($file, implode("|", $result) . PHP_EOL);
            }
            // Close the file
            fclose($file);
            // Set the appropriate headers to force download the file
            Yii::$app->response->headers->set('Content-Type', 'text/plain');
            Yii::$app->response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filePath) . '"');
            Yii::$app->response->sendFile($filePath);
                return $this->render('index');
        } 
########################### CHT #######################################        
 public function actionCht()
        {
        $query = new Query();
        $query->select('*')
            ->from('room')
            ->where(['is_cancel' => 1]);
        // Execute the query and fetch all the results
        $results = $query->all();
        // Define the file path where you want to export the text file
        $filePath = 'exports/palliative/CHT.txt';  
        // Define custom headers
        $headers = ['HN','AN','DATE','TOTAL','PAID','PTTYPE','PERSON_ID','SEQ','OPD_MEMO','INVOICE_NO','INVOICE_LT'];
        // Open the file in write mode
        $file = fopen($filePath, 'w');

        // Write the headers to the file
        fwrite($file, implode("|", $headers) . PHP_EOL);

        // Loop through the results and write them to the file
        foreach ($results as $result) {
            fwrite($file, implode("|", $result) . PHP_EOL);
        }
        // Close the file
        fclose($file);
        // Set the appropriate headers to force download the file
        Yii::$app->response->headers->set('Content-Type', 'text/plain');
        Yii::$app->response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filePath) . '"');
        Yii::$app->response->sendFile($filePath);
            return $this->render('index');
         } 
########################### INS #######################################        
public function actionIns()
        {
        $query = new Query();
        $query->select('*')
            ->from('room')
            ->where(['is_cancel' => 1]);
        // Execute the query and fetch all the results
        $results = $query->all();
        // Define the file path where you want to export the text file
        $filePath = 'exports/palliative/INS.txt'; 
        // Define custom headers
        $headers = ['HN','INSCL','SUBTYPE','CID','HCODE','DATEEXP','HOSPMAIN','HOSPSUB','GOVCODE','GOVNAME','PERMITNO','DOCNO','OWNRPID','OWNNAME','AN','SEQ','SUBINSCL','RELINSCL','HTYPE'];
        // Open the file in write mode
        $file = fopen($filePath, 'w');

        // Write the headers to the file
        fwrite($file, implode("|", $headers) . PHP_EOL);

        // Loop through the results and write them to the file
        foreach ($results as $result) {
            fwrite($file, implode("|", $result) . PHP_EOL);
        }
        // Close the file
        fclose($file);
        // Set the appropriate headers to force download the file
        Yii::$app->response->headers->set('Content-Type', 'text/plain');
        Yii::$app->response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filePath) . '"');
        Yii::$app->response->sendFile($filePath);
            return $this->render('index');
        } 
########################### DRU #######################################        
public function actionDru()
        {
        $query = new Query();
        $query->select('*')
            ->from('room')
            ->where(['is_cancel' => 1]);
        // Execute the query and fetch all the results
        $results = $query->all();
        // Define the file path where you want to export the text file
        $filePath = 'exports/palliative/DRU.txt'; 
        // Define custom headers
        $headers = ['HCODE','HN','AN','CLINIC','PERSON_ID','DATE_SERV','DID','DIDNAME','AMOUNT','DRUGPRICE','DRUGCOST','DIDSTD','UNIT','UNIT_PACK','SEQ','DRUGREMARK','PA_NO','TOTCOPAY','USE_STATUS','TOTAL','SIGCODE','SIGTEXT','PROVIDER'];
        // Open the file in write mode
        $file = fopen($filePath, 'w');

        // Write the headers to the file
        fwrite($file, implode("|", $headers) . PHP_EOL);

        // Loop through the results and write them to the file
        foreach ($results as $result) {
            fwrite($file, implode("|", $result) . PHP_EOL);
        }
        // Close the file
        fclose($file);
        // Set the appropriate headers to force download the file
        Yii::$app->response->headers->set('Content-Type', 'text/plain');
        Yii::$app->response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filePath) . '"');
        Yii::$app->response->sendFile($filePath);
            return $this->render('index');
        } 
########################### ODX #######################################        
public function actionOdx()
        {
        $query = new Query();
        $query->select('*')
            ->from('room')
            ->where(['is_cancel' => 1]);
        // Execute the query and fetch all the results
        $results = $query->all();
        // Define the file path where you want to export the text file
        $filePath = 'exports/palliative/ODX.txt'; 
        // Define custom headers
        $headers = ['HN','DATEDX','CLINIC','DIAG','DXTYPE','DRDX','PERSON_ID','SEQ'];
        // Open the file in write mode
        $file = fopen($filePath, 'w');

        // Write the headers to the file
        fwrite($file, implode("|", $headers) . PHP_EOL);

        // Loop through the results and write them to the file
        foreach ($results as $result) {
            fwrite($file, implode("|", $result) . PHP_EOL);
        }
        // Close the file
        fclose($file);
        // Set the appropriate headers to force download the file
        Yii::$app->response->headers->set('Content-Type', 'text/plain');
        Yii::$app->response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filePath) . '"');
        Yii::$app->response->sendFile($filePath);
            return $this->render('index');
        } 
########################### OOP #######################################        
public function actionOop()
        {
        $query = new Query();
        $query->select('*')
            ->from('room')
            ->where(['is_cancel' => 1]);
        // Execute the query and fetch all the results
        $results = $query->all();
        // Define the file path where you want to export the text file
        $filePath = 'exports/palliative/OOP.txt'; 
        // Define custom headers
        $headers = ['HN','DATEOPD','CLINIC','PER','DROPID','PERSON_ID','SEQ'];
        // Open the file in write mode
        $file = fopen($filePath, 'w');

        // Write the headers to the file
        fwrite($file, implode("|", $headers) . PHP_EOL);

        // Loop through the results and write them to the file
        foreach ($results as $result) {
            fwrite($file, implode("|", $result) . PHP_EOL);
        }
        // Close the file
        fclose($file);
        // Set the appropriate headers to force download the file
        Yii::$app->response->headers->set('Content-Type', 'text/plain');
        Yii::$app->response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filePath) . '"');
        Yii::$app->response->sendFile($filePath);
            return $this->render('index');
        } 
########################### OPD #######################################        
public function actionOpd()
        {
        $query = new Query();
        $query->select('*')
            ->from('room')
            ->where(['is_cancel' => 1]);
        // Execute the query and fetch all the results
        $results = $query->all();
        // Define the file path where you want to export the text file
        $filePath = 'exports/palliative/OPD.txt'; 
        // Define custom headers
        $headers = ['HN','CLINIC','DATEOPD','TIMEOPD','SEQ','UUC','DETAL','BTEMP','SBP','DBP','PR','RR','OPTYPE','TYPEIN','TYPEOUT'];
        // Open the file in write mode
        $file = fopen($filePath, 'w');

        // Write the headers to the file
        fwrite($file, implode("|", $headers) . PHP_EOL);

        // Loop through the results and write them to the file
        foreach ($results as $result) {
            fwrite($file, implode("|", $result) . PHP_EOL);
        }
        // Close the file
        fclose($file);
        // Set the appropriate headers to force download the file
        Yii::$app->response->headers->set('Content-Type', 'text/plain');
        Yii::$app->response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filePath) . '"');
        Yii::$app->response->sendFile($filePath);
            return $this->render('index');
        }  
########################### ORF#######################################        
public function actionOrf()
        {
        $query = new Query();
        $query->select('*')
            ->from('room')
            ->where(['is_cancel' => 1]);
        // Execute the query and fetch all the results
        $results = $query->all();
        // Define the file path where you want to export the text file
        $filePath = 'exports/palliative/ORF.txt'; 
        // Define custom headers
        $headers = ['HN','DATEOPD','CLINIC','REFER','REFERTYPE','SEQ','REFERDATE'];
        // Open the file in write mode
        $file = fopen($filePath, 'w');

        // Write the headers to the file
        fwrite($file, implode("|", $headers) . PHP_EOL);

        // Loop through the results and write them to the file
        foreach ($results as $result) {
            fwrite($file, implode("|", $result) . PHP_EOL);
        }
        // Close the file
        fclose($file);
        // Set the appropriate headers to force download the file
        Yii::$app->response->headers->set('Content-Type', 'text/plain');
        Yii::$app->response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filePath) . '"');
        Yii::$app->response->sendFile($filePath);
            return $this->render('index');
        }  
########################### ADP#######################################        
public function actionAdp()
        {
        $query = new Query();
        $query->select('*')
            ->from('room')
            ->where(['is_cancel' => 1]);
        // Execute the query and fetch all the results
        $results = $query->all();
        // Define the file path where you want to export the text file
        $filePath = 'exports/palliative/ADP.txt'; 
        // Define custom headers
        $headers = ['HN','AN','DATEOPD','TYPE','CODE','QTY','RATE','SEQ','CAGCODE','DOSE','CA_TYPE','SERIALNO','TOTCOPAY','USE_STATUS','TOTAL','QTYDAY','TMTLTCODE','STATUS','BI','CLINIC','ITEMSRC','PROVIDER','GRAVIDA','GAWEEK','DCIP_E_screen','LMP'];
        // Open the file in write mode
        $file = fopen($filePath, 'w');

        // Write the headers to the file
        fwrite($file, implode("|", $headers) . PHP_EOL);

        // Loop through the results and write them to the file
        foreach ($results as $result) {
            fwrite($file, implode("|", $result) . PHP_EOL);
        }
        // Close the file
        fclose($file);
        // Set the appropriate headers to force download the file
        Yii::$app->response->headers->set('Content-Type', 'text/plain');
        Yii::$app->response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filePath) . '"');
        Yii::$app->response->sendFile($filePath);
            return $this->render('index');
        }  
########################### LABFU #######################################        
public function actionLabfu()
        {
        $query = new Query();
        $query->select('*')
            ->from('room')
            ->where(['is_cancel' => 1]);
        // Execute the query and fetch all the results
        $results = $query->all();
        // Define the file path where you want to export the text file
        $filePath = 'exports/palliative/LABFU.txt'; 
        $baseDirectory = 'exports/palliative/all/';
        FileHelper::createDirectory($baseDirectory);
        
        // Define custom headers
        $headers = ['HCODE','HN','PERSON_ID','DATESERV','SEQ','LABTEST','LABRESULT'];
        // Open the file in write mode
        $file = fopen($filePath, 'w');

        // Write the headers to the file
        fwrite($file, implode("|", $headers) . PHP_EOL);

        // Loop through the results and write them to the file
        foreach ($results as $result) {
            fwrite($file, implode("|", $result) . PHP_EOL);
        }
        // Close the file
        fclose($file);
        // Set the appropriate headers to force download the file
        Yii::$app->response->headers->set('Content-Type', 'text/plain');
        Yii::$app->response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filePath) . '"');
        Yii::$app->response->sendFile($filePath);
            return $this->render('index');
        }
################### Export Multi Text Files ###########################################
 public function actionMultitext()
        {
            // Create a new query object
            $query = new Query();
    
            // Build your query
            $query->select('*')
                ->from('room')
                ->where(['is_cancel' => 1]);
    
            // Execute the query and fetch all the results
            $results = $query->all();
    
            // Define the base directory path where you want to export the text files
            $baseDirectory = 'exports/palliative/all/';
    
            // Create the base directory if it doesn't exist
            FileHelper::createDirectory($baseDirectory);
    
            // Loop through the results and export each result as a separate text file
            foreach ($results as $index => $result) {
                // Generate a unique file name based on the result index
                $fileName = 'file_' . ($index + 1) . '.txt';
    
                // Create the full file path by combining the base directory and file name
                $filePath = $baseDirectory . $fileName;
    
                // Open the file in write mode
                $file = fopen($filePath, 'w');
    
                // Write the result to the file
                fwrite($file, implode("|", $result) . PHP_EOL);
    
                // Close the file
                fclose($file);
            }
    
            // Render the view that displays the links to download the exported files
            return $this->render('export', ['baseDirectory' => $baseDirectory]);
        }
  
    }


