<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Keypoints */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="keypoints-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'agenda_id')->textInput() ?>

    <?= $form->field($model, 'key_point')->textInput(['maxlength' => true]) ?>

    <!-- <?= $form->field($model, 'show_work')->textarea(['rows' => 6]) ?> -->

    <?= $form->field($model, 'create_date')->textInput() ?>

    <?= $form->field($model, 'agenda_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'file')->fileInput() ?>



    <!-- <?= $form->field($model, 'filename')->textInput(['maxlength' => true]) ?> -->
    <!-- <?= $form->field($model, 'filename')->fileInput() ?> -->

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Uploads'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
