<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Meeting */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="well">
<div class="meeting-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <div class="col-md-3">
    <?= $form->field($model, 'attime')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
    <?= $form->field($model, 'date')->widget(DatePicker::className(),[
    'inline' => false,
    'clientOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd' 
    ]
  ]);?>
    </div>
    <div class="col-md-3">
    <?= $form->field($model, 'time')->textInput() ?>
    </div>
    <div class="col-md-3">
    <?= $form->field($model, 'user')->textInput(['maxlength' => true]) ?>
    </div>
    <!-- <?= $form->field($model, 'create_date')->textInput() ?> -->

    <div class="form-group">
    <?= Html::submitButton('<i class="glyphicon glyphicon-plus"></i> '.($model->isNewRecord ? 'บันทึก' : 'แก้ไข'), 
        ['class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-info').' btn-lg ' ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
