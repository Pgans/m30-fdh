<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\web\View;
use yii\data\ActiveDataProvider;
use yii\bootstrap\Modal;
use dosamigos\datepicker\DatePicker;

$this->title = 'FDH-TELEMED';
$this->registerCss(<<<'CSS'
@import url("https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;600;700;800&family=IBM+Plex+Mono:wght@400;600&display=swap");

*, *::before, *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: "Noto Sans Thai", sans-serif;
    background: #f4f7fb;
    color: #1e293b;
    min-height: 100vh;
    padding: 0;
}

/* ========================================
   PAGE HEADER
======================================== */
.page-header {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 50%, #0f172a 100%);
    padding: 18px 28px;
    display: flex;
    align-items: center;
    gap: 16px;
    position: sticky;
    top: 0;
    z-index: 200;
    box-shadow: 0 4px 18px rgba(0,0,0,0.12);
}

.page-header .badge-system {
    background: rgba(255,255,255,0.18);
    color: #fff;
    font-size: 11px;
    font-weight: 800;
    padding: 5px 14px;
    border-radius: 30px;
    letter-spacing: 1px;
    backdrop-filter: blur(8px);
}

.page-header h1 {
    font-size: 22px;
    font-weight: 800;
    color: #fff;
    letter-spacing: .5px;
}

.page-header .subtitle {
    font-size: 12px;
    color: rgba(255,255,255,0.75);
    font-family: "IBM Plex Mono", monospace;
}

/* ========================================
   WRAPPER
======================================== */
.dash-wrapper {
    width: 96%;
    margin: 22px auto;
}

/* ========================================
   CONDITION BAR
======================================== */
.condition-bar {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 14px 18px;
    font-size: 12px;
    color: #334155;
    margin-bottom: 22px;
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    box-shadow: 0 4px 20px rgba(15,23,42,0.04);
}

.condition-bar i {
    color: #2563eb;
}

.condition-tag {
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    color: #2563eb;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 700;
}

/* ========================================
   DASH GRID
======================================== */
.dash-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 14px;
    margin-bottom: 24px;
}

@media (max-width: 1400px) {
    .dash-grid {
        grid-template-columns: repeat(4, 1fr);
    }
}

