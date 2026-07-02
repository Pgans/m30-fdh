<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use common\models\RContributionIpd;
use yii\data\ActiveDataProvider;
$this->title = 'ยอดผู้ป่วยนอกแยกตามสิทธิการรักษา';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['thaimed/index']];
$this->params['breadcrumbs'][] = 'ยอดผู้ป่วยนอกแยกตามสิทธิการรักษา';
?>
<br>
       
<div class='well'>
    <?php $form = ActiveForm::begin(); ?>
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
        <?php $form = ActiveForm::begin([ ]);
    // echo Html::a('แยกรายเดือน', ['thaimed/u_9007712month'], ['class' => 'btn btn-success', 'style' => 'margin-left:5px','target'=>'_blank']);
    // echo Html::a('เปรียบเทียบ', ['thaimed/surgeon_inout'], ['class' => 'btn btn-info', 'style' => 'margin-left:5px','target'=>'_blank']);
  
    ActiveForm::end();?>
    <?php ActiveForm::end(); ?>
</div>
<div>
<?php
$gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'attribute' => 'inscl',
            'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,
            'format'=> 'raw',
            'header' => 'สิทธิ์การรักษา',
            'pageSummary' => 'รวมทั้งหมด',
        ],
        [
            'attribute'=>'Visit',
            'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,
            'header'=>'ครั้ง',
            'pageSummary' => true,
          
        ],
        [
            'attribute'=>'amount',
            'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,
            'header'=>'คน',
            'pageSummary' => true,
            //'showPageSummary' => true,
            
        ],
];

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'panel' => [
        'before'=>'<b style="color:blue ">ADJRW-IPD</b><b style="color: red">(ผู้ป่วยใน ***ไม่นับแผนก Home Isolation(57)และนอกหน่วยบริการ </b>',
        'after'=>'<a>ประมวลผลจากวันที่</a> '.$date1   .'<a>ถึงวันที่</a>' .$date2 
        ],
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