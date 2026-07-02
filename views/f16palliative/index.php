<?php
use yii\helpers\Html;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
use yii\bootstrap\Modal;

$this->title = 'Palliative — 16 แฟ้ม FDH';
?>

<?php $this->registerCss("
@import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600;700&display=swap');
* { box-sizing: border-box; }
body, .content-wrapper { font-family: 'Sarabun', sans-serif; background-color: #f8fafc; }

/* ===== HEADER ===== */
.fdh-header {
    background: linear-gradient(135deg, #1a0533 0%, #3b0764 100%);
    border-radius: 14px; padding: 14px 22px;
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 20px; border-left: 5px solid #a855f7;
}
.fdh-header-title { color: #f3e8ff; font-size: 17px; font-weight: 600; }
.fdh-header-sub   { color: #c4b5d4; font-size: 12px; margin-top: 2px; font-family: 'IBM Plex Mono', monospace; }
.fdh-legend { display: flex; gap: 14px; align-items: center; }
.legend-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 5px; }

/* ===== FILTER BAR ===== */
.fdh-filter-bar {
    background: #faf5ff; border: 1px solid #e9d5ff;
    border-radius: 10px; padding: 10px 18px; margin-bottom: 18px;
    display: flex; align-items: center; gap: 14px; flex-wrap: wrap;
    font-size: 13px; color: #7e22ce;
}
.fdh-filter-bar .pill { background: #f3e8ff; color: #6b21a8; border-radius: 20px; padding: 3px 12px; font-weight: 500; font-size: 12px; }

/* ===== DASHBOARD GRID ===== */
.fdh-dash-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(155px, 1fr)); gap: 14px; margin-bottom: 20px; }

/* ===== BASE CARD (ปรับปรุงใหม่: สะอาด สว่าง ตาไม่ล้า) ===== */
.fdh-card { 
    background: linear-gradient(135deg, #fbfaff 0%, #f3efff 100%);
    border-radius: 16px; 
    padding: 16px 16px 14px; 
    position: relative; 
    overflow: hidden; 
    transition: transform .18s, box-shadow .18s; 
    border: 1px solid #e2d9f3;
    display: flex;
    flex-direction: column;
}
.fdh-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(109, 40, 217, 0.08); }
.fdh-card .card-icon-bg { position: absolute; top: -6px; right: -6px; font-size: 56px; opacity: .04; color: #1e1b4b; }
.fdh-card .card-label { font-size: 12px; font-weight: 700; letter-spacing: .4px; margin-bottom: 6px; color: #475569; }
.fdh-card .card-number { font-size: 32px; font-weight: 700; line-height: 1.1; font-family: 'IBM Plex Mono', monospace; margin-bottom: 4px; }
.fdh-card .card-unit { font-size: 11px; opacity: .7; margin-bottom: 12px; color: #64748b; font-weight: 500; }

/* ดันปุ่ม Action และ Link ต่างๆ ให้ไปเกาะขอบล่างของ Card เท่ากันสวยงาม */
.fdh-card .card-btn-wrap,
.fdh-card .link-list,
.fdh-card .search-inputs { margin-top: auto; }

.fdh-card .card-btn { 
    display: inline-flex; 
    align-items: center; 
    justify-content: center;
    gap: 6px; 
    padding: 5px 12px; 
    border-radius: 8px; 
    font-size: 11.5px; 
    font-weight: 600; 
    text-decoration: none; 
    border: 1px solid transparent; 
    cursor: pointer; 
    transition: all .15s; 
    white-space: nowrap; 
}
.fdh-card .card-btn:hover { opacity: 1; transform: scale(1.02); text-decoration: none; }

/* ===== ไล่เฉดสีพาสเทลแยกประเภทการ์ด (ความชัดเจนสูง) ===== */

/* 1. ทั้งหมด */
.card-all     { background: linear-gradient(135deg, #f5f3ff 0%, #e8e1ff 100%); border-color: #d6cbff; }
.card-all .card-label  { color: #5b21b6; }
.card-all .card-number { color: #6d28d9; }
.card-all .card-btn    { background: #7c3aed; color: #ffffff; }
.card-all .card-btn:hover { background: #6d28d9; }

/* 2. ส่งแล้ว */
.card-done    { background: linear-gradient(135deg, #f0fdf4 0%, #e1fae9 100%); border-color: #bbf7d0; }
.card-done .card-label  { color: #065f46; }
.card-done .card-number { color: #059669; }
.card-done .card-btn    { background: #10b981; color: #ffffff; }
.card-done .card-btn:hover { background: #059669; }

/* 3. รอส่ง */
.card-remain  { background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%); border-color: #fecaca; }
.card-remain .card-label  { color: #9f1239; }
.card-remain .card-number { color: #e11d48; }
.card-remain .card-btn    { background: #f43f5e; color: #ffffff; }
.card-remain .card-btn:hover { background: #e11d48; }

/* 4. ผ่านวันนี้ */
.card-today   { background: linear-gradient(135deg, #eff6ff 0%, #e0f2fe 100%); border-color: #bae6fd; }
.card-today .card-label  { color: #1e40af; }
.card-today .card-number { color: #2563eb; }
.card-today .card-btn-wrap { display: flex; gap: 4px; flex-wrap: wrap; }
.card-today .card-btn    { background: #3b82f6; color: #ffffff; }
.card-today .card-btn:hover { background: #2563eb; }
.card-today .card-btn-alt { background: #ffffff; border: 1px solid #bfdbfe; color: #2563eb; }
.card-today .card-btn-alt:hover { background: #eff6ff; }

/* 5. TOKEN */
.card-token   { background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border-color: #fde68a; }
.card-token .card-label  { color: #92400e; }
.card-token .card-number { font-size: 22px; color: #b45309; font-weight: 700; margin-top: 4px; margin-bottom: 8px;}
.card-token .card-btn    { background: #d97706; color: #ffffff; }
.card-token .card-btn:hover { background: #b45309; }

/* 6. ลิงก์ (เน้นความชัดเจนของตัวหนังสือที่วงไว้เป็นพิเศษ) */
.card-links   { background: linear-gradient(135deg, #f0fdfa 0%, #e6fffa 100%); border-color: #99f6e4; }
.card-links .card-label { color: #115e59; }
.card-links .link-list  { display: flex; flex-direction: column; gap: 4px; margin-bottom: 10px; font-size: 12px; }
.card-links .link-list a { color: #0f766e !important; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; }
.card-links .link-list a:hover { color: #0d9488 !important; text-decoration: underline !important; }
.card-links .card-btn-wrap { display: flex; gap: 4px; flex-wrap: wrap; }
.card-links .card-btn    { background: #0d9488; color: #ffffff; }
.card-links .card-btn:hover { background: #0f766e; }
.card-links .card-btn-exp { background: #ffffff; border: 1px solid #99f6e4; color: #0d9488; }
.card-links .card-btn-exp:hover { background: #f0fdfa; }

/* 7. ค้นหาวันที่ (เพิ่ม Contrast ขอบกล่องอินพุต และสีกรอบที่วงไว้ชัดเจน) */
.card-search  { background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-color: #cbd5e1; }
.card-search .card-label { color: #334155; }
.card-search .search-inputs { display: flex; flex-direction: column; gap: 5px; }
.card-search input.form-control { 
    background: #ffffff !important; 
    border: 1px solid #cbd5e1 !important; 
    color: #1e293b !important; 
    border-radius: 8px !important; 
    font-size: 11.5px !important; 
    font-weight: 600 !important;
    font-family: 'IBM Plex Mono', monospace !important;
    height: 30px !important; 
    padding: 0 8px !important; 
}
.card-search input.form-control::placeholder { color: #94a3b8 !important; }
.card-search .btn-search { background: #7c3aed; color: #ffffff; border: none; border-radius: 8px; padding: 6px 12px; font-size: 12px; font-weight: 700; cursor: pointer; width: 100%; margin-top: 4px; transition: background .15s; }
.card-search .btn-search:hover { background: #6d28d9; }

/* ===== STATUS BADGE ===== */
.status-badge { display: inline-flex; align-items: center; gap: 5px; background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2); border-radius: 20px; padding: 3px 12px; font-size: 11px; font-weight: 600; }
.status-badge.active-all     { background: rgba(168,85,247,.2);  border-color: #a855f7; color: #e9d5ff; }
.status-badge.active-success { background: rgba(52,211,153,.2);  border-color: #34d399; color: #a7f3d0; }
.status-badge.active-waiting { background: rgba(251,113,133,.2); border-color: #fb7185; color: #fecdd3; }

/* ===== TABLE (คงเดิมไม่แก้ตามสั่ง) ===== */
.fdh-table-wrap { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 1px 8px rgba(0,0,0,.06); }
.fdh-table-scroll { max-height: 540px; overflow-y: auto; overflow-x: auto; }
.fdh-table-scroll::-webkit-scrollbar { width: 6px; height: 6px; }
.fdh-table-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
.fdh-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.fdh-table thead th { background: #1a0533; color: #c4b5d4; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: .5px; padding: 10px; position: sticky; top: 0; z-index: 2; white-space: nowrap; border-right: 1px solid #2d0b55; }
.fdh-table tbody tr { transition: background .12s; border-bottom: 1px solid #f1f5f9; }
.fdh-table tbody tr.row-sent { background: #f0fdf4; }
.fdh-table tbody tr.row-wait { background: #faf5ff; }
.fdh-table tbody tr:hover { background: #f5f3ff !important; }
.fdh-table td { padding: 8px 10px; white-space: nowrap; color: #1e293b; vertical-align: middle; }
.badge-sent { background: #dcfce7; color: #15803d; border-radius: 12px; padding: 2px 9px; font-size: 11px; font-weight: 600; display: inline-block; }
.badge-wait { background: #f3e8ff; color: #6b21a8; border-radius: 12px; padding: 2px 9px; font-size: 11px; font-weight: 600; display: inline-block; }
.col-amount { color: #d97706; font-weight: 600; text-align: right; }

/* ===== FLOAT BUTTON ===== */
.fdh-float-btn { position: fixed; bottom: 2rem; left: 50%; transform: translateX(-50%); z-index: 999; background: #7c3aed; color: #fff; border: none; border-radius: 30px; padding: 13px 32px; font-size: 15px; font-weight: 700; font-family: 'Sarabun', sans-serif; box-shadow: 0 6px 24px rgba(124,58,237,.4); cursor: pointer; display: flex; align-items: center; gap: 10px; transition: background .15s, transform .15s; }
.fdh-float-btn:hover { background: #6d28d9; transform: translateX(-50%) scale(1.03); }

/* ===== SPINNER ===== */
.fdh-spinner-overlay { display: none; position: fixed; inset: 0; background: rgba(15,23,42,.6); z-index: 9999; align-items: center; justify-content: center; flex-direction: column; gap: 16px; }
.fdh-spinner-ring { width: 60px; height: 60px; border: 5px solid rgba(255,255,255,.2); border-top-color: #a855f7; border-radius: 50%; animation: spin .9s linear infinite; }
.fdh-spinner-text { color: #e2e8f0; font-size: 15px; }
@keyframes spin { to { transform: rotate(360deg); } }
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:0} }
.btn-blink { animation: blink 1.2s infinite; }
"); ?>

<!-- SPINNER -->
<div class="fdh-spinner-overlay" id="fdh-spinner">
    <div class="fdh-spinner-ring"></div>
    <div class="fdh-spinner-text">กำลังส่งข้อมูล...</div>
</div>

<!-- HEADER -->
<div class="fdh-header">
    <div>
        <div class="fdh-header-title"><i class="fa fa-heart"></i> Palliative Care — 16 แฟ้ม FDH</div>
        <div class="fdh-header-sub">db2 · INSCL 03,04,33 · แผนก 72 · OPD เท่านั้น</div>
    </div>
    <div class="fdh-legend">
        <span><span class="legend-dot" style="background:#34d399;"></span><span style="color:#d1fae5;font-size:13px;">ส่งแล้ว</span></span>
        <span><span class="legend-dot" style="background:#d8b4fe;"></span><span style="color:#e9d5ff;font-size:13px;">รอส่ง</span></span>
    </div>
</div>

<!-- FILTER BAR -->
<div class="fdh-filter-bar">
    <i class="fa fa-filter"></i>
    <span>เงื่อนไข:</span>
    <span class="pill">สิทธิ์ 03, 04, 33</span>
    <span class="pill">แผนก 72 (Palliative)</span>
    <span class="pill">OPD เท่านั้น</span>
    <span style="margin-left:auto; color:#6b21a8; font-weight:600;">
        <?= date('d/m/Y', strtotime($date1)) ?> — <?= date('d/m/Y', strtotime($date2)) ?>
    </span>
    <?php
    $statusLabel = ['all' => 'ทั้งหมด', 'success' => 'ส่งแล้ว', 'waiting' => 'รอส่ง'];
    $statusClass = ['all' => 'active-all', 'success' => 'active-success', 'waiting' => 'active-waiting'];
    ?>
    <span class="status-badge <?= $statusClass[$statusFilter] ?>">
        <i class="fa fa-circle" style="font-size:8px;"></i> กำลังแสดง: <?= $statusLabel[$statusFilter] ?>
    </span>
</div>

<!-- DASHBOARD CARDS -->
<div class="fdh-dash-grid">

    <!-- ทั้งหมด -->
    <div class="fdh-card card-all">
        <div class="card-icon-bg"><i class="fa fa-list"></i></div>
        <div class="card-label">ทั้งหมด</div>
        <div class="card-number"><?= number_format($totalMonth) ?></div>
        <div class="card-unit">รายการ</div>
        <a href="<?= Url::to(['f16palliative/index','date1'=>$date1,'date2'=>$date2,'status'=>'all']) ?>"
           class="card-btn <?= $statusFilter==='all' ? 'btn-blink' : '' ?>">
            <i class="fa fa-table"></i> ทั้งหมด <?= number_format($totalMonth) ?>
        </a>
    </div>

    <!-- ส่งแล้ว -->
    <div class="fdh-card card-done">
        <div class="card-icon-bg"><i class="fa fa-check-circle"></i></div>
        <div class="card-label">ส่งแล้ว</div>
        <div class="card-number"><?= number_format($claimedMonth) ?></div>
        <div class="card-unit">รายการ</div>
        <a href="<?= Url::to(['f16palliative/index','date1'=>$date1,'date2'=>$date2,'status'=>'success']) ?>"
           class="card-btn <?= $statusFilter==='success' ? 'btn-blink' : '' ?>">
            <i class="fa fa-check-square"></i> ส่งแล้ว <?= number_format($claimedMonth) ?>
        </a>
    </div>

    <!-- รอส่ง -->
    <div class="fdh-card card-remain">
        <div class="card-icon-bg"><i class="fa fa-clock-o"></i></div>
        <div class="card-label">รอส่ง</div>
        <div class="card-number"><?= number_format($remainingMonth) ?></div>
        <div class="card-unit">รายการ</div>
        <a href="<?= Url::to(['f16palliative/index','date1'=>$date1,'date2'=>$date2,'status'=>'waiting']) ?>"
           class="card-btn <?= $statusFilter==='waiting' ? 'btn-blink' : '' ?>">
            <i class="fa fa-ban"></i> รอส่ง <?= number_format($remainingMonth) ?>
        </a>
    </div>

    <!-- ผ่านวันนี้ -->
    <div class="fdh-card card-today">
        <div class="card-icon-bg"><i class="fa fa-calendar-check-o"></i></div>
        <div class="card-label">ผ่านวันนี้</div>
        <div class="card-number"><?= number_format($amount) ?></div>
        <div class="card-unit">รายการ</div>
        <?php Modal::begin(['id' => 'myModal', 'header' => '<h4 style="font-family:Sarabun,sans-serif;"><i class="fa fa-folder-open"></i> File List</h4>', 'size' => Modal::SIZE_LARGE]); ?>
        <div id="modal-content" style="min-height:80px;">Loading...</div>
        <?php Modal::end(); ?>
        <?php $this->registerJs("\$('#myModal').on('show.bs.modal',function(e){ var url=\$(e.relatedTarget).data('url'); \$.ajax({url:url,success:function(d){\$('#modal-content').html(d);}}); });"); ?>
        <div class="card-btn-wrap">
            <?= Html::a('<i class="fa fa-folder-open"></i> ไฟล์', '#', ['class' => 'card-btn card-btn-alt', 'data-toggle' => 'modal', 'data-target' => '#myModal', 'data-url' => Url::to(['f16erext/list-files-partial'])]) ?>
            <button class="card-btn" onclick="$('#model1').toggle();$('#model2').hide();">
                <i class="fa fa-check"></i> ผ่าน
            </button>
        </div>
    </div>

    <!-- TOKEN -->
    <div class="fdh-card card-token">
        <div class="card-icon-bg"><i class="fa fa-key"></i></div>
        <div class="card-label">TOKEN</div>
        <div class="card-number">tokens</div>
        <div class="card-unit">&nbsp;</div>
        <a href="<?= Url::to(['f16palliative/run-curl','date1'=>$date1,'date2'=>$date2]) ?>" class="card-btn">
            <i class="fa fa-refresh"></i> RunToken
        </a>
    </div>

    <!-- ลิงก์ -->
    <div class="fdh-card card-links">
        <div class="card-icon-bg"><i class="fa fa-link"></i></div>
        <div class="card-label" style="font-size:11px;">ลิงก์</div>
        <div class="link-list">
            <a href="https://uat-fdh.inet.co.th/hospital/detail" target="_blank"><i class="fa fa-external-link" style="font-size:10px;"></i> FDH-UAT</a>
            <a href="https://fdh.moph.go.th/hospital/" target="_blank"><i class="fa fa-external-link" style="font-size:10px;"></i> FDH-Prod</a>
        </div>
        <div class="card-unit">&nbsp;</div>
        <div style="display:flex;gap:6px;flex-wrap:wrap;">
            <a href="<?= Url::to(['fdhpalliative/index']) ?>" class="card-btn" target="_blank"><i class="fa fa-search"></i> Query</a>
            <?= Html::a('<i class="fa fa-download"></i> Export', ['f16palliative/exports'], ['class' => 'card-btn card-btn-exp']) ?>
        </div>
    </div>

    <!-- ค้นหา -->
    <div class="fdh-card card-search">
        <div class="card-icon-bg"><i class="fa fa-search"></i></div>
        <div class="card-label">ค้นหาวันที่</div>
        <?= Html::beginForm(['index'], 'get') ?>
        <input type="hidden" name="status" value="<?= Html::encode($statusFilter) ?>">
        <div class="search-inputs">
            <?= DatePicker::widget(['name' => 'date1', 'value' => $date1, 'language' => 'th', 'clientOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd', 'todayHighlight' => true], 'options' => ['class' => 'form-control', 'placeholder' => 'เริ่มต้น']]) ?>
            <?= DatePicker::widget(['name' => 'date2', 'value' => $date2, 'language' => 'th', 'clientOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd', 'todayHighlight' => true], 'options' => ['class' => 'form-control', 'placeholder' => 'สิ้นสุด']]) ?>
            <?= Html::submitButton('<i class="fa fa-search"></i> ค้นหา', ['class' => 'btn-search']) ?>
        </div>
        <?= Html::endForm() ?>
    </div>

</div>
<!-- END CARDS -->

<!-- MAIN FORM -->
<?= Html::beginForm(['f16palliative/data'], 'post', ['name' => 'frmMain', 'id' => 'frmMain']) ?>
<?= Html::hiddenInput('date1', $date1) ?>
<?= Html::hiddenInput('date2', $date2) ?>

<button type="submit" class="fdh-float-btn" id="fdh-submit-btn">
    <i class="fa fa-heart"></i> ส่งข้อมูล Palliative
</button>

<div class="fdh-table-wrap">
    <div class="fdh-table-scroll">
        <table class="fdh-table">
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll" onclick="toggleAll(this)"></th>
                    <th>#</th>
                    <th>วันที่</th>
                    <th>เลขบริการ</th>
                    <th>HN</th>
                    <th>ชื่อ-สกุล</th>
                    <th>อายุ</th>
                    <th>แผนก</th>
                    <th>โรคหลัก</th>
                    <th>รหัสโรค</th>
                    <th>สิทธิ์</th>
                    <th>สถานหลัก</th>
                    <th>ค่ารักษา</th>
                    <th>ชดเชย</th>
                    <th>สถานะ</th>
                    <th>authen</th>
                    <th>ตรวจสอบ</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $models = $dataProvider->getModels();
            $rowNo  = count($models);
            foreach ($models as $key => $value):
    $rowNo--;
    $displayNo = $rowNo + 1;
    $isSent    = isset($value['messagecode']) && $value['messagecode'] !== null && trim($value['messagecode']) !== '';
    $rowCls    = $isSent ? 'row-sent' : 'row-wait';

    // ✅ เพิ่ม 2 บรรทัดนี้
    $visitIdPad = str_pad($value['visit_id'], 10, '0', STR_PAD_LEFT);
    $hnPad      = str_pad($value['hn'],       6,  '0', STR_PAD_LEFT);
?>
            
                <tr class="<?= $rowCls ?>">
                    <td><input type="checkbox" name="chkDel[]" id="chkDel<?= $key ?>"
                               value="<?= $value['visit_id'] . $value['hn'] ?>"
                               style="width:16px;height:16px;"></td>
                    <td style="color:#94a3b8;font-size:12px;font-family:'IBM Plex Mono',monospace;"><?= $displayNo ?></td>
                    <td style="font-size:12px;font-family:'IBM Plex Mono',monospace;"><?= $value['regdate'] ?></td>
                    <td style="font-size:12px;font-family:'IBM Plex Mono',monospace;color:#6b21a8;font-weight:600;"><?= $value['visit_id'] ?></td>
                    <td style="font-size:12px;font-family:'IBM Plex Mono',monospace;color:#1d4ed8;font-weight:600;"><?= $value['hn'] ?></td>
                    <td style="font-weight:600;"><?= $value['fullname'] ?></td>
                    <td style="text-align:center;"><?= $value['age'] ?></td>
                    <td><?= $value['unit_name'] ?></td>
                    <td style="color:#4338ca;font-weight:600;"><?= $value['Diagx'] ?></td>
                    <td style="color:#64748b;font-size:12px;"><?= $value['Diag'] ?></td>
                    <td><?= $value['inscl'] ?></td>
                    <td style="font-size:12px;font-family:'IBM Plex Mono',monospace;"><?= $value['hospmain'] ?></td>
                   
                    <td class="col-amount"><?= number_format((float)$value['amount'], 2) ?></td>
					 <td>
					<?php if ((float)$value['ret_statement'] == 0.00): ?>
						<span style="color:#dc2626;font-weight:700;"><?= number_format($value['ret_statement'], 2) ?></span>
					<?php else: ?>
						<span style="color:#16a34a;font-weight:700;"><?= number_format($value['ret_statement'], 2) ?></span>
					<?php endif; ?>
				    </td>
                    <td>
                        <?php if ($isSent): ?>
                            <span class="badge-sent"><i class="fa fa-check"></i> <?= Html::encode($value['messagecode']) ?></span>
                        <?php else: ?>
                            <span class="badge-wait"><i class="fa fa-clock-o"></i> รอส่ง</span>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:12px;color:#64748b;"><?= $value['claimcode'] ?></td>
					<td class="text-nowrap" style="font-size:12px;text-align:center;">
					<button type="button"
						class="btn-check-status"
						data-value="<?= $visitIdPad . $hnPad ?>"
						data-hn="<?= $hnPad ?>"
						data-visit="<?= $visitIdPad ?>"
						style="background:linear-gradient(135deg,#e3f2fd,#bbdefb);
							   color:#1565c0;border:1px solid #90caf9;border-radius:20px;
							   padding:4px 12px;font-size:11px;font-weight:bold;
							   cursor:pointer;white-space:nowrap;">
						<i class="fa fa-search"></i> เช็ค
					</button>
					<div class="check-result"
						 id="result-<?= $hnPad ?>"
						 style="margin-top:4px;font-size:10px;display:none;
								max-width:140px;word-wrap:break-word;"></div>
				</td>
					<!--
                    <td style="text-align:center;padding:4px;">
                        <button type="button"
                                style="background:#6f42c1;color:#fff;border:none;border-radius:6px;
                                       padding:4px 10px;font-size:12px;font-weight:500;cursor:pointer;"
                                onclick="openCheckModal('<?= $value['visit_id'] ?>','<?= $value['hn'] ?>','<?= addslashes($value['fullname']) ?>')"
                                title="ตรวจสอบข้อมูลก่อนส่ง">
                            <i class="fas fa-search" style="font-size:11px;"></i> ตรวจสอบ
                        </button>
                    </td>
					-->
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
$url     = \yii\helpers\Url::to(['f16palliative/check']);
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

// ✅ Debug: ตรวจว่า Script โหลดแล้ว
console.log('=== FDH Script Loaded ===');

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

    // ✅ Debug: ดูค่าที่ปุ่มส่งมา
    console.log('--- Click Debug ---');
    console.log('val     :', val);
    console.log('hn      :', hn);
    console.log('visitId :', visitId);

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

            // ✅ Debug: ดู response จาก PHP ทั้งหมด
            console.log('--- AJAX Response ---');
            console.log('Full res        :', res);
            console.log('res.results     :', res.results);
            console.log('visitId (key)   :', visitId);
            console.log('item by visitId :', res.results ? res.results[visitId] : 'ไม่มี results key');

            // ✅ ดึงผลของ visit_id นี้จาก results
            var item = null;

            if (res.results && res.results[visitId]) {
                item = res.results[visitId];
            } else if (res.results) {
                // ✅ กรณี key ไม่ตรง ลอง loop หาจาก hn
                console.log('ไม่เจอ key ตรงๆ ลอง loop results...');
                $.each(res.results, function(k, v) {
                    console.log('key:', k, '| hn:', v.hn, '| match hn:', hn);
                    if (String(v.hn) === String(hn)) {
                        item = v;
                        console.log('เจอจาก hn match:', item);
                        return false; // break
                    }
                });
            }

            // ✅ Fallback ถ้ายังไม่เจอ
            if (!item) {
                console.warn('ไม่เจอ item เลย ใช้ fallback');
                item = {
                    success : false,
                    status  : 'error',
                    message : res.message || 'ไม่พบข้อมูล'
                };
            }

            console.log('Final item :', item);

            var msgText = item.message || '-';
            var status  = (item.status || '').toLowerCase();

            // ✅ สถานะที่ถือว่าผ่าน
           var approvedList = ['approved', 'paid', 'accepted', 'success', 'waited', 'claimed', 'processed', 'complete', 'completed','cut_off_batch'];
            var isApproved   = approvedList.indexOf(status) !== -1;

            console.log('status     :', status);
            console.log('isApproved :', isApproved);
            console.log('item.success:', item.success);

            // ✅ แสดงผลปุ่ม
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

            // ✅ อัปเดต td-status
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

            // ✅ อัปเดตสี row
            if (row.length) {
                row.css({
                    background : item.success ? '#e8f5e9' : '#ffebee',
                    transition : 'background 0.4s'
                });
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

<?= Html::endForm() ?>

<!-- PASS / ERROR LOG -->
<div id="model1" style="display:none;margin-top:20px;">
    <h5 style="color:#15803d;border-left:4px solid #34d399;padding-left:10px;margin-bottom:10px;">รายการผ่านวันนี้</h5>
    <?= \yii\grid\GridView::widget(['dataProvider' => $passProvider, 'tableOptions' => ['class' => 'table table-striped', 'style' => 'font-size:13px;'], 'headerRowOptions' => ['style' => 'background:#f0fdf4;'], 'columns' => [['class' => 'yii\grid\SerialColumn'], 'visit_id', 'pid', 'users', 'messagecode', 'd_update']]); ?>
</div>
<div id="model2" style="display:none;margin-top:20px;">
    <h5 style="color:#dc2626;border-left:4px solid #fb7185;padding-left:10px;margin-bottom:10px;">รายการไม่ผ่าน</h5>
    <?= \yii\grid\GridView::widget(['dataProvider' => $errorProvider, 'tableOptions' => ['class' => 'table table-striped', 'style' => 'font-size:13px;'], 'headerRowOptions' => ['style' => 'background:#fff7f7;'], 'columns' => [['class' => 'yii\grid\SerialColumn'], 'visit_id', 'pid', 'users', 'messagecode', 'd_update']]); ?>
</div>

<!-- ============================================================
     MODAL CHECK DATA (เหมือนเดิมทุกอย่าง พร้อม ADP invoice)
============================================================ -->
<?php /* CSS + Modal + Script เหมือน View เดิม — ใช้ id modalCheckPalli */ ?>
<style>
#modalCheckPalli .modal-dialog { max-width:75vw; width:75vw; margin:20px auto; }
#modalCheckPalli .modal-content { border-radius:10px; overflow:hidden; border:none; }
#modalCheckPalli .modal-header { background:linear-gradient(135deg,#6f42c1 0%,#4b2a8c 100%); border-bottom:none; padding:14px 18px; }
#pmdBody { max-height:75vh; overflow-y:auto; padding:16px 18px; }
.pchk-sum-row { display:flex; gap:10px; margin-bottom:16px; }
.pchk-sum-card { flex:1; border-radius:10px; padding:14px 16px; display:flex; align-items:center; gap:12px; }
.pcsc-ok { background:#E1F5EE; } .pcsc-empty { background:#FCEBEB; } .pcsc-na { background:#F5F0FF; }
.pcsc-icon { width:36px; height:36px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:17px; font-weight:700; flex-shrink:0; }
.pcsc-ok .pcsc-icon { background:#9FE1CB; color:#085041; } .pcsc-empty .pcsc-icon { background:#F7C1C1; color:#791F1F; } .pcsc-na .pcsc-icon { background:#DDD6FE; color:#4c1d95; }
.pcsc-num { font-size:26px; font-weight:700; line-height:1; }
.pcsc-ok .pcsc-num { color:#0F6E56; } .pcsc-empty .pcsc-num { color:#A32D2D; } .pcsc-na .pcsc-num { color:#6d28d9; }
.pcsc-lbl { font-size:11px; font-weight:500; margin-top:3px; }
.pfile-row { border:1px solid #e4e4e4; border-radius:8px; margin-bottom:6px; overflow:hidden; }
.pfile-header { display:flex; align-items:center; gap:10px; padding:10px 14px; }
.pfile-header.clickable { cursor:pointer; } .pfile-header.clickable:hover { background:rgba(0,0,0,.02); }
.pfh-ok { border-left:4px solid #1D9E75; } .pfh-empty { border-left:4px solid #E24B4A; } .pfh-na { border-left:4px solid #7c3aed; } .pfh-warn { border-left:4px solid #EF9F27; }
.pfile-name { font-size:13px; font-weight:600; min-width:60px; color:#333; }
.pfpill { font-size:11px; font-weight:500; padding:3px 11px; border-radius:20px; }
.pfpill-ok { background:#E1F5EE; color:#0F6E56; } .pfpill-empty { background:#FCEBEB; color:#A32D2D; } .pfpill-na { background:#F5F0FF; color:#6d28d9; } .pfpill-warn { background:#FAEEDA; color:#633806; }
.pfchev { margin-left:auto; font-size:11px; color:#bbb; transition:transform .2s; }
.pfile-row.open .pfchev { transform:rotate(180deg); }
.pfile-body { display:none; border-top:1px solid #eee; }
.pfile-row.open .pfile-body { display:block; }
.pdtbl { width:100%; border-collapse:collapse; font-size:11px; }
.pdtbl th { background:#f5f0fc; padding:5px 10px; text-align:left; border-bottom:1px solid #e5e5e5; color:#6f42c1; font-size:10px; font-weight:600; white-space:nowrap; text-transform:uppercase; }
.pdtbl td { padding:5px 10px; border-bottom:1px solid #f0f0f0; color:#333; white-space:nowrap; }
.pchk-prog-bar { height:5px; background:rgba(255,255,255,.3); border-radius:3px; overflow:hidden; margin-bottom:14px; }
.pchk-prog-fill { height:100%; background:#fff; border-radius:3px; transition:width .25s; width:0%; }
.pchk-alert { border-radius:8px; padding:10px 14px; font-size:13px; font-weight:500; margin-bottom:14px; display:flex; align-items:center; gap:8px; }
.pchk-alert-ok { background:#E1F5EE; color:#0F6E56; border:1px solid #9FE1CB; }
.pchk-alert-error { background:#FCEBEB; color:#A32D2D; border:1px solid #F7C1C1; }
</style>

<div class="modal fade" id="modalCheckPalli" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div style="display:flex;align-items:center;gap:11px;">
                    <div style="width:40px;height:40px;border-radius:10px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-clipboard-check" style="color:#fff;font-size:18px;"></i>
                    </div>
                    <div>
                        <div style="font-size:15px;font-weight:600;color:#fff;">ตรวจสอบข้อมูล Palliative — 7 แฟ้ม</div>
                        <div id="pmdPatientInfo" style="font-size:11px;color:rgba(255,255,255,.8);margin-top:2px;"></div>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" style="font-size:22px;color:#fff;opacity:.8;margin-left:auto;">&times;</button>
            </div>
            <div id="pmdBody">
                <div id="pmdProgress" style="display:none;margin-bottom:6px;">
                    <div class="pchk-prog-bar"><div class="pchk-prog-fill" id="pmdProgFill"></div></div>
                    <div style="font-size:11px;color:#999;text-align:center;margin-top:6px;"><i class="fas fa-spinner fa-spin"></i> กำลังตรวจสอบ...</div>
                </div>
                <div id="pmdAlert" style="display:none;"></div>
                <div id="pmdSummary" style="display:none;margin-bottom:14px;">
                    <div class="pchk-sum-row">
                        <div class="pchk-sum-card pcsc-ok"><div class="pcsc-icon">&#10004;</div><div><div class="pcsc-num" id="pmdOkCount">0</div><div class="pcsc-lbl">มีข้อมูล</div></div></div>
                        <div class="pchk-sum-card pcsc-empty"><div class="pcsc-icon">&#10008;</div><div><div class="pcsc-num" id="pmdEmptyCount">0</div><div class="pcsc-lbl">ไม่มีข้อมูล</div></div></div>
                        <div class="pchk-sum-card pcsc-na"><div class="pcsc-icon">&mdash;</div><div><div class="pcsc-num" id="pmdNaCount">0</div><div class="pcsc-lbl">ไม่บังคับ</div></div></div>
                    </div>
                </div>
                <div id="pmdGrid"></div>
            </div>
            <div class="modal-footer">
                <small style="font-size:11px;color:#999;"><span style="color:#E24B4A;font-weight:700;">*</span> = แฟ้มบังคับ</small>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="border-radius:7px;padding:6px 18px;"><i class="fas fa-times"></i> ปิด</button>
            </div>
        </div>
    </div>
</div>

<script>
var palliCheckUrl = '<?= Url::to(['check-data']) ?>';

function openCheckModal(visit, hn, name) {
    $('#pmdPatientInfo').html('<b>HN:</b> '+hn+'&nbsp;|&nbsp;<b>Visit:</b> '+visit+'&nbsp;|&nbsp;'+name);
    $('#pmdGrid').html(''); $('#pmdAlert').hide().html(''); $('#pmdSummary').hide();
    $('#pmdProgress').show(); $('#pmdProgFill').css('width','0%');
    $('#modalCheckPalli').modal('show');
    var pct=0, pTimer=setInterval(function(){ pct+=7; if(pct>88){clearInterval(pTimer);pct=88;} $('#pmdProgFill').css('width',pct+'%'); },70);
    $.getJSON(palliCheckUrl,{visit:visit,hn:hn}).done(function(res){ clearInterval(pTimer); $('#pmdProgFill').css('width','100%'); setTimeout(function(){$('#pmdProgress').hide();},300); renderPalliFiles(res); }).fail(function(x){ clearInterval(pTimer); $('#pmdProgress').hide(); $('#pmdGrid').html('<div style="background:#FCEBEB;border-radius:8px;padding:12px;color:#791F1F;">HTTP Error '+x.status+'</div>'); });
}

function renderPalliFiles(res) {
    if(!res.success){ $('#pmdGrid').html('<div style="background:#FCEBEB;border-radius:8px;padding:12px;color:#791F1F;">'+res.message+'</div>'); return; }
    var ok=0,empty=0,na=0,html='';
    $.each(res.data,function(_,item){
        var hCls,pCls,icon,label;
        if(item.status==='ok'){hCls='pfh-ok';pCls='pfpill-ok';icon='&#10004;';label='มี '+item.count+' record';ok++;}
        else if(item.status==='empty'){hCls='pfh-empty';pCls='pfpill-empty';icon='&#10008;';label='ไม่มีข้อมูล!';empty++;}
        else if(item.status==='error'){hCls='pfh-warn';pCls='pfpill-warn';icon='&#9888;';label='Query Error';empty++;}
        else if(item.status==='no_config'){hCls='pfh-warn';pCls='pfpill-warn';icon='&#9881;';label='ไม่มี config';empty++;}
        else{hCls='pfh-na';pCls='pfpill-na';icon='&mdash;';label='ไม่บังคับ';na++;}
        var tblHtml = item.table==='ADP' ? buildAdpTable(item.rows, item.rows_invoice||[]) : buildDataTable(item.rows);
        var hasData=(tblHtml!=='');
        html+='<div class="pfile-row'+(item.status==='empty'?' open':'')+'"><div class="pfile-header '+hCls+(hasData?' clickable':'')+(hasData?' onclick="togglePRow(this)"':'')+'">'+'<span class="pfile-name">'+item.table+' <span style="color:#E24B4A;">*</span></span><span class="pfpill '+pCls+'">'+icon+'&nbsp;'+label+'</span>'+(hasData?'<span class="pfchev">&#9660;</span>':'')+'</div>'+(hasData?'<div class="pfile-body"><div style="overflow-x:auto;">'+tblHtml+'</div></div>':'')+'</div>';
    });
    $('#pmdGrid').html(html); $('#pmdOkCount').text(ok); $('#pmdEmptyCount').text(empty); $('#pmdNaCount').text(na); $('#pmdSummary').fadeIn(200);
    if(res.hasError){ $('#pmdAlert').html('<i class="fas fa-times-circle"></i>&nbsp;ข้อมูลไม่ครบ — กรุณาตรวจสอบแฟ้มสีแดง').removeClass('pchk-alert-ok').addClass('pchk-alert pchk-alert-error').show(); }
    else { $('#pmdAlert').html('<i class="fas fa-check-circle"></i>&nbsp;ข้อมูลครบถ้วน — พร้อมส่งข้อมูล').removeClass('pchk-alert-error').addClass('pchk-alert pchk-alert-ok').show(); }
}

function buildAdpTable(rows, invoiceRows) {
    var invoiceHtml='', grandTotalInv=0;
    if(invoiceRows && invoiceRows.length>0){
        invoiceHtml+='<table class="pdtbl"><thead><tr><th style="width:52%">รายการ</th><th style="text-align:center;width:8%">จำนวน</th><th style="text-align:right;width:12%">ราคา/หน่วย</th><th style="text-align:right;width:14%">เบิกได้</th><th style="text-align:right;width:14%">สุทธิ</th></tr></thead><tbody>';
        invoiceRows.forEach(function(r){
            var item=r['item']||'', invoice=r['invoice']||'', amount=parseFloat(r['amount']||0), subtotal=parseFloat(r['subtotal']||0);
            var isHeader=(subtotal===0&&(invoice===''||parseInt(invoice)===0));
            grandTotalInv+=subtotal;
            if(isHeader){ invoiceHtml+='<tr><td colspan="5" style="background:#f5f0fc;color:#6f42c1;font-weight:600;padding:7px 12px;">'+item+'</td></tr>'; }
            else { var qty=parseInt(invoice)||'', unitPrice=(qty>0&&subtotal>0)?(subtotal/qty):amount; invoiceHtml+='<tr><td style="padding-left:24px;">'+item+'</td><td style="text-align:center;">'+qty+'</td><td style="text-align:right;">'+(unitPrice>0?Number(unitPrice.toFixed(2)).toLocaleString():'')+'</td><td style="text-align:right;">'+(subtotal>0?Number(subtotal).toLocaleString():'')+'</td><td style="text-align:right;font-weight:500;color:#0F6E56;">'+(subtotal>0?Number(subtotal).toLocaleString():'')+'</td></tr>'; }
        });
        invoiceHtml+='<tr style="background:#ede7f6;"><td colspan="3" style="text-align:right;font-weight:600;padding:7px 12px;color:#6f42c1;">รวม</td><td style="text-align:right;font-weight:700;color:#6f42c1;">'+Number(grandTotalInv).toLocaleString()+'</td><td style="text-align:right;font-weight:700;color:#6f42c1;">'+Number(grandTotalInv).toLocaleString()+'</td></tr></tbody></table>';
    }
    var adpHtml='', grandTotalAdp=0;
    if(rows && rows.length>0){
        adpHtml+='<div style="margin-top:14px;padding-top:10px;border-top:1px dashed #d4b8f0;"><div style="font-size:11px;font-weight:600;color:#888;margin-bottom:6px;">ข้อมูล ADP (fdh_palliative)</div><table class="pdtbl"><thead><tr><th>CODE</th><th style="text-align:center;">QTY</th><th style="text-align:right;">RATE</th><th style="text-align:right;">TOTCOPAY</th><th>DATEOPD</th></tr></thead><tbody>';
        rows.forEach(function(r){ var code=r['CODE']||'-',qty=r['QTY']||1,rate=r['RATE']||0,total=r['TOTCOPAY']||r['TOTAL']||(qty*rate),dt=r['DATEOPD']||''; grandTotalAdp+=parseFloat(total)||0; adpHtml+='<tr><td style="padding-left:12px;font-family:monospace;font-size:11px;">'+code+'</td><td style="text-align:center;">'+qty+'</td><td style="text-align:right;">'+Number(rate).toLocaleString()+'</td><td style="text-align:right;color:#0F6E56;font-weight:500;">'+Number(total).toLocaleString()+'</td><td style="color:#888;font-size:10px;">'+dt+'</td></tr>'; });
        adpHtml+='</tbody></table></div>';
    }
    var compareHtml='';
    if(rows && rows.length>0 && invoiceRows && invoiceRows.length>0){ var match=(Math.round(grandTotalAdp)===Math.round(grandTotalInv)); compareHtml='<div style="margin-top:10px;padding:9px 14px;border-radius:8px;font-size:12px;font-weight:500;background:'+(match?'#E1F5EE':'#FCEBEB')+';border:1px solid '+(match?'#9FE1CB':'#F7C1C1')+';color:'+(match?'#0F6E56':'#A32D2D')+';">ยอด invoice: <b>'+Number(grandTotalInv).toLocaleString()+'</b>&nbsp;|&nbsp;ยอด ADP: <b>'+Number(grandTotalAdp).toLocaleString()+'</b>'+(match?'&nbsp;— ตรงกัน &#10004;':'&nbsp;— ไม่ตรงกัน')+'</div>'; }
    if(!invoiceHtml && !adpHtml) return '';
    return '<div style="padding:12px;">'+invoiceHtml+adpHtml+compareHtml+'</div>';
}

function buildDataTable(rows) {
    if(!rows||rows.length===0) return '';
    var cols=Object.keys(rows[0]),h='<table class="pdtbl"><thead><tr>'; cols.forEach(function(c){h+='<th>'+c+'</th>'}); h+='</tr></thead><tbody>';
    rows.forEach(function(row){ h+='<tr>'; cols.forEach(function(c){ var v=(row[c]!==null&&row[c]!==undefined)?row[c]:'<span style="color:#ccc;font-style:italic;">null</span>'; h+='<td>'+v+'</td>'; }); h+='</tr>'; });
    return h+'</tbody></table>';
}

function togglePRow(hdr) { var row=hdr.closest('.pfile-row'); if(row) row.classList.toggle('open'); }
function toggleAll(master) { document.querySelectorAll('input[name="chkDel[]"]').forEach(function(cb){ cb.checked=master.checked; }); }

document.getElementById('frmMain').addEventListener('submit', function(e) {
    e.preventDefault();
    var checked = document.querySelectorAll('input[name="chkDel[]"]:checked');
    if (checked.length === 0) { alert('กรุณาเลือกรายการก่อนส่ง'); return; }
    document.getElementById('fdh-spinner').style.display = 'flex';
    var i = 0;
    function step() {
        if (i < checked.length) { var row=checked[i].closest('tr'); row.style.background='#f3e8ff'; row.scrollIntoView({behavior:'smooth',block:'center'}); i++; setTimeout(step, 200); }
        else { document.getElementById('frmMain').submit(); }
    }
    step();
});

setTimeout(function(){ $('.alert').slideUp('slow'); }, 15000);
<?php $this->registerJs("\$('#link1').click(function(){ \$('#model1').show(); \$('#model2').hide(); }); \$('#link2').click(function(){ \$('#model1').hide(); \$('#model2').show(); });"); ?>
</script>