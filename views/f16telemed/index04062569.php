<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use dosamigos\datepicker\DatePicker;

$this->title = 'FDH-TELEMED';
$this->registerCss(<<<'CSS'
@import url("https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;600;700;800&family=IBM+Plex+Mono:wght@400;600&display=swap");

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: "Noto Sans Thai", sans-serif; background: #f5f3ff; color: #1e1b4b; }

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
    font-size: 11px;
    font-weight: 800;
    padding: 5px 14px;
    border-radius: 30px;
    letter-spacing: 1px;
}
.page-header h1 { font-size: 22px; font-weight: 800; color: #fff; }
.page-header .subtitle { font-size: 12px; color: rgba(255,255,255,0.75); font-family: "IBM Plex Mono", monospace; }

/* WRAPPER */
.dash-wrapper { width: 96%; margin: 22px auto; }

/* CONDITION BAR */
.condition-bar {
    background: #fff;
    border: 1px solid #ede9fe;
    border-radius: 16px;
    padding: 12px 18px;
    font-size: 12px;
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
    font-size: 11px;
    font-weight: 700;
}

/* DASH GRID */
.dash-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 12px; /* ลดความกว้างช่องว่างลงเล็กน้อยเพื่อให้ดูแน่นกระชับขึ้น */
    margin-bottom: 18px;
}
@media (max-width: 1400px) { .dash-grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 900px)  { .dash-grid { grid-template-columns: repeat(2, 1fr); } }

