<?php
use yii\helpers\Html;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
use yii\bootstrap\Modal;

$this->title = 'FDH-HERB-NEW สมุนไพรไทย';
?>

<?php $this->registerCss("
@import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap');
* { box-sizing: border-box; }
body, .content-wrapper { font-family: 'Sarabun', sans-serif; }

/* ===== HEADER ===== */
.fdh-header {
    background: linear-gradient(135deg, #1a0533 0%, #2d0b55 100%);
    border-radius: 14px; padding: 14px 22px;
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 20px; border-left: 5px solid #c084fc;
}
.fdh-header-title { color: #f1f5f9; font-size: 17px; font-weight: 600; }
.fdh-header-sub   { color: #c4b5d4; font-size: 12px; margin-top: 2px; font-family: 'IBM Plex Mono', monospace; }
.fdh-legend { display: flex; gap: 14px; align-items: center; }
.legend-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 5px; }

/* ===== FILTER BAR ===== */
.fdh-filter-bar {
    background: #fdf4ff; border: 1px solid #e9d5ff;
    border-radius: 10px; padding: 10px 18px; margin-bottom: 18px;
    display: flex; align-items: center; gap: 14px; flex-wrap: wrap;
    font-size: 13px; color: #7e22ce;
}
.fdh-filter-bar .pill { background: #f3e8ff; color: #6b21a8; border-radius: 20px; padding: 3px 12px; font-weight: 500; font-size: 12px; }

/* ===== DASHBOARD GRID ===== */
.fdh-dash-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(155px, 1fr)); gap: 14px; margin-bottom: 20px; }

/* ===== BASE CARD ===== */
.fdh-card { border-radius: 16px; padding: 18px 18px 14px; position: relative; overflow: hidden; transition: transform .18s, box-shadow .18s; cursor: default; }
.fdh-card:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,.13); }
.fdh-card .card-icon-bg { position: absolute; top: -10px; right: -10px; font-size: 64px; opacity: .08; color: #000; }
.fdh-card .card-label { font-size: 12px; font-weight: 600; letter-spacing: .6px; text-transform: uppercase; margin-bottom: 6px; }
.fdh-card .card-number { font-size: 36px; font-weight: 700; line-height: 1; font-family: 'IBM Plex Mono', monospace; margin-bottom: 4px; }
.fdh-card .card-unit { font-size: 11px; opacity: .75; margin-bottom: 14px; }
.fdh-card .card-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 600;
    text-decoration: none; border: none; cursor: pointer; transition: opacity .15s; white-space: nowrap;
}
.fdh-card .card-btn:hover { opacity: .82; text-decoration: none; }

