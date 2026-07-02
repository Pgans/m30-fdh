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


class Closevisit2Controller extends \yii\web\Controller
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
        FROM (
            SELECT 
                e.unit_name,
                b.hn,
                '' AS 'an',
                b.REG_DATETIME AS regdate,
                b.FINISH_DATETIME AS dsc_dt,
                CONCAT(TRIM(p.FNAME), ' ', TRIM(p.LNAME)) AS 'fullname',
                TIMESTAMPDIFF(YEAR, p.BIRTHDATE, b.REG_DATETIME) AS 'age',
                p.cid,
                ak.visit_id,
                b.visit_id AS visit,
                i.icd10_tm,
                p.telephone,
                p.rl_phone,
                p.mother,
                IFNULL(ak.claimtype, '') AS 'claimtype',
                IFNULL(ak.claimcode, '') AS 'claimKiosk',
				COALESCE(cv.claimcode, '') AS 'closevisit', 
                CASE
                    WHEN b.claim_code = '' THEN 'ว่าง'
                    ELSE b.claim_code
                END AS claim_code
            FROM opd_visits b 
            INNER JOIN cid_hn c ON b.HN = c.HN
            LEFT JOIN population p ON c.CID = p.CID
            LEFT JOIN service_units e ON b.UNIT_REG = e.unit_id
            LEFT JOIN authen_kiosk ak ON ak.visit_id = b.VISIT_ID AND DATE(ak.d_update) = DATE(b.reg_datetime)
			LEFT JOIN close_visits cv ON cv.visit_id = b.VISIT_ID 
            LEFT JOIN opd_diagnosis od ON od.visit_id = b.visit_id 
            LEFT JOIN icd10new i ON i.icd10 = od.ICD10
            WHERE b.IS_CANCEL = 0
			#AND p.cid = '1349900787680'
			#AND b.REG_DATETIME BETWEEN '2025-03-01 00:01' AND '2025-03-15 23:59'
            AND b.REG_DATETIME BETWEEN CURDATE() AND NOW()
			AND b.UNIT_REG in ('26')
            #AND b.UNIT_REG NOT IN ('42','51')
			AND p.NATN_ID = '99'
           # AND ISNULL(ak.claimcode)
            GROUP BY b.VISIT_ID 
            ORDER BY ak.claimcode
        ) AS data,
        (SELECT @n := 0) AS init
        ORDER BY No DESC
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
                'pageSize' => 1000,
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

    ################ ActionCheck #########################
	##################################################################################################################################
    // ฟังก์ชันที่ใช้ในการอัปเดตหรือแทรกข้อมูล

  public function updateOrInsertClaim($cid, $claimCode, $visit_id, $claimType, $claimDateTime, $telephone = '')
{
    // ตรวจสอบว่ามีข้อมูลอยู่หรือไม่
    $searchSQL = "SELECT COUNT(*) FROM close_visits WHERE claimcode = :claimcode";
    $existingCount = Yii::$app->db2->createCommand($searchSQL)
        ->bindValue(':claimcode', $claimCode)
        ->queryScalar();

    if ($existingCount == 0) {
        // เพิ่มข้อมูลใหม่
        $insertSQL = "
            INSERT INTO close_visits (cid, visit_id, claimtype, claimcode, claim_datetime, mobile, dep_name, d_update)
            VALUES (:cid, :visit_id, :claimtype, :claimcode, :claim_datetime, :mobile, 'm30_api', NOW())
        ";
        Yii::$app->db2->createCommand($insertSQL)
            ->bindValues([
                ':cid' => $cid,
                ':visit_id' => $visit_id,
                ':claimtype' => $claimType,
                ':claimcode' => $claimCode,
                ':claim_datetime' => $claimDateTime,
                ':mobile' => $telephone,
            ])
            ->execute();

        Yii::$app->session->setFlash('success', 'เพิ่มข้อมูลการปิดสิทธิ์สำเร็จ!');
    } else {
        // อัปเดต visit_id และ claim_datetime ในข้อมูลที่มีอยู่
        $updateSQL = "
            UPDATE close_visits
            SET visit_id = :visit_id, claim_datetime = :claim_datetime, d_update = NOW()
            WHERE claimcode = :claimcode
        ";
        Yii::$app->db2->createCommand($updateSQL)
            ->bindValues([
                ':visit_id' => $visit_id,
                ':claim_datetime' => $claimDateTime,
                ':claimcode' => $claimCode,
            ])
            ->execute();

        Yii::$app->session->setFlash('info', 'อัปเดตข้อมูลการปิดสิทธิ์สำเร็จ!');
    }
}


