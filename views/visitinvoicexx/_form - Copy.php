<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Visitinvoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="visitinvoice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'visit_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'record_dt')->textInput() ?>

    <?= $form->field($model, 'order1')->textInput() ?>

    <?= $form->field($model, 'order2')->textInput() ?>

    <?= $form->field($model, 'order3')->textInput() ?>

    <?= $form->field($model, 'item')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invoice')->textInput() ?>

    <?= $form->field($model, 'is_refund')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subtotal')->textInput() ?>

    <?= $form->field($model, 'ctype')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cfield')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'drug_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'opbills')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_psc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_inv')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_rcp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'base_rate')->textInput() ?>

    <?= $form->field($model, 'extra')->textInput() ?>

    <?= $form->field($model, 'unit_price')->textInput() ?>

    <?= $form->field($model, 'xl_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lab_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'xray_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type16')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seq16')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code16')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hosp')->textInput() ?>

    <?= $form->field($model, 'chrgitem')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ned_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_dt')->textInput() ?>

    <?= $form->field($model, 'is_cancel')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
