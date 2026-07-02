<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Devices;
use common\models\Store;
use dosamigos\datepicker\datepicker;


/* @var $this yii\web\View */
/* @var $model common\models\Serviceout */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="serviceout-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'device_id')->dropDownList(
    ArrayHelper::map(Devices::find()->all(),'device_id','device_name'),
    ['prompt'=>'กรุณาเลือกอุปกรณ์']
    ) ?>

    <?= $form->field($model, 'symptom')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_sent')->widget(DatePicker::className(),[
        'inline' => false,
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
      ]);?>

    <?= $form->field($model, 'date_in')->widget(DatePicker::className(),[
        'inline' => false,
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
      ]);?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'orther')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'store_id')->dropDownList(
    ArrayHelper::map(Store::find()->all(),'store_id','store_name'),
    ['prompt'=>'กรุณาเลือกร้านค้า์']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-info' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
