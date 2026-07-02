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
        background-color: #d091ed;
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
        background-color: #d091ed; /* สีเขียว */
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
    <h3><a>ลูกหนี้หลังรับ STM ผู้ป่วยนอก</a></h3>
    <div class="well">
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
                   <h5 class="card-title text-primary mb-3">
    ลูกหนี้แบบสรุป STM ผู้ป่วยนอก
    <?php if (!empty($departmentName)): ?>
        - แผนก: <?= htmlspecialchars($departmentName, ENT_QUOTES, 'UTF-8') ?>
    <?php endif; ?>วันที่เริ่มต้น: <?= $date1 ?>----วันที่สิ้นสุด: <?= $date2 ?>
</h5>


                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
						'layout' => "{items}", // เอา layout อื่นออกเพื่อไม่ให้แสดง summary
                        'tableOptions' => ['class' => 'table table-bordered table-hover table-striped'],
                        'showPageSummary' => true, // เปิดการแสดงผลรวม
						
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
            'label' => '🛏️ ลูกหนี้ค่าใช้จ่ายสูง',
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
        [
            'columns' => [
                ['content' => '📊 ข้อมูลรายงาน', 'options' => ['colspan' => 6, 'class' => 'text-center']],
            ],
            'options' => ['class' => 'danger'], // สีพื้นหลังหัวข้อ
        ]
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
    max-height: 600px;
    overflow-y: auto;
    overflow-x: auto;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    background-color: #ffffff;
}
</style>

<?php


echo '<div class="table-wrapper">';
echo GridView::widget([
    'dataProvider' => $data1Provider,
    'layout' => "{items}\n{summary}\n{pager}",
    'floatHeader' => true, // ทำให้หัวตารางลอยคงที่
    'floatHeaderOptions' => ['scrollingTop' => 10],
    'responsive' => true,
    'hover' => true,
    'striped' => true,
    'bordered' => true,
    'condensed' => true,
    'resizableColumns' => true,
    'headerRowOptions' => ['style' => 'background-color: #007bff; color: white; text-align: center;'],
    'tableOptions' => ['class' => 'table table-bordered'],
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn',
            'headerOptions' => ['style' => 'width:40px; text-align: center;'],
            'contentOptions' => ['style' => 'text-align: center;'],
        ],
        [
            'attribute' => 'reg_datetime',
            'label' => '🛏️ วันรับบริการ',
            'headerOptions' => ['style' => 'text-align: center;'],
            'contentOptions' => ['style' => 'text-align: center;'],
        ],
        [
            'attribute' => 'hn',
            'label' => '📅 hn',
            'headerOptions' => ['style' => 'text-align: center;'],
            'contentOptions' => ['style' => 'text-align: center;'],
        ],
        [
            'attribute' => 'fullname',
            'label' => '🛋️ ชื่อ--นามสกุล',
            'headerOptions' => ['style' => 'text-align: center;'],
            'contentOptions' => ['style' => 'text-align: left;'],
        ],
        [
            'attribute' => 'INSCL_NAME',
            'label' => '🛏️ สิทธิ์',
            'headerOptions' => ['style' => 'text-align: center;'],
            'contentOptions' => ['style' => 'text-align: center;'],
        ],
        [
            'attribute' => 'rep_no',
            'label' => '🛏️ Rep',
            'headerOptions' => ['style' => 'text-align: center;'],
            'contentOptions' => ['style' => 'text-align: center;'],
        ],
        [
            'attribute' => 'UNIT_NAME',
            'label' => '🛏️ แผนก',
            'headerOptions' => ['style' => 'text-align: center;'],
            'contentOptions' => ['style' => 'text-align: center;'],
        ],
        [
            'attribute' => 'แจ้งหนี้ Mbase',
            'label' => '🛏️ แจ้งหนี้Mbase',
            'headerOptions' => ['style' => 'text-align: center;'],
            'contentOptions' => ['style' => 'text-align: right;'],
        ],
        [
            'attribute' => 'ยอดเรียกเคลม E-Claim',
            'label' => '🛏️ เรียกเก็บ',
            'headerOptions' => ['style' => 'text-align: center;'],
            'contentOptions' => ['style' => 'text-align: right;'],
        ],
        [
            'attribute' => 'ยอดชดเชย STM',
            'label' => '🛏️ ยอดชดเชย',
            'headerOptions' => ['style' => 'text-align: center;'],
            'contentOptions' => ['style' => 'text-align: right;'],
        ],
        [
            'attribute' => 'ลูกหนี้ค่าใช้จ่ายตำ',
            'label' => '🛏️ ค่าใช้จ่ายตำ',
            'headerOptions' => ['style' => 'text-align: center;'],
            'contentOptions' => ['style' => 'text-align: right;'],
        ],
        [
            'attribute' => 'ลูกหนี้ค่าใช้จ่ายสูง',
            'label' => '🛏️ ค่าใช้จ่ายสูง',
            'headerOptions' => ['style' => 'text-align: center;'],
            'contentOptions' => ['style' => 'text-align: right;'],
        ],
        [
            'attribute' => 'users',
            'label' => '🛏️ กองทุน',
            'headerOptions' => ['style' => 'text-align: center;'],
            'contentOptions' => ['style' => 'text-align: center;'],
        ],
        [
            'attribute' => 'acc_name',
            'label' => '🛏️ กองทุน',
            'headerOptions' => ['style' => 'text-align: center;'],
            'contentOptions' => ['style' => 'text-align: center;'],
        ],
    ],
    'summary' => '<div style="font-size: 1rem; font-weight: bold;">แสดง {begin} - {end} จาก {totalCount} รายการ</div>',
    'pager' => [
        'class' => 'yii\widgets\LinkPager',
        'options' => ['class' => 'pagination justify-content-center'],
    ],
]);
echo '</div>';
?>
