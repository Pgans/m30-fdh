<?php

namespace app\controllers;

use yii;
use yii\helpers\FileHelper;
use ZipArchive;
use yii\helpers\Json;
use yii\web\UploadedFile;
use yii\httpclient\Client;
use yii\httpclient\Request;
use yii\helpers\BaseFileHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use  app\models\Fdhlab1;
use app\models\LogFdhOpd;
use yii\data\ArrayDataProvider;
use yii\db\Expression;



class OpucController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $data = Yii::$app->request->post();
        $date1 = isset($data['date1']) ? date('Y-m-d 00:01', strtotime($data['date1'])) : '';
        $date2 = isset($data['date2']) ? date('Y-m-d 23:59', strtotime($data['date2'])) : '';
    echo $date1;
        // print_r($date1);
        $sqlData = "SELECT 
        @n := @n + 1 AS 'No',
        data.*
      FROM 
      (SELECT l.users as 'IPUC',COUNT(l.users) as 'amount', FORMAT(ROUND(SUM(k.ret_statement),2),2) as 'ชดเชยรวมเป็นเงิน',
format(ROUND(sum(CASE
 WHEN k.ret_statement-k.stm_claim>0 THEN k.ret_statement-k.stm_claim
ELSE ''
END),2),2) AS 'ลูกหนี้ค่าใช้จ่ายต่ำ',
format(ROUND(sum(CASE
 WHEN k.ret_statement-k.stm_claim<0 THEN k.ret_statement-k.stm_claim
ELSE ''
END),2),2) AS 'ลูกหนี้ค่าใช้จ่ายสูง'
FROM ipd_reg a LEFT JOIN opd_visits b on a.VISIT_ID=b.VISIT_ID AND a.IS_CANCEL =0 AND a.WARD_NO !=57
LEFT JOIN cid_hn c ON c.HN=b.HN 
LEFT JOIN population d on c.CID= d.CID
LEFT JOIN main_inscls e on e.INSCL=b.INSCL
LEFT JOIN staff f ON f.STAFF_ID=a.ADM_DR 
LEFT JOIN population g ON f.CID=g.CID
LEFT JOIN opd_visits h ON a.VISIT_ID= h.VISIT_ID AND h.INSCL=e.INSCL
LEFT JOIN opd_diagnosis i ON a.VISIT_ID=i.VISIT_ID AND i.IS_CANCEL = 0 AND i.DXT_ID= 1
LEFT JOIN icd10new j ON i.ICD10=j.ICD10
LEFT JOIN cost_visits k on k.visit_id=a.VISIT_ID AND k.is_cancel = 0
LEFT JOIN service_units s on s.UNIT_ID=a.WARD_NO
LEFT JOIN log_fdh_ipd_ck l ON a.VISIT_ID=l.visit_id 
WHERE a.IS_CANCEL = 0
AND a.DSC_DT BETWEEN '$date1' AND '$date2'
and b.INSCL in ('00','23','03','04')
AND b.IS_CANCEL = 0
GROUP BY l.users
UNION
SELECT 'ผลรวมทั้งหมด',COUNT(l.users),format(ROUND(SUM(k.ret_statement),2),2) as 'ชดเชยรวมเป็นเงิน',
format(round(sum(CASE
 WHEN k.ret_statement-k.stm_claim>0 THEN k.ret_statement-k.stm_claim
ELSE ''
END),2),2) AS 'ลูกหนี้ค่าใช้จ่ายตำ',
format(round(sum(CASE
 WHEN k.ret_statement-k.stm_claim<0 THEN k.ret_statement-k.stm_claim
ELSE ''
END),2),2) AS 'ลูกหนี้ค่าใช้จ่ายสูง'
FROM ipd_reg a LEFT JOIN opd_visits b on a.VISIT_ID=b.VISIT_ID AND a.IS_CANCEL =0 AND a.WARD_NO !=57
LEFT JOIN cid_hn c ON c.HN=b.HN 
LEFT JOIN population d on c.CID= d.CID
LEFT JOIN main_inscls e on e.INSCL=b.INSCL
LEFT JOIN staff f ON f.STAFF_ID=a.ADM_DR 
LEFT JOIN population g ON f.CID=g.CID
LEFT JOIN opd_visits h ON a.VISIT_ID= h.VISIT_ID AND h.INSCL=e.INSCL
LEFT JOIN opd_diagnosis i ON a.VISIT_ID=i.VISIT_ID AND i.IS_CANCEL = 0 AND i.DXT_ID= 1
LEFT JOIN icd10new j ON i.ICD10=j.ICD10
LEFT JOIN cost_visits k on k.visit_id=a.VISIT_ID AND k.is_cancel = 0
LEFT JOIN service_units s on s.UNIT_ID=a.WARD_NO
LEFT JOIN log_fdh_ipd_ck l ON a.VISIT_ID=l.visit_id 
WHERE a.IS_CANCEL = 0
AND a.DSC_DT  BETWEEN '$date1' AND '$date2' 
and b.INSCL in ('00','23','03','04')
AND b.IS_CANCEL = 0

UNION 
SELECT 'สรุปผล','+ or -',

format(round(CASE
 when sum(k.ret_statement)> format(abs(sum(k.stm_claim)),2)
 then sum(CASE
 WHEN k.ret_statement-k.stm_claim>0 THEN k.ret_statement-k.stm_claim
ELSE ''
END)+ sum(CASE
 WHEN k.ret_statement-k.stm_claim < 0 THEN k.ret_statement-k.stm_claim
ELSE ''
END)
ELSE '0'
END,2),2)
,'',''
FROM ipd_reg a LEFT JOIN opd_visits b on a.VISIT_ID=b.VISIT_ID AND a.IS_CANCEL =0 AND a.WARD_NO !=57
LEFT JOIN cid_hn c ON c.HN=b.HN 
LEFT JOIN population d on c.CID= d.CID
LEFT JOIN main_inscls e on e.INSCL=b.INSCL
LEFT JOIN staff f ON f.STAFF_ID=a.ADM_DR 
LEFT JOIN population g ON f.CID=g.CID
LEFT JOIN opd_visits h ON a.VISIT_ID= h.VISIT_ID AND h.INSCL=e.INSCL
LEFT JOIN opd_diagnosis i ON a.VISIT_ID=i.VISIT_ID AND i.IS_CANCEL = 0 AND i.DXT_ID= 1
LEFT JOIN icd10new j ON i.ICD10=j.ICD10
LEFT JOIN cost_visits k on k.visit_id=a.VISIT_ID AND k.is_cancel = 0
LEFT JOIN service_units s on s.UNIT_ID=a.WARD_NO
LEFT JOIN log_fdh_ipd_ck l ON a.VISIT_ID=l.visit_id 
WHERE a.IS_CANCEL = 0
AND a.DSC_DT BETWEEN '$date1' AND '$date2'
and b.INSCL in ('00','23','03','04')
AND b.IS_CANCEL = 0
                ) AS data,
                (SELECT @n := 0) AS init
       # ORDER BY  No DESC 
            ";
			 $rawData = \Yii::$app->db14->createCommand($sqlData)->queryAll();

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 400,
            ],
        ]);
