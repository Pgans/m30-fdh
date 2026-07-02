<?php
namespace app\controllers;

use yii\helpers\Html;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use Yii;
use kartik\mpdf\Pdf;
//use mpdf\src\Config\ConfigVariables;
//use mpdf\src\Config\FontVariables;
use mPDF;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UploadCSV;
use yii\web\UploadedFile;
use app\models\Vaccinetoken;
use app\models\Dt;

class HjepiController extends \yii\web\Controller
{
    public function actionIndex()
    {
       // $_token = $model->token;
       

        return $this->render('index');
    }
    public function actionDelete_all()
    {
        //return 'นายชาตรี บุญทา';

        //$selection = \Yii::$app->request->post('selection');
        $visits =  Yii::$app->request->post('chkDel');
         \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $visits;
    
    }
    
    ################ ActionHt-> ActionCheck #########################
    public function actionCheck()
    {
         $sqltoken = "SELECT MAX(token) as token30 FROM vaccine_token";

        $data = \yii::$app->db14->createCommand($sqltoken)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $token30 = $data[$i]['token30'];
        }
    ##################################################################     
        //$vn =  Yii::$app->request->post('chkDel');
		$vn = Yii::$app->request->post('chkDel', []);
      
       foreach ($vn  as $r) {
        $hn = substr($r, 6);
       // echo $hn.'<br />';
        $visit_id = substr($r, 0, 6);
		//echo $visit_id.'<br />';
      $db = Yii::$app->db_jhcis;

	 $sqlPerson = "
            SELECT DISTINCT 
                visitepi.visitno AS vn,
                visitepi.visitno AS seq,
                m.hn,
                person.idcard AS pid,
                '1' AS id_type,
                CASE
                    WHEN TIMESTAMPDIFF(YEAR, person.birth, NOW()) < 15 AND person.sex = '1' THEN 'ด.ช.'
                    WHEN TIMESTAMPDIFF(YEAR, person.birth, NOW()) >= 15 AND person.sex = '1' THEN 'นาย'
                    WHEN TIMESTAMPDIFF(YEAR, person.birth, NOW()) < 15 AND person.sex = '2' THEN 'ด.ญ.'
                    WHEN TIMESTAMPDIFF(YEAR, person.birth, NOW()) >= 15 AND person.sex = '2' AND person.marystatus = '1' THEN 'น.ส.'
                    ELSE 'นาง'
                END AS title,
                TRIM(person.fname) AS fname,
                TRIM(person.lname) AS lname,
                person.marystatus AS marriage,
                person.birth AS dob,
                person.sex AS sex,
                LPAD(person.nation, 3, '0') AS nation,
                '10953' AS hcode,
                'รพ.ม่วงสามสิบ' AS hospital_name,
                CONCAT(DATE_FORMAT(visitepi.dateepi, '%Y-%m-%d'), ' ', TIME_FORMAT(visitepi.dateupdate, '%H:%i')) AS visit_date_time
            FROM 
                visitepi
            LEFT JOIN person ON visitepi.pcucodeperson = person.pcucodeperson AND visitepi.pid = person.pid
            INNER JOIN cdrug ON (visitepi.vaccinecode = cdrug.drugcode AND cdrug.drugtype = '05')
            LEFT JOIN mathhn m ON m.cid = person.idcard
            LEFT JOIN visit v ON visitepi.pcucode = v.pcucode AND visitepi.visitno = v.visitno
            LEFT JOIN user u ON v.pcucode = u.pcucode AND v.username = u.username
            WHERE visitepi.visitno = '$visit_id'
            LIMIT 1
        ";

        // --- Query 2: ข้อมูลวัคซีน
        $sqlVaccine = "
            SELECT 
			cdrug.files18epi as 'code'
			,visitepi.lotno as lot_number
			,right(cdrug.files18epi,1) as dose_quantity
			,'' as manufacturer
		   # ,visitepi.datevacineexpire as expiration_date
			,DATE_FORMAT(visitepi.datevacineexpire,'%Y-%m-%d') as expiration_date
			,CONCAT(
				DATE_FORMAT(visitepi.dateepi, '%Y-%m-%d'),
				' ',
				TIME_FORMAT(visitepi.dateupdate, '%H:%i')
			  ) AS occurence_time
			  ,'' as code_status
			,'' as site_code
			,'IM' as route_code
			  #,concat('ว.',right(u.noofoccupation, 5)) as license_no
			,CONCAT('ว.', RIGHT(IFNULL(u.noofoccupation, '4711183066'), 5)) AS license_no
			,TRIM(IFNULL(fullname, 'ศิริลักษณ์  พลสมัคร')) AS name
			,'' as note
		  FROM  visitepi 
			LEFT JOIN person ON visitepi.pcucodeperson = person.pcucodeperson and visitepi.pid = person.pid 
			INNER  JOIN cdrug ON ( visitepi.vaccinecode=cdrug.drugcode AND cdrug.drugtype='05') 
		  LEFT  JOIN mathhn m ON m.cid = person.idcard
		  
		  LEFT JOIN visit AS v ON visitepi.pcucode=v.pcucode   and visitepi.visitno=v.visitno 
		  LEFT JOIN user AS u ON v.pcucode = u.pcucode  AND v.username = u.username 
		  where visitepi.visitno = '$visit_id'
		  AND cdrug.files18epi <> '401'
        ";

        $params = [':vn' => $visitno];

        $person = $db->createCommand($sqlPerson, $params)->queryOne();
        $vaccines = $db->createCommand($sqlVaccine, $params)->queryAll();

        if (!$person) {
            return ['error' => 'ไม่พบข้อมูล'];
        }

        // เตรียมข้อมูล JSON
        $result = [
            'seq' => $person['seq'],
            'hn' => $person['hn'],
            'pid' => $person['pid'],
            'id_type' => $person['id_type'],
            'title' => $person['title'],
            'fname' => $person['fname'],
            'lname' => $person['lname'],
            'dob' => $person['dob'],
            'sex' => $person['sex'],
			'marriage' => $person['marriage'],
            'nation' => $person['nation'],
            'hcode' => $person['hcode'],
            'hospital_name' => $person['hospital_name'],
            'visit_date_time' => $person['visit_date_time'],
            'vaccine' => []
        ];

        foreach ($vaccines as $v) {
            $result['vaccine'][] = [
                'code' => $v['code'],
                'lot_number' => $v['lot_number'],
                'dose_quantity' => $v['dose_quantity'],
				'expiration_date' => $v['expiration_date'],
				'occurence_time' => $v['occurence_time'],
				'site_code' => $v['site_code'],
				'route_code' => $v['route_code'],
				'license_no' => $v['license_no'],
                'name' => $v['name'],
                'note' => $v['note']
               
            ];
        }

        // $jsonResult = json_encode($result, JSON_PRETTY_PRINT);
        //echo $jsonResult;
    header('Content-Type: application/json; charset=utf-8');

$jsonResult = json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

//echo $jsonResult;


        ############# Send Moph-claim #############
       
         $url = "https://claim-nhso.moph.go.th/api/v1/opd/service-admissions/epi";
       

        $curl = curl_init($url);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
           
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        //SSL USE
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $jsonResult,
            CURLOPT_HTTPHEADER => array(
                "Content-type: application/json",
                "Authorization: Bearer " . $token30
            ),
        ));

        $response = curl_exec($curl);
        $dmht = json_decode($response, true);
        $err = curl_error($curl);
        //curl_close($curl);
      //  echo $response;
        curl_close($curl);
      // $pid = $dmht['results']['pid'];
        $message = $dmht['message'];
        $message_th = $dmht['message_th'];
        $status = $dmht['status'];
      //  echo $response;
		
	
