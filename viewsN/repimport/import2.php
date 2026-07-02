<?php 
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Import2';
// Display the form
$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);

// File input field
echo $form->field($model, 'file')->fileInput();

// Submit button
echo Html::submitButton('Import', ['class' => 'btn btn-primary']);

// Close the form
ActiveForm::end();

?>
<div class="repimport-index">
<div class="box box-primary box-solid">
<div class ="box-header">
          <h3 class = "box-title"><i class="fa fa-users"></i>รายการข้อมูลนำเข้าแล้ว</div>
          <div class="box-body">


    <?php
		echo GridView::widget([
        'dataProvider' =>$dataimport,
       // 'filterModel' => $searchModel,
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
           // 'discharge',
            'ins',
            //'pp',
            //'errorcode',
            'sub',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