###################################################################################################################

        $sqlData1 = "SELECT 
        @n := @n + 1 AS 'No',
        data.*
      FROM 
      (SELECT 
 b.hn, 
CONCAT(CASE 
WHEN d.PRENAME not in('') THEN TRIM(d.PRENAME) 
WHEN TIMESTAMPDIFF(year,d.BIRTHDATE,NOW())< '20' AND d.sex='1' AND d.MARRIAGE = '4'THEN 'สามเณร' 
WHEN TIMESTAMPDIFF(year,d.BIRTHDATE,NOW()) >= '20' AND d.sex='1' AND d.MARRIAGE = '4'THEN 'พระภิกษุ' 
WHEN TIMESTAMPDIFF(year,d.BIRTHDATE,NOW()) < '15' AND d.sex='1' THEN 'ด.ช.' 
WHEN TIMESTAMPDIFF(year,d.BIRTHDATE,NOW()) >= '15' AND d.sex='1' THEN 'นาย' 
WHEN TIMESTAMPDIFF(year,d.BIRTHDATE,NOW()) < '15' AND d.sex='2' THEN 'ด.ญ.' 
WHEN TIMESTAMPDIFF(year,d.BIRTHDATE,NOW()) >= '15' AND d.sex='2' AND g.MARRIAGE ='1' THEN 'น.ส.' 
ELSE 'นาง' 
END, trim(d.FNAME), '  ', Trim(d.LNAME)) as 'fullname'
,b.reg_datetime,
case 
 WHEN k.adjRw !='' THEN k.adjRw
else k.ADJRW
END as 'ADJRW',
e.INSCL_NAME,GROUP_CONCAT(trim(j.NICKNAME)) as 'วินิจฉัย',
s.UNIT_NAME ,(k.cg01+k.cg01_1+k.cg01_2+k.cg02+k.cg03+k.cg04+k.cg05+k.cg06+k.cg07+k.cg08+k.cg09+k.cg10+k.cg11+k.cg12+k.cg13+k.cg14+k.cg15+k.cg16+k.cg17+k.cg18+k.cg19) as 'แจ้งหนี้ Mbase' 
,k.stm_claim as 'ยอดเรียกเคลม E-Claim',k.ret_statement as 'ยอดชดเชย STM', 
CASE
 WHEN k.ret_statement-k.stm_claim>0 THEN k.ret_statement-k.stm_claim
ELSE ''
END AS 'ลูกหนี้ค่าใช้จ่ายตำ',
CASE
 WHEN k.ret_statement-k.stm_claim<0 THEN k.ret_statement-k.stm_claim
ELSE ''
END AS 'ลูกหนี้ค่าใช้จ่ายสูง',l.users,
k.rep_no,
ac.acc_name
FROM opd_visits b 
LEFT JOIN cid_hn c ON c.HN=b.HN 
LEFT JOIN population d on c.CID= d.CID
LEFT JOIN main_inscls e on e.INSCL=b.INSCL
LEFT JOIN population g ON c.CID=g.CID
LEFT JOIN opd_visits h ON b.VISIT_ID= h.VISIT_ID AND h.INSCL=e.INSCL
LEFT JOIN opd_diagnosis i ON b.VISIT_ID = i.VISIT_ID AND i.IS_CANCEL = 0 AND i.DXT_ID= 1
LEFT JOIN icd10new j ON i.ICD10=j.ICD10
LEFT JOIN cost_visits k on k.visit_id=b.VISIT_ID AND k.is_cancel = 0
LEFT JOIN service_units s on s.UNIT_ID=b.unit_reg
LEFT JOIN log_fdh_opd_ck l ON b.VISIT_ID=l.visit_id 
LEFT JOIN account2552 ac ON ac.acc_id = k.acc2552_id
LEFT JOIN staff f ON f.STAFF_ID=i.STAFF_ID 
WHERE b.IS_CANCEL = 0
AND b.REG_DATETIME BETWEEN '2025-01-05 00:01' AND '2025-01-05 23:59'
and b.INSCL in ('00','23','03','04')
AND b.visit_id NOT IN (SELECT visit_id FROM ipd_reg) 
AND b.IS_CANCEL = 0
GROUP BY b.visit_id
ORDER BY k.ret_statement
                ) AS data,
                (SELECT @n := 0) AS init
       # ORDER BY  No DESC 
            ";
			 $rawData1 = \Yii::$app->db14->createCommand($sqlData1)->queryAll();

        $data1Provider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData1,
            'pagination' => [
                'pageSize' => 400,
            ],
        ]);
        

    // ส่งค่ากลับไปยัง view
    return $this->render('index', [
        'dataProvider' => $dataProvider,
		'data1Provider' => $data1Provider,
        'date1' => $date1,
        'date2' => $date2,
    ]);
}

}