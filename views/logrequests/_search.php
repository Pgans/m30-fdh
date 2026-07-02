<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogrequestsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="logrequests-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'users') ?>

    <?= $form->field($model, 'action') ?>

    <?= $form->field($model, 'request_date') ?>

    <?= $form->field($model, 'developer_comments') ?>

    <?php // echo $form->field($model, 'completion_date') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
