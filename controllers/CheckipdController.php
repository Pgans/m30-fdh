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
use app\models\Logfdhipd;
use yii\db\Exception;


class CheckipdController extends \yii\web\Controller
{
    public function actionIndexxxx()
    {
        // $_token = $model->token;


        return $this->render('indexxxx');
    }
    ################# ดึงข้อมูลให้ฟอร์มรายชื่อ ########################
    public function actionIndex()
    {
         $data = Yii::$app->request->post();
        $date1 = isset($data['date1']) ? date('Y-m-d 00:01', strtotime($data['date1'])) : '';
        $date2 = isset($data['date2']) ? date('Y-m-d 23:59', strtotime($data['date2'])) : '';
      /*
    // ตรวจสอบถ้ามีการส่งค่า date1 และ date2
    $date1 = isset($data['date1']) ? date('Y-m-d 00:01', strtotime($data['date1'])) : '';
    $date2 = isset($data['date2']) ? date('Y-m-d 23:59', strtotime($data['date2'])) : '';

    // ถ้าไม่มีการเลือกวันที่ ให้กำหนดวันที่ย้อนหลัง 1 เดือนจากวันนี้
    if (empty($date1) || empty($date2)) {
        $date1 = date('Y-m-d 00:01', strtotime('-1 month')); // ย้อนกลับ 1 เดือน
        $date2 = date('Y-m-d 23:59'); // วันนี้ (วันสุดท้ายของเดือน)
    }
	*/
/*
        $sql = "SELECT @n :=@n +1 'No',
o.visit_id, o.pid, o.an ,o.messagecode ,o.response , o.messages  , o.users , o.d_update
FROM (select @n := 0) m,log_fdh_ipd_ckx o
WHERE o.d_update BETWEEN '$date1' AND '$date2'  #and (o.status_message_th = '' OR  ISNULL(status_message_th))
ORDER BY No  DESC
 ";
 */  
 $sql = "SELECT 
				@n := @n + 1 AS No,
				data.*
			FROM 
				(SELECT a.visit_id, a.adm_id as an, b.hn as pid,li.pid as pid1 ,li.an as an1, li.messagecode, li.response, 
						li.messages, li.users, li.d_update, a.adm_dt, a.dsc_dt,s.unit_name
				 FROM ipd_reg a 
				 LEFT JOIN opd_visits b ON a.VISIT_ID = b.VISIT_ID AND a.IS_CANCEL = 0 
				 LEFT JOIN cid_hn c ON c.HN = b.HN 
				 LEFT JOIN population d ON c.CID = d.CID
				 LEFT JOIN main_inscls e ON e.INSCL = b.INSCL
				 LEFT JOIN log_fdh_ipd_ck li ON li.visit_id = a.visit_id 
				 LEFT JOIN service_units s  ON s.unit_id = a.ward_no
				 WHERE a.DSC_DT BETWEEN '$date1' AND '$date2'
				   AND b.IS_CANCEL = 0
				   AND b.INSCL IN ('03','04','33','00','23')
				   AND (li.messages = '' OR li.messages IS NULL OR li.messages = 'rejected')
				   #AND a.WARD_NO NOT IN ('57')
				   AND a.dsc_dt <> 0
				   #AND li.users <> ''
				 GROUP BY a.adm_id, a.visit_id, li.pid, li.an, li.messagecode, li.response, 
						  li.messages, li.users, li.d_update, a.adm_dt, a.dsc_dt
						  
				) AS data
			JOIN (SELECT @n := 0) AS init
			ORDER BY No DESC, an DESC;
 
          ";
 
        $rawData = \yii::$app->db2->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $visitProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 300,
            ],
        ]);
        #########################################################################
        $sqlCount1 = "SELECT COUNT(DISTINCT v.visit_id) as amount
            FROM log_fdh_ipd_ck v 
            WHERE (v.messages <> '' OR v.messages <> 'rejected')
            AND v.d_update BETWEEN CURDATE() AND NOW()
			";

        $data = \yii::$app->db2->createCommand($sqlCount1)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $amount = $data[$i]['amount'];
        }
        $sqlCamount = "SELECT COUNT(DISTINCT v.visit_id) as amountx
            FROM log_fdh_ipd_ck v 
            WHERE (v.messages = '' OR v.messages IS NULL OR v.messages = 'rejected')
            AND v.d_update BETWEEN CURDATE() AND NOW()";
        $data = \yii::$app->db2->createCommand($sqlCamount)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $amountx = $data[$i]['amountx'];
        }
        $total = "SELECT COUNT(DISTINCT v.visit_id) as total
            FROM log_closevisits v 
            WHERE v.messagecode = 'success'
            AND v.send_date BETWEEN '2023-10-01' AND NOW()
             ";

        $data = \yii::$app->db2->createCommand($total)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $total = $data[$i]['total'];
        }

        ########################################################################################################
        $sqlPass = "SELECT l.id, l.visit_id, l.pid , l.messages, l.response, l.users, l.d_update
        
            FROM log_fdh_ipd_ck l
            WHERE (l.messages <>'' OR l.messages <> 'rejected')
            AND l.d_update BETWEEN CURDATE() AND NOW()
        
         ";
        $rawData = \Yii::$app->db14->createCommand($sqlPass)->queryAll();

        // สร้าง Flash Alert
        //Yii::$app->session->setFlash('success', 'รายการที่ไม่ผ่านตามเงื่อนไข');

        $passProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        ########################################################################################################
        $sqlError = "SELECT l.id, l.visit_id, l.pid , l.messages, l.response, l.users, l.d_update
        
            FROM log_fdh_ipd_ck l
            WHERE (l.messages = '' OR l.messages IS NULL OR l.messages = 'rejected')
            AND l.d_update BETWEEN CURDATE() AND NOW()
        
         ";
        $rawData = \Yii::$app->db14->createCommand($sqlError)->queryAll();

        // สร้าง Flash Alert
        //Yii::$app->session->setFlash('success', 'รายการที่ไม่ผ่านตามเงื่อนไข');

        $errorProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        return $this->render('index', [
            // 'searchModel' => $searchModel,
            'visitProvider' => $visitProvider,
            'amount' => $amount,
            'amountx' => $amountx,
            'total' => $total,
            'passProvider' => $passProvider,
            'errorProvider' => $errorProvider,

        ]);
    }

    ################ ActionHt-> ActionCheck #########################
    public function actionCheck()
{
    // Query to get the maximum token
    $sqlToken = "SELECT MAX(token) as token30 FROM fdh_token";
	//$sqltoken = "SELECT MAX(token) as token30 FROM fdh_token WHERE staff_id = 'pgans'";
    $data = \Yii::$app->db2->createCommand($sqlToken)->queryAll();

    // Check if the token was found
    if (empty($data)) {
        Yii::$app->session->setFlash('error', 'ไม่พบ token ในฐานข้อมูล.');
        return $this->redirect(['index']);
    }

    // Extract the token
    $tokenFdh = $data[0]['token30'];

    // Get the posted 'chkDel' values
    $vn = Yii::$app->request->post('chkDel', []);
    
    // Store results to display after refresh
    $resultData = [];
	
foreach ($vn as $r) {
    // ตัด visit_id (10 ตัวแรก)
    $visitId = substr($r, 0, 10);
    //echo "Visit ID: " . $visitId . "<br>";

    // ตัด an (6 ตัวถัดไป)
    $an = substr($r, 10, 6);
    //echo "AN: " . $an . "<br>";

    // ตัด hn (6 ตัวถัดไป)
    $hn = substr($r, 16, 6);
   // echo "HN: " . $hn . "<br>";

    
        // Prepare POST data for the API call
        $postData = json_encode([
            "hcode" => "10953",
            "an" => $an,
            "hn" => $hn,
            "transaction_uid" => ""
        ]);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://fdh.moph.go.th/api/v1/ucs/track_trans',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer " . $tokenFdh
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        // Handle response
        if ($response === false) {
           Yii::$app->session->setFlash('error', 'ไม่สามารถเรียกใช้ API ได้');
        } else {
            $responseDecoded = json_decode($response, true);

            // Extract relevant data from response
            $status = isset($responseDecoded['data'][0]['status']) ? $responseDecoded['data'][0]['status'] : '';
            $messageTh = isset($responseDecoded['message_th']) ? $responseDecoded['message_th'] : '';
            $statusMessageTh = isset($responseDecoded['data'][0]['status_message_th']) ? $responseDecoded['data'][0]['status_message_th'] : '';

            if (isset($responseDecoded['error'])) {
               Yii::$app->session->setFlash('error', 'ไม่พบข้อมูลจาก API: ' . $responseDecoded['error']);
            } else {
                Yii::$app->session->setFlash('success', 'ตรวจสอบ API สำเร็จแล้ว');

                // ตรวจสอบก่อนว่า AN นี้มีอยู่แล้วหรือไม่
                $checkSQL = "SELECT COUNT(*) FROM log_fdh_ipd_ck WHERE an = :an";
                $exists = \Yii::$app->db2->createCommand($checkSQL)
                    ->bindValue(':an', $an)
                    ->queryScalar(); // ได้ค่าเป็นจำนวนแถวที่พบ

                if ($exists) {
                    // ถ้ามีอยู่แล้ว ให้ UPDATE
                    $logSQLUpdate = "UPDATE log_fdh_ipd_ck 
                                     SET pid = :pid,
                                         response = :response,
                                         messagecode = :status_message_th,
                                         messages = :status,
                                         d_update = NOW() 
                                     WHERE an = :an";

                    \Yii::$app->db2->createCommand($logSQLUpdate)
                        ->bindValue(':pid', $hn)
                        ->bindValue(':response', $response)
                        ->bindValue(':status_message_th', $statusMessageTh)
                        ->bindValue(':status', $status)
                        ->bindValue(':an', $an)
                        ->execute();
                } else {
				// ถ้าไม่มี ให้ INSERT ข้อมูลใหม่ และกำหนด users = 'ipnormal'
				$logSQLInsert = "INSERT INTO log_fdh_ipd_ck (visit_id, an, pid, response, messagecode, messages, d_update, users)
								 VALUES (:visit_id, :an, :pid, :response, :status_message_th, :status, NOW(), '')";

				\Yii::$app->db2->createCommand($logSQLInsert)
					->bindValue(':visit_id', $visitId) // เพิ่มค่าของ visit_id
					->bindValue(':an', $an)
					->bindValue(':pid', $hn)
					->bindValue(':response', $response)
					->bindValue(':status_message_th', $statusMessageTh)
					->bindValue(':status', $status)
					->execute();
				}
            }
        }
    }

    Yii::$app->session->set('resultData', $resultData);
    Yii::$app->session->set('apiProcessingCompleted', true);

    return $this->redirect(['index']);
}

   
    
