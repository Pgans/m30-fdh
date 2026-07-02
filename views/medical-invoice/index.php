<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\Json;

$this->title = 'ระบบใบค่ารักษาพยาบาล (db2)';

$invoicesJson = Json::htmlEncode($allInvoices);
$patientsJson = Json::htmlEncode($allPatients);

// Inject custom CSS
$css = <<<CSS

@import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=Prompt:wght@400;500;600;700&display=swap');

:root {
    --purple-50:  #f5f0ff;
    --purple-100: #ede5ff;
    --purple-200: #d8c8ff;
    --purple-400: #a47cff;
    --purple-500: #8b5cf6;
    --purple-600: #7c3aed;
    --purple-700: #6d28d9;
    --green-50:   #f0fdf4;
    --green-100:  #dcfce7;
    --green-400:  #4ade80;
    --green-500:  #22c55e;
    --green-600:  #16a34a;
    --teal-400:   #2dd4bf;
    --teal-500:   #14b8a6;
    --neutral-50: #fafafa;
    --neutral-100:#f4f4f5;
    --neutral-200:#e4e4e7;
    --neutral-400:#a1a1aa;
    --neutral-600:#52525b;
    --neutral-800:#27272a;
    --white:      #ffffff;
    --shadow-sm:  0 1px 3px rgba(139,92,246,.12), 0 1px 2px rgba(0,0,0,.06);
    --shadow-md:  0 4px 16px rgba(139,92,246,.14), 0 2px 6px rgba(0,0,0,.06);
    --shadow-lg:  0 10px 40px rgba(139,92,246,.18), 0 4px 12px rgba(0,0,0,.08);
    --radius-sm:  8px;
    --radius-md:  12px;
    --radius-lg:  18px;
    --radius-xl:  24px;
}

body, .medical-invoice-index {
    font-family: 'Sarabun', sans-serif;
    background: linear-gradient(135deg, #f5f0ff 0%, #f0fdf4 50%, #ede5ff 100%);
    min-height: 100vh;
    color: var(--neutral-800);
}

/* ===== PAGE HEADER ===== */
.page-header-card {
    background: linear-gradient(135deg, var(--purple-600) 0%, var(--purple-500) 50%, var(--teal-500) 100%);
    border-radius: var(--radius-xl);
    padding: 28px 36px;
    margin-bottom: 28px;
    box-shadow: var(--shadow-lg);
    position: relative;
    overflow: hidden;
}
.page-header-card::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 180px; height: 180px;
    background: rgba(255,255,255,.08);
    border-radius: 50%;
}
.page-header-card::after {
    content: '';
    position: absolute;
    bottom: -60px; left: 30%;
    width: 240px; height: 240px;
    background: rgba(255,255,255,.05);
    border-radius: 50%;
}
.page-header-card h1 {
    font-family: 'Prompt', sans-serif;
    font-size: 3.2rem;
    font-weight: 600;
    color: #fff;
    margin: 0;
    letter-spacing: .3px;
    position: relative; z-index: 1;
}
.page-header-card .subtitle {
    font-size: 1.76rem;
    color: rgba(255,255,255,.75);
    margin-top: 4px;
    position: relative; z-index: 1;
}
.page-header-card .header-icon {
    font-size: 4.8rem;
    margin-right: 16px;
    position: relative; z-index: 1;
}

