<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */
/* @var $totalRecords int */

$this->title = 'รายงาน C305 - ข้อมูลการอุทธรณ์ C305_KTP';
?>

<style>
:root {
    --light-gradient: linear-gradient(135deg, #e0f7fa 0%, #b3e5fc 100%);
}

/* ===== Info Card ===== */
.info-card {
    background: var(--light-gradient);
    border: none;
    border-radius: 12px;
    padding: 18px 24px;
    margin-bottom: 25px;
    color: #2c3e50;
    box-shadow: 0 2px 8px rgba(79,172,254,0.15);
}

/* ===== Main Panel ===== */
.main-panel {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    overflow: hidden;
    margin-bottom: 25px;
}
.panel-header {
    background: linear-gradient(135deg, #e0f7fa 0%, #f0f9ff 100%);
    padding: 20px 24px;
}
.panel-title {
    color: #a515e8;
    font-size: 18px;
    font-weight: 600;
    margin: 0;
}
.panel-body { padding: 24px; }

/* ===== ปุ่ม ===== */
.btn-modern {
    padding: 11px 22px;
    border-radius: 25px;
    border: none;
    font-weight: 500;
    font-size: 14px;
    transition: all 0.3s ease;
    display: inline-block;
    text-decoration: none;
    margin-right: 10px;
    margin-bottom: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    cursor: pointer;
}
.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.18);
    text-decoration: none;
}
.btn-export-all {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: #155724;
}
.btn-export-reason {
    background: linear-gradient(135deg, #ffe6fc 0%, #c3cfe2 100%);
    color: #a515e8;
}
.btn-export-pdf {
    background: linear-gradient(135deg, #ff6b6b 0%, #ffa500 100%);
    color: #fff;
    font-weight: 600;
}
.btn-refresh {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    color: #555;
}

/* ===== ตาราง ===== */
.modern-table { width: 100%; border-collapse: separate; border-spacing: 0; }
.modern-table th {
    background: linear-gradient(135deg, #e5cafc 0%, #f0f9ff 100%);
    color: #a515e8;
    font-weight: 600;
    text-align: center;
    vertical-align: middle !important;
    padding: 13px 12px;
    border: none;
    white-space: nowrap;
}
.modern-table td {
    vertical-align: middle !important;
    padding: 11px 12px;
    border-bottom: 1px solid #e8f4f8;
    background: white;
}
.modern-table tbody tr:hover td {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
}

/* ===== Badge / Label ===== */
.badge-modern {
    background: linear-gradient(135deg, #e0f7fa 0%, #f0f9ff 100%);
    color: #972ef2;
    padding: 5px 13px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    display: inline-block;
    border: 1px solid #d9b3ff;
}
.badge-empty {
    background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
    color: #2d3436;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    display: inline-block;
}
.badge-c305 {
    background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
    color: #c0392b;
    padding: 4px 11px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

/* ===== Reason Box ===== */
.reason-box {
    background: linear-gradient(135deg, #e0f7fa 0%, #f0f9ff 100%);
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 13px;
    line-height: 1.5;
    border-left: 3px solid #4facfe;
    color: #2c3e50;
}
.reason-box i { color: #4a90e2; margin-right: 5px; }

/* ===== Export Info Box ===== */
.export-info {
    background: #f8f4ff;
    border: 1px solid #e0cfff;
    border-radius: 10px;
    padding: 14px 18px;
    margin-bottom: 20px;
    font-size: 13px;
    color: #5a3e8a;
}
.export-info strong { color: #a515e8; }

/* ===== Alert Flash ===== */
.alert-flash {
    padding: 14px 18px;
    border-radius: 10px;
    margin-bottom: 20px;
    font-size: 14px;
}
.alert-flash.error {
    background: #ffe4e4;
    border: 1px solid #f5a0a0;
    color: #b91c1c;
}

/* ===== Guide Card ===== */
.guide-card {
    background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
    border-radius: 12px;
    padding: 20px 24px;
    box-shadow: 0 2px 8px rgba(86,171,47,0.15);
}
.guide-card h4 { color: #2e7d32; font-weight: 600; margin: 0 0 12px 0; }
.guide-card ul { margin: 0; padding-left: 20px; color: #1b5e20; }
.guide-card li { margin-bottom: 7px; line-height: 1.6; }

/* วันที่ */
.date-cell { color: #4a90e2; white-space: nowrap; }
.date-cell i { margin-right: 4px; }

/* ปุ่ม group */
.button-group { margin-bottom: 20px; }

@media (max-width: 768px) {
    .btn-modern { padding: 9px 16px; font-size: 13px; }
    .panel-body { padding: 14px; }
}
</style>

<div class="ktp305-index">

    <!-- ===== Flash Error ===== -->
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert-flash error">
            <i class="fas fa-exclamation-circle"></i>
            <?= Html::encode(Yii::$app->session->getFlash('error')) ?>
        </div>
    <?php endif; ?>

    <!-- ===== Info Card ===== -->
    <div class="info-card">
        <h3 style="margin:0 0 8px 0;">
            <i class="fas fa-file-medical"></i>
            <?= Html::encode($this->title) ?>
        </h3>
        <p style="margin:0; opacity:.9;">
            <i class="fas fa-database"></i>
            ข้อมูลทั้งหมด: <strong><?= number_format($totalRecords) ?></strong> รายการ
        </p>
    </div>

    <!-- ===== Main Panel ===== -->
    <div class="main-panel">
        <div class="panel-header">
            <h4 class="panel-title">
                <i class="fas fa-list-alt"></i>
                รายการผู้ป่วยที่ไม่ได้ทำ Authen
            </h4>
        </div>

        <div class="panel-body">

            <!-- Export Info -->
            <div class="export-info">
                <i class="fas fa-info-circle"></i>
                <strong>ส่งออก CSV ทั้งหมด</strong> — รายงานเต็ม พร้อมหัวกระดาษ / ชื่อโรงพยาบาล / เหตุผลอัตโนมัติ
                &nbsp;|&nbsp;
                <strong>ส่งออก Trans Reason</strong> — เฉพาะ <code>tran_id</code> และ <code>reason</code> (2 คอลัมน์)
                &nbsp;|&nbsp;
                <strong>ส่งออก PDF</strong> — รายงานหน้าพิมพ์ หัวตาราง repeat ทุกหน้า + ลายเซ็น ผอ.
                <br>
                <small style="color:#7c3aed;">
                    <i class="fas fa-check-circle"></i>
                    PDF ใช้ <strong>mPDF (PHP)</strong> — ไม่ต้องติดตั้ง Python
                </small>
            </div>

            <!-- ปุ่ม Export + Refresh -->
            <div class="button-group">
                <?= Html::a(
                    '<i class="fas fa-file-csv"></i> ส่งออก CSV ทั้งหมด',
                    ['export'],
                    ['class' => 'btn-modern btn-export-all']
                ) ?>

                <?= Html::a(
                    '<i class="fas fa-file-export"></i> ส่งออก Trans Reason',
                    ['export-trans-reason'],
                    ['class' => 'btn-modern btn-export-reason']
                ) ?>

                <?= Html::a(
                    '<i class="fas fa-file-pdf"></i> ส่งออก PDF',
                    ['export-pdf'],
                    ['class' => 'btn-modern btn-export-pdf']
                ) ?>
				
				 <?= Html::a(
                    '<i class="fa fa-upload"></i> นำเข้าข้อมูล',
                    ['/ktp-c305-hn/import'],
                    ['class' => 'btn-modern btn-refresh']
                ) ?>
                <?= Html::a(
                    '<i class="fas fa-sync-alt"></i> รีเฟรช',
                    ['index'],
                    ['class' => 'btn-modern btn-refresh']
                ) ?>
            </div>

            <!-- ===== GridView ===== -->
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'modern-table table table-bordered'],
                'columns'      => [

                    // ลำดับ
                    [
                        'class'          => 'yii\grid\SerialColumn',
                        'header'         => '#',
                        'headerOptions'  => ['style' => 'width:50px; text-align:center;'],
                        'contentOptions' => ['style' => 'text-align:center;'],
                    ],

                    // เลขอ้างอิงชื่อไฟล์
                    [
                        'attribute'      => 'rep',
                        'label'          => 'เลขอ้างอิง<br>ชื่อไฟล์',
                        'format'         => 'raw',
                        'encodeLabel'    => false,
                        'headerOptions'  => ['style' => 'width:130px; text-align:center;'],
                        'contentOptions' => ['style' => 'text-align:center; font-size:12px;'],
                    ],

                    // Trans_ID
                    [
                        'attribute'      => 'tran_id2',
                        'label'          => 'Trans_ID',
                        'format'         => 'raw',
                        'value'          => function ($model) {
                            $val = trim($model['tran_id2'] ?? '');
                            if ($val === '') return '<span class="text-muted">-</span>';
                            return '<span class="badge-modern">' . Html::encode($val) . '</span>';
                        },
                        'headerOptions'  => ['style' => 'width:140px; text-align:center;'],
                        'contentOptions' => ['style' => 'text-align:center;'],
                    ],

                    // เลขบัตรประชาชน
                    [
                        'attribute'      => 'pid',
                        'label'          => 'เลขบัตร<br>ประชาชน',
                        'encodeLabel'    => false,
                        'headerOptions'  => ['style' => 'width:135px; text-align:center;'],
                        'contentOptions' => ['style' => 'text-align:center; font-family:monospace;'],
                    ],

                    // HN 6 หลัก
                    [
                        'attribute'      => 'hn',
                        'label'          => 'HN',
                        'format'         => 'raw',
                        'value'          => function ($model) {
                            $hn = trim($model['hn'] ?? '');
                            if ($hn !== '') {
                                $hn = str_pad(preg_replace('/\D/', '', $hn), 6, '0', STR_PAD_LEFT);
                                return '<span style="font-family:monospace;">' . Html::encode($hn) . '</span>';
                            }
                            return '<span class="text-muted">-</span>';
                        },
                        'headerOptions'  => ['style' => 'width:80px; text-align:center;'],
                        'contentOptions' => ['style' => 'text-align:center;'],
                    ],

                    // วันที่รับบริการ (รองรับ d/m/Y พ.ศ. และ Y-m-d ค.ศ.)
                    [
                        'attribute'      => 'regdate',
                        'label'          => 'วันที่รับบริการ',
                        'format'         => 'raw',
                        'value'          => function ($model) {
                            $d = trim($model['regdate'] ?? '');
                            if (empty($d)) return '<span class="text-muted">-</span>';

                            // กรณี d/m/Y (พ.ศ.)
                            $parts = explode('/', $d);
                            if (count($parts) === 3) {
                                $day    = $parts[0];
                                $month  = $parts[1];
                                $yearBE = (int)$parts[2];
                                $yearAD = $yearBE - 543;
                                $dateStr = $yearAD . '-' . $month . '-' . $day;
                                if (strtotime($dateStr)) {
                                    return '<span class="date-cell">
                                        <i class="fas fa-calendar-alt"></i> '
                                        . Yii::$app->formatter->asDate($dateStr, 'php:d/m/Y')
                                    . '</span>';
                                }
                            }

                            // กรณี Y-m-d (ค.ศ.)
                            if (strtotime($d)) {
                                return '<span class="date-cell">
                                    <i class="fas fa-calendar-alt"></i> '
                                    . date('d/m/Y', strtotime($d))
                                . '</span>';
                            }

                            return '<span class="text-danger">รูปแบบวันที่ผิด</span>';
                        },
                        'headerOptions'  => ['style' => 'width:120px; text-align:center;'],
                        'contentOptions' => ['style' => 'text-align:center;'],
                    ],

                    // ชื่อ-สกุล
                    [
                        'attribute'      => 'fullname',
                        'label'          => 'ชื่อ-สกุล',
                        'headerOptions'  => ['style' => 'min-width:160px;'],
                        'contentOptions' => ['style' => 'text-align:left;'],
                    ],

                    // รายการติด (c305)
                    [
                        'attribute'      => 'c305',
                        'label'          => 'รายการติด',
                        'format'         => 'raw',
                        'value'          => function ($model) {
                            $val = trim($model['c305'] ?? '');
                            if ($val === '') return '<span class="text-muted">-</span>';
                            return '<span class="badge-c305">' . Html::encode($val) . '</span>';
                        },
                        'headerOptions'  => ['style' => 'width:90px; text-align:center;'],
                        'contentOptions' => ['style' => 'text-align:center;'],
                    ],

                    // เหตุผล
                    [
                        'attribute'      => 'reason',
                        'label'          => 'เหตุผล',
                        'format'         => 'raw',
                        'value'          => function ($model) {
                            $r = trim($model['reason'] ?? '');
                            if (!empty($r)) {
                                return '<div class="reason-box">
                                    <i class="fas fa-comment-dots"></i> '
                                    . Html::encode($r)
                                . '</div>';
                            }
                            return '<span class="badge-empty">
                                <i class="fas fa-exclamation-circle"></i> ยังไม่ระบุเหตุผล
                            </span>';
                        },
                        'headerOptions'  => ['style' => 'min-width:250px;'],
                    ],

                ],
                'pager' => [
                    'options'              => ['class' => 'pagination'],
                    'prevPageLabel'        => '<i class="fas fa-chevron-left"></i> ก่อนหน้า',
                    'nextPageLabel'        => 'ถัดไป <i class="fas fa-chevron-right"></i>',
                    'activePageCssClass'   => 'active',
                    'disabledPageCssClass' => 'disabled',
                ],
            ]); ?>

        </div><!-- /.panel-body -->
    </div><!-- /.main-panel -->

    <!-- ===== คำแนะนำการใช้งาน ===== -->
    <div class="guide-card">
        <h4>
            <i class="fas fa-info-circle" style="color:#66bb6a; margin-right:6px;"></i>
            คำแนะนำการใช้งาน
        </h4>
        <ul>
            <li>
                <strong>ส่งออก CSV ทั้งหมด:</strong>
                รายงานหลักพร้อมหัวกระดาษ ชื่อโรงพยาบาล และเหตุผลอัตโนมัติ
                ชื่อไฟล์ <code>c305_report_YYYYMMDD_HHiiss.csv</code>
            </li>
            <li>
                <strong>ส่งออก Trans Reason:</strong>
                ดึงจาก KTP_C305 + KTP_C305_HN + cid_hn เฉพาะ <code>tran_id</code> และ <code>reason</code>
                ชื่อไฟล์ <code>c305_trans_reason_YYYYMMDD_HHiiss.csv</code>
            </li>
            <li>
                <strong>ส่งออก PDF:</strong>
                ใช้ <strong>mPDF (PHP ล้วน)</strong> ไม่ต้องติดตั้ง Python
                — หัวคอลัมน์ซ้ำทุกหน้า, มีสรุปจำนวน และลายเซ็นผู้อำนวยการ
                <br>
                <small style="color:#666;">ติดตั้งครั้งเดียว: <code>composer require mpdf/mpdf</code></small>
            </li>
            <li>
                <strong>รองรับภาษาไทย:</strong> ทั้ง CSV ใช้ BOM UTF-8 เปิดใน Excel ได้ทันที
            </li>
            <li>
                <strong>HN:</strong> เติม 0 ข้างหน้าครบ 6 หลัก &nbsp;|&nbsp;
                <strong>CID:</strong> ป้องกัน Excel แปลงเป็นเลขยกกำลัง
            </li>
            <li>
                <strong>วันที่:</strong> รองรับทั้งรูปแบบ <code>d/m/Y</code> (พ.ศ.) และ <code>Y-m-d</code> (ค.ศ.) อัตโนมัติ
            </li>
        </ul>
    </div>

</div><!-- /.ktp305-index -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">