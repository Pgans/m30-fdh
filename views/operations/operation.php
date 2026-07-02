<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'OP-สิทธิ์ประกันสุขภาพถ้วนหน้า นอกเขต ในจังหวัด ';
$this->params['breadcrumbs'][] = $this->title;

// กำหนด CSS สีสันของ .well
$this->registerCss("
.well {
    background: linear-gradient(to right, #4facfe, #00f2fe);
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
        'action' => ['opucs/opucin'],
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
    <?= Html::a('ล้างค่า', ['opucs/opucin'], ['class' => 'btn btn-warning']) ?>
    <input class="btn btn-primary" name="btnButton" type="button" value="Print Results" onClick="JavaScript:window.print();">

    <?php ActiveForm::end(); ?>
</div>

<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover table-sm table-sticky'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'CID', 'label' => 'CID'],
            ['attribute' => 'HN', 'label' => 'HN'],
            ['attribute' => 'VISIT_ID'],
            ['attribute' => 'REG_DATETIME', 'label' => 'วันที่รับบริการ'],
            ['attribute' => 'FNAME', 'label' => 'ชื่อ'],
            ['attribute' => 'LNAME', 'label' => 'สกุล'],
            ['attribute' => 'สิทธิ์'],
            ['attribute' => 'Hmain', 'label' => 'Hmain'],
            ['attribute' => 'Hsub', 'label' => 'Hsub'],
            ['attribute' => 'HOSP_NAME', 'label' => 'ชื่อหน่วยบริการหลัก'],
            ['attribute' => 'Start_date', 'label' => 'เริ่มสิทธิ์'],
            ['attribute' => 'Expire_date', 'label' => 'หมดอายุ'],
        ],
    ]); ?>
</div>
<?= Html::a('← กลับหน้าแรก', ['referopd/index3'], [
    'class' => 'btn btn-primary',
    'style' => 'border: 2px solid white; background-color: #4facfe; color: white;'
]) ?>
