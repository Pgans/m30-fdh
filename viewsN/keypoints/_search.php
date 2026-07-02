<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\KeypointsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="keypoints-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'key_id') ?>

    <?= $form->field($model, 'agenda_id') ?>

    <?= $form->field($model, 'key_point') ?>

    <?= $form->field($model, 'show_work') ?>

    <?= $form->field($model, 'create_date') ?>

    <?php // echo $form->field($model, 'filename') ?>

    <?php // echo $form->field($model, 'link') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
