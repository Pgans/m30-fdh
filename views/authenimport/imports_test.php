<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Import Excel';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->field($modelImport, 'fileImport')->fileInput() ?>

<div class="form-group">
    <?= Html::submitButton('นำเข้าไฟล์', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
