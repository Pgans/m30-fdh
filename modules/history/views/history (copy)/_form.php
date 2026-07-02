<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Devices;
use common\models\Departments;
/* @var $this yii\web\View */
/* @var $model common\models\History */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="history-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-3">
    <?= $form->field($model, 'devices_device_id')->dropDownList(
        ArrayHelper::map(devices::find()->all(),'device_id','device_serial'),
        ['prompt'=>'กรุณาเลือกรหัสอุปกรณ์']
        ) ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'dep_id')->dropDownList(
        ArrayHelper::map(departments::find()->all(),'dep_id','dep_name'),
        ['prompt'=>'กรุณาเลือกแผนกที่ย้ายใหม่']
        ) ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
