<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Authenkiosk */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="authenkiosk-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hospcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visit_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'claimtype')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'claimcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dep_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'authen_date')->textInput() ?>

    <?= $form->field($model, 'd_update')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
