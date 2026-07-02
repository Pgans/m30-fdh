<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

/**
 * D569 Controller - รายงานผู้ป่วย Anemia, unspecified
 */
class D569Controller extends Controller
{
    /**
     * หน้าแสดงฟอร์มและรายงาน
     */
    public function actionIndex()
    {
        $startDate = Yii::$app->request->get('start_date', date('Y-m-01'));
        $endDate = Yii::$app->request->get('end_date', date('Y-m-d'));
        $icdCode = Yii::$app->request->get('icd_code', 'D569');
        
        $data = [];
        
        if (Yii::$app->request->get('search')) {
            $data = $this->getReportData($startDate, $endDate, $icdCode);
        }
        
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'icdCode' => $icdCode,
        ]);
    }
    
    /**
     * ดึงข้อมูลรายงาน
     */
    private function getReportData($startDate, $endDate, $icdCode)
    {
        $startDateTime = $startDate . ' 00:00';
        $endDateTime = $endDate . ' 23:59';
        
        // ใช้ db70
        $db = Yii::$app->db70;
        
        $sql = "SELECT 
            @n := @n + 1 AS 'No',
            data.*
        FROM 
        (SELECT 
            o.reg_datetime as 'regdate',
            o.visit_id,
            o.hn,
            ir.adm_id as an,
            o.weight,
            o.height,
            CONCAT(
                CASE 
                    WHEN p.PRENAME not in('') THEN TRIM(p.PRENAME)
                    WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW())< '20' AND p.sex='1' AND p.MARRIAGE = '4' THEN 'สามเณร'
                    WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '20' AND p.sex='1' AND p.MARRIAGE  = '4' THEN 'พระภิกษุ'
                    WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='1' THEN 'เด็กชาย'
                    WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='1' THEN 'นาย'
                    WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='2' THEN 'เด็กหญิง'
                    WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='2' AND p.MARRIAGE ='1' THEN 'นางสาว'
                    ELSE 'นาง' 
                END, TRIM(p.FNAME), '  ', TRIM(p.LNAME)
            ) as 'fullname',
            TIMESTAMPDIFF(year,p.BIRTHDATE,o.REG_DATETIME) as 'age',
            p.cid AS cid,
            GROUP_CONCAT(DISTINCT TRIM(icd1.ICD10_TM)) AS Diagx,
            GROUP_CONCAT(DISTINCT TRIM(icd.ICD10_TM) ORDER BY icd.ICD10_TM SEPARATOR ', ') AS Diag,      
            left(e.unit_name,10) 'unit_name', 
            f.INSCL_NAME as 'inscl',
            g.hospmain, 
            left(hpt.hosp_name,30) as hospname,
            log.messagecode,
            COALESCE((cg01 + cg02 + cg03 + cg04 + cg05 + cg06 + cg07 + cg08 + cg09 + cg10 + cg11 + cg12 + cg13 + cg14 + cg15 + cg16 + cg17 + cg18 + cg19), 00) AS amount,
            IFNULL(o.claim_code, '') AS claim_code,
            IFNULL(ak.claimcode, '') AS claimcode           
        FROM opd_visits o 
        INNER JOIN cid_hn c on o.HN= c.HN
        INNER JOIN population p on c.CID=p.CID AND left(p.cid,5) <> '00000'				
        LEFT JOIN opd_diagnosis d ON d.visit_id = o.visit_id AND d.is_cancel = 0 
        LEFT JOIN icd10new icd ON icd.icd10 = d.icd10 AND icd.icd10 <> ''
        LEFT JOIN opd_diagnosis d1 ON d1.visit_id = o.visit_id AND d.is_cancel = 0  AND d1.dxt_id = 1
        LEFT JOIN icd10new icd1 ON icd1.icd10 = d1.icd10 AND icd1.icd10 <> ''
        LEFT JOIN service_units e ON o.UNIT_REG=e.unit_id        
        LEFT JOIN main_inscls f ON o.INSCL = f.INSCL
        LEFT JOIN uc_inscl g ON c.CID= g.CID AND (g.date_abort > date(o.REG_DATETIME) OR DAY(g.DATE_ABORT)=0) and trim(g.hospmain) <>''
        LEFT JOIN hosp_sss h ON c.CID=h.CID AND (h.date_abort > date(o.REG_DATETIME) OR DAY(h.DATE_ABORT) = 0 ) and trim(h.HOSP_ID) <>''  
        LEFT JOIN authen_kiosk ak ON ak.visit_id = o.visit_id AND ak.cid = p.cid
        LEFT JOIN log_fdh_opd_ck as log ON log.visit_id = o.visit_id
        LEFT JOIN hospitals hpt on hpt.hosp_id=g.hospmain AND hpt.is_ubon = 0
        LEFT JOIN cost_visits cos ON cos.visit_id = o.visit_id AND cos.is_cancel = 0
        INNER JOIN ipd_reg ir ON ir.visit_id = o.visit_id AND ir.is_cancel = 0
        WHERE o.IS_CANCEL = 0
        AND o.REG_DATETIME BETWEEN :startDate AND :endDate
        #AND o.REG_DATETIME BETWEEN '2026-01-01 00:00' AND '2026-01-30 23:59'
        AND EXISTS (
					SELECT 1
					FROM opd_diagnosis dx
					INNER JOIN icd10new icdx ON icdx.icd10 = dx.icd10
					WHERE dx.visit_id = o.visit_id
						AND dx.is_cancel = 0
						AND icdx.icd10_tm BETWEEN 'D560' AND 'D569'
			)

				AND o.inscl IN ('03','04')
				AND g.hospmain = '10953'
        #AND ir.adm_id IN ('152371','152334')
        AND o.visit_id  in (SELECT ipd_reg.visit_id from ipd_reg WHERE ipd_reg.is_cancel=0)
        #AND o.visit_id not in (SELECT visit_id from mobile_visits)
        GROUP BY o.VISIT_ID
        ) AS data,
        (SELECT @n := 0) AS init
        ORDER BY No ASC";
        
        $command = $db->createCommand($sql);
        $command->bindValue(':startDate', $startDateTime);
        $command->bindValue(':endDate', $endDateTime);
       
        
        return $command->queryAll();
    }
    
    /**
     * ส่งออกเป็น Excel
     */
    public function actionExport()
    {
        $startDate = Yii::$app->request->get('start_date');
        $endDate = Yii::$app->request->get('end_date');
        #$icdCode = Yii::$app->request->get('icd_code', 'D569');
        
        $data = $this->getReportData($startDate, $endDate, $icdCode);
        
        // สร้างไฟล์ CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=report_' . date('YmdHis') . '.csv');
        
        $output = fopen('php://output', 'w');
        
        // เขียน BOM สำหรับ UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Header
        if (!empty($data)) {
            fputcsv($output, array_keys($data[0]));
        }
        
        // Data
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        
        fclose($output);
        exit;
    }
}