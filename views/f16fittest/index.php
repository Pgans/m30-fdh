<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use dosamigos\datepicker\DatePicker;

$this->title = 'Mbase-FitTest บริการคัดกรองมะเร็งลำไส้ใหญ่';

// ลงทะเบียน CSS แบบ Modern
$this->registerCss("
    body { background-color: #f4f7f6; font-family: 'Sarabun', sans-serif; color: #333; }
    
    /* Header Card */
    .header-banner {
        background: linear-gradient(135deg, #1e5b53, #2d8a7d);
        color: white;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    /* Modern Info Card */
    .info-card {
        background: #fff;
        border: none;
        border-radius: 15px;
        padding: 20px;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .info-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
    .card-label { font-size: 14px; color: #777; font-weight: 600; }
    .card-value { font-size: 28px; font-weight: bold; color: #2d8a7d; margin: 5px 0; }

    /* Table Styling */
    .table-container {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .my-striped-table thead th {
        background-color: #f8f9fa;
        color: #444;
        font-weight: 600;
        border-bottom: 2px solid #eee !important;
        text-transform: uppercase;
        font-size: 13px;
        padding: 15px !important;
    }
    .my-striped-table tbody td { padding: 12px 15px !important; vertical-align: middle; border-bottom: 1px solid #f1f1f1; font-size: 14px; }
    .my-striped-table tbody tr:hover { background-color: #f9fffb !important; }

    /* Floating Button */
    .btn-floating-send {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
        background: linear-gradient(135deg, #28a745, #218838);
        color: white;
        padding: 15px 40px;
        border-radius: 50px;
        font-size: 18px;
        font-weight: bold;
        box-shadow: 0 10px 20px rgba(40, 167, 69, 0.3);
        border: none;
        transition: all 0.3s;
    }
    .btn-floating-send:hover { transform: translateX(-50%) scale(1.05); box-shadow: 0 15px 30px rgba(40, 167, 69, 0.4); color: white; }

    /* Custom Scrollbar */
    #scroll-area::-webkit-scrollbar { width: 6px; }
    #scroll-area::-webkit-scrollbar-track { background: #f1f1f1; }
    #scroll-area::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
");
?>

<div class="container-fluid py-4">
    
    <div class="header-banner">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="m-0"><i class="fas fa-microscope mr-2"></i> Fit-Test Dashboard</h3>
                <p class="m-0 opacity-75">คัดกรองมะเร็งลำไส้ใหญ่และลำไส้ตรง (อายุ 50-70 ปี)</p>
            </div>
            <div class="col-md-4 text-right">
                <span class="badge badge-warning p-2">ICD10: Z12.1</span>
                <span class="badge badge-light p-2 text-dark">ค่าบริการ 60.-</span>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="info-card">
                <div>
                    <span class="card-label">รายการผ่านวันนี้</span>
                    <div class="card-value"><?= number_format($amount) ?></div>
                </div>
                <div class="mt-3">
                    <?= Html::a('<i class="fas fa-file-alt"></i> เปิดไฟล์', '#', [
                        'class' => 'btn btn-sm btn-outline-primary btn-round',
                        'data-toggle' => 'modal', 'data-target' => '#myModal',
                        'data-url' => Url::to(['f16erext/list-files-partial']),
                    ]) ?>
                    <button class="btn btn-sm btn-success" id="link1">ดูรายการ</button>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="info-card" style="border-left: 5px solid #ff4757;">
                <div>
                    <span class="card-label">จัดการ Token / ส่งไม่ผ่าน</span>
                    <div class="card-value text-danger">Check Error</div>
                </div>
                <div class="mt-3">
                    <a href="<?= Url::to(['f16fittest/run-curl']) ?>" class="btn btn-sm btn-danger"><i class="fas fa-sync"></i> Refresh Token</a>
                    <button class="btn btn-sm btn-outline-danger" id="link2">ดูข้อผิดพลาด</button>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-card">
                <span class="card-label mb-2"><i class="fas fa-calendar-alt"></i> ช่วงวันที่รับบริการ</span>
                <?php $form = \yii\widgets\ActiveForm::begin(['method' => 'get', 'options' => ['class' => 'row']]); ?>
                <div class="col-md-4">
                    <?= DatePicker::widget([
                        'name' => 'date1', 'value' => $date1,
                        'options' => ['class' => 'form-control', 'placeholder' => 'เริ่ม'],
                        'clientOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd']
                    ]) ?>
                </div>
                <div class="col-md-4">
                    <?= DatePicker::widget([
                        'name' => 'date2', 'value' => $date2,
                        'options' => ['class' => 'form-control', 'placeholder' => 'สิ้นสุด'],
                        'clientOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd']
                    ]) ?>
                </div>
                <div class="col-md-4">
                    <?= Html::submitButton('<i class="fas fa-search"></i> ค้นหา', ['class' => 'btn btn-primary btn-block']) ?>
                </div>
                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>
        </div>
    </div>

    <div class="table-container">
        <?= Html::beginForm(['f16fittest/data'], 'post', ['name' => 'frmMain', 'id' => 'main-form']); ?>
        <div id="scroll-area" style="max-height: 600px; overflow-y: auto;">
            <table class="table my-striped-table m-0">
                <thead>
                    <tr>
                        <th width="40" class="text-center">
                            <input type="checkbox" id="CheckAll" onClick="ClickCheckAll(this);">
                        </th>
                        <th width="50">#</th>
                        <th>วันที่รับบริการ</th>
                        <th>Visit ID</th>
                        <th>HN</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th class="text-center">อายุ</th>
                        <th>สิทธิ์</th>
                        <th>สถานะ</th>
                        <th>Claim Code</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dataProvider->getModels() as $key => $value) : 
                        $isSuccess = !empty($value['messagecode']);
                    ?>
                    <tr class="<?= $isSuccess ? 'table-success-light' : '' ?>">
                        <td class="text-center">
                            <input type="checkbox" name="chkDel[]" value="<?= $value["visit_id"].$value["hn"] ?>">
                        </td>
                        <td><span class="text-muted"><?= $value["No"] ?></span></td>
                        <td><?= $value["regdate"] ?></td>
                        <td><strong><?= $value["visit_id"] ?></strong></td>
                        <td><?= $value["hn"] ?></td>
                        <td><?= $value["fullname"] ?></td>
                        <td class="text-center"><?= $value["age_year"] ?>ปี <?= $value["age_month"] ?>ด.</td>
                        <td><span class="badge badge-info"><?= $value["inscl"] ?></span></td>
                        <td>
                            <?php if($isSuccess): ?>
                                <span class="text-success"><i class="fas fa-check-circle"></i> <?= $value["messagecode"] ?></span>
                            <?php else: ?>
                                <span class="text-muted small">รอดำเนินการ</span>
                            <?php endif; ?>
                        </td>
                        <td><code class="text-primary"><?= $value["claimcode"] ?></code></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php 
        $allowedUsers = [6,75 ,96, 250, 289, 383];
        if (in_array(Yii::$app->user->id, $allowedUsers)) : ?>
            <button type="submit" name="btnSubmit" class="btn-floating-send">
                <i class="fas fa-paper-plane mr-2"></i> ส่งข้อมูล FitTest ที่เลือก
            </button>
        <?php endif; ?>
        
        <?= Html::endForm(); ?>
    </div>
</div>

<?php
Modal::begin([
    'id' => 'myModal',
    'header' => '<h5 class="modal-title">รายการไฟล์ข้อมูล</h5>',
    'size' => Modal::SIZE_LARGE,
]);
echo '<div id="modal-content" class="p-3 text-center"><div class="spinner-border text-primary"></div></div>';
Modal::end();
?>

<?php
$this->registerJs("
    // Select All Logic
    function ClickCheckAll(vol) {
        $('input[name=\"chkDel[]\"]').prop('checked', vol.checked);
    }

    // Modal Ajax
    $('#myModal').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var url = button.data('url');
        $.get(url, function(data) {
            $('#modal-content').html(data);
        });
    });

    // Form Processing Animation
    $('#main-form').on('submit', function(e) {
        var count = $('input[name=\"chkDel[]\"]:checked').length;
        if(count === 0) {
            alert('กรุณาเลือกรายการที่ต้องการส่ง');
            return false;
        }
        $(this).find('button[type=submit]').html('<i class=\"fas fa-spinner fa-spin\"></i> กำลังส่งข้อมูล...').prop('disabled', true);
    });
");
?>