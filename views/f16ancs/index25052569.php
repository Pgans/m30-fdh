<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$this->title = 'ANC-mBase';

// --- CSS Custom Design (Lavender & Mint Theme) ---
$this->registerCss("
    body { background-color: #fcfaff; font-family: 'Sarabun', sans-serif; }
    
    /* การ์ดสรุปข้อมูล (Lavender Gradient) */
    .info-card {
        background: linear-gradient(135deg, #e3dffc 0%, #f3f0ff 100%);
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(162, 155, 254, 0.2);
        padding: 20px;
        transition: all 0.3s ease;
        border-left: 6px solid #a29bfe; 
    }
    .info-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(162, 155, 254, 0.3); }
    .info-box-text { font-weight: bold; color: #6c5ce7; }
    .info-box-number { font-weight: 800; color: #2d3436; }

    /* ส่วนค้นหาและตัวกรอง (Mint Fresh) */
    .filter-section {
        background: #e6fffa; 
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 20px;
        border: 1px solid #b2f5ea;
    }

    /* ตารางที่สวยงามและสะอาดตา */
    .my-striped-table {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        border: none !important;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    }
    .my-striped-table thead th {
        background-color: #a29bfe !important; /* ม่วงอ่อนสดใส */
        color: #ffffff !important;
        font-weight: 500;
        border: none !important;
        padding: 12px;
        text-align: center;
    }
    /* แถวสลับสี ม่วงจาง / ขาว */
    .my-striped-table tbody tr:nth-child(odd) { background-color: #f8f7ff; }
    .my-striped-table tbody tr:nth-child(even) { background-color: #ffffff; }
    
    /* Hover เป็นสีเขียวมิ้นต์ */
    .my-striped-table tbody tr:hover { 
        background-color: #c6f6d5 !important; 
        transition: 0.2s;
    }
    .my-striped-table td { vertical-align: middle !important; border-top: 1px solid #eee !important; }

    /* ปุ่ม Modern Styles */
    .btn-modern {
        border-radius: 50px;
        padding: 8px 20px;
        font-weight: bold;
        border: none;
        transition: 0.3s;
    }
    .btn-purple { background: #a29bfe; color: white; box-shadow: 0 4px 6px rgba(162, 155, 254, 0.3); }
    .btn-mint { background: #4fd1c5; color: white; box-shadow: 0 4px 6px rgba(79, 209, 197, 0.3); }
    .btn-modern:hover { opacity: 0.9; transform: scale(1.05); color: #fff; }

    /* ปุ่มลอยส่งข้อมูล */
    .floating-button-container {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
    }
    .btn-submit-pcu {
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
        padding: 12px 35px;
        border-radius: 50px;
        font-size: 1.2rem;
        font-weight: bold;
        box-shadow: 0 8px 20px rgba(72, 187, 120, 0.4);
        border: 2px solid #fff;
    }
");
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 style="color: #6c5ce7; font-weight: bold;">
            <i class="fas fa-hand-holding-heart"></i> <?= Html::encode($this->title) ?>
        </h4>
        <div class="text-muted" style="font-size: 0.9rem;">
            เงื่อนไข: UCS-สิทธิ์บัตรทอง 10953 | รหัสโรค ('z340','z348')
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="info-card">
                <div class="info-box-text"><i class="far fa-calendar-check"></i> รายการผ่านวันนี้</div>
                <div class="info-box-number" style="font-size: 24px;"><?= number_format($amount) ?></div>
                <div class="mt-2">
                    <?= Html::a('เปิดอ่านไฟล์', '#', [
                        'class' => 'btn btn-sm btn-purple',
                        'data-toggle' => 'modal', 'data-target' => '#myModal',
                        'data-url' => Url::to(['f16erext/list-files-partial']),
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-card" style="border-left-color: #4fd1c5;">
                <div class="info-box-text"><i class="fas fa-key"></i> จัดการ Token</div>
                <div class="info-box-number" style="font-size: 18px; color: #38a169;">Status: OK</div>
                <div class="mt-2">
                    <a href="<?= Url::to(['f16ancs/run-curl']) ?>" class="btn btn-sm btn-mint">Run Token</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="filter-section">
                <?php $form = ActiveForm::begin(['action' => ['f16ancs/index'], 'method' => 'post', 'options' => ['class' => 'form-inline']]); ?>
                    <div class="form-group mr-2">
                        <label>วันที่: </label>
                        <?= yii\jui\DatePicker::widget([
                            'name' => 'date1', 'value' => $date1, 'language' => 'th', 'dateFormat' => 'yyyy-MM-dd',
                            'options' => ['class' => 'form-control mx-2', 'style' => 'border-radius:8px']
                        ]); ?>
                    </div>
                    <div class="form-group mr-2">
                        <label>ถึง: </label>
                        <?= yii\jui\DatePicker::widget([
                            'name' => 'date2', 'value' => $date2, 'language' => 'th', 'dateFormat' => 'yyyy-MM-dd',
                            'options' => ['class' => 'form-control mx-2', 'style' => 'border-radius:8px']
                        ]); ?>
                    </div>
                    <button class="btn btn-purple">ตกลง</button>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

    <?= Html::beginForm(['f16ancs/data'], 'post', ['name' => 'frmMain']); ?>
    <?= Html::hiddenInput('date1', $date1) ?>
    <?= Html::hiddenInput('date2', $date2) ?>

<div class="my-striped-table">
    <div class="p-3" style="background: #f8f7ff; border-bottom: 1px solid #eee;">
        <label class="mr-3"><b>โซนการส่ง:</b></label>
        <input type="radio" name="zone" value="real" id="real"> <label for="real" class="mr-3">โซนจริง</label>
        <input type="radio" name="zone" value="test" id="test" checked> <label for="test">โซนทดสอบ</label>
    </div>
    <div style="max-height: 500px; overflow-y: auto;">
        <table class="table mb-0" style="text-align: center;">
            <thead>
                <tr>
                    <th style="text-align: center;" width="40"><input type="checkbox" id="CheckAll" onClick="ClickCheckAll(this);"></th>
                    <th style="text-align: center;" width="50">#</th>
                    <th style="text-align: center;">วันที่</th>
                    <th style="text-align: center;">Visit ID</th>
                    <th style="text-align: center;">HN</th>
                    <th style="text-align: left;">ชื่อ-สกุล</th>
                    <th style="text-align: center;">โรคหลัก</th>
                    <th style="text-align: left;">แผนกลงทะเบียน</th>
                    <th style="text-align: center;">สิทธิ์</th>
                    <th style="text-align: center;">สถานะ</th>
                    <th style="text-align: center;">Authen</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataProvider->getModels() as $key => $value) : ?>
                    <tr>
                        <td style="text-align: center;">
                            <input type="checkbox" name="chkDel[]" value="<?= $value["visit_id"] . '|' . $value["hn"]; ?>">
                        </td>
                        <td style="text-align: center;"><?= $value["No"]; ?></td>
                        <td style="text-align: center;"><?= $value["regdate"]; ?></td>
                        <td style="text-align: center;"><b><?= $value["visit_id"]; ?></b></td>
                        <td style="text-align: center;">
                            <span class="badge" style="background:#e3dffc; color:#e32db3;"><?= $value["hn"]; ?></span>
                        </td>
                        <td style="text-align: left;"><?= $value["fullname"]; ?></td>
                        <td style="text-align: center;">
                            <span class="badge" style="background:#e3dffc; color:#6c5ce7;"><?= $value["Diagx"]; ?></span>
                        </td>
                        <td style="text-align: left;"><?= $value["unit_name"]; ?></td>
                        <td style="text-align: center;"><?= $value["inscl"]; ?></td>
                        <td style="text-align: center;">
                            <?php if (!empty($value['messagecode'])): ?>
                                <span class="text-success"><i class="fa fa-check-circle"></i> <?= $value['messagecode'] ?></span>
                            <?php else: ?>
                                <span class="text-muted small">รอดำเนินการ</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center; font-size: 14px;" class="text-nowrap"><?= $value["claimcode"]; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</div>

    <?php if (in_array(Yii::$app->user->id ?? null, [6, 75, 96, 289, 250, 383])) : ?>
        <div class="floating-button-container">
            <button type="submit" class="btn btn-submit-pcu">
                <i class="fa fa-paper-plane mr-2"></i> ส่งข้อมูล PCU ANC
            </button>
        </div>
    <?php endif; ?>

    <?= Html::endForm(); ?>
</div>

<?php Modal::begin(['id' => 'myModal', 'header' => '<h4 class="text-primary">รายการไฟล์ที่ส่งออก</h4>', 'size' => Modal::SIZE_LARGE]); ?>
<div id="modal-content" class="text-center p-4">กำลังโหลดข้อมูล...</div>
<?php Modal::end(); ?>

<script>
    function ClickCheckAll(vol) {
        var checkboxes = document.querySelectorAll('input[name="chkDel[]"]');
        checkboxes.forEach(function(cb) { cb.checked = vol.checked; });
    }
    
    $('#myModal').on('show.bs.modal', function (e) {
        var url = $(e.relatedTarget).data('url');
        $.get(url, function(data) { $('#modal-content').html(data); });
    });
</script>