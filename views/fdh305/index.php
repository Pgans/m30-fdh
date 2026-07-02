<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'รายงาน C305 - ข้อมูลการอุทธรณ์ C305_FDH';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="fdh305-index">

    <h1 class="page-title"><i class="fa fa-file-text"></i> <?= Html::encode($this->title) ?></h1>

    <!-- จำนวนรายการ -->
    <div class="info-card">
        <i class="fa fa-database"></i>
        <strong>จำนวนข้อมูลทั้งหมด:</strong> <?= number_format($totalRecords) ?> รายการ
    </div>

    <!-- Flash Error -->
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert-flash error">
            <i class="fa fa-exclamation-circle"></i>
            <?= Html::encode(Yii::$app->session->getFlash('error')) ?>
        </div>
    <?php endif; ?>

    <div class="main-panel">
        <div class="panel-header">
            <h3 class="panel-title">
                <i class="fa fa-table"></i> รายการอุทธรณ์ C305-FDH
            </h3>
        </div>
        <div class="panel-body">

            <!-- Export Info -->
            <div class="export-info">
                <i class="fa fa-info-circle"></i>
                <strong>CSV ทั้งหมด</strong> — รายงานเต็มพร้อมหัวกระดาษ &nbsp;|&nbsp;
                <strong>Trans Reason</strong> — เฉพาะ <code>tran_id</code> + <code>reason</code> (2 คอลัมน์) &nbsp;|&nbsp;
                <strong>PDF</strong> — พร้อมพิมพ์ พร้อมลายเซ็น ผอ.<br>
                <small><i class="fa fa-check-circle"></i> ไฟล์ CSV เปิดใน Excel ได้ทันที (BOM UTF-8) — HN / CID ไม่ถูกตัด 0 นำหน้า</small>
            </div>

            <!-- ปุ่ม Export -->
            <p class="btn-group-wrap">
                <?= Html::a(
                    '<i class="fa fa-download"></i> ส่งออก CSV ทั้งหมด',
                    ['export'],
                    ['class' => 'btn-export btn-green']
                ) ?>
                <?= Html::a(
                    '<i class="fa fa-file-text-o"></i> ส่งออก Trans Reason',
                    ['export-trans-reason'],
                    ['class' => 'btn-export btn-purple']
                ) ?>
                <?= Html::a(
                    '<i class="fa fa-file-pdf-o"></i> ส่งออก PDF',
                    ['export-pdf'],
                    ['class' => 'btn-export btn-red']
                ) ?>
                <?= Html::a(
                    '<i class="fa fa-upload"></i> นำเข้าข้อมูล',
                    ['/patient-claim305/index'],
                    ['class' => 'btn-export btn-gray']
                ) ?>
                <?= Html::a(
                    '<i class="fa fa-refresh"></i> รีเฟรช',
                    ['index'],
                    ['class' => 'btn-export btn-light']
                ) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table modern-table'],
                'layout'       => "{summary}\n{items}\n{pager}",
                'columns'      => [

                    ['class' => 'yii\grid\SerialColumn', 'header' => 'ลำดับ'],

                    [
                        'attribute'     => 'trans_id',
                        'label'         => 'เลขอ้างอิงชื่อไฟล์',
                        'headerOptions' => ['style' => 'width:120px;'],
                    ],

                    [
                        'attribute'     => 'trans_id2',
                        'label'         => 'รหัสอ้างอิง SERVICE',
                        'headerOptions' => ['style' => 'width:180px;'],
                        'format'        => 'raw',
                        'value'         => function ($m) {
                            return '<span class="badge-service">' . Html::encode($m['trans_id2']) . '</span>';
                        },
                    ],

                    [
                        'attribute'     => 'cid',
                        'label'         => 'รหัสบัตรประชาชน',
                        'headerOptions' => ['style' => 'width:130px;'],
                    ],

                    [
                        'attribute'     => 'hn',
                        'label'         => 'HN',
                        'headerOptions' => ['style' => 'width:80px;text-align:center;'],
                        'contentOptions'=> ['style' => 'text-align:center;'],
                    ],

                    [
                        'attribute'     => 'regdate',
                        'label'         => 'วันที่รับบริการ',
                        'headerOptions' => ['style' => 'width:120px;'],
                        'format'        => 'raw',
                        'value'         => function ($m) {
                            if (empty($m['regdate'])) return '<span class="text-muted">-</span>';
                            return '<span class="date-cell"><i class="fa fa-calendar"></i> '
                                . Yii::$app->formatter->asDate($m['regdate'], 'php:d/m/Y')
                                . '</span>';
                        },
                    ],

                    [
                        'attribute'      => 'fullname',
                        'label'          => 'ชื่อ-สกุล',
                        'headerOptions'  => ['style' => 'width:160px;'],
                        'contentOptions' => ['style' => 'text-align:left;'],
                    ],

                    [
                        'attribute'     => 'reason',
                        'label'         => 'เหตุผล',
                        'headerOptions' => ['style' => 'min-width:280px;'],
                        'format'        => 'raw',
                        'value'         => function ($m) {
                            if (empty($m['reason'])) {
                                return '<span class="badge-empty">ไม่มีข้อมูล</span>';
                            }
                            $r    = $m['reason'];
                            $icon = 'fa-info-circle';
                            if (strpos($r, 'อินเตอร์เนต') !== false) $icon = 'fa-wifi';
                            elseif (strpos($r, 'นอกพื้นที่') !== false) $icon = 'fa-map-marker';
                            elseif (strpos($r, 'จำนวนมาก') !== false)  $icon = 'fa-users';
                            return '<div class="reason-box"><i class="fa ' . $icon . '"></i> '
                                . Html::encode($r) . '</div>';
                        },
                    ],

                    [
                        'attribute'     => 'dru_oper',
                        'label'         => 'ส่งผ่าน',
                        'headerOptions' => ['style' => 'width:180px;'],
                        'format'        => 'raw',
                        'value'         => function ($m) {
                            return empty($m['dru_oper'])
                                ? '<span class="text-muted">-</span>'
                                : '<strong>' . Html::encode($m['dru_oper']) . '</strong>';
                        },
                    ],

                    [
                        'attribute'     => 'c305',
                        'label'         => 'รหัสติด C',
                        'headerOptions' => ['style' => 'width:180px;'],
                        'format'        => 'raw',
                        'value'         => function ($m) {
                            return empty($m['c305'])
                                ? '<span class="text-muted">-</span>'
                                : '<strong>' . Html::encode($m['c305']) . '</strong>';
                        },
                    ],

                ],
            ]) ?>

        </div><!-- /.panel-body -->
    </div><!-- /.main-panel -->

    <!-- คำแนะนำ -->
    <div class="guide-card">
        <h4><i class="fa fa-lightbulb-o"></i> คำแนะนำการใช้งาน</h4>
        <ul>
            <li><strong>ส่งออก CSV ทั้งหมด:</strong> รายงานหลัก 9 คอลัมน์ พร้อมหัวกระดาษและเหตุผลอัตโนมัติ ชื่อไฟล์ <code>c305_oppp_YYYYMMDD_HHmmss.csv</code></li>
            <li><strong>ส่งออก Trans Reason:</strong> เฉพาะ <code>tran_id</code> และ <code>reason</code> (2 คอลัมน์) ชื่อไฟล์ <code>c305_oppp_trans_reason_YYYYMMDD.csv</code></li>
            <li><strong>ส่งออก PDF:</strong> ใช้ mPDF ติดตั้งครั้งเดียว: <code>composer require mpdf/mpdf</code></li>
            <li>คลิกหัวคอลัมน์เพื่อเรียงข้อมูล &nbsp;|&nbsp; แสดง <?= $dataProvider->pagination->pageSize ?> รายการ/หน้า</li>
        </ul>
    </div>

