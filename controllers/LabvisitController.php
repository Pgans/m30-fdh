<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\UploadForm;

class LabvisitController extends Controller
{
    public function actionIndex()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->validate()) {
                // กำหนดตำแหน่งที่เก็บไฟล์
                $filePath = Yii::getAlias('@webroot/uploads/textlab/lab.txt');
                if (!is_dir(dirname($filePath))) {
                    mkdir(dirname($filePath), 0755, true);
                }

                // บันทึกไฟล์
                $model->file->saveAs($filePath);

                // อ่านไฟล์และดึงค่า CID
                $cids = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

                // แปลงค่าจาก array ให้เป็น string สำหรับใช้ใน IN Query
                $cidString = implode(',', array_map('trim', $cids));

                // เรียก Query
                $result = $this->queryLabData($cidString);

                // ส่งผลลัพธ์ไปยัง View
                return $this->render('index', [
                    'model' => $model,
                    'data' => $result,
                ]);
            }
        }

        return $this->render('index', ['model' => $model, 'data' => null]);
    }

    private function queryLabData($cidString)
    {
        $sql = "
            SELECT o.hn, o.visit_id, o.reg_datetime, MAX(o.VISIT_ID) AS max_visit, MAX(o.REG_DATETIME) AS maxdate, o.STAFF_ID
            FROM opd_visits o
            INNER JOIN cid_hn c ON o.hn = c.hn
            LEFT JOIN population p ON p.cid = c.cid
            WHERE o.REG_DATETIME >= CURDATE()
            AND c.cid IN ($cidString)
            AND o.STAFF_ID = :staff_id
            AND o.IS_CANCEL = 0
            GROUP BY o.VISIT_ID
            ORDER BY o.HN
        ";

        return Yii::$app->db14->createCommand($sql, [':staff_id' => '0292'])->queryAll();
    }
}
