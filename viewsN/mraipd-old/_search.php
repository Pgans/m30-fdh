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
        'options' => [
            'data-pjax' => 1
        ],
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

    <?php // echo $form->field($model, 'NA3') ?>

    <?php // echo $form->field($model, 'Missing3') ?>

    <?php // echo $form->field($model, 'No3') ?>

    <?php // echo $form->field($model, 'infc1') ?>

    <?php // echo $form->field($model, 'infc2') ?>

    <?php // echo $form->field($model, 'infc3') ?>

    <?php // echo $form->field($model, 'infc4') ?>

    <?php // echo $form->field($model, 'infc5') ?>

    <?php // echo $form->field($model, 'infc6') ?>

    <?php // echo $form->field($model, 'infc7') ?>

    <?php // echo $form->field($model, 'infc8') ?>

    <?php // echo $form->field($model, 'infc9') ?>

    <?php // echo $form->field($model, 'infc_huk') ?>

    <?php // echo $form->field($model, 'NA4') ?>

    <?php // echo $form->field($model, 'Missing4') ?>

    <?php // echo $form->field($model, 'No4') ?>

    <?php // echo $form->field($model, 'hist1') ?>

    <?php // echo $form->field($model, 'hist2') ?>

    <?php // echo $form->field($model, 'hist3') ?>

    <?php // echo $form->field($model, 'hist4') ?>

    <?php // echo $form->field($model, 'hist5') ?>

    <?php // echo $form->field($model, 'hist6') ?>

    <?php // echo $form->field($model, 'hist7') ?>

    <?php // echo $form->field($model, 'hist8') ?>

    <?php // echo $form->field($model, 'hist9') ?>

    <?php // echo $form->field($model, 'hist_huk') ?>

    <?php // echo $form->field($model, 'NA5') ?>

    <?php // echo $form->field($model, 'Missing5') ?>

    <?php // echo $form->field($model, 'No5') ?>

    <?php // echo $form->field($model, 'pe1') ?>

    <?php // echo $form->field($model, 'pe2') ?>

    <?php // echo $form->field($model, 'pe3') ?>

    <?php // echo $form->field($model, 'pe4') ?>

    <?php // echo $form->field($model, 'pe5') ?>

    <?php // echo $form->field($model, 'pe6') ?>

    <?php // echo $form->field($model, 'pe7') ?>

    <?php // echo $form->field($model, 'pe8') ?>

    <?php // echo $form->field($model, 'pe9') ?>

    <?php // echo $form->field($model, 'pe_huk') ?>

    <?php // echo $form->field($model, 'NA6') ?>

    <?php // echo $form->field($model, 'Missing6') ?>

    <?php // echo $form->field($model, 'No6') ?>

    <?php // echo $form->field($model, 'pn1') ?>

    <?php // echo $form->field($model, 'pn2') ?>

    <?php // echo $form->field($model, 'pn3') ?>

    <?php // echo $form->field($model, 'pn4') ?>

    <?php // echo $form->field($model, 'pn5') ?>

    <?php // echo $form->field($model, 'pn6') ?>

    <?php // echo $form->field($model, 'pn7') ?>

    <?php // echo $form->field($model, 'pn8') ?>

    <?php // echo $form->field($model, 'pn9') ?>

    <?php // echo $form->field($model, 'pn_huk') ?>

    <?php // echo $form->field($model, 'NA7') ?>

    <?php // echo $form->field($model, 'Missing7') ?>

    <?php // echo $form->field($model, 'No7') ?>

    <?php // echo $form->field($model, 'cr1') ?>

    <?php // echo $form->field($model, 'cr2') ?>

    <?php // echo $form->field($model, 'cr3') ?>

    <?php // echo $form->field($model, 'cr4') ?>

    <?php // echo $form->field($model, 'cr5') ?>

    <?php // echo $form->field($model, 'cr6') ?>

    <?php // echo $form->field($model, 'cr7') ?>

    <?php // echo $form->field($model, 'cr8') ?>

    <?php // echo $form->field($model, 'cr9') ?>

    <?php // echo $form->field($model, 'cr_huk') ?>

    <?php // echo $form->field($model, 'NA8') ?>

    <?php // echo $form->field($model, 'Missing8') ?>

    <?php // echo $form->field($model, 'No8') ?>

    <?php // echo $form->field($model, 'ar1') ?>

    <?php // echo $form->field($model, 'ar2') ?>

    <?php // echo $form->field($model, 'ar3') ?>

    <?php // echo $form->field($model, 'ar4') ?>

    <?php // echo $form->field($model, 'ar5') ?>

    <?php // echo $form->field($model, 'ar6') ?>

    <?php // echo $form->field($model, 'ar7') ?>

    <?php // echo $form->field($model, 'ar8') ?>

    <?php // echo $form->field($model, 'ar9') ?>

    <?php // echo $form->field($model, 'ar_huk') ?>

    <?php // echo $form->field($model, 'NA9') ?>

    <?php // echo $form->field($model, 'Missing9') ?>

    <?php // echo $form->field($model, 'No9') ?>

    <?php // echo $form->field($model, 'on1') ?>

    <?php // echo $form->field($model, 'on2') ?>

    <?php // echo $form->field($model, 'on3') ?>

    <?php // echo $form->field($model, 'on4') ?>

    <?php // echo $form->field($model, 'on5') ?>

    <?php // echo $form->field($model, 'on6') ?>

    <?php // echo $form->field($model, 'on7') ?>

    <?php // echo $form->field($model, 'on8') ?>

    <?php // echo $form->field($model, 'on9') ?>

    <?php // echo $form->field($model, 'on_huk') ?>

    <?php // echo $form->field($model, 'NA10') ?>

    <?php // echo $form->field($model, 'Missing10') ?>

    <?php // echo $form->field($model, 'No10') ?>

    <?php // echo $form->field($model, 'lr1') ?>

    <?php // echo $form->field($model, 'lr2') ?>

    <?php // echo $form->field($model, 'lr3') ?>

    <?php // echo $form->field($model, 'lr4') ?>

    <?php // echo $form->field($model, 'lr5') ?>

    <?php // echo $form->field($model, 'lr6') ?>

    <?php // echo $form->field($model, 'lr7') ?>

    <?php // echo $form->field($model, 'lr8') ?>

    <?php // echo $form->field($model, 'lr9') ?>

    <?php // echo $form->field($model, 'lr_huk') ?>

    <?php // echo $form->field($model, 'NA11') ?>

    <?php // echo $form->field($model, 'Missing11') ?>

    <?php // echo $form->field($model, 'No11') ?>

    <?php // echo $form->field($model, 'rr1') ?>

    <?php // echo $form->field($model, 'rr2') ?>

    <?php // echo $form->field($model, 'rr3') ?>

    <?php // echo $form->field($model, 'rr4') ?>

    <?php // echo $form->field($model, 'rr5') ?>

    <?php // echo $form->field($model, 'rr6') ?>

    <?php // echo $form->field($model, 'rr7') ?>

    <?php // echo $form->field($model, 'rr8') ?>

    <?php // echo $form->field($model, 'rr9') ?>

    <?php // echo $form->field($model, 'rr_huk') ?>

    <?php // echo $form->field($model, 'NA12') ?>

    <?php // echo $form->field($model, 'Missing12') ?>

    <?php // echo $form->field($model, 'No12') ?>

    <?php // echo $form->field($model, 'nn1') ?>

    <?php // echo $form->field($model, 'nn2') ?>

    <?php // echo $form->field($model, 'nn3') ?>

    <?php // echo $form->field($model, 'nn4') ?>

    <?php // echo $form->field($model, 'nn5') ?>

    <?php // echo $form->field($model, 'nn6') ?>

    <?php // echo $form->field($model, 'nn7') ?>

    <?php // echo $form->field($model, 'nn8') ?>

    <?php // echo $form->field($model, 'nn9') ?>

    <?php // echo $form->field($model, 'nn_huk') ?>

    <?php // echo $form->field($model, 'hospcode') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
