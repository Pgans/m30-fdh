<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="600"> <!-- รีเฟรชทุก 10 นาที -->

    <style>
        body {
            background: linear-gradient(135deg, #f8f0ff, #e0d7ff); /* Gradient ม่วงอ่อน */
            font-family: 'Prompt', sans-serif;
        }

        .panel-custom {
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: none;
            background: linear-gradient(to bottom right, #f3e7ff, #f6f2fa);
            padding: 20px;
            margin-bottom: 20px;
        }

        .panel-heading-custom {
            background: linear-gradient(to right, #a18cd1, #dfc6f7);
            color: white;
            font-size: 18px;
            font-weight: bold;
            padding: 15px;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            border-bottom: 2px solid #d3bce3;
        }

        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #fdf8ff;
        }

        .btn-purple {
            background-color: #efe6f7;
            border-color: #b37feb;
            color: #fff;
        }

        .btn-purple:hover {
            background-color: #a67efb;
            border-color: #925ee4;
        }
    </style>
</head>

<body>
<?php $this->title = 'ผลการส่งข้อมูล Total Visits  (ช่วงเวลา 1 ตุลาคม 2567 - ปัจจุบัน)'; ?>

<div class="row">
    <div class="col-md-3">
        <div class="panel-custom">
            <div class="panel-heading-custom">
                <i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp;จำนวนการส่งข้อมูลผู้ป่วยนอกล่าสุด
            </div>
            <div class="panel-body">
                 <?= GridView::widget([
        'dataProvider' => $opd1Provider,
		 'summary' => false,
		'showPageSummary' => true,
        'columns' => [
		['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'reg_day',
                'label' => 'วันที่',
				'pageSummary' => 'รวมทั้งหมด',
            ],
            [
                'attribute' => 'sent_count',
                'label' => 'ทั้งหมด',
				'pageSummary' => true,
            ],
            [
                'attribute' => 'base_count',
                'label' => 'ส่งผ่าน',
                'format' => ['decimal', 0],
				'pageSummary' => true,
            ],
        ],
		 'options' => ['class' => 'table-responsive'],
                    'tableOptions' => ['class' => 'table table-striped'],
    ]); ?>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="panel-custom">
            <div class="panel-heading-custom">
                <i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp;แสดงรายการส่งข้อมูล Total Visits ผู้ป่วยนอก
            </div>
            <div class="panel-body">
               <?= GridView::widget([
        'dataProvider' => $opdProvider,
		'showPageSummary' => true,
        'columns' => [
		['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'thai_month',
                'label' => 'เดือน',
            ],
            [
                'attribute' => 'thai_year',
                'label' => 'ปี พ.ศ.',
				'pageSummary' => 'รวมทั้งหมด',
            ],
            [
                'attribute' => 'total_visits',
                'label' => 'จำนวนส่ง',
                'format' => ['decimal', 0],
				'pageSummary' => true,
            ],
        ],
		 'options' => ['class' => 'table-responsive'],
                    'tableOptions' => ['class' => 'table table-striped'],
    ]); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="panel-custom">
            <div class="panel-heading-custom">
                <i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp;จำนวนการส่งข้อมูลผู้ป่วยในล่าสุด
            </div>
            <div class="panel-body">
                
                 <?= GridView::widget([
        'dataProvider' => $ipd1Provider,
		 'summary' => false,
		'showPageSummary' => true,
        'columns' => [
		['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'reg_day',
                'label' => 'วันที่',
				'pageSummary' => 'รวมทั้งหมด',
            ],
            [
                'attribute' => 'sent_count',
                'label' => 'ทั้งหมด',
				'pageSummary' => true,
            ],
            [
                'attribute' => 'base_count',
                'label' => 'ส่งผ่าน',
                'format' => ['decimal', 0],
				'pageSummary' => true,
            ],
        ],
		 'options' => ['class' => 'table-responsive'],
                    'tableOptions' => ['class' => 'table table-striped'],
    ]); ?>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="panel-custom">
            <div class="panel-heading-custom">
                <i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp;แสดงรายการส่งข้อมูล Total Visits ผู้ป่วยใน
            </div>
            <div class="panel-body">
               <?= GridView::widget([
        'dataProvider' => $ipdProvider,
		'showPageSummary' => true,
        'columns' => [
		['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'thai_month',
                'label' => 'เดือน',
            ],
            [
                'attribute' => 'thai_year',
                'label' => 'ปี พ.ศ.',
				'pageSummary' => 'รวมทั้งหมด',
            ],
            [
                'attribute' => 'total_visits',
                'label' => 'จำนวนส่ง',
                'format' => ['decimal', 0],
				'pageSummary' => true,
            ],
        ],
		 'options' => ['class' => 'table-responsive'],
                    'tableOptions' => ['class' => 'table table-striped'],
    ]); ?>
            </div>
        </div>
    </div>
</div>



