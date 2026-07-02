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
use app\models\Logclosevisit;



class ClosevisitController extends \yii\web\Controller
{
    public function actionIndexxxx()
    {
        // $_token = $model->token;


        return $this->render('indexxxx');
    }
    ################# ดึงข้อมูลให้ฟอร์มรายชื่อ ########################
    public function actionIndex()
    {
        $sqlvisits = "SELECT @n :=@n +1 'No'
        ,DATE_FORMAT(o.reg_datetime, '%Y-%m-%d %H:%i') as 'regdate'
        ,o.visit_id
        ,o.hn
       , CONCAT(
          CASE 
                 WHEN p.PRENAME not in('') THEN TRIM(p.PRENAME)
                       WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW())< '20' AND p.sex='1' AND p.MARRIAGE = '4'THEN 'สามเณร'
                       WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '20' AND p.sex='1' AND p.MARRIAGE  = '4'THEN 'พระภิกษุ'
                       WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='1' THEN 'เด็กชาย'
                       WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='1' THEN 'นาย'
                       WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='2' THEN 'เด็กหญิง'
                       WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='2' AND p.MARRIAGE ='1' THEN 'นางสาว'
                       ELSE 'นาง' 
                END ,TRIM(p.FNAME),'  ',TRIM(p.LNAME)) as 'fullname',
          TIMESTAMPDIFF(year,p.BIRTHDATE,o.REG_DATETIME) as 'age',
          p.cid,
          icd1.icd10_tm as Diag1,
          LEFT(GROUP_CONCAT(DISTINCT TRIM(icd.ICD10_TM)), 30) AS Diag
        ,left(e.unit_name,10) 'unit_name', 
        f.INSCL_NAME as 'inscl',
        cos.auto_id as 'invoice_number',
(cg01+cg02+cg03+ cg04+ cg05 + cg06+ cg07+ cg08+ cg08+ cg09+ cg10+ cg11+ cg12+ cg13+ cg14+ cg15+ cg16+cg17+ cg18+ cg19 ) as amount,
g.HOSPMAIN, g.HOSPSUB,
g.UC_REGISTER,g.UC_EXPIRE,
 h.HOSP_ID as 'sss',
h.SSS_DATE,h.EXP_DATE
        ,CASE
	    WHEN ak.claimcode = '' THEN 'ว่าง'
	    WHEN ak.claimcode <> '' THEN ak.claimcode
        END AS claimcode
          FROM (select @n := 0) m, opd_visits o 
          INNER JOIN cid_hn c on o.HN= c.HN
          INNER JOIN population p on c.CID=p.CID AND left(p.cid,5) <> '00000'
          INNER JOIN opd_diagnosis d ON d.visit_id = o.visit_id AND d.is_cancel = 0 
          LEFT JOIN icd10new icd ON icd.icd10 = d.icd10 AND icd.icd10 <> ''
          INNER JOIN opd_diagnosis d1 ON d1.visit_id = o.visit_id AND d1.is_cancel = 0 AND d1.dxt_id = 1
          LEFT JOIN icd10new icd1 ON icd1.icd10 = d1.icd10 AND icd1.icd10 <> ''
          LEFT JOIN ipd_reg ir ON ir.VISIT_ID = o.visit_id  AND ir.IS_CANCEL = 0
          INNER JOIN service_units e ON o.UNIT_REG=e.unit_id
          LEFT JOIN lab_requests lr ON lr.visit_id = o.visit_id AND lr.is_cancel = 0 
          LEFT JOIN lab_lists l ON l.lab_id = lr.lab_id 
LEFT JOIN main_inscls f ON o.INSCL = f.INSCL
LEFT JOIN uc_inscl g ON c.CID= g.CID AND (g.date_abort > date(o.REG_DATETIME) OR DAY(g.DATE_ABORT)=0)  and trim(g.hospmain) <>''
LEFT JOIN hosp_sss h ON c.CID=h.CID AND (h.date_abort > date(o.REG_DATETIME) OR DAY(h.DATE_ABORT) = 0 )and trim(h.HOSP_ID) <>''  
          LEFT JOIN authen_kiosk ak ON p.CID = ak.cid  AND date(o.REG_DATETIME)=date(ak.d_update)
LEFT JOIN cost_visits cos ON cos.visit_id = o.visit_id  AND cos.is_cancel = 0
          WHERE o.IS_CANCEL = 0
            AND o.REG_DATETIME BETWEEN DATE_SUB(NOW(), INTERVAL 5 DAY) AND NOW()
AND o.unit_reg <> '42' AND o.inscl in ('03','04')
AND LEFT(p.cid, 4) <> '0000'
AND (cg01+cg02+cg03+ cg04+ cg05 + cg06+ cg07+ cg08+ cg08+ cg09+ cg10+ cg11+ cg12+ cg13+ cg14+ cg15+ cg16+cg17+ cg18+ cg19 )<> ''
          AND o.visit_id not in (SELECT ipd_reg.VISIT_ID FROM ipd_reg WHERE ipd_reg.IS_CANCEL=0)
          AND o.visit_id  not in (SELECT vs.visit_id from log_all.log_closevisits vs )
          GROUP BY o.VISIT_ID ORDER BY NO DESC  ";
        $rawData = \yii::$app->db14->createCommand($sqlvisits)->queryAll();
        try {
            $rawData = \Yii::$app->db14->createCommand($sqlvisits)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $visitProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        #########################################################################
        $sqlCount1 = "SELECT COUNT(DISTINCT v.visit_id) as amount
            FROM log_closevisits v 
            WHERE v.messagecode = 'success'
            AND v.d_update BETWEEN CURDATE() AND NOW()";

        $data = \yii::$app->db143->createCommand($sqlCount1)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $amount = $data[$i]['amount'];
        }
        $sqlCamount = "SELECT COUNT(DISTINCT v.visit_id) as amountx
             FROM log_closevisits v 
             WHERE v.messagecode <> 'success'
             AND v.d_update BETWEEN CURDATE() AND NOW()";
        $data = \yii::$app->db143->createCommand($sqlCamount)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $amountx = $data[$i]['amountx'];
        }
        $total = "SELECT COUNT(DISTINCT v.visit_id) as total
            FROM log_closevisits v 
            WHERE v.messagecode = 'success'
            AND v.d_update BETWEEN '2023-10-01' AND NOW()
             ";

        $data = \yii::$app->db143->createCommand($total)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $total = $data[$i]['total'];
        }

        ########################################################################################################
        $sqlPass = "select l.id, l.visit_id, l.pid , l.messagecode, l.response, l.users, l.d_update
        FROM log_closevisits l 
        WHERE l.d_update BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()
        AND l.messagecode = 'success' AND l.users = 'fdh'
        ORDER BY l.d_update DESC
        
         ";
        $rawData = \Yii::$app->db143->createCommand($sqlPass)->queryAll();

        // สร้าง Flash Alert
        //Yii::$app->session->setFlash('success', 'รายการที่ไม่ผ่านตามเงื่อนไข');

        $passProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        ########################################################################################################
        $sqlError = "select l.id, l.visit_id, l.pid , l.messagecode, l.response, l.users, l.d_update
        FROM log_closevisits l 
        WHERE l.d_update BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()
        AND l.messagecode <> 'success' AND l.users = 'fdh'
        ORDER BY l.d_update DESC
        
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
        $sqltoken = "SELECT MAX(token) as token30 FROM fdh_token";

        $data = \yii::$app->db14->createCommand($sqltoken)->queryAll();
        for ($i = 0; $i < sizeof($data); $i++) {
            $token_fdh = $data[$i]['token30'];
        }
        ##################################################################     
        $vn =  Yii::$app->request->post('chkDel');

        foreach ($vn  as $r) {
            $hn = substr($r, 10);
            //echo $hn.'<br />';
            $visit_id = substr($r, 0, 10);

            ############ ดึงข้อมูลมาประกอบ Json ############################

            $strVn = "SELECT @n :=@n +1 as 'No',
            DATE_FORMAT(o.reg_datetime, '%Y-%m-%d %H:%i') as 'regdate',
            o.visit_id as 'vn',
            o.hn,
            '10953' as 'hcode',
            cos.auto_id as 'invoice_number',
            #right(o.visit_id,8) as 'invoice_number',
            c.cid,
            (cg01+cg02+cg03+ cg04+ cg05 + cg06+ cg07+ cg08+ cg08+ cg09+ cg10+ cg11+ cg12+ cg13+ cg14+ cg15+ cg16+cg17+ cg18+ cg19 ) as 'amount'
            FROM (select @n := 0) m, opd_visits o 
            INNER JOIN cid_hn c on o.HN= c.HN
            INNER JOIN population p on c.CID=p.CID AND left(p.cid,5) <> '00000'
            INNER JOIN opd_diagnosis d ON d.visit_id = o.visit_id AND d.is_cancel = 0 
            LEFT JOIN icd10new icd ON icd.icd10 = d.icd10 AND icd.icd10 <> ''
            LEFT JOIN ipd_reg ir ON ir.VISIT_ID = o.visit_id  AND ir.IS_CANCEL = 0
            INNER JOIN service_units e ON o.UNIT_REG=e.unit_id
            LEFT JOIN lab_requests lr ON lr.visit_id = o.visit_id AND lr.is_cancel = 0 
            LEFT JOIN lab_lists l ON l.lab_id = lr.lab_id 
            LEFT JOIN main_inscls f ON o.INSCL = f.INSCL
            LEFT JOIN uc_inscl g ON c.CID= g.CID AND (g.date_abort > date(o.REG_DATETIME) OR DAY(g.DATE_ABORT)=0)  and trim(g.hospmain) <>''
            LEFT JOIN hosp_sss h ON c.CID=h.CID AND (h.date_abort > date(o.REG_DATETIME) OR DAY(h.DATE_ABORT) = 0 )and trim(h.HOSP_ID) <>''  
            LEFT JOIN authen_kiosk ak ON p.CID = ak.cid  AND date(o.REG_DATETIME)=date(ak.d_update)
            LEFT JOIN cost_visits cos ON cos.visit_id = o.visit_id AND cos.is_cancel = 0
            WHERE o.IS_CANCEL = 0
            AND o.visit_id = '$visit_id'  ######o.visit_id = '$visit_id'  #'0003029834'
            AND o.unit_reg <> '42'
            AND (cg01+cg02+cg03+ cg04+ cg05 + cg06+ cg07+ cg08+ cg08+ cg09+ cg10+ cg11+ cg12+ cg13+ cg14+ cg15+ cg16+cg17+ cg18+ cg19 )<> ''
            AND o.visit_id not in (SELECT ipd_reg.VISIT_ID FROM ipd_reg WHERE ipd_reg.IS_CANCEL=0)
            #AND o.visit_id  not in (SELECT vs.visit_id from log_all.log_closevisits vs )
            GROUP BY o.VISIT_ID ORDER BY NO DESC";

            $closeData = \yii::$app->db14->createCommand($strVn)->queryAll();

            $resultArray = [];

            foreach ($closeData as $closeRow) {
                $resultArray = [
                    "service_date_time" => $closeRow['regdate'],
                    "cid" => $closeRow['cid'],
                    "hcode" => $closeRow['hcode'],
                    "total_amout" => $closeRow['amount'],
                    "invoice_number" => $closeRow['invoice_number'],
                    "vn" => $closeRow['vn']
                ];
            }

            $resultText = json_encode($resultArray, JSON_PRETTY_PRINT);

            echo $resultText;

            ########################################################################################
            $token = $token_fdh;

            # $url = "https://epidemcenter.moph.go.th/epidem/api/SendEPIDEM";
            $url = "https://uat-fdh.inet.co.th/api/v1/reservation";
            # $url = "https://epidemcenter.moph.go.th/epidem506";

            // $_token = $token30;
            $curl = curl_init($url);
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => 1,
                //SSL USE
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,

                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $resultText,
                CURLOPT_HTTPHEADER => array(
                    "Content-type: application/json",
                    "Authorization: Bearer " . $token
                ),
            ));
            $response = curl_exec($curl);
            $closevisit = json_decode($response, true);
            $err = curl_error($curl);
            //curl_close($curl);
            // echo $response;
            curl_close($curl);
            // $cid = $closevisit['results']['cid'];
            $message = $closevisit['message'];
            $message_th = $closevisit['message_th'];
            $status = $closevisit['status'];
            // echo $status;
            //echo $response;

            ############################INSERT TABLE Log_closevisits #############################

            if (strlen($response) > 0) {
                $strSQL = "REPLACE INTO log_closevisits (visit_id, pid,status, messagecode ,response , users,d_update) VALUES ('$visit_id','$hn',$status,'$message','$message_th','FDH',NOW())";
                //  $strSQL = "REPLACE INTO log_dt (visit_id, pid, cid,status, messagecode ,response , users,d_update) VALUES ('$visit_id','$hn','$pid',$status,'$message','$message_th' ,'dt',NOW())";
                Yii::$app->db143->createCommand($strSQL)->execute();
            }
        }
        return $this->redirect(['index']);
    }
    public function actionDelete($id)
{
    $model = $this->findModel($id);
    $model->delete();
    
    return $this->redirect(['index']);
}

protected function findModel($id)
{
    if (($model = Logclosevisit::findOne($id)) !== null) {
        return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
}
public function actionDeleteMultiple()
{
    // รับค่าจากฟอร์ม POST โดยใช้ 'selection' ซึ่งเป็นชื่อที่ `CheckboxColumn` สร้างขึ้น
    $selection = Yii::$app->request->post('selection', []); 

    if (!empty($selection)) {
        Logclosevisit::deleteAll(['id' => $selection]); // ลบรายการตาม ID ที่เลือก
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

}
