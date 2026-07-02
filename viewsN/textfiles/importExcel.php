<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);

echo $form->field($model, 'excelFile')->fileInput();

echo Html::submitButton('Import', ['class' => 'btn btn-primary']);

ActiveForm::end();
