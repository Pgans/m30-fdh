<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\models\Teams;
use app\models\Kteams;
use app\models\Kdepartments;
use app\models\Kdocuments;
use app\models\Kworkgroups;



/* @var $this yii\web\View */
/* @var $model app\models\Kha */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kha-form">
 <div class="table-responsive">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-4">
    <?= $form->field($model, 'id')->dropDownList(
    ArrayHelper::map(Kdocuments::find()->all(),'id','document_name'),
    ['prompt'=>'รหัสเอกสาร']
     ) ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'id')->dropDownList(
    ArrayHelper::map(Kworkgroups::find()->all(),'id','workgroup_name'),
    ['prompt'=>'ระบุกลุ่มงาน']
     ) ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'team_id')->dropDownList(
    ArrayHelper::map(Kteams::find()->all(),'id','team_name'),
    ['prompt'=>'ระบุทีม HA']
     ) ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'id')->dropDownList(
    ArrayHelper::map(Kdepartments::find()->all(),'id','dep_name'),
    ['prompt'=>'ระบุทีมแผนก']
     ) ?>
    </div>
    
    <div class="col-md-4">
    <?= $form->field($model, 'ha_name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'filename')->textInput(['maxlength' => true]) ?>
    </div>
   
    <div class="col-md-4">
    <?= $form->field($model, 'is_update')->hiddenInput()->label(true) ?>
    </div>
    


    <div class="form-group">
    <?= Html::submitButton('<i class="glyphicon glyphicon-plus"></i> '.($model->isNewRecord ? 'บันทึก' : 'แก้ไข'), 
        ['class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-info').' btn-lg ']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