/* ===== SEARCH CARD ===== */
.search-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: 22px 28px;
    margin-bottom: 24px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--purple-100);
}
.search-card .form-group {
    margin-right: 16px;
    margin-bottom: 0;
}
.search-card label {
    font-size: 1.64rem;
    font-weight: 600;
    color: var(--purple-600);
    display: block;
    margin-bottom: 5px;
    letter-spacing: .3px;
}
.search-card .form-control {
    border: 1.5px solid var(--purple-200);
    border-radius: var(--radius-sm);
    font-family: 'Sarabun', sans-serif;
    font-size: 1.8rem;
    padding: 8px 13px;
    color: var(--neutral-800);
    background: var(--purple-50);
    transition: border-color .2s, box-shadow .2s, background .2s;
    height: auto;
}
.search-card .form-control:focus {
    border-color: var(--purple-500);
    box-shadow: 0 0 0 3px rgba(139,92,246,.15);
    background: var(--white);
    outline: none;
}
.btn-search {
    background: linear-gradient(135deg, var(--purple-600), var(--purple-500));
    color: #fff;
    border: none;
    border-radius: var(--radius-sm);
    padding: 9px 22px;
    font-family: 'Sarabun', sans-serif;
    font-weight: 600;
    font-size: 1.8rem;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(139,92,246,.3);
    transition: transform .15s, box-shadow .15s;
}
.btn-search:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(139,92,246,.4);
    color: #fff;
}
.btn-export-all {
    background: linear-gradient(135deg, var(--green-600), var(--green-500));
    color: #fff;
    border: none;
    border-radius: var(--radius-sm);
    padding: 9px 20px;
    font-family: 'Sarabun', sans-serif;
    font-weight: 600;
    font-size: 1.9rem;
    margin-left: 8px;
    box-shadow: 0 2px 8px rgba(34,197,94,.28);
    transition: transform .15s, box-shadow .15s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-export-all:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(34,197,94,.4);
    color: #fff;
    text-decoration: none;
}

/* ===== GRID TABLE ===== */
.grid-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--purple-100);
    overflow: hidden;
}
.grid-card .grid-view {
    margin: 0;
}
.grid-card table.table {
    margin: 0;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 1.76rem;
}
.grid-card table.table thead th {
    background: linear-gradient(135deg, var(--purple-600) 0%, var(--purple-500) 100%);
    color: #fff;
    font-family: 'Prompt', sans-serif;
    font-weight: 500;
    font-size: 1.64rem;
    letter-spacing: .5px;
    padding: 13px 15px;
    border: none;
    white-space: nowrap;
}
.grid-card table.table thead th a {
    color: rgba(255,255,255,.85);
    text-decoration: none;
}
.grid-card table.table tbody tr {
    transition: background .15s;
}
.grid-card table.table tbody tr:nth-child(odd) td {
    background: var(--purple-50);
}
.grid-card table.table tbody tr:nth-child(even) td {
    background: var(--white);
}
.grid-card table.table tbody tr:hover td {
    background: var(--purple-100) !important;
}
.grid-card table.table tbody td {
    padding: 11px 15px;
    border-top: 1px solid var(--purple-100);
    color: var(--neutral-800);
    vertical-align: middle;
}
.grid-card .summary {
    background: var(--purple-50);
    padding: 10px 20px;
    font-size: 1.64rem;
    color: var(--neutral-600);
    border-top: 1px solid var(--purple-100);
}
.grid-card .pagination {
    margin: 12px 0 0;
    justify-content: center;
}
.grid-card .pagination .page-item .page-link {
    border-radius: var(--radius-sm);
    border: 1.5px solid var(--purple-200);
    color: var(--purple-600);
    font-family: 'Sarabun', sans-serif;
    font-size: 1.7rem;
    padding: 5px 12px;
    margin: 0 2px;
}
.grid-card .pagination .page-item.active .page-link {
    background: var(--purple-500);
    border-color: var(--purple-500);
    color: #fff;
}

/* ===== ACTION BUTTONS ===== */
.btn-view-invoice {
    background: linear-gradient(135deg, var(--purple-500), var(--teal-500));
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 5px 13px;
    font-family: 'Sarabun', sans-serif;
    font-size: 1.6rem;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(139,92,246,.25);
    transition: transform .15s, box-shadow .15s;
    white-space: nowrap;
}
.btn-view-invoice:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(139,92,246,.35);
    color: #fff;
}
.btn-excel {
    background: linear-gradient(135deg, var(--green-600), var(--teal-500));
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 5px 11px;
    font-family: 'Sarabun', sans-serif;
    font-size: 1.6rem;
    font-weight: 600;
    box-shadow: 0 2px 6px rgba(22,163,74,.22);
    transition: transform .15s, box-shadow .15s;
    text-decoration: none;
    display: inline-block;
    white-space: nowrap;
}
.btn-excel:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(22,163,74,.35);
    color: #fff;
    text-decoration: none;
}

