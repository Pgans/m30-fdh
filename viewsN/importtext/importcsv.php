<?php


use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'นำเข้า CSV';
// Display the form
$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);

// File input field
echo $form->field($model, 'file')->fileInput();

// Submit button
echo Html::submitButton('Import CSV File', ['class' => 'btn btn-primary']);

// Close the form
ActiveForm::end();
?>
</br>
<div class="box box-info box-solid">
<div class ="box-header">
          <h3 class = "box-title"><i class="fa fa-users"></i> รายการข้อมูลนำเข้าแล้ว</h3>
            </div>
          <div class="box-body">
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

       // 'auto_id',
        'rep',
        //'id',
        'train_id',
        'hn',
        'an',
        'pid',
        'fullname',
        'main',
        'regdate',
        'discharge',
        //'ins',
        //'pp',
        //'errorcode',
        'sub',
        'd_update',

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
</div>