<?php
use yii\helpers\Html;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
use yii\bootstrap\Modal;

\yii\web\JqueryAsset::register($this);
$this->title = 'Rider — 16 แฟ้ม FDH';
?>

<?php $this->registerCss("
/* ===== FONTS ===== */
@import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap');

* { box-sizing: border-box; }
body, .content-wrapper { font-family: 'Sarabun', sans-serif; }

/* ===== HEADER STRIP ===== */
.fdh-header {
    background: #0f172a;
    border-radius: 14px;
    padding: 14px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    border-left: 5px solid #22d3ee;
}
.fdh-header-title {
    color: #f1f5f9;
    font-size: 17px;
    font-weight: 600;
    letter-spacing: 0.3px;
}
.fdh-header-sub {
    color: #94a3b8;
    font-size: 12px;
    margin-top: 2px;
    font-family: 'IBM Plex Mono', monospace;
}
.fdh-legend {
    display: flex;
    gap: 14px;
    align-items: center;
}
.legend-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 5px;
}

/* ===== FILTER BAR ===== */
.fdh-filter-bar {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px 18px;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
    font-size: 13px;
    color: #64748b;
}
.fdh-filter-bar .pill {
    background: #e0f2fe;
    color: #0369a1;
    border-radius: 20px;
    padding: 3px 12px;
    font-weight: 500;
    font-size: 12px;
}

/* ===== DASHBOARD GRID ===== */
.fdh-dash-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(155px, 1fr));
    gap: 14px;
    margin-bottom: 20px;
}

/* ===== BASE CARD ===== */
.fdh-card {
    border-radius: 16px;
    padding: 18px 18px 14px;
    position: relative;
    overflow: hidden;
    transition: transform .18s ease, box-shadow .18s ease;
    cursor: default;
}
.fdh-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(0,0,0,.12);
}
.fdh-card .card-icon-bg {
    position: absolute;
    top: -10px; right: -10px;
    font-size: 64px;
    opacity: .08;
    color: #000;
}
.fdh-card .card-label {
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .6px;
    text-transform: uppercase;
    margin-bottom: 6px;
}
.fdh-card .card-number {
    font-size: 36px;
    font-weight: 700;
    line-height: 1;
    font-family: 'IBM Plex Mono', monospace;
    margin-bottom: 4px;
}
.fdh-card .card-unit {
    font-size: 11px;
    opacity: .75;
    margin-bottom: 14px;
}
.fdh-card .card-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: opacity .15s;
    white-space: nowrap;
}
.fdh-card .card-btn:hover { opacity: .82; text-decoration: none; }

