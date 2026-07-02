<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use dosamigos\datepicker\DatePicker;

$this->title = 'MBASE-เยี่ยมหลังคลอด';

// --- CSS Custom Design ---
$this->registerCss("
    body { background-color: #f8f9fa; font-family: 'Sarabun', sans-serif; color: #444; }
    
    /* การ์ดสรุปข้อมูลด้านบน (Info Cards) */
    .info-card {
        background: linear-gradient(135deg, #ffffff 0%, #f3f0ff 100%);
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        padding: 20px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        border-left: 5px solid #a29bfe; /* เส้นขอบม่วงอ่อน */
    }
    .info-card:hover { transform: translateY(-3px); box-shadow: 0 6px 15px rgba(0,0,0,0.1); }
    .info-box-text { font-weight: bold; color: #6c5ce7; font-size: 1.1rem; }
    .info-box-number { font-size: 1.8rem; font-weight: 800; color: #2d3436; }

    /* ปรับแต่งตารางให้สะอาดตา */
    .my-striped-table {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        border: none !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .my-striped-table thead th {
        background-color: #a29bfe !important; /* หัวตารางม่วงสดใส */
        color: #ffffff !important;
        font-weight: 500;
        border: none !important;
        padding: 12px;
        text-align: center;
    }
    .my-striped-table tbody tr:nth-child(even) { background-color: #fdfbff; }
    .my-striped-table tbody tr:hover { background-color: #e3ffed !important; } /* ไฮไลท์เขียวอ่อนเมื่อชี้ */
    .my-striped-table td { vertical-align: middle !important; border-top: 1px solid #eee !important; padding: 10px; }

    /* ปุ่มเมนู Modern */
    .btn-modern {
        border-radius: 50px;
        padding: 10px 24px;
        font-weight: bold;
        transition: 0.3s;
        border: none;
        box-shadow: 0 4px 6px rgba(108, 92, 231, 0.2);
    }
    .btn-purple { background: linear-gradient(135deg, #a29bfe, #6c5ce7); color: white; }
    .btn-green { background: linear-gradient(135deg, #55efc4, #00b894); color: white; }
    .btn-modern:hover { opacity: 0.9; transform: scale(1.02); color: #fff; }

    /* ส่วนค้นหาและ Radio */
    .filter-section {
        background: #ebfbee; /* เขียวมิ้นต์อ่อนมาก */
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 20px;
        border: 1px solid #d7f5dd;
    }
    .custom-datepicker {
        border-radius: 10px !important;
        border: 2px solid #e0e0e0 !important;
        text-align: center;
        background: #fff !important;
    }

    /* Floating Submit Button */
    .floating-container {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
    }
    .btn-submit-main {
        background: linear-gradient(135deg, #6c5ce7, #a29bfe) !important;
        color: white !important;
        padding: 15px 40px !important;
        border-radius: 50px !important;
        font-size: 1.3rem !important;
        box-shadow: 0 10px 25px rgba(108, 92, 231, 0.4) !important;
        border: 3px solid #fff !important;
    }
    
    /* Spinner */
    .custom-spinner {
        border: 8px solid #f3f3f3;
        border-top: 8px solid #6c5ce7;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 1s linear infinite;
    }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
");
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 style="color: #6c5ce7; font-weight: bold;"><i class="fas fa-baby"></i> <?= Html::encode($this->title) ?></h3>
        <div class="btn-group">
             <?= Html::a('<i class="fa fa-sync"></i> ดึงข้อมูล', ['personcopy/copyanccare'], ['class' => 'btn btn-modern btn-purple']) ?>
             <?= Html::a('<i class="fa fa-search"></i> Query', ['fdhanccare/index'], ['class' => 'btn btn-modern btn-green', 'target' => '_blank']) ?>
        </div>
    </div>

    <div class="filter-section">
        <?= Html::beginForm(['index'], 'get', ['class' => 'row g-3 align-items-center']) ?>
            <div class="col-md-3">
                <?= DatePicker::widget([
                    'name' => 'date1', 'value' => $date1, 'language' => 'th',
                    'clientOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd'],
                    'options' => ['class' => 'form-control custom-datepicker', 'placeholder' => 'เริ่มวันที่']
                ]) ?>
            </div>
            <div class="col-md-3">
                <?= DatePicker::widget([
                    'name' => 'date2', 'value' => $date2, 'language' => 'th',
                    'clientOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd'],
                    'options' => ['class' => 'form-control custom-datepicker', 'placeholder' => 'ถึงวันที่']
                ]) ?>
            </div>
            <div class="col-md-2">
                <?= Html::submitButton('🔍 ค้นหาข้อมูล', ['class' => 'btn btn-modern btn-purple w-100']) ?>
            </div>
            <div class="col-md-4 text-end">
                <span class="badge bg-white text-dark p-2" style="border-radius: 8px; border: 1px solid #ddd;">
                    เงื่อนไข: Z390, Z391, Z392
                </span>
            </div>
        <?= Html::endForm() ?>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="info-card">
                <div class="info-box-text"><i class="fa fa-check-circle text-success"></i> รายการผ่านวันนี้</div>
                <div class="info-box-number"><?= number_format($amount) ?></div>
                <div class="mt-2">
                    <?= Html::a('เปิดอ่านไฟล์', '#', [
                        'class' => 'btn btn-sm btn-outline-primary',
                        'data-toggle' => 'modal', 'data-target' => '#myModal',
                        'data-url' => Url::to(['f16erext/list-files-partial']),
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-card" style="border-left-color: #55efc4;">
                <div class="info-box-text"><i class="fa fa-key text-warning"></i> จัดการ Token</div>
                <div class="info-box-number">สถานะ OK</div>
                <div class="mt-2">
                    <?= Html::a('Run Token', ['f16anccare/run-curl'], ['class' => 'btn btn-sm btn-outline-info']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-card" style="border-left-color: #fab1a0;">
                <div class="info-box-text"><i class="fa fa-external-link-alt"></i> ระบบ FDH</div>
                <div class="d-flex gap-2 mt-2">
                    <a href="https://fdh.moph.go.th/hospital/" target="_blank" class="btn btn-sm btn-light border">Production</a>
                    <a href="https://uat-fdh.inet.co.th/hospital/detail" target="_blank" class="btn btn-sm btn-light border">UAT Zone</a>
                </div>
            </div>
        </div>
    </div>

    <?= Html::beginForm(['f16anccare/data'], 'post', ['name' => 'frmMain']); ?>
    <?= Html::hiddenInput('date1', $date1) ?>
    <?= Html::hiddenInput('date2', $date2) ?>

    <div class="my-striped-table">
        <div style="padding: 15px; background: #fdfbff; border-bottom: 1px solid #eee;" class="row">
            <div class="col-md-6">
                <strong>การใช้สิทธิ์:</strong> 
                <input type="radio" name="uuc" value="1" checked> ใช้สิทธิ์ 
                <input type="radio" name="uuc" value="2" class="ms-3"> ไม่ใช้สิทธิ์
            </div>
            <div class="col-md-6 text-end">
                <strong>โซน:</strong> 
                <input type="radio" name="zone" value="real"> จริง 
                <input type="radio" name="zone" value="test" checked class="ms-3"> ทดสอบ
            </div>
        </div>

        <div style="max-height: 600px; overflow-y: auto;">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th width="40"><input type="checkbox" id="CheckAll" onClick="ClickCheckAll(this);"></th>
                        <th width="50">#</th>
                        <th>วันที่</th>
                        <th>Visit ID</th>
                        <th>ชื่อ-สกุล</th>
                        <th>สิทธิ์</th>
                        <th>Diag</th>
                        <th>สถานะ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dataProvider->getModels() as $value) : ?>
                        <tr id="row-<?= $value["visit_id"] ?>">
                            <td align="center"><input type="checkbox" name="chkDel[]" value="<?= $value["visit_id"].$value["hn"] ?>"></td>
                            <td align="center" class="text-muted"><?= $value["No"] ?></td>
                            <td align="center"><?= $value["regdate"] ?></td>
                            <td align="center"><strong><?= $value["visit_id"] ?></strong></td>
                            <td><?= mb_substr($value["fullname"], 0, -2) . 'xx' ?></td>
                            <td align="center"><span class="badge bg-light text-dark"><?= $value["inscl"] ?></span></td>
                            <td align="center"><b class="text-primary"><?= $value["Diagx"] ?></b></td>
                            <td align="center">
                                <?php if (!empty($value['messagecode'])): ?>
                                    <span class="text-success"><i class="fa fa-check"></i> <?= $value['messagecode'] ?></span>
                                <?php else: ?>
                                    <span class="text-muted small">รอดำเนินการ</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if (in_array(Yii::$app->user->id ?? null, [6,75,96, 250, 289, 383])) : ?>
        <div class="floating-container">
            <button type="submit" id="btnSubmit" class="btn btn-submit-main">
                <i class="fa fa-paper-plane"></i> ส่งข้อมูล PCU เยี่ยมหลังคลอด
            </button>
        </div>
    <?php endif; ?>

    <?= Html::endForm(); ?>
</div>

<?php Modal::begin(['id' => 'myModal', 'header' => '<h4>รายการไฟล์ที่ส่งออก</h4>', 'size' => Modal::SIZE_LARGE]); ?>
<div id="modal-content" class="text-center">กำลังโหลด...</div>
<?php Modal::end(); ?>

<script>
    // ฟังก์ชันเลือกทั้งหมด
    function ClickCheckAll(vol) {
        var checkboxes = document.querySelectorAll('input[name="chkDel[]"]');
        checkboxes.forEach(function(cb) { cb.checked = vol.checked; });
    }

    // ซ่อน Alert อัตโนมัติ
    setTimeout(function() { $('.alert').slideUp(); }, 5000);

    // Ajax โหลด Modal
    $('#myModal').on('show.bs.modal', function (e) {
        var url = $(e.relatedTarget).data('url');
        $.get(url, function(data) { $('#modal-content').html(data); });
    });
</script>