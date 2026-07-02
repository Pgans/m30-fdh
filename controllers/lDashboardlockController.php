<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use yii\helpers\Json;

class DashboardlockController extends Controller
{
    public function actionIndex()
    {
        // ดึงข้อมูลจากฐานข้อมูล
        $result = Yii::$app->db7->createCommand("SHOW OPEN TABLES WHERE In_use > 0;")
            ->queryAll();

        // ส่งข้อมูลไปยัง View
        return $this->render('index', [
            'data' => $result
        ]);
    }
}
