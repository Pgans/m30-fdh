<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="600"> <!-- 60 วินาทีหรือ 10 นาที -->
    <style>
        h5 {
            background-color: #008080;
            color: #ffffff;
            padding: 10px;
            border: 4px solid #c6dee3;
            border-radius: 8px;
        }

        #refreshTimer {
            color: yellow;
            border: 4px solid white;
            padding: 5px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
<?php
$this->title = 'ผลการส่งข้อมูล PHR ย้อนหลัง 1 ปี (ช่วงเวลา 1 มกราคม 2566 - ปัจจุบัน)';
$this->title .= ' ' . Html::a('Update 10', ['phrsend/update-send-phr-procedure'], ['class' => 'btn btn-success']);
$this->title .= ' ' . Html::a('Update All', ['phrsend/update-send-phr-all'], ['class' => 'btn btn-info']);
$this->title .= ' ' . Html::a('Delete log_phr', ['delete-log-phr'], ['class' => 'btn btn-danger']);
//$this->title .= ' ' . Html::a('ตรวจสอบ Json', ['phrjsontest/phr'], ['class' => 'btn btn-success']);
$this->title .= ' ' . Html::a('ตรวจสอบ Json', ['phrjsontest/phr'], ['class' => 'btn btn-success', 'id' => 'jsonLink']);
$this->title .= ' <span style="color: yellow;">Update :: ' . date('d-m-Y') . '</span>';
//$this->title .= ' ' . Html::button('Refresh', ['class' => 'btn btn-info', 'id' => 'refreshButton']);
$this->title .= '  '.' <span id="refreshTimer" style="border: 4px solid white; padding: 5px; border-radius: 10px;">60</span>';

?>
<script>
        var refreshCountdown = 600; // เริ่มต้นที่ 600 วินาที
        function updateRefreshTimer() {
            var timerElement = document.getElementById('refreshTimer');
            timerElement.innerHTML = refreshCountdown; // อัปเดตเวลาที่แสดง
            if (refreshCountdown > 0) {
                refreshCountdown--; // ลดเวลาลงทีละ 1 วินาที
            } else {
                refreshCountdown = 600; // รีเซ็ตเวลาเมื่อถึง 0
            }
        }

        setInterval(updateRefreshTimer, 1000); // อัปเดตทุก ๆ 10 นาที
    </script>
</body>

<h5><?= $this->title ?></h5>
<!-- <?php echo Html::a('Update SendPhr Procedure', ['update-send-phr-procedure'], ['class' => 'btn btn-primary']); ?> -->
 <!-- <?php echo Html::a('Update Phr ', ['phrsend/update-send-phr-procedure'], ['class' => 'btn btn-successs']); ?>  -->

<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-3 mb-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                        <!-- <h6 style="color: #6f6fff;">ข้อมูลบริการจาก mBase</h6> -->
                        <h6>ข้อมูลบริการ mBase</h6>
                        <!-- <p><span style="color: #ff8040; font-size: 14px;">นับจาก 1 มกราคม 2566</span></p> -->
                            
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                <span><?= number_format($totalx, 0, '', ',') ?></span>
                                </div>
                            </div>
                            <div class="col">
                                <!-- <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="col-auto">
                        <a href="<?= \yii\helpers\Url::to(['/phr/sendphr']) ?>" target="_blank">
                                <img src="images/accept.svg" title="ข้อมูลสำเร็จ" width="70" height="60">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-3 mb-3">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                            <h6>ส่งข้อมูลสำเร๊จ</h6>
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                <span><?= number_format($successx, 0, '', ',') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>

                        <div class="col-auto">
                            <a href="<?= \yii\helpers\Url::to(['/phr/logerr']) ?>" target="_blank">
                                <img src="images/reject.76840914.svg" title="ไม่ผ่าน" width="70" height="60">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <!-- Pending Requests Card Example -->
  <div class="col-xl-3 col-md-3 mb-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                            <h6>ยอดคงเหลือ</h6>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <span><?= number_format($nopassx, 0, '', ',') ?></span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <img src="images/waitmoph.98529de4.svg" title="เหลือ" width="70" height="60">
                    </div>
                </div>
            </div>
        </div>
    </div>

 <!-- Pending Requests Card Example -->
 <div class="col-xl-3 col-md-3 mb-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ">
                            <h6>เปอร์เซนต์</h6>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php $percentage = ($successx / $totalx) * 100; ?>
                        <span><?= number_format($percentage, 2) ?>%</span>
                        </div>
                    </div>
                    <div class="col-auto">
                    <img src="images/reject.76840914.svg" title="เปอร์เซนต์" width="70" height="60">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-info" id="success-alert">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php elseif (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger" id="error-alert">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<script>
