<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\categories;
use common\models\departments;
use dosamigos\datepicker\datepicker;

/* @var $this yii\web\View */
/* @var $model common\models\Devices */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="devices-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'device_serial')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'device_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(
    ArrayHelper::map(categories::find()->all(),'category_id','category_name'),
    ['prompt'=>'กรุณาเลือกประเภท']
    ) ?>

    <?= $form->field($model, 'dep_id')->dropDownList(
    ArrayHelper::map(departments::find()->all(), 'dep_id', 'dep_name'),
    ['prompt' => 'กรุณาเลือกแผนก']
    ) ?>

    <?= $form->field($model, 'spec')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'purchase_date')->widget(DatePicker::className(),[
        'inline' => false,
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
      ]);?>

    <?= $form->field($model, 'due_date')->widget(DatePicker::className(),[
        'inline' => false,
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
      ]);?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'sale_date')->widget(DatePicker::className(), [
      'inline' => false,
      'clientOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd'
        ]
      ]); ?>



    <?= $form->field($model, 'orther')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
