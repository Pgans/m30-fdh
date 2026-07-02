<?php


use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'TextFile Homeward  สำหรับ CMI-Moph';
?>

<div class="site-import" style="background-color: #e8f5e9; padding: 20px; border-radius: 10px;">
    <h3><?= Html::encode($this->title) ?></h3>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success"><?= Yii::$app->session->getFlash('success') ?></div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger"><?= Yii::$app->session->getFlash('error') ?></div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="form-group">
        <?= $form->field($model, 'uploadFile')->fileInput(['accept' => '.zip']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Upload & Extract ZIP', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php if ($extractedPath): ?>
        <hr>
        <h4>ZIP extracted to: <code><?= $extractedPath ?></code></h4>

        <?= Html::beginForm(['importtxtproc/process'], 'post') ?>
            <?= Html::hiddenInput('extractedPath', $extractedPath) ?>
            <?= Html::submitButton('Import Text File', ['class' => 'btn btn-success']) ?>
        <?= Html::endForm() ?>
    <?php endif; ?>
</div>


<script>
document.getElementById('submit-button').addEventListener('click', function(event) {
    const fileInput = document.getElementById('file-input');
    if (!fileInput.value) {
        event.preventDefault(); // ป้องกันการส่งฟอร์ม
        alert('กรุณาเลือกไฟล์ก่อนส่ง!');
    }
});
</script>


