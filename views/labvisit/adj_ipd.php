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


<?php
$gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
        [
        'attribute' => 'INSCL_NAME',
        'format'=>'raw',
        'label' => 'รายการ',
        'headerOptions'=>[ 'style'=>'background-color:#FEF5E7'],
        'value' => function ($model, $key, $index, $widget) {
                return "<font  color='2E86C1'>" . $model['INSCL_NAME'] . "</font>"; 
        },
        'pageSummary' => 'รวมทั้งหมด',
    ],
	[
        'attribute' => 'visits',
        'label' => 'จำนวน',
        'headerOptions'=>[ 'style'=>'background-color:#FEF5E7'],
        'format' => ['decimal', 0],
        'hAlign' => 'right',
        'pageSummary' => true,
        'pageSummaryOptions' => ['id' => 'total_sum'],
    ],
	
	[
        'attribute' => 'Adjrw',
        'label' => 'ค่ารวมAdjrw',
        'headerOptions'=>[ 'style'=>'background-color:#FEF5E7'],
        'format' => ['decimal', 2],
        'hAlign' => 'right',
        'pageSummary' => true,
        'pageSummaryOptions' => ['id' => 'total_sum'],
    ],
       [
    'attribute'=>'Adjrw',
    'headerOptions'=>[ 'style'=>'background-color:#FEF5E7'],
	'label'=>'Adjrw'
	], 
    
];
echo GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'autoXlFormat' => true,
    'export' => [
        'fontAwesome' => true,
        'showConfirmAlert' => false,
        'target' => GridView::TARGET_BLANK
    ],
    'columns' => $gridColumns,
    'resizableColumns' => true,
     'showPageSummary' => true,
        //'resizeStorageKey' => Yii::$app->user->id . '-' . date("m"),
]);
?>