/* badge amount */
.amount-badge {
    background: var(--green-100);
    color: var(--green-600);
    font-weight: 700;
    border-radius: 6px;
    padding: 2px 10px;
    font-size: 1.7rem;
    display: inline-block;
    letter-spacing: .2px;
}

/* ===== MODAL ===== */
#modal .modal-content {
    border: none;
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    font-family: 'Sarabun', sans-serif;
}
#modal .modal-header {
    background: linear-gradient(135deg, var(--purple-600), var(--teal-500));
    border: none;
    padding: 18px 26px;
}
#modal .modal-header h4 {
    font-family: 'Prompt', sans-serif;
    font-size: 2.5rem;
    font-weight: 600;
    color: #fff;
    margin: 0;
}
#modal .modal-header .close {
    color: rgba(255,255,255,.8);
    opacity: 1;
    font-size: 1.7rem;
    text-shadow: none;
}
#modal .modal-header .close:hover { color: #fff; }
#modal .modal-body {
    padding: 24px;
    background: var(--neutral-50);
}
#modal .modal-footer {
    background: var(--white);
    border-top: 1px solid var(--purple-100);
    padding: 12px 24px;
}

/* patient info grid inside modal */
.patient-info-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-bottom: 18px;
}
.patient-info-grid .info-item {
    background: var(--white);
    border: 1.5px solid var(--purple-100);
    border-radius: var(--radius-sm);
    padding: 10px 14px;
}
.patient-info-grid .info-item .info-label {
    font-size: 1.44rem;
    color: var(--purple-500);
    font-weight: 700;
    letter-spacing: .5px;
    text-transform: uppercase;
    margin-bottom: 2px;
}
.patient-info-grid .info-item .info-value {
    font-size: 1.76rem;
    font-weight: 600;
    color: var(--neutral-800);
}
.patient-info-grid .info-item.full-width {
    grid-column: 1 / -1;
}

