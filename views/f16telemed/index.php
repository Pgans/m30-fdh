<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use dosamigos\datepicker\DatePicker;
use yii\web\View;

$this->title = 'FDH-TELEMED';
$this->registerCss(<<<'CSS'
@import url("https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;600;700;800&family=IBM+Plex+Mono:wght@400;600&display=swap");

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: "Noto Sans Thai", sans-serif; font-size: 15px; background: #f5f3ff; color: #1e1b4b; }

/* PAGE HEADER */
.page-header {
    background: linear-gradient(135deg, #6d28d9 0%, #7c3aed 50%, #1e1b4b 100%);
    padding: 18px 28px;
    display: flex;
    align-items: center;
    gap: 16px;
    position: sticky;
    top: 0;
    z-index: 200;
    box-shadow: 0 4px 18px rgba(109,40,217,0.30);
}
.page-header .badge-system {
    background: rgba(255,255,255,0.18);
    color: #fff;
    font-size: 12px;
    font-weight: 800;
    padding: 5px 14px;
    border-radius: 30px;
    letter-spacing: 1px;
}
.page-header h1 { font-size: 22px; font-weight: 800; color: #fff; }
.page-header .subtitle { font-size: 13px; color: rgba(255,255,255,0.75); font-family: "IBM Plex Mono", monospace; }

/* WRAPPER */
.dash-wrapper { width: 96%; margin: 22px auto; }

/* CONDITION BAR */
.condition-bar {
    background: #fff;
    border: 1px solid #ede9fe;
    border-radius: 16px;
    padding: 12px 18px;
    font-size: 13px;
    color: #3b0764;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    box-shadow: 0 4px 20px rgba(109,40,217,0.06);
}
.condition-bar i { color: #7c3aed; }
.condition-tag {
    background: #f5f3ff;
    border: 1px solid #ddd6fe;
    color: #6d28d9;
    padding: 3px 10px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
}

/* DASH GRID */
.dash-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 12px;
    margin-bottom: 18px;
}
@media (max-width: 1400px) { .dash-grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 900px)  { .dash-grid { grid-template-columns: repeat(2, 1fr); } }

/* DASH CARD */
.dash-card {
    background: linear-gradient(135deg, #fbfaff 0%, #f3efff 100%);
    border: 1px solid #e0d7ff;
    border-radius: 16px;
    padding: 12px;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    gap: 4px;
    min-height: 125px;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    color: #2e1065;
    box-shadow: 0 4px 14px rgba(109, 40, 217, 0.04);
}
.dash-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(109, 40, 217, 0.08);
    border-color: #c0b2ff;
    background: linear-gradient(135deg, #f5f0ff 0%, #ede5ff 100%);
}
.card-all     { background: linear-gradient(135deg, #f3efff 0%, #e8e1ff 100%); border-color: #d6cbff; }
.card-all .card-icon     { background: #a78bfa; color: #fff; }
.card-all .card-number   { color: #6d28d9; }
.card-done    { background: linear-gradient(135deg, #f0fdf4 0%, #e1fae9 100%); border-color: #bbf7d0; }
.card-done .card-icon    { background: #34d399; color: #fff; }
.card-done .card-number  { color: #059669; }
.card-remain  { background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%); border-color: #fecaca; }
.card-remain .card-icon  { background: #f472b6; color: #fff; }
.card-remain .card-number { color: #e11d48; }
.card-today   { background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%); border-color: #e9d5ff; }
.card-today .card-icon   { background: #8b5cf6; color: #fff; }
.card-today .card-number  { color: #7c3aed; }
.card-token   { background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%); border-color: #99f6e4; }
.card-token .card-icon   { background: #2dd4bf; color: #fff; }
.card-token .card-number  { color: #0d9488; }
.card-links   { background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%); border-color: #c7d2fe; }
.card-links .card-icon   { background: #818cf8; color: #fff; }
.card-links .card-number  { color: #4338ca; }
.card-search  { background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-color: #e2e8f0; }
.card-search .card-icon  { background: #94a3b8; color: #fff; }
.card-search .card-number { color: #475569; }

.card-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    margin-bottom: 2px;
}
.card-label  { font-size: 13px; font-weight: 700; color: #4c1d95; }
.card-number { font-size: 26px; font-weight: 700; font-family: "IBM Plex Mono", monospace; line-height: 1.1; }
.card-unit   { font-size: 12px; color: #6b21a8; opacity: 0.7; }
.card-actions { margin-top: auto; display: flex; flex-wrap: wrap; gap: 4px; }

.card-links a,
.card-links .cta-link {
    color: #312e81 !important;
    font-weight: 600;
    font-size: 12px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.15s ease;
}
.card-links a:hover,
.card-links .cta-link:hover {
    color: #4338ca !important;
    text-decoration: underline !important;
}

.card-search input[type="text"],
.card-search input[type="date"],
.card-search .form-control {
    background: #ffffff !important;
    border: 1px solid #cbd5e1 !important;
    color: #334155 !important;
    font-weight: 600;
    font-family: "IBM Plex Mono", monospace;
    font-size: 12px;
    padding: 4px 8px;
    border-radius: 6px;
    width: 100%;
}
.card-search input::placeholder { color: #64748b !important; opacity: 1; }

/* BUTTON */
.cta-btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    border: 1px solid rgba(109, 40, 217, 0.15);
    text-decoration: none;
    background: rgba(255, 255, 255, 0.6);
    color: #5b21b6;
    transition: all 0.15s ease;
    cursor: pointer;
}
.cta-btn:hover {
    background: rgba(255, 255, 255, 0.9);
    color: #4c1d95;
    border-color: rgba(109, 40, 217, 0.3);
    text-decoration: none;
}

/* UNIT SUMMARY */
.unit-summary-bar {
    background: #fff;
    border: 1px solid #ede9fe;
    border-radius: 14px;
    padding: 10px 16px;
    margin-bottom: 18px;
    box-shadow: 0 2px 10px rgba(109,40,217,0.06);
}
.unit-summary-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
    font-size: 13px;
    font-weight: 700;
    color: #1e1b4b;
}
.unit-summary-header .us-count {
    background: #f5f3ff;
    border: 1px solid #ddd6fe;
    color: #6d28d9;
    border-radius: 20px;
    padding: 1px 9px;
    font-size: 12px;
    font-weight: 700;
}
.unit-chips { display: flex; flex-wrap: wrap; gap: 6px; align-items: center; }
.unit-chip {
    display: inline-flex;
    align-items: center;
    gap: 0;
    border-radius: 20px;
    overflow: hidden;
    font-size: 12px;
    font-weight: 700;
    border: 1px solid #ede9fe;
    box-shadow: 0 1px 3px rgba(109,40,217,0.08);
    white-space: nowrap;
}
.chip-name  { background: #f5f3ff; color: #4c1d95; padding: 4px 8px; font-weight: 600; }
.chip-total { background: #4c1d95; color: #f8fafc; padding: 4px 7px; font-family: "IBM Plex Mono", monospace; font-weight: 700; }
.chip-sent  { background: #dcfce7; color: #15803d; padding: 4px 6px; font-family: "IBM Plex Mono", monospace; }
.chip-wait  { background: #fee2e2; color: #b91c1c; padding: 4px 6px; font-family: "IBM Plex Mono", monospace; border-radius: 0 20px 20px 0; }
.chip-pct   { padding: 4px 7px; font-family: "IBM Plex Mono", monospace; font-weight: 800; font-size: 11px; border-radius: 0 20px 20px 0; }
.chip-pct-green  { background: #bbf7d0; color: #14532d; }
.chip-pct-orange { background: #fed7aa; color: #92400e; }
.chip-pct-red    { background: #fecaca; color: #7f1d1d; }
.unit-toggle {
    margin-left: auto;
    font-size: 12px;
    color: #7c3aed;
    cursor: pointer;
    text-decoration: none;
    white-space: nowrap;
    padding: 2px 8px;
    border-radius: 6px;
    background: #f5f3ff;
    border: 1px solid #ddd6fe;
}
.unit-toggle:hover { background: #ede9fe; color: #4c1d95; text-decoration: none; }

/* TABLE */
.table-wrap {
    background: #fff;
    border: 1px solid #ede9fe;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 8px 28px rgba(109,40,217,0.08);
}
.scroll-area { height: 560px; overflow-y: auto; overflow-x: auto; }
.scroll-area::-webkit-scrollbar { width: 7px; height: 7px; }
.scroll-area::-webkit-scrollbar-thumb { background: #c4b5fd; border-radius: 10px; }

.data-table { width: 100%; border-collapse: collapse; font-size: 14px; }
.data-table thead th {
    position: sticky;
    top: 0;
    z-index: 50;
    background: linear-gradient(180deg, #f5f3ff 0%, #ede9fe 100%);
    color: #1e1b4b;
    font-weight: 800;
    font-size: 12px;
    letter-spacing: .5px;
    text-transform: uppercase;
    padding: 12px 10px;
    border-bottom: 1px solid #ddd6fe;
    text-align: center;
    white-space: nowrap;
}
.data-table tbody tr { border-bottom: 1px solid #e5e7eb; transition: all .15s ease; }
.data-table tbody tr.row-pass { background: #eefbf3 !important; border-left: 4px solid #22c55e; }
.data-table tbody tr.row-wait { background: #fff1f5 !important; border-left: 4px solid #f472b6; }
.data-table tbody tr.row-pass:hover { background: #dcfce7 !important; }
.data-table tbody tr.row-wait:hover { background: #ffe4ec !important; }
.data-table td { padding: 10px 10px; vertical-align: middle; white-space: nowrap; font-size: 14px; color: #1e293b; font-weight: 500; }

.num-col      { font-family: "IBM Plex Mono", monospace; font-size: 13px; color: #334155 !important; font-weight: 700; }
.col-visitid  { font-family: "IBM Plex Mono", monospace; font-weight: 700; color: #15803d !important; font-size: 13px; }
.col-hn       { font-family: "IBM Plex Mono", monospace; color: #6d28d9 !important; font-size: 13px; font-weight: 700; }
.col-name     { font-weight: 700; color: #111827 !important; }
.col-age      { text-align: center; color: #111827 !important; font-weight: 700; }
.col-diag     { color: #4338ca !important; font-weight: 700; }
.col-hospmain { color: #334155 !important; font-size: 13px; font-family: "IBM Plex Mono", monospace; font-weight: 600; }
.col-claim    { color: #7c3aed !important; font-weight: 800; font-size: 13px; font-family: "IBM Plex Mono", monospace; }

.badge-pass {
    display: inline-flex; align-items: center; gap: 4px;
    background: #dcfce7; color: #15803d; border: 1px solid #86efac;
    padding: 4px 10px; border-radius: 30px; font-size: 12px; font-weight: 700;
}
.badge-wait {
    display: inline-flex; align-items: center; gap: 4px;
    background: #ffe4e6; color: #e11d48; border: 1px solid #fda4af;
    padding: 4px 10px; border-radius: 30px; font-size: 12px; font-weight: 700;
}
.badge-dept {
    display: inline-block;
    background: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe;
    padding: 3px 8px; border-radius: 8px; font-size: 12px; font-weight: 700;
}
.badge-diag {
    display: inline-block;
    background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe;
    padding: 3px 8px; border-radius: 8px; font-size: 12px; font-weight: 700;
    font-family: "IBM Plex Mono", monospace;
}

/* FLOATING BUTTON */
.floating-send { position: fixed; bottom: 28px; left: 50%; transform: translateX(-50%); z-index: 1000; }
.floating-send button {
    background: linear-gradient(135deg, #7c3aed, #6d28d9) !important;
    border: none !important;
    color: #fff !important;
    font-size: 15px !important;
    font-weight: 800 !important;
    padding: 14px 36px !important;
    border-radius: 40px !important;
    box-shadow: 0 10px 30px rgba(109,40,217,0.35) !important;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: "Noto Sans Thai", sans-serif;
}
.floating-send button:hover {
    background: linear-gradient(135deg, #6d28d9, #4c1d95) !important;
    box-shadow: 0 14px 36px rgba(109,40,217,0.45) !important;
}

input[type="checkbox"] { width: 15px; height: 15px; accent-color: #7c3aed; cursor: pointer; }

/* PROGRESS MODAL */
@keyframes pdot { to { opacity: .3; } }
@keyframes spin  { to { transform: rotate(360deg); } }
.prog-dot-run  { animation: pdot .8s ease infinite alternate; }
.fa-spin-anim  { animation: spin 1s linear infinite; display: inline-block; }
#logConsole::-webkit-scrollbar       { width: 5px; }
#logConsole::-webkit-scrollbar-thumb { background: #c4b5fd; border-radius: 4px; }
CSS
);
?>

<!-- ════════════════════════════════════════════════
     PAGE HEADER
     ════════════════════════════════════════════════ -->
<div class="page-header">
    <div><span class="badge-system">🏥 FDH System</span></div>
    <div>
        <h1>FDH-TELEMED</h1>
        <div class="subtitle">Financial Data Hub · Telemedicine Claims · INSCL 03,04,33,00,23 · แผนก 63,68,70,71,75,81-86</div>
    </div>
</div>

<div class="dash-wrapper">

<!-- CONDITION BAR -->
<div class="condition-bar">
    <i class="fa fa-filter"></i>
    <strong>เงื่อนไข:</strong>
    <span class="condition-tag">สิทธิ์ 03, 04, 33, 00, 23</span>
    <span class="condition-tag">แผนก 63, 68, 70, 71, 75, 81-86</span>
    <span class="condition-tag">OPD เท่านั้น</span>
    <span style="margin-left:auto;color:#0369a1;font-weight:700;font-size:13px;">
        <?= date('d/m/Y', strtotime($date1)) ?> — <?= date('d/m/Y', strtotime($date2)) ?>
    </span>
    <span style="display:inline-flex;align-items:center;gap:12px;font-size:12px;">
        <span style="display:inline-flex;align-items:center;gap:4px;">
            <span style="width:9px;height:9px;border-radius:50%;background:#4ade80;display:inline-block;"></span> ส่งแล้ว
        </span>
        <span style="display:inline-flex;align-items:center;gap:4px;">
            <span style="width:9px;height:9px;border-radius:50%;background:#fb7185;display:inline-block;"></span> รอส่ง
        </span>
    </span>
</div>

<!-- ════════════════════════════════════════════════
     DASHBOARD CARDS
     ════════════════════════════════════════════════ -->
<div class="dash-grid">

    <!-- ทั้งหมด -->
    <div class="dash-card card-all">
        <div class="card-icon"><i class="fa fa-list"></i></div>
        <div class="card-label">ทั้งหมด</div>
        <div class="card-number"><?= number_format($totalMonth ?? 0) ?></div>
        <div class="card-unit">รายการ</div>
        <div class="card-actions">
            <a href="<?= Url::to(['f16telemed/index','date1'=>$date1,'date2'=>$date2,'status'=>'all']) ?>" class="cta-btn">
                <i class="fa fa-table"></i> ทั้งหมด <?= number_format($totalMonth ?? 0) ?>
            </a>
        </div>
    </div>

    <!-- ส่งแล้ว -->
    <div class="dash-card card-done">
        <div class="card-icon"><i class="fa fa-check-circle"></i></div>
        <div class="card-label">ส่งแล้ว</div>
        <div class="card-number"><?= number_format($claimedMonth ?? 0) ?></div>
        <div class="card-unit">รายการ</div>
        <div class="card-actions">
            <a href="<?= Url::to(['f16telemed/index','date1'=>$date1,'date2'=>$date2,'status'=>'success']) ?>" class="cta-btn">
                <i class="fa fa-check-square"></i> ส่งแล้ว <?= number_format($claimedMonth ?? 0) ?>
            </a>
        </div>
    </div>

    <!-- รอส่ง -->
    <div class="dash-card card-remain">
        <div class="card-icon"><i class="fa fa-clock-o"></i></div>
        <div class="card-label">รอส่ง</div>
        <div class="card-number"><?= number_format($remainingMonth ?? 0) ?></div>
        <div class="card-unit">รายการ</div>
        <div class="card-actions">
            <a href="<?= Url::to(['f16telemed/index','date1'=>$date1,'date2'=>$date2,'status'=>'waiting']) ?>" class="cta-btn">
                <i class="fa fa-ban"></i> รอส่ง <?= number_format($remainingMonth ?? 0) ?>
            </a>
        </div>
    </div>

    <!-- ผ่านวันนี้ -->
    <div class="dash-card card-today">
        <div class="card-icon"><i class="fa fa-calendar-check-o"></i></div>
        <div class="card-label">ผ่านวันนี้</div>
        <div class="card-number"><?= $amount ?? 0 ?></div>
        <div class="card-unit">รายการ</div>
        <div class="card-actions">
            <?= Html::a('<i class="fa fa-folder-open"></i> ไฟล์', '#', [
                'class'       => 'cta-btn btn-open-file',
                'data-url'    => Url::to(['f16erext/list-files-partial']),
            ]) ?>
            <button class="cta-btn" id="link1b">
                <i class="fa fa-check"></i> ผ่าน
            </button>
        </div>
    </div>

    <!-- TOKEN -->
    <div class="dash-card card-token">
        <div class="card-icon"><i class="fa fa-key"></i></div>
        <div class="card-label">TOKEN</div>
        <div class="card-number" style="font-size:20px;color:#fcd34d;">tokens</div>
        <div class="card-unit">&nbsp;</div>
        <div class="card-actions">
            <a href="<?= Url::to(['f16telemed/run-curl','date1'=>$date1,'date2'=>$date2]) ?>" class="cta-btn">
                RunToken <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- ลิงก์ -->
    <div class="dash-card card-links">
        <div class="card-icon"><i class="fa fa-link"></i></div>
        <div class="card-label">ลิงก์</div>
        <div style="font-size:12px;display:flex;flex-direction:column;gap:4px;margin-bottom:4px;">
            <a href="https://uat-fdh.inet.co.th/hospital/detail" target="_blank"><i class="fa fa-external-link" style="font-size:9px;"></i> FDH-UAT</a>
            <a href="https://fdh.moph.go.th/hospital/" target="_blank"><i class="fa fa-external-link" style="font-size:9px;"></i> FDH-Prod</a>
        </div>
        <div class="card-actions">
            <a href="<?= Url::to(['fdhtelemed/index']) ?>" class="cta-btn" target="_blank"><i class="fa fa-search"></i> Query</a>
            <?= Html::a('<i class="fa fa-download"></i> Export', ['f16telemed/exports'], ['class' => 'cta-btn']) ?>
        </div>
    </div>

    <!-- ค้นหาวันที่ -->
    <div class="dash-card card-search">
        <div class="card-icon"><i class="fa fa-search"></i></div>
        <div class="card-label" style="margin-bottom:6px;">ค้นหาวันที่</div>
        <?= Html::beginForm(['index'], 'get') ?>
        <input type="hidden" name="status" value="<?= Html::encode($status) ?>">
        <div style="display:flex;flex-direction:column;gap:6px;">
            <?= DatePicker::widget([
                'name'          => 'date1',
                'value'         => $date1,
                'language'      => 'th',
                'clientOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd', 'todayHighlight' => true],
                'options'       => [
                    'class'       => 'form-control',
                    'placeholder' => 'เริ่มต้น',
                ],
            ]) ?>
            <?= DatePicker::widget([
                'name'          => 'date2',
                'value'         => $date2,
                'language'      => 'th',
                'clientOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd', 'todayHighlight' => true],
                'options'       => [
                    'class'       => 'form-control',
                    'placeholder' => 'สิ้นสุด',
                ],
            ]) ?>
            <?= Html::submitButton('<i class="fa fa-search"></i> ค้นหา', [
                'class' => 'cta-btn',
                'style' => 'width:100%;justify-content:center;margin-top:2px;',
            ]) ?>
        </div>
        <?= Html::endForm() ?>
    </div>

</div><!-- /dash-grid -->

<!-- ════════════════════════════════════════════════
     UNIT SUMMARY
     ════════════════════════════════════════════════ -->
<div class="unit-summary-bar">
    <div class="unit-summary-header">
        <i class="fa fa-bar-chart" style="color:#2563eb;"></i>
        สรุปแยกแผนก
        <span class="us-count"><?= count($unitSummary) ?> แผนก · <?= number_format($totalMonth) ?> ราย</span>
        <?php
        $pctTotal = $totalMonth > 0 ? round($claimedMonth / $totalMonth * 100) : 0;
        $pctClass = $pctTotal >= 80 ? 'chip-pct-green' : ($pctTotal >= 50 ? 'chip-pct-orange' : 'chip-pct-red');
        ?>
        <span class="<?= $pctClass ?>" style="padding:2px 8px;border-radius:8px;font-size:12px;font-weight:700;font-family:'IBM Plex Mono',monospace;">
            รวม <?= $pctTotal ?>% ส่งแล้ว
        </span>
        <a href="#" class="unit-toggle" id="unitToggleBtn" onclick="
            var c=document.getElementById('unitChips');
            var shown=c.style.display!='none';
            c.style.display=shown?'none':'flex';
            this.innerHTML=shown?'<i class=\'fa fa-chevron-down\'></i> แสดง':'<i class=\'fa fa-chevron-up\'></i> ย่อ';
            return false;
        "><i class="fa fa-chevron-up"></i> ย่อ</a>
    </div>
    <div class="unit-chips" id="unitChips">
        <?php foreach ($unitSummary as $unitName => $counts):
            $pct    = $counts['total'] > 0 ? round($counts['sent'] / $counts['total'] * 100) : 0;
            $pctCls = $pct >= 80 ? 'chip-pct-green' : ($pct >= 50 ? 'chip-pct-orange' : 'chip-pct-red');
        ?>
        <div class="unit-chip" title="รวม: <?= $counts['total'] ?> | ส่งแล้ว: <?= $counts['sent'] ?> | รอ: <?= $counts['waiting'] ?>">
            <span class="chip-name"><?= Html::encode($unitName) ?></span>
            <span class="chip-total"><?= $counts['total'] ?></span>
            <?php if ($counts['sent'] > 0): ?>
            <span class="chip-sent">✓<?= $counts['sent'] ?></span>
            <?php endif; ?>
            <?php if ($counts['waiting'] > 0): ?>
            <span class="chip-wait">✗<?= $counts['waiting'] ?></span>
            <?php endif; ?>
            <span class="chip-pct <?= $pctCls ?>"><?= $pct ?>%</span>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ════════════════════════════════════════════════
     MAIN DATA TABLE
     ════════════════════════════════════════════════ -->
<?= Html::beginForm(['f16telemed/data'], 'post', ['name' => 'frmMain', 'id' => 'frmMain']) ?>

<div class="table-wrap">
    <div class="scroll-area">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout'       => '{items}',
            'tableOptions' => ['class' => 'data-table'],
            'rowOptions'   => function ($model) {
                return ['class' => !empty($model['messagecode']) ? 'row-pass' : 'row-wait'];
            },
            'columns' => [
                [
                    'class'           => 'yii\grid\CheckboxColumn',
                    'name'            => 'chkDel[]',
                    'checkboxOptions' => function ($model) {
                        return ['value' => $model['visit_id'] . $model['hn']];
                    },
                    'headerOptions'  => ['style' => 'width:36px;text-align:center;'],
                    'contentOptions' => ['style' => 'text-align:center;'],
                ],
                [
                    'attribute'      => 'No',
                    'label'          => '#',
                    'headerOptions'  => ['style' => 'width:50px;text-align:center;'],
                    'contentOptions' => ['class' => 'num-col', 'style' => 'text-align:center;'],
                ],
                [
                    'attribute'      => 'regdate',
                    'label'          => 'วันที่',
                    'contentOptions' => ['class' => 'num-col'],
                ],
                [
                    'attribute'      => 'visit_id',
                    'label'          => 'เลขบริการ',
                    'contentOptions' => ['class' => 'col-visitid'],
                ],
                [
                    'attribute'      => 'hn',
                    'label'          => 'HN',
                    'contentOptions' => ['class' => 'col-hn'],
                ],
                [
                    'attribute'      => 'fullname',
                    'label'          => 'ชื่อ-สกุล',
                    'contentOptions' => ['class' => 'col-name', 'style' => 'min-width:160px;'],
                ],
                [
                    'attribute'      => 'age',
                    'label'          => 'อายุ',
                    'contentOptions' => ['class' => 'col-age'],
                ],
                [
                    'label'          => 'แผนก',
                    'format'         => 'raw',
                    'value'          => function ($model) {
                        return Html::tag('span', Html::encode($model['unit_name']), ['class' => 'badge-dept']);
                    },
                    'contentOptions' => ['style' => 'text-align:center;'],
                ],
                [
                    'attribute'      => 'Diagx',
                    'label'          => 'โรคหลัก',
                    'contentOptions' => ['class' => 'col-diag', 'style' => 'max-width:180px;overflow:hidden;text-overflow:ellipsis;'],
                ],
                [
                    'label'          => 'รหัสโรค',
                    'format'         => 'raw',
                    'value'          => function ($model) {
                        return Html::tag('span', Html::encode($model['Diag']), ['class' => 'badge-diag']);
                    },
                    'contentOptions' => ['style' => 'text-align:center;'],
                ],
                [
                    'attribute'      => 'inscl',
                    'label'          => 'สิทธิ์',
                ],
                [
                    'label'   => 'สถานะ',
                    'format'  => 'raw',
                    'value'   => function ($model) {
                        if (!empty($model['messagecode'])) {
                            return Html::tag('span',
                                '<i class="fa fa-check-circle"></i> ' . Html::encode($model['messagecode']),
                                ['class' => 'badge-pass']
                            );
                        }
                        return Html::tag('span', '<i class="fa fa-times-circle"></i> รอส่ง', ['class' => 'badge-wait']);
                    },
                    'contentOptions' => ['style' => 'text-align:center;'],
                ],
                [
                    'attribute'      => 'hospmain',
                    'label'          => 'สถานหลัก',
                    'contentOptions' => ['class' => 'col-hospmain'],
                ],
                [
                    'label'          => 'เช็คสถานะ',
                    'format'         => 'raw',
                    'contentOptions' => ['style' => 'white-space:nowrap;text-align:center;vertical-align:middle;width:160px;'],
                    'value'          => function ($model) {
                        $visitIdPad = str_pad($model['visit_id'], 10, '0', STR_PAD_LEFT);
                        $hnPad      = str_pad($model['hn'],        6, '0', STR_PAD_LEFT);
                        $safeId     = 'r' . $visitIdPad;
                        return '
                        <button type="button"
                            class="btn-check-status"
                            data-value="'  . $visitIdPad . $hnPad . '"
                            data-hn="'     . $hnPad      . '"
                            data-visit="'  . $visitIdPad . '"
                            style="background:linear-gradient(135deg,#e3f2fd,#bbdefb);color:#1565c0;border:1px solid #90caf9;
                                   border-radius:20px;padding:5px 14px;font-size:12px;font-weight:bold;cursor:pointer;
                                   transition:0.3s;box-shadow:0 2px 5px rgba(0,0,0,0.12);"
                            onmouseover="this.style.transform=\'scale(1.05)\'"
                            onmouseout="this.style.transform=\'scale(1)\'">
                            <i class="fa fa-search"></i> เช็ค
                        </button>
                        <div class="check-result" id="result-' . $safeId . '"
                            style="margin-top:5px;font-size:11px;display:none;max-width:140px;
                                   word-wrap:break-word;padding:4px 6px;border-radius:10px;
                                   background:#f5faff;border:1px solid #d6ecff;color:#1565c0;">
                        </div>';
                    }
                ],
                [
                    'attribute'      => 'claimcode',
                    'label'          => 'Authen',
                    'contentOptions' => ['class' => 'col-claim'],
                ],
            ],
        ]) ?>
    </div>
</div>

<?= Html::endForm() ?>

</div><!-- /dash-wrapper -->

<!-- FLOATING SEND BUTTON -->
<div class="floating-send">
    <button type="submit" form="frmMain">
        <i class="fa fa-arrow-circle-right"></i>
        ส่งข้อมูล TELEMED
    </button>
</div>

<!-- ════════════════════════════════════════════════
     MODAL: เปิดไฟล์
     ════════════════════════════════════════════════ -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:12px;overflow:hidden;">
            <div class="modal-header" style="background:linear-gradient(135deg,#6d28d9,#4c1d95);border:none;padding:14px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:1;">&times;</button>
                <h4 class="modal-title" style="color:#fff;font-size:15px;font-weight:700;">
                    <i class="fa fa-folder-open"></i> รายการไฟล์
                </h4>
            </div>
            <div class="modal-body" style="padding:20px;">
                <div style="text-align:center;padding:30px;color:#9ca3af;">
                    <i class="fa fa-spinner fa-spin fa-2x"></i><br>กำลังโหลด...
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ════════════════════════════════════════════════
     MODAL: PROGRESS SEND
     ════════════════════════════════════════════════ -->
<div class="modal fade" id="progressSendModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="max-width:540px;" role="document">
        <div class="modal-content" style="border-radius:16px;border:none;overflow:hidden;box-shadow:0 16px 56px rgba(0,0,0,0.24);">

            <!-- หัว -->
            <div style="background:linear-gradient(135deg,#6d28d9,#4c1d95);padding:16px 22px;display:flex;align-items:center;gap:12px;">
                <div style="width:36px;height:36px;background:rgba(255,255,255,0.18);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;">
                    <i class="fa fa-paper-plane"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div id="progressTitle" style="font-size:14px;font-weight:700;color:#fff;font-family:'Noto Sans Thai',sans-serif;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        กำลังส่งข้อมูล TELEMED...
                    </div>
                </div>
                <div id="progressCount" style="font-size:12px;color:rgba(255,255,255,0.8);font-family:'IBM Plex Mono',monospace;white-space:nowrap;flex-shrink:0;">
                    0 / 0
                </div>
            </div>

            <!-- Body -->
            <div style="padding:20px 22px;">

                <!-- Progress bar -->
                <div style="margin-bottom:14px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:7px;">
                        <span id="progStatusLabel" style="font-size:12px;color:#6b7280;display:flex;align-items:center;gap:6px;">
                            <span id="progDot" style="width:7px;height:7px;border-radius:50%;background:#7c3aed;display:inline-block;" class="prog-dot-run"></span>
                            กำลังประมวลผล...
                        </span>
                        <span id="progPct" style="font-size:13px;font-weight:700;color:#1e1b4b;font-family:'IBM Plex Mono',monospace;">0%</span>
                    </div>
                    <div style="height:22px;background:#ede9fe;border-radius:20px;overflow:hidden;">
                        <div id="progBar"
                             style="height:100%;width:0%;background:linear-gradient(90deg,#7c3aed,#6d28d9);border-radius:20px;
                                    display:flex;align-items:center;justify-content:center;
                                    font-size:11px;font-weight:700;color:#fff;font-family:'IBM Plex Mono',monospace;
                                    transition:width .4s ease;min-width:2px;">
                        </div>
                    </div>
                </div>

                <!-- Stat boxes -->
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin-bottom:14px;">
                    <div style="background:#f5f3ff;border:1px solid #ddd6fe;border-radius:10px;padding:10px;text-align:center;">
                        <div id="statTotal" style="font-size:22px;font-weight:700;color:#4c1d95;font-family:'IBM Plex Mono',monospace;">0</div>
                        <div style="font-size:11px;color:#7c3aed;margin-top:2px;">ทั้งหมด</div>
                    </div>
                    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:10px;text-align:center;">
                        <div id="statOk" style="font-size:22px;font-weight:700;color:#059669;font-family:'IBM Plex Mono',monospace;">0</div>
                        <div style="font-size:11px;color:#16a34a;margin-top:2px;">สำเร็จ</div>
                    </div>
                    <div style="background:#fff1f2;border:1px solid #fecaca;border-radius:10px;padding:10px;text-align:center;">
                        <div id="statFail" style="font-size:22px;font-weight:700;color:#dc2626;font-family:'IBM Plex Mono',monospace;">0</div>
                        <div style="font-size:11px;color:#ef4444;margin-top:2px;">ล้มเหลว</div>
                    </div>
                </div>

                <!-- Log console -->
                <div style="border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
                    <div style="background:#f9fafb;border-bottom:1px solid #e5e7eb;padding:7px 12px;display:flex;align-items:center;gap:6px;font-size:12px;color:#6b7280;">
                        <i class="fa fa-terminal"></i>
                        บันทึกการส่งข้อมูล
                        <span id="liveTag" style="margin-left:auto;font-size:11px;color:#7c3aed;font-weight:700;">● LIVE</span>
                    </div>
                    <div id="logConsole"
                         style="background:#fff;max-height:220px;min-height:80px;overflow-y:auto;
                                padding:10px 12px;font-family:'IBM Plex Mono',monospace;
                                font-size:12px;font-weight:500;line-height:1.85;color:#374151;">
                        <span style="color:#9ca3af;">[ระบบ] ตรวจสอบสิทธิ์การส่งข้อมูล...</span>
                    </div>
                </div>

            </div><!-- /body -->

            <!-- Footer -->
            <div style="padding:12px 22px;border-top:1px solid #f3f4f6;display:flex;align-items:center;justify-content:space-between;gap:8px;background:#fafafa;">
                <span id="footStatus" style="font-size:12px;color:#6b7280;display:flex;align-items:center;gap:6px;">
                    <i class="fa fa-spinner fa-spin"></i> กำลังดำเนินการ — ห้ามปิดหน้าต่าง
                </span>
                <div style="display:flex;gap:8px;">
                    <button type="button" id="btnCloseProgress"
                            style="display:none;border-radius:8px;font-size:13px;font-weight:600;
                                   padding:7px 18px;border:1px solid #d1d5db;background:#fff;
                                   color:#374151;cursor:pointer;"
                            data-dismiss="modal">
                        <i class="fa fa-times"></i> ปิดหน้าต่าง
                    </button>
                    <button type="button" id="btnReload"
                            style="display:none;border-radius:8px;font-size:13px;font-weight:700;
                                   padding:7px 18px;background:#6d28d9;color:#fff;border:none;cursor:pointer;"
                            onclick="location.reload()">
                        <i class="fa fa-refresh"></i> โหลดหน้าใหม่
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
/* ── JS globals ── */
$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->getCsrfToken();
$checkUrl  = Url::to(['f16telemed/check']);

$this->registerJs("
    var _csrf    = " . json_encode($csrfParam) . ";
    var _csrfVal = " . json_encode($csrfToken) . ";
    var _url     = " . json_encode($checkUrl)  . ";
", \yii\web\View::POS_HEAD);
?>

<?php $this->registerJs(<<<'JS'

console.log('=== FDH-TELEMED Script Loaded ===');

/* ════════════════════════════════════════════════════
   PROGRESS MODAL HELPERS
   ════════════════════════════════════════════════════ */

/**
 * เปิด modal และรีเซ็ตค่าทั้งหมด
 * @param {number} total จำนวนรายการทั้งหมดที่จะส่ง
 */
function logShow(total) {
    // reset bar
    var bar = document.getElementById('progBar');
    bar.style.width      = '0%';
    bar.style.background = 'linear-gradient(90deg,#7c3aed,#6d28d9)';
    bar.textContent      = '';

    // reset text
    document.getElementById('progPct').textContent       = '0%';
    document.getElementById('progressTitle').textContent = 'กำลังเตรียมคิวส่งข้อมูล...';
    document.getElementById('progressCount').textContent = '0 / ' + total;

    // reset stats
    document.getElementById('statTotal').textContent = total;
    document.getElementById('statOk').textContent    = '0';
    document.getElementById('statFail').textContent  = '0';

    // reset status label
    document.getElementById('progDot').style.cssText =
        'width:7px;height:7px;border-radius:50%;background:#7c3aed;display:inline-block;';
    document.getElementById('progDot').className = 'prog-dot-run';
    document.getElementById('progStatusLabel').innerHTML =
        '<span id="progDot" class="prog-dot-run" style="width:7px;height:7px;border-radius:50%;background:#7c3aed;display:inline-block;"></span> กำลังประมวลผล...';

    // reset live tag
    document.getElementById('liveTag').textContent  = '● LIVE';
    document.getElementById('liveTag').style.color  = '#7c3aed';

    // reset footer
    document.getElementById('footStatus').innerHTML =
        '<i class="fa fa-spinner fa-spin"></i> กำลังดำเนินการ — ห้ามปิดหน้าต่าง';
    document.getElementById('btnCloseProgress').style.display = 'none';
    document.getElementById('btnReload').style.display        = 'none';

    // reset console
    document.getElementById('logConsole').innerHTML =
        '<span style="color:#9ca3af;">[ระบบ] เริ่มต้นส่งข้อมูลจำนวน ' + total + ' รายการ...</span>';

    $('#progressSendModal').modal('show');
}

/**
 * เพิ่มบรรทัด log และอัพเดท progress bar + stat
 * @param {number} idx     ลำดับปัจจุบัน (เริ่มที่ 1)
 * @param {number} total   จำนวนทั้งหมด
 * @param {string} hn      HN ผู้ป่วย
 * @param {string} name    ชื่อผู้ป่วย
 * @param {boolean} ok     สำเร็จหรือไม่
 * @param {string} msg     ข้อความเพิ่มเติม
 */
function logLine(idx, total, hn, name, ok, msg) {
    // log text
    var color  = ok ? '#059669' : '#dc2626';
    var prefix = ok ? '✓' : '✗';
    var detail = ok
        ? 'ส่งสำเร็จ'
        : ('ล้มเหลว' + (msg ? ' (' + msg + ')' : ''));
    var line = document.createElement('div');
    line.style.cssText = 'color:' + color + ';padding:1px 0;';
    line.textContent   = prefix + ' [' + idx + '] HN:' + hn + ' ' + name + ' → ' + detail;
    var con = document.getElementById('logConsole');
    con.appendChild(line);
    con.scrollTop = con.scrollHeight;

    // progress bar
    var pct = Math.round(idx / total * 100);
    var bar = document.getElementById('progBar');
    bar.style.width  = pct + '%';
    bar.textContent  = pct + '%';
    document.getElementById('progPct').textContent      = pct + '%';
    document.getElementById('progressCount').textContent = idx + ' / ' + total;
    document.getElementById('progressTitle').textContent = 'กำลังส่งรายการที่ ' + idx + ' / ' + total;

    // stat counters
    if (ok) {
        var el = document.getElementById('statOk');
        el.textContent = parseInt(el.textContent || '0') + 1;
    } else {
        var el = document.getElementById('statFail');
        el.textContent = parseInt(el.textContent || '0') + 1;
    }
}

/**
 * เรียกเมื่อส่งครบทุกรายการ — แสดงปุ่มปิด
 * @param {number} total จำนวนทั้งหมด
 */
function logDone(total) {
    // bar เต็ม + เปลี่ยนสี
    var bar = document.getElementById('progBar');
    bar.style.width      = '100%';
    bar.style.background = '#059669';
    bar.textContent      = '100%';
    document.getElementById('progPct').textContent = '100%';

    // header
    document.getElementById('progressTitle').textContent  = 'ส่งข้อมูลเสร็จสมบูรณ์';
    document.getElementById('progressCount').textContent  = total + ' / ' + total;

    // status dot
    document.getElementById('progStatusLabel').innerHTML =
        '<span style="width:7px;height:7px;border-radius:50%;background:#059669;display:inline-block;"></span> เสร็จสิ้น';

    // live tag
    document.getElementById('liveTag').textContent = '● เสร็จแล้ว';
    document.getElementById('liveTag').style.color = '#059669';

    // footer
    document.getElementById('footStatus').innerHTML =
        '<i class="fa fa-check-circle" style="color:#059669;"></i> ส่งครบแล้ว — สามารถปิดหน้าต่างได้';
    document.getElementById('btnCloseProgress').style.display = '';
    document.getElementById('btnReload').style.display        = '';

    // log summary
    var okVal   = parseInt(document.getElementById('statOk').textContent   || '0');
    var failVal = parseInt(document.getElementById('statFail').textContent  || '0');
    var summary = document.createElement('div');
    summary.style.cssText  = 'color:#6d28d9;font-weight:700;margin-top:6px;padding-top:6px;border-top:1px solid #ede9fe;';
    summary.textContent    = '[ระบบ] เสร็จสิ้น — สำเร็จ ' + okVal + ' รายการ | ล้มเหลว ' + failVal + ' รายการ';
    var con = document.getElementById('logConsole');
    con.appendChild(summary);
    con.scrollTop = con.scrollHeight;
}

/* ════════════════════════════════════════════════════
   FORM SUBMIT → SEQUENTIAL QUEUE SEND
   ════════════════════════════════════════════════════ */
$(document).on('submit', '#frmMain', function (e) {
    e.preventDefault();

    var checkedRows = $('input[name="chkDel[]"]:checked');
    var totalItems  = checkedRows.length;

    if (totalItems === 0) {
        alert('กรุณาเลือกรายการที่ต้องการส่งข้อมูลอย่างน้อย 1 รายการ');
        return false;
    }

    var date1 = $('input[name="date1"]').val();
    var date2 = $('input[name="date2"]').val();

    logShow(totalItems);

    var currentIndex = 0;

    function sendNextItem() {
        if (currentIndex >= totalItems) {
            logDone(totalItems);
            return;
        }

        var currentItem  = $(checkedRows[currentIndex]);
        var value        = currentItem.val();
        var row          = currentItem.closest('tr');
        var hn           = row.find('td:nth-child(5)').text().trim();
        var fullname     = row.find('td:nth-child(6)').text().trim();
        var displayIndex = currentIndex + 1;

        var postData     = { 'chkDel': [value], 'date1': date1, 'date2': date2 };
        postData[_csrf]  = _csrfVal;

        $.ajax({
            url      : $('#frmMain').attr('action'),
            type     : 'POST',
            dataType : 'json',
            data     : postData,
            success  : function (response) {
                var ok  = response && response.status === 'success';
                var msg = (response && response.message) ? response.message : '';
                logLine(displayIndex, totalItems, hn, fullname, ok, msg);
                row.css({
                    background : ok ? 'rgba(52,211,153,0.18)' : 'rgba(248,113,113,0.12)',
                    transition : 'background 0.4s'
                });
            },
            error: function (xhr) {
                logLine(displayIndex, totalItems, hn, fullname, false, 'Server Error ' + xhr.status);
            },
            complete: function () {
                currentIndex++;
                setTimeout(sendNextItem, 300);
            }
        });
    }

    sendNextItem();
});

/* ════════════════════════════════════════════════════
   OPEN FILE MODAL
   ════════════════════════════════════════════════════ */
$(document).on('click', '.btn-open-file', function (e) {
    e.preventDefault();
    var url = $(this).data('url');
    $('#myModal .modal-body').html(
        '<div style="text-align:center;padding:30px;color:#9ca3af;">' +
        '<i class="fa fa-spinner fa-spin fa-2x"></i><br>กำลังโหลด...</div>'
    );
    $('#myModal').modal('show');
    $('#myModal .modal-body').load(url, function (res, status, xhr) {
        if (status === 'error') {
            $(this).html('<div class="alert alert-danger">Error ' + xhr.status + ': ' + xhr.statusText + '</div>');
        }
    });
});

/* ════════════════════════════════════════════════════
   LINK1B → scroll to model1
   ════════════════════════════════════════════════════ */
$('#link1b').on('click', function (e) {
    e.preventDefault();
    var m1 = document.getElementById('model1');
    if (m1) { m1.style.display = 'block'; m1.scrollIntoView({ behavior: 'smooth' }); }
});

/* ════════════════════════════════════════════════════
   CHECK STATUS (ปุ่มสีฟ้าในตาราง)
   ════════════════════════════════════════════════════ */
$(document).on('mouseenter', '.btn-check-status', function () {
    var val = $(this).data('value');
    if (val && String(val).length >= 16) {
        $(this).attr('title',
            'VisitID: ' + String(val).substring(0, 10) +
            '\nHN: '    + String(val).substring(10)
        );
    }
});

$(document).on('click', '.btn-check-status', function () {
    var btn       = $(this);
    var val       = btn.data('value');
    var hn        = btn.data('hn');
    var visitId   = btn.data('visit');
    var resultBox = $('#result-r' + visitId);

    btn.html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);
    resultBox.hide().removeClass('text-success text-danger text-info');

    var postData    = { chkDel: [val] };
    postData[_csrf] = _csrfVal;

    $.ajax({
        url      : _url,
        type     : 'POST',
        data     : postData,
        dataType : 'json',
        success  : function (res) {
            var item = null;
            if (res.results && res.results[visitId]) {
                item = res.results[visitId];
            }
            if (!item && res.results) {
                $.each(res.results, function (k, v) {
                    if (String(v.hn) === String(hn)) { item = v; return false; }
                });
            }
            if (!item) {
                item = { success: false, status: 'error', message: res.message || 'ไม่พบข้อมูล' };
            }

            var msgText      = item.message || '-';
            var status       = String(item.status || '').toLowerCase();
            var approvedList = ['approved', 'paid', 'accepted', 'success'];
            var isApproved   = approvedList.indexOf(status) !== -1;

            if (isApproved) {
                btn.html('<i class="fa fa-check-circle" style="color:#2e7d32"></i> ผ่าน');
                resultBox.removeClass('text-danger text-info').addClass('text-success')
                         .text(msgText).css({'background':'#e8f5e9','border-color':'#c8e6c9','color':'#2e7d32'}).show();
            } else if (item.success) {
                btn.html('<i class="fa fa-paper-plane" style="color:#1565c0"></i> ส่งแล้ว');
                resultBox.removeClass('text-danger text-success').addClass('text-info')
                         .text(msgText).css({'background':'#e3f2fd','border-color':'#90caf9','color':'#1565c0'}).show();
            } else {
                btn.html('<i class="fa fa-times-circle" style="color:#c62828"></i> ไม่ผ่าน');
                resultBox.removeClass('text-success text-info').addClass('text-danger')
                         .text(msgText).css({'background':'#ffebee','border-color':'#ffcdd2','color':'#c62828'}).show();
            }
            btn.prop('disabled', false);
        },
        error: function (xhr) {
            btn.html('<i class="fa fa-times" style="color:#c62828"></i> Error').prop('disabled', false);
            resultBox.removeClass('text-success text-info').addClass('text-danger')
                     .text('AJAX ERROR: ' + xhr.status)
                     .css({'background':'#fafafa','border-color':'#ddd','color':'#555'}).show();
        }
    });
});

/* ════════════════════════════════════════════════════
   AUTO-HIDE ALERTS
   ════════════════════════════════════════════════════ */
setTimeout(function () {
    document.querySelectorAll('.alert').forEach(function (el) {
        el.style.transition = 'opacity 0.5s';
        el.style.opacity    = '0';
        setTimeout(function () { el.style.display = 'none'; }, 500);
    });
}, 15000);

JS
, \yii\web\View::POS_END); ?>