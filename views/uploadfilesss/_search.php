<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UploadfileSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="uploadfile-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'key_id') ?>

    <?= $form->field($model, 'agenda_id') ?>

    <?= $form->field($model, 'meeting_id') ?>

    <?= $form->field($model, 'key_point') ?>

    <?= $form->field($model, 'show_work') ?>

    <?php // echo $form->field($model, 'create_date') ?>

    <?php // echo $form->field($model, 'filename') ?>

    <?php // echo $form->field($model, 'path') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
