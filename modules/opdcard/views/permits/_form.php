<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Treatments;
use backend\models\Status;


/* @var $this yii\web\View */
/* @var $model backend\models\Permits */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="permits-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-3">
            <?= $form->field($model, 'AN')->textInput(['maxlength' => true]) ?>
          </div>
    <div class="col-md-3">
            <?= $form->field($model, 'HN')->textInput(['maxlength' => true]) ?>
          </div>
    <div class="col-md-3">
            <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>
          </div>
     <div class="col-md-3">
        <?= $form->field($model, 'treatments_id')->dropDownList(
        ArrayHelper::map(treatments::find()->all(),'id','treatment_name'),
        ['prompt'=>'กรุณาเลือกเพื่อใช้']
        ) ?>
          </div>
    <!--<div class="col-md-3">
        <?= $form->field($model, 'created_by')->textInput() ?>
        </div>
    <div class="col-md-3">
    <?= $form->field($model, 'created_at')->textInput() ?>
        </div>
    <div class="col-md-3">
    <?= $form->field($model, 'updated_by')->textInput() ?>
        </div>
    <div class="col-md-3">
    <?= $form->field($model, 'updated_at')->textInput() ?>-->
    
    <div class="col-md-3">
        <?= $form->field($model, 'status_id')->dropDownList(
        ArrayHelper::map(status::find()->all(),'id','status'),
        ['prompt'=>'กรุณาเลือกสถานะ']
        ) ?>
          </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'ตกลง' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <button class="btn btn-info" type="reset">ล้างข้อมูล</button>
    </div>

    <?php ActiveForm::end(); ?>

</div>
