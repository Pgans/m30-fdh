<?php 
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

// ...

$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
echo $form->field($model, 'excelFile')->fileInput();
echo Html::submitButton('Import', ['class' => 'btn btn-primary']);
ActiveForm::end();



?>