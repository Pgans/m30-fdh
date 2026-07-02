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
use app\models\Logfdhopd;
use yii\db\Exception;


class CheckopdController extends \yii\web\Controller
{
	public function actionIndex3()
    {	 
	     $sqlCount1 = "SELECT COUNT(DISTINCT v.id) as amount
			FROM log_thaimed v 
			";
        
         $data = \yii::$app->db->createCommand($sqlCount1)->queryAll();
             for ($i = 0; $i < sizeof($data); $i++) {
                 $amount = $data[$i]['amount'];    
             }
        //return $this->render('index');
		return $this->render('index3',[
              'dataProvider' => $dataProvider,
             // 'sql'=>$sql,
			 // 'date1'=>$date1,
			  //'date2'=>$date2,
			 // 'amount'=>$amount, 
          ]);
    }
	
	################################################################
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
		
        $sql = "SELECT 
        @n := @n + 1 AS 'No',
        data.*
      FROM 
		(SELECT 
		o.datereg, o.visit_id, o.pid, o.messagecode ,o.response , o.messages  , o.users , o.d_update
		FROM log_fdh_opd_ck o
		WHERE o.d_update BETWEEN '$date1' AND '$date2'  
		AND o.messagecode = ''
		
		)AS data,
				(SELECT @n := 0) AS init
			  ORDER BY 
				No DESC, datereg DESC 
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
            FROM log_fdh_opd_ck v 
            WHERE (v.messages <> '' OR v.messages <> 'rejected')
            AND v.d_update BETWEEN CURDATE() AND NOW()";

