<?php

use yii\helpers\Html;
use yii\grid\GridView;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Url;


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
        background: linear-gradient(135deg, #6a11cb, #2575fc);
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
                    'title' => ['text' => 'สรุปยอดการเคลม ศูนย์จัดเก็บรายได้'],
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
            <div class="card-header text-center">ยอดเรียกเก็บผู้ป่วยนอก ปีงบ2568</div>
            <div class="card-body">
                <h3 class="card-title text-center"><?= Html::encode(number_format($total_hosp_claim, 2)) ?></h3>
            </div>
        </div>
    </div>

    <!-- Card รายการ nhso_rep -->
    <div class="col-md-4">
        <div class="card mb-4 gradient-card">
            <div class="card-header text-center">ยอดชดเชยผู้ป่วยนอก ปีงบ2568</div>
            <div class="card-body">
                <h3 class="card-title text-center"><?= Html::encode(number_format($total_nhso_rep, 2)) ?></h3>
            </div>
        </div>
    </div>

<!-- Card รายการ nhso_rep -->
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
        background: linear-gradient(135deg, #f39c12, #f1c40f); /* Gradient สีส้ม */
        border-radius: 15px; /* ขอบมน */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* เงา 3 มิติ */
        color: #fff; /* ตัวหนังสือสีขาว */
    }

    .card-header, .card-body {
        text-align: center; /* จัดข้อความให้อยู่กลาง */
    }

    .card-header {
    font-size: 3.25rem;
    font-weight: bold;
    #color: #9b59b6; /* สีม่วงอ่อน */
	}

    .card-title {
        font-size: 4rem;
    }
</style>


            <?=
		
 GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => ['class' => 'table table-bordered'],
    'rowOptions' => function ($model, $key, $index, $grid) {
        return ['style' => $index % 2 === 0 ? 'background-color: #ebf7f4;' : ''];
    },
    'columns' => [
        [
            'attribute' => 'users',
            'label' => 'กองทุนย่อย',
            'headerOptions' => ['style' => 'background-color: #ffc107; color: black; text-align: center; vertical-align: middle;'],
            'contentOptions' => ['style' => 'background-color: #f5f2f2;'],
        ],
        [
            'attribute' => 'r10',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],

        ],
        [
            'attribute' => 'hosp_claim_10',
            'label' => 'เรียกเก็บ',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
			
        ],
        [
            'attribute' => 'nhso_rep_10',
            'label' => 'ชดเชย',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'r11',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'hosp_claim_11',
            'label' => 'เรียกเก็บ',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'nhso_rep_11',
            'label' => 'ชดเชย',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
		[
            'attribute' => 'r12',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'hosp_claim_12',
            'label' => 'เรียกเก็บ',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'nhso_rep_12',
            'label' => 'ชดเชย',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
		[
            'attribute' => 'r1',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'hosp_claim_1',
            'label' => 'เรียกเก็บ',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'nhso_rep_1',
            'label' => 'ชดเชย',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
		[
            'attribute' => 'r2',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'hosp_claim_2',
            'label' => 'เรียกเก็บ',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'nhso_rep_2',
            'label' => 'ชดเชย',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
		[
            'attribute' => 'r3',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'hosp_claim_3',
            'label' => 'เรียกเก็บ',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'nhso_rep_3',
            'label' => 'ชดเชย',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
		
		[
            'attribute' => 'r4',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'hosp_claim_4',
            'label' => 'เรียกเก็บ',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'nhso_rep_4',
            'label' => 'ชดเชย',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
		
		[
            'attribute' => 'r5',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'hosp_claim_5',
            'label' => 'เรียกเก็บ',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'nhso_rep_5',
            'label' => 'ชดเชย',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
		
		[
            'attribute' => 'r6',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'hosp_claim_6',
            'label' => 'เรียกเก็บ',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'nhso_rep_6',
            'label' => 'ชดเชย',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
		
		[
            'attribute' => 'r7',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'hosp_claim_7',
            'label' => 'เรียกเก็บ',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'nhso_rep_7',
            'label' => 'ชดเชย',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
		[
            'attribute' => 'r8',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'hosp_claim_8',
            'label' => 'เรียกเก็บ',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'nhso_rep_8',
            'label' => 'ชดเชย',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
		
		[
            'attribute' => 'r9',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'hosp_claim_9',
            'label' => 'เรียกเก็บ',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
        [
            'attribute' => 'nhso_rep_9',
            'label' => 'ชดเชย',
            'headerOptions' => ['style' => 'text-align: center; background-color: #ffc107;'],
        ],
		
		[
            'attribute' => 'total',
            'label' => 'รวม',
            'format' => 'raw',
			'headerOptions' => ['style' => 'background-color: #ffc107; color: black; text-align: center; vertical-align: middle;'],
            'value' => function ($model) {
                return Html::button($model['total'], [
                    'class' => 'btn btn-total',
                    'style' => 'cursor: default;color: green;', // กำหนดสีตัวอักษรเป็นสีส้ม',
                ]);
            },
            'headerOptions' => ['class' => 'header-gradient'],
        ],
    ],
    'beforeRow' => function ($model, $key, $index, $grid) {
        if ($index === 0) {
            return '<tr>
                <th rowspan="2" style="text-align: center; vertical-align: middle; background-color: #ffeb3b;">กองทุนย่อย</th>
                <th colspan="3" style="text-align: center; background-color: #ffeb3b;">ตุลาคม</th>
                <th colspan="3" style="text-align: center; background-color: #ffeb3b;">พฤศจิกายน</th>
				<th colspan="3" style="text-align: center; background-color: #ffeb3b;">ธันวาคม</th>
				<th colspan="3" style="text-align: center; background-color: #ffeb3b;">มกราคม</th>
				<th colspan="3" style="text-align: center; background-color: #ffeb3b;">กุมภาพันธ์</th>
				<th colspan="3" style="text-align: center; background-color: #ffeb3b;">มีนาคม</th>
			    <th colspan="3" style="text-align: center; background-color: #ffeb3b;">เมษายน</th>
				<th colspan="3" style="text-align: center; background-color: #ffeb3b;">พฤษภาคม</th>
				<th colspan="3" style="text-align: center; background-color: #ffeb3b;">มิถุนายน</th>
				<th colspan="3" style="text-align: center; background-color: #ffeb3b;">กรกฏาคม</th>
				<th colspan="3" style="text-align: center; background-color: #ffeb3b;">สิงหาคม</th>
				<th colspan="3" style="text-align: center; background-color: #ffeb3b;">กันยายน</th>
				
            </tr>
            <tr>
                <th style="text-align: center; background-color: #ffc107;">จำนวน</th>
                <th style="text-align: center; background-color: #ffc107;">เรียกเก็บ</th>
                <th style="text-align: center; background-color: #ffc107;">ชดเชย</th>
                <th style="text-align: center; background-color: #ffc107;">จำนวน</th>
                <th style="text-align: center; background-color: #ffc107;">เรียกเก็บ</th>
                <th style="text-align: center; background-color: #ffc107;">ชดเชย</th>
				<th style="text-align: center; background-color: #ffc107;">จำนวน</th>
                <th style="text-align: center; background-color: #ffc107;">เรียกเก็บ</th>
                <th style="text-align: center; background-color: #ffc107;">ชดเชย</th>
				<th style="text-align: center; background-color: #ffc107;">จำนวน</th>
                <th style="text-align: center; background-color: #ffc107;">เรียกเก็บ</th>
                <th style="text-align: center; background-color: #ffc107;">ชดเชย</th>
				<th style="text-align: center; background-color: #ffc107;">จำนวน</th>
                <th style="text-align: center; background-color: #ffc107;">เรียกเก็บ</th>
                <th style="text-align: center; background-color: #ffc107;">ชดเชย</th>
				<th style="text-align: center; background-color: #ffc107;">จำนวน</th>
                <th style="text-align: center; background-color: #ffc107;">เรียกเก็บ</th>
                <th style="text-align: center; background-color: #ffc107;">ชดเชย</th>
				<th style="text-align: center; background-color: #ffc107;">จำนวน</th>
                <th style="text-align: center; background-color: #ffc107;">เรียกเก็บ</th>
                <th style="text-align: center; background-color: #ffc107;">ชดเชย</th>
				<th style="text-align: center; background-color: #ffc107;">จำนวน</th>
                <th style="text-align: center; background-color: #ffc107;">เรียกเก็บ</th>
                <th style="text-align: center; background-color: #ffc107;">ชดเชย</th>
				<th style="text-align: center; background-color: #ffc107;">จำนวน</th>
                <th style="text-align: center; background-color: #ffc107;">เรียกเก็บ</th>
                <th style="text-align: center; background-color: #ffc107;">ชดเชย</th>
				<th style="text-align: center; background-color: #ffc107;">จำนวน</th>
                <th style="text-align: center; background-color: #ffc107;">เรียกเก็บ</th>
                <th style="text-align: center; background-color: #ffc107;">ชดเชย</th>
				<th style="text-align: center; background-color: #ffc107;">จำนวน</th>
                <th style="text-align: center; background-color: #ffc107;">เรียกเก็บ</th>
                <th style="text-align: center; background-color: #ffc107;">ชดเชย</th>
				<th style="text-align: center; background-color: #ffc107;">จำนวน</th>
                <th style="text-align: center; background-color: #ffc107;">เรียกเก็บ</th>
                <th style="text-align: center; background-color: #ffc107;">ชดเชย</th>
            </tr>';
        }
    },
	  'options' => [
        'style' => 'overflow-x: auto; white-space: nowrap;', // เลื่อนในแนวนอน
    ],
]);



            ?>
			
			
            <p>***หมายเหตุ เฉพาะที่ส่งข้อมูลผ่าน API </p>
        </div>
    </div>
    