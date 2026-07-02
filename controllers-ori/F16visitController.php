<?php

namespace app\controllers;

use yii;
use yii\helpers\FileHelper;
use ZipArchive;

class F16visitController extends \yii\web\Controller
{
    public function actionIndex()
    {
        ############### ข้อมูลแสดงรายการที่ ระบุตาม AN ########################################
        $sqlData = "SELECT DISTINCT  o.visit_id,o.hn , ip.ADM_ID as an,
         CONCAT(    CASE
     WHEN p.PRENAME not in('') THEN TRIM(p.PRENAME)
         #WHEN TIMESTAMPDIFF(year,pv.BIRTHDATE,NOW())< '20' AND pv.sex='1' AND pv.MARRIAGE = '4'THEN 'สามเณร'
         #WHEN TIMESTAMPDIFF(year,pv.BIRTHDATE,NOW()) >= '20' AND pv.sex='1' AND pv.MARRIAGE  = '4'THEN 'พระภิกษุ'
         WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='1' THEN 'ด.ช.'
         WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='1' THEN 'นาย'
         WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15'  AND p.sex='2' THEN 'ด.ญ.'
         WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='2' AND p.MARRIAGE ='1' THEN 'น.ส.'
         ELSE 'นาง' END ,'',TRIM(p.fname),'  ',p.lname) as fullname,
 TIMESTAMPDIFF(year,p.BIRTHDATE,o.REG_DATETIME) as age,
         s.unit_name,
         j.ICD10_TM as diag,
         ip.adm_dt as admit,
         ip.dsc_dt as dsc,
         CASE 
         WHEN o.INSCL in (03,04) AND g.HOSPMAIN ='10953' THEN CONCAT(f.INSCL_NAME,' -ในเขต') 
         WHEN o.INSCL in (03,04) AND g.HOSPMAIN !='10953' THEN CONCAT(f.INSCL_NAME,' -นอกเขต') 
         ELSE f.INSCL_NAME 
         END as 'inscl'

 FROM opd_visits o 
 LEFT JOIN cid_hn b on o.HN = b.HN
 LEFT JOIN population p on b.CID = p.CID
 LEFT JOIN opd_diagnosis i ON o.VISIT_ID = i.VISIT_ID AND i.IS_CANCEL = 0 AND i.DXT_ID = '1'
 LEFT JOIN icd10new j ON i.ICD10 = j.ICD10
 INNER JOIN ipd_reg ip on ip.VISIT_ID = o.VISIT_ID AND ip.IS_CANCEL = 0
 LEFT JOIN service_units s ON s.unit_id = ip.ward_no
         LEFT JOIN main_inscls f ON o.INSCL = f.INSCL
         LEFT JOIN uc_inscl g ON p.CID = g.CID AND (g.date_abort > date(o.REG_DATETIME) OR DAY(g.DATE_ABORT)= 0)  and trim(g.hospmain) <>''
         LEFT JOIN hosp_sss h ON p.CID = h.CID AND (h.date_abort > date(o.REG_DATETIME) OR DAY(h.DATE_ABORT) = 0 )and trim(h.HOSP_ID) <>'' 
 WHERE o.IS_CANCEL = 0
 AND ip.adm_id = '133069'
 GROUP BY ip.adm_id
# ORDER BY NO DESC
     ";
        $rawData = \Yii::$app->db14->createCommand($sqlData)->queryAll();


        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'sql' => $sqlData,

        ]);
    }
    public function actionData()
    {
        $data = Yii::$app->request->post();
        $an = isset($data['an']) ? $data['an'] : '';
        # $date2 = isset($data['date2']) ? $data['date2'] : '';
        // echo $date1;
        $db14 = \Yii::$app->db14;
        ################### ADP ##################################################################################
        $adp = "SELECT a.HN as 'HN', ip.adm_id as 'AN',
       DATE_FORMAT(a.reg_datetime,'%Y%m%d') as 'DATEOPD',
       trim(CASE
        WHEN v.type16 ='' THEN '2'
       ELSE v.type16 
       END) as 'TYPE',
       CASE
        when trim(d.uc_code) = '' then '8704' 
        WHEN v.chrgitem = '21' AND trim(d.uc_code) != '' THEN trim(d.uc_code)
       ELSE trim(v.code16)
       END as 'CODE',
       CASE
        when v.amount = 0 THEN 1
       ELSE CAST(REPLACE(v.amount, ' ', '') AS UNSIGNED) 
       end as 'QTY',
       CASE
        WHEN v.unit_price = '0' THEN v.invoice
       ELSE v.unit_price
       END as 'RATE'
       ,a.visit_id as 'SEQ',
       '' as 'CAGCODE','' as 'DOSE', '' as 'CA_TYPE', '' as 'SERIALNO', '' as 'TOTCOPAY','1' as 'USE_STATUS'
       , v.invoice as 'TOTAL','' as 'QTYDAY','' as 'TMLTCODE',
       '' as 'STATUS1','' as 'BI',
       concat(
       case 
        when ip.adm_id != '' then '1'
       ELSE '0'
       end ,i.dxg_id,'00') as 'CLINIC', '1' as 'ITEMSRC','' as 'PROVIDER', '' as 'GRAVIDA', '' as 'GA_WEEK','' as 'DCIP/E_SCREEN', '' as 'LMP'
       FROM opd_visits a LEFT JOIN visit_invoice v on v.visit_id=a.visit_id AND v.is_cancel = 0 
       LEFT JOIN cid_hn b on a.HN = b.HN
       LEFT JOIN population c on b.CID = c.CID
       LEFT JOIN opd_diagnosis i ON a.VISIT_ID=i.VISIT_ID AND i.IS_CANCEL = 0 AND i.DXT_ID = '1'
       LEFT JOIN icd10new j ON i.ICD10=j.ICD10
       LEFT JOIN ipd_reg ip on ip.VISIT_ID=a.VISIT_ID AND ip.IS_CANCEL = 0  
       LEFT JOIN drugs d on d.drug_id=v.drug_id
       WHERE a.IS_CANCEL = 0
       AND v.seq16 != ''
       AND (v.type16 !='' or v.chrgitem = '21')
       #AND ip.dsc_dt BETWEEN @date1 AND @date2
       AND ip.adm_id ='$an'
       #AND a.visit_id='0003067125'
       GROUP BY v.auto_id
    ";

        ################### CHA ##################################################################################
        $cha = "SELECT DISTINCT o.HN as 'HN',
                IFNULL(ip.adm_id,'') as 'AN',
                CASE 
                    WHEN ip.ADM_ID <>'' and date(ip.dsc_dt) = '0000-00-00' then trim(concat(left(ip.adm_dt,4),substr(ip.adm_dt,6,2),right(date(ip.adm_dt),2)))
                    WHEN ip.ADM_ID !='' then trim(concat(left(ip.dsc_dt,4),substr(ip.dsc_dt,6,2),right(date(ip.dsc_dt),2)))	
                    ELSE trim(concat(left(o.REG_DATETIME,4),substr(o.REG_DATETIME,6,2),right(date(o.REG_DATETIME),2)))
                end as 'DATE',
                v.chrgitem as 'CHRGITEM',
                v.invoice as 'AMOUNT',
                p.cid as 'PERSON_ID',
                o.visit_id as 'SEQ'
                FROM opd_visits o 
                LEFT JOIN cid_hn b on o.HN = b.HN
                LEFT JOIN population p on b.CID = p.CID
                LEFT JOIN opd_diagnosis i ON o.VISIT_ID=i.VISIT_ID AND i.IS_CANCEL = 0 AND i.DXT_ID = '1'
                LEFT JOIN icd10new j ON i.ICD10=j.ICD10
                LEFT JOIN visit_invoice v on v.visit_id=o.visit_id AND v.is_cancel = 0 and v.chrgitem !=''
                LEFT JOIN ipd_reg ip on ip.VISIT_ID=o.VISIT_ID AND ip.IS_CANCEL = 0 AND ip.dsc_dt 
                WHERE o.IS_CANCEL = 0
                AND ip.adm_id ='$an'
            ";

        ################### CHT ##################################################################################
        $cht = "SELECT DISTINCT o.HN as 'HN',
                ifnull(ip.ADM_ID,'') as 'AN',
                CASE 
                    WHEN ip.ADM_ID <>'' and date(ip.dsc_dt) = '0000-00-00' then trim(concat(left(ip.adm_dt,4),substr(ip.adm_dt,6,2),right(date(ip.adm_dt),2)))
                    WHEN ip.ADM_ID <>'' then trim(concat(left(ip.dsc_dt,4),substr(ip.dsc_dt,6,2),right(date(ip.dsc_dt),2)))	
                    ELSE DATE_FORMAT(o.reg_datetime,'%Y%m%d')
                END as 'DATE',
                ifnull(k.cg01+k.cg01_1+k.cg01_2+k.cg02+k.cg03+k.cg04+k.cg05+k.cg06+k.cg07+k.cg08+k.cg09+k.cg10+k.cg11+k.cg12+k.cg13+k.cg14+k.cg15+k.cg16+k.cg17+k.cg18+k.cg19,'') as 'TOTAL',
                CASE 
                    WHEN sum(r.PAID) <>'' then sum(r.PAID)
                ELSE '0'
                END as 'PAID', o.INSCL as 'PTTYPE', p.CID as 'PERSONID', o.VISIT_ID as 'SEQ'
                FROM opd_visits o
                LEFT JOIN cid_hn b on o.HN = b.HN
                LEFT JOIN population p on b.CID = p.CID
                LEFT JOIN main_inscls f ON o.INSCL=f.INSCL
                LEFT JOIN uc_inscl g ON p.CID= g.CID AND (g.date_abort > date(o.REG_DATETIME) OR DAY(g.DATE_ABORT)=0)  and trim(g.hospmain) <>''
                LEFT JOIN hosp_sss h ON p.CID=h.CID AND (h.date_abort > date(o.REG_DATETIME) OR DAY(h.DATE_ABORT) = 0 )and trim(h.HOSP_ID) <>'' 
                LEFT JOIN opd_diagnosis i ON o.VISIT_ID=i.VISIT_ID AND i.IS_CANCEL = 0 AND i.DXT_ID = '1'
                LEFT JOIN icd10new j ON i.ICD10=j.ICD10
                LEFT JOIN cost_visits k on k.visit_id=o.VISIT_ID
                LEFT JOIN receipts r on o.VISIT_ID=r.VISIT_ID AND r.IS_CANCEL <>1
                LEFT JOIN authen_kiosk ak ON p.cid=ak.cid AND DATE(ak.d_update)=date(o.REG_DATETIME)
                LEFT JOIN service_units s on s.UNIT_ID=o.UNIT_REG
                LEFT JOIN ipd_reg ip on ip.VISIT_ID=o.VISIT_ID AND ip.IS_CANCEL = 0
                LEFT JOIN service_units ss on ss.UNIT_ID=ip.WARD_NO
                LEFT JOIN mobile_visits m ON m.visit_id=o.visit_id
                WHERE o.IS_CANCEL = 0
                AND ip.adm_id ='$an'
                GROUP BY o.VISIT_ID,r.VISIT_ID
                ORDER BY ip.adm_id
            ";
        ################### DRU ##################################################################################
        $dru = " SELECT DISTINCT 
        gc.offid as 'HCODE' ,o.HN as 'HN',
        IFNULL(ip.ADM_ID, '' ) as 'AN',
        CONCAT(CASE 
            WHEN ip.adm_id <> '' THEN '1'
        ELSE '0'
        END ,s.f16, s.unit_id) as 'CLINIC',
        p.CID as 'PERSON_ID',
        DATE_FORMAT(o.REG_DATETIME,'%Y%m%d') as 'DATE_SERV',
        d.drug_id as 'DID',
        d.drug_name as 'DIDNAME',
        ps.rx_amount as 'Amount', v.unit_price as 'DRUGPRICE', d.price as 'DRUGCOST', d.didstd as 'DIDSTD',u.uunit_name as 'UNIT',
        CONCAT(REPLACE(ps.RX_DOSE,'.00',''),' ', u.UUNIT_NAME) as 'UNIT_PACK',
        o.visit_id as 'SEQ',
        u.uunit_name as 'DRUGTYPE', 
        '' as 'DRUGMARK', 
        '' as 'PA_NO', '' as 'TOTCOPAY', 
        CASE 
            WHEN v.order1 = '4' THEN '2'
            WHEN v.order1 = '3' THEN '1'
        ELSE ''
        END as 'USE_STATUE',v.invoice as 'TOTAL'
        FROM gcoffice gc, opd_visits o
        LEFT JOIN cid_hn b on o.HN = b.HN 
        LEFT JOIN population p on b.CID = p.CID
        LEFT JOIN opd_diagnosis i ON o.VISIT_ID=i.VISIT_ID AND i.IS_CANCEL = 0 AND i.DXT_ID = '1'
        LEFT JOIN prescriptions ps on o.visit_id = ps.visit_id AND ps.is_cancel=0
        LEFT JOIN drugs d on d.drug_id = ps.drug_id
        LEFT JOIN authen_kiosk ak ON p.cid=ak.cid AND DATE(ak.d_update)=date(o.REG_DATETIME)
        LEFT JOIN service_units s on s.UNIT_ID=o.UNIT_REG
        LEFT JOIN ipd_reg ip on ip.VISIT_ID=o.VISIT_ID AND ip.IS_CANCEL = 0 AND ip.dsc_dt AND ip.visit_id = '$visit'
        LEFT JOIN service_units ss on ss.UNIT_ID = ip.WARD_NO
        LEFT JOIN mobile_visits m ON m.visit_id=o.visit_id
        LEFT JOIN visit_invoice v on v.visit_id=o.visit_id and v.is_cancel = 0 and v.drug_id =ps.drug_id 
        LEFT JOIN usage_units u on u.uunit_id = d.uunit_id
        WHERE o.IS_CANCEL = 0
        AND ip.adm_id ='$an'
        AND v.drug_id <> ''
        #GROUP BY o.VISIT_ID
         ";
        ################### INS ##################################################################################
        $ins = "SELECT DISTINCT o.HN,
        CASE
            WHEN trim(f.NHSO_CODE) in ('UCS','WEL','M.8','EMP','UCH') THEN 'UCS'
            WHEN trim(f.NHSO_CODE) in ('SSS','VAR','SSI') THEN 'SSS'
        ELSE trim(f.NHSO_CODE)
        END as 'INSCL',
        CASE
            WHEN trim(f.nhso_code) in ('OFC','AC1','AC2','LGO','SSS','OTH','FRL') THEN ''
        ELSE g.UC_TYPE 
        END as 'SUBTYPE',
        p.CID,
        CASE 
            WHEN o.INSCL in ('18','19','00','23','36','30','22','12','35','05','01') THEN ''
            WHEN h.SSS_DATE ='0000-00-00' then ''
            WHEN h.SSS_DATE <> '' THEN  concat(left(h.SSS_DATE,4),SUBSTR(h.SSS_DATE,6,2),right(h.SSS_DATE,2))
            WHEN g.UC_REGISTER ='0000-00-00' then ''
            WHEN g.UC_REGISTER <>'' THEN concat(left(g.UC_REGISTER,4),SUBSTR(g.UC_REGISTER,6,2),right(g.UC_REGISTER,2))
        ELSE ''
        END as 'DATEIN',
        CASE 
            WHEN o.INSCL in ('18','19','00','23','36','30','22','12','35','05','01') THEN ''
            WHEN h.EXP_DATE ='0000-00-00' then ''
            WHEN h.EXP_DATE <> '' THEN concat(left(h.EXP_DATE,4),SUBSTR(h.EXP_DATE,6,2),right(h.EXP_DATE,2))
            WHEN g.UC_EXPIRE = '0000-00-00' then ''
            WHEN g.UC_EXPIRE <> '' THEN concat(left(g.UC_EXPIRE,4),SUBSTR(g.UC_EXPIRE,6,2),right(g.UC_EXPIRE,2))
        ELSE ''
        END as 'DATEEXP',
        CASE 
            WHEN o.INSCL in ('18','19','00','23','36','30','22','12','35','05','01') THEN ''
            WHEN h.HOSP_ID  <> '' THEN h.HOSP_ID
            WHEN g.HOSPMAIN <> '' THEN g.HOSPMAIN
        ELSE ''
        END as 'HOSPMAIN',
        CASE 
            WHEN o.INSCL not in ('03','04','33') THEN ''
            WHEN g.HOSPSUB !='' THEN g.HOSPSUB
        ELSE ''
        END as 'HOSPSUB',
        '' as 'GOVCODE',
        '' as 'GOVNAME',
        CASE 
        WHEN o.claim_code <> '' THEN trim(o.claim_code)
        WHEN o.claim_code = '' THEN trim(ak.claimcode)
        ELSE ''
        END as 'PERMITNO',
        '' as 'DOCNO', '' as 'OWNRPID', '' as 'OWNNAME',
        trim(ip.ADM_ID) as 'AN',
        o.VISIT_ID as 'SEQ',
        '' as 'SUBINSCL', '' as 'RELINCL',
        CASE
            WHEN h.HOSP_ID <> '' and o.INSCL in (08,31,09) THEN '2'
        ELSE ''
        END as 'HTYPE'
        FROM opd_visits o LEFT JOIN cid_hn b on o.HN = b.HN
        LEFT JOIN population p on b.CID = p.CID
        LEFT JOIN main_inscls f ON o.INSCL=f.INSCL
        LEFT JOIN uc_inscl g ON p.CID= g.CID AND (g.date_abort > date(o.REG_DATETIME) OR DAY(g.DATE_ABORT)=0)  and trim(g.hospmain) <>''
        LEFT JOIN hosp_sss h ON p.CID=h.CID AND (h.date_abort > date(o.REG_DATETIME) OR DAY(h.DATE_ABORT) = 0 )and trim(h.HOSP_ID) <>'' 
        LEFT JOIN opd_diagnosis i ON o.VISIT_ID=i.VISIT_ID AND i.IS_CANCEL = 0 AND i.DXT_ID = '1'
        LEFT JOIN icd10new j ON i.ICD10=j.ICD10
        LEFT JOIN cost_visits k on k.visit_id=o.VISIT_ID
        LEFT JOIN receipts r on o.VISIT_ID=r.VISIT_ID AND r.IS_CANCEL <>1
        LEFT JOIN authen_kiosk ak ON p.cid=ak.cid AND DATE(ak.d_update)=date(o.REG_DATETIME)
        LEFT JOIN service_units s on s.UNIT_ID=o.UNIT_REG
        LEFT JOIN ipd_reg ip on ip.VISIT_ID=o.VISIT_ID AND ip.IS_CANCEL = 0
        LEFT JOIN service_units ss on ss.UNIT_ID=ip.WARD_NO
        LEFT JOIN mobile_visits m ON m.visit_id=o.visit_id
        WHERE o.IS_CANCEL = 0
        AND ip.adm_id ='$an'
        GROUP BY o.VISIT_ID,r.VISIT_ID
        ORDER BY o.INSCL,g.HOSPMAIN
          ";
        ################### LABFU ################################################################################
        $labfu = " ";
        ################### AER ################################################################################
        $aer = "SELECT DISTINCT
        o.HN,
        IFNULL(ip.ADM_ID,'') as 'AN',
        DATE_FORMAT(o.reg_datetime,'%Y%m%d') as 'DATEOPD',
        CASE
            WHEN o.claim_code <> '' THEN o.claim_code
            WHEN o.claim_code = '' THEN ak.claimcode
        ELSE ''
        END as 'AUTHAE',
        DATE_FORMAT(ac.datetime_ae,'%Y%m%d') as 'AEDATE',
        TIME_FORMAT(ac.datetime_ae,'%H%i') as 'AETIME',
        CASE
            WHEN o.inscl= '19' THEN 'V'
        ELSE ''
        END as 'AETYPE',
        
        '' as 'REFER_NO', '' as 'REFMAINI','' as 'IREFTPE', '' as 'REFMAINO','' as 'OPEFTYPE','A' as 'UCAE','' as 'EMTYPE',
        o.VISIT_ID as 'SEQ','' as 'AESTATUS','' as 'DALERT', '' as 'TALERT'
        
        FROM opd_visits o LEFT JOIN cid_hn b on o.HN = b.HN
        LEFT JOIN population p on b.CID = p.CID
        LEFT JOIN main_inscls f ON o.INSCL=f.INSCL
        LEFT JOIN uc_inscl g ON p.CID= g.CID AND (g.date_abort > date(o.REG_DATETIME) OR DAY(g.DATE_ABORT)=0)  and trim(g.hospmain) <>''
        LEFT JOIN hosp_sss h ON p.CID=h.CID AND (h.date_abort > date(o.REG_DATETIME) OR DAY(h.DATE_ABORT) = 0 )and trim(h.HOSP_ID) <>'' 
        LEFT JOIN opd_diagnosis i ON o.VISIT_ID=i.VISIT_ID AND i.IS_CANCEL = 0 AND i.DXT_ID = '1'
        LEFT JOIN icd10new j ON i.ICD10=j.ICD10
        LEFT JOIN cost_visits k on k.visit_id=o.VISIT_ID
        LEFT JOIN receipts r on o.VISIT_ID=r.VISIT_ID AND r.IS_CANCEL <>1
        LEFT JOIN authen_kiosk ak ON p.cid=ak.cid AND DATE(ak.d_update)=date(o.REG_DATETIME)
        LEFT JOIN service_units s on s.UNIT_ID=o.UNIT_REG
        LEFT JOIN ipd_reg ip on ip.VISIT_ID=o.VISIT_ID AND ip.IS_CANCEL = 0
        LEFT JOIN service_units ss on ss.UNIT_ID=ip.WARD_NO
        LEFT JOIN mobile_visits m ON m.visit_id=o.visit_id
        inner JOIN accidents ac on ac.visit_id=o.visit_id 
        WHERE o.IS_CANCEL = 0
        AND ip.adm_id ='$an'
        GROUP BY o.VISIT_ID,r.VISIT_ID
        ORDER BY o.INSCL,g.HOSPMAIN
         ";
        ################### LVD ################################################################################
        $lvd = "SELECT '' as 'SEQLVD', '' as 'AN', '' as 'DATEOUT', '' as 'TIMEOUT','' as 'DATEIN', '' as 'TIMEIN', '' as 'QYTDAY' ";
        ################### IPD ################################################################################
        $ipd = "SELECT DISTINCT o.HN as 'HN', ip.ADM_ID as 'AN',
         DATE_FORMAT(ip.adm_dt,'%Y%m%d') as 'DATEADM', 
         TIME_FORMAT(ip.adm_dt,'%H%i') as 'TIMEADM',
         DATE_FORMAT(ip.dsc_dt,'%Y%m%d') as 'DATEDSC', 
         TIME_FORMAT(ip.dsc_dt,'%H%i') as 'TIMEDSC',
         ip.DSC_STATUS as 'DISCHS', ip.DSC_TYPE as 'DISCHT', ip.WARD_NO as 'WARDDSC', ip.WARD_NO as 'DEPT', o.WEIGHT as 'ADM_W', '1' as 'UUC', '1' as 'SVCTYPE'
         FROM opd_visits o LEFT JOIN cid_hn b on o.HN = b.HN
         LEFT JOIN population p on b.CID = p.CID
         INNER JOIN ipd_reg ip on ip.VISIT_ID = o.VISIT_ID AND ip.IS_CANCEL = 0 and ip.dsc_dt 
         LEFT JOIN service_units ss on ss.UNIT_ID = ip.WARD_NO
         LEFT JOIN mobile_visits m ON m.visit_id = o.visit_id
         WHERE o.IS_CANCEL = 0
         AND ip.adm_id ='$an'
         GROUP BY o.VISIT_ID
         ORDER BY o.INSCL
         ";
        ################### IDX ################################################################################
        $idx = "SELECT DISTINCT 
        ip.ADM_ID as 'AN',
        Trim(j.ICD10_tm) as 'DIAG',
        i.DXT_ID as 'DXTYPE',
        concat('ว.',trim(st.LICENCE)) as 'DRDX' 
        FROM opd_visits o
        LEFT JOIN cid_hn b on o.HN = b.HN
        LEFT JOIN population p on b.CID = p.CID
        LEFT JOIN main_inscls f ON o.INSCL=f.INSCL
        LEFT JOIN uc_inscl g ON p.CID= g.CID AND (g.date_abort > date(o.REG_DATETIME) OR DAY(g.DATE_ABORT)=0)  and trim(g.hospmain) <>''
        LEFT JOIN hosp_sss h ON p.CID = h.CID AND (h.date_abort > date(o.REG_DATETIME) OR DAY(h.DATE_ABORT) = 0 )and trim(h.HOSP_ID) <>'' 
        LEFT JOIN opd_diagnosis i ON o.VISIT_ID = i.VISIT_ID AND i.IS_CANCEL = 0 
        LEFT JOIN icd10new j ON i.ICD10=j.ICD10
        LEFT JOIN cost_visits k on k.visit_id=o.VISIT_ID
        LEFT JOIN receipts r on o.VISIT_ID=r.VISIT_ID AND r.IS_CANCEL <> 1
        LEFT JOIN authen_kiosk ak ON p.cid=ak.cid AND DATE(ak.d_update)=date(o.REG_DATETIME)
        LEFT JOIN service_units s on s.UNIT_ID=o.UNIT_REG
        INNER JOIN ipd_reg ip on ip.VISIT_ID=o.VISIT_ID AND ip.IS_CANCEL = 0 AND ip.visit_id = '$visit'
        LEFT JOIN service_units ss on ss.UNIT_ID=ip.WARD_NO
        LEFT JOIN mobile_visits m ON m.visit_id=o.visit_id
        LEFT JOIN staff st on st.staff_id=ip.ADM_DR
        WHERE o.IS_CANCEL = 0
        AND ip.adm_id ='$an'
        ORDER BY ip.ADM_ID
         ";
        ################### IOP ################################################################################
        $iop = "SELECT DISTINCT
        ip.adm_id as 'AN',
        REPLACE(trim(icd.code), '\"', '') as 'OPER',
        '1' as 'OPTYPE',
        right(trim(st.licence),6) as 'DROPID', # 6 หลัก
        DATE_FORMAT(op.op_dt,'%Y%m%d') as 'DATEIN',
        TIME_FORMAT(op.op_dt,'%H%i') as 'TIMEIN',
        CASE
            WHEN op.op_end <> '0000-00-00 00:00:00' THEN DATE_FORMAT(op.op_end,'%Y%m%d')
        ELSE DATE_FORMAT(op.op_dt,'%Y%m%d') 
        end as 'DATEOUT',
        case 
            when op.op_end <> '0000-00-00 00:00:00' THEN TIME_FORMAT(op.op_end,'%H%i')
        ELSE TIME_FORMAT(op.op_dt,'%H%i')
        end as 'TIMEOUT'
        FROM opd_visits o LEFT JOIN cid_hn b on o.HN = b.HN
        LEFT JOIN population p on b.CID = p.CID
        LEFT JOIN opd_diagnosis i ON o.VISIT_ID=i.VISIT_ID AND i.IS_CANCEL = 0 AND i.dxt_id = 1
        INNER JOIN opd_operations op ON o.VISIT_ID=op.VISIT_ID AND op.IS_CANCEL = 0 
        LEFT JOIN icd9cm icd ON op.icd9=icd.icd9
        LEFT JOIN icd10new j ON i.ICD10=j.ICD10
        LEFT JOIN service_units s on s.UNIT_ID=o.UNIT_REG
        inner JOIN ipd_reg ip on ip.VISIT_ID=o.VISIT_ID AND ip.IS_CANCEL = 0 AND ip.visit_id = '$visit'
        LEFT JOIN staff st on st.staff_id=op.staff_id
        WHERE o.IS_CANCEL = 0
        AND ip.adm_id ='$an'
        AND icd.code <> ''
        AND st.licence <> ''
        AND icd.code NOT IN ('test1','XXXXX')
        GROUP BY op.visit_id,op.icd9
        ORDER BY o.visit_id
        ";
        ################### ODX ##################################################################################
        $odx = "SELECT DISTINCT o.hn as 'HN',
        DATE_FORMAT(o.reg_datetime,'%Y%m%d') as 'DATEDX',
        CONCAT(CASE 
            WHEN ip.adm_id <> '' THEN '1'
        ELSE '0'
        END ,s.f16,s.unit_id) as 'CLINIC',
        trim(j.ICD10_tm) as 'DIAG',
        i.DXT_ID as 'DXTYPE',trim(st.licence) as 'DRDX',
        p.cid as 'PERSON_ID',o.visit_id as 'SEQ'
        FROM opd_visits o 
        LEFT JOIN cid_hn b on o.HN = b.HN
        LEFT JOIN population p on b.CID = p.CID
        LEFT JOIN opd_diagnosis i ON o.VISIT_ID=i.VISIT_ID AND i.IS_CANCEL = 0 
        LEFT JOIN icd10new j ON i.ICD10=j.ICD10
        LEFT JOIN service_units s on s.UNIT_ID=o.UNIT_REG
        left JOIN ipd_reg ip on ip.VISIT_ID=o.VISIT_ID AND ip.IS_CANCEL = 0
        LEFT JOIN staff st on st.staff_id=i.staff_id
        WHERE o.IS_CANCEL = 0
         AND ip.adm_id ='$an'
        ORDER BY o.visit_id
          ";
        ################### OOP ##################################################################################
        $oop = "SELECT DISTINCT o.hn as 'HN',
        DATE_FORMAT(o.REG_DATETIME,'%Y%m%d') as 'DATEDX',
        concat(case 
            when ip.adm_id <> '' then '1'
        ELSE '0'
        END , s.f16, s.unit_id) as 'CLINIC',
        trim(icd.code) as 'OPER',
        trim(st.licence) as 'DROPID',
        p.cid as 'PERSON_ID',
        o.visit_id as 'SEQ',
        icd.cost as 'SERVPRICE'
        FROM opd_visits o LEFT JOIN cid_hn b on o.HN = b.HN
        LEFT JOIN population p on b.CID = p.CID
        LEFT JOIN opd_diagnosis i ON o.VISIT_ID=i.VISIT_ID AND i.IS_CANCEL = 0 AND i.dxt_id = 1
        INNER JOIN opd_operations op ON o.VISIT_ID = op.VISIT_ID AND op.IS_CANCEL = 0 
        LEFT JOIN icd9cm icd ON op.icd9 = icd.icd9
        LEFT JOIN icd10new j ON i.ICD10=j.ICD10
        LEFT JOIN service_units s on s.UNIT_ID = o.UNIT_REG
        left JOIN ipd_reg ip on ip.VISIT_ID = o.VISIT_ID AND ip.IS_CANCEL = 0
        LEFT JOIN staff st on st.staff_id=op.staff_id
        WHERE o.IS_CANCEL = 0
        AND ip.adm_id ='$an'
        AND icd.code <> ''
        AND st.licence <> ''
        AND icd.code NOT IN ('test1','XXXXX')
        GROUP BY op.visit_id,op.icd9
        ORDER BY o.visit_id
         ";
        ################### OPD ##################################################################################       
        $opd = "SELECT DISTINCT o.HN as 'HN',
        CONCAT(CASE 
            WHEN ip.adm_id <> '' THEN '1'
        ELSE '0'
        END ,s.f16,o.unit_reg) as CLINIC,
        DATE_FORMAT(o.REG_DATETIME,'%Y%m%d') as 'DATEOPD',
        TIME_FORMAT(o.REG_DATETIME,'%H%S') as 'TIMEOPD',
        o.visit_id as 'SEQ',
        '1' as 'UUC'
        FROM opd_visits o 
        LEFT JOIN cid_hn b on o.HN = b.HN
        LEFT JOIN population p on b.CID = p.CID
        LEFT JOIN opd_diagnosis i ON o.VISIT_ID = i.VISIT_ID AND i.IS_CANCEL = 0 AND i.DXT_ID = '1'
        LEFT JOIN icd10new j ON i.ICD10 = j.ICD10
        LEFT JOIN ipd_reg ip on ip.VISIT_ID = o.VISIT_ID AND ip.IS_CANCEL = 0
        LEFT JOIN service_units s ON s.unit_id = o.unit_reg
        WHERE o.IS_CANCEL = 0
        AND ip.adm_id ='$an'
        GROUP BY o.VISIT_ID
        ORDER BY o.INSCL,p.auto_uc
          ";
        ################### ORF ##################################################################################       
        $orf = "SELECT DISTINCT
        o.HN as 'HN',
        DATE_FORMAT(o.REG_DATETIME,'%Y%m%d') as 'DATEOPD',
       CONCAT(CASE
           WHEN ip.adm_id != '' THEN '1'
       ELSE '0'
       end ,s.f16,s.unit_id) as 'CLINIC',
       r.hosp_id as 'REFER',r.rf_type as 'REFERTYPE',
       o.visit_id as 'SEQ'
       ,DATE_FORMAT(r.RF_DT,'%Y%m%d') as 'REFERDATE'
       FROM opd_visits o 
       LEFT JOIN cid_hn b on o.HN = b.HN
       LEFT JOIN population p on b.CID = p.CID
       LEFT JOIN opd_diagnosis i ON o.VISIT_ID=i.VISIT_ID AND i.IS_CANCEL = 0 AND i.DXT_ID = '1'
       LEFT JOIN icd10new j ON i.ICD10=j.ICD10
       LEFT JOIN ipd_reg ip on ip.VISIT_ID=o.VISIT_ID AND ip.IS_CANCEL = 0
       INNER JOIN refers r on r.visit_id=o.visit_id AND r.is_cancel=0
       LEFT JOIN service_units s ON s.unit_id = o.unit_reg
       WHERE o.IS_CANCEL = 0
       AND ip.adm_id ='$an'
       GROUP BY r.visit_id, r.rf_type
       ORDER BY o.hn
         ";
        ################### IRF ##################################################################################       
        $irf = " SELECT DISTINCT 
        ip.adm_id as 'AN',
        r.hosp_id as 'REFER',
        r.rf_type as 'REFERTYPE'
        FROM opd_visits o LEFT JOIN cid_hn b on o.HN = b.HN
        LEFT JOIN population p on b.CID = p.CID
        LEFT JOIN opd_diagnosis i ON o.VISIT_ID=i.VISIT_ID AND i.IS_CANCEL = 0 AND i.DXT_ID = '1'
        LEFT JOIN icd10new j ON i.ICD10=j.ICD10
        inner JOIN ipd_reg ip on ip.VISIT_ID=o.VISIT_ID AND ip.IS_CANCEL = 0 AND ip.visit_id = '$visit'
        INNER JOIN refers r on r.visit_id=o.visit_id AND r.is_cancel=0
        WHERE o.IS_CANCEL = 0
        AND o.visit_id = '$visit'
        GROUP BY r.visit_id, r.rf_type
        ORDER BY o.hn
         ";
        #################### PAT ##################################################################################
        $pat = "SELECT DISTINCT 
        gc.offid as 'HCODE',
        o.HN as 'HN',
        left(p.TOWN_ID,2) as 'CHANGWAT',
        SUBSTR(p.TOWN_ID,3,2) as 'AMPHUR',
        DATE_FORMAT(p.BIRTHDATE,'%Y%m%d') as 'DOB',
        p.SEX as 'SEX',
        case 
            when p.MARRIAGE ='' then '1'
        ELSE p.MARRIAGE
        END as 'MARRIAGE', 
        case 
            when p.OC_ID ='' then '502' 
        else p.OC_ID
        END as 'OCCUPA',
        p.NATN_ID as  'NATION', p.cid as 'PERSONID', 
        CONCAT(TRIM(p.FNAME), '',TRIM(p.LNAME),',',
        CASE 
            WHEN p.PRENAME not in('') THEN TRIM(p.PRENAME) 
            WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW())< '20' AND p.sex='1' AND p.MARRIAGE = '4'THEN 'สามเณร' 
            WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '20' AND p.sex='1' AND p.MARRIAGE = '4'THEN 'พระภิกษุ' 
            WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15' AND p.sex='1' THEN 'ด.ช.' 
            WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='1' THEN 'นาย' 
            WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15' AND p.sex='2' THEN 'ด.ญ.' 
            WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='2' AND p.MARRIAGE ='1' THEN 'น.ส.' 
        ELSE 'นาง' 
        END ) as 'NAMEPAT',
        CASE 
            WHEN p.PRENAME not in('') THEN TRIM(p.PRENAME) 
            WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW())< '20' AND p.sex='1' AND p.MARRIAGE = '4'THEN 'สามเณร' 
            WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '20' AND p.sex='1' AND p.MARRIAGE = '4'THEN 'พระภิกษุ' 
            WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15' AND p.sex='1' THEN 'ด.ช.' 
            WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='1' THEN 'นาย' 
            WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) < '15' AND p.sex='2' THEN 'ด.ญ.' 
            WHEN TIMESTAMPDIFF(year,p.BIRTHDATE,NOW()) >= '15' AND p.sex='2' AND p.MARRIAGE ='1' THEN 'น.ส.' 
        ELSE 'นาง' 
        END as 'TITLE',TRIM(p.FNAME) as 'FNAME',
        TRIM(p.LNAME) as 'LNAME',
        '1' as 'IDTYPE'
        FROM gcoffice gc , opd_visits o LEFT JOIN cid_hn b on o.HN = b.HN
        LEFT JOIN population p on b.CID = p.CID
        LEFT JOIN main_inscls f ON o.INSCL = f.INSCL
        LEFT JOIN uc_inscl g ON p.CID= g.CID AND (g.date_abort > date(o.REG_DATETIME) OR DAY(g.DATE_ABORT)=0)  and trim(g.hospmain) <>''
        LEFT JOIN hosp_sss h ON p.CID = h.CID AND (h.date_abort > date(o.REG_DATETIME) OR DAY(h.DATE_ABORT) = 0 )and trim(h.HOSP_ID) <>'' 
        LEFT JOIN opd_diagnosis i ON o.VISIT_ID = i.VISIT_ID AND i.IS_CANCEL = 0 AND i.DXT_ID = '1'
        LEFT JOIN icd10new j ON i.ICD10 = j.ICD10
        LEFT JOIN cost_visits k on k.visit_id = o.VISIT_ID
        LEFT JOIN receipts r on o.VISIT_ID = r.VISIT_ID AND r.IS_CANCEL !=1
        LEFT JOIN authen_kiosk ak ON p.cid = ak.cid AND DATE(ak.d_update) = date(o.REG_DATETIME)
        LEFT JOIN service_units s on s.UNIT_ID = o.UNIT_REG
        LEFT JOIN ipd_reg ip on ip.VISIT_ID = o.VISIT_ID AND ip.IS_CANCEL = 0
        LEFT JOIN service_units ss on ss.UNIT_ID = ip.WARD_NO
        LEFT JOIN mobile_visits m ON m.visit_id = o.visit_id
        WHERE o.IS_CANCEL = 0
        AND ip.adm_id ='$an'
        GROUP BY p.CID
        ORDER BY o.INSCL,g.HOSPMAIN ";


        $results2 = $db14->createCommand($cha)->queryAll();
        $results3 = $db14->createCommand($cht)->queryAll();
        $results4 =  $db14->createCommand($dru)->queryAll();
        $results5 =  $db14->createCommand($ins)->queryAll();
        //$results6 =  $db14->createCommand($labfu)->queryAll();
        //$results7 =  $db14->createCommand($odx)->queryAll();
        //$results8 =  $db14->createCommand($oop)->queryAll();
        //$results9 =  $db14->createCommand($opd)->queryAll();
        $results10 = $db14->createCommand($orf)->queryAll();
        $results11 = $db14->createCommand($pat)->queryAll();
        $results12 = $db14->createCommand($irf)->queryAll();
        $results13 = $db14->createCommand($iop)->queryAll();
        $results14 = $db14->createCommand($idx)->queryAll();
        $results15 = $db14->createCommand($ipd)->queryAll();
        $results16 = $db14->createCommand($aer)->queryAll();
       // $results17 = $db14->createCommand($lvd)->queryAll();
        $results18 = $db14->createCommand($adp)->queryAll();


        $baseDirectory = 'uploads/F16_claim/';
        $mode = 0777; // Set the desired mode (permissions)

        // Export the results of the CHA query to a text file
        $chaFile = $baseDirectory . 'CHA.txt';
        $this->exportToTextFile($results2, $chaFile, ['HN', 'AN', 'DATE', 'CHRGITEM', 'AMOUNT', 'PERSON_ID', 'SEQ']);

        // Check if the CHA file was created successfully
        if (file_exists($chaFile)) {
            Yii::$app->session->setFlash('success', 'CHA.txt created successfully');
        } else {
            Yii::$app->session->setFlash('error', 'Error creating CHA.txt');
        }

        // Export the results of the CHT query to a text file
        $chtFile = $baseDirectory . 'CHT.txt';
        $this->exportToTextFile(
            $results3,
            $chtFile,
            ['HN', 'AN', 'DATE', 'TOTAL', 'PAID', 'PTTYPE', 'PERSON_ID', 'SEQ', 'OPD_MEMO', 'INVOICE_NO', 'INVOICE_LT']
        );

        $this->exportToTextFile(
            $results4,
            $baseDirectory . 'DRU.txt',
            ['HCODE', 'HN', 'AN', 'CLINIC', 'PERSON_ID', 'DATE_SERV', 'DID', 'DIDNAME', 'AMOUNT', 'DRUGPRICE', 'DRUGCOST', 'DIDSTD', 'UNIT', 'UNIT_PACK', 'SEQ', 'DRUGREMARK', 'PA_NO', 'TOTCOPAY', 'USE_STATUS', 'TOTAL', 'SIGCODE', 'SIGTEXT', 'PROVIDER']
        );

        $this->exportToTextFile(
            $results5,
            $baseDirectory . 'INS.txt',
            ['HN', 'INSCL', 'SUBTYPE', 'CID', 'HCODE', 'DATEEXP', 'HOSPMAIN', 'HOSPSUB', 'GOVCODE', 'GOVNAME', 'PERMITNO', 'DOCNO', 'OWNRPID', 'OWNNAME', 'AN', 'SEQ', 'SUBINSCL', 'RELINSCL', 'HTYPE']
        );

        // $this->exportToTextFile($results6, $baseDirectory . 'LABFU.txt',
        //['HCODE', 'HN', 'PERSON_ID', 'DATESERV', 'SEQ', 'LABTEST', 'LABRESULT']); 

        // $this->exportToTextFile(
        //     $results7,
        //     $baseDirectory . 'ODX.txt',
        //     ['HN', 'DATEDX', 'CLINIC', 'DIAG', 'DXTYPE', 'DRDX', 'PERSON_ID', 'SEQ']
        // );

        // $this->exportToTextFile(
        //     $results8,
        //     $baseDirectory . 'OOP.txt',
        //     ['HN', 'DATEOPD', 'CLINIC', 'PER', 'DROPID', 'PERSON_ID', 'SEQ']
        // );

        // $this->exportToTextFile(
        //     $results9,
        //     $baseDirectory . 'OPD.txt',
        //     ['HN', 'CLINIC', 'DATEOPD', 'TIMEOPD', 'SEQ', 'UUC', 'DETAL', 'BTEMP', 'SBP', 'DBP', 'PR', 'RR', 'OPTYPE', 'TYPEIN', 'TYPEOUT']
        // );

        $this->exportToTextFile(
            $results10,
            $baseDirectory . 'ORF.txt',
            ['HN', 'DATEOPD', 'CLINIC', 'REFER', 'REFERTYPE', 'SEQ', 'REFERDATE']
        );

        $this->exportToTextFile(
            $results11,
            $baseDirectory . 'PAT.txt',
            ['HCODE', 'HN', 'CHANGWAT', 'AMPHUR', 'DOB', 'SEX', 'MARRIAGE', 'OCCUPA', 'NATION', 'PERSON_ID', 'NAMEPAT', 'TITLE', 'FNAME', 'LNAME', 'IDTYPE']
        );

        $this->exportToTextFile(
            $results12,
            $baseDirectory . 'IRF.txt',
            ['AN', 'REFER', 'REFERTYPE']
        );

        $this->exportToTextFile(
            $results13,
            $baseDirectory . 'IOP.txt',
            ['AN', 'OPER', 'OPTYPE', 'DROPID', 'DATEIN', 'TIMEIN', 'DATEOUT', 'TIMEOUT']
        );

        $this->exportToTextFile(
            $results14,
            $baseDirectory . 'IDX.txt',
            ['AN', 'DIAG', 'DXTYPE', 'DRDX']
        );

        $this->exportToTextFile(
            $results15,
            $baseDirectory . 'IPD.txt',
            ['HN', 'AN', 'DATEADM', 'TIMEADM', 'DATEDSC', 'TIMEDSC', 'DISCHS', 'DISCHT', 'WARDDSC', 'DEPT', 'ADM_W', 'UUC', 'SVCTYPE']
        );
        #
        $this->exportToTextFile(
            $results16,
            $baseDirectory . 'AER.txt',
            ['HN', 'AN', 'DATEOPD', 'AUTHAE', 'AEDATE', 'AETIME', 'AETYPE', 'REFER_NO', 'REFMAINI', 'IREFTYPE', 'REFMAINO', 'OREFTYPE', 'UCAE', 'EMTYPE', 'SEQ', 'AESTATUS', 'DALERT', 'TALERT']
        );
        $this->exportToTextFile(
            $results18,
            $baseDirectory . 'ADP.txt',
            ['HN',	'AN','DATEOPD','TYPE','CODE','QTY','RATE','SEQ','CAGCODE','DOSE','CA_TYPE'	,'SERIALNO','TOTCOPAY','USE_STATUS',
            	'TOTAL','QTYDAY','TMLTCODE'	,'STATUS1',	'BI','CLINIC',	'ITEMSRC',	'PROVIDER',	'GRAVIDA'	,'GA_WEEK',
            	'DCIP/E_SCREEN'	,'LMP']
        );

        // $this->exportToTextFile(
        //     $results17,
        //     $baseDirectory . 'LVD.txt',
        //     ['SEQLVD', 'AN', 'DATEOUT', 'TIMEOUT', 'DATEIN', 'TIMEIN', 'QTYDAY']
        // );

        Yii::$app->session->setFlash(
            'success',
            'นับจำนวนในไฟล์.<br>' .
                //'Total adp: ' . count($results1) . '<br>' .
                'Total cha: ' . count($results2) . '<br>' .
                'Total cht: ' . count($results3) . '<br>' .
                'Total dru: ' . count($results4) . '<br>' .
                'Total ins: ' . count($results5) . '<br>' .
                // 'Total labfu: ' . count($results6) . '<br>' .
               // 'Total odx: ' . count($results7) . '<br>' .
                //'Total oop: ' . count($results8) . '<br>' .
                //'Total opd: ' . count($results9) . '<br>' .
                'Total orf: ' . count($results10) . '<br>' .
                'Total pat: ' . count($results11) . '<br>' .
                'Total irf: ' . count($results12) . '<br>' .
                'Total iop: ' . count($results13) . '<br>' .
                'Total idx: ' . count($results14) . '<br>' .
                'Total ipd: ' . count($results15) . '<br>' .
                'Total aer: ' . count($results16) . '<br>' .
                'Total adp: ' . count($results18) . '<br>' 
              //  'Total lvd: ' . count($results17) . '<br>'
        );
        return $this->render('index', ['baseDirectory' => $baseDirectory]);
    }
    /*    
        ################### DRU ##################################################################################
        $dru = " SELECT DISTINCT 
        gc.offid as 'HCODE' ,o.HN as 'HN',
        IFNULL(ip.ADM_ID, '' ) as 'AN',
        CONCAT(CASE 
            WHEN ip.adm_id <> '' THEN '1'
        ELSE '0'
        END ,s.f16, s.unit_id) as 'CLINIC',
        p.CID as 'PERSON_ID',
        DATE_FORMAT(o.REG_DATETIME,'%Y%m%d') as 'DATE_SERV',
        d.drug_id as 'DID',
        trim(d.drug_name) as 'DIDNAME',
        ps.rx_amount as 'Amount', v.unit_price as 'DRUGPRICE', d.price as 'DRUGCOST', d.didstd as 'DIDSTD',u.uunit_name as 'UNIT',
        CONCAT(REPLACE(ps.RX_DOSE,'.00',''),' ', u.UUNIT_NAME) as 'UNIT_PACK',
        o.visit_id as 'SEQ',
        u.uunit_name as 'DRUGTYPE', 
        '' as 'DRUGMARK', 
        '' as 'PA_NO', '' as 'TOTCOPAY', 
        CASE 
            WHEN v.order1 = '4' THEN '2'
            WHEN v.order1 = '3' THEN '1'
        ELSE ''
        END as 'USE_STATUE',v.invoice as 'TOTAL'
        FROM gcoffice gc, opd_visits o
        LEFT JOIN cid_hn b on o.HN = b.HN 
        LEFT JOIN population p on b.CID = p.CID
        LEFT JOIN opd_diagnosis i ON o.VISIT_ID=i.VISIT_ID AND i.IS_CANCEL = 0 AND i.DXT_ID = '1'
        LEFT JOIN prescriptions ps on o.visit_id = ps.visit_id AND ps.is_cancel=0
        LEFT JOIN drugs d on d.drug_id = ps.drug_id
        LEFT JOIN authen_kiosk ak ON p.cid=ak.cid AND DATE(ak.d_update)=date(o.REG_DATETIME)
        LEFT JOIN service_units s on s.UNIT_ID=o.UNIT_REG
        LEFT JOIN ipd_reg ip on ip.VISIT_ID=o.VISIT_ID AND ip.IS_CANCEL = 0 AND ip.dsc_dt BETWEEN '$date1' AND '$date2'
        LEFT JOIN service_units ss on ss.UNIT_ID = ip.WARD_NO
        LEFT JOIN mobile_visits m ON m.visit_id=o.visit_id
        LEFT JOIN visit_invoice v on v.visit_id=o.visit_id and v.is_cancel = 0 and v.drug_id =ps.drug_id 
        LEFT JOIN usage_units u on u.uunit_id = d.uunit_id
        WHERE o.IS_CANCEL = 0
        AND o.REG_DATETIME BETWEEN '$date1' AND '$date2'
        AND v.drug_id <> ''
        #GROUP BY o.VISIT_ID
         ";

    $results4 = $db14->createCommand($dru)->queryAll();
    $druFile = $baseDirectory . 'CHT.txt';
    $this->exportToTextFile($results3, $druFile,
    ['HCODE','HN','AN','CLINIC','PERSON_ID','DATE_SERV','DID','DIDNAME','AMOUNT','DRUGPRICE','DRUGCOST','DIDSTD','UNIT','UNIT_PACK','SEQ','DRUGREMARK','PA_NO','TOTCOPAY','USE_STATUS','TOTAL','SIGCODE','SIGTEXT','PROVIDER']); 
    
    if (file_exists($druFile)) {
        Yii::$app->session->setFlash('success', 'DRU.txt created successfully');
    } else {
        Yii::$app->session->setFlash('error', 'Error creating DRU.txt');
    }
    */


    public function actionExports()
    {
        $baseDirectory = 'uploads/F16_claim/';
        $mode = 0777; // Set the desired mode (permissions)
        $currentDateTime = date('Ymd_His');
        $zipFilename = $baseDirectory . 'F16_10953_IPD' . $currentDateTime . '.zip';
        // Open the ZIP file
        $zip = new ZipArchive();
        $zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // Find all files in the specified directory and add them to the ZIP archive
        $files = FileHelper::findFiles($baseDirectory);
        foreach ($files as $file) {
            $relativePath = str_replace($baseDirectory . '/', '', $file);
            $zip->addFile($file, $relativePath);
        }

        // Close the ZIP archive
        $zip->close();

        // Set appropriate headers for downloading
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . basename($zipFilename) . '"');
        header('Content-Length: ' . filesize($zipFilename));

        // Serve the ZIP file
        readfile($zipFilename);

        // Delete the ZIP file after it's downloaded
       // unlink($zipFilename);

        // Redirect to f16only/index after the download
        //header('Location: /f16only/index');
        //exit; // Make sure to exit to prevent further execution
       //  return $this->render('data', ['baseDirectory' => $baseDirectory]);
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
}
    