/* card-all — slate */
.card-all {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    color: #f1f5f9;
    border: 1px solid #475569;
}
.card-all .card-btn { background: #38bdf8; color: #0c1a27; }

/* card-done — emerald */
.card-done {
    background: linear-gradient(135deg, #064e3b 0%, #065f46 100%);
    color: #d1fae5;
    border: 1px solid #059669;
}
.card-done .card-btn { background: #34d399; color: #022c22; }

/* card-remain — rose */
.card-remain {
    background: linear-gradient(135deg, #4c0519 0%, #881337 100%);
    color: #ffe4e6;
    border: 1px solid #e11d48;
}
.card-remain .card-btn { background: #fb7185; color: #2d0010; }

/* card-today — indigo */
.card-today {
    background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
    color: #e0e7ff;
    border: 1px solid #6366f1;
}
.card-today .card-btn-wrap { display: flex; gap: 6px; flex-wrap: wrap; }
.card-today .card-btn { background: #818cf8; color: #1e1b4b; }
.card-today .card-btn-alt { background: transparent; border: 1px solid #818cf8; color: #c7d2fe; }

/* card-token — amber */
.card-token {
    background: linear-gradient(135deg, #451a03 0%, #78350f 100%);
    color: #fef3c7;
    border: 1px solid #d97706;
}
.card-token .card-label { color: #fcd34d; }
.card-token .card-number { font-size: 20px; color: #fcd34d; }
.card-token .card-btn { background: #fbbf24; color: #2d1a00; }

/* card-links — teal */
.card-links {
    background: linear-gradient(135deg, #042f2e 0%, #134e4a 100%);
    color: #ccfbf1;
    border: 1px solid #0d9488;
}
.card-links .link-list { display: flex; flex-direction: column; gap: 5px; margin-bottom: 12px; font-size: 12px; }
.card-links .link-list a { color: #5eead4; text-decoration: none; }
.card-links .link-list a:hover { color: #99f6e4; }
.card-links .card-btn { background: #2dd4bf; color: #011c1b; }
.card-links .card-btn-exp { background: transparent; border: 1px solid #2dd4bf; color: #5eead4; }

/* card-search — cool gray */
.card-search {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    color: #e2e8f0;
    border: 1px solid #334155;
    grid-column: span 1;
}
.card-search .search-inputs { display: flex; flex-direction: column; gap: 6px; }
.card-search input.form-control {
    background: rgba(255,255,255,.06) !important;
    border: 1px solid rgba(255,255,255,.15) !important;
    color: #e2e8f0 !important;
    border-radius: 8px !important;
    font-size: 12px !important;
    height: 32px !important;
    padding: 0 10px !important;
}
.card-search .btn-search {
    background: #38bdf8;
    color: #0c1a27;
    border: none;
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    width: 100%;
    margin-top: 4px;
}

/* ===== ACTIVE STATUS BADGE ===== */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 20px;
    padding: 3px 12px;
    font-size: 11px;
    font-weight: 600;
}
.status-badge.active-all    { background: rgba(56,189,248,.2); border-color: #38bdf8; color: #bae6fd; }
.status-badge.active-success{ background: rgba(52,211,153,.2); border-color: #34d399; color: #a7f3d0; }
.status-badge.active-waiting{ background: rgba(251,113,133,.2); border-color: #fb7185; color: #fecdd3; }

/* ===== UNIT SUMMARY ===== */
.unit-summary-wrap {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 8px rgba(0,0,0,.06);
    margin-bottom: 20px;
    overflow: hidden;
}
.unit-summary-header {
    background: #0f172a;
    color: #94a3b8;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .5px;
    padding: 11px 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}
.unit-summary-header .us-badge {
    background: rgba(56,189,248,.15);
    border: 1px solid #38bdf8;
    color: #38bdf8;
    border-radius: 20px;
    padding: 1px 10px;
    font-size: 11px;
    margin-left: 4px;
}
.unit-summary-header .toggle-btn {
    margin-left: auto;
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.15);
    color: #94a3b8;
    border-radius: 6px;
    padding: 3px 10px;
    font-size: 11px;
    cursor: pointer;
    font-family: 'Sarabun', sans-serif;
    transition: background .15s;
}
.unit-summary-header .toggle-btn:hover { background: rgba(255,255,255,.15); color: #e2e8f0; }
.unit-table-scroll {
    max-height: 340px;
    overflow-y: auto;
    overflow-x: auto;
}
.unit-table-scroll::-webkit-scrollbar { width: 5px; height: 5px; }
.unit-table-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
.unit-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.unit-table th {
    background: #f8fafc;
    color: #64748b;
    font-weight: 600;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .4px;
    padding: 9px 14px;
    border-bottom: 2px solid #e2e8f0;
    white-space: nowrap;
    position: sticky;
    top: 0;
    z-index: 1;
}
.unit-table td {
    padding: 7px 14px;
    border-bottom: 1px solid #f1f5f9;
    color: #1e293b;
    vertical-align: middle;
}
.unit-table tbody tr:hover { background: #f0f9ff; }
.unit-table tbody tr:last-child td { border-bottom: none; }
.unit-rank {
    color: #94a3b8;
    font-size: 11px;
    font-family: 'IBM Plex Mono', monospace;
    text-align: center;
    width: 36px;
}
.unit-name-cell { font-weight: 500; max-width: 140px; }
.unit-total {
    font-family: 'IBM Plex Mono', monospace;
    font-weight: 700;
    color: #0f172a;
    text-align: center;
}
.u-badge-sent {
    background: #dcfce7; color: #15803d;
    border-radius: 10px; padding: 2px 9px;
    font-size: 11px; font-weight: 600;
    display: inline-block;
    min-width: 36px;
    text-align: center;
}
.u-badge-wait {
    background: #fee2e2; color: #b91c1c;
    border-radius: 10px; padding: 2px 9px;
    font-size: 11px; font-weight: 600;
    display: inline-block;
    min-width: 36px;
    text-align: center;
}
.unit-bar-col { min-width: 130px; }
.unit-bar-wrap {
    width: 120px;
    background: #e2e8f0;
    border-radius: 4px;
    height: 9px;
    display: flex;
    overflow: hidden;
}
.unit-bar-sent { background: #34d399; height: 100%; transition: width .4s; }
.unit-bar-wait { background: #fb7185; height: 100%; transition: width .4s; }
.unit-pct {
    font-size: 12px;
    font-family: 'IBM Plex Mono', monospace;
    font-weight: 600;
    text-align: center;
    min-width: 42px;
}
.pct-green  { color: #15803d; }
.pct-orange { color: #b45309; }
.pct-red    { color: #b91c1c; }
/* summary footer row */
.unit-table tfoot td {
    background: #f8fafc;
    font-weight: 700;
    font-size: 12px;
    padding: 8px 14px;
    border-top: 2px solid #e2e8f0;
    color: #0f172a;
}

/* ===== TABLE ===== */
.fdh-table-wrap {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 1px 8px rgba(0,0,0,.06);
}
.fdh-table-scroll {
    max-height: 540px;
    overflow-y: auto;
    overflow-x: auto;
}
.fdh-table-scroll::-webkit-scrollbar { width: 6px; height: 6px; }
.fdh-table-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }

.fdh-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
    font-family: 'Sarabun', sans-serif;
}
.fdh-table thead th {
    background: #0f172a;
    color: #94a3b8;
    font-weight: 600;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .5px;
    padding: 10px 10px;
    position: sticky;
    top: 0;
    z-index: 2;
    white-space: nowrap;
    border-right: 1px solid #1e293b;
}
.fdh-table thead th:first-child { border-radius: 0; }
.fdh-table tbody tr {
    transition: background .12s;
    border-bottom: 1px solid #f1f5f9;
}
.fdh-table tbody tr.row-sent { background: #f0fdf4; }
.fdh-table tbody tr.row-wait { background: #fff7f7; }
.fdh-table tbody tr:hover { background: #eff6ff !important; }
.fdh-table td {
    padding: 8px 10px;
    white-space: nowrap;
    color: #1e293b;
    vertical-align: middle;
}
.fdh-table td.hn-dup { color: #dc2626; font-weight: 600; }
.badge-sent {
    background: #dcfce7; color: #15803d;
    border-radius: 12px; padding: 2px 9px;
    font-size: 11px; font-weight: 600;
    white-space: nowrap;
    display: inline-block;
}
.badge-wait {
    background: #fee2e2; color: #b91c1c;
    border-radius: 12px; padding: 2px 9px;
    font-size: 11px; font-weight: 600;
    display: inline-block;
}

/* ===== FLOATING SUBMIT ===== */
.fdh-float-btn {
    position: fixed;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    z-index: 999;
    background: #16a34a;
    color: #fff;
    border: none;
    border-radius: 30px;
    padding: 13px 32px;
    font-size: 15px;
    font-weight: 700;
    font-family: 'Sarabun', sans-serif;
    box-shadow: 0 6px 24px rgba(22,163,74,.4);
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: background .15s, transform .15s;
}
.fdh-float-btn:hover { background: #15803d; transform: translateX(-50%) scale(1.03); }

/* ===== DUP LIST ===== */
.dup-list { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 6px; }
.dup-pill {
    background: #fff7ed;
    border: 1px solid #fed7aa;
    color: #c2410c;
    border-radius: 8px;
    padding: 3px 10px;
    font-size: 12px;
    font-weight: 600;
}

/* ===== SPINNER ===== */
.fdh-spinner-overlay {
    display: none;
    position: fixed; inset: 0;
    background: rgba(15,23,42,.6);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 16px;
}
.fdh-spinner-ring {
    width: 60px; height: 60px;
    border: 5px solid rgba(255,255,255,.2);
    border-top-color: #38bdf8;
    border-radius: 50%;
    animation: spin .9s linear infinite;
}
.fdh-spinner-text { color: #e2e8f0; font-size: 15px; }
@keyframes spin { to { transform: rotate(360deg); } }
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:0} }
.btn-blink { animation: blink 1.2s infinite; }
"); ?>

<!-- SPINNER OVERLAY -->
<div class="fdh-spinner-overlay" id="fdh-spinner">
    <div class="fdh-spinner-ring"></div>
    <div class="fdh-spinner-text">กำลังส่งข้อมูล...</div>
</div>

<!-- HEADER -->
<div class="fdh-header">
    <div>
        <div class="fdh-header-title"><i class="fa fa-database"></i> ผู้ป่วยนอก UCS — 16 แฟ้ม FDH Rider</div>
        <div class="fdh-header-sub">db2 · INSCL 03,04,33,00,23 · OPD เท่านั้น</div>
    </div>
    <div class="fdh-legend">
        <span><span class="legend-dot" style="background:#34d399;"></span><span style="color:#d1fae5;font-size:13px;">ส่งแล้ว</span></span>
        <span><span class="legend-dot" style="background:#fb7185;"></span><span style="color:#fecdd3;font-size:13px;">รอส่ง</span></span>
    </div>
</div>

<!-- FILTER BAR -->
<div class="fdh-filter-bar">
    <i class="fa fa-filter" style="color:#94a3b8;"></i>
    <span>เงื่อนไข:</span>
    <span class="pill">สิทธิ์บัตรทอง สิทธิ์ว่าง มาตรา8 = 03, 04, 33, 00, 23</span>
    <span class="pill">จับจาการลาหัตถการ op.icd9 = '0000016301'</span>
    <span class="pill">OPD เท่านั้น</span>
    <span style="margin-left:auto; color:#0369a1; font-weight:600;">
        <?= date('d/m/Y', strtotime($date1)) ?> — <?= date('d/m/Y', strtotime($date2)) ?>
    </span>
    <?php
    $statusLabel = ['all' => 'ทั้งหมด', 'success' => 'ส่งแล้ว', 'waiting' => 'รอส่ง'];
    $statusClass = ['all' => 'active-all', 'success' => 'active-success', 'waiting' => 'active-waiting'];
    ?>
    <span class="status-badge <?= $statusClass[$statusFilter] ?>">
        <i class="fa fa-circle" style="font-size:8px;"></i>
        กำลังแสดง: <?= $statusLabel[$statusFilter] ?>
    </span>
</div>

<!-- DASHBOARD CARDS -->
<div class="fdh-dash-grid">

    <!-- CARD: ทั้งหมด -->
    <div class="fdh-card card-all">
        <div class="card-icon-bg"><i class="fa fa-list"></i></div>
        <div class="card-label">ทั้งหมด</div>
        <div class="card-number"><?= number_format($totalMonth) ?></div>
        <div class="card-unit">รายการ</div>
        <a href="<?= Url::to(['f16rider/index','date1'=>$date1,'date2'=>$date2,'status'=>'all']) ?>"
           class="card-btn <?= $statusFilter==='all' ? 'btn-blink' : '' ?>">
            <i class="fa fa-table"></i> ทั้งหมด <?= number_format($totalMonth) ?>
        </a>
    </div>

    <!-- CARD: ส่งแล้ว -->
    <div class="fdh-card card-done">
        <div class="card-icon-bg"><i class="fa fa-check-circle"></i></div>
        <div class="card-label">ส่งแล้ว</div>
        <div class="card-number"><?= number_format($claimedMonth) ?></div>
        <div class="card-unit">รายการ</div>
        <a href="<?= Url::to(['f16rider/index','date1'=>$date1,'date2'=>$date2,'status'=>'success']) ?>"
           class="card-btn <?= $statusFilter==='success' ? 'btn-blink' : '' ?>">
            <i class="fa fa-check-square"></i> ส่งแล้ว <?= number_format($claimedMonth) ?>
        </a>
    </div>

    <!-- CARD: รอส่ง -->
    <div class="fdh-card card-remain">
        <div class="card-icon-bg"><i class="fa fa-clock-o"></i></div>
        <div class="card-label">รอส่ง</div>
        <div class="card-number"><?= number_format($remainingMonth) ?></div>
        <div class="card-unit">รายการ</div>
        <a href="<?= Url::to(['f16rider/index','date1'=>$date1,'date2'=>$date2,'status'=>'waiting']) ?>"
           class="card-btn <?= $statusFilter==='waiting' ? 'btn-blink' : '' ?>">
            <i class="fa fa-ban"></i> รอส่ง <?= number_format($remainingMonth) ?>
        </a>
    </div>

    <!-- CARD: ผ่านวันนี้ -->
    <div class="fdh-card card-today">
        <div class="card-icon-bg"><i class="fa fa-calendar-check-o"></i></div>
        <div class="card-label">ผ่านวันนี้</div>
        <div class="card-number"><?= number_format($amount) ?></div>
        <div class="card-unit">รายการ</div>
        <?php
        Modal::begin([
            'id'     => 'myModal',
            'header' => '<h4 style="color:#1a202c;font-family:Sarabun,sans-serif;"><i class="fa fa-folder-open"></i> File List</h4>',
            'size'   => Modal::SIZE_LARGE,
        ]);
        ?>
        <div id="modal-content" style="min-height:100px;">Loading...</div>
        <?php Modal::end(); ?>
        <?php $this->registerJs("
            \$('#myModal').on('show.bs.modal', function(event) {
                var url = \$(event.relatedTarget).data('url');
                \$.ajax({ url: url, success: function(data) { \$('#modal-content').html(data); } });
            });
        "); ?>
        <div class="card-btn-wrap">
            <?= Html::a('<i class="fa fa-folder-open"></i> ไฟล์', '#', [
                'class'       => 'card-btn card-btn-alt',
                'data-toggle' => 'modal',
                'data-target' => '#myModal',
                'data-url'    => Url::to(['f16erext/list-files-partial']),
            ]) ?>
            <button class="card-btn" id="link1b" onclick="$('#model1').toggle();$('#model2').hide();">
                <i class="fa fa-check"></i> ผ่าน
            </button>
        </div>
    </div>

    <!-- CARD: TOKEN -->
    <div class="fdh-card card-token">
        <div class="card-icon-bg"><i class="fa fa-key"></i></div>
        <div class="card-label">TOKEN</div>
        <div class="card-number">tokens</div>
        <div class="card-unit">&nbsp;</div>
        <a href="<?= Url::to(['f16rider/run-curl','date1'=>$date1,'date2'=>$date2]) ?>"
           class="card-btn">
            <i class="fa fa-refresh"></i> RunToken
        </a>
    </div>

    <!-- CARD: ลิงก์ -->
    <div class="fdh-card card-links">
        <div class="card-icon-bg"><i class="fa fa-link"></i></div>
        <div class="card-label" style="font-size:11px;">ลิงก์</div>
        <div class="link-list" style="margin-bottom:8px;">
            <a href="https://uat-fdh.inet.co.th/hospital/detail" target="_blank"><i class="fa fa-external-link" style="font-size:10px;"></i> FDH-UAT</a>
            <a href="https://fdh.moph.go.th/hospital/" target="_blank"><i class="fa fa-external-link" style="font-size:10px;"></i> FDH-Prod</a>
        </div>
        <div class="card-unit">&nbsp;</div>
        <div style="display:flex;gap:6px;flex-wrap:wrap;">
            <a href="<?= Url::to(['fdhreider/index']) ?>" class="card-btn" target="_blank"><i class="fa fa-search"></i> Query</a>
            <?= Html::a('<i class="fa fa-download"></i> Export', ['f16rider/exports'], ['class' => 'card-btn card-btn-exp']) ?>
        </div>
    </div>

    <!-- CARD: ค้นหาวันที่ -->
    <div class="fdh-card card-search">
        <div class="card-icon-bg"><i class="fa fa-search"></i></div>
        <div class="card-label">ค้นหาวันที่</div>
        <?= Html::beginForm(['index'], 'get') ?>
        <input type="hidden" name="status" value="<?= Html::encode($statusFilter) ?>">
        <div class="search-inputs">
            <?= DatePicker::widget([
                'name'          => 'date1',
                'value'         => $date1,
                'language'      => 'th',
                'clientOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd', 'todayHighlight' => true],
                'options'       => ['class' => 'form-control', 'placeholder' => 'เริ่มต้น'],
            ]) ?>
            <?= DatePicker::widget([
                'name'          => 'date2',
                'value'         => $date2,
                'language'      => 'th',
                'clientOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd', 'todayHighlight' => true],
                'options'       => ['class' => 'form-control', 'placeholder' => 'สิ้นสุด'],
            ]) ?>
            <?= Html::submitButton('<i class="fa fa-search"></i> ค้นหา', ['class' => 'btn-search']) ?>
        </div>
        <?= Html::endForm() ?>
    </div>

</div>
<!-- END CARDS -->

<!-- ==========================================
     UNIT SUMMARY — สรุปจำนวนแยกแผนก
     ========================================== -->
<div class="unit-summary-wrap">
    <div class="unit-summary-header">
        <i class="fa fa-bar-chart" style="color:#38bdf8;"></i>
        สรุปจำนวนผู้ป่วยแยกแผนก
        <span class="us-badge"><?= number_format($totalMonth) ?> รายการ</span>
        <span class="us-badge" style="border-color:#818cf8;color:#818cf8;background:rgba(129,140,248,.15);">
            <?= count($unitSummary) ?> แผนก
        </span>
        <button class="toggle-btn" onclick="
            var b = document.getElementById('unit-table-body');
            var shown = b.style.display !== 'none';
            b.style.display = shown ? 'none' : '';
            this.innerHTML = shown
                ? '<i class=\'fa fa-chevron-down\'></i> แสดง'
                : '<i class=\'fa fa-chevron-up\'></i> ย่อ';
        ">
            <i class="fa fa-chevron-up"></i> ย่อ
        </button>
    </div>

    <div id="unit-table-body">
        <div class="unit-table-scroll">
            <table class="unit-table">
                <thead>
                    <tr>
                        <th class="unit-rank">#</th>
                        <th>แผนก</th>
                        <th style="text-align:center;">รวม</th>
                        <th style="text-align:center;">ส่งแล้ว</th>
                        <th style="text-align:center;">รอส่ง</th>
                        <th class="unit-bar-col">สัดส่วน</th>
                        <th style="text-align:center;">%ส่ง</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $rank    = 1;
                $maxTot  = !empty($unitSummary) ? reset($unitSummary)['total'] : 1;
                foreach ($unitSummary as $unitName => $counts):
                    $pctSent = $counts['total'] > 0
                        ? round($counts['sent'] / $counts['total'] * 100) : 0;
                    $barSent = $counts['total'] > 0
                        ? round($counts['sent']    / $maxTot * 100) : 0;
                    $barWait = $counts['total'] > 0
                        ? round($counts['waiting'] / $maxTot * 100) : 0;
                    $pctClass = $pctSent >= 80 ? 'pct-green'
                        : ($pctSent >= 50 ? 'pct-orange' : 'pct-red');
                ?>
                <tr>
                    <td class="unit-rank"><?= $rank++ ?></td>
                    <td class="unit-name-cell"><?= Html::encode($unitName) ?></td>
                    <td class="unit-total"><?= number_format($counts['total']) ?></td>
                    <td style="text-align:center;">
                        <span class="u-badge-sent"><?= number_format($counts['sent']) ?></span>
                    </td>
                    <td style="text-align:center;">
                        <span class="u-badge-wait"><?= number_format($counts['waiting']) ?></span>
                    </td>
                    <td class="unit-bar-col">
                        <div class="unit-bar-wrap">
                            <div class="unit-bar-sent" style="width:<?= $barSent ?>%;"></div>
                            <div class="unit-bar-wait" style="width:<?= $barWait ?>%;"></div>
                        </div>
                    </td>
                    <td class="unit-pct <?= $pctClass ?>"><?= $pctSent ?>%</td>
                </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="text-align:right;color:#64748b;">รวมทั้งหมด</td>
                        <td style="text-align:center;font-family:'IBM Plex Mono',monospace;">
                            <?= number_format($totalMonth) ?>
                        </td>
                        <td style="text-align:center;">
                            <span class="u-badge-sent"><?= number_format($claimedMonth) ?></span>
                        </td>
                        <td style="text-align:center;">
                            <span class="u-badge-wait"><?= number_format($remainingMonth) ?></span>
                        </td>
                        <td></td>
                        <td class="unit-pct <?= $totalMonth > 0 && round($claimedMonth/$totalMonth*100) >= 80 ? 'pct-green' : ($totalMonth > 0 && round($claimedMonth/$totalMonth*100) >= 50 ? 'pct-orange' : 'pct-red') ?>">
                            <?= $totalMonth > 0 ? round($claimedMonth / $totalMonth * 100) : 0 ?>%
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<!-- END UNIT SUMMARY -->

<!-- MAIN TABLE FORM -->
<?= Html::beginForm(['f16rider/data'], 'post', ['name' => 'frmMain', 'id' => 'frmMain']) ?>
<input type="hidden" name="date1" value="<?= Html::encode($date1) ?>">
<input type="hidden" name="date2" value="<?= Html::encode($date2) ?>">

<div class="fdh-table-wrap">
    <div class="fdh-table-scroll">
        <table class="fdh-table">
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll" onclick="toggleAll(this)"></th>
                    <th>#</th>
                    <th>วันที่</th>
                    <th>HN</th>
                    <th>ชื่อ-สกุล</th>
                    <th>อายุ</th>
                    <th>แผนก</th>
                    <th>SBP</th>
                    <th>DBP</th>
                    <th>FBS</th>
                    <th>โรคหลัก</th>
                    <th>กองทุน</th>
                    <th>ค่าเรียกเก็บ</th>
                    <th>ค่าชดเชย</th>
                    <th>สิทธิ์</th>
                    <th>สถานหลัก</th>
                    <th>สถานะ</th>
                    <th>ตรวจสอบ</th>
					<th>Authen</th>
                   
                </tr>
            </thead>
            <tbody>
<?php
$dupHnList = array_column($dupHns, 'hn');
$models    = $dataProvider->getModels();
$rowNo     = count($models);
foreach ($models as $key => $value):
    $rowNo--;
    $displayNo  = $rowNo + 1;
    $isSent     = !empty($value['messagecode']);
    $isDup      = in_array($value['hn'], $dupHnList);
    $rowCls     = $isSent ? 'row-sent' : 'row-wait';
    $visitIdPad = str_pad($value['visit_id'], 10, '0', STR_PAD_LEFT);
    $hnPad      = str_pad($value['hn'],        6, '0', STR_PAD_LEFT);
?>
<tr class="<?= $rowCls ?>" id="row-<?= $visitIdPad ?>">

    <td><input type="checkbox" name="chkDel[]" id="chkDel<?= $key ?>"
               value="<?= $visitIdPad . $hnPad ?>"></td>
    <td style="color:#94a3b8;font-size:12px;font-family:'IBM Plex Mono',monospace;"><?= $displayNo ?></td>
    <td><?= $value['regdate'] ?></td>
    <td class="<?= $isDup ? 'hn-dup' : '' ?>"><?= $value['hn'] ?></td>
    <td><?= $value['fullname'] ?></td>
    <td style="text-align:center;"><?= $value['age'] ?></td>
    <td><?= $value['unit_name'] ?></td>
    <td style="text-align:center;"><?= $value['SBP'] ?></td>
    <td style="text-align:center;"><?= $value['DBP'] ?></td>
    <td style="text-align:center;"><?= $value['FBS'] ?></td>
    <td><?= $value['Diagx'] ?></td>
    <td><?= $value['fund'] ?></td>
    <td><?= $value['amount'] ?></td>
    <td>
        <?php if ((float)$value['ret_statement'] == 0.00): ?>
            <span style="color:#dc2626;font-weight:700;"><?= number_format($value['ret_statement'], 2) ?></span>
        <?php else: ?>
            <span style="color:#16a34a;font-weight:700;"><?= number_format($value['ret_statement'], 2) ?></span>
        <?php endif; ?>
    </td>
    <td><?= $value['inscl'] ?></td>
    <td>
        <?php if ($value['hospmain'] == '10953'): ?>
            <span style="color:#16a34a;font-weight:700;"><?= $value['hospmain'] ?></span>
        <?php else: ?>
            <span style="color:#dc2626;font-weight:700;"><?= $value['hospmain'] ?></span>
        <?php endif; ?>
    </td>

    <td id="td-status-<?= $visitIdPad ?>">
        <?php if ($isSent): ?>
            <span class="badge-sent">
                <i class="fa fa-check"></i> <?= Html::encode($value['messagecode']) ?>
            </span>
        <?php else: ?>
            <span class="badge-wait">
                <i class="fa fa-clock-o"></i> รอส่ง
            </span>
        <?php endif; ?>
    </td>
   
    <td class="text-nowrap" style="font-size:12px;text-align:center;">
        <button type="button"
            class="btn-check-status"
            data-value="<?= $visitIdPad . $hnPad ?>"
            data-hn="<?= (int)$value['hn'] ?>"
            data-visit="<?= $visitIdPad ?>"
            style="background:linear-gradient(135deg,#e3f2fd,#bbdefb);
                   color:#1565c0;border:1px solid #90caf9;border-radius:20px;
                   padding:4px 12px;font-size:11px;font-weight:bold;
                   cursor:pointer;white-space:nowrap;">
            <i class="fa fa-search"></i> เช็ค
        </button>
        <div class="check-result"
             id="result-<?= (int)$value['hn'] ?>"
             style="margin-top:4px;font-size:10px;display:none;
                    max-width:140px;word-wrap:break-word;"></div>
    </td>
	
 <td><?= $value['claimcode'] ?></td>
 
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php
$url     = \yii\helpers\Url::to(['f16rider/check']);
$csrf    = Yii::$app->request->csrfParam;
$csrfVal = Yii::$app->request->getCsrfToken();
$this->registerJs(
    'var _url=' . json_encode($url) . ';' .
    'var _csrf=' . json_encode($csrf) . ';' .
    'var _csrfVal=' . json_encode($csrfVal) . ';',
    \yii\web\View::POS_END
);
?>
<?php $this->registerJs(<<<'JS'
$(document).on('mouseenter', '.btn-check-status', function () {
    var val = $(this).data('value');
    if (val && val.length >= 16) {
        $(this).attr('title',
            'VisitID: ' + val.substring(0, 10) +
            '\nHN: '    + val.substring(10, 16)
        );
    } else {
        $(this).attr('title', 'ข้อมูลไม่ครบถ้วน: ' + val);
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
            var msgText = res.message || '-';
            if (!res.success) {
                btn.html('<i class="fa fa-times-circle" style="color:#c62828"></i> ไม่ผ่าน');
                resultBox.addClass('text-danger').text(msgText).show();
            } else if (res.status === 'approved') {
                btn.html('<i class="fa fa-check-circle" style="color:#2e7d32"></i> ผ่าน');
                resultBox.addClass('text-success').text(msgText).show();
            } else {
                btn.html('<i class="fa fa-paper-plane" style="color:#1565c0"></i> ส่งแล้ว');
                resultBox.addClass('text-info').text(msgText).show();
            }
            btn.prop('disabled', false);
            if (statusCell.length) {
                var icon  = res.status === 'approved' ? 'fa-check-circle'
                          : res.success               ? 'fa-paper-plane'
                          :                            'fa-times-circle';
                var color = res.status === 'approved' ? '#16a34a'
                          : res.success               ? '#2563eb'
                          :                            '#dc2626';
                statusCell.html(
                    '<span style="color:' + color + ';font-weight:600;">' +
                    '<i class="fa ' + icon + '"></i> ' + msgText + '</span>'
                );
            }
            if (row.length) {
                row.css({ background: res.success ? '#e8f5e9' : '#ffebee',
                          transition: 'background 0.4s' });
                setTimeout(function () {
                    row.css('background', res.success ? '#edf2f0' : '#f7edfa');
                }, 2000);
            }
        },
        error: function (xhr) {
            btn.html('<i class="fa fa-times" style="color:#c62828"></i> Error')
               .prop('disabled', false);
            resultBox.addClass('text-danger').text('AJAX ERROR: ' + xhr.status).show();
        }
    });
});
JS
, \yii\web\View::POS_END); ?>


<!-- HN ซ้ำ -->
<?php if (!empty($dupHns)): ?>
<div style="margin-top:12px;">
    <span style="color:#dc2626;font-weight:600;font-size:13px;"><i class="fa fa-exclamation-triangle"></i> HN ซ้ำในช่วงวันที่นี้:</span>
    <div class="dup-list">
        <?php foreach ($dupHns as $dup): ?>
            <span class="dup-pill"><?= $dup['hn'] ?> (<?= $dup['count_hn'] ?> ครั้ง)</span>
        <?php endforeach; ?>
    </div>
</div>
<?php else: ?>
<div style="margin-top:10px;color:#16a34a;font-size:13px;"><i class="fa fa-check-circle"></i> ไม่พบ HN ซ้ำ</div>
<?php endif; ?>

<!-- PASS LOG (hidden) -->
<div id="model1" style="display:none;margin-top:20px;">
    <h5 style="color:#15803d;border-left:4px solid #34d399;padding-left:10px;margin-bottom:10px;">รายการผ่านวันนี้</h5>
    <?= \yii\grid\GridView::widget([
        'dataProvider'    => $passProvider,
        'tableOptions'    => ['class' => 'table table-striped table-hover', 'style' => 'font-size:13px;'],
        'headerRowOptions'=> ['style' => 'background:#f0fdf4;'],
        'columns'         => [
            ['class' => 'yii\grid\SerialColumn'],
            'visit_id', 'pid', 'users', 'messagecode', 'd_update',
        ],
    ]); ?>
</div>

<!-- FLOAT SUBMIT -->
<button type="submit" class="fdh-float-btn" id="fdh-submit-btn">
    <i class="fa fa-arrow-circle-right"></i> ส่งข้อมูล Rider
</button>

<?= Html::endForm() ?>

<?php $this->registerJs("
function toggleAll(master) {
    document.querySelectorAll('input[name=\"chkDel[]\"]').forEach(function(cb) {
        cb.checked = master.checked;
    });
}

document.getElementById('frmMain').addEventListener('submit', function(e) {
    e.preventDefault();
    var checked = document.querySelectorAll('input[name=\"chkDel[]\"]:checked');
    if (checked.length === 0) {
        alert('กรุณาเลือกรายการก่อนส่ง');
        return;
    }
    document.getElementById('fdh-spinner').style.display = 'flex';
    var i = 0;
    function step() {
        if (i < checked.length) {
            var row = checked[i].closest('tr');
            row.style.background = '#fef9c3';
            row.scrollIntoView({ behavior: 'smooth', block: 'center' });
            i++;
            setTimeout(step, 200);
        } else {
            document.getElementById('frmMain').submit();
        }
    }
    step();
});

setTimeout(function() { \$('.alert').slideUp('slow'); }, 15000);
"); ?>