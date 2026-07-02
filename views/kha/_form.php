<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
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

    
	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="col-md-4">
    <?= $form->field($model, 'workgroup_id')->dropDownList(
    ArrayHelper::map(Kworkgroups::find()->all(),'id','workgroup_name'),
    ['prompt'=>'ระบุกลุ่มงาน']
     ) ?>
    </div>

    <div class="col-md-4">
    <?= $form->field($model, 'document_id')->dropDownList(
    ArrayHelper::map(Kdocuments::find()->all(),'id','document_name'),
    ['prompt'=>'รหัสเอกสาร']
     ) ?>
    </div>

    <div class="col-md-4">
    <?= $form->field($model, 'team_id')->dropDownList(
    ArrayHelper::map(Kteams::find()->all(),'id','team_id'),
    ['prompt'=>'ระบุทีม HA']
     ) ?>
    </div>

    <div class="col-md-4">
    <?= $form->field($model, 'dep_id')->dropDownList(
    ArrayHelper::map(Kdepartments::find()->all(),'id','dep_name'),
    ['prompt'=>'ระบุทีมแผนก']
     ) ?>
    </div>
	<div class="col-md-8">
    <?= $form->field($model, 'ha_name')->textInput(['maxlength' => true]) ?>
	</div>
	
    <?= $form->field($model, 'filename')->textInput(['maxlength' => true]) ?> 
    
    <?= $form->field($model, 'file')->fileInput() ?>

   

    <div class="form-group">
    <?= Html::submitButton('<i class="glyphicon glyphicon-plus"></i> '.($model->isNewRecord ? 'บันทึก' : 'แก้ไข'), 
        ['class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-info').' btn-lg ']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
