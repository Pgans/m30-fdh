<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\jui\DatePicker;

$this->title = 'ระบบบริหารจัดการข้อมูล [FDH-DENT]';

$this->registerCssFile('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap');
$this->registerCss("

/* ══ BASE ══════════════════════════════════════════════════════ */
body, table, .kv-grid-table, .btn, h4, h5, span, div, td, th, input, select {
    font-family: 'Sarabun', sans-serif !important;
}

/* ══ PAGE WRAPPER ══════════════════════════════════════════════ */
.anc-page-wrapper  { background:#f0f2f8; padding:22px; border-radius:18px; }
.anc-page-title    { font-size:14px; font-weight:700; color:#1e1b4b;
                     margin-bottom:18px; padding-bottom:12px;
                     border-bottom:2px solid #e2e8f0;
                     display:flex; align-items:center; gap:8px; }

/* ══ BADGE ROW ═════════════════════════════════════════════════ */
.dashboard-badge-row { display:flex; flex-wrap:wrap; gap:12px; margin-bottom:22px; }
.chip-badge {
    display:inline-flex; align-items:center; gap:10px;
    padding:14px 28px; border-radius:14px;
    font-size:16px; font-weight:700;
    text-decoration:none !important;
    transition:all .2s ease;
    border:2px solid transparent;
    white-space:nowrap; cursor:pointer;
    box-shadow:0 4px 10px rgba(0,0,0,.04);
}
.chip-badge:hover { transform:translateY(-3px); box-shadow:0 8px 20px rgba(0,0,0,.15); }
.chip-active      { box-shadow:0 0 0 4px rgba(108,72,255,.4) !important; }

.chip-all       { background:linear-gradient(135deg,#6c48ff,#9d7bff); color:#fff; border-color:#6c48ff; }
.chip-sent      { background:#eff6ff;  color:#1d4ed8; border-color:#bfdbfe; }
.chip-wait      { background:#fffbeb;  color:#b45309; border-color:#fde68a; }
.chip-today     { background:#f0fdf4;  color:#15803d; border-color:#bbf7d0; }
.chip-money-ok  { background:#ecfdf5;  color:#047857; border-color:#a7f3d0; }
.chip-money-no  { background:#fef2f2;  color:#b91c1c; border-color:#fecaca; }
.chip-money-all { background:#f3f4f6;  color:#374151; border-color:#d1d5db; }

/* ══ CONTROL CARDS ═════════════════════════════════════════════ */
.control-container {
    display:grid;
    grid-template-columns:220px 200px 1fr;
    gap:16px; margin-bottom:18px;
}
@media (max-width:992px) { .control-container { grid-template-columns:1fr; } }

.control-card {
    background:#fff; border-radius:16px; padding:18px 20px;
    box-shadow:0 2px 12px rgba(0,0,0,.06);
    border:1px solid #e8eaf0;
    display:flex; flex-direction:column; justify-content:space-between;
    min-height:120px;
}
.card-purple { border-top:4px solid #6c48ff; background:linear-gradient(160deg,#faf8ff,#fff); }
.card-teal   { border-top:4px solid #0d9488; background:linear-gradient(160deg,#f0fdfa,#fff); }
.card-form   { border-top:4px solid #94a3b8; background:linear-gradient(160deg,#f8fafc,#fff); }

.card-label { font-size:13px; font-weight:700; letter-spacing:.5px; text-transform:uppercase; margin-bottom:4px; }
.card-value { font-size:28px; font-weight:700; color:#111827; line-height:1.1; margin-bottom:10px; }
.card-value small { font-size:14px; font-weight:400; color:#6b7280; }

.dot-indicator {
    height:9px; width:9px; background:#22c55e; border-radius:50%;
    display:inline-block; margin-right:6px;
    box-shadow:0 0 0 3px rgba(34,197,94,.2);
}
.pill-btn {
    display:inline-block; padding:5px 16px; border-radius:999px;
    font-size:13px; font-weight:600; border:none; cursor:pointer;
    text-decoration:none; transition:opacity .15s;
}
.pill-btn:hover { opacity:.85; text-decoration:none; }
.pill-purple { background:#6c48ff; color:#fff; }
.pill-teal   { background:#0d9488; color:#fff; }

/* ── Date Form ──────────────────────────────────────────────── */
.date-form-inner { display:flex; align-items:center; gap:10px; flex-wrap:wrap; height:100%; }
.date-form-inner .form-control {
    border-radius:8px !important;
    border:1.5px solid #d1d5db !important;
    font-size:14px !important; height:36px; width:140px !important;
    background:#fafafa; transition:border-color .2s;
}
.date-form-inner .form-control:focus {
    border-color:#6c48ff !important;
    box-shadow:0 0 0 3px rgba(108,72,255,.15) !important; outline:none;
}
.btn-search {
    background:linear-gradient(135deg,#6c48ff,#9d7bff); color:#fff;
    border:none; border-radius:999px; padding:7px 22px;
    font-size:14px; font-weight:600; cursor:pointer; transition:opacity .15s;
}
.btn-search:hover { opacity:.88; }

/* ══ QUICK LINKS ════════════════════════════════════════════════ */
.quick-links-bar {
    background:#fff; border:1px solid #e5e7eb; border-radius:10px;
    padding:10px 18px; display:flex; align-items:center;
    gap:5px; margin-bottom:16px; font-size:14px; flex-wrap:wrap;
}
.quick-links-bar a {
    color:#4f46e5; text-decoration:none; font-weight:600;
    padding:3px 8px; border-radius:6px; transition:background .15s;
}
.quick-links-bar a:hover   { background:#eff6ff; text-decoration:none; }
.quick-links-bar .ql-success       { color:#059669; }
.quick-links-bar .ql-success:hover { background:#ecfdf5; }
.quick-links-bar .ql-warn          { color:#d97706; }
.quick-links-bar .ql-warn:hover    { background:#fffbeb; }
.quick-links-bar .sep { color:#d1d5db; margin:0 2px; }

/* ══ TABLE SHELL ════════════════════════════════════════════════ */
.table-shell {
    border-radius:14px; overflow:hidden;
    border:1px solid #e2e8f0;
    box-shadow:0 4px 16px rgba(0,0,0,.06);
}
.grid-wrapper {
    height:520px; overflow-y:auto; overflow-x:auto; background:#fff;
}
.grid-wrapper::-webkit-scrollbar       { width:6px; height:6px; }
.grid-wrapper::-webkit-scrollbar-track { background:#f1f5f9; }
.grid-wrapper::-webkit-scrollbar-thumb { background:#cbd5e1; border-radius:4px; }
.grid-wrapper::-webkit-scrollbar-thumb:hover { background:#94a3b8; }

/* ── Header sticky ──────────────────────────────────────────── */
.kv-grid-table thead th {
    position:sticky !important; top:0 !important;
    background:linear-gradient(180deg,#2d2a6e,#1e1b4b) !important;
    color:#c7d2fe !important;
    font-size:14px !important; font-weight:600 !important;
    letter-spacing:.3px; padding:11px 12px !important;
    text-align:center; border:none !important;
    border-bottom:2px solid #4338ca !important;
    z-index:5; white-space:nowrap;
}

/* ── Body cells ─────────────────────────────────────────────── */
.kv-grid-table tbody td {
    padding:9px 10px !important;
    font-size:15px;
    vertical-align:middle !important;
    border-bottom:1px solid #f1f5f9 !important;
    border-right:none !important;
}
.kv-grid-table tbody tr { height:50px; transition:background .12s ease; }

/* ── Row colors + zebra ─────────────────────────────────────── */
.row-sent              { background:#f0fdf4 !important; }
.row-sent:nth-child(even) { background:#e8fdf0 !important; }
.row-sent:hover td     { background:#dcfce7 !important; }

.row-wait              { background:#fff1f2 !important; }
.row-wait:nth-child(even) { background:#ffe8ea !important; }
.row-wait:hover td     { background:#ffe4e6 !important; }

/* ── Empty text ─────────────────────────────────────────────── */
.kv-grid-table td.kv-grid-empty { padding:50px !important; text-align:center; }

/* ══ INLINE BADGES ══════════════════════════════════════════════ */
.tb {
    padding:3px 10px; border-radius:6px;
    font-size:13px; font-weight:700;
    display:inline-block; border:1px solid transparent;
}
.tb-pill {
    padding:4px 12px; border-radius:999px;
    font-size:13px; font-weight:700;
    display:inline-flex; align-items:center; gap:5px;
    border:1px solid transparent;
}
.tb-icon {
    width:16px; height:16px; border-radius:50%;
    display:inline-flex; align-items:center; justify-content:center;
    font-size:10px; font-weight:900; flex-shrink:0;
}
.tb-green  { background:#dcfce7; color:#15803d; border-color:#bbf7d0; }
.tb-red    { background:#ffe4e6; color:#b91c1c; border-color:#fecaca; }
.tb-blue   { background:#eff6ff; color:#1d4ed8; border-color:#bfdbfe; }
.icon-green { background:#22c55e; color:#fff; }
.icon-red   { background:#f43f5e; color:#fff; }

.seq-badge {
    display:inline-flex; align-items:center; justify-content:center;
    width:24px; height:24px; background:#e2e8f0; color:#475569;
    border-radius:50%; font-size:12px; font-weight:700;
}
.d-update-text { font-size:12px; color:#64748b; margin-top:3px; font-weight:400; }

/* ── ข้อความยาว truncate ─────────────────────────────────────── */
.kv-grid-table .col-fullname,
.kv-grid-table .col-diagx {
    max-width:160px; overflow:hidden;
    text-overflow:ellipsis; white-space:nowrap;
}

/* ── ปุ่มเช็ค ────────────────────────────────────────────────── */
.btn-check-status {
    background:linear-gradient(135deg,#e3f2fd,#bbdefb);
    color:#1565c0; border:1px solid #90caf9;
    border-radius:20px; padding:4px 12px;
    font-size:12px; font-weight:700;
    cursor:pointer; transition:all .2s; white-space:nowrap;
}
.btn-check-status:hover {
    background:linear-gradient(135deg,#bbdefb,#90caf9);
    transform:translateY(-1px);
    box-shadow:0 3px 8px rgba(21,101,192,.25);
}

/* ══ FLOATING BUTTON ════════════════════════════════════════════ */
.floating-container {
    position:fixed; bottom:36px; left:50%;
    transform:translateX(-50%); z-index:9999;
}
.btn-floating {
    background:linear-gradient(135deg,#22c55e,#16a34a) !important;
    color:#fff !important; font-size:16px; font-weight:700;
    border-radius:999px; padding:12px 36px;
    box-shadow:0 8px 24px rgba(34,197,94,.45);
    border:3px solid #fff !important;
    transition:all .2s; letter-spacing:.2px;
}
.btn-floating:hover {
    transform:scale(1.04);
    box-shadow:0 12px 28px rgba(34,197,94,.55);
    color:#fff !important;
}

/* ══ DATEPICKER ═════════════════════════════════════════════════ */
.ui-datepicker {
    z-index:9999 !important; border-radius:12px !important;
    box-shadow:0 10px 30px rgba(0,0,0,.15) !important;
    border:1px solid #e5e7eb !important;
}
.ui-datepicker-header {
    background:linear-gradient(135deg,#6c48ff,#9d7bff) !important;
    border:none !important; color:#fff !important;
    border-radius:8px 8px 0 0 !important; padding:8px !important;
}
.ui-datepicker-title          { color:#fff !important; font-weight:700; }
.ui-datepicker-prev,
.ui-datepicker-next           { color:#fff !important; }
.ui-datepicker th             { color:#6c48ff !important; font-weight:700; }
.ui-datepicker td .ui-state-active {
    background:#6c48ff !important; border-color:#6c48ff !important; color:#fff !important;
}
.ui-datepicker td .ui-state-hover {
    background:#ede9ff !important; color:#6c48ff !important;
}
");
?>

<div class="anc-page-wrapper">

    <div class="anc-page-title">
        <i class="fa fa-tooth" style="color:#6c48ff;"></i>
      เงื่อนไข:: สิทธิ์บัตรทอง รหัสโรค Z348 อุลตราซาวด์ 88.78 -upt->'lab_id = '039'-> Pregnancy test
    </div>

    <div class="dashboard-badge-row">
        <a href="<?= Url::current(['statusFilter' => 'all']) ?>"
           class="chip-badge chip-all <?= $statusFilter === 'all' ? 'chip-active' : '' ?>">
            <i class="fa fa-folder"></i> ทั้งหมด <strong>(<?= $totalCases ?> ราย)</strong>
        </a>
        <a href="<?= Url::current(['statusFilter' => 'success']) ?>"
           class="chip-badge chip-sent <?= $statusFilter === 'success' ? 'chip-active' : '' ?>">
            <i class="fa fa-check-circle"></i> ส่งแล้ว <strong>(<?= $sentCases ?> ราย)</strong>
        </a>
        <a href="<?= Url::current(['statusFilter' => 'waiting']) ?>"
           class="chip-badge chip-wait <?= $statusFilter === 'waiting' ? 'chip-active' : '' ?>">
            <i class="fa fa-clock-o"></i> รอส่ง <strong>(<?= $waitCases ?> ราย)</strong>
        </a>
        <a href="<?= Url::current(['statusFilter' => 'today']) ?>"
           class="chip-badge chip-today <?= $statusFilter === 'today' ? 'chip-active' : '' ?>">
            <i class="fa fa-calendar-check-o"></i> ส่งวันนี้ <strong>(<?= $amountToday ?> ราย)</strong>
        </a>
        <span class="chip-badge chip-money-ok">
            <i class="fa fa-check"></i> ยอดชดเชยแล้ว <strong><?= number_format($compensated, 2) ?></strong>
        </span>
        <a href="<?= Url::current(['statusFilter' => 'not_compensated']) ?>"
           class="chip-badge chip-money-no <?= $statusFilter === 'not_compensated' ? 'chip-active' : '' ?>">
            <i class="fa fa-times"></i> ยังไม่ชดเชย <strong><?= number_format($notCompensated, 2) ?></strong>
        </a>
        <span class="chip-badge chip-money-all">
            <i class="fa fa-calculator"></i> ค่ารักษาทั้งหมด <strong><?= number_format($totalAmount, 2) ?></strong>
        </span>
    </div>

    <div class="control-container">

        <div class="control-card card-purple">
            <div>
                <div class="card-label" style="color:#6c48ff;">ยืนยันส่งวันนี้</div>
                <div class="card-value"><?= $amountToday ?> <small>เคส</small></div>
            </div>
            <?= Html::button('<i class="fa fa-folder-open"></i> เปิดอ่านไฟล์', [
                'class' => 'pill-btn pill-purple',
                'data-toggle' => 'modal',
                'data-target' => '#fileListModal',
            ]) ?>
        </div>

        <div class="control-card card-teal">
            <div>
                <div class="card-label" style="color:#0d9488;"><i class="fa fa-key"></i> STATUS TOKEN</div>
                <div style="font-size:16px;font-weight:600;color:#111827;margin-bottom:10px;">
                    <span class="dot-indicator"></span>Status: OK
                </div>
            </div>
            <a href="<?= Url::to(['f16dent/run-curl']) ?>" class="pill-btn pill-teal">
                <i class="fa fa-refresh"></i> Run Token
            </a>
        </div>

        <div class="control-card card-form">
            <div class="card-label" style="color:#64748b;margin-bottom:10px;">
                <i class="fa fa-calendar"></i> ค้นหาตามช่วงเวลารับบริการ
            </div>
            <?= Html::beginForm(['index'], 'get', ['id' => 'searchForm']) ?>
            <input type="hidden" name="statusFilter" value="<?= Html::encode($statusFilter) ?>">
            <div class="date-form-inner">
                <span style="font-size:12px;color:#94a3b8;font-weight:600;">เริ่ม</span>
                <?= DatePicker::widget([
                    'name' => 'date1', 'value' => $date1,
                    'language' => 'th', 'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control', 'readonly' => true],
                    'clientOptions' => ['autoclose' => true, 'todayHighlight' => true],
                ]) ?>
                <span style="color:#cbd5e1;">—</span>
                <span style="font-size:12px;color:#94a3b8;font-weight:600;">ถึง</span>
                <?= DatePicker::widget([
                    'name' => 'date2', 'value' => $date2,
                    'language' => 'th', 'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control', 'readonly' => true],
                    'clientOptions' => ['autoclose' => true, 'todayHighlight' => true],
                ]) ?>
                <button type="submit" class="btn-search">
                    <i class="fa fa-search"></i> เรียกดู
                </button>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>

    <div class="quick-links-bar">
        <i class="fa fa-link" style="color:#94a3b8;"></i>
        <a href="https://uat-fdh.inet.co.th/hospital/detail" target="_blank">FDH-UAT</a>
        <span class="sep">|</span>
        <a href="https://fdh.moph.go.th/hospital/" target="_blank" class="ql-success">FDH-Production</a>
        <span class="sep">|</span>
       
        <?= Html::a('<i class="fa fa-window-restore"></i> Query ในหน้านี้ (Modal)', '#', [
            'class' => 'ql-warn',
            'style' => 'font-weight: bold;',
            'data-toggle' => 'modal',
            'data-target' => '#queryDataModal',
            'data-url' => Url::to(['/fdhancdentusupt/index']),
        ]) ?>
        
        <span class="sep">|</span>
        <a href="<?= Url::to(['f16dent/exports', 'date1' => $date1, 'date2' => $date2]) ?>" class="ql-success">
            <i class="fa fa-file-excel-o"></i> Export Excel
        </a>
    </div>

    <?= Html::beginForm(['f16dent/data'], 'post', ['name' => 'frmMain']) ?>

    <div class="table-shell">
        <div class="grid-wrapper">
           <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => ['class' => 'kv-grid-table table table-condensed'],
    'layout'       => '{items}',
    'emptyText'    => '
        <div style="padding:50px;text-align:center;color:#dc2626;font-weight:700;font-size:15px;">
            <div style="font-size:32px;margin-bottom:8px;">⚠️</div>
            ไม่พบข้อมูลตามเงื่อนไขที่ระบุ
        </div>',
    'rowOptions' => function($model) {
        $cls = !empty($model['messagecode']) ? 'row-sent' : 'row-wait';
        return ['class' => $cls, 'style' => 'cursor:default;'];
    },
    'columns' => [

        /* ── Checkbox ──────────────────────────────────────── */
        [
            'header'         => '<input type="checkbox" id="CheckAll"
                                    onclick="ClickCheckAll(this)"
                                    style="width:15px;height:15px;accent-color:#6c48ff;">',
            'width'          => '38px',
            'format'         => 'raw',
            'hAlign'         => GridView::ALIGN_CENTER,
            'headerOptions'  => ['style' => 'text-align:center;'],
            'contentOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
            'value'          => function($model) {
                $val = ($model['visit_id'] ?? '') . '.' . ($model['hn'] ?? '');
                return '<input type="checkbox" name="chkDel[]"
                            value="' . Html::encode($val) . '"
                            style="width:15px;height:15px;accent-color:#6c48ff;">';
            },
        ],

        /* ── ลำดับ ──────────────────────────────────────────── */
        [
            'header'         => '#',
            'width'          => '46px',
            'format'         => 'raw',
            'headerOptions'  => ['style' => 'text-align:center;'],
            'contentOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
            'value'          => function($model, $key, $index) {
                return '<span class="seq-badge">' . ($index + 1) . '</span>';
            },
        ],

        /* ── วันที่ ──────────────────────────────────────────── */
        [
            'attribute'      => 'regdate',
            'header'         => 'วันที่',
            'contentOptions' => ['style' => 'white-space:nowrap;'],
            'value'          => function($m) { return $m['regdate'] ?? ''; },
        ],

        /* ── HN ─────────────────────────────────────────────── */
        [
            'attribute'      => 'hn',
            'header'         => 'HN',
            'contentOptions' => ['style' => 'white-space:nowrap;'],
            'value'          => function($m) { return $m['hn'] ?? ''; },
        ],

        /* ── ชื่อ-สกุล ──────────────────────────────────────── */
        [
            'attribute'      => 'fullname',
            'header'         => 'ชื่อ-สกุล',
            'contentOptions' => ['style' => 'min-width:140px;max-width:180px;
                                             overflow:hidden;text-overflow:ellipsis;
                                             white-space:nowrap;'],
            'value'          => function($m) { return $m['fullname'] ?? ''; },
        ],

        /* ── อายุ ───────────────────────────────────────────── */
        [
            'attribute'      => 'age',
            'header'         => 'อายุ',
            'hAlign'         => GridView::ALIGN_CENTER,
            'contentOptions' => ['style' => 'text-align:center;'],
            'value'          => function($m) { return $m['age'] ?? ''; },
        ],

        /* ── แผนก ───────────────────────────────────────────── */
        [
            'attribute'      => 'unit_name',
            'header'         => 'แผนก',
            'contentOptions' => ['style' => 'white-space:nowrap;'],
            'value'          => function($m) { return $m['unit_name'] ?? ''; },
        ],

        /* ── โรคหลัก ─────────────────────────────────────────── */
        [
            'attribute'      => 'Diagx',
            'header'         => 'โรคหลัก',
            'contentOptions' => ['style' => 'min-width:120px;max-width:160px;
                                             overflow:hidden;text-overflow:ellipsis;
                                             white-space:nowrap;'],
            'value'          => function($m) { return $m['Diagx'] ?? ''; },
        ],

        /* ── รหัสโรค ─────────────────────────────────────────── */
        [
            'attribute'      => 'Diag',
            'header'         => 'รหัสโรค',
            'format'         => 'raw',
            'hAlign'         => GridView::ALIGN_CENTER,
            'contentOptions' => ['style' => 'text-align:center;white-space:nowrap;'],
            'value'          => function($model) {
                $cls = !empty($model['messagecode']) ? 'tb-green' : 'tb-red';
                return '<span class="tb ' . $cls . '">'
                     . Html::encode($model['Diag'] ?? '')
                     . '</span>';
            },
        ],

        /* ── หัตถการ ─────────────────────────────────────────── */
        [
            'attribute'      => 'oper',
            'header'         => 'หัตถการ',
            'contentOptions' => ['style' => 'white-space:nowrap;'],
            'value'          => function($m) { return $m['oper'] ?? ''; },
        ],

        /* ── สิทธิ์ ──────────────────────────────────────────── */
        [
            'attribute'      => 'inscl',
            'header'         => 'สิทธิ์',
            'hAlign'         => GridView::ALIGN_CENTER,
            'contentOptions' => ['style' => 'text-align:center;white-space:nowrap;'],
            'value'          => function($m) { return $m['inscl'] ?? ''; },
        ],

        /* ── สถานหลัก ────────────────────────────────────────── */
        [
            'attribute'      => 'hospmain',
            'header'         => 'สถานหลัก',
            'format'         => 'raw',
            'hAlign'         => GridView::ALIGN_CENTER,
            'contentOptions' => ['style' => 'text-align:center;white-space:nowrap;'],
            'value'          => function($model) {
                $val = $model['hospmain'] ?? '';
                $cls = ($val === '10953') ? 'tb-green' : 'tb-red';
                return '<span class="tb ' . $cls . '">' . Html::encode($val) . '</span>';
            },
        ],

        /* ── แลป ─────────────────────────────────────────────── */
        [
            'attribute' => 'labname',
            'header'    => 'แลป',
            'value'     => function($m) { return $m['labname'] ?? ''; },
        ],

        /* ── ค่ารักษา ────────────────────────────────────────── */
        [
            'attribute'      => 'amount',
            'header'         => 'ค่ารักษา',
            'format'         => 'raw',
            'hAlign'         => GridView::ALIGN_RIGHT,
            'contentOptions' => ['style' => 'text-align:right;white-space:nowrap;
                                             font-variant-numeric:tabular-nums;'],
            'value'          => function($model) {
                $v   = (float)($model['amount'] ?? 0);
                $cls = ($v == 0) ? 'tb-red' : 'tb-blue';
                return '<span class="tb ' . $cls . '">' . number_format($v, 2) . '</span>';
            },
        ],

        /* ── ชดเชย ───────────────────────────────────────────── */
        [
            'attribute'      => 'ret_statement',
            'header'         => 'ชดเชย',
            'format'         => 'raw',
            'hAlign'         => GridView::ALIGN_RIGHT,
            'contentOptions' => ['style' => 'text-align:right;white-space:nowrap;
                                             font-variant-numeric:tabular-nums;'],
            'value'          => function($model) {
                $v   = (float)($model['ret_statement'] ?? 0);
                $cls = ($v == 0) ? 'tb-red' : 'tb-blue';
                return '<span class="tb ' . $cls . '">' . number_format($v, 2) . '</span>';
            },
        ],

        /* ── สถานะ ───────────────────────────────────────────── */
        [
            'attribute'      => 'messagecode',
            'header'         => 'สถานะ',
            'format'         => 'raw',
            'hAlign'         => GridView::ALIGN_CENTER,
            'contentOptions' => ['style' => 'text-align:center;white-space:nowrap;'],
            'value'          => function($model) {
                $msg     = $model['messagecode'] ?? '';
                $dUpdate = $model['d_update']    ?? '';

                if (!empty($msg)) {
                    $badge = '<span class="tb-pill tb-green">'
                           . '<span class="tb-icon icon-green">&#10003;</span>'
                           . Html::encode($msg)
                           . '</span>';
                } else {
                    $badge = '<span class="tb-pill tb-red">'
                           . '<span class="tb-icon icon-red">&#10005;</span>'
                           . 'รอส่ง'
                           . '</span>';
                }

                $time = !empty($dUpdate)
                    ? '<div class="d-update-text"><i class="fa fa-clock-o"></i> '
                      . Html::encode($dUpdate) . '</div>'
                    : '';

                return '<div style="display:flex;flex-direction:column;align-items:center;">'
                     . $badge . $time . '</div>';
            },
        ],

        /* ── claim_anc ───────────────────────────────────────── */
        ['attribute' => 'claim_code', 'header' => 'claim_anc', 'value' => function($m){ 
				$claim = $m['claim_code'] ?? '';
				$user  = $m['users'] ?? '';
				return $claim . '<br><small style="color:purple; font-size:14px;">' . $user . '</small>'; 
				}, 'format' => 'raw'
		],

        /* ── ปุ่มเช็ค ────────────────────────────────────────── */
        [
            'label'          => 'เช็ค',
            'format'         => 'raw',
            'headerOptions'  => ['style' => 'text-align:center;'],
            'contentOptions' => ['style' => 'white-space:nowrap;text-align:center;
                                             vertical-align:middle;width:150px;'],
            'value'          => function($model) {
                $visitIdPad = str_pad($model['visit_id'], 10, '0', STR_PAD_LEFT);
                $hnPad      = str_pad($model['hn'],        6, '0', STR_PAD_LEFT);
                $safeId     = 'r' . $visitIdPad;

                return '<button type="button"
                            class="btn-check-status"
                            data-value="' . $visitIdPad . $hnPad . '"
                            data-hn="'    . $hnPad      . '"
                            data-visit="' . $visitIdPad . '">
                            <i class="fa fa-search"></i> เช็ค
                        </button>
                        <div class="check-result"
                             id="result-' . $safeId . '"
                             style="margin-top:4px;font-size:10px;display:none;
                                    max-width:140px;word-wrap:break-word;">
                        </div>';
            },
        ],

        /* ── authen ──────────────────────────────────────────── */
        [
            'attribute'      => 'claimcode',
            'header'         => 'authen',
            'contentOptions' => ['style' => 'white-space:nowrap;font-size:12px;color:#475569;'],
            'value'          => function($m) { return $m['claimcode'] ?? ''; },
        ],

    ],
]); ?>
        </div>
    </div>

    <?php
    $allowedUsers  = [6, 96, 289, 383];
    $currentUserId = Yii::$app->user->id ?? null;
    $currentUserId = Yii::$app->user->id ?? null;
    if (in_array($currentUserId, $allowedUsers)):
    ?>
        <div class="floating-container">
            <?= Html::submitButton(
                '<i class="fa fa-paper-plane"></i> ส่งข้อมูล f16-dent',
                ['class' => 'btn btn-floating', 'name' => 'btnSubmit', 'id' => 'btnSubmit']
            ) ?>
        </div>
    <?php endif; ?>

    <?= Html::endForm() ?>

</div>

<?php $this->registerJs(
    "var _csrf    = '" . Yii::$app->request->csrfParam . "';" .
    "var _csrfVal = '" . Yii::$app->request->getCsrfToken() . "';" .
    "var _url     = '" . Url::to(['f16dent/check']) . "';",
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
// ═══ 1. MODAL รายชื่อไฟล์ส่งวันนี้ ═══
Modal::begin([
    'id'     => 'fileListModal',
    'header' => '<h4 style="font-weight:700;color:#1e1b4b;margin:0;"><i class="fa fa-folder-open" style="color:#f59e0b;"></i> รายชื่อไฟล์ส่งวันนี้</h4>',
    'size'   => Modal::SIZE_LARGE,
]);
echo '<div id="modalContent" style="min-height:100px;display:flex;align-items:center;justify-content:center;"><i class="fa fa-spinner fa-spin fa-2x text-muted"></i></div>';
Modal::end();

// ═══ 2. MODAL ใหม่สำหรับแสดงหน้าต่าง QUERY ระบบ f16dent ═══
Modal::begin([
    'id'     => 'queryDataModal',
    'header' => '<h4 style="font-weight:700;color:#6c48ff;margin:0;"><i class="fa fa-window-restore"></i> ข้อมูลระบบตรวจสอบแผนกเดนท์ [fdhdent]</h4>',
    'size'   => Modal::SIZE_LARGE,
]);
echo '<div id="queryModalContent" style="min-height:150px;display:flex;align-items:center;justify-content:center;"><i class="fa fa-spinner fa-spin fa-2x text-muted"></i> กำลังโหลดหน้าต่างข้อมูล...</div>';
Modal::end();


$ajaxUrl = Url::to(['f16erext/list-files-partial']);
$this->registerJs("
    // สคริปต์โหลดไฟล์เดิม
    \$('#fileListModal').on('show.bs.modal', function() {
        \$.ajax({
            url: '$ajaxUrl',
            success: function(res) { \$('#modalContent').html(res); },
            error:   function()    { \$('#modalContent').html('<span class=\"text-danger\"><i class=\"fa fa-exclamation-triangle\"></i> โหลดไม่สำเร็จ</span>'); }
        });
    });

    // สคริปต์ใหม่สำหรับ AJAX ดึงหน้า Query ข้อมูลมาหยอดลง Modal
    \$('#queryDataModal').on('show.bs.modal', function(event) {
        var button = \$(event.relatedTarget); 
        var targetUrl = button.data('url'); 
        var modal = \$(this);
        
        modal.find('#queryModalContent').html('<div style=\"text-align:center;padding:30px;\"><i class=\"fa fa-spinner fa-spin fa-2x text-primary\"></i><br><br>กำลังดึงข้อมูลจากระบบ...</div>');
        
        \$.ajax({
            url: targetUrl,
            type: 'GET',
            success: function(response) {
                modal.find('#queryModalContent').html(response);
            },
            error: function() {
                modal.find('#queryModalContent').html('<div class=\"alert alert-danger\"><i class=\"fa fa-exclamation-triangle\"></i> เกิดข้อผิดพลาด ไม่สามารถดึงหน้าสืบค้นข้อมูลได้</div>');
            }
        });
    });
");
?>