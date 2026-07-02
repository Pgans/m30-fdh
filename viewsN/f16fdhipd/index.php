<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\F16fdhipdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Query IPD-ช่วงเวลา ');
$this->params['breadcrumbs'][] = $this->title;
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3D Panel</title>
    <style>
        .panel-3d {
            border: 1px solid #ff8aff; /* เส้นขอบ */
            border-radius: 6px; /* โค้งมน */
            padding: 20px; /* ระยะห่างขอบ */
            box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.75); /* เส้นเรืองแสง 3 มิติ */
        }
    </style>
</head>
<div class="f16-Query-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="panel-3d">
    <p>
    <?= Html::a('<i class="fa fa-arrow-circle-right" aria-hidden="true"></i> เพิ่มข้อมูล', ['create'], ['class' => 'btn btn-success']) ?>

    </p>
    <!-- <div class="well" style="background-color: #ffecff;"> -->
   

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
