<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\jui\DatePicker;

$this->title = 'FDH-ANCDENT-US';

// การลงทะเบียน Google Font และ Styling ทั้งระบบ
$this->registerCss("
@import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap');

body, table, th, td, input, button, select, div, h4, span, .btn {
    font-family: 'Sarabun', sans-serif !important;
    font-size: 14px;
}

/* ─── DASHBOARD BADGE ROW ─── */
.dashboard-badge-row {
    display: flex;
    flex-wrap: wrap;
    gap: 18px;
    margin-bottom: 30px;
}
.chip-badge {
    display: inline-flex; 
    align-items: center; 
    gap: 12px;
    padding: 20px 36px; /* ขยายขนาดกล่องให้ใหญ่เบิ้มสะใจ */
    border-radius: 18px; /* เพิ่มความโค้งมนรับกับขนาดปุ่ม */
    font-size: 19px; /* ขยายตัวอักษรใหญ่ชัดเจนมองเห็นระยะไกล */
    font-weight: 700; /* ตัวหนาพิเศษ */
    text-decoration: none !important;
    transition: all 0.2s ease-in-out;
    border: 2.5px solid transparent;
    white-space: nowrap; 
    cursor: pointer;
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08); /* เพิ่มมิติเงาให้ลอยเด่นขึ้น */
}

.chip-badge:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.08);
}
.chip-badge.active {
    box-shadow: 0 0 0 3px rgba(108, 72, 255, 0.4) !important;
    font-weight: 700;
}

