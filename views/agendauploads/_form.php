<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Meetingagenda;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;


/* @var $this yii\web\View */
/* @var $model app\models\Agendauploads */
/* @var $form yii\widgets\ActiveForm */
?>
<?php 
//$upfileCat = Meetingagenda::find()->all();
//$listData = ArrayHelper::map($upfileCat, 'id', 'title');
?>
<div class="agendauploads-form">

    <?php $form = ActiveForm::begin(); ?>

    

    <?= $form->field($model, 'meeting_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'topic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <!-- <?= $form->field($model, 'filename')->textInput(['maxlength' => true]) ?> -->

    <?= $form->field($model, 'file')->fileInput() ?>

    <!-- <?= $form->field($model, 'path')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'create_date')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
