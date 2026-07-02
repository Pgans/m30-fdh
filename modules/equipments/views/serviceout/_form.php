<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Devices;
use common\models\Store;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Serviceout */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="serviceout-form">

    <?php $form = ActiveForm::begin(); ?>

        <div class="col-md-4">
        <?= $form->field($model, 'device_id')->dropDownList(
        ArrayHelper::map(Devices::find()->all(),'device_id','device_serial'),
        ['prompt'=>'กรุณาเลือกอุปกรณ์']
        ) ?>
        </div>

        <div class="col-md-4">
        <?= $form->field($model, 'symptom')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-4">
        <?= $form->field($model, 'date_sent')->widget(DatePicker::className(),[
            'inline' => false,
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
          ]);?>
          </div>

          <div class="col-md-4">
          <?= $form->field($model, 'date_in')->widget(DatePicker::className(),[
              'inline' => false,
              'clientOptions' => [
                  'autoclose' => true,
                  'format' => 'yyyy-mm-dd'
              ]
            ]);?>
            </div>

        <div class="col-md-4">
        <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
          </div>

        <div class="col-md-4">
        <?= $form->field($model, 'orther')->textInput(['maxlength' => true]) ?>
         </div>
         
        <?= $form->field($model, 'store_id')->dropDownList(
        ArrayHelper::map(Store::find()->all(),'store_id','store_name'),
        ['prompt'=>'กรุณาเลือกร้านค้า์']
        ) ?>
       

        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        

    <?php ActiveForm::end(); ?>

</div>