/* Badge Color Schemes */
.chip-all       { background-color: #6c48ff; color: #ffffff !important; }
.chip-sent      { background-color: #e0f2fe; color: #0369a1 !important; }
.chip-wait      { background-color: #fef9c3; color: #a16207 !important; }
.chip-today     { background-color: #dcfce7; color: #15803d !important; }
.chip-money-ok  { background-color: #ecfdf5; color: #047857 !important; }
.chip-money-no  { background-color: #fee2e2; color: #b91c1c !important; }
.chip-money-all { background-color: #f3f4f6; color: #4b5563 !important; }

/* ─── CONTROL CARDS ─── */
.control-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 2fr;
    gap: 20px;
    margin-bottom: 20px;
}
@media (max-width: 992px) {
    .control-grid { grid-template-columns: 1fr; }
}
.panel-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.07);
    border: 1px solid #e5e7eb;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.panel-purple { border-top: 5px solid #6c48ff; }
.panel-teal   { border-top: 5px solid #0d9488; }
.panel-form   { border-top: 5px solid #9ca3af; }

.status-dot {
    height: 10px;
    width: 10px;
    background-color: #10b981;
    border-radius: 50%;
    display: inline-block;
    margin-right: 6px;
}

/* ─── QUICK LINKS ─── */
.quick-links {
    background: #f8fafc;
    padding: 12px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    display: flex;
    gap: 15px;
    align-items: center;
    border: 1px solid #e2e8f0;
}

/* ─── GRIDVIEW OVERRIDES ─── */
.kv-grid-table th {
    position: sticky !important;
    top: 0 !important;
    background-color: #1e1b4b !important;
    color: #e0e7ff !important;
    font-size: 13px;
    font-weight: 500;
    text-align: center;
    z-index: 5;              /* ✅ ลดจาก 20 → 5 ป้องกันบัง DatePicker */
    border: none !important;
}
.row-sent { background-color: #f0fdf4 !important; }
.row-wait { background-color: #fff1f2 !important; }

/* ─── CUSTOM BADGES (ตาราง) ─── */
.custom-badge {
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}
.badge-gray {
    background-color: #e5e7eb;
    color: #4b5563;
    border-radius: 50%;
    padding: 4px 8px;
}

/* สถานะ / โรค / สถานพยาบาล */
.diag-sent, .status-sent, .hosp-ok { background-color: #dcfce7; color: #16a34a; }
.diag-wait, .status-wait, .hosp-no { background-color: #ffe4e6; color: #dc2626; }

/* ยอดเงิน */
.amt-zero     { background-color: #ffe4e6; color: #dc2626; }
.amt-positive { background-color: #eff6ff; color: #2563eb; }

/* ─── FLOATING SUBMIT BUTTON ─── */
.fixed-submit-container {
    position: fixed;
    bottom: 40px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 9999;
}
.btn-floating {
    background-color: #10b981 !important;
    color: #ffffff !important;
    font-weight: 600;
    font-size: 16px;
    padding: 12px 35px;
    border-radius: 999px;
    box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.4);
    border: 2px solid #ffffff;
    transition: all 0.2s ease;
}
.btn-floating:hover {
    transform: scale(1.03);
    box-shadow: 0 12px 20px -3px rgba(16, 185, 129, 0.6);
}

/* ─── DATEPICKER FIX ✅ ─── */
.ui-datepicker {
    z-index: 9999 !important;
}
");
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

<h4 style="font-weight: 600; color: #1e1b4b; margin-bottom: 20px;">
    <i class="fa-solid fa-tooth text-primary"></i> เงื่อนไขเมนู :: สิทธิ์บัตรทอง รหัสโรค Z348 หัตถการทำฟัน 2387010, 2330011 อุลตราซาวด์ 88.78
</h4>

<div class="dashboard-badge-row">
    <a href="<?= Url::to(['index', 'date1' => $date1, 'date2' => $date2, 'statusFilter' => 'all']) ?>" class="chip-badge chip-all <?= $statusFilter === 'all' ? 'active' : '' ?>">
        ทั้งหมด: <?= $totalCases ?> เคส
    </a>
    <a href="<?= Url::to(['index', 'date1' => $date1, 'date2' => $date2, 'statusFilter' => 'success']) ?>" class="chip-badge chip-sent <?= $statusFilter === 'success' ? 'active' : '' ?>">
        ส่งแล้ว: <?= $sentCases ?> เคส
    </a>
    <a href="<?= Url::to(['index', 'date1' => $date1, 'date2' => $date2, 'statusFilter' => 'waiting']) ?>" class="chip-badge chip-wait <?= $statusFilter === 'waiting' ? 'active' : '' ?>">
        รอส่ง: <?= $waitCases ?> เคส
    </a>
    <a href="<?= Url::to(['index', 'date1' => $date1, 'date2' => $date2, 'statusFilter' => 'today']) ?>" class="chip-badge chip-today <?= $statusFilter === 'today' ? 'active' : '' ?>">
        ส่งวันนี้: <?= $amountToday ?> เคส
    </a>
    <span class="chip-badge chip-money-ok">
        ยอดชดเชยแล้ว: <?= number_format($compensated, 2) ?>
    </span>
    <a href="<?= Url::to(['index', 'date1' => $date1, 'date2' => $date2, 'statusFilter' => 'not_compensated']) ?>" class="chip-badge chip-money-no <?= $statusFilter === 'not_compensated' ? 'active' : '' ?>">
        ยังไม่ชดเชย: <?= number_format($notCompensated, 2) ?>
    </a>
    <span class="chip-badge chip-money-all">
        ค่ารักษาทั้งหมด: <?= number_format($totalAmount, 2) ?>
    </span>
</div>

<div class="control-grid">
    <div class="panel-card panel-purple">
        <div>
            <h5 style="color: #6c48ff; font-weight: 600; margin: 0 0 10px 0;">ยืนยันส่งวันนี้</h5>
            <p style="font-size: 24px; font-weight: 700; margin: 0; color: #1f2937;"><?= $amountToday ?> <span style="font-size:14px; font-weight:400;">เคส</span></p>
        </div>
        <div style="margin-top: 15px; display: flex; gap: 8px;">
            <?= Html::a('เปิดอ่านไฟล์', '#', [
                'class' => 'btn btn-sm btn-primary',
                'style' => 'border-radius:6px;',
                'data-toggle' => 'modal',
                'data-target' => '#fileListModal',
                'data-url' => Url::to(['f16erext/list-files-partial']),
            ]) ?>
        </div>
    </div>

    <div class="panel-card panel-teal">
        <div>
            <h5 style="color: #0d9488; font-weight: 600; margin: 0 0 10px 0;">STATUS TOKEN</h5>
            <div style="font-size: 18px; font-weight: 600; color: #111827; display: flex; align-items: center;">
                <span class="status-dot"></span> Status: OK
            </div>
        </div>
        <div style="margin-top: 15px;">
            <a href="<?= Url::to(['f16ancdentus/run-curl']) ?>" class="btn btn-sm btn-default" style="border: 1px solid #d1d5db; border-radius:6px; width:100%;">
                Run Token <i class="fa fa-arrow-circle-right text-teal"></i>
            </a>
        </div>
    </div>

    <div class="panel-card panel-form">
        <h5 style="color: #4b5563; font-weight: 600; margin: 0 0 10px 0;">ช่วงเวลาคัดกรองข้อมูล</h5>
        <?php $form = ActiveForm::begin(['method' => 'post', 'action' => ['index'], 'options' => ['class' => 'form-inline']]); ?>
            <div style="display: flex; gap: 10px; width: 100%; align-items: center;">
                <div style="flex: 1;">
                    <?= DatePicker::widget([
                        'name' => 'date1',
                        'value' => $date1,
                        'language' => 'th',
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => ['class' => 'form-control', 'style' => 'width: 100%; border-radius: 6px;', 'placeholder' => 'เริ่ม'],
                    ]) ?>
                </div>
                <div style="color: #9ca3af;">ถึง</div>
                <div style="flex: 1;">
                    <?= DatePicker::widget([
                        'name' => 'date2',
                        'value' => $date2,
                        'language' => 'th',
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => ['class' => 'form-control', 'style' => 'width: 100%; border-radius: 6px;', 'placeholder' => 'สิ้นสุด'],
                    ]) ?>
                </div>
                <?= Html::hiddenInput('statusFilter', $statusFilter) ?>
                <button type="submit" class="btn btn-primary" style="background-color: #6c48ff; border: none; border-radius: 999px; padding: 6px 20px;">
                    <i class="fa fa-search"></i> เรียกดู
                </button>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<div class="quick-links">
    <span style="font-weight: 600; color: #64748b; margin-right: 5px;"><i class="fa-solid fa-link"></i> ลิงก์ด่วน:</span>
    <a href="https://uat-fdh.inet.co.th/hospital/detail" target="_blank" class="text-primary"><i class="fa-solid fa-vial"></i> FDH-UAT</a> |
    <a href="https://fdh.moph.go.th/hospital/" target="_blank" class="text-success"><i class="fa-solid fa-server"></i> FDH-Production</a> |
    <a href="<?= Url::to(['f16ancdentus/index']) ?>" target="_blank" class="text-warning"><i class="fa-solid fa-window-restore"></i> Query หน้าต่างใหม่</a> |
    <a href="<?= Url::to(['f16ancdentus/exports', 'date1' => $date1, 'date2' => $date2]) ?>" class="text-info"><i class="fa-solid fa-file-excel"></i> Export Excel</a>
</div>

<?= Html::beginForm(['f16ancdentus/data'], 'post', ['name' => 'frmMain']); ?>

<div style="box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; border: 1px solid #e5e7eb;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'kv-grid-table table-bordered table-hover'],
        'layout' => "{items}", 
        'options' => ['style' => 'height: 520px; overflow-y: auto; background:#fff;'],
        'emptyText' => '<div class="text-center text-danger" style="padding: 50px 0; font-size: 16px; font-weight:600;"><i class="fa fa-exclamation-triangle"></i> ไม่พบข้อมูลตามเงื่อนไขที่เลือก</div>',
        'rowOptions' => function($model) {
            return [
                'class' => !empty($model['messagecode']) ? 'row-sent' : 'row-wait'
            ];
        },
        'columns' => [
            // 1. Checkbox Action
            [
                'class' => 'kartik\grid\CheckboxColumn',
                'width' => '40px',
                'checkboxOptions' => function($model) {
                    $vId = $model['visit_id'] ?? '';
                    $hn = $model['hn'] ?? '';
                    return ['value' => $vId . '|' . $hn];
                }
            ],
            // 2. # No Index
            [
                'attribute' => 'No',
                'header' => '#',
                'width' => '50px',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value' => function($model) {
                    return Html::tag('span', $model['No'] ?? '', ['class' => 'badge-gray']);
                },
                'format' => 'raw'
            ],
            // 3. วันที่รับบริการ
            [
                'header' => 'วันที่',
                'attribute' => 'regdate',
                'vAlign' => 'middle',
                'value' => function($model) { return $model['regdate'] ?? ''; }
            ],
            // 4. เลขบริการ
            [
                'header' => 'เลขบริการ',
                'attribute' => 'visit_id',
                'vAlign' => 'middle',
                'value' => function($model) { return $model['visit_id'] ?? ''; }
            ],
            // 5. HN
            [
                'header' => 'HN',
                'attribute' => 'hn',
                'vAlign' => 'middle',
                'value' => function($model) { return $model['hn'] ?? ''; }
            ],
            // 6. ชื่อ-สกุล
            [
                'header' => 'ชื่อ-สกุล',
                'attribute' => 'fullname',
                'vAlign' => 'middle',
                'value' => function($model) { return $model['fullname'] ?? ''; }
            ],
            // 7. อายุ
            [
                'header' => 'อายุ',
                'attribute' => 'age',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function($model) { return $model['age'] ?? ''; }
            ],
            // 8. แผนก
            [
                'header' => 'แผนก',
                'attribute' => 'unit_name',
                'vAlign' => 'middle',
                'value' => function($model) { return $model['unit_name'] ?? ''; }
            ],
            // 9. โรคหลัก
            [
                'header' => 'โรคหลัก',
                'attribute' => 'Diagx',
                'vAlign' => 'middle',
                'value' => function($model) { return $model['Diagx'] ?? ''; }
            ],
            // 10. รหัสโรค
            [
                'header' => 'รหัสโรค',
                'attribute' => 'Diag',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function($model) {
                    $class = !empty($model['messagecode']) ? 'diag-sent' : 'diag-wait';
                    return Html::tag('span', $model['Diag'] ?? '', ['class' => "custom-badge $class"]);
                }
            ],
            // 11. หัตถการ
            [
                'header' => 'หัตถการ',
                'attribute' => 'oper',
                'vAlign' => 'middle',
                'value' => function($model) { return $model['oper'] ?? ''; }
            ],
            // 12. สิทธิ์
            [
                'header' => 'สิทธิ์',
                'attribute' => 'inscl',
                'vAlign' => 'middle',
                'value' => function($model) { return $model['inscl'] ?? ''; }
            ],
            // 13. สถานหลัก
            [
                'header' => 'สถานหลัก',
                'attribute' => 'hospmain',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function($model) {
                    $hMain = $model['hospmain'] ?? '';
                    $class = ($hMain === '10953') ? 'hosp-ok' : 'hosp-no';
                    return Html::tag('span', $hMain, ['class' => "custom-badge $class"]);
                }
            ],
            // 14. สถานรอง
            [
                'header' => 'สถานรอง',
                'attribute' => 'hospsub',
                'vAlign' => 'middle',
                'value' => function($model) { return $model['hospsub'] ?? ''; }
            ],
           
            // 16. ยอดเรียกเก็บ (amount)
            [
                'header' => 'ค่ารักษา',
                'attribute' => 'amount',
                'hAlign' => 'right',
                'vAlign' => 'middle',
                'format' => 'raw',
                'value' => function($model) {
                    $amt = (float)($model['amount'] ?? 0);
                    $class = ($amt == 0) ? 'amt-zero' : 'amt-positive';
                    return Html::tag('span', number_format($amt, 2), ['class' => "custom-badge $class"]);
                }
            ],
            // 17. ยอดชดเชยสำเร็จ (ret_statement)
            [
                'header' => 'ชดเชย',
                'attribute' => 'ret_statement',
                'hAlign' => 'right',
                'vAlign' => 'middle',
                'format' => 'raw',
                'value' => function($model) {
                    $ret = (float)($model['ret_statement'] ?? 0);
                    $class = ($ret == 0) ? 'amt-zero' : 'amt-positive';
                    return Html::tag('span', number_format($ret, 2), ['class' => "custom-badge $class"]);
                }
            ],
            // 18. Claim ANC Code
            /* ── claim_anc ───────────────────────────────────────── */
				['attribute' => 'claim_code', 'header' => 'claim_anc', 'value' => function($m){ 
				$claim = $m['claim_code'] ?? '';
				$user  = $m['users'] ?? '';
				return $claim . '<br><small style="color:purple; font-size:14px;">' . $user . '</small>'; 
				}, 'format' => 'raw'],

			 // 15. สถานะส่งซิงค์ + เวลาอัปเดต
            [
                'header' => 'สถานะส่งข้อมูล',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function($model) {
                    $mCode = $model['messagecode'] ?? '';
                    $dUpdate = $model['d_update'] ?? '';
                    
                    if (!empty($mCode)) {
                        $badge = Html::tag('span', '<i class="fa fa-check"></i> ' . $mCode, ['class' => 'custom-badge status-sent']);
                    } else {
                        $badge = Html::tag('span', '<i class="fa fa-times"></i> รอส่ง', ['class' => 'custom-badge status-wait']);
                    }
                    
                    $timeStr = !empty($dUpdate) ? Html::tag('span', '<i class="fa-regular fa-clock"></i> ' . $dUpdate, ['style' => 'font-size:11px; color:#6b7280; margin-top:4px;']) : '';
                    
                    return Html::tag('div', $badge . $timeStr, [
                        'style' => 'display:flex; flex-direction:column; align-items:center; justify-content:center;'
                    ]);
                }
            ],
			[
					'label' => 'เช็คสถานะ',
					'format' => 'raw',
					'contentOptions' => [
						'style' => 'white-space:nowrap;text-align:center;vertical-align:middle;width:160px;'
					],
					'value' => function ($model) {
						$visitIdPad = str_pad($model['visit_id'], 10, '0', STR_PAD_LEFT);
						$hnPad      = str_pad($model['hn'],        6, '0', STR_PAD_LEFT);
						$safeId     = 'r' . $visitIdPad;

						return
							'<button type="button"
								class="btn-check-status"
								data-value="' . $visitIdPad . $hnPad . '"
								data-hn="'    . $hnPad      . '"
								data-visit="' . $visitIdPad . '"
								style="background:linear-gradient(135deg,#e3f2fd,#bbdefb);
									   color:#1565c0;border:1px solid #90caf9;border-radius:20px;
									   padding:3px 10px;font-size:11px;font-weight:bold;
									   cursor:pointer;white-space:nowrap;">
								<i class="fa fa-search"></i> เช็ค
							</button>
							<div class="check-result"
								 id="result-' . $safeId . '"
								 style="margin-top:4px;font-size:10px;display:none;
										max-width:140px;word-wrap:break-word;">
							</div>';
					}
				],
				
            // 19. Authen Code
            [
                'header' => 'authen',
                'attribute' => 'claimcode',
                'vAlign' => 'middle',
                'value' => function($model) { return $model['claimcode'] ?? ''; }
            ],
        ],
    ]); ?>
</div>

<?php 
$allowedUsers = [6, 96, 289, 383];  
$currentUserId = Yii::$app->user->id ?? null;
if (in_array($currentUserId, $allowedUsers)) :
?>
    <div class="fixed-submit-container">
        <button type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-floating">
            <i class="fa fa-paper-plane"></i> ส่งข้อมูล [ANC-DENT-US]
        </button>
    </div>
<?php endif; ?>

<?= Html::endForm(); ?>

<?php $this->registerJs(
    "var _csrf    = '" . Yii::$app->request->csrfParam . "';" .
    "var _csrfVal = '" . Yii::$app->request->getCsrfToken() . "';" .
    "var _url     = '" . Url::to(['f16ancdentus/check']) . "';",
\yii\web\View::POS_END); ?>

<?php $this->registerJs(<<<'JS'
console.log('=== FDH Script Loaded ===');

$(document).on('mouseenter', '.btn-check-status', function () {
    var val = String($(this).data('value'));
    if (val && val.length >= 16) {
        $(this).attr('title',
            'VisitID: ' + val.substring(0, 10) +
            '\nHN: '    + val.substring(10, 16)
        );
    }
});

$(document).on('click', '.btn-check-status', function () {
    var btn       = $(this);
    var val       = String(btn.data('value'));
    var hn        = btn.data('hn');
    var visitId   = btn.data('visit');
    var resultBox = $('#result-r' + visitId);   // ✅ แก้จาก hn → r+visitId
    var statusCell= $('#td-status-' + visitId);
    var row       = btn.closest('tr');           // ✅ หา row จาก closest แทน id

    btn.html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);
    resultBox.hide().removeClass('text-success text-danger text-info');

    var postData    = { chkDel: [val] };
    postData[_csrf] = _csrfVal;

    $.ajax({
        url     : _url,
        type    : 'POST',
        data    : postData,
        dataType: 'json',
        success : function (res) {

            var item = null;
            if (res.results && res.results[String(visitId)]) {
                item = res.results[String(visitId)];
            } else if (res.results) {
                $.each(res.results, function (k, v) {
                    if (String(v.hn) === String(hn)) { item = v; return false; }
                });
            }

            if (!item) {
                item = { success: false, status: 'error', message: res.message || 'ไม่พบข้อมูล' };
            }

            var msgText      = item.message || '-';
            var status       = String(item.status || '').toLowerCase();
            var approvedList = ['approved','paid','accepted','success','waited','claimed','processed','complete','completed','cut_off_batch'];
            var isApproved   = approvedList.indexOf(status) !== -1;
            var currentDate  = new Date().toISOString().replace('T',' ').substring(0, 16);

            // ── ปุ่ม + result box ──
            if (isApproved) {
                btn.html('<i class="fa fa-check-circle" style="color:#2e7d32"></i> ผ่าน');
                resultBox
                    .removeClass('text-danger text-info').addClass('text-success')
                    .html('<div style="margin-top:4px;padding:4px 8px;border-radius:8px;background:#dcfce7;border:1px solid #86efac;color:#15803d;font-size:10px;font-weight:700;"><i class="fa fa-check-circle"></i> ' + msgText + '</div>')
                    .show();
                row.removeClass('row-wait').addClass('row-pass');

            } else if (item.success) {
                btn.html('<i class="fa fa-paper-plane" style="color:#1565c0"></i> ส่งแล้ว');
                resultBox
                    .removeClass('text-danger text-success').addClass('text-info')
                    .html('<div style="margin-top:4px;padding:4px 8px;border-radius:8px;background:#dbeafe;border:1px solid #93c5fd;color:#1d4ed8;font-size:10px;font-weight:700;"><i class="fa fa-paper-plane"></i> ' + msgText + '</div>')
                    .show();
                row.removeClass('row-wait').addClass('row-pass');

            } else {
                btn.html('<i class="fa fa-times-circle" style="color:#c62828"></i> ไม่ผ่าน');
                resultBox
                    .removeClass('text-success text-info').addClass('text-danger')
                    .html('<div style="margin-top:4px;padding:4px 8px;border-radius:8px;background:#fee2e2;border:1px solid #fca5a5;color:#b91c1c;font-size:10px;font-weight:700;"><i class="fa fa-times-circle"></i> ' + msgText + '</div>')
                    .show();
                row.removeClass('row-pass').addClass('row-wait');
            }

            btn.prop('disabled', false);

            // ── td-status ──
            if (statusCell.length) {
                var icon  = isApproved   ? 'fa-check-circle'
                          : item.success ? 'fa-paper-plane'
                          :               'fa-times-circle';
                var color = isApproved   ? '#16a34a'
                          : item.success ? '#2563eb'
                          :               '#dc2626';
                statusCell.html(
                    '<div style="color:' + color + ';font-weight:600;">' +
                    '<i class="fa ' + icon + '"></i> ' + msgText + '</div>' +
                    '<div style="font-size:11px;color:#6b7280;margin-top:2px;">' +
                    '<i class="fa fa-clock-o"></i> ' + currentDate + '</div>'
                );
            }

            // ── กระพริบแถว ──
            row.css({ background: '#fef08a', transition: 'background 0.3s' });
            setTimeout(function () { row.css('background', ''); }, 1000);
        },
        error: function (xhr) {
            btn.html('<i class="fa fa-times" style="color:#c62828"></i> Error').prop('disabled', false);
            resultBox
                .removeClass('text-success text-info').addClass('text-danger')
                .html('<div style="padding:4px 8px;border-radius:8px;background:#fee2e2;color:#b91c1c;font-size:10px;">AJAX ERROR: ' + xhr.status + '</div>')
                .show();
        }
    });
});
JS
, \yii\web\View::POS_END); ?>

<?php
Modal::begin([
    'id' => 'fileListModal',
    'header' => '<h4 style="font-weight:600; color:#1e1b4b;"><i class="fa-solid fa-folder-open text-warning"></i> รายชื่อไฟล์ (File List)</h4>',
    'size' => Modal::SIZE_LARGE,
]);
echo "<div id='modal-content' style='padding:10px;'>กำลังโหลดข้อมูล...</div>";
Modal::end();

// JavaScript สำหรับดึงข้อมูลผ่าน Ajax เข้าสู่ Modal
$this->registerJs("
    $('#fileListModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var url = button.data('url');
        var modal = $(this);
        $.ajax({
            url: url,
            success: function(data) {
                modal.find('#modal-content').html(data);
            },
            error: function() {
                modal.find('#modal-content').html('<span class=\"text-danger\">เกิดข้อผิดพลาดในการโหลดไฟล์</span>');
            }
        });
    });
");
?>