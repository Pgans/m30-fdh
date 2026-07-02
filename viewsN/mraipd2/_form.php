<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Mraipd */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mraipd-form">
    <table>
    <tr>
        <th>Content of medical record</th><th>NA (N)</th><th>Miss (M)</th><th>No (O)</th><th>ข้อที่1</th><th>ข้อที่2</th>
        <th>ข้อที่3</th><th>ข้อที่4</th><th>ข้อที่5</th><th>ข้อที่6</th><th>ข้อที่7</th><th>ข้อที่8</th><th>ข้อที่9</th><th>หัก</th>
    </tr>
    <?php $form = ActiveForm::begin(); ?>
     <div class="col-md-2">
    <?= $form->field($model, 'unit_id')->textInput() ?>
     </div>
    <div class="col-md-2">
    <?= $form->field($model, 'HN')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-2">
    <?= $form->field($model, 'AN')->textInput(['maxlength' => true]) ?>
    </div>
    <!-- <div class="col-md-2">
    <?= $form->field($model, 'dr_license')->textInput(['maxlength' => true]) ?>
    </div> -->
    <div class="col-md-2">
    <?= $form->field($model, 'date_admit')->textInput() ?>
    </div>
    <div class="col-md-2">
    <?= $form->field($model, 'date_discharge')->textInput() ?>
    </div>
    <div class="col-md-2">
    <?= $form->field($model, 'date_audit')->textInput() ?>
    </div>
    <div class="col-md-12">
    <tr>
            <!-- <td><?= $form->field($model, 'content_id')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td> -->
            <td style="nowrap">Discharge summary : Dx, Op</td>
            <td> <?= $form->field($model, 'NA1')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing1')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'No1')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'dxop1')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'dxop2')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'dxop3')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'dxop4')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'dxop5')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'dxop6')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'dxop7')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'dxop8')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'dxop9')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'dxop_huk')->textInput(['maxlength' => true,'value'=>'0'])->label(false) ?></td>
        </tr>
        <tr>
            <td>Discharge summary : Dx, Other</td>
            <td><?= $form->field($model, 'NA2')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'Missing2')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'No2')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'other1')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'other2')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'other3')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'other4')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td>  <?= $form->field($model, 'other5')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'other6')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'other7')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'other8')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td> <?= $form->field($model, 'other9')->textInput(['maxlength' => true,'value'=>'1'])->label(false) ?></td>
            <td><?= $form->field($model, 'other_huk')->textInput(['maxlength' => true,'value'=>'0'])->label(false) ?></td>
        </tr>
   
    </table>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
   
    <?php ActiveForm::end(); ?>

</div>
