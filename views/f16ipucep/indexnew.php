<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
//use common\models\RContributionIpd;
use yii\data\ActiveDataProvider;

$this->title = 'Convert Files';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['thaimed/index']];
// Define JavaScript function for selecting all checkboxes
$js = <<< JS
$(document).ready(function() {
    $('#select-all').on('click', function() {
        $('.checkbox').prop('checked', $(this).prop('checked'));
    });
});
JS;

$this->registerJs($js);
?>
<style>
    .well {
        background-color: #B7E1CD;
        color: darkgreen;
        font-size: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
    }

    .form-group {
        margin-right: 20px;
        flex: 1;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
    }

    .form-group .form-control {
        width: 100%;
    }

    .form-group:last-child {
        margin-right: 0;
    }

    .btn-submit {
        margin-left: 20px;
    }
</style>
<br>
<h2 style="color: white; font-size: 32px; background-color: #004646; border: 6px solid #8affc5;" class="badge">
New E-Claim IPD (16 แฟ้ม)
</h2>
<h3 class="text-center">
                                ข้อมูล 16 แฟ้มเลือกตาม Visit
                            </h3>


<!-- <p>16fdb = Yii::$app->db16</p> -->
<br>
    <div style="background-color: #126F30; padding: 10px; border: 0px solid #D4F1F5;">
    <font color="white" size="5">[สิทธิ์ประกันสุขภาพ UCS]</font> 

</div>


<div class='well' style="background-color: #B7E1CD;color: darkgreen; font-size: 16px;">

    <div class="form-group">
        <label for="date1">ระหว่างวันที่:</label>
        <?= yii\jui\DatePicker::widget([
            'name' => 'date1',
            'value' => $date1,
            'language' => 'th',
            'dateFormat' => 'yyyy-MM-dd',
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
            ],
            'options' => ['class' => 'form-control']
        ]); ?>
    </div>

    <div class="form-group">
        <label for="date2">ถึงวันที่:</label>
        <?= yii\jui\DatePicker::widget([
            'name' => 'date2',
            'value' => $date2,
            'language' => 'th',
            'dateFormat' => 'yyyy-MM-dd',
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
            ],
            'options' => ['class' => 'form-control']
        ]); ?>
    </div>

    <div class="form-group btn-submit">
        <?= Html::submitButton('ตกลง', ['class' => 'btn btn-danger']) ?>
    </div>
</div>

<?= Html::checkbox('select-all', false, ['id' => 'select-all']) ?> <?= Html::label('Select All', 'select-all') ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\CheckboxColumn'],
        //'id',
        'hn',
        'an',
        'fullname',
        'age',
        'Diag',
        'admit',
        'dsc',
        'inscl',
        // Other columns...
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete}',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                        'title' => Yii::t('yii', 'View'),
                    ]);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                        'title' => Yii::t('yii', 'Update'),
                    ]);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'title' => Yii::t('yii', 'Delete'),
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                    ]);
                },
            ],
        ],
    ],
]); ?>

