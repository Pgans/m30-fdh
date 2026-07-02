<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Mraipd */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mraipd-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $form = ActiveForm::begin(); ?>
<div class="mraipd-form">

    <div class="well">
      <div class="row">
           <div class="col-md-2">
           <?= $form->field($model, 'hospcode')->textInput(['maxlength' => true,'value'=>'10953']) ?>
          </div>
          <div class="col-md-2">
          <?= $form->field($model, 'unit_id')->textInput() ?>
          </div>
          <div class="col-md-1">
          <?= $form->field($model, 'HN')->textInput(['maxlength' => true]) ?>
          </div>
          <div class="col-md-1">
          <?= $form->field($model, 'AN')->textInput(['maxlength' => true]) ?>
          </div>
          <!-- <div class="col-md-2">
          <?= $form->field($model, 'dr_license')->textInput(['maxlength' => true]) ?>
          </div> -->
          <div class="col-md-2">
          <?= $form->field($model, 'date_admit')->textInput() ?>
          </div>
          <div class="col-md-2">
          <?= $form->field($model, 'date_discharge')->textInput() ?>
          </div>
          <div class="col-md-2">
          <?= $form->field($model, 'date_audit')->textInput() ?>
          </div>
      </div>
    </div>
</div>


    <?= $form->field($model, 'NA1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Missing1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'No1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dxop1')->textInput() ?>

    <?= $form->field($model, 'dxop2')->textInput() ?>

    <?= $form->field($model, 'dxop3')->textInput() ?>

    <?= $form->field($model, 'dxop4')->textInput() ?>

    <?= $form->field($model, 'dxop5')->textInput() ?>

    <?= $form->field($model, 'dxop6')->textInput() ?>

    <?= $form->field($model, 'dxop7')->textInput() ?>

    <?= $form->field($model, 'dxop8')->textInput() ?>

    <?= $form->field($model, 'dxop9')->textInput() ?>

    <?= $form->field($model, 'dxop_huk')->textInput() ?>

    <?= $form->field($model, 'NA2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Missing2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'No2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'other1')->textInput() ?>

    <?= $form->field($model, 'other2')->textInput() ?>

    <?= $form->field($model, 'other3')->textInput() ?>

    <?= $form->field($model, 'other4')->textInput() ?>

    <?= $form->field($model, 'other5')->textInput() ?>

    <?= $form->field($model, 'other6')->textInput() ?>

    <?= $form->field($model, 'other7')->textInput() ?>

    <?= $form->field($model, 'other8')->textInput() ?>

    <?= $form->field($model, 'other9')->textInput() ?>

    <?= $form->field($model, 'other_huk')->textInput() ?>

    <?= $form->field($model, 'NA3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Missing3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'No3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'infc1')->textInput() ?>

    <?= $form->field($model, 'infc2')->textInput() ?>

    <?= $form->field($model, 'infc3')->textInput() ?>

    <?= $form->field($model, 'infc4')->textInput() ?>

    <?= $form->field($model, 'infc5')->textInput() ?>

    <?= $form->field($model, 'infc6')->textInput() ?>

    <?= $form->field($model, 'infc7')->textInput() ?>

    <?= $form->field($model, 'infc8')->textInput() ?>

    <?= $form->field($model, 'infc9')->textInput() ?>

    <?= $form->field($model, 'infc_huk')->textInput() ?>

    <?= $form->field($model, 'NA4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Missing4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'No4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hist1')->textInput() ?>

    <?= $form->field($model, 'hist2')->textInput() ?>

    <?= $form->field($model, 'hist3')->textInput() ?>

    <?= $form->field($model, 'hist4')->textInput() ?>

    <?= $form->field($model, 'hist5')->textInput() ?>

    <?= $form->field($model, 'hist6')->textInput() ?>

    <?= $form->field($model, 'hist7')->textInput() ?>

    <?= $form->field($model, 'hist8')->textInput() ?>

    <?= $form->field($model, 'hist9')->textInput() ?>

    <?= $form->field($model, 'hist_huk')->textInput() ?>

    <?= $form->field($model, 'NA5')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Missing5')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'No5')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pe1')->textInput() ?>

    <?= $form->field($model, 'pe2')->textInput() ?>

    <?= $form->field($model, 'pe3')->textInput() ?>

    <?= $form->field($model, 'pe4')->textInput() ?>

    <?= $form->field($model, 'pe5')->textInput() ?>

    <?= $form->field($model, 'pe6')->textInput() ?>

    <?= $form->field($model, 'pe7')->textInput() ?>

    <?= $form->field($model, 'pe8')->textInput() ?>

    <?= $form->field($model, 'pe9')->textInput() ?>

    <?= $form->field($model, 'pe_huk')->textInput() ?>

    <?= $form->field($model, 'NA6')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Missing6')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'No6')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pn1')->textInput() ?>

    <?= $form->field($model, 'pn2')->textInput() ?>

    <?= $form->field($model, 'pn3')->textInput() ?>

    <?= $form->field($model, 'pn4')->textInput() ?>

    <?= $form->field($model, 'pn5')->textInput() ?>

    <?= $form->field($model, 'pn6')->textInput() ?>

    <?= $form->field($model, 'pn7')->textInput() ?>

    <?= $form->field($model, 'pn8')->textInput() ?>

    <?= $form->field($model, 'pn9')->textInput() ?>

    <?= $form->field($model, 'pn_huk')->textInput() ?>

    <?= $form->field($model, 'NA7')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Missing7')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'No7')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cr1')->textInput() ?>

    <?= $form->field($model, 'cr2')->textInput() ?>

    <?= $form->field($model, 'cr3')->textInput() ?>

    <?= $form->field($model, 'cr4')->textInput() ?>

    <?= $form->field($model, 'cr5')->textInput() ?>

    <?= $form->field($model, 'cr6')->textInput() ?>

    <?= $form->field($model, 'cr7')->textInput() ?>

    <?= $form->field($model, 'cr8')->textInput() ?>

    <?= $form->field($model, 'cr9')->textInput() ?>

    <?= $form->field($model, 'cr_huk')->textInput() ?>

    <?= $form->field($model, 'NA8')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Missing8')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'No8')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ar1')->textInput() ?>

    <?= $form->field($model, 'ar2')->textInput() ?>

    <?= $form->field($model, 'ar3')->textInput() ?>

    <?= $form->field($model, 'ar4')->textInput() ?>

    <?= $form->field($model, 'ar5')->textInput() ?>

    <?= $form->field($model, 'ar6')->textInput() ?>

    <?= $form->field($model, 'ar7')->textInput() ?>

    <?= $form->field($model, 'ar8')->textInput() ?>

    <?= $form->field($model, 'ar9')->textInput() ?>

    <?= $form->field($model, 'ar_huk')->textInput() ?>

    <?= $form->field($model, 'NA9')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Missing9')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'No9')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'on1')->textInput() ?>

    <?= $form->field($model, 'on2')->textInput() ?>

    <?= $form->field($model, 'on3')->textInput() ?>

    <?= $form->field($model, 'on4')->textInput() ?>

    <?= $form->field($model, 'on5')->textInput() ?>

    <?= $form->field($model, 'on6')->textInput() ?>

    <?= $form->field($model, 'on7')->textInput() ?>

    <?= $form->field($model, 'on8')->textInput() ?>

    <?= $form->field($model, 'on9')->textInput() ?>

    <?= $form->field($model, 'on_huk')->textInput() ?>

    <?= $form->field($model, 'NA10')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Missing10')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'No10')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lr1')->textInput() ?>

    <?= $form->field($model, 'lr2')->textInput() ?>

    <?= $form->field($model, 'lr3')->textInput() ?>

    <?= $form->field($model, 'lr4')->textInput() ?>

    <?= $form->field($model, 'lr5')->textInput() ?>

    <?= $form->field($model, 'lr6')->textInput() ?>

    <?= $form->field($model, 'lr7')->textInput() ?>

    <?= $form->field($model, 'lr8')->textInput() ?>

    <?= $form->field($model, 'lr9')->textInput() ?>

    <?= $form->field($model, 'lr_huk')->textInput() ?>

    <?= $form->field($model, 'NA11')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Missing11')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'No11')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rr1')->textInput() ?>

    <?= $form->field($model, 'rr2')->textInput() ?>

    <?= $form->field($model, 'rr3')->textInput() ?>

    <?= $form->field($model, 'rr4')->textInput() ?>

    <?= $form->field($model, 'rr5')->textInput() ?>

    <?= $form->field($model, 'rr6')->textInput() ?>

    <?= $form->field($model, 'rr7')->textInput() ?>

    <?= $form->field($model, 'rr8')->textInput() ?>

    <?= $form->field($model, 'rr9')->textInput() ?>

    <?= $form->field($model, 'rr_huk')->textInput() ?>

    <?= $form->field($model, 'NA12')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Missing12')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'No12')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nn1')->textInput() ?>

    <?= $form->field($model, 'nn2')->textInput() ?>

    <?= $form->field($model, 'nn3')->textInput() ?>

    <?= $form->field($model, 'nn4')->textInput() ?>

    <?= $form->field($model, 'nn5')->textInput() ?>

    <?= $form->field($model, 'nn6')->textInput() ?>

    <?= $form->field($model, 'nn7')->textInput() ?>

    <?= $form->field($model, 'nn8')->textInput() ?>

    <?= $form->field($model, 'nn9')->textInput() ?>

    <?= $form->field($model, 'nn_huk')->textInput() ?>

    <?= $form->field($model, 'hospcode')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
