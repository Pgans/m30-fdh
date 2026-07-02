<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'ประมวลผลหัตถการ 88.38-scanning C.A.Tก';
$this->params['breadcrumbs'][] = $this->title;

// กำหนด CSS สีสันของ .well
$this->registerCss("
.well {
    background: linear-gradient(to right, #09b8ab, #00f2fe);
    color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.table-sticky thead th {
    position: sticky;
    top: 0;
    background-color: #f8f9fa;
    z-index: 1;
}
.table-responsive {
    max-height: calc(36px * 20 + 60px); /* 12 rows + header/footer padding */
    overflow-y: auto;
}
.table tbody tr:hover {
    background-color: #00f2fe !important; /* สีฟ้าอ่อน */
    transition: background-color 0.2s ease-in-out;
}
");

?>

<div class='well'>
    <?php $form = ActiveForm::begin([
        'method' => 'POST',
        'action' => ['operations/icd8838'],
    ]); ?>

    <label>ระหว่างวันที่:</label>
    <?= yii\jui\DatePicker::widget([
        'name' => 'date1',
        'value' => $date1,
        'language' => 'th',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control', 'style' => 'display:inline-block; width:auto;'],
        'clientOptions' => [
            'changeMonth' => true,
            'changeYear' => true,
        ]
    ]); ?>

    <label>ถึง:</label>
    <?= yii\jui\DatePicker::widget([
        'name' => 'date2',
        'value' => $date2,
        'language' => 'th',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control', 'style' => 'display:inline-block; width:auto;'],
        'clientOptions' => [
            'changeMonth' => true,
            'changeYear' => true,
        ]
    ]); ?>

    <?= Html::submitButton('ตกลง', ['class' => 'btn btn-danger']) ?>
    <?= Html::a('ล้างค่า', ['operations/icd8838'], ['class' => 'btn btn-warning']) ?>
    <input class="btn btn-primary" name="btnButton" type="button" value="Print Results" onClick="JavaScript:window.print();">

    <?php ActiveForm::end(); ?>
</div>

<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover table-sm table-sticky'],
		'panel' => [
            'before'=>'<b style="color:blue "></b>',
            'after'=>'ประมวลผล '.date('Y-m-d H:i:s')
            ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            ['attribute' => 'visit_id', 'label' => 'VISIT'],
            ['attribute' => 'hn', 'label' => 'HN'],
            ['attribute' => 'date_serv', 'label' => 'วันที่รับบริการ'],
			['attribute' => 'time_serv', 'label' => 'เวลา'],
            ['attribute' => 'fullname', 'label' => 'ชื่อ-สกุล'],
            ['attribute' => 'age', 'label' => 'อายุ'],
            ['attribute' => 'inscl_name', 'label' => 'สิทธิการรักษา'],
			['attribute' => 'unit_name'],
            ['attribute' => 'procedure_code', 'label' => 'icd9'],
            ['attribute' => 'procedure_name', 'label' => 'icd9_name'],
			[
			'attribute' => 'claimcode',
			'label' => 'authen',
			'contentOptions' => ['style' => 'color: orange; font-weight: bold;'],
	     	],
			[
				'attribute' => 'closeclaim',
				'label' => 'ปิดสิทธิ์',
				'value' => function($model) {
					return $model->closeclaim ?: ''; // ถ้าไม่มีค่า ให้แสดงว่าง
				},
				'contentOptions' => function($model) {
					return ['style' => $model->closeclaim ? 'color: green; font-weight: bold;' : ''];
				},
			],

			
            
        ],
    ]); ?>
</div>
<?= Html::a('← กลับหน้าแรก', ['referopd/index3'], [
    'class' => 'btn btn-primary',
    'style' => 'border: 2px solid white; background-color: #09b8ab; color: white;'
]) ?>
