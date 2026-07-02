<?php
/* @var $this yii\web\View */

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

$this->title = '16F';

$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['f16only/index']];
$this->params['breadcrumbs'][] = 'ประมวลผล 16 แฟ้ม';
?>
<br>
<style>
    .custom-button {
        background-color: #0080ff; /* Blue color */
        color: white;
        padding: 10px 22px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
</style>
<button class="custom-button"><b>ประมวลผล 16 แฟ้ม</b></button>
<div class='well'>
    <?php $form = ActiveForm::begin(['action' => ['f16only/data']]); ?>
     ระหว่างวันที่:
           <?php
        echo yii\jui\DatePicker::widget([
            'name' => 'date1',
            'value' => $date1,
            'language' => 'th',
            'dateFormat' => 'yyyy-MM-dd',
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
            ]
        ]);
        ?>
        ถึง:
           <?php
      echo yii\jui\DatePicker::widget([
        'name' => 'date2',
        'value' => $date2,
        'language' => 'th',
        'dateFormat' => 'yyyy-MM-dd',
        'clientOptions' => [
            'changeMonth' => true,
            'changeYear' => true,
        ]
    ]);
        ?>
        <button class='btn btn-danger'> ประมวลผล </button>
        <?php $form = ActiveForm::begin([ ]);
    //echo Html::a('รายเดือน', ['thaimed/op_count'], ['class' => 'btn btn-success', 'id'=>'modalButton','target'=>'_blank']);
    ActiveForm::end();?>
    <?php ActiveForm::end(); ?>