/* =============================================
   DASH CARD (โจทย์ใหม่: ม่วงอ่อนๆ Gradient + ลดขนาด)
============================================= */
.dash-card {
    /* พื้นหลังเริ่มต้นเป็นม่วงอ่อนพาสเทลไล่เฉดนุ่มๆ สบายตา */
    background: linear-gradient(135deg, #fbfaff 0%, #f3efff 100%);
    border: 1px solid #e0d7ff;
    border-radius: 16px; /* ปรับลดความมนให้เข้ากับขนาด Card ที่เล็กลง */
    padding: 12px; /* ลด Padding จาก 14px เพื่อเพิ่มพื้นที่ด้านใน */
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    gap: 4px;
    min-height: 125px; /* ลดความสูงขั้นต่ำลงจาก 150px เพื่อให้ Card กระชับ */
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    color: #2e1065; /* สีตัวอักษรม่วงเข้มเพื่อให้ตัดกับพื้นหลังอ่อน อ่านง่าย */
    box-shadow: 0 4px 14px rgba(109, 40, 217, 0.04);
}

.dash-card:hover { 
    transform: translateY(-3px); 
    box-shadow: 0 8px 20px rgba(109, 40, 217, 0.08);
    border-color: #c0b2ff;
    background: linear-gradient(135deg, #f5f0ff 0%, #ede5ff 100%); /* เปลี่ยนเฉดตอนโฮเวอร์ให้เด่นขึ้นนิดหน่อย */
}

/* ปรับเฉด Gradient ของแต่ละ Card ให้เป็นโทนสีพาสเทลอ่อนโยน แยกแยะตามเฉดสีของ Icon และตัวเลข */
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
    width: 32px;  /* ลดขนาด Icon ลง */
    height: 32px; /* ลดขนาด Icon ลง */
    border-radius: 8px;
    display: flex; 
    align-items: center; 
    justify-content: center;
    font-size: 13px;
    margin-bottom: 2px;
}

.card-label  { 
    font-size: 12px; /* ลดขนาดตัวอักษร Label */
    font-weight: 700; 
    color: #4c1d95; /* ปรับโทนให้เข้ากับความเป็นม่วง */
}

.card-number { 
    font-size: 26px; /* ลดขนาดขนาดตัวเลขลงจาก 30px-32px เพื่อความคลีนกะทัดรัด */
    font-weight: 700; 
    font-family: "IBM Plex Mono", monospace; 
    line-height: 1.1;
}

.card-unit   { 
    font-size: 11px; 
    color: #6b21a8; 
    opacity: 0.7;
}

.card-actions { 
    margin-top: auto; 
    display: flex; 
    flex-wrap: wrap; 
    gap: 4px; 
}
/* =============================================
   ปรับปรุงความคมชัด (Contrast) เฉพาะการ์ดที่วงไว้
============================================= */

/* 1. การ์ดลิงก์ (.card-links) */
.card-links { 
    background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%); 
    border-color: #c7d2fe; 
}
.card-links .card-icon   { background: #818cf8; color: #fff; }
.card-links .card-number { color: #4338ca; }

/* ปรับฟอนต์ของลิงก์ภายในเคสนี้ให้เข้มขึ้นชัดเจน */
.card-links a, 
.card-links .cta-link { 
    color: #312e81 !important; /* เปลี่ยนจากฟ้าอ่อนเป็นน้ำเงินครามเข้ม */
    font-weight: 600;
    font-size: 11.5px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.15s ease;
}
.card-links a:hover, 
.card-links .cta-link:hover { 
    color: #4338ca !important; 
    text-decoration: underline !important; /* เพิ่มขีดเส้นใต้ตอน hover ให้รู้ว่าเป็นลิงก์ชัดเจน */
}


/* 2. การ์ดค้นหาจากวันที่ (.card-search) */
.card-search { 
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); 
    border-color: #cbd5e1; /* เพิ่มความเข้มของเส้นขอบการ์ดค้นหา */
}
.card-search .card-icon  { background: #64748b; color: #fff; }
.card-search .card-label { color: #334155; }

/* ปรับแต่งสไตล์ของกล่อง Input วันที่ (Datepicker) ให้เห็นกรอบและตัวหนังสือชัดเจน */
.card-search input[type="text"],
.card-search input[type="date"],
.card-search .form-control {
    background: #ffffff !important;
    border: 1px solid #cbd5e1 !important;
    color: #334155 !important; /* ปรับตัวหนังสือข้างในและ Placeholder ให้เข้มขึ้น */
    font-weight: 600;
    font-family: "IBM Plex Mono", monospace;
    font-size: 11px;
    padding: 4px 8px;
    border-radius: 6px;
    width: 100%;
}
.card-search input::placeholder {
    color: #64748b !important; /* ปรับสีตัวอย่างวันที่ให้เข้มขึ้น ไม่จาง */
    opacity: 1;
}

/* ปรับปุ่มค้นหา (ปุ่มล่างสุดของการ์ดค้นหา) ให้เด่นกว่าเดิม */
.card-search .btn-search,
.card-search .cta-btn-search {
    background: #475569 !important;
    color: #ffffff !important;
    border: none !important;
    font-weight: 700;
    width: 100%;
    justify-content: center;
}
.card-search .btn-search:hover,
.card-search .cta-btn-search:hover {
    background: #334155 !important;
}

/* BUTTON INTERNAL CARD (ย่อขนาดให้รับกับ Card) */
.cta-btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 10px; /* ลดขนาด Padding ของปุ่ม */
    border-radius: 6px;
    font-size: 10.5px; /* ลดขนาดฟอนต์ปุ่ม */
    font-weight: 600;
    border: 1px solid rgba(109, 40, 217, 0.15);
    text-decoration: none;
    background: rgba(255, 255, 255, 0.6); /* โปร่งแสงกลืนไปกับความ Gradient */
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

/* =============================================
   UNIT SUMMARY & TABLE (คงเดิมตามโครงสร้างของคุณ)
============================================= */
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
    font-size: 12px;
    font-weight: 700;
    color: #1e1b4b;
}
.unit-summary-header .us-count {
    background: #f5f3ff;
    border: 1px solid #ddd6fe;
    color: #6d28d9;
    border-radius: 20px;
    padding: 1px 9px;
    font-size: 11px;
    font-weight: 700;
}
.unit-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    align-items: center;
}
.unit-chip {
    display: inline-flex;
    align-items: center;
    gap: 0;
    border-radius: 20px;
    overflow: hidden;
    font-size: 11px;
    font-weight: 700;
    border: 1px solid #ede9fe;
    box-shadow: 0 1px 3px rgba(109,40,217,0.08);
    white-space: nowrap;
}
.chip-name {
    background: #f5f3ff;
    color: #4c1d95;
    padding: 4px 8px;
    font-weight: 600;
}
.chip-total {
    background: #4c1d95;
    color: #f8fafc;
    padding: 4px 7px;
    font-family: "IBM Plex Mono", monospace;
    font-weight: 700;
}
.chip-sent {
    background: #dcfce7;
    color: #15803d;
    padding: 4px 6px;
    font-family: "IBM Plex Mono", monospace;
}
.chip-wait {
    background: #fee2e2;
    color: #b91c1c;
    padding: 4px 6px;
    font-family: "IBM Plex Mono", monospace;
    border-radius: 0 20px 20px 0;
}
.chip-pct {
    padding: 4px 7px;
    font-family: "IBM Plex Mono", monospace;
    font-weight: 800;
    font-size: 10px;
    border-radius: 0 20px 20px 0;
}
.chip-pct-green  { background: #bbf7d0; color: #14532d; }
.chip-pct-orange { background: #fed7aa; color: #92400e; }
.chip-pct-red    { background: #fecaca; color: #7f1d1d; }

/* unit toggle */
.unit-toggle {
    margin-left: auto;
    font-size: 11px;
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

/* TABLE WRAP */
.table-wrap {
    background: #fff;
    border: 1px solid #ede9fe;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 8px 28px rgba(109,40,217,0.08);
}
.scroll-area {
    height: 560px;
    overflow-y: auto;
    overflow-x: auto;
}
.scroll-area::-webkit-scrollbar { width: 7px; height: 7px; }
.scroll-area::-webkit-scrollbar-thumb { background: #c4b5fd; border-radius: 10px; }

/* DATA TABLE */
.data-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.data-table thead th {
    position: sticky;
    top: 0;
    z-index: 50;
    background: linear-gradient(180deg, #f5f3ff 0%, #ede9fe 100%);
    color: #1e1b4b;
    font-weight: 800;
    font-size: 11px;
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
.data-table tbody tr.row-pass td { color: #1f2937 !important; }
.data-table tbody tr.row-wait td { color: #1f2937 !important; }
.data-table tbody tr.row-pass:hover { background: #dcfce7 !important; }
.data-table tbody tr.row-wait:hover { background: #ffe4ec !important; }
.data-table td { padding: 10px 10px; vertical-align: middle; white-space: nowrap; font-size: 13px; color: #1e293b; font-weight: 500; }

/* COLUMN STYLES */
.num-col      { font-family: "IBM Plex Mono", monospace; font-size: 12px; color: #334155 !important; font-weight: 700; }
.col-visitid  { font-family: "IBM Plex Mono", monospace; font-weight: 700; color: #15803d !important; font-size: 12px; }
.col-hn       { font-family: "IBM Plex Mono", monospace; color: #6d28d9 !important; font-size: 12px; font-weight: 700; }
.col-name     { font-weight: 700; color: #111827 !important; }
.col-age      { text-align: center; color: #111827 !important; font-weight: 700; }
.col-diag     { color: #4338ca !important; font-weight: 700; }
.col-hospmain { color: #334155 !important; font-size: 12px; font-family: "IBM Plex Mono", monospace; font-weight: 600; }
.col-claim    { color: #7c3aed !important; font-weight: 800; font-size: 12px; font-family: "IBM Plex Mono", monospace; }
.col-endpoint { color: #6d28d9 !important; font-weight: 700; font-size: 12px; font-family: "IBM Plex Mono", monospace; }

/* BADGES */
.badge-pass {
    display: inline-flex; align-items: center; gap: 4px;
    background: #dcfce7; color: #15803d; border: 1px solid #86efac;
    padding: 4px 10px; border-radius: 30px; font-size: 11px; font-weight: 700;
}
.badge-wait {
    display: inline-flex; align-items: center; gap: 4px;
    background: #ffe4e6; color: #e11d48; border: 1px solid #fda4af;
    padding: 4px 10px; border-radius: 30px; font-size: 11px; font-weight: 700;
}
.badge-dept {
    display: inline-block;
    background: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe;
    padding: 3px 8px; border-radius: 8px; font-size: 11px; font-weight: 700;
}
.badge-diag {
    display: inline-block;
    background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe;
    padding: 3px 8px; border-radius: 8px; font-size: 11px; font-weight: 700;
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

/* LOADING */
#loading-spinner {
    position: fixed; inset: 0;
    background: rgba(245,243,255,0.88);
    display: none;
    align-items: center; justify-content: center;
    z-index: 9999; flex-direction: column; gap: 20px;
}
.spinner-ring {
    width: 64px; height: 64px;
    border: 4px solid rgba(124,58,237,0.15);
    border-top-color: #7c3aed;
    border-radius: 50%;
    animation: spin .8s linear infinite;
}
.spinner-text { color: #4c1d95; font-size: 13px; font-weight: 700; }
@keyframes spin { to { transform: rotate(360deg); } }
input[type="checkbox"] { width: 15px; height: 15px; accent-color: #7c3aed; cursor: pointer; }
CSS
);
?>

<!-- Loading Overlay -->
<div id="loading-spinner">
    <div class="spinner-ring"></div>
    <div class="spinner-text">กำลังส่งข้อมูล...</div>
</div>

<!-- Page Header -->
<div class="page-header">
    <div><span class="badge-system">🏥 FDH System</span></div>
    <div>
        <h1>FDH-TELEMED</h1>
        <div class="subtitle">Financial Data Hub · Telemedicine Claims · INSCL 03,04,33,00,23 · แผนก 63,68,70,71,75,81-86</div>
    </div>
</div>

<div class="dash-wrapper">

<!-- Condition Bar -->
<div class="condition-bar">
    <i class="fa fa-filter"></i>
    <strong>เงื่อนไข:</strong>
    <span class="condition-tag">สิทธิ์ 03, 04, 33, 00, 23</span>
    <span class="condition-tag">แผนก 63, 68, 70, 71, 75, 81-86</span>
    <span class="condition-tag">OPD เท่านั้น</span>
    <span style="margin-left:auto;color:#0369a1;font-weight:700;font-size:12px;">
        <?= date('d/m/Y', strtotime($date1)) ?> — <?= date('d/m/Y', strtotime($date2)) ?>
    </span>
    <span style="display:inline-flex;align-items:center;gap:12px;font-size:11px;">
        <span style="display:inline-flex;align-items:center;gap:4px;">
            <span style="width:9px;height:9px;border-radius:50%;background:#4ade80;display:inline-block;"></span> ส่งแล้ว
        </span>
        <span style="display:inline-flex;align-items:center;gap:4px;">
            <span style="width:9px;height:9px;border-radius:50%;background:#fb7185;display:inline-block;"></span> รอส่ง
        </span>
    </span>
</div>

<!-- Dashboard Cards -->
<div class="dash-grid">

    <!-- CARD: ทั้งหมด -->
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

    <!-- CARD: ส่งแล้ว -->
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

    <!-- CARD: รอส่ง -->
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

    <!-- CARD: ผ่านวันนี้ -->
    <div class="dash-card card-today">
        <div class="card-icon"><i class="fa fa-calendar-check-o"></i></div>
        <div class="card-label">ผ่านวันนี้</div>
        <div class="card-number"><?= $amount ?? 0 ?></div>
        <div class="card-unit">รายการ</div>
        <div class="card-actions">
            <?php
            Modal::begin([
                'id'     => 'myModal',
                'header' => '<h4 style="color:#1a202c;">📁 File List</h4>',
                'size'   => Modal::SIZE_LARGE,
            ]);
            ?>
            <div id="modal-content" style="min-height:100px;display:flex;align-items:center;justify-content:center;">Loading...</div>
            <?php Modal::end(); ?>
            <?php $this->registerJs("
                \$('#myModal').on('show.bs.modal', function(event) {
                    var url = \$(event.relatedTarget).data('url');
                    \$.ajax({ url: url, success: function(data) { \$('#modal-content').html(data); } });
                });
            "); ?>
            <?= Html::a('<i class="fa fa-folder-open"></i> ไฟล์', '#', [
                'class'       => 'cta-btn',
                'data-toggle' => 'modal',
                'data-target' => '#myModal',
                'data-url'    => Url::to(['f16erext/list-files-partial']),
            ]) ?>
            <button class="cta-btn" id="link1b">
                <i class="fa fa-check"></i> ผ่าน
            </button>
        </div>
    </div>

    <!-- CARD: TOKEN -->
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

    <!-- CARD: ลิงก์ -->
    <div class="dash-card card-links">
        <div class="card-icon"><i class="fa fa-link"></i></div>
        <div class="card-label">ลิงก์</div>
        <div style="font-size:11px;display:flex;flex-direction:column;gap:4px;margin-bottom:4px;">
            <a href="https://uat-fdh.inet.co.th/hospital/detail" target="_blank" style="color:#bae6fd;"><i class="fa fa-external-link" style="font-size:9px;"></i> FDH-UAT</a>
            <a href="https://fdh.moph.go.th/hospital/" target="_blank" style="color:#bae6fd;"><i class="fa fa-external-link" style="font-size:9px;"></i> FDH-Prod</a>
        </div>
        <div class="card-actions">
            <a href="<?= Url::to(['fdhtelemed/index']) ?>" class="cta-btn" target="_blank"><i class="fa fa-search"></i> Query</a>
            <?= Html::a('<i class="fa fa-download"></i> Export', ['f16telemed/exports'], ['class' => 'cta-btn']) ?>
        </div>
    </div>

    <!-- CARD: ค้นหาวันที่ -->
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
                    'style'       => 'width:100%;font-size:12px;padding:6px 10px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.15);border-radius:8px;color:#e2e8f0;',
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
                    'style'       => 'width:100%;font-size:12px;padding:6px 10px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.15);border-radius:8px;color:#e2e8f0;',
                ],
            ]) ?>
            <?= Html::submitButton('<i class="fa fa-search"></i> ค้นหา', [
                'class' => 'cta-btn',
                'style' => 'width:100%;justify-content:center;margin-top:2px;background:rgba(255,255,255,0.22);',
            ]) ?>
        </div>
        <?= Html::endForm() ?>
    </div>

</div><!-- /dash-grid -->

<!-- =============================================
     UNIT SUMMARY — Compact Chip Layout
     แสดงทุกแผนกในแถวเดียว ประหยัดพื้นที่
============================================= -->
<div class="unit-summary-bar">
    <div class="unit-summary-header">
        <i class="fa fa-bar-chart" style="color:#2563eb;"></i>
        สรุปแยกแผนก
        <span class="us-count"><?= count($unitSummary) ?> แผนก · <?= number_format($totalMonth) ?> ราย</span>
        <?php
        $pctTotal = $totalMonth > 0 ? round($claimedMonth / $totalMonth * 100) : 0;
        $pctClass = $pctTotal >= 80 ? 'chip-pct-green' : ($pctTotal >= 50 ? 'chip-pct-orange' : 'chip-pct-red');
        ?>
        <span class="<?= $pctClass ?>" style="padding:2px 8px;border-radius:8px;font-size:11px;font-weight:700;font-family:'IBM Plex Mono',monospace;">
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
            $pct      = $counts['total'] > 0 ? round($counts['sent'] / $counts['total'] * 100) : 0;
            $pctCls   = $pct >= 80 ? 'chip-pct-green' : ($pct >= 50 ? 'chip-pct-orange' : 'chip-pct-red');
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
<!-- END UNIT SUMMARY -->

<!-- MAIN DATA TABLE -->
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
					'label' => 'เช็คสถานะ',
					'format' => 'raw',
					'contentOptions' => [
						'style' => 'white-space:nowrap;text-align:center;vertical-align:middle;width:160px;'
					],
					'value' => function ($model) {
						// ✅ ใช้ array syntax ให้ตรงกับ dataProvider
						$visitIdPad = str_pad($model['visit_id'], 10, '0', STR_PAD_LEFT);  // ✅ 10 หลัก
						$hnPad      = str_pad($model['hn'],        6, '0', STR_PAD_LEFT);  // ✅ 6 หลัก
						// รวม val = 16 หลัก
						$safeId     = 'r' . $visitIdPad; // ป้องกัน id ขึ้นต้นด้วยตัวเลข

						return '
						<button type="button"
							class="btn-check-status"
							data-value="'  . $visitIdPad . $hnPad . '"
							data-hn="'     . $hnPad      . '"
							data-visit="'  . $visitIdPad . '"
							style="
								background:linear-gradient(135deg,#e3f2fd,#bbdefb);
								color:#1565c0;border:1px solid #90caf9;
								border-radius:20px;padding:5px 14px;
								font-size:11px;font-weight:bold;cursor:pointer;
								transition:0.3s;box-shadow:0 2px 5px rgba(0,0,0,0.12);
							"
							onmouseover="this.style.transform=\'scale(1.05)\'"
							onmouseout="this.style.transform=\'scale(1)\'">
							<i class="fa fa-search"></i> เช็ค
						</button>
						<div class="check-result"
							id="result-' . $safeId . '"
							style="margin-top:5px;font-size:10px;display:none;max-width:140px;
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

<!-- Floating Send Button -->
<div class="floating-send">
    <button type="submit" form="frmMain">
        <i class="fa fa-arrow-circle-right"></i>
        ส่งข้อมูล TELEMED
    </button>
</div>
<?php $this->registerJs("
    var _csrf    = '" . Yii::$app->request->csrfParam . "';
    var _csrfVal = '" . Yii::$app->request->getCsrfToken() . "';
    var _url     = '" . Url::to(['f16telemed/check']) . "';
", \yii\web\View::POS_HEAD); ?>

<?php $this->registerJs(<<<'JS'

console.log('=== FDH Script Loaded ===');

// ── Tooltip เมื่อ hover ปุ่ม ──────────────────────────────────────
$(document).on('mouseenter', '.btn-check-status', function () {
    var val = $(this).data('value');
    if (val && String(val).length >= 17) {
        $(this).attr('title',
            'VisitID: ' + String(val).substring(0, 8) +
            '\nHN: '    + String(val).substring(8, 17)
        );
    } else {
        $(this).attr('title', 'ข้อมูลไม่ครบถ้วน: ' + val);
    }
});

// ── Click เช็คสถานะ ───────────────────────────────────────────────
$(document).on('click', '.btn-check-status', function () {

    var btn       = $(this);
    var val       = btn.data('value');
    var hn        = btn.data('hn');
    var visitId   = btn.data('visit');
    var resultBox = $('#result-r' + visitId);   // ✅ prefix r + visitId
    var statusCell= $('#td-status-' + visitId);
    var row       = $('#row-'       + visitId);

    console.log('--- Click Debug ---');
    console.log('val     :', val);
    console.log('hn      :', hn);
    console.log('visitId :', visitId);

    btn.html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);
    resultBox.hide().removeClass('text-success text-danger text-info');

    var postData     = { chkDel: [val] };
    postData[_csrf]  = _csrfVal;

    $.ajax({
        url      : _url,
        type     : 'POST',
        data     : postData,
        dataType : 'json',
        success  : function (res) {

            console.log('--- AJAX Response ---');
            console.log('Full res     :', res);
            console.log('res.results  :', res.results);
            console.log('visitId (key):', visitId);

            var item = null;

            // 1) หาจาก key ตรง
            if (res.results && res.results[visitId]) {
                item = res.results[visitId];
                console.log('เจอจาก key ตรง:', item);
            }

            // 2) fallback loop หาจาก hn
            if (!item && res.results) {
                console.log('ไม่เจอ key ตรง → loop หาจาก hn...');
                $.each(res.results, function (k, v) {
                    console.log('key:', k, '| v.hn:', v.hn, '| hn:', hn);
                    if (String(v.hn) === String(hn)) {
                        item = v;
                        console.log('เจอจาก hn match:', item);
                        return false; // break
                    }
                });
            }

            // 3) ไม่เจอเลย
            if (!item) {
                console.warn('ไม่เจอ item → ใช้ fallback error');
                item = {
                    success : false,
                    status  : 'error',
                    message : res.message || 'ไม่พบข้อมูล'
                };
            }

            console.log('Final item :', item);

            var msgText      = item.message || '-';
            var status       = String(item.status || '').toLowerCase();
            var approvedList = ['approved', 'paid', 'accepted', 'success'];
            var isApproved   = approvedList.indexOf(status) !== -1;

            console.log('status     :', status);
            console.log('isApproved :', isApproved);

            // ── อัปเดตปุ่ม + result box ──
            if (isApproved) {
                btn.html('<i class="fa fa-check-circle" style="color:#2e7d32"></i> ผ่าน');
                resultBox.removeClass('text-danger text-info').addClass('text-success').text(msgText).show();
            } else if (item.success) {
                btn.html('<i class="fa fa-paper-plane" style="color:#1565c0"></i> ส่งแล้ว');
                resultBox.removeClass('text-danger text-success').addClass('text-info').text(msgText).show();
            } else {
                btn.html('<i class="fa fa-times-circle" style="color:#c62828"></i> ไม่ผ่าน');
                resultBox.removeClass('text-success text-info').addClass('text-danger').text(msgText).show();
            }

            btn.prop('disabled', false);

            // ── อัปเดต td-status ──
            if (statusCell.length) {
                var icon  = isApproved   ? 'fa-check-circle'
                          : item.success ? 'fa-paper-plane'
                          :               'fa-times-circle';
                var color = isApproved   ? '#16a34a'
                          : item.success ? '#2563eb'
                          :               '#dc2626';
                statusCell.html(
                    '<span style="color:' + color + ';font-weight:600;">' +
                    '<i class="fa ' + icon + '"></i> ' + msgText +
                    '</span>'
                );
            }

            // ── อัปเดตสี row ──
            if (row.length) {
                row.css({ background: item.success ? '#e8f5e9' : '#ffebee', transition: 'background 0.4s' });
                setTimeout(function () {
                    row.css('background', item.success ? '#edf2f0' : '#f7edfa');
                }, 2000);
            }
        },
        error: function (xhr) {
            console.error('AJAX Error:', xhr.status, xhr.responseText);
            btn.html('<i class="fa fa-times" style="color:#c62828"></i> Error').prop('disabled', false);
            resultBox.removeClass('text-success text-info').addClass('text-danger')
                     .text('AJAX ERROR: ' + xhr.status).show();
        }
    });
});

JS
, \yii\web\View::POS_END); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Toggle sub-log
    document.getElementById('link1b') && document.getElementById('link1b').addEventListener('click', function(e) {
        e.preventDefault();
        var m1 = document.getElementById('model1');
        if (m1) { m1.style.display = 'block'; m1.scrollIntoView({ behavior: 'smooth' }); }
    });

    // Submit with highlight
    document.getElementById('frmMain').addEventListener('submit', function(event) {
        var checked = document.querySelectorAll('input[name="chkDel[]"]:checked');
        if (checked.length === 0) {
            alert('กรุณาเลือกรายการที่ต้องการส่ง');
            event.preventDefault();
            return;
        }
        event.preventDefault();
        document.getElementById('loading-spinner').style.display = 'flex';
        var i = 0;
        function highlight() {
            if (i >= checked.length) {
                document.getElementById('frmMain').submit();
                return;
            }
            var row = checked[i].closest('tr');
            row.style.background = 'rgba(16,185,129,0.35)';
            row.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(function() { i++; highlight(); }, 400);
        }
        highlight();
    });

    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(el) { el.style.display = 'none'; });
    }, 15000);
});
</script>