</div><!-- /.fdh305-index -->


<style>
/* ── Layout ─────────────────────────────────────── */
.fdh305-index   { padding: 8px 0; }
.page-title     { color: #4a90e2; font-weight: 600; font-size: 24px; margin-bottom: 20px; }
.page-title i   { margin-right: 10px; }

/* ── Info Card ──────────────────────────────────── */
.info-card {
    background: linear-gradient(135deg, #e0f7fa 0%, #b3e5fc 100%);
    border-radius: 12px;
    padding: 16px 22px;
    margin-bottom: 22px;
    color: #2c3e50;
    box-shadow: 0 2px 8px rgba(79,172,254,.15);
    font-size: 15px;
}
.info-card i { color: #4a90e2; margin-right: 8px; font-size: 18px; }

/* ── Flash ──────────────────────────────────────── */
.alert-flash { padding: 14px 18px; border-radius: 10px; margin-bottom: 18px; font-size: 14px; }
.alert-flash.error { background: #ffe4e4; border: 1px solid #f5a0a0; color: #b91c1c; }

/* ── Export Info ────────────────────────────────── */
.export-info {
    background: #f8f4ff;
    border: 1px solid #e0cfff;
    border-radius: 10px;
    padding: 13px 18px;
    margin-bottom: 18px;
    font-size: 13px;
    color: #5a3e8a;
    line-height: 1.8;
}
.export-info strong { color: #7c3aed; }
.export-info small  { color: #7c3aed; }

/* ── Main Panel ─────────────────────────────────── */
.main-panel     { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.08); overflow: hidden; margin-bottom: 24px; }
.panel-header   { background: linear-gradient(135deg, #e0f7fa 0%, #f0f9ff 100%); padding: 18px 24px; }
.panel-title    { color: #a515e8; font-size: 18px; font-weight: 600; margin: 0; }
.panel-title i  { margin-right: 8px; }
.panel-body     { padding: 22px; }

/* ── Buttons ────────────────────────────────────── */
.btn-group-wrap { margin-bottom: 18px; }
.btn-export {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 24px;
    font-size: 13.5px;
    font-weight: 500;
    text-decoration: none;
    margin: 0 8px 10px 0;
    box-shadow: 0 2px 6px rgba(0,0,0,.1);
    transition: all .25s ease;
    cursor: pointer;
}
.btn-export:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.18); text-decoration: none; }
.btn-green  { background: linear-gradient(135deg,#43e97b,#38f9d7); color: #155724; }
.btn-purple { background: linear-gradient(135deg,#ffe6fc,#c3cfe2); color: #a515e8; }
.btn-red    { background: linear-gradient(135deg,#ff6b6b,#ffa500); color: #fff; }
.btn-gray   { background: linear-gradient(135deg,#ffe6fc,#c3cfe2); color: #a515e8; }
.btn-light  { background: linear-gradient(135deg,#f5f7fa,#c3cfe2); color: #555; }

/* ── Table ──────────────────────────────────────── */
.modern-table { width: 100%; border-collapse: separate; border-spacing: 0; }
.modern-table th {
    background: linear-gradient(135deg,#e5cafc,#f0f9ff);
    color: #a515e8;
    font-weight: 600;
    text-align: center;
    vertical-align: middle !important;
    padding: 12px 10px;
    border: none;
    white-space: nowrap;
}
.modern-table td {
    vertical-align: middle !important;
    padding: 10px;
    border-bottom: 1px solid #e8f4f8;
    background: #fff;
}
.modern-table tbody tr:hover td { background: linear-gradient(135deg,#f0f9ff,#e0f2fe); }

/* ── Badges & Cells ─────────────────────────────── */
.badge-service {
    background: linear-gradient(135deg,#e0f7fa,#f0f9ff);
    color: #972ef2;
    padding: 5px 12px;
    border-radius: 18px;
    font-size: 12px;
    border: 1px solid #d9b3ff;
    display: inline-block;
}
.badge-empty {
    background: linear-gradient(135deg,#ffeaa7,#fdcb6e);
    color: #2d3436;
    padding: 5px 12px;
    border-radius: 18px;
    font-size: 12px;
    display: inline-block;
}
.reason-box {
    background: linear-gradient(135deg,#e0f7fa,#f0f9ff);
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 12.5px;
    line-height: 1.5;
    color: #2c3e50;
    border-left: 3px solid #4facfe;
}
.reason-box i { color: #4a90e2; margin-right: 5px; }
.date-cell    { color: #4a90e2; }
.date-cell i  { margin-right: 4px; }
.text-muted   { color: #95a5a6; }

/* ── Guide ──────────────────────────────────────── */
.guide-card { background: linear-gradient(135deg,#e8f5e9,#c8e6c9); border-radius: 12px; padding: 18px 22px; box-shadow: 0 2px 8px rgba(86,171,47,.15); }
.guide-card h4 { color: #2e7d32; font-weight: 600; margin: 0 0 10px; }
.guide-card h4 i { color: #66bb6a; margin-right: 6px; }
.guide-card ul { margin: 0; padding-left: 18px; color: #1b5e20; }
.guide-card li { margin-bottom: 7px; line-height: 1.6; font-size: 13px; }

@media(max-width:768px) {
    .btn-export { padding: 9px 16px; font-size: 12px; }
    .panel-body { padding: 14px; }
}
</style>