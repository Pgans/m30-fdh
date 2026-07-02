<?php
use yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\grid\GridView;
use yii\helpers\Url;
?>

<style>
    /* การตกแต่ง .well ให้มีการใช้ gradient สีเขียวและมุมโค้ง */
    .well {
        background: linear-gradient(to right, #a8e6cf, #d0f4de); /* Gradient สีเขียว */
        border-radius: 12px; /* ขอบโค้งมน */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* ขอบเงา 3 มิติ */
        padding: 20px;
        margin: 20px 0;
    }

    /* ทำให้ DatePicker (input) มีขอบโค้งมนและการจัดการให้ดูดี */
    .ui-datepicker-input {
        border-radius: 10px !important; /* มุมโค้งมน */
        padding: 8px 12px; /* ระยะห่างภายใน */
        border: 1px solid #ccc; /* ขอบสีเทา */
        font-size: 14px; /* ขนาดตัวอักษร */
    }

    .ui-datepicker-input:focus {
        border-color: #56ab2f; /* ขอบสีเขียวเมื่อ focus */
        box-shadow: 0 0 5px rgba(86, 171, 47, 0.7); /* เพิ่มเงาเมื่อเลือก */
    }

    .ui-datepicker {
        border-radius: 12px !important; /* ขอบโค้งมน */
    }

    /* ปรับปรุงปุ่มให้ดูสวยงาม */
    .btn-danger {
        border-radius: 25px; /* ขอบโค้งมน */
        padding: 10px 20px;
        background-color: #d9534f;
        color: white;
        border: none;
        font-size: 16px;
    }

    .btn-danger:hover {
        background-color: #c9302c;
    }

    /* ตกแต่ง GridView */
    .table-bordered {
        border: 1px solid #ccc; /* ขอบกรอบสีเทา */
        border-radius: 10px; /* มุมโค้งมน */
        overflow: hidden;
    }

    .table thead {
        background-color: #56ab2f; /* สีเขียว */
        color: white;
    }

    .table th, .table td {
        text-align: center; /* จัดให้อยู่กลาง */
        padding: 12px; /* ระยะห่างภายใน */
    }

    .table tbody tr:nth-child(even) {
        background-color: #f9f9f9; /* สีพื้นหลังแถวคู่ */
    }

    .table tbody tr:nth-child(odd) {
        background-color: #ffffff; /* สีพื้นหลังแถวคี่ */
    }

    .table tbody tr:hover {
        background-color: #f1f1f1; /* สีพื้นหลังเมื่อ hover */
    }

    .table td {
        font-size: 14px; /* ขนาดตัวอักษร */
    }
	
</style>
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
<div class="report-index">
   
        <?php $form = ActiveForm::begin(); ?>
        <label for="date1">ระหว่างวันที่:</label>
        <?php
        echo DatePicker::widget([
            'name' => 'date1',
            'value' => Yii::$app->request->post('date1', date('Y-m-d')),
            'language' => 'th',
            'dateFormat' => 'yyyy-MM-dd',
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
            ]
        ]);
        ?>

        <label for="date2">ถึง:</label>
        <?php
        echo DatePicker::widget([
            'name' => 'date2',
            'value' => Yii::$app->request->post('date2', date('Y-m-d')),
            'language' => 'th',
            'dateFormat' => 'yyyy-MM-dd',
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
            ]
        ]);
        ?>
        <button class="btn btn-danger">ตกลง</button>
        <?php ActiveForm::end(); ?>
    </div>
	
	
 <div class="col-md-12 mb-6">
            <div class="card-body">
                <div class="wellx">
   

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
						'layout' => "{items}", // เอา layout อื่นออกเพื่อไม่ให้แสดง summary
                        'tableOptions' => ['class' => 'table table-bordered table-hover table-striped'],
                        'showPageSummary' => true, // เปิดการแสดงผลรวม
											
        'panel' => [
            'before'=>'<b style="color:blue "></b>',
            'after'=>'ประมวลผล '.date('Y-m-d H:i:s')
            ],
                        'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'attribute' => 'IPUC',
            'label' => '🛏️ กองทุน IPUC',
        ],
        [
            'attribute' => 'amount',
            'label' => '📅 จำนวน_case',
            'pageSummary' => 'รวมทั้งหมด',
        ],
        [
            'attribute' => 'ชดเชยรวมเป็นเงิน',
            'label' => '🏥 ชดเชยรวมเป็นเงิน',
            'contentOptions' => ['class' => 'text-center'],  // จัดตำแหน่งตัวเลขให้ตรงกลาง
            'pageSummary' => true,
        ],
        [
            'attribute' => 'ลูกหนี้ค่าใช้จ่ายต่ำ',
            'label' => '🛋️ ลูกหนี้ค่าใช้จ่ายต่ำ',
            'contentOptions' => ['class' => 'text-center'],  // จัดตำแหน่งตัวเลขให้ตรงกลาง
            'pageSummary' => true,
        ],
        [
            'attribute' => 'ลูกหนี้ค่าใช้จ่ายสูง',
            'label' => '🛏️ลูกหนี้ค่าใช้จ่ายสูง',
            'contentOptions' => ['class' => 'text-center'],  // จัดตำแหน่งตัวเลขให้ตรงกลาง
            'pageSummary' => true,
        ],
    ],
    'summary' => '<div style="font-size: 1.2rem; font-weight: bold;">แสดง {begin} - {end} จาก {totalCount} รายการ</div>',
    'pager' => [
        'class' => 'yii\widgets\LinkPager',
        'options' => ['class' => 'pagination justify-content-center'],
    ],
    'beforeHeader' => [
        
    ],
    'tableOptions' => [
        'class' => 'table table-bordered',
        'style' => 'border: 1px solid #ccc;'
    ],
    'headerRowOptions' => [
        'style' => 'background-color: #4CAF50; color: white;',  // สีพื้นหลังหัวตารางเป็นเขียว และฟอนต์เป็นสีขาว
    ],
 ]); ?>
        </div>
    </div>