############################INSERT TABLE Log_epi#############################

         if (strlen($response) > 0 ) {
               $strSQL = "INSERT INTO log_dt (visit_id, pid,status, messagecode ,response , users,d_update) VALUES ('$visit_id','$hn',$status,'$message','$message_th' ,'hjepi',NOW())";
             //  $strSQL = "REPLACE INTO log_dt (visit_id, pid, cid,status, messagecode ,response , users,d_update) VALUES ('$visit_id','$hn','$pid',$status,'$message','$message_th' ,'dt',NOW())";
               Yii::$app->db_jhcis->createCommand($strSQL)->execute();
          
            }
          }
          return $this->redirect(['hjepi']);
        }
      
                
    ################# ดึงข้อมูลให้ฟอร์ม EPI########################
    public function actionHjepi() {
        $sql ="  SELECT 
        @n := @n + 1 AS 'No',
        data.*
FROM
(SELECT 
        TRIM( visitepi.pcucodeperson ) AS HOSPCODE, 
      person.idcard,
      m.hn,
        visitepi.pid AS PID, 
        visitepi.visitno AS visit_id, 
        IF( visitepi.dateepi IS NULL OR TRIM( visitepi.dateepi ) = '' OR visitepi.dateepi LIKE '0000-00-00%', '', DATE_FORMAT( visitepi.dateepi, '%Y%m%d' ) ) AS DATE_SERV,
        cdrug.files18epi AS VCCTYPE,
        CONCAT(person.fname,' ',person.lname) as fullname ,
        timestampdiff(year,person.birth,visitepi.dateupdate) as age,
      cdrug.drugcode,
      visitepi.lotno,
      visitepi.datevacineexpire,
      visitepi.dateepi,
      visitepi.dateupdate,
      v.claimcode_nhso,
        IF( visitepi.hosservice IS NULL OR visitepi.hosservice = '', IFNULL( visitepi.pcucode, '00000' ), TRIM( visitepi.hosservice ) ) AS VCCPLACE, 
      IF( u.idcard IS NULL OR TRIM( u.idcard ) = '', '', u.idcard ) AS PROVIDER, 
        IF( visitepi.dateupdate IS NULL OR TRIM( visitepi.dateupdate ) = '' OR  visitepi.dateupdate LIKE '0000-00-00%', DATE_FORMAT( visitepi.dateepi, '%Y%m%d%H%i%s' ), DATE_FORMAT( visitepi.dateupdate, '%Y%m%d%H%i%s' ) ) AS D_UPDATE
    FROM 
    (select @n := 0) m, visitepi 
        LEFT JOIN person ON visitepi.pcucodeperson = person.pcucodeperson and visitepi.pid = person.pid 
        INNER  JOIN cdrug ON ( visitepi.vaccinecode=cdrug.drugcode) #AND cdrug.drugtype='05' ) #AND left(drugcode,3 )= 'HPV' ) 
      LEFT  JOIN mathhn m ON m.cid = person.idcard
      #LEFT JOIN mbase_data1.authen_kiosk as a on a.cid = person.idcard AND date(a.d_update) = visitepi.dateepi
      LEFT JOIN visit AS v ON visitepi.pcucode=v.pcucode   and visitepi.visitno=v.visitno 
      LEFT JOIN `user` AS u ON v.pcucode = u.pcucode  AND v.username = u.username 
    WHERE 
        visitepi.dateepi IS NOT NULL 
        AND TRIM( visitepi.dateepi ) <> '' 
        AND TRIM( visitepi.pcucodeperson ) <> '' 
        AND ( ( visitepi.dateepi >= ( DATE_SUB( CURDATE(), INTERVAL 10 YEAR ) ) ) OR ( DATE( visitepi.dateupdate ) >= ( DATE_SUB( CURDATE(), INTERVAL 10 YEAR ) ) ) )
        AND DATE_FORMAT( visitepi.dateepi, '%Y-%m-%d' ) BETWEEN '2024-10-01'  AND NOW()
                    AND left(drugcode,3 ) <> 'HPV' 
                    AND visitepi.visitno <> ''
                    AND cdrug.files18epi <> '401'
                    AND visitepi.visitno <> ''
                    AND v.claimcode_nhso <> ''
                    AND visitepi.lotno <> ''
                    AND timestampdiff(year,person.birth,visitepi.dateupdate) <= 14
					AND visitepi.visitno  not in (SELECT vs.visit_id from log_dt vs )
        GROUP BY visitepi.visitno
        #ORDER BY NO  DESC  
		) AS data,
        (SELECT @n := 0) AS init
      ORDER BY 
        No DESC 
		 limit 30

        ";
            $rawData = \yii::$app->db_jhcis->createCommand($sql)->queryAll();
            try {
                $rawData = \Yii::$app->db_jhcis->createCommand($sql)->queryAll();
            } catch (\yii\db\Exception $e) {
                throw new \yii\web\ConflictHttpException('sql error');
            }
            $hjpvProvider = new \yii\data\ArrayDataProvider([
                'allModels' => $rawData,
                'pagination' => [
                    'pageSize' =>10,
                ],
            ]);
         $sqlCount1 = "SELECT COUNT(DISTINCT v.visit_id) as amount
            FROM log_dt v 
            WHERE v.messagecode = 'success'
            AND v.d_update BETWEEN CURDATE() AND NOW()
            AND v.users = 'hjepi'
            ";
        
         $data = \yii::$app->db_jhcis->createCommand($sqlCount1)->queryAll();
             for ($i = 0; $i < sizeof($data); $i++) {
                 $amount = $data[$i]['amount'];    
             }
             $sqlCamount = "SELECT COUNT(DISTINCT v.visit_id) as amountx
             FROM log_dt v 
             WHERE v.status <> '200'
             AND v.d_update BETWEEN CURDATE() AND NOW()
             AND v.users = 'hjepi'
             ";
             $data = \yii::$app->db_jhcis->createCommand($sqlCamount)->queryAll();
             for ($i = 0; $i < sizeof($data); $i++) {
                 $amountx = $data[$i]['amountx'];    
             }
             $total = "SELECT COUNT(DISTINCT v.visit_id) as total
            FROM log_dt v 
            WHERE v.status = '200'
            AND v.users = 'hjepi'
             ";
        
         $data = \yii::$app->db_jhcis->createCommand($total)->queryAll();
             for ($i = 0; $i < sizeof($data); $i++) {
                 $total = $data[$i]['total'];    
             }
      ########################################################################################################
        $sqlPass = "select l.id, l.visit_id, l.pid ,status, l.messagecode, l.response, l.users, l.d_update
        FROM log_dt l 
        WHERE l.d_update BETWEEN CURDATE() AND NOW()
        AND l.status= '200' 
        ORDER BY l.d_update DESC
        
         ";
        $rawData = \Yii::$app->db_jhcis->createCommand($sqlPass)->queryAll();

        // สร้าง Flash Alert
        //Yii::$app->session->setFlash('success', 'รายการที่ไม่ผ่านตามเงื่อนไข');

        $passProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        ########################################################################################################
        $sqlError = "select l.id, l.visit_id, l.pid ,status, l.messagecode, l.response, l.users, l.d_update
        FROM log_dt l 
        WHERE l.d_update BETWEEN CURDATE() AND NOW()
        AND l.status <> '200' 
        ORDER BY l.d_update DESC
        
         ";
        $rawData = \Yii::$app->db_jhcis->createCommand($sqlError)->queryAll();

        // สร้าง Flash Alert
        //Yii::$app->session->setFlash('success', 'รายการที่ไม่ผ่านตามเงื่อนไข');

        $errorProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
            return $this->render('hpv', [
                // 'searchModel' => $searchModel,
                'hjpvProvider' => $hjpvProvider,
                 'amount'=>$amount,  
                'amountx'=>$amountx, 
                'total'=>$total,   
				'passProvider'=>$passProvider,   	
				'errorProvider'=>$errorProvider,   
    
            ]);
          }
		

