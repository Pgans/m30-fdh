<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VisitinvoiceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="visitinvoice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'visit_id') ?>

    <?= $form->field($model, 'record_dt') ?>

    <?= $form->field($model, 'order1') ?>

    <?= $form->field($model, 'order2') ?>

    <?= $form->field($model, 'order3') ?>

    <?php // echo $form->field($model, 'item') ?>

    <?php // echo $form->field($model, 'invoice') ?>

    <?php // echo $form->field($model, 'is_refund') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'subtotal') ?>

    <?php // echo $form->field($model, 'ctype') ?>

    <?php // echo $form->field($model, 'cfield') ?>

    <?php // echo $form->field($model, 'drug_id') ?>

    <?php // echo $form->field($model, 'opbills') ?>

    <?php // echo $form->field($model, 'is_psc') ?>

    <?php // echo $form->field($model, 'is_inv') ?>

    <?php // echo $form->field($model, 'is_rcp') ?>

    <?php // echo $form->field($model, 'base_rate') ?>

    <?php // echo $form->field($model, 'extra') ?>

    <?php // echo $form->field($model, 'unit_price') ?>

    <?php // echo $form->field($model, 'xl_id') ?>

    <?php // echo $form->field($model, 'lab_id') ?>

    <?php // echo $form->field($model, 'xray_code') ?>

    <?php // echo $form->field($model, 'type16') ?>

    <?php // echo $form->field($model, 'seq16') ?>

    <?php // echo $form->field($model, 'code16') ?>

    <?php // echo $form->field($model, 'hosp') ?>

    <?php // echo $form->field($model, 'chrgitem') ?>

    <?php // echo $form->field($model, 'ned_code') ?>

    <?php // echo $form->field($model, 'order_dt') ?>

    <?php // echo $form->field($model, 'is_cancel') ?>

    <?php // echo $form->field($model, 'auto_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
