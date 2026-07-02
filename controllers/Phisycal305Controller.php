<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;

class RevisitController extends Controller
{
    public function actionIndex()
    {
        $date_start    = Yii::$app->request->post('date_start', date('Y') . '-10-01');
        $date_end      = Yii::$app->request->post('date_end',   date('Y-m-d'));
        $revisit_hours = Yii::$app->request->post('revisit_hours', 48);

        $rows = [];

        if (Yii::$app->request->isPost) {
            $rows = $this->getTop10($date_start, $date_end, $revisit_hours);
        }

        return $this->render('index', [
            'rows'          => $rows,
            'date_start'    => $date_start,
            'date_end'      => $date_end,
            'revisit_hours' => $revisit_hours,
        ]);
    }

    public function actionDetail($icd10)
    {
        $date_start    = Yii::$app->request->get('date_start');
        $date_end      = Yii::$app->request->get('date_end');
        $revisit_hours = Yii::$app->request->get('revisit_hours', 48);

        $details = $this->getDetailByIcd10($icd10, $date_start, $date_end, $revisit_hours);

        return $this->render('_detail', [
            'icd10'         => $icd10,
            'details'       => $details,
            'date_start'    => $date_start,
            'date_end'      => $date_end,
            'revisit_hours' => $revisit_hours,
        ]);
    }

    // ─── Query Top 10 ───────────────────────────────────────────
    private function getTop10($date_start, $date_end, $revisit_hours)
    {
        $sql = "
            SELECT 
                i1.icd10                    AS icd10,
                i1.icd10_tm                 AS disease_name,
                COUNT(DISTINCT c.hn)        AS revisit_count
            FROM opd_visits o1
            LEFT JOIN cid_hn c
                ON o1.hn = c.hn AND o1.is_cancel = 0
            LEFT JOIN opd_visits o2
                ON o2.hn = c.hn AND o2.is_cancel = 0
               AND o2.visit_id > o1.visit_id
            LEFT JOIN opd_diagnosis dx1
                ON o1.visit_id = dx1.visit_id
               AND dx1.DXT_ID = 1 AND dx1.is_cancel = 0
            LEFT JOIN opd_diagnosis dx2
                ON o2.visit_id = dx2.visit_id
               AND dx2.DXT_ID = 1 AND dx2.is_cancel = 0
            LEFT JOIN icd10new i1 ON i1.icd10 = dx1.icd10
            LEFT JOIN icd10new i2 ON i2.icd10 = dx2.icd10
            WHERE o1.REG_DATETIME BETWEEN :date_start AND :date_end
              AND i1.icd10_tm = i2.icd10_tm
              AND LEFT(i1.icd10, 1) NOT IN ('Z','U')
              AND o1.hn NOT IN (
                    SELECT hn FROM appoints
                    WHERE AP_DATE = DATE(o1.REG_DATETIME)
              )
              AND (
                    ((TO_DAYS(o2.REG_DATETIME) * 24) - (TO_DAYS(o1.REG_DATETIME) * 24))
                  + ((TIME_TO_SEC(o2.REG_DATETIME)) / 3600)
                  - ((TIME_TO_SEC(o1.REG_DATETIME)) / 3600)
              ) BETWEEN 0.001 AND :max_hrs
            GROUP BY i1.icd10, i1.icd10_tm
            ORDER BY revisit_count DESC
            LIMIT 10
        ";

        return Yii::$app->db->createCommand($sql, [
            ':date_start' => $date_start . ' 00:00:00',
            ':date_end'   => $date_end   . ' 23:59:59',
            ':max_hrs'    => (float)$revisit_hours,
        ])->queryAll();
    }

    // ─── Query Detail ────────────────────────────────────────────
    private function getDetailByIcd10($icd10, $date_start, $date_end, $revisit_hours)
    {
        $sql = "
            SELECT 
                o1.visit_id                                     AS vn1,
                DATE(o1.REG_DATETIME)                           AS d1,
                TIME(o1.REG_DATETIME)                           AS time_1,
                CONCAT(TRIM(p.fname), '  ', p.lname)            AS ptname,
                c.hn,
                o2.visit_id                                     AS vn2,
                DATE(o2.REG_DATETIME)                           AS d2,
                TIME(o2.REG_DATETIME)                           AS time_2,
                i1.icd10_tm                                     AS icdname,
                ROUND(
                    ((TO_DAYS(o2.REG_DATETIME) * 24) - (TO_DAYS(o1.REG_DATETIME) * 24))
                  + ((TIME_TO_SEC(o2.REG_DATETIME)) / 3600)
                  - ((TIME_TO_SEC(o1.REG_DATETIME)) / 3600)
                , 2)                                            AS revisit_hrs
            FROM opd_visits o1
            LEFT JOIN cid_hn c
                ON o1.hn = c.hn AND o1.is_cancel = 0
            LEFT JOIN population p
                ON p.cid = c.cid
            LEFT JOIN opd_visits o2
                ON o2.hn = c.hn AND o2.is_cancel = 0
               AND o2.visit_id > o1.visit_id
            LEFT JOIN opd_diagnosis dx1
                ON o1.visit_id = dx1.visit_id
               AND dx1.DXT_ID = 1 AND dx1.is_cancel = 0
            LEFT JOIN opd_diagnosis dx2
                ON o2.visit_id = dx2.visit_id
               AND dx2.DXT_ID = 1 AND dx2.is_cancel = 0
            LEFT JOIN icd10new i1 ON i1.icd10 = dx1.icd10
            LEFT JOIN icd10new i2 ON i2.icd10 = dx2.icd10
            WHERE o1.REG_DATETIME BETWEEN :date_start AND :date_end
              AND dx1.icd10 = :icd10
              AND i1.icd10_tm = i2.icd10_tm
              AND o1.hn NOT IN (
                    SELECT hn FROM appoints
                    WHERE AP_DATE = DATE(o1.REG_DATETIME)
              )
              AND (
                    ((TO_DAYS(o2.REG_DATETIME) * 24) - (TO_DAYS(o1.REG_DATETIME) * 24))
                  + ((TIME_TO_SEC(o2.REG_DATETIME)) / 3600)
                  - ((TIME_TO_SEC(o1.REG_DATETIME)) / 3600)
              ) BETWEEN 0.001 AND :max_hrs
            GROUP BY c.hn
            HAVING COUNT(c.hn) > 1
            ORDER BY d1 ASC
        ";

        return Yii::$app->db->createCommand($sql, [
            ':date_start' => $date_start . ' 00:00:00',
            ':date_end'   => $date_end   . ' 23:59:59',
            ':icd10'      => $icd10,
            ':max_hrs'    => (float)$revisit_hours,
        ])->queryAll();
    }
}