// Automatically hide the success and error alerts after 5 seconds
setTimeout(function(){
    document.getElementById('success-alert')?.remove();
    document.getElementById('error-alert')?.remove();
}, 5000);
</script>


<div class="row">
    <div class="col-md-3">
    <div class="panel panel-info" style="border: 2px solid #5bc0de; padding: 15px; background-color: #ebf7fa;">
    <div class="panel-heading" style="background-color: #008080; color: #fff; font-size: 18px; border: 4px solid #b0e3e3;">
    <i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp;จำนวนการส่งข้อมูล
</div>

            <div class="panel-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider1,
                    'showFooter' => false,
                    'summary' => '',
                    'columns' => [
                        [
                            'attribute' => 'opd_date',
                            'contentOptions' => ['style' => 'text-overflow: ellipsis; white-space: nowrap; max-width: 25vw; overflow: hidden; font-size: 14px;'],
                            'label' => 'Date',
                        ],
                        [
                            'attribute' => 'total',
                            'contentOptions' => ['style' => 'text-overflow: ellipsis; white-space: nowrap; max-width: 25vw; overflow: hidden; font-size: 14px;'],
                            'label' => 'Total',
                        ],
                       
                        [
                            'attribute' => 'success',
                            'contentOptions' => ['style' => 'text-overflow: ellipsis; white-space: nowrap; max-width: 25vw; overflow: hidden; font-size: 14px;'],
                            'format' => 'raw',
                            'value' => function ($model) {
                                $regdate = $model['opd_date'];
                                $url = Yii::$app->urlManager->createUrl(['phrsend/index', 'regdate' => $regdate]);
                                return Html::a(Html::encode($model['success']), $url);
                            },
                        ],
                        [
                            'attribute' => 'nopass',
                            'contentOptions' => ['style' => 'text-overflow: ellipsis; white-space: nowrap; max-width: 25vw; overflow: hidden; font-size: 14px;'],
                            'format' => 'raw',
                            'value' => function ($model) {
                                $regdate = $model['opd_date'];
                                $url = Yii::$app->urlManager->createUrl(['phrsend/index', 'regdate' => $regdate]);
                                return Html::a(Html::encode($model['nopass']), $url);
                            },
                        ],
                    ],
                    'options' => ['class' => 'table-responsive'],
                    'tableOptions' => ['class' => 'table table-striped'],
                ]); ?>
            </div>
        </div>
    </div>

    <div class="col-md-9">
    <div class="panel panel-info" style="border: 2px solid #5bc0de; padding: 15px; background-color: #ebf7fa;">
    <div class="panel-heading" style="background-color: #008080; color: #fff; font-size: 18px; border: 4px solid #b0e3e3;">
    <i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp;แสดงรายการส่งข้อมูล
