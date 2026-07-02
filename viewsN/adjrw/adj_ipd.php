<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

$this->title = "ADJRW-IPD";
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['reg/index']];
$this->params['breadcrumbs'][] = 'งานเวชระเบียน';
?>
<b style = "color:blue">ADJRW-IPD</b>
<div class='well'>
     <?php $form = ActiveForm::begin([
    'method' => 'POST',
    'action' => ['adjrw/adjipd'],
]); ?>
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
        <button class='btn btn-danger'> ตกลง </button>
		<input class="btn btn-primary" name="btnButton" type="button" value="Print Results" onClick="JavaScript:window.print();">

    <?php ActiveForm::end(); ?>
	
</div>
<?php //echo $sql;?>
<?php
echo GridView::widget([
        'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
        'panel' => [
            'before'=>'<b style="color:blue ">ADJRW-IPD</b><b style="color: red">(ผู้ป่วยใน ***ไม่นับแผนก Home Isolation(57)และนอกหน่วยบริการ </b>',
            'after'=>'<a>ประมวลผลจากวันที่</a> '.$date1   .'<a>ถึงวันที่</a>' .$date2 
            ],
    ]
  );

        ?>
        <div class="alert alert-info">
            <?=$sql?>
        </div>
