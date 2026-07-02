<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MraipdSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mraipd-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'mra_id') ?>

    <?= $form->field($model, 'unit_id') ?>

    <?= $form->field($model, 'HN') ?>

    <?= $form->field($model, 'AN') ?>

    <?= $form->field($model, 'dr_license') ?>

    <?php // echo $form->field($model, 'date_admit') ?>

    <?php // echo $form->field($model, 'date_discharge') ?>

    <?php // echo $form->field($model, 'date_audit') ?>

    <?php // echo $form->field($model, 'NA1') ?>

    <?php // echo $form->field($model, 'Missing1') ?>

    <?php // echo $form->field($model, 'No1') ?>

    <?php // echo $form->field($model, 'dxop1') ?>

    <?php // echo $form->field($model, 'dxop2') ?>

    <?php // echo $form->field($model, 'dxop3') ?>

    <?php // echo $form->field($model, 'dxop4') ?>

    <?php // echo $form->field($model, 'dxop5') ?>

    <?php // echo $form->field($model, 'dxop6') ?>

    <?php // echo $form->field($model, 'dxop7') ?>

    <?php // echo $form->field($model, 'dxop8') ?>

    <?php // echo $form->field($model, 'dxop9') ?>

    <?php // echo $form->field($model, 'dxop_huk') ?>

    <?php // echo $form->field($model, 'NA2') ?>

    <?php // echo $form->field($model, 'Missing2') ?>

    <?php // echo $form->field($model, 'No2') ?>

    <?php // echo $form->field($model, 'other1') ?>

    <?php // echo $form->field($model, 'other2') ?>

    <?php // echo $form->field($model, 'other3') ?>

    <?php // echo $form->field($model, 'other4') ?>

    <?php // echo $form->field($model, 'other5') ?>

    <?php // echo $form->field($model, 'other6') ?>

    <?php // echo $form->field($model, 'other7') ?>

    <?php // echo $form->field($model, 'other8') ?>

    <?php // echo $form->field($model, 'other9') ?>

    <?php // echo $form->field($model, 'other_huk') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
