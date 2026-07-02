<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;

/**
 * Model สำหรับจัดการข้อมูลค่ารักษาพยาบาล (VisitInvoice)
 * ปรับปรุง: เพิ่ม batch query methods เพื่อลด query จาก N+1 เหลือ 2 ครั้ง
 */
class VisitInvoice extends Model
{
    public static $tableOpdVisits   = 'opd_visits';
    public static $tableVisitInvoice = 'visit_invoice';
    public static $tableCostVisits  = 'cost_visits';

    public static function getDb()
    {
        return Yii::$app->db2;
    }

    // =========================================================================
    // BATCH METHODS (ใหม่) — ใช้กับ actionIndex เพื่อ preload ทั้งหน้า
    // =========================================================================

    /**
     * ดึงข้อมูล invoice ทุก visit_id ในครั้งเดียว (IN query)
     * คืน array จัดกลุ่มตาม visit_id: [ visit_id => [ items... ] ]
     *
     * @param  array $visitIds
     * @return array
     */
    public static function getInvoicesByVisitIds(array $visitIds): array
    {
        if (empty($visitIds)) return [];

        $table        = self::$tableVisitInvoice;
        $placeholders = [];
        $params       = [];

        foreach ($visitIds as $i => $id) {
            $placeholders[] = ':v' . $i;
            $params[':v' . $i] = $id;
        }
        $inClause = implode(',', $placeholders);

        $sql = "SELECT visit_id, record_dt, item, invoice, amount, subtotal
                FROM {$table}
                WHERE visit_id IN ({$inClause})
                  AND is_cancel = 0
                ORDER BY visit_id, record_dt, invoice";

        try {
            $rows    = self::getDb()->createCommand($sql, $params)->queryAll();
            $grouped = [];
            foreach ($rows as $row) {
                $grouped[$row['visit_id']][] = $row;
            }
            return $grouped;
        } catch (\Exception $e) {
            Yii::error('Batch invoice error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * ดึง patient info ทุก visit_id ในครั้งเดียว (IN query)
     * คืน array key'd ด้วย visit_id: [ visit_id => patient_row ]
     *
     * @param  array $visitIds
     * @return array
     */
    public static function getPatientInfoByVisitIds(array $visitIds): array
    {
        if (empty($visitIds)) return [];

        $table        = self::$tableOpdVisits;
        $placeholders = [];
        $params       = [];

        foreach ($visitIds as $i => $id) {
            $placeholders[] = ':v' . $i;
            $params[':v' . $i] = $id;
        }
        $inClause = implode(',', $placeholders);

        $sql = "SELECT o.visit_id, o.hn, o.REG_DATETIME,
                       p.cid,
                       f.INSCL_NAME AS inscl,
                       CONCAT(TRIM(p.PRENAME), TRIM(p.FNAME), ' ', TRIM(p.LNAME)) AS fullname,
                       TIMESTAMPDIFF(year,  p.BIRTHDATE, o.REG_DATETIME) AS age_y,
                       TIMESTAMPDIFF(month, p.BIRTHDATE, o.REG_DATETIME) % 12 AS age_m
                FROM {$table} o
                INNER JOIN cid_hn    c ON o.HN    = c.HN
                INNER JOIN population p ON c.CID   = p.CID
                LEFT  JOIN main_inscls f ON o.INSCL = f.INSCL
                WHERE o.visit_id IN ({$inClause})";

        try {
            $rows = self::getDb()->createCommand($sql, $params)->queryAll();
            // key by visit_id เพื่อ O(1) lookup ใน JS/PHP
            return array_column($rows, null, 'visit_id');
        } catch (\Exception $e) {
            Yii::error('Batch patient info error: ' . $e->getMessage());
            return [];
        }
    }

    // =========================================================================
    // SINGLE-VISIT METHODS (เดิม) — ยังใช้กับ Export Excel / CSV
    // =========================================================================

    /**
     * ดึงข้อมูลผู้ป่วยรายบุคคลสำหรับหัวเอกสาร
     *
     * @param  int|string $visit_id
     * @return array|false
     */
    public static function getPatientInfo($visit_id)
    {
        $table = self::$tableOpdVisits;
        $sql   = "SELECT o.visit_id, o.hn, o.REG_DATETIME,
                         p.cid,
                         f.INSCL_NAME AS inscl,
                         CONCAT(TRIM(p.PRENAME), TRIM(p.FNAME), ' ', TRIM(p.LNAME)) AS fullname,
                         TIMESTAMPDIFF(year,  p.BIRTHDATE, o.REG_DATETIME) AS age_y,
                         TIMESTAMPDIFF(month, p.BIRTHDATE, o.REG_DATETIME) % 12 AS age_m
                  FROM {$table} o
                  INNER JOIN cid_hn    c ON o.HN    = c.HN
                  INNER JOIN population p ON c.CID   = p.CID
                  LEFT  JOIN main_inscls f ON o.INSCL = f.INSCL
                  WHERE o.visit_id = :visit_id
                  LIMIT 1";

        try {
            return self::getDb()->createCommand($sql)
                ->bindValue(':visit_id', $visit_id)
                ->queryOne();
        } catch (\Exception $e) {
            Yii::error('Error fetching patient info from db2: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * ดึงข้อมูลใบแจ้งหนี้ตาม visit_id รายเดี่ยว
     *
     * @param  int|string $visit_id
     * @return array
     */
    public static function getInvoiceByVisitId($visit_id)
    {
        $table = self::$tableVisitInvoice;
        $sql   = "SELECT visit_id, record_dt, item, invoice, amount, subtotal
                  FROM {$table}
                  WHERE visit_id = :visit_id
                    AND is_cancel = 0
                  ORDER BY record_dt, invoice";

        try {
            return self::getDb()->createCommand($sql)
                ->bindValue(':visit_id', $visit_id)
                ->queryAll();
        } catch (\Exception $e) {
            Yii::error('Error fetching invoice from db2: ' . $e->getMessage());
            return [];
        }
    }

    // =========================================================================
    // SEARCH / DATA PROVIDER
    // =========================================================================

    /**
     * ค้นหาข้อมูลบริการ OPD ตามช่วงเวลา (Query หลักสำหรับหน้าแรก)
     *
     * @param  string $startDate  Y-m-d
     * @param  string $endDate    Y-m-d
     * @return SqlDataProvider
     */
    public static function searchOpdVisits($startDate, $endDate)
    {
        $table     = self::$tableOpdVisits;
        $costTable = self::$tableCostVisits;

        $sql = "SELECT
                    @n := @n + 1 AS 'No',
                    data.*
                FROM (
                    SELECT
                        DATE_FORMAT(o.reg_datetime, '%Y-%m-%d %H:%i') AS 'regdate',
                        o.visit_id,
                        o.hn,
                        o.weight,
                        o.height,
                        CONCAT(
                            CASE
                                WHEN p.PRENAME NOT IN ('') THEN TRIM(p.PRENAME)
                                WHEN TIMESTAMPDIFF(year, p.BIRTHDATE, NOW()) <  '20' AND p.sex = '1' AND p.MARRIAGE = '4' THEN 'สามเณร'
                                WHEN TIMESTAMPDIFF(year, p.BIRTHDATE, NOW()) >= '20' AND p.sex = '1' AND p.MARRIAGE = '4' THEN 'พระภิกษุ'
                                WHEN TIMESTAMPDIFF(year, p.BIRTHDATE, NOW()) <  '15' AND p.sex = '1' THEN 'เด็กชาย'
                                WHEN TIMESTAMPDIFF(year, p.BIRTHDATE, NOW()) >= '15' AND p.sex = '1' THEN 'นาย'
                                WHEN TIMESTAMPDIFF(year, p.BIRTHDATE, NOW()) <  '15' AND p.sex = '2' THEN 'เด็กหญิง'
                                WHEN TIMESTAMPDIFF(year, p.BIRTHDATE, NOW()) >= '15' AND p.sex = '2' AND p.MARRIAGE = '1' THEN 'นางสาว'
                                ELSE 'นาง'
                            END,
                            TRIM(p.FNAME), '  ', TRIM(p.LNAME)
                        ) AS 'fullname',
                        TIMESTAMPDIFF(year, p.BIRTHDATE, o.REG_DATETIME) AS 'age',
                        p.cid,
                        icd1.ICD10_TM AS Diagx,
                        LEFT(GROUP_CONCAT(DISTINCT TRIM(icd.ICD10_TM)), 30) AS Diag,
                        f.INSCL_NAME AS 'inscl',
                        COALESCE((
                            cos.cg01 + cos.cg02 + cos.cg03 + cos.cg04 + cos.cg05 +
                            cos.cg06 + cos.cg07 + cos.cg08 + cos.cg09 + cos.cg10 +
                            cos.cg11 + cos.cg12 + cos.cg13 + cos.cg14 + cos.cg15 +
                            cos.cg16 + cos.cg17 + cos.cg18 + cos.cg19
                        ), 0.00) AS amount,
                        IFNULL(o.claim_code, '') AS claim_code
                    FROM {$table} o
                    INNER JOIN cid_hn    c   ON o.HN       = c.HN
                    INNER JOIN population p  ON c.CID      = p.CID  AND LEFT(p.cid, 5) <> '00000'
                    LEFT  JOIN opd_diagnosis d  ON d.visit_id = o.visit_id AND d.is_cancel = 0
                    LEFT  JOIN icd10new   icd  ON icd.icd10  = d.icd10   AND icd.icd10   <> ''
                    LEFT  JOIN opd_diagnosis d1 ON d1.visit_id = o.visit_id AND d.is_cancel = 0 AND d1.dxt_id = 1
                    LEFT  JOIN icd10new   icd1 ON icd1.icd10 = d1.icd10  AND icd1.icd10  <> ''
                    LEFT  JOIN main_inscls f   ON o.INSCL    = f.INSCL
                    LEFT  JOIN {$costTable} cos ON cos.visit_id = o.visit_id AND cos.is_cancel = 0
                    WHERE o.IS_CANCEL = 0
                      AND o.REG_DATETIME BETWEEN :start AND :end
                      AND o.INSCL IN ('18', '19')
                      AND o.visit_id NOT IN (SELECT ipd_reg.visit_id FROM ipd_reg  WHERE ipd_reg.is_cancel = 0)
                      AND o.visit_id NOT IN (SELECT visit_id           FROM mobile_visits)
                    GROUP BY o.VISIT_ID
                ) AS data,
                (SELECT @n := 0) AS init
                ORDER BY No ASC";

        $countSql = "SELECT COUNT(o.visit_id)
                     FROM {$table} o
                     WHERE o.IS_CANCEL = 0
                       AND o.REG_DATETIME BETWEEN :start AND :end
                       AND o.INSCL IN ('18', '19')
                       AND o.visit_id NOT IN (SELECT ipd_reg.visit_id FROM ipd_reg  WHERE ipd_reg.is_cancel = 0)
                       AND o.visit_id NOT IN (SELECT visit_id           FROM mobile_visits)";

        $count = self::getDb()->createCommand($countSql, [
            ':start' => $startDate . ' 00:00:00',
            ':end'   => $endDate   . ' 23:59:59',
        ])->queryScalar();

        return new SqlDataProvider([
            'db'         => self::getDb(),
            'sql'        => $sql,
            'params'     => [
                ':start' => $startDate . ' 00:00:00',
                ':end'   => $endDate   . ' 23:59:59',
            ],
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }
}