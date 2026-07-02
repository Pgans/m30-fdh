<?php

use app\models\Agendaitem;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Meetingagenda;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Uploadfile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="uploadfile-form">

    <?php $form = ActiveForm::begin(); ?>

    
    <?= $form->field($model, 'file')->fileInput() ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'meeting_id')->dropDownList(
        ArrayHelper::map(Meetingagenda::find()->all(),'id','title'),
        ['prompt'=>'การประชุม']
        ) ?>
     <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'agenda_id')->dropDownList(
        ArrayHelper::map(Agendaitem::find()->all(),'agenda_id','topic'),
        ['prompt'=>'วาระการประชุม']
        ) ?>

    <?= $form->field($model, 'key_point')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'show_work')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'create_date')->textInput() ?>

    <?= $form->field($model, 'filename')->textInput(['maxlength' => true]) ?>

   

    <?= $form->field($model, 'path')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
