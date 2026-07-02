<?php

use app\models\Agendaitem;
use app\models\Agendas;
use app\models\Meetingagenda;
use app\models\Uploadfile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Uploadfile */
/* @var $form yii\widgets\ActiveForm */
?>
<?php 
$upfileCat = Agendaitem::find()->all();
$listData = ArrayHelper::map($upfileCat, 'agenda_id', 'topic');

?>
<div class="uploadfile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'file31')->fileInput() ?>

    <?= $form->field($model, 'meeting_id')->dropDownList(
        ArrayHelper::map(Meetingagenda::find()->all(),'id','title'),
        ['prompt'=>'เลือกหัวข้อการประชุม']
        ) ?>
   
    <?= $form->field($model, 'agenda_id')->dropDownList($listData); ?> 
   
    <?= $form->field($model, 'key_point')->textInput(['maxlength' => true]) ?>
    </div>                   
    <?= $form->field($model, 'show_work')->textarea(['rows' => 6]) ?>

    <!-- <?= $form->field($model, 'create_date')->textInput() ?> -->

    <!-- <?= $form->field($model, 'filename')->textInput(['maxlength' => true]) ?> -->


    <!-- <?= $form->field($model, 'path')->textInput(['maxlength' => true]) ?> -->

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
