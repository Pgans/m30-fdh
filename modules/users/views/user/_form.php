<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-warning box-solid">
  <div class ="box-header">
          <h3 class = "box-title"><i class="fa fa-users"></i> <?= Html::encode($this->title) ?></h3>
            </div>
          <div class="box-body">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-6">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
          </div>
    
    <div class="col-md-6">
    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>
         </div>

    <div class="col-md-6">
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    <div class="col-md-6">
    <?= $form->field($model, 'status')->textInput() ?>
        </div>

    <?= $form->field($model, 'level_user')->dropDownList([ 'EMPLOYEE' => 'EMPLOYEE', 'USER' => 'USER', 'ADMIN' => 'ADMIN', '' => '', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