##########################################
    //     if ($recordExists) {
    //         // Update the existing record
    //         $logSQL = "UPDATE log_fdh_ipd_ck
    //                    SET pid = :pid,
    //                        messagecode = :messagecode,
    //                        response = :response,
    //                        status_message_th = :status_message_th,
    //                        d_update = NOW()
    //                    WHERE visit_id = :visit_id";
    //     } else {
    //         // Insert a new record
    //         $logSQL = "INSERT INTO log_fdh_ipd_ck(visit_id, pid, an, messagecode, response, users, d_update) 
    //         VALUES ('$visitId', '', '$an','', '', '', NOW())";
    //     }

    //     \Yii::$app->db143->createCommand($logSQL)
    //         ->bindValue(':visit_id', $visitId)
    //         ->bindValue(':pid', $an)
    //         ->bindValue(':messagecode', $message)
    //         ->bindValue(':response', $response)
    //         ->bindValue(':status_message_th', $statusMessageTh)
    //         ->execute();
    // }


    //     return $this->redirect(['index']);
    // }

#################################################################################################################
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Logfdhipd::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionDeleteMultiple()
    {
        // รับค่าจากฟอร์ม POST โดยใช้ 'selection' ซึ่งเป็นชื่อที่ `CheckboxColumn` สร้างขึ้น
        $selection = Yii::$app->request->post('selection', []);

        if (!empty($selection)) {
            Logfdhopd::deleteAll(['id' => $selection]); // ลบรายการตาม ID ที่เลือก
            Yii::$app->session->setFlash('success', 'ลบรายการที่เลือกสำเร็จ');
        } else {
            Yii::$app->session->setFlash('error', 'ไม่มีรายการที่เลือก');
        }

        return $this->redirect(['index']); // กลับไปยังหน้า index หรือหน้าเดิม
    }

    public function actionDeleteSpecific()
    {
        // คำสั่ง SQL สำหรับลบ 10 รายการที่ไม่สำเร็จ
        $sql = "DELETE FROM log_closevisits
                WHERE messagecode <> 'success'
                AND users = 'fdh'
                LIMIT 10";

        Yii::$app->db143->createCommand($sql)->execute(); // ดำเนินการลบ

        Yii::$app->session->setFlash('success', 'ลบรายการที่ไม่สำเร็จ 10 รายการสำเร็จ');

        return $this->redirect(['index']); // กลับไปยังหน้า index หรือหน้าเดิม
    }
    public function actionRunCurl()
    {
        // เริ่มต้นการตั้งค่า Flash
        Yii::$app->response->format = Response::FORMAT_JSON;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fdh.moph.go.th/token?Action=get_moph_access_token',
            CURLOPT_RETURNTRANSFER => true,
            //SSL USE
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_TIMEOUT => 30,
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
                'staff_id' => 'yoo',
            ])->execute();

            Yii::$app->session->setFlash('success', 'New token สร้างสำเร็จ');
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', "Database Error: " . $e->getMessage());
        }

        return $this->redirect(['index']);
    }
	
}