@media (max-width: 900px) {
    .dash-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* ========================================
   DASH CARD
======================================== */
.dash-card {
    border-radius: 20px;
    padding: 14px;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    gap: 5px;
    min-height: 150px;
    transition: all .2s ease;
    color: #fff;
    box-shadow: 0 8px 24px rgba(15,23,42,0.10);
}

.dash-card:hover {
    transform: translateY(-3px);
}

.card-all {
    background: linear-gradient(135deg, #2563eb, #38bdf8);
}

.card-done {
    background: linear-gradient(135deg, #16a34a, #4ade80);
}

.card-remain {
    background: linear-gradient(135deg, #e11d48, #fb7185);
}

.card-today {
    background: linear-gradient(135deg, #7c3aed, #c084fc);
}

.card-token {
    background: linear-gradient(135deg, #d97706, #fbbf24);
}

.card-links {
    background: linear-gradient(135deg, #0891b2, #38bdf8);
}

.card-search {
    background: linear-gradient(135deg, #475569, #64748b);
}

.card-icon {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    background: rgba(255,255,255,0.20);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}

.card-label {
    font-size: 12px;
    font-weight: 700;
}

.card-number {
    font-size: 30px;
    font-weight: 800;
    font-family: "IBM Plex Mono", monospace;
}

.card-unit {
    font-size: 11px;
    opacity: .8;
}

.card-actions {
    margin-top: 6px;
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}

/* ========================================
   BUTTON
======================================== */
.cta-btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 5px 10px;
    border-radius: 24px;
    font-size: 11px;
    font-weight: 700;
    border: none;
    text-decoration: none;
    background: rgba(255,255,255,0.18);
    color: #fff;
    transition: .15s ease;
}

.cta-btn:hover {
    transform: scale(1.04);
    background: rgba(255,255,255,0.28);
    color: #fff;
    text-decoration: none;
}

/* ========================================
   SECTION TITLE
======================================== */
.section-title {
    font-size: 14px;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-title::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #cbd5e1;
}

/* ========================================
   TABLE WRAP
======================================== */
.table-wrap {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 8px 28px rgba(15,23,42,0.06);
}

.scroll-area {
    height: 560px;
    overflow-y: auto;
    overflow-x: auto;
}

.scroll-area::-webkit-scrollbar {
    width: 7px;
    height: 7px;
}

.scroll-area::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

/* ========================================
   DATA TABLE
======================================== */
.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

/* ========================================
   TABLE HEADER
======================================== */
.data-table thead th {
    position: sticky;
    top: 0;
    z-index: 50;
    background: linear-gradient(180deg, #f8fafc 0%, #e2e8f0 100%);
    color: #0f172a;
    font-weight: 800;
    font-size: 11px;
    letter-spacing: .5px;
    text-transform: uppercase;
    padding: 12px 10px;
    border-bottom: 1px solid #cbd5e1;
    text-align: center;
    white-space: nowrap;
}

/* ========================================
   ROW
======================================== */
.data-table tbody tr {
    border-bottom: 1px solid #e5e7eb;
    transition: all .15s ease;
}

/* ========================================
   ส่งแล้ว = เขียวอ่อน
======================================== */
.data-table tbody tr.row-pass {
    background: #eefbf3 !important;
    border-left: 4px solid #22c55e;
}

.data-table tbody tr.row-pass td {
    color: #1f2937 !important;
}

/* ========================================
   รอส่ง = ชมพูอ่อน
======================================== */
.data-table tbody tr.row-wait {
    background: #fff1f5 !important;
    border-left: 4px solid #f472b6;
}

.data-table tbody tr.row-wait td {
    color: #1f2937 !important;
}

/* ========================================
   HOVER
======================================== */
.data-table tbody tr.row-pass:hover {
    background: #dcfce7 !important;
}

.data-table tbody tr.row-wait:hover {
    background: #ffe4ec !important;
}

/* ========================================
   TD
======================================== */
.data-table td {
    padding: 10px 10px;
    vertical-align: middle;
    white-space: nowrap;
    font-size: 13px;
    color: #1e293b;
    font-weight: 500;
}

/* ========================================
   COLUMN COLORS
======================================== */
.num-col {
    font-family: "IBM Plex Mono", monospace;
    font-size: 12px;
    color: #334155 !important;
    font-weight: 700;
}

.col-visitid {
    font-family: "IBM Plex Mono", monospace;
    font-weight: 700;
    color: #15803d !important;
    font-size: 12px;
}

.col-hn {
    font-family: "IBM Plex Mono", monospace;
    color: #1d4ed8 !important;
    font-size: 12px;
    font-weight: 700;
}

.col-name {
    font-weight: 700;
    color: #111827 !important;
}

.col-age {
    text-align: center;
    color: #111827 !important;
    font-weight: 700;
}

.col-diag {
    color: #4338ca !important;
    font-weight: 700;
}

.col-inscl {
    color: #1f2937 !important;
    font-size: 12px;
    font-weight: 600;
}

.col-hospmain {
    color: #334155 !important;
    font-size: 12px;
    font-family: "IBM Plex Mono", monospace;
    font-weight: 600;
}

.col-claim {
    color: #ea580c !important;
    font-weight: 800;
    font-size: 12px;
    font-family: "IBM Plex Mono", monospace;
}

.col-endpoint {
    color: #2563eb !important;
    font-weight: 700;
    font-size: 12px;
    font-family: "IBM Plex Mono", monospace;
}

/* ========================================
   BADGES
======================================== */
.badge-pass {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #dcfce7;
    color: #15803d;
    border: 1px solid #86efac;
    padding: 4px 10px;
    border-radius: 30px;
    font-size: 11px;
    font-weight: 700;
}

.badge-wait {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #ffe4e6;
    color: #e11d48;
    border: 1px solid #fda4af;
    padding: 4px 10px;
    border-radius: 30px;
    font-size: 11px;
    font-weight: 700;
}

.badge-dept {
    display: inline-block;
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid #bfdbfe;
    padding: 3px 8px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 700;
}

.badge-diag {
    display: inline-block;
    background: #eef2ff;
    color: #4338ca;
    border: 1px solid #c7d2fe;
    padding: 3px 8px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 700;
    font-family: "IBM Plex Mono", monospace;
}

/* ========================================
   SUB SECTION
======================================== */
.sub-section {
    margin-top: 24px;
}

.sub-section-header {
    padding: 14px 18px;
    font-weight: 700;
    font-size: 13px;
}

.header-pass {
    background: #dcfce7;
    color: #166534;
}

.header-fail {
    background: #ffe4e6;
    color: #be123c;
}

/* ========================================
   FLOATING BUTTON
======================================== */
.floating-send {
    position: fixed;
    bottom: 28px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000;
}

.floating-send button {
    background: linear-gradient(135deg, #10b981, #059669) !important;
    border: none !important;
    color: #fff !important;
    font-size: 15px !important;
    font-weight: 800 !important;
    padding: 14px 36px !important;
    border-radius: 40px !important;
    box-shadow: 0 10px 30px rgba(16,185,129,0.30) !important;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* ========================================
   LOADING
======================================== */
#loading-spinner {
    position: fixed;
    inset: 0;
    background: rgba(255,255,255,0.85);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    flex-direction: column;
    gap: 20px;
}

.spinner-ring {
    width: 64px;
    height: 64px;
    border: 4px solid rgba(59,130,246,0.15);
    border-top-color: #2563eb;
    border-radius: 50%;
    animation: spin .8s linear infinite;
}

.spinner-text {
    color: #1e293b;
    font-size: 13px;
    font-weight: 700;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* ========================================
   CHECKBOX
======================================== */
input[type="checkbox"] {
    width: 15px;
    height: 15px;
    accent-color: #10b981;
    cursor: pointer;
}
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
    <div>
        <span class="badge-system">🏥 FDH System</span>
    </div>
    <div>
        <h1>FDH-TELEMED</h1>
        <div class="subtitle">Financial Data Hub · Telemedicine Claims</div>
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
        <span style="margin-left:auto; display:flex; gap:8px; align-items:center;">
            <span style="display:inline-flex;align-items:center;gap:5px;font-size:11px;">
                <span style="width:10px;height:10px;border-radius:50%;background:#4ade80;display:inline-block;"></span> ส่งแล้ว
            </span>
            <span style="display:inline-flex;align-items:center;gap:5px;font-size:11px;">
                <span style="width:10px;height:10px;border-radius:50%;background:#fb7185;display:inline-block;"></span> รอส่ง
            </span>
        </span>
    </div>

    <!-- Dashboard Cards -->
    <!-- Dashboard Cards -->
<div class="dash-grid">

    <!-- =========================
         CARD : ทั้งหมด
    ========================== -->
    <div class="dash-card card-all">

        <div class="card-icon">
            <i class="fa fa-list"></i>
        </div>

        <div class="card-label">
            ทั้งหมด
        </div>

        <div class="card-number">
            <?= number_format($totalMonth ?? 0) ?>
        </div>

        <div class="card-unit">
            รายการ
        </div>

        <div class="card-actions">

            <a href="<?= Url::to([
                'f16telemed/index',
                'date1' => substr($date1,0,10),
                'date2' => substr($date2,0,10),
                'status' => 'all'
            ]) ?>"
               class="cta-btn btn-blue">

                <i class="fa fa-table"></i>

                ทั้งหมด
                <?= number_format($totalMonth ?? 0) ?>

            </a>

        </div>

    </div>


    <!-- =========================
         CARD : ส่งแล้ว
    ========================== -->
    <div class="dash-card card-done">

        <div class="card-icon">
            <i class="fa fa-check-circle"></i>
        </div>

        <div class="card-label">
            ส่งแล้ว
        </div>

        <div class="card-number">
            <?= number_format($claimedMonth ?? 0) ?>
        </div>

        <div class="card-unit">
            รายการ
        </div>

        <div class="card-actions">

            <a href="<?= Url::to([
                'f16telemed/index',
                'date1' => substr($date1,0,10),
                'date2' => substr($date2,0,10),
                'status' => 'success'
            ]) ?>"
               class="cta-btn btn-green">

                <i class="fa fa-check-square"></i>

                ส่งแล้ว
                <?= number_format($claimedMonth ?? 0) ?>

            </a>

        </div>

    </div>


    <!-- =========================
         CARD : รอส่ง
    ========================== -->
    <div class="dash-card card-remain">

        <div class="card-icon">
            <i class="fa fa-clock-o"></i>
        </div>

        <div class="card-label">
            รอส่ง
        </div>

        <div class="card-number">
            <?= number_format($remainingMonth ?? 0) ?>
        </div>

        <div class="card-unit">
            รายการ
        </div>

        <div class="card-actions">

            <a href="<?= Url::to([
                'f16telemed/index',
                'date1' => substr($date1,0,10),
                'date2' => substr($date2,0,10),
                'status' => 'waiting'
            ]) ?>"
               class="cta-btn btn-red">

                <i class="fa fa-ban"></i>

                รอส่ง
                <?= number_format($remainingMonth ?? 0) ?>

            </a>

        </div>

    </div>



        <!-- Card 4: ผ่านวันนี้ -->
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
                <?php
                $this->registerJs("
                    $('#myModal').on('show.bs.modal', function(event) {
                        var button = \$(event.relatedTarget);
                        var url    = button.data('url');
                        var modal  = \$(this);
                        \$.ajax({ url: url, success: function(data) { modal.find('#modal-content').html(data); } });
                    });
                ");
                ?>
                <?= Html::a('<i class="fa fa-folder-open"></i> ไฟล์', '#', [
                    'class'       => 'cta-btn btn-purple',
                    'data-toggle' => 'modal',
                    'data-target' => '#myModal',
                    'data-url'    => Url::to(['f16erext/list-files-partial']),
                ]) ?>
                <button class="cta-btn btn-green" id="link1b">
                    <i class="fa fa-check"></i> ผ่าน
                </button>
            </div>
        </div>

        <!-- Card 5: TOKEN -->
        <div class="dash-card card-token">
            <div class="card-icon"><i class="fa fa-key"></i></div>
            <div class="card-label">TOKEN</div>
            <div class="card-number" style="font-size:20px;padding-top:4px;color:#fcd34d;">tokens</div>
            <div class="card-unit">&nbsp;</div>
            <div class="card-actions">
                <a href="<?= Url::to(['f16telemed/run-curl', 'date1' => $date1, 'date2' => $date2]) ?>"
                   class="cta-btn btn-yellow">
                    RunToken <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Card 6: ลิงก์ -->
        <div class="dash-card card-links">
            <div class="card-icon"><i class="fa fa-link"></i></div>
            <div class="card-label">ลิงก์</div>
            <div class="link-list">
                <a href="https://uat-fdh.inet.co.th/hospital/detail" target="_blank">
                    <i class="fa fa-external-link" style="font-size:10px;"></i> FDH-UAT
                </a>
                <a href="https://fdh.moph.go.th/hospital/" target="_blank">
                    <i class="fa fa-external-link" style="font-size:10px;"></i> FDH-Prod
                </a>
            </div>
            <div class="card-actions">
                <a href="<?= Url::to(['fdhtelemed/index']) ?>" class="cta-btn btn-cyan" target="_blank">
                    <i class="fa fa-search"></i> Query
                </a>
                <?= Html::a('<i class="fa fa-download"></i> Export', ['f16telemed/exports'], ['class' => 'cta-btn btn-green']) ?>
            </div>
        </div>

        <!-- Card 7: ค้นหา -->
        <div class="dash-card card-search">
            <div class="card-icon"><i class="fa fa-search"></i></div>
            <div class="card-label" style="margin-bottom:6px;">ค้นหาวันที่</div>
            <?= Html::beginForm(['index'], 'get') ?>
            <div class="date-field">
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
                <?= Html::submitButton('🔍 ค้นหา', [
                    'class' => 'cta-btn btn-gray',
                    'style' => 'width:100%;justify-content:center;margin-top:2px;',
                ]) ?>
            </div>
            <?= Html::endForm() ?>
        </div>

    </div><!-- /dash-grid -->

    <!-- ====== MAIN DATA TABLE (GridView) ====== -->
    <?= Html::beginForm(['f16telemed/data'], 'post', ['name' => 'frmMain', 'id' => 'frmMain']) ?>

    <div class="section-title" id="mainTable">
        <i class="fa fa-database" style="color:#63b3ed;"></i>
        ข้อมูลผู้ป่วย OPD Telemed
    </div>

    <div class="table-wrap">
        <div class="scroll-area">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout'       => '{items}',
                'tableOptions' => ['class' => 'data-table'],

                // ✅ กำหนดสีแถว: เขียว = ส่งแล้ว, ชมพู = รอส่ง
                'rowOptions' => function ($model) {
                    $isPassed = !empty($model['messagecode']);
                    return ['class' => $isPassed ? 'row-pass' : 'row-wait'];
                },

                'columns' => [
                    // Checkbox
                    [
                        'class'           => 'yii\grid\CheckboxColumn',
                        'name'            => 'chkDel[]',
                        'checkboxOptions' => function ($model) {
                            return ['value' => $model['visit_id'] . $model['hn']];
                        },
                        'headerOptions'  => ['style' => 'width:36px; text-align:center;'],
                        'contentOptions' => ['style' => 'text-align:center;'],
                    ],

                    // ลำดับ
                    [
					'attribute'      => 'No',
					'label'          => '#',
					'headerOptions'  => ['style' => 'width:60px;text-align:center;'],
					'contentOptions' => ['class' => 'num-col', 'style' => 'text-align:center;'],
					],

                    // วันที่
                    [
                        'attribute'      => 'regdate',
                        'label'          => 'วันที่',
                        'contentOptions' => ['class' => 'num-col'],
                    ],

                    // เลขบริการ
                    [
                        'attribute'      => 'visit_id',
                        'label'          => 'เลขบริการ',
                        'contentOptions' => ['class' => 'col-visitid'],
                    ],

                    // HN
                    [
                        'attribute'      => 'hn',
                        'label'          => 'HN',
                        'contentOptions' => ['class' => 'col-hn'],
                    ],

                    // ชื่อ-สกุล
                    [
                        'attribute'      => 'fullname',
                        'label'          => 'ชื่อ-สกุล',
                        'contentOptions' => ['class' => 'col-name', 'style' => 'min-width:160px;'],
                    ],

                    // อายุ
                    [
                        'attribute'      => 'age',
                        'label'          => 'อายุ',
                        'contentOptions' => ['class' => 'col-age'],
                    ],

                    // แผนก
                    [
                        'label'          => 'แผนก',
                        'format'         => 'raw',
                        'value'          => function ($model) {
                            return Html::tag('span', Html::encode($model['unit_name']), ['class' => 'badge-dept']);
                        },
                        'contentOptions' => ['style' => 'text-align:center;'],
                    ],

                    // โรคหลัก
                    [
                        'attribute'      => 'Diagx',
                        'label'          => 'โรคหลัก',
                        'contentOptions' => ['class' => 'col-diag', 'style' => 'max-width:180px;overflow:hidden;text-overflow:ellipsis;'],
                    ],

                    // รหัสโรค
                    [
                        'label'          => 'รหัสโรค',
                        'format'         => 'raw',
                        'value'          => function ($model) {
                            return Html::tag('span', Html::encode($model['Diag']), ['class' => 'badge-diag']);
                        },
                        'contentOptions' => ['style' => 'text-align:center;'],
                    ],

                    // สิทธิ์
                    [
                        'attribute'      => 'inscl',
                        'label'          => 'สิทธิ์',
                        'contentOptions' => ['class' => 'col-inscl'],
                    ],

                    // สถานะ ✅ หัวใจของการแสดงสี
                    [
                        'label'   => 'สถานะ',
                        'format'  => 'raw',
                        'value'   => function ($model) {
                            $isPassed = !empty($model['messagecode']);
                            if ($isPassed) {
                                return Html::tag('span',
                                    '<i class="fa fa-check-circle"></i> ' . Html::encode($model['messagecode']),
                                    ['class' => 'badge-pass']
                                );
                            }
                            return Html::tag('span',
                                '<i class="fa fa-times-circle"></i> รอส่ง',
                                ['class' => 'badge-wait']
                            );
                        },
                        'contentOptions' => ['style' => 'text-align:center;'],
                    ],

                    // สถานหลัก
                    [
                        'attribute'      => 'hospmain',
                        'label'          => 'สถานหลัก',
                        'contentOptions' => ['class' => 'col-hospmain'],
                    ],

                    // Authen (claimcode)
                    [
                        'attribute'      => 'claimcode',
                        'label'          => 'Authen',
                        'contentOptions' => ['class' => 'col-claim'],
                    ],

                    // ปิดสิทธิ์ (endpoint)
                    [
                        'attribute'      => 'endpoint',
                        'label'          => 'ปิดสิทธิ์',
                        'contentOptions' => ['class' => 'col-endpoint'],
                    ],
                ],
            ]) ?>
        </div>
    </div>

 
    <?= Html::endForm() ?>

</div><!-- /dash-wrapper -->

<!-- Floating Send Button -->
<div class="floating-send">
    <button type="submit" form="frmMain" name="btnButton1" id="selectAll">
        <i class="fa fa-arrow-circle-right"></i>
        ส่งข้อมูล TELEMED
    </button>
</div>

<script>
// Check All
document.addEventListener('DOMContentLoaded', function () {
    var checkAll = document.querySelector('input[name="CheckAll"]');
    if (checkAll) {
        checkAll.addEventListener('change', function () {
            document.querySelectorAll('input[name="chkDel[]"]')
                .forEach(el => el.checked = this.checked);
        });
    }
});

// Toggle sub-tables
['link1', 'link1b'].forEach(function(id) {
    document.getElementById(id)?.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('model1').style.display = 'block';
        document.getElementById('model2').style.display = 'none';
        document.getElementById('model1').scrollIntoView({ behavior: 'smooth' });
    });
});

document.getElementById('link2')?.addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('model1').style.display = 'none';
    document.getElementById('model2').style.display = 'block';
    document.getElementById('model2').scrollIntoView({ behavior: 'smooth' });
});

// Submit with row highlight animation
document.getElementById('frmMain')?.addEventListener('submit', function(event) {
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
        var row  = checked[i].closest('tr');
        var orig = row.style.background;
        row.style.background = 'rgba(16,185,129,0.35)';
        row.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(function() {
            row.style.background = orig;
            i++;
            highlight();
        }, 500);
    }
    highlight();
});

// Auto-hide alerts
setTimeout(function() {
    document.querySelectorAll('.alert').forEach(el => el.style.display = 'none');
}, 15000);
</script>