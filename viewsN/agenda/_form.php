<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\date\DatePicker;
use dosamigos\ckeditor\CKEditor;
use app\models\Meeting;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Agenda */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="agenda-form">

    <?php $form = ActiveForm::begin(); ?>

    
   <?= $form->field($model, 'meeting_id')->dropDownList(
    ArrayHelper::map(Meeting::find()->all(), 'meeting_id', 'title'),
    ['prompt' => 'เลือกหัวขอการประชุม']
    ) ?>
   

   <?= $form->field($model, 'ref')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'topic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'discription')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'covenant')->widget(FileInput::classname(), [
    //'options' => ['accept' => 'image/*'],
    'pluginOptions' => [
        'initialPreview'=>$model->initialPreview($model->covenant,'covenant','file'),
        'initialPreviewConfig'=>$model->initialPreview($model->covenant,'covenant','config'),
        'allowedFileExtensions'=>['doc','docx','xls','xlsx','pdf'],
        'showPreview' => true,
        'showCaption' => true,
        'showRemove' => true,
        'showUpload' => false
     ]
    ]); ?>

    <!-- <?= $form->field($model, 'docs')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'create_date')->textInput() ?> -->

    <!-- <?= $form->field($model, 'view')->textInput() ?> -->

    <div class="form-group">
    <?= Html::submitButton('<i class="glyphicon glyphicon-plus"></i> '.($model->isNewRecord ? 'บันทึก' : 'แก้ไข'), 
        ['class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-info').' btn-lg ']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
