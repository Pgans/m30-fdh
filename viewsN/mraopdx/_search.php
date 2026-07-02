<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MraopdSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mraopd-search">

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

    <?php // echo $form->field($model, 'NA01') ?>

    <?php // echo $form->field($model, 'MI01') ?>

    <?php // echo $form->field($model, 'NO01') ?>

    <?php // echo $form->field($model, 'SC011') ?>

    <?php // echo $form->field($model, 'SC012') ?>

    <?php // echo $form->field($model, 'SC013') ?>

    <?php // echo $form->field($model, 'SC014') ?>

    <?php // echo $form->field($model, 'SC015') ?>

    <?php // echo $form->field($model, 'SC016') ?>

    <?php // echo $form->field($model, 'SC017') ?>

    <?php // echo $form->field($model, 'SC018') ?>

    <?php // echo $form->field($model, 'SC019') ?>

    <?php // echo $form->field($model, 'PEIM01') ?>

    <?php // echo $form->field($model, 'DEC01') ?>

    <?php // echo $form->field($model, 'NA02') ?>

    <?php // echo $form->field($model, 'MI02') ?>

    <?php // echo $form->field($model, 'NO02') ?>

    <?php // echo $form->field($model, 'SC021') ?>

    <?php // echo $form->field($model, 'SC022') ?>

    <?php // echo $form->field($model, 'SC023') ?>

    <?php // echo $form->field($model, 'SC024') ?>

    <?php // echo $form->field($model, 'SC025') ?>

    <?php // echo $form->field($model, 'SC026') ?>

    <?php // echo $form->field($model, 'SC027') ?>

    <?php // echo $form->field($model, 'SC028') ?>

    <?php // echo $form->field($model, 'SC029') ?>

    <?php // echo $form->field($model, 'PEIM02') ?>

    <?php // echo $form->field($model, 'DEC02') ?>

    <?php // echo $form->field($model, 'NA03') ?>

    <?php // echo $form->field($model, 'MI03') ?>

    <?php // echo $form->field($model, 'NO03') ?>

    <?php // echo $form->field($model, 'SC031') ?>

    <?php // echo $form->field($model, 'SC032') ?>

    <?php // echo $form->field($model, 'SC033') ?>

    <?php // echo $form->field($model, 'SC034') ?>

    <?php // echo $form->field($model, 'SC035') ?>

    <?php // echo $form->field($model, 'SC036') ?>

    <?php // echo $form->field($model, 'SC037') ?>

    <?php // echo $form->field($model, 'SC038') ?>

    <?php // echo $form->field($model, 'SC039') ?>

    <?php // echo $form->field($model, 'PEIM03') ?>

    <?php // echo $form->field($model, 'DEC03') ?>

    <?php // echo $form->field($model, 'NA04') ?>

    <?php // echo $form->field($model, 'MI04') ?>

    <?php // echo $form->field($model, 'NO04') ?>

    <?php // echo $form->field($model, 'SC041') ?>

    <?php // echo $form->field($model, 'SC042') ?>

    <?php // echo $form->field($model, 'SC043') ?>

    <?php // echo $form->field($model, 'SC044') ?>

    <?php // echo $form->field($model, 'SC045') ?>

    <?php // echo $form->field($model, 'SC046') ?>

    <?php // echo $form->field($model, 'SC047') ?>

    <?php // echo $form->field($model, 'SC048') ?>

    <?php // echo $form->field($model, 'SC049') ?>

    <?php // echo $form->field($model, 'PEIM04') ?>

    <?php // echo $form->field($model, 'DEC04') ?>

    <?php // echo $form->field($model, 'NA05') ?>

    <?php // echo $form->field($model, 'MI05') ?>

    <?php // echo $form->field($model, 'NO05') ?>

    <?php // echo $form->field($model, 'SC051') ?>

    <?php // echo $form->field($model, 'SC052') ?>

    <?php // echo $form->field($model, 'SC053') ?>

    <?php // echo $form->field($model, 'SC054') ?>

    <?php // echo $form->field($model, 'SC055') ?>

    <?php // echo $form->field($model, 'SC056') ?>

    <?php // echo $form->field($model, 'SC057') ?>

    <?php // echo $form->field($model, 'SC058') ?>

    <?php // echo $form->field($model, 'SC059') ?>

    <?php // echo $form->field($model, 'PEIM05') ?>

    <?php // echo $form->field($model, 'DEC05') ?>

    <?php // echo $form->field($model, 'Followdate1') ?>

    <?php // echo $form->field($model, 'Followdate2') ?>

    <?php // echo $form->field($model, 'NA06') ?>

    <?php // echo $form->field($model, 'MI06') ?>

    <?php // echo $form->field($model, 'NO06') ?>

    <?php // echo $form->field($model, 'SC061') ?>

    <?php // echo $form->field($model, 'SC062') ?>

    <?php // echo $form->field($model, 'SC063') ?>

    <?php // echo $form->field($model, 'SC064') ?>

    <?php // echo $form->field($model, 'SC065') ?>

    <?php // echo $form->field($model, 'SC066') ?>

    <?php // echo $form->field($model, 'SC067') ?>

    <?php // echo $form->field($model, 'SC068') ?>

    <?php // echo $form->field($model, 'SC069') ?>

    <?php // echo $form->field($model, 'PEIM06') ?>

    <?php // echo $form->field($model, 'DEC06') ?>

    <?php // echo $form->field($model, 'Followdate3') ?>

    <?php // echo $form->field($model, 'NA70') ?>

    <?php // echo $form->field($model, 'MI07') ?>

    <?php // echo $form->field($model, 'NO07') ?>

    <?php // echo $form->field($model, 'SC071') ?>

    <?php // echo $form->field($model, 'SC072') ?>

    <?php // echo $form->field($model, 'SC073') ?>

    <?php // echo $form->field($model, 'SC074') ?>

    <?php // echo $form->field($model, 'SC075') ?>

    <?php // echo $form->field($model, 'SC076') ?>

    <?php // echo $form->field($model, 'SC077') ?>

    <?php // echo $form->field($model, 'SC078') ?>

    <?php // echo $form->field($model, 'SC079') ?>

    <?php // echo $form->field($model, 'PEIM07') ?>

    <?php // echo $form->field($model, 'DEC07') ?>

    <?php // echo $form->field($model, 'NA08') ?>

    <?php // echo $form->field($model, 'MI08') ?>

    <?php // echo $form->field($model, 'NO08') ?>

    <?php // echo $form->field($model, 'SC081') ?>

    <?php // echo $form->field($model, 'SC082') ?>

    <?php // echo $form->field($model, 'SC083') ?>

    <?php // echo $form->field($model, 'SC084') ?>

    <?php // echo $form->field($model, 'SC085') ?>

    <?php // echo $form->field($model, 'SC086') ?>

    <?php // echo $form->field($model, 'SC087') ?>

    <?php // echo $form->field($model, 'SC088') ?>

    <?php // echo $form->field($model, 'SC089') ?>

    <?php // echo $form->field($model, 'PEIM08') ?>

    <?php // echo $form->field($model, 'DEC08') ?>

    <?php // echo $form->field($model, 'NA09') ?>

    <?php // echo $form->field($model, 'MI09') ?>

    <?php // echo $form->field($model, 'NO09') ?>

    <?php // echo $form->field($model, 'SC091') ?>

    <?php // echo $form->field($model, 'SC092') ?>

    <?php // echo $form->field($model, 'SC093') ?>

    <?php // echo $form->field($model, 'SC094') ?>

    <?php // echo $form->field($model, 'SC095') ?>

    <?php // echo $form->field($model, 'SC096') ?>

    <?php // echo $form->field($model, 'SC097') ?>

    <?php // echo $form->field($model, 'SC098') ?>

    <?php // echo $form->field($model, 'SC099') ?>

    <?php // echo $form->field($model, 'PEIM09') ?>

    <?php // echo $form->field($model, 'DEC09') ?>

    <?php // echo $form->field($model, 'NA10') ?>

    <?php // echo $form->field($model, 'MI10') ?>

    <?php // echo $form->field($model, 'NO10') ?>

    <?php // echo $form->field($model, 'SC101') ?>

    <?php // echo $form->field($model, 'SC102') ?>

    <?php // echo $form->field($model, 'SC103') ?>

    <?php // echo $form->field($model, 'SC104') ?>

    <?php // echo $form->field($model, 'SC105') ?>

    <?php // echo $form->field($model, 'SC106') ?>

    <?php // echo $form->field($model, 'SC107') ?>

    <?php // echo $form->field($model, 'SC108') ?>

    <?php // echo $form->field($model, 'SC109') ?>

    <?php // echo $form->field($model, 'PEIM10') ?>

    <?php // echo $form->field($model, 'DEC10') ?>

    <?php // echo $form->field($model, 'hospcode') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
