<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\F16fdhipdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'ANC-DENT-US-Lab1-upt');
$this->params['breadcrumbs'][] = $this->title;
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3D Panel</title>
    <style>
        .panel-3d {
            border: 1px solid #ffffff; /* เส้นขอบ */
            border-radius: 6px; /* โค้งมน */
            padding: 20px; /* ระยะห่างขอบ */
            box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.75); /* เส้นเรืองแสง 3 มิติ */
        }
        .panel-3d {
    background-color: #e3f2e3; /* รหัสสีของเขียวอ่อนจาง */
}
    </style>
   <style>
    .index-watermark::before {
        content: "ANC-DENT-US-Lab1-UPT";
        position: absolute;
        top: 30%;
        left: 30%;
        transform: rotate(-45deg) translate(-50%, -50%);
        font-size: 5em; /* ขนาดตัวอักษร */
        color: rgba(0, 0, 0, 0.2); /* สีของตัวอักษร */
        pointer-events: none; /* ป้องกันการคลิกที่ตัวอักษร */
        z-index: 1; /* ให้ตัวอักษรอยู่ข้างหน้าเพื่อไม่ให้บังคับปุ่มหรือเนื้อหาอื่นๆ */
    }

    .index-watermark::after {
        content: "ANC-DENT-U/S-Lab1";
        position: absolute;
        top: 70%;
        left: 70%;
        transform: rotate(-45deg) translate(-50%, -50%);
        font-size: 5em; /* ขนาดตัวอักษร */
        color: rgba(0, 0, 0, 0.2); /* สีของตัวอักษร */
        pointer-events: none; /* ป้องกันการคลิกที่ตัวอักษร */
        z-index: 1; /* ให้ตัวอักษรอยู่ข้างหน้าเพื่อไม่ให้บังคับปุ่มหรือเนื้อหาอื่นๆ */
    }
</style>
</head>
<div class="index-watermark">
    <div class="panel-3d">
    <p>
    <!-- <?= Html::a('<i class="fa fa-arrow-circle-right" aria-hidden="true"></i> เพิ่มข้อมูล', ['create'], ['class' => 'btn btn-success']) ?> -->

    </p>
    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'main_table',
            'main_query:ntext',
           'd_update',

            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}', // กำหนดให้แสดงเฉพาะปุ่มแก้ไขเท่านั้น
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-edit" style="font-size: 25px;"></span>', $url, [
                            'title' => Yii::t('yii', 'Update'),
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
