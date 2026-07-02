<?php 
use kartik\checkbox\CheckboxX;
use kartik\form\ActiveForm;
$form = ActiveForm::begin();
 
// Basic Checkbox X with ActiveForm. Check the model validation, when you set the value to null. 
// You can also navigate using keyboard navigation keys and use the `space bar` key to modify.
echo $form->field($model, 'status')->widget(CheckboxX::classname(), []); 
 
//