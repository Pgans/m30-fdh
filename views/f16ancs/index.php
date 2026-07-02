<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$this->title = 'ANC-mBase';

$this->registerCss("
    @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@400;500;700;800&display=swap');

    body { background-color: #fcfaff; font-family: 'Sarabun', sans-serif; }

    /* ====== MODERN SINGLE ROW FILTER TABS ====== */
    .filter-tabs { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 18px; }
    .filter-tab {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid transparent;
        cursor: pointer;
        text-decoration: none !important;
        transition: all .2s;
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
    }
    .filter-tab.all          { background:#f0eeff; color:#6c5ce7; border-color:#a29bfe; }
    .filter-tab.claimed      { background:#e3f2fd; color:#0d47a1; border-color:#90caf9; }
    .filter-tab.waiting-send { background:#fff3e0; color:#e65100; border-color:#ffcc80; }
    .filter-tab.today        { background:#e0f7fa; color:#006064; border-color:#00bcd4; }
    .filter-tab.success      { background:#e6fff4; color:#276749; border-color:#48bb78; }
    .filter-tab.not-claimed  { background:#fff5f5; color:#c53030; border-color:#feb2b2; }
    
    .filter-tab:hover, .filter-tab.active { opacity:.9; transform:translateY(-1px); box-shadow: 0 4px 8px rgba(0,0,0,0.08); }
    .filter-tab.all.active          { background:#6c5ce7; color:#fff; }
    .filter-tab.claimed.active      { background:#1e88e5; color:#fff; }
    .filter-tab.waiting-send.active { background:#fb8c00; color:#fff; }
    .filter-tab.today.active        { background:#00bcd4; color:#fff; }
    .filter-tab.success.active      { background:#48bb78; color:#fff; }
    .filter-tab.not-claimed.active  { background:#e53e3e; color:#fff; }

    /* ====== Info Boxes ====== */
    .info-card {
        background: linear-gradient(135deg, #e3dffc 0%, #f3f0ff 100%);
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(162, 155, 254, 0.15);
        padding: 15px;
        transition: all 0.3s ease;
        border-left: 5px solid #a29bfe;
    }
    .info-box-text   { font-weight: bold; color: #6c5ce7; font-size: 13px; }
    .info-box-number { font-weight: 800; color: #2d3436; font-size: 20px; }

    /* ====== Search Filter Section ====== */
    .filter-section {
        background: #e6fffa;
        padding: 12px;
        border-radius: 12px;
        border: 1px solid #b2f5ea;
    }

    /* ====== Table Customization ====== */
    .my-striped-table {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    }
    .my-striped-table thead th {
        background-color: #a29bfe !important;
        color: #ffffff !important;
        font-weight: 500;
        padding: 12px;
        text-align: center;
    }
    
    /* ควบคุมสีพื้นหลังแถวตามสถานะ */
    .row-claimed { background-color: #e6fff4 !important; }       /* สีเขียวอ่อนสำหรับเคสส่งแล้ว */
    .row-waiting-send { background-color: #fff5f5 !important; }  /* สีชมพูอ่อนสำหรับเคสรอส่ง */
    
    .my-striped-table tbody tr:hover { background-color: #cbd5e1 !important; transition: 0.1s; }
    .my-striped-table td { vertical-align: middle !important; border-top: 1px solid #edf2f7 !important; }

    .btn-modern { border-radius: 50px; padding: 6px 16px; font-weight: bold; border: none; transition: 0.3s; }
    .btn-purple { background: #a29bfe; color: white; }
    .btn-mint   { background: #4fd1c5; color: white; }

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
        font-size: 1.1rem;
        font-weight: bold;
        box-shadow: 0 8px 20px rgba(72,187,120,.4);
        border: 2px solid #fff;
    }
");
?>

<div class="container-fluid">

    <!-- ===== Header Title ===== -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 style="color:#6c5ce7;font-weight:bold; margin:0;">
            <i class="fas fa-hand-holding-heart"></i> <?= Html::encode($this->title) ?>
        </h4>
        <div class="text-muted" style="font-size:.85rem;">
            เงื่อนไข: UCS-สิทธิ์บัตรทอง 10953 | รหัสโรค ('z340','z348')
        </div>
    </div>

    <!-- ===== แถบปุ่มกรองข้อมูลสถิติเม็ดเงินจัดเรียงแถวเดียวกันแบบประหยัดเนื้อที่ ===== -->
    <div class="filter-tabs">
        <a href="<?= Url::to(['f16ancs/index', 'date1' => $date1, 'date2' => $date2, 'status' => 'all']) ?>"
           class="filter-tab all <?= $statusFilter === 'all' ? 'active' : '' ?>">
            <i class="fas fa-th-list mr-1"></i> ทั้งหมด (<?= number_format($totalMonth) ?>)
        </a>

        <a href="<?= Url::to(['f16ancs/index', 'date1' => $date1, 'date2' => $date2, 'status' => 'claimed']) ?>"
           class="filter-tab claimed <?= $statusFilter === 'claimed' ? 'active' : '' ?>">
            <i class="fas fa-paper-plane mr-1"></i> จำนวนส่งแล้ว (<?= number_format($claimedCount) ?> เคส)
        </a>

        <a href="<?= Url::to(['f16ancs/index', 'date1' => $date1, 'date2' => $date2, 'status' => 'waiting_send']) ?>"
           class="filter-tab waiting-send <?= $statusFilter === 'waiting_send' ? 'active' : '' ?>">
            <i class="fas fa-clock mr-1"></i> จำนวนรอส่ง (<?= number_format($waitingSendCount) ?> เคส)
        </a>
        
        <a href="<?= Url::to(['f16ancs/index', 'date1' => $date1, 'date2' => $date2, 'status' => 'today']) ?>"
           class="filter-tab today <?= $statusFilter === 'today' ? 'active' : '' ?>">
            <i class="fas fa-calendar-day mr-1"></i> ส่งวันนี้ (<?= number_format($todayCount) ?> เคส)
        </a>

        <a href="<?= Url::to(['f16ancs/index', 'date1' => $date1, 'date2' => $date2, 'status' => 'success']) ?>"
           class="filter-tab success <?= $statusFilter === 'success' ? 'active' : '' ?>">
            <i class="fas fa-check-circle mr-1"></i> ยอดชดเชยแล้ว (฿<?= number_format($sumRetStatement, 2) ?>)
        </a>

        <a href="<?= Url::to(['f16ancs/index', 'date1' => $date1, 'date2' => $date2, 'status' => 'not_claimed']) ?>"
           class="filter-tab not-claimed <?= $statusFilter === 'not_claimed' ? 'active' : '' ?>">
            <i class="fas fa-times-circle mr-1"></i> ยังไม่ชดเชย (฿<?= number_format($sumNotRetStatement, 2) ?>)
        </a>

        <a href="<?= Url::to(['f16ancs/index', 'date1' => $date1, 'date2' => $date2, 'status' => 'all']) ?>"
           class="filter-tab all" style="background: #e2e8f0; color:#4a5568; border-color:#cbd5e0; pointer-events: none;">
            <i class="fas fa-chart-line mr-1"></i> ค่ารักษาทั้งหมด (฿<?= number_format($sumTxAmount, 2) ?>)
        </a>
    </div>

    <!-- ===== โซนปฏิทินกรองวันที่ค้นหา ===== -->
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="info-card">
                <div class="info-box-text"><i class="far fa-calendar-check"></i> ยืนยันส่งผ่านวันนี้ (d_update)</div>
                <div class="info-box-number"><?= number_format($todayCount) ?> เคส</div>
                <div class="mt-1">
                    <?= Html::a('เปิดอ่านไฟล์', '#', [
                        'class'       => 'btn btn-xs btn-purple btn-modern',
                        'style'       => 'font-size:11px; padding:3px 12px;',
                        'data-toggle' => 'modal', 'data-target' => '#myModal',
                        'data-url'    => Url::to(['f16erext/list-files-partial']),
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-card" style="border-left-color:#4fd1c5;">
                <div class="info-box-text"><i class="fas fa-key"></i> Status Token</div>
                <div class="info-box-number" style="color:#38a169; font-size:16px; margin-top:4px;">Status: OK</div>
                <div class="mt-1">
                    <a href="<?= Url::to(['f16ancs/run-curl']) ?>" class="btn btn-xs btn-mint btn-modern" style="font-size:11px; padding:3px 12px;">Run Token</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="filter-section">
                <?php $form = ActiveForm::begin([
                    'action'  => ['f16ancs/index'],
                    'method'  => 'get',
                    'options' => ['class' => 'form-inline'],
                ]); ?>
                    <?= Html::hiddenInput('status', $statusFilter) ?>
                    <div class="form-group mr-2">
                        <label class="small">วันที่เริ่มต้น: </label>
                        <?= yii\jui\DatePicker::widget([
                            'name' => 'date1', 'value' => $date1, 'language' => 'th', 'dateFormat' => 'yyyy-MM-dd',
                            'options' => ['class' => 'form-control mx-1 input-sm', 'style' => 'border-radius:6px; height:30px; font-size:12px;'],
                        ]); ?>
                    </div>
                    <div class="form-group mr-2">
                        <label class="small">ถึงวันที่: </label>
                        <?= yii\jui\DatePicker::widget([
                            'name' => 'date2', 'value' => $date2, 'language' => 'th', 'dateFormat' => 'yyyy-MM-dd',
                            'options' => ['class' => 'form-control mx-1 input-sm', 'style' => 'border-radius:6px; height:30px; font-size:12px;'],
                        ]); ?>
                    </div>
                    <button class="btn btn-sm btn-purple btn-modern" style="height:30px; padding:0 15px;">เรียกดู</button>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

    <!-- ===== GridView Main Table ===== -->
    <?= Html::beginForm(['f16ancs/data'], 'post', ['name' => 'frmMain']); ?>
    <?= Html::hiddenInput('date1', $date1) ?>
    <?= Html::hiddenInput('date2', $date2) ?>

    <div class="my-striped-table">
        <div style="max-height:500px;overflow-y:auto;">
            <table class="table mb-0" style="text-align:center; font-size:13px;">
                <thead>
                    <tr>
                        <th width="40"><input type="checkbox" id="CheckAll" onClick="ClickCheckAll(this);"></th>
                        <th width="50">#</th>
                        <th>วันที่รับบริการ</th>
                        <th>Visit ID</th>
                        <th>HN</th>
                        <th style="text-align:left;">ชื่อ-สกุล</th>
                        <th>โรคหลัก</th>
                        <th style="text-align:left;">แผนกลงทะเบียน</th>
                        <th>สิทธิ์</th>
                        <th>ค่ารักษา</th>
                        <th>ชดเชย</th>
                        <th>สถานะ / วันที่ส่ง</th>
						<th>LMP</th>
                        <th>Authen</th>
                        <th>ตรวจสอบ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dataProvider->getModels() as $key => $value):
                        $visitIdPad = str_pad($value['visit_id'], 10, '0', STR_PAD_LEFT);
                        $hnPad      = str_pad($value['hn'],        6, '0', STR_PAD_LEFT);
                        
                        // ตรวจสอบสถานะการส่งเพื่อหยอด Class สีพื้นหลังให้กับแถวของตาราง
                        $rowClass = !empty($value['messagecode']) ? 'row-claimed' : 'row-waiting-send';
                    ?>
                    <tr id="row-<?= $visitIdPad ?>" class="<?= $rowClass ?>">
                        <td>
                            <input type="checkbox" name="chkDel[]" value="<?= $visitIdPad . $hnPad ?>">
                        </td>
                        <td><?= $value['No'] ?></td>
                        <td><?= $value['regdate'] ?></td>
                        <td><b><?= $value['visit_id'] ?></b></td>
                        <td>
                            <span class="badge" style="background:#e3dffc;color:#e32db3;"><?= $value['hn'] ?></span>
                        </td>
                        <td style="text-align:left;"><?= $value['fullname'] ?></td>
                        <td>
                            <span class="badge" style="background:#e3dffc;color:#6c5ce7;"><?= $value['Diagx'] ?></span>
                        </td>
                        <td style="text-align:left;"><?= $value['unit_name'] ?></td>
                        <td><?= $value['inscl'] ?></td>
                        <td style="text-align:right;"><?= !empty($value['amount']) ? number_format($value['amount'], 2) : '0.00' ?></td>
                        <td>
                            <?php if ((float)$value['ret_statement'] == 0.00): ?>
                                <span style="color:#dc2626;font-weight:700;"><?= number_format($value['ret_statement'], 2) ?></span>
                            <?php else: ?>
                                <span style="color:#16a34a;font-weight:700;"><?= number_format($value['ret_statement'], 2) ?></span>
                            <?php endif; ?>
                        </td>
                        <td id="td-status-<?= $visitIdPad ?>">
                            <?php if (!empty($value['messagecode'])): ?>
                                <div class="text-success" style="font-weight:600;"><i class="fa fa-check-circle"></i> <?= $value['messagecode'] ?></div>
                                <?php if (!empty($value['d_update'])): ?>
                                    <div class="text-muted" style="font-size:11px; margin-top:2px;"><i class="far fa-clock"></i> <?= $value['d_update'] ?></div>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="text-muted small">รอส่งข้อมูล</span>
                            <?php endif; ?>
                        </td>
						<td>
						<?php 
							$claim = $value['claim_code'] ?? '';
							$user  = $value['users'] ?? '';
						?>
						<?php if (!empty($claim)): ?>
							<div style="font-weight:600;"><?= $claim ?></div>
						<?php endif; ?>
						<?php if (!empty($user)): ?>
							<div><small style="color:purple; font-size:14px;"><?= $user ?></small></div>
						<?php endif; ?>
					</td>

                        <td class="text-nowrap" style="font-size:13px;"><?= $value['claimcode'] ?></td>
                        <td class="text-nowrap">
                            <button type="button"
                                class="btn-check-status"
                                data-value="<?= $visitIdPad . $hnPad ?>"
                                data-hn="<?= $hnPad ?>"
                                data-visit="<?= $visitIdPad ?>"
                                style="background:linear-gradient(135deg,#e3f2fd,#bbdefb);
                                       color:#1565c0;border:1px solid #90caf9;border-radius:20px;
                                       padding:3px 10px;font-size:11px;font-weight:bold;
                                       cursor:pointer;white-space:nowrap;">
                                <i class="fa fa-search"></i> เช็ค
                            </button>
                            <div class="check-result" id="result-<?= $hnPad ?>"
                                 style="margin-top:4px;font-size:10px;display:none;max-width:140px;word-wrap:break-word;"></div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if (in_array(Yii::$app->user->id ?? null, [6, 75, 96, 289, 250, 383])): ?>
        <div class="floating-button-container">
            <button type="submit" class="btn btn-submit-pcu">
                <i class="fa fa-paper-plane mr-2"></i> ส่งข้อมูล PCU ANC
            </button>
        </div>
    <?php endif; ?>

    <?= Html::endForm(); ?>

</div>

<!-- ===== Modal Component ===== -->
<?php Modal::begin([
    'id'     => 'myModal',
    'header' => '<h4 class="text-primary">รายการไฟล์ที่ส่งออก</h4>',
    'size'   => Modal::SIZE_LARGE,
]); ?>
<div id="modal-content" class="text-center p-4">กำลังโหลดข้อมูล...</div>
<?php Modal::end(); ?>

<?php
$url     = \yii\helpers\Url::to(['f16ancs/check']);
$csrf    = Yii::$app->request->csrfParam;
$csrfVal = Yii::$app->request->getCsrfToken();
$this->registerJs(
    'var _url='    . json_encode($url)     . ';' .
    'var _csrf='   . json_encode($csrf)    . ';' .
    'var _csrfVal='. json_encode($csrfVal) . ';',
    \yii\web\View::POS_END
);
?>

<?php $this->registerJs(<<<'JS'
console.log('=== FDH Script Loaded ===');

$(document).on('mouseenter', '.btn-check-status', function () {
    var val = $(this).data('value');
    if (val && val.length >= 16) {
        $(this).attr('title',
            'VisitID: ' + val.substring(0, 10) +
            '\nHN: '    + val.substring(10, 16)
        );
    }
});

$(document).on('click', '.btn-check-status', function () {
    var btn       = $(this);
    var val       = btn.data('value');
    var hn        = btn.data('hn');
    var visitId   = btn.data('visit');
    var resultBox = $('#result-'    + hn);
    var statusCell= $('#td-status-' + visitId);
    var row       = $('#row-'       + visitId);

    btn.html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);
    resultBox.hide().removeClass('text-success text-danger text-info');

    var postData = { chkDel: [val] };
    postData[_csrf] = _csrfVal;

    $.ajax({
        url:      _url,
        type:     'POST',
        data:     postData,
        dataType: 'json',
        success: function (res) {
            var item = null;
            if (res.results && res.results[visitId]) {
                item = res.results[visitId];
            } else if (res.results) {
                $.each(res.results, function(k, v) {
                    if (String(v.hn) === String(hn)) { item = v; return false; }
                });
            }

            if (!item) {
                item = { success: false, status: 'error', message: res.message || 'ไม่พบข้อมูล' };
            }

            var msgText      = item.message || '-';
            var status       = (item.status || '').toLowerCase();
            var approvedList = ['approved','paid','accepted','success','waited','claimed','processed','complete','completed','cut_off_batch'];
            var isApproved   = approvedList.indexOf(status) !== -1;

            var currentFullDate = new Date().toISOString().replace('T', ' ').substring(0, 16);

            if (isApproved) {
                btn.html('<i class="fa fa-check-circle" style="color:#2e7d32"></i> ผ่าน');
                resultBox.removeClass('text-danger text-info').addClass('text-success').text(msgText).show();
                // เปลี่ยนสีแถวเป็นเขียวอ่อนทันทีแบบ Realtime
                if (row.length) {
                    row.removeClass('row-waiting-send').addClass('row-claimed');
                }
            } else if (item.success) {
                btn.html('<i class="fa fa-paper-plane" style="color:#1565c0"></i> ส่งแล้ว');
                resultBox.removeClass('text-danger text-success').addClass('text-info').text(msgText).show();
                // เปลี่ยนสีแถวเป็นเขียวอ่อนทันทีแบบ Realtime
                if (row.length) {
                    row.removeClass('row-waiting-send').addClass('row-claimed');
                }
            } else {
                btn.html('<i class="fa fa-times-circle" style="color:#c62828"></i> ไม่ผ่าน');
                resultBox.removeClass('text-success text-info').addClass('text-danger').text(msgText).show();
                // ถ้าไม่ผ่านหรือล้มเหลว ให้รักษาสีชมพูอ่อนไว้
                if (row.length) {
                    row.removeClass('row-claimed').addClass('row-waiting-send');
                }
            }

            btn.prop('disabled', false);

            if (statusCell.length) {
                var icon  = isApproved   ? 'fa-check-circle' : item.success ? 'fa-paper-plane' : 'fa-times-circle';
                var color = isApproved   ? '#16a34a' : item.success ? '#2563eb' : '#dc2626';
                statusCell.html(
                    '<div style="color:' + color + ';font-weight:600;"><i class="fa ' + icon + '"></i> ' + msgText + '</div>' +
                    '<div class="text-muted" style="font-size:11px; margin-top:2px;"><i class="far fa-clock"></i> ' + currentFullDate + ' (อัปเดต)</div>'
                );
            }

            // ทำเอฟเฟกต์กระพริบตาเมื่อแถวเปลี่ยนสถานะสำเร็จ
            if (row.length) {
                var origBg = row.css('background-color');
                row.css({ background: '#fef08a', transition: 'background 0.3s' });
                setTimeout(function () { row.css('background-color', ''); }, 1000);
            }
        },
        error: function (xhr) {
            btn.html('<i class="fa fa-times" style="color:#c62828"></i> Error').prop('disabled', false);
            resultBox.removeClass('text-success text-info').addClass('text-danger').text('AJAX ERROR').show();
        }
    });
});
JS
, \yii\web\View::POS_END); ?>

<script>
    function ClickCheckAll(vol) {
        document.querySelectorAll('input[name="chkDel[]"]').forEach(function(cb) {
            cb.checked = vol.checked;
        });
    }

    $('#myModal').on('show.bs.modal', function (e) {
        var url = $(e.relatedTarget).data('url');
        $.get(url, function(data) { $('#modal-content').html(data); });
    });
</script>