public function actionCheck()
{
    $cids = Yii::$app->request->post('chkDel', []);

    if (!empty($cids)) {
        foreach ($cids as $r) {
            $cid = substr($r, 0, 13);
            $visit_id = substr($r, 13, 10);

            echo "✅ CID: " . htmlspecialchars($cid) . "<br>";
            echo "✅ Visit ID: " . htmlspecialchars($visit_id) . "<br>";

            // ส่ง API Request
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://192.168.200.63:8189/api/nhso-service/latest-5-authen-code-all-hospital/' . $cid,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array(
                    'Cookie: TS01e80146=013bd252cb92f51720a1ea0f8eeca789f1467d7859c5d018175e4a4e5556b950058f436b39aa661efbf11e2f2a90391a334d4abf07'
                ),
            ));

            $response = curl_exec($curl);
            $authen = json_decode($response, true);
            curl_close($curl);

            // ตรวจสอบว่า Response มีค่า status เป็น 404 หรือไม่
            if (isset($authen['status']) && $authen['status'] == 404) {
                echo "❌ ไม่พบข้อมูลจาก API: " . htmlspecialchars($authen['message']);
                continue; // ข้ามไปยังการทำงานครั้งถัดไป
            }

            // ตรวจสอบว่า Response เป็น Object หรือ Array
            if (isset($authen['claimCode'])) {
                $authen = [$authen]; // ถ้าเป็น Object ให้แปลงเป็น Array
            }

            if (!$authen || !is_array($authen)) {
                echo "❌ API response ไม่ถูกต้องหรือเป็นค่าว่าง<br>";
                continue;
            }

            // แสดงจำนวนรายการทั้งหมด
            echo "จำนวนรายการทั้งหมด: " . count($authen) . "<br>";

            echo "<h3>📌 Response จาก API:</h3><pre>";
            print_r($authen);  // แสดงข้อมูลทั้งหมดที่ได้รับจาก API
            echo "</pre>";

            // จัดกลุ่ม claim ตามวันที่
            $claimsByDate = [];

            foreach ($authen as $item) {
                $claimDateTime = $item['claimDateTime'] ?? null;
                $claimCode = $item['claimCode'] ?? null;

                if ($claimDateTime && $claimCode) {
                    $claimDate = date('Y-m-d', strtotime($claimDateTime));

                    if (!isset($claimsByDate[$claimDate])) {
                        $claimsByDate[$claimDate] = [
                            'PP' => [],
                            'EP' => []
                        ];
                    }

                    // เช็กว่า claimCode เป็น PP หรือ EP
                    if (strpos($claimCode, 'PP') === 0) {
                        $claimsByDate[$claimDate]['PP'][] = $item;
                    } elseif (strpos($claimCode, 'EP') === 0) {
                        $claimsByDate[$claimDate]['EP'][] = $item;
                    }
                }
            }

            echo "<h3>📌 ข้อมูล Claims ที่จัดกลุ่มแล้ว:</h3><pre>";
            print_r($claimsByDate);
            echo "</pre>";

            // เลือก Claim ตามเงื่อนไข
            $selectedClaims = [];

            foreach ($claimsByDate as $date => $claims) {
                if (!empty($claims['EP'])) {
                    // ถ้ามี EP ให้เลือกทั้งหมด
                    $selectedClaims = array_merge($selectedClaims, $claims['EP']);
                }
            }

            // ตรวจสอบ Claim ที่เลือกมา
            if (!empty($selectedClaims)) {
                echo "<h3>✅ ClaimCode ที่เลือก:</h3>";
                foreach ($selectedClaims as $claim) {
                    echo "🟢 ClaimCode: " . htmlspecialchars($claim['claimCode']) . " (วันที่: " . htmlspecialchars($claim['claimDateTime']) . ")<br>";

                    // บันทึกข้อมูลลงฐานข้อมูล
                    $claimType = $claim['claimType'] ?? null;
                    $telephone = '';
                    $this->updateOrInsertClaim($cid, $claim['claimCode'], $visit_id, $claimType, $claim['claimDateTime'], $telephone);
                }
            } else {
                echo "<h3>❌ ไม่มี ClaimCode ที่ตรงตามเงื่อนไข</h3>";
            }
        }
    }
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
            //SSL USE
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode([
                'user' => 'saijai.10953',
                'password_hash' => '1435D328C7B3D1E5F22DE8D5BA784E7823F1D20A8268478BA0D2A5DEEE799827',
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

       // return $this->redirect(['index']);
    }
}
