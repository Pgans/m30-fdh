 
<!-- import.php -->

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
]);

foreach ($model->files as $i => $file) {
    echo $form->field($model, "tables[$i]")->dropDownList([
        'table1' => 'Table 1',
        'table2' => 'Table 2',
        // Add more options for additional tables
    ], ['prompt' => 'Select a table']);

    echo $form->field($model, "files[$i]")->fileInput();
}

echo Html::submitButton('Import', ['class' => 'btn btn-primary']);

ActiveForm::end();





?>