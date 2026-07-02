<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class Check514Controller extends \yii\web\Controller
{
    public function actionIndex()
    {
	$data = Yii::$app->db2->createCommand("
            SELECT o.HN, i.ADM_ID, i.DSC_TYPE, i.DSC_DT
            FROM ipd_reg i
            LEFT JOIN refers r ON i.VISIT_ID = r.VISIT_ID
            LEFT JOIN opd_visits o ON i.VISIT_ID = o.VISIT_ID
            WHERE i.DSC_DT BETWEEN '2024-10-01 00:00:00' AND '2025-12-31 23:59:59'
              AND i.IS_CANCEL = 0
              AND r.RF_TYPE = 2
              AND r.IS_CANCEL = 0
              AND r.TRANSPORT IN (2,3,4,5)
              AND i.dsc_type != 4
            GROUP BY i.VISIT_ID
        ")->queryAll();

        return $this->render('index', ['data' => $data]);
    }
}


