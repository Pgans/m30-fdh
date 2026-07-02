<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Drugexport */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="drugexport-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'HOSPCODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SEQ')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DATE_SERV')->textInput() ?>

    <?= $form->field($model, 'CLINIC')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DIDSTD')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DNAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'AMOUNT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UNIT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UNIT_PACKING')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DRUGPRICE')->textInput() ?>

    <?= $form->field($model, 'DRUGCOST')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PROVIDER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'D_UPDATE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'USAGE_LINE1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'USAGE_LINE2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'USAGE_LINE3')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
