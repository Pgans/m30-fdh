<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Url;
use yii\bootstrap\BootstrapAsset;
use yii\web\JqueryAsset;




$this->title = 'สรุปยอดการเคลม ศูนย์จัดเก็บรายได้ ปีงบประมาณ' . ($y + 1);
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .btn-group-modern {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin-top: 10px;
    }
    
    .btn-modern {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
        text-decoration: none;
        color: white;
        transition: all 0.3s ease-in-out;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

     .btn-modern i {
        font-size: 18px;
    }

    /* ปรับสีปุ่ม */
    .btn-samba {
        background: linear-gradient(135deg, #2f7060, #08c495);
    }
	.btn-rep {
       background: linear-gradient(135deg, #db2df7, #edb0f7);
	
    }
    /* Hover Effect */
    .btn-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.3);
    }
</style>

<style>
   <style>
    /* Hover effect สำหรับแถวใน GridView */
    .grid-view tbody tr:hover {
        background-color: #FFEB3B !important; /* สีเหลืองอ่อน */
        color: #000 !important; /* เปลี่ยนสีตัวอักษรเมื่อ hover */
    }
</style>

</style>



<style>
.table-scroll {
    display: block;
    overflow-x: auto; /* เลื่อนแนวนอน */
    white-space: nowrap; /* ป้องกันการตัดข้อความ */
}

.table th, .table td {
    min-width: 70px; /* กำหนดความกว้างขั้นต่ำ */
}

.table th:first-child, .table td:first-child {
    position: sticky; /* ทำให้คอลัมน์แรกคงที่ */
    left: 0;
    background-color: #ffc107;
    z-index: 2;
}

</style>
<div class="btn-group-modern">
    
	 <a href="<?= Url::to(['/computer/authen']) ?>" class="btn-modern btn-rep">
        <i class="fa fa-check-square-o"></i> รายวัน-สัปดาห์
    </a>
	 <a href="<?= Url::to(['/rptfdh/reportall']) ?>" class="btn-modern btn-rep">
        <i class="fa fa-check-square-o"></i>ผู้ป่วยนอกรายเดือน
    </a>
	<a href="<?= Url::to(['/rptfdh/reportipd']) ?>" class="btn-modern btn-rep">
        <i class="fa fa-check-square-o"></i>ผู้ป่วยในรายเดือน
    </a>
	<a href="<?= Url::to(['/rptfdh/rep']) ?>" class="btn-modern btn-rep">
        <i class="fa fa-check-square-o"></i>ตรวจนำเข้า REP
    </a>
	<a href="<?= Url::to(['/ipuc/index']) ?>" class="btn-modern btn-rep">
        <i class="fa fa-check-square-o"></i>ลูกหนี้หลังรับ STM แบบรายตัว
    </a>
</div>
<br>
<div class="rental-view ">
    <div class="box box-gradient">
        <div class="box-header box-header-gradient">
            <h3 class="box-title"><i class="fa fa-bar-chart"></i> <?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body ">
                <?= Html::a('กลับ', ['report'], ['class' => 'btn btn-warning']) ?>
            </p>
            <?=
            Highcharts::widget([
                'options' => [
                    'title' => ['text' => 'สรุปยอดการเคลมผู้ป่วยใน ศูนย์จัดเก็บรายได้'],
                    'xAxis' => [
                        'categories' => [
                            'ม.ค.',
                            'ก.พ.',
                            'มี.ค.',
                            'เม.ย.',
                            'พ.ค.',
                            'มิ.ย.',
                            'ก.ค.',
                            'ส.ค',
                            'ก.ย.',
                            'ต.ค.',
                            'พ.ย.',
                            'ธ.ค.',
                        ]
                    ],
                    'yAxis' => [
                        'title' => ['text' => 'จำนวน(ราย)']
                    ],
                    'series' => $graph,
                ]
            ])
            ?>
		<div class="row">
    <!-- Card รายการ hosp_claim -->
    <div class="col-md-4">
        <div class="card mb-4 gradient-card">
            <div class="card-header text-center">ยอดเรียกเก็บผู้ป่วยใน ปีงบ2568</div>
            <div class="card-body">
                <h3 class="card-title text-center"><?= Html::encode(number_format($total_hosp_claim, 2)) ?></h3>
            </div>
        </div>
    </div>

    <!-- Card รายการ ret_statement -->
    <div class="col-md-4">
        <div class="card mb-4 gradient-card">
            <div class="card-header text-center">ยอดชดเชยผู้ป่วยใน ปีงบ2568</div>
            <div class="card-body">
                <h3 class="card-title text-center"><?= Html::encode(number_format($total_ret_statement, 2)) ?></h3>
            </div>
        </div>
    </div>

<!-- Card รายการ ret_statement -->
    <div class="col-md-4">
        <div class="card mb-4 gradient-card">
            <div class="card-header text-center">ผลต่าง</div>
            <div class="card-body">
                <h3 class="card-title text-center"><?= Html::encode(number_format($total_difference, 2)) ?></h3>
            </div>
        </div>
    </div>
</div>

<style>
    .gradient-card {
        background: linear-gradient(135deg, #0bb389, #53f5cd); 
        border-radius: 15px; /* ขอบมน */
        border: 1px solid #0aa37d; /* ขอบสีเข้มขึ้น */
        box-shadow: 
            inset 2px 2px 5px rgba(255, 255, 255, 0.6), /* ไฮไลท์ขอบด้านบน */
            inset -2px -2px 5px rgba(0, 0, 0, 0.2), /* เงาภายใน */
            5px 5px 10px rgba(0, 0, 0, 0.3); /* เงาด้านนอก */
        color: #fff; /* ตัวหนังสือสีขาว */
        padding: 20px;
    }

    .card-header, .card-body {
        text-align: center; /* จัดข้อความให้อยู่กลาง */
    }

    .card-header {
        font-size: 3.25rem;
        font-weight: bold;
        color: #fff; /* ตัวหนังสือสีขาว */
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* เงาตัวหนังสือ */
    }

    .card-title {
        font-size: 4rem;
		text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* เงาตัวหนังสือ */
    }
</style>
<?php
Modal::begin([
    'id' => 'no-user-modal',
    'header' => '<h4>รายชื่อผู้ไม่มี users</h4>',
    'size' => 'modal-lg',
]);

echo '<div id="modal-content">กำลังโหลด...</div>';

Modal::end();

$js = <<<JS
function loadNoUserDetail(month) {
    $('#no-user-modal').modal('show')
        .find('#modal-content')
        .load('index.php?r=rptfdh/no-user-detail&month=' + month);
}
JS;
$this->registerJs($js);
?>

            <?=
	 GridView::widget([
		'dataProvider' => $dataProvider,
    'tableOptions' => ['class' => 'table table-bordered'],
    'summary' => '',
    'showPageSummary' => true, // เปิดการแสดงผลรวม
   
    'columns' => [
		[
					'attribute' => 'users',
					'label' => 'กองทุนย่อย',
					'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
					'contentOptions' => ['style' => 'background-color: #ebf7f4;'],
					'pageSummary' => 'รวมทั้งหมด',
				],
				 [
                'attribute' => 't10',
                'label' => 'ทั้งหมด',
                'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
                'pageSummary' => true,
            ],
            
            [
            'attribute' => 'r10',
            'label' => 'เคลม',
            'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'contentOptions' => function ($model, $key, $index, $column) {
                if ($model['color_10'] == 1) {
                    return ['style' => 'color: red;']; // เปลี่ยนสีเป็นแดงถ้าเงื่อนไขตรง
                }
                return [];
            },
            'pageSummary' => true,
			],
            [
                'attribute' => 'hosp_claim_10',
                'label' => 'เรียกเก็บ',
                'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
                'format' => ['decimal', 2],
                'pageSummary' => true,
            ],
            [
                'attribute' => 'ret_statement_10',
                'label' => 'ชดเชย',
                'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
                'format' => ['decimal', 2],
                'pageSummary' => true,
            ],
				[
            'attribute' => 't11',
            'label' => 'ทั้งหมด',
            'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
			'pageSummary' => true,
        ],


           [
            'attribute' => 'r11',
            'label' => 'เคลม',
            'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'contentOptions' => function ($model, $key, $index, $column) {
                // ตรวจสอบค่า color_11 จากข้อมูลที่คิวรีมา
                if ($model['color_11'] == 1) {
                    return ['style' => 'color: red;']; // เปลี่ยนสีเป็นแดงถ้าเงื่อนไขตรง
                }
                return [];
            },
            'pageSummary' => true,
        ],
		  [
            'attribute' => 'hosp_claim_11',
            'label' => 'เรียกเก็บ',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_11',
            'label' => 'ชดเชย',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		
		[
            'attribute' => 't12',
            'label' => 'ทั้งหมด',
            'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
			'pageSummary' => true,
        ],
		[
            'attribute' => 'r12',
            'label' => 'เคลม',
            'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'contentOptions' => function ($model, $key, $index, $column) {
                if ($model['color_12'] == 1) {
                    return ['style' => 'color: red;']; // เปลี่ยนสีเป็นแดงถ้าเงื่อนไขตรง
                }
                return [];
            },
            'pageSummary' => true,
			],
        [
            'attribute' => 'hosp_claim_12',
            'label' => 'เรียกเก็บ',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_12',
            'label' => 'ชดเชย',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		
		[
            'attribute' => 't1',
            'label' => 'ทั้งหมด',
            'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
			'pageSummary' => true,
        ],
		[
            'attribute' => 'r1',
            'label' => 'เคลม',
            'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'contentOptions' => function ($model, $key, $index, $column) {
                if ($model['color_1'] == 1) {
                    return ['style' => 'color: red;']; // เปลี่ยนสีเป็นแดงถ้าเงื่อนไขตรง
                }
                return [];
            },
            'pageSummary' => true,
			],
        [
            'attribute' => 'hosp_claim_1',
            'label' => 'เรียกเก็บ',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_1',
            'label' => 'ชดเชย',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		
		[
            'attribute' => 't2',
            'label' => 'ทั้งหมด',
            'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
			'pageSummary' => true,
        ],
		[
            'attribute' => 'r2',
            'label' => 'เคลม',
            'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'contentOptions' => function ($model, $key, $index, $column) {
                if ($model['color_2'] == 1) {
                    return ['style' => 'color: red;']; // เปลี่ยนสีเป็นแดงถ้าเงื่อนไขตรง
                }
                return [];
            },
            'pageSummary' => true,
			],
        [
            'attribute' => 'hosp_claim_2',
            'label' => 'เรียกเก็บ',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_2',
            'label' => 'ชดเชย',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		
		[
            'attribute' => 't3',
            'label' => 'ทั้งหมด',
           'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
			'pageSummary' => true,
        ],
		[
            'attribute' => 'r3',
            'label' => 'เคลม',
            'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'contentOptions' => function ($model, $key, $index, $column) {
                if ($model['color_3'] == 1) {
                    return ['style' => 'color: red;']; // เปลี่ยนสีเป็นแดงถ้าเงื่อนไขตรง
                }
                return [];
            },
            'pageSummary' => true,
			],
        [
            'attribute' => 'hosp_claim_3',
            'label' => 'เรียกเก็บ',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_3',
            'label' => 'ชดเชย',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		
			[
			'attribute' => 't4',
			'label' => 'เม.ย.',
			'format' => 'raw',
			'value' => function ($model) {
				$url = \yii\helpers\Url::to(['rptfdh/no-user-detail', 'month' => 4]);

				return Html::a(
					$model['t4'],
					'#',
					[
						'onclick' => "window.open('$url', '_blank', 'width=1200,height=700,scrollbars=yes'); return false;",
						'title' => "ดูรายชื่อผู้ไม่มี users เดือน เม.ย.",
						'style' => 'color: #20909e; text-decoration: underline;',
					]
				);
			},
		],
		[
            'attribute' => 'r4',
            'label' => 'เคลม',
            'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'contentOptions' => function ($model, $key, $index, $column) {
                if ($model['color_4'] == 1) {
                    return ['style' => 'color: red;']; // เปลี่ยนสีเป็นแดงถ้าเงื่อนไขตรง
                }
                return [];
            },
            'pageSummary' => true,
			],
        [
            'attribute' => 'hosp_claim_4',
            'label' => 'เรียกเก็บ',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_4',
            'label' => 'ชดเชย',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
				
			[
			'attribute' => 't5',
			'label' => 'พ.ค.',
			'format' => 'raw',
			'value' => function ($model) {
				$url = \yii\helpers\Url::to(['rptfdh/no-user-detail', 'month' => 5]);

				return Html::a(
					$model['t5'],
					'#',
					[
						'onclick' => "window.open('$url', '_blank', 'width=1200,height=700,scrollbars=yes'); return false;",
						'title' => "ดูรายชื่อผู้ไม่มี users เดือน พ.ค.",
						'style' => 'color: #20909e; text-decoration: underline;',
					]
				);
			},
		],
		[
            'attribute' => 'r5',
            'label' => 'เคลม',
            'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'contentOptions' => function ($model, $key, $index, $column) {
                if ($model['color_5'] == 1) {
                    return ['style' => 'color: red;']; // เปลี่ยนสีเป็นแดงถ้าเงื่อนไขตรง
                }
                return [];
            },
            'pageSummary' => true,
			],
        [
            'attribute' => 'hosp_claim_5',
            'label' => 'เรียกเก็บ',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_5',
            'label' => 'ชดเชย',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
			[
			'attribute' => 't6',
			'label' => 'ต.ค.',
			'format' => 'raw',
			'value' => function ($model) {
				$url = \yii\helpers\Url::to(['rptfdh/no-user-detail', 'month' => 6]);

				return Html::a(
					$model['t6'],
					'#',
					[
						'onclick' => "window.open('$url', '_blank', 'width=1200,height=700,scrollbars=yes'); return false;",
						'title' => "ดูรายชื่อผู้ไม่มี users เดือน ต.ค.",
						'style' => 'color: #20909e; text-decoration: underline;',
					]
				);
			},
		],

		[
            'attribute' => 'r6',
            'label' => 'เคลม',
            'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'contentOptions' => function ($model, $key, $index, $column) {
                if ($model['color_6'] == 1) {
                    return ['style' => 'color: red;']; // เปลี่ยนสีเป็นแดงถ้าเงื่อนไขตรง
                }
                return [];
            },
            'pageSummary' => true,
			],
        [
            'attribute' => 'hosp_claim_6',
            'label' => 'เรียกเก็บ',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_6',
            'label' => 'ชดเชย',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		
		
			[
			'attribute' => 't7',
			'label' => 'ก.ค.',
			'format' => 'raw',
			'value' => function ($model) {
				$url = \yii\helpers\Url::to(['rptfdh/no-user-detail', 'month' => 7]);

				return Html::a(
					$model['t7'],
					'#',
					[
						'onclick' => "window.open('$url', '_blank', 'width=1200,height=700,scrollbars=yes'); return false;",
						'title' => "ดูรายชื่อผู้ไม่มี users เดือน ก.ค.",
						'style' => 'color: #20909e; text-decoration: underline;',
					]
				);
			},
		],
		[
            'attribute' => 'r7',
            'label' => 'เคลม',
            'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'contentOptions' => function ($model, $key, $index, $column) {
                if ($model['color_7'] == 1) {
                    return ['style' => 'color: red;']; // เปลี่ยนสีเป็นแดงถ้าเงื่อนไขตรง
                }
                return [];
            },
            'pageSummary' => true,
			],
        [
            'attribute' => 'hosp_claim_7',
            'label' => 'เรียกเก็บ',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_7',
            'label' => 'ชดเชย',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		
		
			[
			'attribute' => 't8',
			'label' => 'ส.ค.',
			'format' => 'raw',
			'value' => function ($model) {
				$url = \yii\helpers\Url::to(['rptfdh/no-user-detail', 'month' => 8]);

				return Html::a(
					$model['t8'],
					'#',
					[
						'onclick' => "window.open('$url', '_blank', 'width=1200,height=700,scrollbars=yes'); return false;",
						'title' => "ดูรายชื่อผู้ไม่มี users เดือน ส.ค.",
						'style' => 'color: #20909e; text-decoration: underline;',
					]
				);
			},
		],
		[
            'attribute' => 'r8',
            'label' => 'เคลม',
            'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'contentOptions' => function ($model, $key, $index, $column) {
                if ($model['color_8'] == 1) {
                    return ['style' => 'color: red;']; // เปลี่ยนสีเป็นแดงถ้าเงื่อนไขตรง
                }
                return [];
            },
            'pageSummary' => true,
			],
        [
            'attribute' => 'hosp_claim_8',
            'label' => 'เรียกเก็บ',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_8',
            'label' => 'ชดเชย',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
				
			[
			'attribute' => 't9',
			'label' => 'ก.ย.',
			'format' => 'raw',
			'value' => function ($model) {
				$url = \yii\helpers\Url::to(['rptfdh/no-user-detail', 'month' => 9]);

				return Html::a(
					$model['t9'],
					'#',
					[
						'onclick' => "window.open('$url', '_blank', 'width=1200,height=700,scrollbars=yes'); return false;",
						'title' => "ดูรายชื่อผู้ไม่มี users เดือน ก.ย.",
						'style' => 'color: #20909e; text-decoration: underline;',
					]
				);
			},
		],
		[
            'attribute' => 'r9',
            'label' => 'เคลม',
            'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'contentOptions' => function ($model, $key, $index, $column) {
                if ($model['color_9'] == 1) {
                    return ['style' => 'color: red;']; // เปลี่ยนสีเป็นแดงถ้าเงื่อนไขตรง
                }
                return [];
            },
            'pageSummary' => true,
			],
        [
            'attribute' => 'hosp_claim_9',
            'label' => 'เรียกเก็บ',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_9',
            'label' => 'ชดเชย',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
	

		[
            'attribute' => 'total',
            'label' => 'รวม',
			'headerOptions' => ['style' => 'display:none'], // ซ่อนหัวคอลัมน์
            'format' => ['decimal', 0],
            'pageSummary' => true,
        ],
    ],
   'beforeRow' => function ($model, $key, $index, $grid) {
    if ($index === 0) {
        $months = [
            'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม',
            'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฏาคม', 'สิงหาคม', 'กันยายน'
        ];

        // เริ่มต้นการสร้าง header แถวแรก
        $header = '<tr>
            <th rowspan="2" style="text-align: center; vertical-align: middle; background-color: #607D8B; color: white;">กองทุนย่อย</th>';
        
        // เพิ่มหัวคอลัมน์เดือน
        foreach ($months as $month) {
            $header .= '<th colspan="4" style="text-align: center; background-color: #9E9E9E; color: white;">' . $month . '</th>';
        }

        $header .= '</tr><tr>';

        // เพิ่มหัวคอลัมน์ภายในเดือน (ทั้งหมด, เคลม, เรียกเก็บ, ชดเชย)
        foreach ($months as $i => $month) {
            $bgColor = ($i % 2 == 0) ? '#ffffff' : '#d3ede8'; // สลับสีขาว-เทา
            $header .= '<th style="text-align: center; background-color: ' . $bgColor . ';">ทั้งหมด</th>';
            $header .= '<th style="text-align: center; background-color: ' . $bgColor . ';">เคลม</th>';
            $header .= '<th style="text-align: center; background-color: ' . $bgColor . ';">เรียกเก็บ</th>';
            $header .= '<th style="text-align: center; background-color: ' . $bgColor . ';">ชดเชย</th>';
        }
        
        $header .= '</tr>';
        return $header;
    }
},
'rowOptions' => function ($model, $key, $index, $grid) {
    return ['class' => 'data-row']; // เพิ่ม class สำหรับใช้ CSS
},
'options' => [
    'style' => 'overflow-x: auto; white-space: nowrap;', // ให้เลื่อนในแนวนอน
],
]);


            ?>
			
			
            <p>***หมายเหตุ เฉพาะที่ส่งข้อมูลผ่าน API </p>
        </div>
    </div>
	
	
	
	
 <style>
    /* สลับสีในแต่ละเดือน (4 แถวต่อเดือน) */
   /* เดือนตุลาคม */
th:nth-child(2), td:nth-child(2) {
    background-color: #ffffff; /* สีขาว */
}
th:nth-child(3), td:nth-child(3) {
     background-color: #ffffff; /* สีขาว */
}
th:nth-child(4), td:nth-child(4) {
    background-color: #ffffff; /* สีขาว */
}
th:nth-child(5), td:nth-child(5) {
    background-color: #ffffff; /* สีขาว */
}
/* เดือนพฤศจิกายน */
th:nth-child(6), td:nth-child(6) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
th:nth-child(7), td:nth-child(7) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
th:nth-child(8), td:nth-child(8) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
th:nth-child(9), td:nth-child(9) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
/* เดือนธันวาคม */
th:nth-child(10), td:nth-child(10) {
    background-color: #ffffff; /* สีขาว */
}
th:nth-child(11), td:nth-child(11) {
   background-color: #ffffff; /* สีขาว */
}
th:nth-child(12), td:nth-child(12) {
    background-color: #ffffff; /* สีขาว */
}
th:nth-child(13), td:nth-child(13) {
   background-color: #ffffff; /* สีขาว */
}
/* เดือนมกราคม */
th:nth-child(14), td:nth-child(14) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
th:nth-child(15), td:nth-child(15) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
th:nth-child(16), td:nth-child(16) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
th:nth-child(17), td:nth-child(17) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
/* เดือนกุมภาพันธ์ */
th:nth-child(18), td:nth-child(18) {
    background-color: #ffffff; /* สีขาว */
}
th:nth-child(19), td:nth-child(19) {
    background-color: #ffffff; /* สีขาว */
}
th:nth-child(20), td:nth-child(20) {
    background-color: #ffffff; /* สีขาว */
}
th:nth-child(21), td:nth-child(21) {
    background-color: #ffffff; /* สีขาว */
}
/* เดือนมีนาคม */
th:nth-child(22), td:nth-child(22) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
th:nth-child(23), td:nth-child(23) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
th:nth-child(24), td:nth-child(24) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
th:nth-child(25), td:nth-child(25) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
/* เดือนเมษายน */
th:nth-child(26), td:nth-child(26) {
    background-color: #ffffff; /* สีขาว */
}
th:nth-child(27), td:nth-child(27) {
    background-color: #ffffff; /* สีขาว */
}
th:nth-child(28), td:nth-child(28) {
    background-color: #ffffff; /* สีขาว */
}
th:nth-child(29), td:nth-child(29) {
    background-color: #ffffff; /* สีขาว */
}
/* เดือนพฤษภาคม */
th:nth-child(30), td:nth-child(30) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
th:nth-child(31), td:nth-child(31) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
th:nth-child(32), td:nth-child(32) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
th:nth-child(33), td:nth-child(33) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
/* เดือนมิถุนายน */
th:nth-child(34), td:nth-child(34) {
    background-color: #ffffff; /* สีขาว */
}
th:nth-child(35), td:nth-child(35) {
    background-color: #ffffff; /* สีขาว */
}
th:nth-child(36), td:nth-child(36) {
    background-color: #ffffff; /* สีขาว */
}
th:nth-child(37), td:nth-child(37) {
    background-color: #ffffff; /* สีขาว */
}
/* เดือนกรกฎาคม */
th:nth-child(38), td:nth-child(38) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
th:nth-child(39), td:nth-child(39) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
th:nth-child(40), td:nth-child(40) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
th:nth-child(41), td:nth-child(41) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
/* เดือนสิงหาคม */
th:nth-child(42), td:nth-child(42) {
    background-color: #ffffff; /* สีขาว */
}
th:nth-child(43), td:nth-child(43) {
    background-color: #ffffff; /* สีขาว */
}
th:nth-child(44), td:nth-child(44) {
    background-color: #ffffff; /* สีขาว */
}
th:nth-child(45), td:nth-child(45) {
    background-color: #ffffff; /* สีขาว */
}
/* เดือนกันยายน */
th:nth-child(46), td:nth-child(46) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
th:nth-child(47), td:nth-child(47) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
th:nth-child(48), td:nth-child(48) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}
th:nth-child(49), td:nth-child(49) {
    background-color: #f5f5f5; /* สีเทาอ่อน */
}

	 
    /* เพิ่มสี Hover เมื่อชี้ที่แถว */
    tr:hover td {
        background-color: #b2f7e6 !important;
        transition: background-color 0.3s ease-in-out;
    }
</style>
<?php
$jsPjax = <<<JS
$(document).on('pjax:end', function() {
    window.loadNoUserDetail = function(month) {
        $('#no-user-modal').modal('show')
            .find('#modal-content')
            .load('index.php?r=rptfdh/no-user-detail&month=' + month);
    };
});
JS;
$this->registerJs($jsPjax);
?>

