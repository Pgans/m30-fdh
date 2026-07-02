<?php

use yii\helpers\Html;
#use yii\grid\GridView;
use kartik\grid\GridView;
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



            <?=
		
 GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => ['class' => 'table table-bordered'],
	'showPageSummary' => true, // เปิดการแสดงผลรวม
    'rowOptions' => function ($model, $key, $index, $grid) {
        return ['style' => $index % 2 === 0 ? 'background-color: #ebf7f4;' : ''];
    },
    'columns' => [
        [
            'attribute' => 'users',
            'label' => 'กองทุนย่อย',
            'headerOptions' => ['style' => 'background-color: #035744; color: black; text-align: center; vertical-align: middle;'],
            'contentOptions' => ['style' => 'background-color: #ebf7f4;'],
			'pageSummary' => 'รวมทั้งหมด',
        ],
        [
            'attribute' => 'r10',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #035744;'],
			'pageSummary' => true,
        ],
       [
            'attribute' => 'hosp_claim_10',
            'label' => 'เรียกเก็บ',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_10',
            'label' => 'ชดเชย',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
        [
            'attribute' => 'r11',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #035744;'],
			'pageSummary' => true,
        ],
        [
            'attribute' => 'hosp_claim_11',
            'label' => 'เรียกเก็บ',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_11',
            'label' => 'ชดเชย',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'r12',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #035744;'],
			'pageSummary' => true,
        ],
        [
            'attribute' => 'hosp_claim_12',
            'label' => 'เรียกเก็บ',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_12',
            'label' => 'ชดเชย',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'r1',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #035744;'],
			'pageSummary' => true,
        ],
        [
            'attribute' => 'hosp_claim_1',
            'label' => 'เรียกเก็บ',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_1',
            'label' => 'ชดเชย',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'r2',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #035744;'],
			'pageSummary' => true,
        ],
        [
            'attribute' => 'hosp_claim_2',
            'label' => 'เรียกเก็บ',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_2',
            'label' => 'ชดเชย',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'r3',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #035744;'],
			'pageSummary' => true,
        ],
        [
            'attribute' => 'hosp_claim_3',
            'label' => 'เรียกเก็บ',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_3',
            'label' => 'ชดเชย',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		
		[
            'attribute' => 'r4',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #035744;'],
			'pageSummary' => true,
        ],
        [
            'attribute' => 'hosp_claim_4',
            'label' => 'เรียกเก็บ',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_4',
            'label' => 'ชดเชย',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		
		[
            'attribute' => 'r5',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #035744;'],
			'pageSummary' => true,
        ],
        [
            'attribute' => 'hosp_claim_5',
            'label' => 'เรียกเก็บ',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_5',
            'label' => 'ชดเชย',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		
		[
            'attribute' => 'r6',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #035744;'],
			'pageSummary' => true,
        ],
        [
            'attribute' => 'hosp_claim_6',
            'label' => 'เรียกเก็บ',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_6',
            'label' => 'ชดเชย',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		
		[
            'attribute' => 'r7',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #035744;'],
			'pageSummary' => true,
        ],
        [
            'attribute' => 'hosp_claim_7',
            'label' => 'เรียกเก็บ',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_7',
            'label' => 'ชดเชย',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'r8',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #035744;'],
			'pageSummary' => true,
        ],
        [
            'attribute' => 'hosp_claim_8',
            'label' => 'เรียกเก็บ',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_8',
            'label' => 'ชดเชย',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		
		[
            'attribute' => 'r9',
            'label' => 'จำนวน',
            'headerOptions' => ['style' => 'text-align: center; background-color: #035744;'],
			'pageSummary' => true,
        ],
        [
            'attribute' => 'hosp_claim_9',
            'label' => 'เรียกเก็บ',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		[
            'attribute' => 'ret_statement_9',
            'label' => 'ชดเชย',
            'format' => ['decimal', 2],
            'pageSummary' => true,
        ],
		
		[
            'attribute' => 'total',
            'label' => 'รวม',
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

        $header = '<tr>
            <th rowspan="2" style="text-align: center; vertical-align: middle; background-color: #607D8B; color: white;">กองทุนย่อย</th>';
        
        foreach ($months as $month) {
            $header .= '<th colspan="3" style="text-align: center; background-color: #9E9E9E; color: white;">' . $month . '</th>';
        }

        $header .= '</tr><tr>';

        foreach ($months as $i => $month) {
            $bgColor = ($i % 2 == 0) ? '#ffffff' : '#d3ede8'; // สลับสีขาว-เทา
            $header .= '<th style="text-align: center; background-color: ' . $bgColor . ';">จำนวน</th>';
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
    <!--###################### สลับสีคอลัมน์ #################################################-->
	
  <style>
    /* กำหนดให้แต่ละชุดของ 3 คอลัมน์ (เดือน) มีสีเดียวกัน */
    th:nth-child(n+2):nth-child(-n+4),
    td:nth-child(n+2):nth-child(-n+4) {
        background-color: #ffffff; /* สีขาว */
    }

    th:nth-child(n+5):nth-child(-n+7),
    td:nth-child(n+5):nth-child(-n+7) {
        background-color: #f5f5f5; /* สีเทาอ่อน */
    }

    th:nth-child(n+8):nth-child(-n+10),
    td:nth-child(n+8):nth-child(-n+10) {
        background-color: #ffffff; /* สีขาว */
    }

    th:nth-child(n+11):nth-child(-n+13),
    td:nth-child(n+11):nth-child(-n+13) {
        background-color: #f5f5f5; /* สีเทาอ่อน */
    }

    th:nth-child(n+14):nth-child(-n+16),
    td:nth-child(n+14):nth-child(-n+16) {
        background-color: #ffffff; /* สีขาว */
    }

    th:nth-child(n+17):nth-child(-n+19),
    td:nth-child(n+17):nth-child(-n+19) {
        background-color: #f5f5f5; /* สีเทาอ่อน */
    }

    th:nth-child(n+20):nth-child(-n+22),
    td:nth-child(n+20):nth-child(-n+22) {
        background-color: #ffffff; /* สีขาว */
    }

    th:nth-child(n+23):nth-child(-n+25),
    td:nth-child(n+23):nth-child(-n+25) {
        background-color: #f5f5f5; /* สีเทาอ่อน */
    }

    th:nth-child(n+26):nth-child(-n+28),
    td:nth-child(n+26):nth-child(-n+28) {
        background-color: #ffffff; /* สีขาว */
    }

    th:nth-child(n+29):nth-child(-n+31),
    td:nth-child(n+29):nth-child(-n+31) {
        background-color: #f5f5f5; /* สีเทาอ่อน */
    }

    th:nth-child(n+32):nth-child(-n+34),
    td:nth-child(n+32):nth-child(-n+34) {
        background-color: #ffffff; /* สีขาว */
    }

    th:nth-child(n+35):nth-child(-n+37),
    td:nth-child(n+35):nth-child(-n+37) {
        background-color: #f5f5f5; /* สีเทาอ่อน */
    }
	 /* ✅ เพิ่มสี Hover เมื่อชี้ที่แถว */
    tr:hover td {
        background-color: #b2f7e6!important; 
        transition: background-color 0.3s ease-in-out;
    }
</style>