</div>

        <div class="panel-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider2,
                'summary' => '',
                'columns' => [
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'checkboxOptions' => function ($model, $key, $index, $column) {
                            return ['value' => $model['visit_id']];
                        },
                    ],
                    
                    [
                        'attribute' => 'visit_id',
                        'contentOptions' => [
                            'style' => 'text-overflow: ellipsis; white-space: nowrap; max-width: 25vw; overflow: hidden; font-size: 13px; font-weight: normal;', 
                        ],
                        'label' => 'Visit ID',
                    ],
                    [
                        'attribute' => 'cid',
                        'contentOptions' => ['style' => 'text-overflow: ellipsis; white-space: nowrap; max-width: 25vw; overflow: hidden; font-size: 14px;'],
                        'label' => 'Cid',
                    ],
                    [
                        'attribute' => 'response',
                        'contentOptions' => ['style' => 'text-overflow: ellipsis; white-space: nowrap; max-width: 25vw; overflow: hidden; font-size: 14px;'],
                        'label' => 'Response',
                    ],
                    
                    [
                        'attribute' => 'regdate',
                        'contentOptions' => ['style' => 'text-overflow: ellipsis; white-space: nowrap; max-width: 25vw; overflow: hidden; font-size: 14px;'],
                        'label' => 'Regdate',
                    ],
                    [
                        'attribute' => 'd_update',
                        'contentOptions' => ['style' => 'text-overflow: ellipsis; white-space: nowrap; max-width: 25vw; overflow: hidden; font-size: 14px;'],
                        'label' => 'D_update',
                    ],
                    [
                        'attribute' => 'status',
                        'contentOptions' => ['style' => 'text-overflow: ellipsis; white-space: nowrap; max-width: 25vw; overflow: hidden; font-size: 14px;'],
                        'label' => 'Status',
                    ],
                    

                    [
                        'attribute' => 'visit_id', // Assuming 'visit_id' is a valid attribute of your model
                        'format' => 'raw',
                        'value' => function ($model) {
                            $regdate = Yii::$app->request->get('regdate');
                            $url = Yii::$app->urlManager->createUrl(['phrsend/delete', 'regdate' => $regdate, 'visit_id' => $model['visit_id']]);
                            
                            return Html::a('<i class="fa fa-trash"></i>', $url, [
                               // 'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => "Are you sure you want to delete this item with visit_id {$model['visit_id']}?",
                                    'method' => 'post',
                                ],
                            ]);
                        },
                    ],
                    
                    
                ],
                'options' => ['class' => 'table-responsive'],
                'tableOptions' => ['class' => 'table table-striped'],
            ]); ?>
        </div>
    </div>
</div>

                <!-- <?= GridView::widget([
                    'dataProvider' => $dataProvider3,
                    'columns' => [
                        [
                            'attribute' => 'visit_id',
                            'label' => 'Visit ID',
                        ],
                        'cid',
                        'response',
                        [
                            'attribute' => 'regdate',
                            'label' => 'Regdate',
                        ],
                        'd_update',
                        'status',
                        // Add more columns for $dataProvider3 if needed
                    ],
                    'options' => ['class' => 'table-responsive'],
                    'tableOptions' => ['class' => 'table table-striped'],
                ]); ?>
            </div>
        </div>
    </div>
</div> -->

<?php
$this->registerJs('
    $("#delete-selected-btn").on("click", function() {
        var selectedRows = $("input[name=\'selection[]\']:checked");
        var selectedIds = selectedRows.map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            alert("กรุณาเลือกก่อนลบ.");
            return;
        }

        if (confirm("ยืนยันการลบข้อมูล?")) {
            $.post("' . Yii::$app->urlManager->createUrl(['phrsend/delete-selected']) . '", {ids: selectedIds}, function(data) {
                // Handle success or error here
                console.log(data);
            });
        }
    });
');
?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var jsonLink = document.getElementById('jsonLink');

    if (jsonLink) {
        jsonLink.addEventListener('click', function (event) {
            event.preventDefault();
            openPopup(jsonLink.href);
        });
    }

    function openPopup(url) {
        var width = 800; // กำหนดความกว้างของ popup
        var height = 600; // กำหนดความสูงของ popup
        var left = (window.innerWidth - width) / 2;
        var top = (window.innerHeight - height) / 2;

        window.open(url, '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,width=' + width + ',height=' + height + ',top=' + top + ',left=' + left);
    }
});
</script>
