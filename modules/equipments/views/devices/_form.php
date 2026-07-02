<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Categories;
use common\models\Departments;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Devices */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="devices-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-4">
    <?= $form->field($model, 'device_serial')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-4">
    <?= $form->field($model, 'device_name')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-4">
    <?= $form->field($model, 'category_id')->dropDownList(
    ArrayHelper::map(Categories::find()->all(),'category_id','category_name'),
    ['prompt'=>'กรุณาเลือกประเภท']
    ) ?>
    </div>

    <div class="col-md-4">
    <?= $form->field($model, 'dep_id')->dropDownList(
    ArrayHelper::map(departments::find()->all(), 'dep_id', 'dep_name'),
    ['prompt' => 'กรุณาเลือกแผนก']
    ) ?>
    </div>
    
    <div class="col-md-4">
    <?= $form->field($model, 'spec')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-4">
    <?= $form->field($model, 'purchase_date')->widget(DatePicker::className(),[
        'inline' => false,
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
      ]);?>
      </div>

      <div class="col-md-4">
    <?= $form->field($model, 'due_date')->widget(DatePicker::className(),[
        'inline' => false,
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
      ]);?>
      </div>

    <div class="col-md-4">
    <?= $form->field($model, 'price')->textInput() ?>
    </div>
    
    <div class="col-md-4">
    <?= $form->field($model, 'sale_date')->widget(DatePicker::className(), [
      'inline' => false,
      'clientOptions' => [
        'autoclose' => true,
        'format' => '0000-00-00'
        ]
      ]); ?>
      </div>

    <?= $form->field($model, 'orther')->textInput(['maxlength' => true]) ?>
    
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>

</div>
