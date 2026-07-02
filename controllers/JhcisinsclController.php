<?php

namespace app\controllers;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\UploadedFile;
use yii\httpclient\Client;
use yii\helpers\BaseFileHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use app\models\Fdhjthaired;
use app\models\LogFdhOpd;
use yii\data\ArrayDataProvider;
use yii\db\Expression;

class JhcisinsclController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $data = Yii::$app->request->post();
        $date1 = isset($data['date1']) ? date('Y-m-d 00:01', strtotime($data['date1'])) : '';
        $date2 = isset($data['date2']) ? date('Y-m-d 23:59', strtotime($data['date2'])) : '';

        // print_r($date1);
        $sqlData = "SELECT DISTINCT @n :=@n +1 'No'
        ,date_format(f.date_serv,'%Y-%m-%d')as date_serv 
		,f.timestart,o.reg_datetime
        ,f.seq
        ,f.hn
		,f.cid
		#,f.gravida
		#,f.ga
        ,f.fullname as 'fullname'
        ,f.age_year as 'age'
        ,f.weight
		,f.height
        ,left(f.rightname,50) as rightname
        ,f.symptoms
        ,f.hospmain
        ,f.hospsub
		,log.messagecode
        #,v.lmp
		,p.claimcode_nhso	
          FROM (select @n := 0) m, fdh_thaired f
		  LEFT JOIN visit p ON p.visitno = f.seq 
		  LEFT JOIN mbase_data1.opd_visits o ON o.hn = f.hn AND f.date_serv = date(o.reg_datetime)  and o.is_cancel = 0
		  LEFT JOIN log_all.log_fdh_opd_ck as log ON log.visit_id = p.visitno
            WHERE f.date_serv BETWEEN '2024-10-01' AND NOW()
			#AND f.mapright = '0100'
            AND f.seq not in (SELECT seq FROM inscl_authens) 
			GROUP BY f.seq
            ORDER BY No DESC, f.hn
            ";
        $rawData = \Yii::$app->db14j->createCommand($sqlData)->queryAll();

        $sqlCount1 = "SELECT COUNT( v.visit_id) as amount
        FROM log_fdh_opd_ck v 
        WHERE  v.users = 'jthaired' AND v.messagecode <> ''
		#AND v.messages = 'received'
        AND v.d_update BETWEEN CURDATE() AND NOW()";

        $data = \yii::$app->db143->createCommand($sqlCount1)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $amount = $data[$i]['amount'];
        }

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);
        ########################################################################################################
        $sqlPass = "select l.id, l.visit_id, l.pid , l.messagecode, l.response, l.users, l.d_update
       FROM log_fdh_opd_ck l 
       WHERE l.d_update BETWEEN CURDATE() AND NOW()
       AND l.messagecode <> '' AND l.users = 'jthaired'
       ORDER BY l.d_update DESC
        
         ";
        $rawData = \Yii::$app->db143->createCommand($sqlPass)->queryAll();

        // สร้าง Flash Alert
        //Yii::$app->session->setFlash('success', 'รายการที่ไม่ผ่านตามเงื่อนไข');

        $passProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 300,
            ],
        ]);
        ########################################################################################################
        $sqlError = "select l.id, l.visit_id, l.pid , l.messagecode, l.response, l.users, l.d_update
        FROM log_fdh_opd l 
        WHERE l.d_update BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()
        AND l.messagecode <> 'success' AND l.users = 'jthaired'
        ORDER BY l.d_update DESC
        
         ";
        $rawData = \Yii::$app->db143->createCommand($sqlError)->queryAll();

        // สร้าง Flash Alert
        //Yii::$app->session->setFlash('success', 'รายการที่ไม่ผ่านตามเงื่อนไข');

        $errorProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 350,
            ],
        ]);
        return $this->render('index', [
            // 'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'passProvider' => $passProvider,
            'errorProvider' => $errorProvider,
            'amount' => $amount,

        ]);
    }
    public function actionCheck()
{
    $vn = Yii::$app->request->post('chkDel', []);
    $insertedCount = 0; // ตัวแปรเก็บจำนวน record ที่ insert สำเร็จ

    foreach ($vn as $r) {
        // ตัดค่า seq, cid, date_serv ตามที่กำหนด
        $seq = substr($r, 0, 6);
        $cid = substr($r, 6, 13);
        $date_serv = substr($r, 19, 10);

        // เรียก API
        $client = new \yii\httpclient\Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('https://authenucws.nhso.go.th/authencodestatus/api/check-authen-status')
            ->setData([
                'personalId' => $cid,
                'serviceDate' => $date_serv,
            ])
            ->addHeaders([
                'Authorization' => 'Bearer 7a4c8f6a-3578-4dd9-a0bf-54cece059a5e',
            ])
            ->send();

        if ($response->isOk) {
            $data = json_decode($response->content, true); // แปลง JSON response เป็น array

            // เตรียมข้อมูลสำหรับการ Insert ลงในตาราง inscl_authens
            $statusAuthen = isset($data['statusAuthen']) ? $data['statusAuthen'] : null;
            $statusMessage = isset($data['statusMessage']) ? $data['statusMessage'] : null;
            $firstName = isset($data['firstName']) ? $data['firstName'] : null;
            $lastName = isset($data['lastName']) ? $data['lastName'] : null;
            $sex = isset($data['sex']) ? $data['sex'] : null;
            $birthYear = isset($data['birthDate']['year']) ? $data['birthDate']['year'] : null;
            $birthMonth = isset($data['birthDate']['month']) ? $data['birthDate']['month'] : null;
            $nationCode = isset($data['nation']['code']) ? $data['nation']['code'] : null;
            $nationDescriptionTh = isset($data['nation']['descriptionTh']) ? $data['nation']['descriptionTh'] : null;
            $provinceId = isset($data['province']['id']) ? $data['province']['id'] : null;
            $provinceName = isset($data['province']['name']) ? $data['province']['name'] : null;
            $mainInsclId = isset($data['mainInscl']['id']) ? $data['mainInscl']['id'] : null;
            $mainInsclName = isset($data['mainInscl']['name']) ? $data['mainInscl']['name'] : null;
            $subInsclId = isset($data['subInscl']['id']) ? $data['subInscl']['id'] : null;
            $subInsclName = isset($data['subInscl']['name']) ? $data['subInscl']['name'] : null;

            // Insert ข้อมูลลงในตาราง inscl_authens
            $sqlInscl = "INSERT INTO inscl_authens (
                statusAuthen, statusMessage, firstName, lastName, sex, birthYear, birthMonth, nationCode,
                nationDescriptionTh, provinceId, provinceName, mainInsclId, mainInsclName, subInsclId, subInsclName, seq
            ) VALUES (
                :statusAuthen, :statusMessage, :firstName, :lastName, :sex, :birthYear, :birthMonth, :nationCode,
                :nationDescriptionTh, :provinceId, :provinceName, :mainInsclId, :mainInsclName, :subInsclId, :subInsclName, :seq
            )";
            Yii::$app->db14j->createCommand($sqlInscl, [
                ':statusAuthen' => $statusAuthen,
                ':statusMessage' => $statusMessage,
                ':firstName' => $firstName,
                ':lastName' => $lastName,
                ':sex' => $sex,
                ':birthYear' => $birthYear,
                ':birthMonth' => $birthMonth,
                ':nationCode' => $nationCode,
                ':nationDescriptionTh' => $nationDescriptionTh,
                ':provinceId' => $provinceId,
                ':provinceName' => $provinceName,
                ':mainInsclId' => $mainInsclId,
                ':mainInsclName' => $mainInsclName,
                ':subInsclId' => $subInsclId,
                ':subInsclName' => $subInsclName,
                ':seq' => $seq
            ])->execute();

            // เตรียมข้อมูล serviceHistories และ insert ลงใน service_histories
            if (isset($data['serviceHistories'])) {
                foreach ($data['serviceHistories'] as $history) {
                    $hospitalCode = isset($history['hospital']['hcode']) ? $history['hospital']['hcode'] : null;
                    $hospitalName = isset($history['hospital']['hname']) ? $history['hospital']['hname'] : null;
                    $serviceDateTime = isset($history['serviceDateTime']) ? $history['serviceDateTime'] : null;
                    $claimCode = isset($history['claimCode']) ? $history['claimCode'] : null;
                    $serviceCode = isset($history['service']['code']) ? $history['service']['code'] : null;
                    $serviceName = isset($history['service']['name']) ? $history['service']['name'] : null;

                    // Insert ข้อมูลลงในตาราง service_histories
                    $sqlServiceHistory = "INSERT INTO service_histories (
                        seq, hospitalCode, hospitalName, serviceDateTime, claimCode, serviceCode, serviceName
                    ) VALUES (
                        :seq, :hospitalCode, :hospitalName, :serviceDateTime, :claimCode, :serviceCode, :serviceName
                    )";
                    Yii::$app->db14j->createCommand($sqlServiceHistory, [
                        ':seq' => $seq,
                        ':hospitalCode' => $hospitalCode,
                        ':hospitalName' => $hospitalName,
                        ':serviceDateTime' => $serviceDateTime,
                        ':claimCode' => $claimCode,
                        ':serviceCode' => $serviceCode,
                        ':serviceName' => $serviceName
                    ])->execute();
                }
            }

            // นับจำนวนการ insert ที่สำเร็จ
            $insertedCount++;
        }
    }

    // ตั้งค่า Flash message
    Yii::$app->session->setFlash('success', "Insert สำเร็จจำนวน $insertedCount รายการ");

    // Redirect ไปที่หน้า index
    return $this->redirect(['index']);
}
}