/* invoice table inside modal */
.invoice-table-wrap {
    background: var(--white);
    border: 1.5px solid var(--purple-100);
    border-radius: var(--radius-md);
    overflow: hidden;
}
.invoice-table-wrap table {
    width: 100%;
    font-size: .87rem;
    margin: 0;
    border-collapse: collapse;
}
.invoice-table-wrap thead th {
    background: linear-gradient(135deg, var(--purple-500), var(--teal-400));
    color: #fff;
    font-weight: 600;
    font-family: 'Prompt', sans-serif;
    font-size: 1.6rem;
    padding: 11px 14px;
    letter-spacing: .4px;
}
.invoice-table-wrap tbody td {
    padding: 9px 14px;
    border-top: 1px solid var(--purple-100);
    color: var(--neutral-800);
}
.invoice-table-wrap tbody tr:nth-child(odd) td  { background: var(--purple-50); }
.invoice-table-wrap tbody tr:nth-child(even) td { background: var(--white); }
.invoice-table-wrap .total-row td {
    background: linear-gradient(90deg, var(--green-50), var(--green-100)) !important;
    color: var(--green-700, #15803d);
    font-weight: 700;
    font-size: 1.8rem;
    border-top: 2px solid var(--green-400);
}

/* loading skeleton */
.skeleton-line {
    background: linear-gradient(90deg, var(--purple-100) 25%, var(--purple-50) 50%, var(--purple-100) 75%);
    background-size: 200% 100%;
    animation: shimmer 1.2s infinite;
    border-radius: 4px;
    height: 14px;
    margin: 6px 0;
}
@keyframes shimmer {
    0%   { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* empty state */
.empty-state {
    text-align: center;
    padding: 28px;
    color: var(--neutral-400);
    font-size: 1.8rem;
}
.empty-state .empty-icon { font-size: 4.4rem; margin-bottom: 8px; }

CSS;
$this->registerCss($css);
?>

<div class="medical-invoice-index" style="padding: 0 4px;">

    <!-- PAGE HEADER -->
    <div class="page-header-card d-flex align-items-center">
        <span class="header-icon">🏥</span>
        <div>
            <h1><?= Html::encode($this->title) ?></h1>
            <div class="subtitle">โรงพยาบาลม่วงสามสิบ &nbsp;·&nbsp; จังหวัดอุบลราชธานี</div>
        </div>
    </div>

    <!-- SEARCH CARD -->
    <div class="search-card">
        <?= Html::beginForm(['index'], 'get', ['class' => 'form-inline']) ?>
            <div class="form-group">
                <label>📅&nbsp; วันที่เริ่มต้น</label>
                <?= Html::input('date', 'startDate', $startDate, ['class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <label>📅&nbsp; วันที่สิ้นสุด</label>
                <?= Html::input('date', 'endDate', $endDate, ['class' => 'form-control']) ?>
            </div>
            <?= Html::submitButton('🔍&nbsp; ค้นหา', ['class' => 'btn btn-search']) ?>
            <?= Html::a(
                '⬇️&nbsp; ส่งออก CSV ทั้งหมด',
                ['export-all-csv', 'startDate' => $startDate, 'endDate' => $endDate],
                ['class' => 'btn-export-all', 'target' => '_blank', 'data-pjax' => '0']
            ) ?>
        <?= Html::endForm() ?>
    </div>

    <!-- GRID TABLE -->
    <div class="grid-card">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table'],
            'columns' => [
                [
                    'attribute' => 'No',
                    'label'     => '#',
                    'options'   => ['style' => 'width:50px; text-align:center'],
                    'contentOptions' => ['style' => 'text-align:center; font-weight:600; color:var(--purple-500)'],
                ],
                [
                    'attribute' => 'visit_id',
                    'label'     => 'Visit ID',
                    'contentOptions' => ['style' => 'font-family:monospace; font-size:1.64rem; color:var(--neutral-600)'],
                ],
                [
                    'attribute' => 'hn',
                    'label'     => 'HN',
                    'contentOptions' => ['style' => 'font-weight:600; color:var(--purple-600)'],
                ],
                [
                    'attribute' => 'fullname',
                    'label'     => 'ชื่อ-นามสกุล',
                ],
                [
                    'attribute' => 'regdate',
                    'label'     => 'วันรับบริการ',
                    'contentOptions' => ['style' => 'font-size:1.66rem; color:var(--neutral-600)'],
                ],
                [
                    'attribute' => 'inscl',
                    'label'     => 'สิทธิ์',
                    'format'    => 'raw',
                    'value'     => function ($model) {
                        $inscl = Html::encode($model['inscl']);
                        return "<span style='background:var(--purple-100);color:var(--purple-700);border-radius:6px;padding:2px 10px;font-size:.1.2rem;font-weight:600;'>{$inscl}</span>";
                    },
                ],
                [
                    'attribute' => 'amount',
                    'label'     => 'ค่ารักษา (บาท)',
                    'format'    => 'raw',
                    'value'     => function ($model) {
                        $amt = number_format((float)$model['amount'], 2);
                        return "<span class='amount-badge'>{$amt}</span>";
                    },
                    'contentOptions' => ['style' => 'text-align:right'],
                    'headerOptions'  => ['style' => 'text-align:right'],
                ],
                [
                    'label'   => 'การจัดการ',
                    'format'  => 'raw',
                    'value'   => function ($model) {
                        $vid = $model['visit_id'];
                        $viewBtn = Html::button('🔍 ดูค่ารักษา', [
                            'class'      => 'btn-view-invoice showInvoiceBtn',
                            'data-visit' => $vid,
                            'title'      => 'รายละเอียดค่ารักษา: ' . $vid,
                        ]);
                        $excelBtn = Html::a('📥 Excel', ['export-excel', 'visit_id' => $vid], [
                            'class'     => 'btn-excel',
                            'target'    => '_blank',
                            'data-pjax' => '0',
                        ]);
                        return $viewBtn . '&nbsp;' . $excelBtn;
                    },
                    'contentOptions' => ['style' => 'white-space:nowrap'],
                ],
            ],
        ]); ?>
    </div>

</div><!-- /.medical-invoice-index -->

<?php
Modal::begin([
    'header' => '<h4 id="modalHeader">รายละเอียดค่ารักษาพยาบาล</h4>',
    'id'     => 'modal',
    'size'   => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();

$js = <<<JS
var allInvoices = {$invoicesJson};
var allPatients = {$patientsJson};

$(function () {

    $(document).on('click', '.showInvoiceBtn', function () {
        var visitId = String($(this).data('visit'));
        var patient = allPatients[visitId] || {};
        var items   = allInvoices[visitId] || [];

        $('#modalHeader').html('📋&nbsp; Visit: ' + visitId + ' — ' + (patient.fullname || ''));

        /* ── Patient info grid ── */
        var html = '<div class="patient-info-grid">';

        html += _infoItem('👤 ผู้ป่วย', patient.fullname || '-');
        html += _infoItem('🪪 HN', patient.hn || '-');
        html += _infoItem('🛡️ สิทธิ์', patient.inscl || '-');

        html += _infoItem('🔢 เลขบัตร ปชช.', patient.cid || '-');
        html += _infoItem('🆔 Visit ID', visitId);
        html += _infoItem('🎂 อายุ', (patient.age_y || 0) + ' ปี ' + (patient.age_m || 0) + ' เดือน');

        html += '<div class="info-item full-width">';
        html += '<div class="info-label">📅 วันที่รับบริการ</div>';
        html += '<div class="info-value">' + (patient.REG_DATETIME || '-') + '</div>';
        html += '</div>';

        html += '</div>'; /* end patient-info-grid */

        /* ── Invoice table ── */
        html += '<div class="invoice-table-wrap">';
        html += '<table><thead><tr>';
        html += '<th>รายการ</th>';
        html += '<th style="text-align:right;width:130px">จำนวนเงิน</th>';
        html += '<th style="text-align:right;width:130px">สุทธิ</th>';
        html += '</tr></thead><tbody>';

        var total = 0;

        if (items.length === 0) {
            html += '<tr><td colspan="3">';
            html += '<div class="empty-state"><div class="empty-icon">📭</div>ไม่มีรายการค่ารักษา</div>';
            html += '</td></tr>';
        } else {
            items.forEach(function (item) {
                var amount   = parseFloat(item.amount)   || 0;
                var subtotal = parseFloat(item.subtotal) || 0;
                total += subtotal;
                html += '<tr>';
                html += '<td>' + item.item + '</td>';
                html += '<td style="text-align:right">' + _fmt(amount)   + '</td>';
                html += '<td style="text-align:right">' + _fmt(subtotal) + '</td>';
                html += '</tr>';
            });
        }

        html += '<tr class="total-row">';
        html += '<td colspan="2" style="text-align:right">💰 รวมทั้งสิ้น</td>';
        html += '<td style="text-align:right">' + _fmt(total) + '</td>';
        html += '</tr>';

        html += '</tbody></table></div>'; /* end invoice-table-wrap */

        $('#modalContent').html(html);
        $('#modal').modal('show');
    });

    function _infoItem(label, value) {
        return '<div class="info-item">'
             + '<div class="info-label">' + label + '</div>'
             + '<div class="info-value">' + value + '</div>'
             + '</div>';
    }

    function _fmt(num) {
        return num.toLocaleString('th-TH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

});
JS;
$this->registerJs($js);
?>