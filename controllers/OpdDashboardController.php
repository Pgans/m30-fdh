<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class OpdDashboardController extends Controller
{
    public function actionIndex()
{
    // รับค่าปีงบประมาณ (ค.ศ.) หรือคำนวณจากปีปัจจุบัน
    $currentYear = (int)date('Y');
    $currentMonth = (int)date('m');
    
    // คำนวณปีงบประมาณปัจจุบัน (ถ้าเดือน 10-12 ใช้ปีปัจจุบัน, เดือน 1-9 ใช้ปีก่อนหน้า)
    $defaultFiscalYear = ($currentMonth >= 10) ? $currentYear : $currentYear - 1;
    
    $fiscalYear = Yii::$app->request->get('fiscalYear', $defaultFiscalYear);
    
    // ปีงบประมาณ: 1 ตุลาคม $fiscalYear ถึง 30 กันยายน $fiscalYear+1
    $startDate = $fiscalYear . '-10-01 00:00:00';
    $endDate = ($fiscalYear + 1) . '-09-30 23:59:59';

    $sql = "
    SELECT 
        r.users AS กลุ่มงาน,
        
        -- ตุลาคม (เดือน 10 ของปี fiscalYear)
        COUNT(IF(MONTH(o.reg_datetime) = 10 AND YEAR(o.reg_datetime) = :fiscalYear, o.visit_id, NULL)) AS ต10_ทั้งหมด,
        COUNT(IF(MONTH(o.reg_datetime) = 10 AND YEAR(o.reg_datetime) = :fiscalYear AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)) AS ต10_เคลม,
        COUNT(IF(MONTH(o.reg_datetime) = 10 AND YEAR(o.reg_datetime) = :fiscalYear AND (r.messages = 'rejected' OR r.messages = ''), o.visit_id, NULL)) AS ต10_ไม่ชดเชย,
        SUM(CASE WHEN MONTH(r.datereg) = 10 AND YEAR(r.datereg) = :fiscalYear THEN c.hosp_claim ELSE 0 END) AS ต10_เรียกเก็บ,
        SUM(CASE WHEN MONTH(r.datereg) = 10 AND YEAR(r.datereg) = :fiscalYear THEN IFNULL(c.nhso_rep, 0) ELSE 0 END) AS ต10_ชดเชย,
        IF(COUNT(IF(MONTH(o.reg_datetime) = 10 AND YEAR(o.reg_datetime) = :fiscalYear, o.visit_id, NULL)) <> COUNT(IF(MONTH(o.reg_datetime) = 10 AND YEAR(o.reg_datetime) = :fiscalYear AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)), 1, 0) AS ต10_ติดC,
        
        -- พฤศจิกายน (เดือน 11 ของปี fiscalYear)
        COUNT(IF(MONTH(o.reg_datetime) = 11 AND YEAR(o.reg_datetime) = :fiscalYear, o.visit_id, NULL)) AS พ11_ทั้งหมด,
        COUNT(IF(MONTH(o.reg_datetime) = 11 AND YEAR(o.reg_datetime) = :fiscalYear AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)) AS พ11_เคลม,
        COUNT(IF(MONTH(o.reg_datetime) = 11 AND YEAR(o.reg_datetime) = :fiscalYear AND (r.messages = 'rejected' OR r.messages = ''), o.visit_id, NULL)) AS พ11_ไม่ชดเชย,
        SUM(CASE WHEN MONTH(r.datereg) = 11 AND YEAR(r.datereg) = :fiscalYear THEN c.hosp_claim ELSE 0 END) AS พ11_เรียกเก็บ,
        SUM(CASE WHEN MONTH(r.datereg) = 11 AND YEAR(r.datereg) = :fiscalYear THEN IFNULL(c.nhso_rep, 0) ELSE 0 END) AS พ11_ชดเชย,
        IF(COUNT(IF(MONTH(o.reg_datetime) = 11 AND YEAR(o.reg_datetime) = :fiscalYear, o.visit_id, NULL)) <> COUNT(IF(MONTH(o.reg_datetime) = 11 AND YEAR(o.reg_datetime) = :fiscalYear AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)), 1, 0) AS พ11_ติดC,
        
        -- ธันวาคม (เดือน 12 ของปี fiscalYear)
        COUNT(IF(MONTH(o.reg_datetime) = 12 AND YEAR(o.reg_datetime) = :fiscalYear, o.visit_id, NULL)) AS ธ12_ทั้งหมด,
        COUNT(IF(MONTH(o.reg_datetime) = 12 AND YEAR(o.reg_datetime) = :fiscalYear AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)) AS ธ12_เคลม,
        COUNT(IF(MONTH(o.reg_datetime) = 12 AND YEAR(o.reg_datetime) = :fiscalYear AND (r.messages = 'rejected' OR r.messages = ''), o.visit_id, NULL)) AS ธ12_ไม่ชดเชย,
        SUM(CASE WHEN MONTH(r.datereg) = 12 AND YEAR(r.datereg) = :fiscalYear THEN c.hosp_claim ELSE 0 END) AS ธ12_เรียกเก็บ,
        SUM(CASE WHEN MONTH(r.datereg) = 12 AND YEAR(r.datereg) = :fiscalYear THEN IFNULL(c.nhso_rep, 0) ELSE 0 END) AS ธ12_ชดเชย,
        IF(COUNT(IF(MONTH(o.reg_datetime) = 12 AND YEAR(o.reg_datetime) = :fiscalYear, o.visit_id, NULL)) <> COUNT(IF(MONTH(o.reg_datetime) = 12 AND YEAR(o.reg_datetime) = :fiscalYear AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)), 1, 0) AS ธ12_ติดC,
        
				-- มกราคม (1)
		COUNT(IF(MONTH(o.reg_datetime) = 1 AND YEAR(o.reg_datetime) = :fiscalYearNext, o.visit_id, NULL)) AS ม1_ทั้งหมด,
		COUNT(IF(MONTH(o.reg_datetime) = 1 AND YEAR(o.reg_datetime) = :fiscalYearNext AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)) AS ม1_เคลม,
		COUNT(IF(MONTH(o.reg_datetime) = 1 AND YEAR(o.reg_datetime) = :fiscalYearNext AND (r.messages = 'rejected' OR r.messages = ''), o.visit_id, NULL)) AS ม1_ไม่ชดเชย,
		SUM(CASE WHEN MONTH(r.datereg) = 1 AND YEAR(r.datereg) = :fiscalYearNext THEN c.hosp_claim ELSE 0 END) AS ม1_เรียกเก็บ,
		SUM(CASE WHEN MONTH(r.datereg) = 1 AND YEAR(r.datereg) = :fiscalYearNext THEN IFNULL(c.nhso_rep, 0) ELSE 0 END) AS ม1_ชดเชย,
		IF(
		  COUNT(IF(MONTH(o.reg_datetime) = 1 AND YEAR(o.reg_datetime) = :fiscalYearNext, o.visit_id, NULL))
		  <> 
		  COUNT(IF(MONTH(o.reg_datetime) = 1 AND YEAR(o.reg_datetime) = :fiscalYearNext AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)),
		  1, 0
		) AS ม1_ติดC,

		-- กุมภาพันธ์ (2)
		COUNT(IF(MONTH(o.reg_datetime) = 2 AND YEAR(o.reg_datetime) = :fiscalYearNext, o.visit_id, NULL)) AS ก2_ทั้งหมด,
		COUNT(IF(MONTH(o.reg_datetime) = 2 AND YEAR(o.reg_datetime) = :fiscalYearNext AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)) AS ก2_เคลม,
		COUNT(IF(MONTH(o.reg_datetime) = 2 AND YEAR(o.reg_datetime) = :fiscalYearNext AND (r.messages = 'rejected' OR r.messages = ''), o.visit_id, NULL)) AS ก2_ไม่ชดเชย,
		SUM(CASE WHEN MONTH(r.datereg) = 2 AND YEAR(r.datereg) = :fiscalYearNext THEN c.hosp_claim ELSE 0 END) AS ก2_เรียกเก็บ,
		SUM(CASE WHEN MONTH(r.datereg) = 2 AND YEAR(r.datereg) = :fiscalYearNext THEN IFNULL(c.nhso_rep, 0) ELSE 0 END) AS ก2_ชดเชย,
		IF(
		  COUNT(IF(MONTH(o.reg_datetime) = 2 AND YEAR(o.reg_datetime) = :fiscalYearNext, o.visit_id, NULL))
		  <> 
		  COUNT(IF(MONTH(o.reg_datetime) = 2 AND YEAR(o.reg_datetime) = :fiscalYearNext AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)),
		  1, 0
		) AS ก2_ติดC,

		-- มีนาคม (3)
		COUNT(IF(MONTH(o.reg_datetime) = 3 AND YEAR(o.reg_datetime) = :fiscalYearNext, o.visit_id, NULL)) AS ม3_ทั้งหมด,
		COUNT(IF(MONTH(o.reg_datetime) = 3 AND YEAR(o.reg_datetime) = :fiscalYearNext AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)) AS ม3_เคลม,
		COUNT(IF(MONTH(o.reg_datetime) = 3 AND YEAR(o.reg_datetime) = :fiscalYearNext AND (r.messages = 'rejected' OR r.messages = ''), o.visit_id, NULL)) AS ม3_ไม่ชดเชย,
		SUM(CASE WHEN MONTH(r.datereg) = 3 AND YEAR(r.datereg) = :fiscalYearNext THEN c.hosp_claim ELSE 0 END) AS ม3_เรียกเก็บ,
		SUM(CASE WHEN MONTH(r.datereg) = 3 AND YEAR(r.datereg) = :fiscalYearNext THEN IFNULL(c.nhso_rep, 0) ELSE 0 END) AS ม3_ชดเชย,
		IF(
		  COUNT(IF(MONTH(o.reg_datetime) = 3 AND YEAR(o.reg_datetime) = :fiscalYearNext, o.visit_id, NULL))
		  <> 
		  COUNT(IF(MONTH(o.reg_datetime) = 3 AND YEAR(o.reg_datetime) = :fiscalYearNext AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)),
		  1, 0
		) AS ม3_ติดC,

		-- เมษายน (4)
		COUNT(IF(MONTH(o.reg_datetime) = 4 AND YEAR(o.reg_datetime) = :fiscalYearNext, o.visit_id, NULL)) AS ม4_ทั้งหมด,
		COUNT(IF(MONTH(o.reg_datetime) = 4 AND YEAR(o.reg_datetime) = :fiscalYearNext AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)) AS ม4_เคลม,
		COUNT(IF(MONTH(o.reg_datetime) = 4 AND YEAR(o.reg_datetime) = :fiscalYearNext AND (r.messages = 'rejected' OR r.messages = ''), o.visit_id, NULL)) AS ม4_ไม่ชดเชย,
		SUM(CASE WHEN MONTH(r.datereg) = 4 AND YEAR(r.datereg) = :fiscalYearNext THEN c.hosp_claim ELSE 0 END) AS ม4_เรียกเก็บ,
		SUM(CASE WHEN MONTH(r.datereg) = 4 AND YEAR(r.datereg) = :fiscalYearNext THEN IFNULL(c.nhso_rep, 0) ELSE 0 END) AS ม4_ชดเชย,
		IF(
		  COUNT(IF(MONTH(o.reg_datetime) = 4 AND YEAR(o.reg_datetime) = :fiscalYearNext, o.visit_id, NULL))
		  <> 
		  COUNT(IF(MONTH(o.reg_datetime) = 4 AND YEAR(o.reg_datetime) = :fiscalYearNext AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)),
		  1, 0
		) AS ม4_ติดC,

		-- พฤษภาคม (5)
		COUNT(IF(MONTH(o.reg_datetime) = 5 AND YEAR(o.reg_datetime) = :fiscalYearNext, o.visit_id, NULL)) AS พ5_ทั้งหมด,
		COUNT(IF(MONTH(o.reg_datetime) = 5 AND YEAR(o.reg_datetime) = :fiscalYearNext AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)) AS พ5_เคลม,
		COUNT(IF(MONTH(o.reg_datetime) = 5 AND YEAR(o.reg_datetime) = :fiscalYearNext AND (r.messages = 'rejected' OR r.messages = ''), o.visit_id, NULL)) AS พ5_ไม่ชดเชย,
		SUM(CASE WHEN MONTH(r.datereg) = 5 AND YEAR(r.datereg) = :fiscalYearNext THEN c.hosp_claim ELSE 0 END) AS พ5_เรียกเก็บ,
		SUM(CASE WHEN MONTH(r.datereg) = 5 AND YEAR(r.datereg) = :fiscalYearNext THEN IFNULL(c.nhso_rep, 0) ELSE 0 END) AS พ5_ชดเชย,
		IF(
		  COUNT(IF(MONTH(o.reg_datetime) = 5 AND YEAR(o.reg_datetime) = :fiscalYearNext, o.visit_id, NULL))
		  <> 
		  COUNT(IF(MONTH(o.reg_datetime) = 5 AND YEAR(o.reg_datetime) = :fiscalYearNext AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)),
		  1, 0
		) AS พ5_ติดC,

		-- มิถุนายน (6)
		COUNT(IF(MONTH(o.reg_datetime) = 6 AND YEAR(o.reg_datetime) = :fiscalYearNext, o.visit_id, NULL)) AS ม6_ทั้งหมด,
		COUNT(IF(MONTH(o.reg_datetime) = 6 AND YEAR(o.reg_datetime) = :fiscalYearNext AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)) AS ม6_เคลม,
		COUNT(IF(MONTH(o.reg_datetime) = 6 AND YEAR(o.reg_datetime) = :fiscalYearNext AND (r.messages = 'rejected' OR r.messages = ''), o.visit_id, NULL)) AS ม6_ไม่ชดเชย,
		SUM(CASE WHEN MONTH(r.datereg) = 6 AND YEAR(r.datereg) = :fiscalYearNext THEN c.hosp_claim ELSE 0 END) AS ม6_เรียกเก็บ,
		SUM(CASE WHEN MONTH(r.datereg) = 6 AND YEAR(r.datereg) = :fiscalYearNext THEN IFNULL(c.nhso_rep, 0) ELSE 0 END) AS ม6_ชดเชย,
		IF(
		  COUNT(IF(MONTH(o.reg_datetime) = 6 AND YEAR(o.reg_datetime) = :fiscalYearNext, o.visit_id, NULL))
		  <> 
		  COUNT(IF(MONTH(o.reg_datetime) = 6 AND YEAR(o.reg_datetime) = :fiscalYearNext AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)),
		  1, 0
		) AS ม6_ติดC,

		-- กรกฎาคม (7)
		COUNT(IF(MONTH(o.reg_datetime) = 7 AND YEAR(o.reg_datetime) = :fiscalYearNext, o.visit_id, NULL)) AS ก7_ทั้งหมด,
		COUNT(IF(MONTH(o.reg_datetime) = 7 AND YEAR(o.reg_datetime) = :fiscalYearNext AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)) AS ก7_เคลม,
		COUNT(IF(MONTH(o.reg_datetime) = 7 AND YEAR(o.reg_datetime) = :fiscalYearNext AND (r.messages = 'rejected' OR r.messages = ''), o.visit_id, NULL)) AS ก7_ไม่ชดเชย,
		SUM(CASE WHEN MONTH(r.datereg) = 7 AND YEAR(r.datereg) = :fiscalYearNext THEN c.hosp_claim ELSE 0 END) AS ก7_เรียกเก็บ,
		SUM(CASE WHEN MONTH(r.datereg) = 7 AND YEAR(r.datereg) = :fiscalYearNext THEN IFNULL(c.nhso_rep, 0) ELSE 0 END) AS ก7_ชดเชย,
		IF(
		  COUNT(IF(MONTH(o.reg_datetime) = 7 AND YEAR(o.reg_datetime) = :fiscalYearNext, o.visit_id, NULL))
		  <> 
		  COUNT(IF(MONTH(o.reg_datetime) = 7 AND YEAR(o.reg_datetime) = :fiscalYearNext AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)),
		  1, 0
		) AS ก7_ติดC,

		-- สิงหาคม (8)
		COUNT(IF(MONTH(o.reg_datetime) = 8 AND YEAR(o.reg_datetime) = :fiscalYearNext, o.visit_id, NULL)) AS ส8_ทั้งหมด,
		COUNT(IF(MONTH(o.reg_datetime) = 8 AND YEAR(o.reg_datetime) = :fiscalYearNext AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)) AS ส8_เคลม,
		COUNT(IF(MONTH(o.reg_datetime) = 8 AND YEAR(o.reg_datetime) = :fiscalYearNext AND (r.messages = 'rejected' OR r.messages = ''), o.visit_id, NULL)) AS ส8_ไม่ชดเชย,
		SUM(CASE WHEN MONTH(r.datereg) = 8 AND YEAR(r.datereg) = :fiscalYearNext THEN c.hosp_claim ELSE 0 END) AS ส8_เรียกเก็บ,
		SUM(CASE WHEN MONTH(r.datereg) = 8 AND YEAR(r.datereg) = :fiscalYearNext THEN IFNULL(c.nhso_rep, 0) ELSE 0 END) AS ส8_ชดเชย,
		IF(
		  COUNT(IF(MONTH(o.reg_datetime) = 8 AND YEAR(o.reg_datetime) = :fiscalYearNext, o.visit_id, NULL))
		  <> 
		  COUNT(IF(MONTH(o.reg_datetime) = 8 AND YEAR(o.reg_datetime) = :fiscalYearNext AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)),
		  1, 0
		) AS ส8_ติดC,

		-- กันยายน (9)
		COUNT(IF(MONTH(o.reg_datetime) = 9 AND YEAR(o.reg_datetime) = :fiscalYearNext, o.visit_id, NULL)) AS ก9_ทั้งหมด,
		COUNT(IF(MONTH(o.reg_datetime) = 9 AND YEAR(o.reg_datetime) = :fiscalYearNext AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)) AS ก9_เคลม,
		COUNT(IF(MONTH(o.reg_datetime) = 9 AND YEAR(o.reg_datetime) = :fiscalYearNext AND (r.messages = 'rejected' OR r.messages = ''), o.visit_id, NULL)) AS ก9_ไม่ชดเชย,
		SUM(CASE WHEN MONTH(r.datereg) = 9 AND YEAR(r.datereg) = :fiscalYearNext THEN c.hosp_claim ELSE 0 END) AS ก9_เรียกเก็บ,
		SUM(CASE WHEN MONTH(r.datereg) = 9 AND YEAR(r.datereg) = :fiscalYearNext THEN IFNULL(c.nhso_rep, 0) ELSE 0 END) AS ก9_ชดเชย,
		IF(
		  COUNT(IF(MONTH(o.reg_datetime) = 9 AND YEAR(o.reg_datetime) = :fiscalYearNext, o.visit_id, NULL))
		  <> 
		  COUNT(IF(MONTH(o.reg_datetime) = 9 AND YEAR(o.reg_datetime) = :fiscalYearNext AND r.messages NOT IN ('rejected', ''), r.visit_id, NULL)),
		  1, 0
		) AS ก9_ติดC,

        
        -- รวมทั้งหมด
        COUNT(o.visit_id) AS รวม_ทั้งหมด,
        SUM(c.hosp_claim) AS รวม_เรียกเก็บ,
        SUM(IFNULL(c.nhso_rep, 0)) AS รวม_ชดเชย,
        (SUM(c.hosp_claim) - SUM(IFNULL(c.nhso_rep, 0))) AS ผลต่าง

    FROM opd_visits o
    LEFT JOIN log_fdh_opd_ck r ON o.visit_id = r.visit_id
    LEFT JOIN mbase_data1.cost_visits c ON c.visit_id = o.visit_id

    WHERE o.REG_DATETIME BETWEEN :startDate AND :endDate
      AND o.IS_CANCEL = 0
      AND r.users IS NOT NULL

    GROUP BY r.users
    ORDER BY r.users
    ";

    $data = Yii::$app->db70->createCommand($sql)
        ->bindValue(':fiscalYear', $fiscalYear)
        ->bindValue(':fiscalYearNext', $fiscalYear + 1)
        ->bindValue(':startDate', $startDate)
        ->bindValue(':endDate', $endDate)
        ->queryAll();

    


        // คำนวณผลรวมด้านบน
        $totalClaim = 0;
        $totalCompensation = 0;
        foreach ($data as $row) {
            $totalClaim += $row['รวม_เรียกเก็บ'];
            $totalCompensation += $row['รวม_ชดเชย'];
        }
        $totalDifference = $totalClaim - $totalCompensation;

        // สร้าง DataProvider
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'fiscalYear' => $fiscalYear,
            'totalClaim' => $totalClaim,
            'totalCompensation' => $totalCompensation,
            'totalDifference' => $totalDifference,
        ]);
    }
}