/* card-all — violet */
.card-all { background: linear-gradient(135deg, #2e1065 0%, #4c1d95 100%); color: #ede9fe; border: 1px solid #7c3aed; }
.card-all .card-btn { background: #c084fc; color: #1a003a; }

/* card-done — emerald */
.card-done { background: linear-gradient(135deg, #064e3b 0%, #065f46 100%); color: #d1fae5; border: 1px solid #059669; }
.card-done .card-btn { background: #34d399; color: #022c22; }

/* card-remain — rose */
.card-remain { background: linear-gradient(135deg, #4c0519 0%, #881337 100%); color: #ffe4e6; border: 1px solid #e11d48; }
.card-remain .card-btn { background: #fb7185; color: #2d0010; }

/* card-today — indigo */
.card-today { background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%); color: #e0e7ff; border: 1px solid #6366f1; }
.card-today .card-btn-wrap { display: flex; gap: 6px; flex-wrap: wrap; }
.card-today .card-btn { background: #818cf8; color: #1e1b4b; }
.card-today .card-btn-alt { background: transparent; border: 1px solid #818cf8; color: #c7d2fe; }

/* card-token — amber */
.card-token { background: linear-gradient(135deg, #451a03 0%, #78350f 100%); color: #fef3c7; border: 1px solid #d97706; }
.card-token .card-label { color: #fcd34d; }
.card-token .card-number { font-size: 20px; color: #fcd34d; }
.card-token .card-btn { background: #fbbf24; color: #2d1a00; }

/* card-links — teal */
.card-links { background: linear-gradient(135deg, #042f2e 0%, #134e4a 100%); color: #ccfbf1; border: 1px solid #0d9488; }
.card-links .link-list { display: flex; flex-direction: column; gap: 5px; margin-bottom: 12px; font-size: 12px; }
.card-links .link-list a { color: #5eead4; text-decoration: none; }
.card-links .link-list a:hover { color: #99f6e4; }
.card-links .card-btn { background: #2dd4bf; color: #011c1b; }
.card-links .card-btn-exp { background: transparent; border: 1px solid #2dd4bf; color: #5eead4; }

/* card-search — dark */
.card-search { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #e2e8f0; border: 1px solid #334155; }
.card-search .search-inputs { display: flex; flex-direction: column; gap: 6px; }
.card-search input.form-control {
    background: rgba(255,255,255,.06) !important; border: 1px solid rgba(255,255,255,.15) !important;
    color: #e2e8f0 !important; border-radius: 8px !important; font-size: 12px !important;
    height: 32px !important; padding: 0 10px !important;
}
.card-search .btn-search {
    background: #c084fc; color: #1a003a; border: none; border-radius: 8px;
    padding: 6px 12px; font-size: 12px; font-weight: 600; cursor: pointer; width: 100%; margin-top: 4px;
}

/* ===== STATUS BADGE ===== */
.status-badge { display: inline-flex; align-items: center; gap: 5px; background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2); border-radius: 20px; padding: 3px 12px; font-size: 11px; font-weight: 600; }
.status-badge.active-all     { background: rgba(192,132,252,.2); border-color: #c084fc; color: #e9d5ff; }
.status-badge.active-success { background: rgba(52,211,153,.2);  border-color: #34d399; color: #a7f3d0; }
.status-badge.active-waiting { background: rgba(251,113,133,.2); border-color: #fb7185; color: #fecdd3; }

/* ===== TABLE ===== */
.fdh-table-wrap { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 1px 8px rgba(0,0,0,.06); }
.fdh-table-scroll { max-height: 540px; overflow-y: auto; overflow-x: auto; }
.fdh-table-scroll::-webkit-scrollbar { width: 6px; height: 6px; }
.fdh-table-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
.fdh-table { width: 100%; border-collapse: collapse; font-size: 13px; font-family: 'Sarabun', sans-serif; }
.fdh-table thead th {
    background: #1a0533; color: #c4b5d4; font-weight: 600; font-size: 11px;
    text-transform: uppercase; letter-spacing: .5px; padding: 10px; position: sticky; top: 0; z-index: 2;
    white-space: nowrap; border-right: 1px solid #2d0b55;
}
.fdh-table tbody tr { transition: background .12s; border-bottom: 1px solid #f1f5f9; }
.fdh-table tbody tr.row-sent { background: #f0fdf4; }
.fdh-table tbody tr.row-wait { background: #fdf4ff; }
.fdh-table tbody tr:hover { background: #f5f3ff !important; }
.fdh-table td { padding: 8px 10px; white-space: nowrap; color: #1e293b; vertical-align: middle; }
.badge-sent { background: #dcfce7; color: #15803d; border-radius: 12px; padding: 2px 9px; font-size: 11px; font-weight: 600; display: inline-block; }
.badge-wait { background: #fae8ff; color: #7e22ce; border-radius: 12px; padding: 2px 9px; font-size: 11px; font-weight: 600; display: inline-block; }

/* ===== FLOAT BUTTON ===== */
.fdh-float-btn {
    position: fixed; bottom: 2rem; left: 50%; transform: translateX(-50%); z-index: 999;
    background: #7c3aed; color: #fff; border: none; border-radius: 30px;
    padding: 13px 32px; font-size: 15px; font-weight: 700;
    font-family: 'Sarabun', sans-serif;
    box-shadow: 0 6px 24px rgba(124,58,237,.4);
    cursor: pointer; display: flex; align-items: center; gap: 10px; transition: background .15s, transform .15s;
}
.fdh-float-btn:hover { background: #6d28d9; transform: translateX(-50%) scale(1.03); }

/* ===== SPINNER ===== */
.fdh-spinner-overlay { display: none; position: fixed; inset: 0; background: rgba(15,23,42,.6); z-index: 9999; align-items: center; justify-content: center; flex-direction: column; gap: 16px; }
.fdh-spinner-ring { width: 60px; height: 60px; border: 5px solid rgba(255,255,255,.2); border-top-color: #c084fc; border-radius: 50%; animation: spin .9s linear infinite; }
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
        <div class="fdh-header-title"><i class="fa fa-leaf"></i> สมุนไพรไทย — 16 แฟ้ม FDH HerbNew</div>
        <div class="fdh-header-sub">db2 · INSCL 03,04,33,00,23 · OPD เท่านั้น · is_herb=1</div>
    </div>
    <div class="fdh-legend">
        <span><span class="legend-dot" style="background:#34d399;"></span><span style="color:#d1fae5;font-size:13px;">ส่งแล้ว</span></span>
        <span><span class="legend-dot" style="background:#c084fc;"></span><span style="color:#e9d5fe;font-size:13px;">รอส่ง</span></span>
    </div>
</div>

<!-- FILTER BAR -->
<div class="fdh-filter-bar">
    <i class="fa fa-filter"></i>
    <span>เงื่อนไข:</span>
    <span class="pill">สิทธิ์ 03, 04, 33, 00, 23</span>
    <span class="pill">is_herb = 1 / chrgitem = 21</span>
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
        <a href="<?= Url::to(['f16herbnew/index','date1'=>$date1,'date2'=>$date2,'status'=>'all']) ?>"
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
        <a href="<?= Url::to(['f16herbnew/index','date1'=>$date1,'date2'=>$date2,'status'=>'success']) ?>"
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
        <a href="<?= Url::to(['f16herbnew/index','date1'=>$date1,'date2'=>$date2,'status'=>'waiting']) ?>"
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
        <a href="<?= Url::to(['f16herbnew/run-curl','date1'=>$date1,'date2'=>$date2]) ?>" class="card-btn">
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
            <a href="<?= Url::to(['fdhherbnew/index']) ?>" class="card-btn" target="_blank"><i class="fa fa-search"></i> Query</a>
            <?= Html::a('<i class="fa fa-download"></i> Export', ['f16herbnew/exports'], ['class' => 'card-btn card-btn-exp']) ?>
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
<?= Html::beginForm(['f16herbnew/data'], 'post', ['name' => 'frmMain', 'id' => 'frmMain']) ?>
<?= Html::hiddenInput('date1', $date1) ?>
<?= Html::hiddenInput('date2', $date2) ?>

<?php
$allowedUsers  = [6, 96, 289, 383];
$currentUserId = Yii::$app->user->id ?? null;
if (in_array($currentUserId, $allowedUsers)):
?>
<button type="submit" class="fdh-float-btn" id="fdh-submit-btn">
    <i class="fa fa-leaf"></i> ส่งข้อมูล OP-HerbNew
</button>
<?php endif; ?>

<div class="fdh-table-wrap">
    <div class="fdh-table-scroll">
        <table class="fdh-table">
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll" onclick="toggleAll(this)"></th>
                    <th>#</th>
                    <th>วันรับบริการ</th>
                    
                    <th>HN</th>
                    <th>ชื่อ-สกุล</th>
                    <th>อายุ</th>
                    <th>แผนก</th>
                    <th>โรคหลัก</th>
                    <th>สมุนไพร</th>
                    <th>กองทุน</th>
			        <th>เรียกเก็บ</th>
					<th>ชดเชย</th>
                    <th>สิทธิ์</th>
                    <th>สถานหลัก</th>
                    <th>สถานะ</th>
                    <th>ตรวจสอบ</th>
					<th>authen</th>
					<th>##</th>
                </tr>
            </thead>
            <tbody>
           <?php
$models = $dataProvider->getModels();
$rowNo  = count($models);
foreach ($models as $key => $value):
    $rowNo--;
    $displayNo = $rowNo + 1;
    $isSent    = isset($value['messagecode']) && $value['messagecode'] !== null && $value['messagecode'] !== '';
    $rowCls    = $isSent ? 'row-sent' : 'row-wait';

    // ✅ เพิ่มตรงนี้ — pad ให้ครบ 10 หลัก และ 6 หลัก
    $visitIdPad = str_pad($value['VISIT_ID'], 10, '0', STR_PAD_LEFT);
    $hnPad      = str_pad($value['HN'],       6,  '0', STR_PAD_LEFT);
?>
    <tr class="<?= $rowCls ?>" id="row-<?= $visitIdPad ?>">
        <td><input type="checkbox" name="chkDel[]" id="chkDel<?= $key ?>"
                   value="<?= $visitIdPad . $hnPad ?>"
                   style="width:16px;height:16px;"></td>
        <td style="color:#94a3b8;font-size:12px;font-family:'IBM Plex Mono',monospace;"><?= $displayNo ?></td>
        <td style="font-size:12px;font-family:'IBM Plex Mono',monospace;"><?= $value['REG_DATETIME'] ?></td>
        <!--<td style="font-size:12px;font-family:'IBM Plex Mono',monospace;"><?= $value['VISIT_ID'] ?></td>-->
        <td><?= $value['HN'] ?></td>
        <td><?= $value['fullname'] ?></td>
        <td style="text-align:center;"><?= $value['age'] ?></td>
        <td><?= $value['unit_name'] ?></td>
        <td><?= $value['Diagx'] ?></td>
        <td style="max-width:160px;overflow:hidden;text-overflow:ellipsis;" title="<?= Html::encode($value['Herb']) ?>"><?= $value['Herb'] ?></td>
        <td style="text-align:right;"><?= $value['fund'] ?? '' ?></td>
        <td style="text-align:right;"><?= $value['amount'] ?? '' ?></td>
        <td>
            <?php if ((float)$value['ret_statement'] == 0.00): ?>
                <span style="color:#dc2626;font-weight:700;">
                    <?= number_format($value['ret_statement'], 2) ?>
                </span>
            <?php else: ?>
                <span style="color:#16a34a;font-weight:700;">
                    <?= number_format($value['ret_statement'], 2) ?>
                </span>
            <?php endif; ?>
        </td>
        <td><?= $value['inscl'] ?></td>
        <td><?= $value['hospmain'] ?></td>
        <td id="td-status-<?= $visitIdPad ?>">
            <?php if ($isSent): ?>
                <span class="badge-sent"><i class="fa fa-check"></i> <?= Html::encode($value['messagecode']) ?></span>
            <?php else: ?>
                <span class="badge-wait"><i class="fa fa-clock-o"></i> รอส่ง</span>
            <?php endif; ?>
        </td>

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
        <td style="font-size:12px;color:#64748b;"><?= $value['claimcode'] ?></td>

        <td style="text-align:center;padding:4px;">
            <button type="button"
                    style="background:#7c3aed;color:#fff;border:none;border-radius:6px;
                           padding:4px 10px;font-size:12px;font-weight:500;cursor:pointer;"
                    onclick="openCheckModal(
                        '<?= $value['VISIT_ID'] ?>',
                        '<?= $value['HN'] ?>',
                        '<?= addslashes($value['fullname']) ?>'
                    )"
                    title="ตรวจสอบข้อมูลก่อนส่ง">
                <i class="fas fa-search" style="font-size:11px;"></i> ตรวจสอบ
            </button>
        </td>
    </tr>
<?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= Html::endForm() ?>
<?php
$url     = \yii\helpers\Url::to(['f16herbnew/check']);
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
            var approvedList = ['approved', 'paid', 'accepted', 'success'];
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


<!-- PASS LOG (hidden) -->
<div id="model1" style="display:none;margin-top:20px;">
    <h5 style="color:#15803d;border-left:4px solid #34d399;padding-left:10px;margin-bottom:10px;">รายการผ่านวันนี้</h5>
    <?= \yii\grid\GridView::widget(['dataProvider' => $passProvider, 'tableOptions' => ['class' => 'table table-striped table-hover', 'style' => 'font-size:13px;'], 'headerRowOptions' => ['style' => 'background:#f0fdf4;'], 'columns' => [['class' => 'yii\grid\SerialColumn'], 'visit_id', 'pid', 'users', 'messagecode', 'd_update']]); ?>
</div>
<div id="model2" style="display:none;margin-top:20px;">
    <h5 style="color:#dc2626;border-left:4px solid #fb7185;padding-left:10px;margin-bottom:10px;">รายการไม่ผ่าน</h5>
    <?= \yii\grid\GridView::widget(['dataProvider' => $errorProvider, 'tableOptions' => ['class' => 'table table-striped', 'style' => 'font-size:13px;'], 'headerRowOptions' => ['style' => 'background:#fff7f7;'], 'columns' => [['class' => 'yii\grid\SerialColumn'], 'visit_id', 'pid', 'users', 'messagecode', 'd_update']]); ?>
</div>

<!-- ====================================================  MODAL CHECK DATA  ==================================================== -->
<style>
#modalCheckData .modal-dialog { max-width:75vw; width:75vw; margin:20px auto; }
#modalCheckData .modal-content { border-radius:10px; overflow:hidden; border:none; }
#modalCheckData .modal-header { background:linear-gradient(135deg,#7c3aed 0%,#4c1d95 100%); border-bottom:none; padding:14px 18px; }
#mdBody { max-height:75vh; overflow-y:auto; padding:16px 18px; }
.chk-sum-row { display:flex; gap:10px; margin-bottom:16px; }
.chk-sum-card { flex:1; border-radius:10px; padding:14px 16px; display:flex; align-items:center; gap:12px; }
.csc-ok { background:#E1F5EE; } .csc-empty { background:#FCEBEB; } .csc-na { background:#F5F0FF; }
.csc-icon { width:36px; height:36px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:17px; font-weight:700; flex-shrink:0; }
.csc-ok .csc-icon { background:#9FE1CB; color:#085041; } .csc-empty .csc-icon { background:#F7C1C1; color:#791F1F; } .csc-na .csc-icon { background:#DDD6FE; color:#4c1d95; }
.csc-num { font-size:26px; font-weight:700; line-height:1; }
.csc-ok .csc-num { color:#0F6E56; } .csc-empty .csc-num { color:#A32D2D; } .csc-na .csc-num { color:#6d28d9; }
.csc-lbl { font-size:11px; font-weight:500; margin-top:3px; }
.file-row { border:1px solid #e4e4e4; border-radius:8px; margin-bottom:6px; overflow:hidden; }
.file-header { display:flex; align-items:center; gap:10px; padding:10px 14px; }
.file-header.clickable { cursor:pointer; } .file-header.clickable:hover { background:rgba(0,0,0,.02); }
.fh-ok { border-left:4px solid #1D9E75; } .fh-empty { border-left:4px solid #E24B4A; } .fh-na { border-left:4px solid #7c3aed; } .fh-warn { border-left:4px solid #EF9F27; }
.file-name { font-size:13px; font-weight:600; min-width:60px; color:#333; }
.fpill { font-size:11px; font-weight:500; padding:3px 11px; border-radius:20px; }
.fpill-ok { background:#E1F5EE; color:#0F6E56; } .fpill-empty { background:#FCEBEB; color:#A32D2D; } .fpill-na { background:#F5F0FF; color:#6d28d9; } .fpill-warn { background:#FAEEDA; color:#633806; }
.fchev { margin-left:auto; font-size:11px; color:#bbb; transition:transform .2s; }
.file-row.open .fchev { transform:rotate(180deg); }
.file-body { display:none; border-top:1px solid #eee; }
.file-row.open .file-body { display:block; }
.dtbl { width:100%; border-collapse:collapse; font-size:11px; }
.dtbl th { background:#f7faf9; padding:5px 10px; text-align:left; border-bottom:1px solid #e5e5e5; color:#666; font-size:10px; font-weight:600; white-space:nowrap; text-transform:uppercase; }
.dtbl td { padding:5px 10px; border-bottom:1px solid #f0f0f0; color:#333; white-space:nowrap; }
.chk-prog-bar { height:5px; background:rgba(255,255,255,.3); border-radius:3px; overflow:hidden; margin-bottom:14px; }
.chk-prog-fill { height:100%; background:#fff; border-radius:3px; transition:width .25s; width:0%; }
.chk-alert { border-radius:8px; padding:10px 14px; font-size:13px; font-weight:500; margin-bottom:14px; display:flex; align-items:center; gap:8px; }
.chk-alert-ok { background:#E1F5EE; color:#0F6E56; border:1px solid #9FE1CB; }
.chk-alert-error { background:#FCEBEB; color:#A32D2D; border:1px solid #F7C1C1; }
</style>

<div class="modal fade" id="modalCheckData" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div style="display:flex;align-items:center;gap:11px;">
                    <div style="width:40px;height:40px;border-radius:10px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-clipboard-check" style="color:#fff;font-size:18px;"></i>
                    </div>
                    <div>
                        <div style="font-size:15px;font-weight:600;color:#fff;">ตรวจสอบข้อมูล 8 แฟ้ม</div>
                        <div id="mdPatientInfo" style="font-size:11px;color:rgba(255,255,255,.8);margin-top:2px;"></div>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" style="font-size:22px;color:#fff;opacity:.8;margin-left:auto;">&times;</button>
            </div>
            <div id="mdBody">
                <div id="mdProgress" style="display:none;margin-bottom:6px;">
                    <div class="chk-prog-bar"><div class="chk-prog-fill" id="mdProgFill"></div></div>
                    <div style="font-size:11px;color:#999;text-align:center;margin-top:6px;"><i class="fas fa-spinner fa-spin"></i> กำลังตรวจสอบ...</div>
                </div>
                <div id="mdAlert" style="display:none;"></div>
                <div id="mdSummary" style="display:none;margin-bottom:14px;">
                    <div class="chk-sum-row">
                        <div class="chk-sum-card csc-ok"><div class="csc-icon">&#10004;</div><div><div class="csc-num" id="mdOkCount">0</div><div class="csc-lbl">มีข้อมูล</div></div></div>
                        <div class="chk-sum-card csc-empty"><div class="csc-icon">&#10008;</div><div><div class="csc-num" id="mdEmptyCount">0</div><div class="csc-lbl">ไม่มีข้อมูล</div></div></div>
                        <div class="chk-sum-card csc-na"><div class="csc-icon">&mdash;</div><div><div class="csc-num" id="mdNaCount">0</div><div class="csc-lbl">ไม่บังคับ</div></div></div>
                    </div>
                </div>
                <div id="mdGrid"></div>
            </div>
            <div class="modal-footer">
                <small style="font-size:11px;color:#999;"><span style="color:#E24B4A;font-weight:700;">*</span> = แฟ้มบังคับ</small>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="border-radius:7px;padding:6px 18px;"><i class="fas fa-times"></i> ปิด</button>
            </div>
        </div>
    </div>
</div>

<script>
var checkDataUrl = '<?= Url::to(['check-data']) ?>';

function openCheckModal(visit, hn, name) {
    $('#mdPatientInfo').html('<b>HN:</b> '+hn+'&nbsp;|&nbsp;<b>Visit:</b> '+visit+'&nbsp;|&nbsp;'+name);
    $('#mdGrid').html(''); $('#mdAlert').hide().html(''); $('#mdSummary').hide();
    $('#mdProgress').show(); $('#mdProgFill').css('width','0%');
    $('#modalCheckData').modal('show');
    var pct=0, pTimer=setInterval(function(){ pct+=7; if(pct>88){clearInterval(pTimer);pct=88;} $('#mdProgFill').css('width',pct+'%'); },70);
    $.getJSON(checkDataUrl,{visit:visit,hn:hn}).done(function(res){ clearInterval(pTimer); $('#mdProgFill').css('width','100%'); setTimeout(function(){$('#mdProgress').hide();},300); renderFiles(res); }).fail(function(x){ clearInterval(pTimer); $('#mdProgress').hide(); $('#mdGrid').html('<div style="background:#FCEBEB;border-radius:8px;padding:12px;color:#791F1F;">HTTP Error '+x.status+'</div>'); });
}

function renderFiles(res) {
    if(!res.success){ $('#mdGrid').html('<div style="background:#FCEBEB;border-radius:8px;padding:12px;color:#791F1F;">'+res.message+'</div>'); return; }
    var ok=0,empty=0,na=0,html='';
    $.each(res.data,function(_,item){
        var hCls,pCls,icon,label;
        if(item.status==='ok'){hCls='fh-ok';pCls='fpill-ok';icon='&#10004;';label='มี '+item.count+' record';ok++;}
        else if(item.status==='empty'){hCls='fh-empty';pCls='fpill-empty';icon='&#10008;';label='ไม่มีข้อมูล!';empty++;}
        else if(item.status==='error'){hCls='fh-warn';pCls='fpill-warn';icon='&#9888;';label='Query Error';empty++;}
        else if(item.status==='no_config'){hCls='fh-warn';pCls='fpill-warn';icon='&#9881;';label='ไม่มี config';empty++;}
        else{hCls='fh-na';pCls='fpill-na';icon='&mdash;';label='ไม่บังคับ';na++;}
        var reqBadge=item.required?'<span style="color:#E24B4A;"> *</span>':'';
        var tblHtml=buildDataTable(item.rows);
        var hasData=(tblHtml!=='');
        html+='<div class="file-row'+(item.status==='empty'?' open':'')+'"><div class="file-header '+hCls+(hasData?' clickable':'')+(hasData?' onclick="toggleRow(this)"':'')+'">'+
              '<span class="file-name">'+item.table+reqBadge+'</span><span class="fpill '+pCls+'">'+icon+'&nbsp;'+label+'</span>'+
              (hasData?'<span class="fchev">&#9660;</span>':'')+'</div>'+
              (hasData?'<div class="file-body"><div style="overflow-x:auto;">'+tblHtml+'</div></div>':'')+
              '</div>';
    });
    $('#mdGrid').html(html); $('#mdOkCount').text(ok); $('#mdEmptyCount').text(empty); $('#mdNaCount').text(na); $('#mdSummary').fadeIn(200);
    if(res.hasError){ $('#mdAlert').html('<i class="fas fa-times-circle"></i>&nbsp;ข้อมูลไม่ครบ — กรุณาตรวจสอบแฟ้มสีแดง').removeClass('chk-alert-ok').addClass('chk-alert chk-alert-error').show(); }
    else { $('#mdAlert').html('<i class="fas fa-check-circle"></i>&nbsp;ข้อมูลครบถ้วน — พร้อมส่งข้อมูล').removeClass('chk-alert-error').addClass('chk-alert chk-alert-ok').show(); }
}

function buildDataTable(rows) {
    if(!rows||rows.length===0) return '';
    var cols=Object.keys(rows[0]),h='<table class="dtbl"><thead><tr>';
    cols.forEach(function(c){h+='<th>'+c+'</th>';});
    h+='</tr></thead><tbody>';
    rows.forEach(function(row){ h+='<tr>'; cols.forEach(function(c){ var v=(row[c]!==null&&row[c]!==undefined)?row[c]:'<span style="color:#ccc;font-style:italic;">null</span>'; h+='<td>'+v+'</td>'; }); h+='</tr>'; });
    return h+'</tbody></table>';
}

function toggleRow(hdr) { var row=hdr.closest('.file-row'); if(row) row.classList.toggle('open'); }

function toggleAll(master) { document.querySelectorAll('input[name="chkDel[]"]').forEach(function(cb){ cb.checked=master.checked; }); }

document.getElementById('frmMain').addEventListener('submit', function(e) {
    e.preventDefault();
    var checked = document.querySelectorAll('input[name="chkDel[]"]:checked');
    if (checked.length === 0) { alert('กรุณาเลือกรายการก่อนส่ง'); return; }
    document.getElementById('fdh-spinner').style.display = 'flex';
    var i = 0;
    function step() {
        if (i < checked.length) {
            var row = checked[i].closest('tr');
            row.style.background = '#f3e8ff';
            row.scrollIntoView({ behavior: 'smooth', block: 'center' });
            i++; setTimeout(step, 200);
        } else { document.getElementById('frmMain').submit(); }
    }
    step();
});

setTimeout(function(){ $('.alert').slideUp('slow'); }, 15000);

<?php $this->registerJs("$('#link1').click(function(){ $('#model1').show(); $('#model2').hide(); }); $('#link2').click(function(){ $('#model1').hide(); $('#model2').show(); });"); ?>
</script>