</div>
<style>
.table-wrapper {
    max-height: 500px;
    overflow-y: auto;
    border: 1px solid #ddd;
}

/* sticky header */
.fixed-header-table thead th {
    position: sticky;
    top: 0;
    background-color: #4CAF50;
    color: white;
    text-align: center;
    padding: 10px;
    border: 1px solid #ddd;
    z-index: 10;
}

/* ปรับ td ให้ตรงกับ th โดยไม่ต้องแยก block */
.fixed-header-table th,
.fixed-header-table td {
    padding: 10px;
    border: 1px solid #ddd;
    box-sizing: border-box;
}

/* hover สีเขียวอ่อน */
.fixed-header-table tbody tr:hover {
    background-color: #d0f0c0;
}

</style>



<div class="table-wrapper">
    <?= GridView::widget([
        'dataProvider' => $data1Provider,
        'layout' => "{items}",
       'tableOptions' => [
            'class' => 'table table-bordered table-hover table-striped fixed-header-table',
            'style' => 'width:100%; border-collapse:collapse;',
        ],
							
        'panel' => [
            'before'=>'<b style="color:blue "></b>',
            'after'=>'ประมวลผล '.date('Y-m-d H:i:s')
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 
                'headerOptions'=>['style'=>'width:40px;'], 
                'contentOptions'=>['style'=>'text-align:center;']
            ],
            ['attribute'=>'Doctor', 'label'=>'แพทย์ตรวจ',
                'headerOptions'=>['style'=>'width:120px;'], 
                'contentOptions'=>['style'=>'text-align:center;']
            ],
            ['attribute'=>'hn', 'label'=>'HN',
                'headerOptions'=>['style'=>'width:60px;'], 
                'contentOptions'=>['style'=>'text-align:center;']
            ],
            ['attribute'=>'ADM_ID', 'label'=>'AN',
                'headerOptions'=>['style'=>'width:60px;'], 
                'contentOptions'=>['style'=>'text-align:center;']
            ],
            ['attribute'=>'fullname', 'label'=>'ชื่อ-นามสกุล',
                'headerOptions'=>['style'=>'width:140px;'], 
                'contentOptions'=>['style'=>'text-align:center;']
            ],
            ['attribute'=>'ADM_DT', 'label'=>'วันเข้ารักษา',
                'headerOptions'=>['style'=>'width:120px;'], 
                'contentOptions'=>['style'=>'text-align:center;']
            ],
            ['attribute'=>'DSC_DT', 'label'=>'วันออก',
                'headerOptions'=>['style'=>'width:120px;'], 
                'contentOptions'=>['style'=>'text-align:center;']
            ],
            ['attribute'=>'ADJRW','label'=>'ADJRW',
                'headerOptions'=>['style'=>'width:100px;'], 
                'contentOptions'=>['style'=>'text-align:center;']
            ],
            ['attribute'=>'INSCL_NAME','label'=>'สิทธิ์',
                'headerOptions'=>['style'=>'width:100px;'], 
                'contentOptions'=>['style'=>'text-align:center;']
            ],
            ['attribute'=>'rep_no','label'=>'Rep',
                'headerOptions'=>['style'=>'width:80px;'], 
                'contentOptions'=>['style'=>'text-align:center;']
            ],
            ['attribute'=>'tran_id','label'=>'Trans_id',
                'headerOptions'=>['style'=>'width:80px;'], 
                'contentOptions'=>['style'=>'text-align:center;']
            ],
            ['attribute'=>'หอผู้ป่วยใน','label'=>'หอผู้ป่วย',
                'headerOptions'=>['style'=>'width:110px;'], 
                'contentOptions'=>['style'=>'text-align:center;']
            ],
            ['attribute'=>'แจ้งหนี้ Mbase','label'=>'แจ้งหนี้ Mbase',
                'headerOptions'=>['style'=>'width:150px;'], 
                'contentOptions'=>['style'=>'text-align:center;']
            ],
            ['attribute'=>'ยอดเรียกเคลม E-Claim','label'=>'ยอดเรียกเก็บ',
                'headerOptions'=>['style'=>'width:150px;'], 
                'contentOptions'=>['style'=>'text-align:center;']
            ],
            ['attribute'=>'ยอดชดเชย STM','label'=>'ยอดชดเชย',
                'headerOptions'=>['style'=>'width:150px;'], 
                'contentOptions'=>['style'=>'text-align:center;']
            ],
            ['attribute'=>'ลูกหนี้ค่าใช้จ่ายตำ','label'=>'ค่าใช้จ่ายตำ',
                'headerOptions'=>['style'=>'width:150px;'], 
                'contentOptions'=>['style'=>'text-align:center;']
            ],
            ['attribute'=>'ลูกหนี้ค่าใช้จ่ายสูง','label'=>'ค่าใช้จ่ายสูง',
                'headerOptions'=>['style'=>'width:150px;'], 
                'contentOptions'=>['style'=>'text-align:center;']
            ],
            ['attribute'=>'acc_name','label'=>'กองทุน',
                'headerOptions'=>['style'=>'width:150px;'], 
                'contentOptions'=>['style'=>'text-align:center;']
            ],
        ],
        'summary' => '<div style="font-size: 1.2rem; font-weight: bold;">แสดง {begin} - {end} จาก {totalCount} รายการ</div>',
        'pager' => [
            'class' => 'yii\widgets\LinkPager',
            'options' => ['class' => 'pagination justify-content-center']
        ],
    ]); ?>
</div>
