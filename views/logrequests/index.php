<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogrequestsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'การพัฒนาปรับปรุงโปรแกรมส่ง FDH');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .gray-row {
        background-color: #f0f0f0; /* สีเทา */
    }
    .white-row {
        background-color: #ffffff; /* สีขาว */
    }
</style>

<div class="logrequests-index" style="background: linear-gradient(to right, #f1fbf8 , #fce3f9); padding: 20px; border-radius: 10px;">

    <h1 style="color: #5c4d8a;"><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fas fa-plus"></i> ' . Yii::t('app', 'บันทึกกิจกรรมการพัฒนา'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['class' => $index % 2 === 0 ? 'gray-row' : 'white-row']; // กำหนดสีพื้นหลังให้กับแต่ละแถว
        },
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],
            'id',
            'users',
            'action:ntext',
            'request_date',
            'developer_comments:ntext',
            'completion_date',
            [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Actions',
            'template' => '{view} {update}', // แสดงเฉพาะปุ่มดูและแก้ไข
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('<i class="fas fa-eye"></i>', $url, [
                        'title' => Yii::t('app', 'View'),
                        'class' => 'btn btn-info btn-sm', // ปรับแต่งปุ่ม
                    ]);
                },
                'update' => function ($url, $model) {
                    return Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                        'title' => Yii::t('app', 'Update'),
                        'class' => 'btn btn-warning btn-sm', // ปรับแต่งปุ่ม
                    ]);
                },
            ],
        ],
    ],
]); ?>
       
</div>

<!-- เพิ่มการโหลด Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