################ ลบ 10 รายการ ########################################################################
		   public function actionDeleteSome()
{
    Yii::$app->db_jhcis->createCommand("
        DELETE FROM log_dt
        WHERE id IN (
            SELECT id FROM (
                SELECT id FROM log_dt
                WHERE messagecode <> 'success'
                LIMIT 10
            ) AS temp
        )
    ")->execute();

    Yii::$app->session->setFlash('success', 'ลบข้อมูลไม่ใช่ success จำนวน 10 รายการแล้ว');
    return $this->redirect(['hjepi']);
}

	###############################################################################################
		  public function actionRunCurl()
    {
        // เริ่มต้นการตั้งค่า Flash
        Yii::$app->response->format = Response::FORMAT_JSON;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fdh.moph.go.th/token?Action=get_moph_access_token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
             //SSL USE
             CURLOPT_SSL_VERIFYHOST => 0,
             CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode([
				  'user' => 'chatree.10953',
                'password_hash' => 'EA83F69D2E86DD5DB0EFEDFA4580F37D147477460C1703E466474B2C2DD7FC69',
                'hospital_code' => '10953'
            ]),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
        ));

        $response = curl_exec($curl);  // รัน cURL และเก็บผลลัพธ์
        $err = curl_error($curl);     // ใช้ตัวแปร $curl ที่ถูกต้อง
        curl_close($curl);            // ปิด cURL


        if ($err) {
            Yii::$app->session->setFlash('error', "cURL Error: $err");
            return $this->redirect(['index']); 
        }

        try {
            Yii::$app->db2->createCommand()->insert('fdh_token', [
                'token_dt' => date('Y-m-d H:i:s'),
                'token' => $response,
                'staff_id' => 'pgans',
            ])->execute();

            Yii::$app->session->setFlash('success', 'New token สร้างสำเร็จ');
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', "Database Error: " . $e->getMessage());
        }

        return $this->redirect(['index']); 
    }
		  }
		 