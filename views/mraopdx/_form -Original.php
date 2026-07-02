<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Mraopd */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mraopd-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'unit_id')->textInput() ?>

    <?= $form->field($model, 'HN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'AN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dr_license')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_admit')->textInput() ?>

    <?= $form->field($model, 'date_discharge')->textInput() ?>

    <?= $form->field($model, 'date_audit')->textInput() ?>

    <?= $form->field($model, 'NA01')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MI01')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NO01')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC011')->textInput() ?>

    <?= $form->field($model, 'SC012')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC013')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC014')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC015')->textInput() ?>

    <?= $form->field($model, 'SC016')->textInput() ?>

    <?= $form->field($model, 'SC017')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC018')->textInput() ?>

    <?= $form->field($model, 'SC019')->textInput() ?>

    <?= $form->field($model, 'PEIM01')->textInput() ?>

    <?= $form->field($model, 'DEC01')->textInput() ?>

    <?= $form->field($model, 'NA02')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MI02')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NO02')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC021')->textInput() ?>

    <?= $form->field($model, 'SC022')->textInput() ?>

    <?= $form->field($model, 'SC023')->textInput() ?>

    <?= $form->field($model, 'SC024')->textInput() ?>

    <?= $form->field($model, 'SC025')->textInput() ?>

    <?= $form->field($model, 'SC026')->textInput() ?>

    <?= $form->field($model, 'SC027')->textInput() ?>

    <?= $form->field($model, 'SC028')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC029')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PEIM02')->textInput() ?>

    <?= $form->field($model, 'DEC02')->textInput() ?>

    <?= $form->field($model, 'NA03')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MI03')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NO03')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC031')->textInput() ?>

    <?= $form->field($model, 'SC032')->textInput() ?>

    <?= $form->field($model, 'SC033')->textInput() ?>

    <?= $form->field($model, 'SC034')->textInput() ?>

    <?= $form->field($model, 'SC035')->textInput() ?>

    <?= $form->field($model, 'SC036')->textInput() ?>

    <?= $form->field($model, 'SC037')->textInput() ?>

    <?= $form->field($model, 'SC038')->textInput() ?>

    <?= $form->field($model, 'SC039')->textInput() ?>

    <?= $form->field($model, 'PEIM03')->textInput() ?>

    <?= $form->field($model, 'DEC03')->textInput() ?>

    <?= $form->field($model, 'NA04')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MI04')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NO04')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC041')->textInput() ?>

    <?= $form->field($model, 'SC042')->textInput() ?>

    <?= $form->field($model, 'SC043')->textInput() ?>

    <?= $form->field($model, 'SC044')->textInput() ?>

    <?= $form->field($model, 'SC045')->textInput() ?>

    <?= $form->field($model, 'SC046')->textInput() ?>

    <?= $form->field($model, 'SC047')->textInput() ?>

    <?= $form->field($model, 'SC048')->textInput() ?>

    <?= $form->field($model, 'SC049')->textInput() ?>

    <?= $form->field($model, 'PEIM04')->textInput() ?>

    <?= $form->field($model, 'DEC04')->textInput() ?>

    <?= $form->field($model, 'NA05')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MI05')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NO05')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC051')->textInput() ?>

    <?= $form->field($model, 'SC052')->textInput() ?>

    <?= $form->field($model, 'SC053')->textInput() ?>

    <?= $form->field($model, 'SC054')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC055')->textInput() ?>

    <?= $form->field($model, 'SC056')->textInput() ?>

    <?= $form->field($model, 'SC057')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC058')->textInput() ?>

    <?= $form->field($model, 'SC059')->textInput() ?>

    <?= $form->field($model, 'PEIM05')->textInput() ?>

    <?= $form->field($model, 'DEC05')->textInput() ?>

    <?= $form->field($model, 'Followdate1')->textInput() ?>

    <?= $form->field($model, 'Followdate2')->textInput() ?>

    <?= $form->field($model, 'NA06')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MI06')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NO06')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC061')->textInput() ?>

    <?= $form->field($model, 'SC062')->textInput() ?>

    <?= $form->field($model, 'SC063')->textInput() ?>

    <?= $form->field($model, 'SC064')->textInput() ?>

    <?= $form->field($model, 'SC065')->textInput() ?>

    <?= $form->field($model, 'SC066')->textInput() ?>

    <?= $form->field($model, 'SC067')->textInput() ?>

    <?= $form->field($model, 'SC068')->textInput() ?>

    <?= $form->field($model, 'SC069')->textInput() ?>

    <?= $form->field($model, 'PEIM06')->textInput() ?>

    <?= $form->field($model, 'DEC06')->textInput() ?>

    <?= $form->field($model, 'Followdate3')->textInput() ?>

    <?= $form->field($model, 'NA70')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MI07')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NO07')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC071')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC072')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC073')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC074')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC075')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC076')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC077')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC078')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC079')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PEIM07')->textInput() ?>

    <?= $form->field($model, 'DEC07')->textInput() ?>

    <?= $form->field($model, 'NA08')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MI08')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NO08')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC081')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC082')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC083')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC084')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC085')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC086')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC087')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC088')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC089')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PEIM08')->textInput() ?>

    <?= $form->field($model, 'DEC08')->textInput() ?>

    <?= $form->field($model, 'NA09')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MI09')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NO09')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC091')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC092')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC093')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC094')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC095')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC096')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC097')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC098')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC099')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PEIM09')->textInput() ?>

    <?= $form->field($model, 'DEC09')->textInput() ?>

    <?= $form->field($model, 'NA10')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MI10')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NO10')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC101')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC102')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC103')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC104')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC105')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC106')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC107')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC108')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SC109')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PEIM10')->textInput() ?>

    <?= $form->field($model, 'DEC10')->textInput() ?>

    <?= $form->field($model, 'hospcode')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
