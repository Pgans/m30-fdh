<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Visitinvoice */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .gradient-background {
        background: linear-gradient(to bottom right, rgba(173, 216, 230, 0.7), rgba(255, 255, 255, 0.7)); /* ฟ้าอ่อน */
        border-radius: 8px; /* มุมมน */
        padding: 20px; /* ระยะห่างภายใน */
    }
</style>
<div class="box box-info box-solid gradient-background">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-users"></i> <?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div class="visitinvoice-form">

            <?php $form = ActiveForm::begin(); ?>
            <div class="col-md-5">
                <?= $form->field($model, 'visit_id')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-5">
                <?= $form->field($model, 'invoice')->textInput() ?>
            </div>
            <div class="col-md-5">
                <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-5">
                <?= $form->field($model, 'subtotal')->textInput() ?>
            </div>
            <div class="col-md-5">
                <?= $form->field($model, 'is_cancel')->textInput() ?>
            </div>

            <div class="col-md-5">
                <div class="form-group">
                    <?= Html::submitButton('<i class="glyphicon glyphicon-plus"></i> '.($model->isNewRecord ? 'บันทึกรายการ' : 'แก้ไข'), 
                        ['class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-info').' btn-lg ']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
