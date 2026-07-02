<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Faculty;
use common\models\University;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Students */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="students-form">
    
     <?php $form = ActiveForm::begin(); ?>

     <div class="col-md-3"><?= $form->field($model, 'stud_id')->textInput() ?></div>

     <div class="col-md-3"><?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?></div>

     <div class="col-md-3"><?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?></div>

    <div class="col-md-3"> <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?></div>

     <div class="col-md-3"><?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?></div>

     <div class="col-md-3">
    <?= $form->field($model, 'faculty_id')->dropDownList(
    ArrayHelper::map(faculty::find()->all(),'faculty_id','faculty_name'),
    ['prompt'=>'กรุณาเลือกคณะวิชา']
    ) ?>
    </div>

     <div class="col-md-3">
    <?= $form->field($model, 'university_id')->dropDownList(
    ArrayHelper::map(university::find()->all(), 'university_id','university_name')
    ) ?>
    </div>

     <div class="col-md-3">
    <?= $form->field($model, 'train_at')->widget(DatePicker::className(), [
      'inline' => false,
      'clientOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd'
        ]
      ]) ?>
      </div>

       <div class="col-md-3">
    <?= $form->field($model, 'traint_out')->widget(DatePicker::className(), [
      'inline' => false,
      'clientOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd'
        ]
      ]) ?>
      </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
