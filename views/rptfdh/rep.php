<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = 'รายการนำเข้า REP';
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
</div>
</br>
<div class="rep-index">
    <div class="panel panel-primary custom-panel">
        <div class="panel-heading text-center">
            <i class="glyphicon glyphicon-list-alt"></i> <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

            <?php Pjax::begin(); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
				'summary' =>'',
                'tableOptions' => ['class' => 'table table-bordered table-striped table-hover custom-table'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn', 'header' => 'ลำดับ'],

                    [
                        'attribute' => 'pt_type',
                        'label' => 'ประเภทผู้ป่วย',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'tran_id',
                        'label' => 'tran_id',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                   [
						'attribute' => 'rep_no',
						'label' => 'Rep',
						'contentOptions' => ['class' => 'text-center', 'style' => 'color: #007bff;'],
					],

                    [
                        'attribute' => 'dt_rep',
                       // 'label' => 'วันที่รายงาน',
                        'format' => ['date', 'php:d/m/Y'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'dt_statement',
                       // 'label' => 'รายละเอียด',
                        'contentOptions' => ['class' => 'text-left'],
                    ],

                    //['class' => 'yii\grid\ActionColumn', 'header' => 'จัดการ'],
                ],
            ]); ?>

            <?php Pjax::end(); ?>

        </div>
    </div>
</div>

<!-- CSS ปรับแต่งเพิ่มเติม -->
<style>
    /* ปรับแต่ง Panel */
    .custom-panel {
        border-radius: 10px;
        border: 3px solid #1E90FF;
        box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }

    .panel-heading {
        background: linear-gradient(to right, #007bff, #00c6ff);
        color: white;
        font-size: 18px;
        font-weight: bold;
        padding: 15px;
        border-bottom: 0px solid #1E90FF;
    }

    .panel-body {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 0 0 10px 10px;
    }

    /* ปรับแต่ง GridView */
    .custom-table {
        border: 2px solid #007bff;
        border-radius: 10px;
        overflow: hidden;
    }
   .custom-table th {
    background-color: transparent !important; /* ไม่มีสีพื้นหลัง */
    color: black !important; /* เปลี่ยนเป็นสีตัวอักษรสีดำ */
    text-align: center;
    border-bottom: 2px solid #007bff; /* สามารถลบออกได้หากไม่ต้องการเส้นขอบ */
}


    .custom-table tbody tr:nth-child(even) {
        background-color: #e3f2fd !important; /* ฟ้าอ่อน */
    }

    .custom-table tbody tr:nth-child(odd) {
        background-color: #ffffff !important; /* ขาว */
    }

    .custom-table tbody tr:hover {
        background-color: #d1ecf1 !important; /* สีฟ้าอ่อนเมื่อ hover */
    }
</style>
