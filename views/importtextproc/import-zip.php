
<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Upload & Extract ZIP สำหรับ CMI-MOPH';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-import-zip" style="background-color: #eaffea; padding: 30px; border-radius: 12px; box-shadow: 0 0 12px #cfc;">
   
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger"><?= Yii::$app->session->getFlash('error') ?></div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'file')->fileInput()->label('เลือกไฟล์ ZIP') ?>

    <div class="form-group">
        <?= Html::submitButton('Upload & Extract ZIP', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
