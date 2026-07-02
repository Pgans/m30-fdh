<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Fdhanccare */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fdhanccare-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'main_table')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'main_query')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'd_update')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
