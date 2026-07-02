
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>

<?= $form->field($model, 'zip_file')->fileInput() ?>

<?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>

<?php ActiveForm::end(); ?>
