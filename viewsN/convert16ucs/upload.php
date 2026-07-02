<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->field($model, 'uploadFiles[]')->fileInput(['multiple' => true]) ?>

<?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>



<div>
                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->field($model, 'uploadFiles[]')->fileInput(['multiple' => true]) ?>

<?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>
                        </div>


                        <?php  
                        $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);


// ใช้ fileInput() โดยตรง
echo $form->field($model, 'uploadFiles[]')->fileInput(['multiple' => true]);

echo Html::submitButton('Upload', ['class' => 'btn btn-primary']);

ActiveForm::end();
?>