        $data = \yii::$app->db14->createCommand($sqlCount1)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $amount = $data[$i]['amount'];
        }
        $sqlCamount = "SELECT COUNT(DISTINCT v.visit_id) as amountx
             FROM log_closevisits v 
             WHERE v.messagecode <> 'success'
             AND v.send_date BETWEEN CURDATE() AND NOW()";
        $data = \yii::$app->db143->createCommand($sqlCamount)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $amountx = $data[$i]['amountx'];
        }
        $total = "SELECT COUNT(DISTINCT v.visit_id) as total
            FROM log_closevisits v 
            WHERE v.messagecode = 'success'
            AND v.send_date BETWEEN '2023-10-01' AND NOW()
             ";

        $data = \yii::$app->db143->createCommand($total)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $total = $data[$i]['total'];
        }

        ########################################################################################################
        $sqlPass = "SELECT l.id, l.visit_id, l.pid , l.messagecode, l.response, l.users, l.d_update
        FROM log_fdh_opd_ck l 
        WHERE l.d_update BETWEEN CURDATE() AND NOW()
        AND l.messages <> '' 
        ORDER BY l.d_update DESC
        
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
        $sqlError = "select l.id, l.visit_id, l.pid , l.messagecode, l.response, l.users, l.send_date
        FROM log_closevisits l 
        WHERE l.send_date BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()
        AND l.messagecode <> 'success' AND l.users = 'fdh'
        ORDER BY l.send_date DESC
        
         ";
        $rawData = \Yii::$app->db143->createCommand($sqlError)->queryAll();

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
    try {
        // ดึง token ล่าสุดจากฐานข้อมูล
       // $sqlToken = "SELECT MAX(token) as token30 FROM fdh_token";
	   $sqltoken = "SELECT MAX(token) as token30 FROM fdh_token WHERE staff_id = 'pgans'";
        $data = \Yii::$app->db2->createCommand($sqlToken)->queryOne();

        if (empty($data) || empty($data['token30'])) {
            Yii::$app->session->setFlash('error', 'ไม่พบ token ในฐานข้อมูล.');
            return $this->redirect(['index']);
        }

        $tokenFdh = $data['token30'];
		
        $vn = Yii::$app->request->post('chkDel', []);

        $hasError = false; // ตรวจสอบว่ามีข้อผิดพลาดหรือไม่
        $errorMessages = []; // เก็บข้อความแจ้งเตือน

        foreach ($vn as $r) {
            $hn = substr($r, 10);
            $visitId = substr($r, 0, 10);
    // echo $visitId;
            if (empty($visitId)) {
                $errorMessages[] = "HN: $hn - Visit ID ไม่ถูกต้อง.";
                $hasError = true;
                continue;
            }

            // เตรียมข้อมูลสำหรับ API
            $postData = json_encode([
                "hcode" => "10953",
                "hn" => $hn,
                "seq" => $visitId,
                "transaction_uid" => ""
            ]);

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://fdh.moph.go.th/api/v1/ucs/track_trans',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $postData,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "Authorization: Bearer " . $tokenFdh
                ],
            ]);

            $response = curl_exec($curl);
            $curlError = curl_error($curl);
            curl_close($curl);
			
			// **แสดง response ที่ได้รับจาก API**
            echo "<pre>";
            print_r($response);
            echo "</pre>";
            exit(); // **หยุดการทำงานเพื่อดูผลลัพธ์ทันที**
			
            if ($response === false) {
                Yii::error("cURL Error: " . $curlError);
                $errorMessages[] = "HN: $hn - Failed to execute API request.";
                $hasError = true;
                continue;
            }

            $responseDecoded = json_decode($response, true);

            // 🛑 ตรวจสอบว่ามี error "not found"
            if (isset($responseDecoded['error']) && $responseDecoded['error'] === 'not found') {
                $errorMessages[] = "HN: $hn - API แจ้งเตือน: " . ($responseDecoded['message_th'] ?? 'ไม่พบข้อมูล.');
                $hasError = true;
                continue;
            }

            // ดึงข้อมูลจาก API
            $status = $responseDecoded['data'][0]['status'] ?? '';
            $statusMessageTh = $responseDecoded['data'][0]['status_message_th'] ?? '';

            // ตรวจสอบว่า visit_id มีอยู่ในฐานข้อมูลหรือไม่
           if (!empty($visitId)) {
    $existingVisit = \Yii::$app->db2->createCommand("SELECT COUNT(*) FROM log_fdh_opd_ck WHERE visit_id = :visit_id")
        ->bindValue(':visit_id', $visitId)
        ->queryScalar();
} else {
    $errorMessages[] = "HN: $hn - Visit ID ว่างเปล่า.";
    $hasError = true;
    continue;
}
            if ($existingVisit) {
                // อัปเดตข้อมูล
                $logSQLUpdate = "UPDATE log_fdh_opd_ck 
                                 SET pid = :pid,
                                     response = :response,
                                     messagecode = :status_message_th,
                                     messages = :status,
                                     d_update = NOW() 
                                 WHERE visit_id = :visit_id";

                \Yii::$app->db2->createCommand($logSQLUpdate)
                    ->bindValue(':pid', $hn)
                    ->bindValue(':response', $response)
                    ->bindValue(':status_message_th', $statusMessageTh)
                    ->bindValue(':status', $status)
                    ->bindValue(':visit_id', $visitId)
                    ->execute();
            } else {
                // แทรกข้อมูลใหม่
                $logSQLInsert = "INSERT INTO log_fdh_opd_ck (visit_id, pid, response, messagecode, messages, d_update)
                                 VALUES (:visit_id, :pid, :response, :status_message_th, :status, NOW())";

                \Yii::$app->db2->createCommand($logSQLInsert)
                    ->bindValue(':visit_id', $visitId)
                    ->bindValue(':pid', $hn)
                    ->bindValue(':response', $response)
                    ->bindValue(':status_message_th', $statusMessageTh)
                    ->bindValue(':status', $status)
                    ->execute();
            }
        }

        // แสดง error message ถ้ามีข้อผิดพลาด
        if ($hasError) {
            Yii::$app->session->setFlash('error', implode('<br>', $errorMessages));
        } else {
            Yii::$app->session->setFlash('success', 'ตรวจสอบสถานะสำเร็จ.');
        }
    } catch (\Exception $e) {
        Yii::error("Error in actionCheck: " . $e->getMessage());
        Yii::$app->session->setFlash('error', 'ไม่พบข้อมูลที่เคยส่ง: ' . $e->getMessage());
    }

    return $this->redirect(['index']);
}



    ##################################################################################

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Logfdhopd::findOne($id)) !== null) {
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
                return $this->redirect(['index']); // เปลี่ยนให้ตรงกับหน้าเว็บที่ต้องการ
            }
    
            try {
                Yii::$app->db2->createCommand()->insert('fdh_token', [
                    'token_dt' => date('Y-m-d H:i:s'),
                    'token' => $response,
                    'staff_id' => 'pgans',
                ])->execute();
    
                Yii::$app->session->setFlash('success', 'New token created successfully');
            } catch (Exception $e) {
                Yii::$app->session->setFlash('error', "Database Error: " . $e->getMessage());
            }
    
            return $this->redirect(['index']); // กลับไปยังหน้าเว็บที่ต้องการ
        }
}
