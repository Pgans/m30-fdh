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

?>
<br>
<style>
    .btn-pink {
        background-color: #958beb;
        /* ตั้งค่าสีพื้นหลังเป็นม่วง */
        color: white;
        /* ตั้งค่าสีของตัวหนังสือเป็นขาว */
    }
</style>

<div style="background-color: #126F30; padding: 10px; border: 0px solid #D4F1F5;">
    <font color="white" size="5"><i class='fas fa-bed'></i> ผู้ป่วยใน สิทธิ์ประกันสุขภาพ [UCS] 16 แฟ้ม New E-claim</font> 
    <p style="color: yellow;">16fdb = Yii::$app->db16 โรงพยาบาลม่วงสามสิบ</p>
</div>
<h5 style="color: green;"><i class="fas fa-user"></i> ข้อมูล 16 แฟ้มผู้ป่วยในเลือกตาม AN </h5>



<div class="well" style="border: 2px solid #4CAF50;">
<div class='card-body'>
    <form action="/your-action-url" method="post" style="display: flex; align-items: center;">
        <div class="form-group" style="margin-right: 10px;">
            <label for="inputText">เลขผู้ป่วยใน:</label>
            <?= Html::input('text', 'an', '', ['class' => 'form-control', 'maxlength' => 10]) ?> 
    </div>
    <?= Html::submitButton('<i class="fas fa-bullseye"></i> ตกลง', ['class' => 'btn btn', 'style' => 'background-color: #8175e8; color: white; margin-left: 10px;']) ?>
        
    </form>
</div>
<?php 
echo GridView::widget([
    'dataProvider' => $dataProvider, // ใส่ DataProvider ที่คุณสร้างไว้
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'], // เพิ่มคอลัมน์นับลำดับ
        'column1', // เพิ่มคอลัมน์ที่ต้องการแสดงข้อมูล
        'column2',
        // เพิ่มคอลัมน์เพิ่มเติมตามต้องการ
        [
            'class' => 'yii\grid\ActionColumn', // เพิ่มคอลัมน์ดำเนินการ
            'template' => '{view} {update} {delete}', // ระบุปุ่มที่ต้องการแสดง
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
]);

?>


</div>








