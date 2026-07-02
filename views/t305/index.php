<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'รายงาน C305 - ข้อมูลการอุทธรณ์ C305_oppp';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="t305-index">
    <h1 style="color: #4a90e2; font-weight: 600;"><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-12">
            <div class="info-card">
                <i class="fa fa-database"></i>
                <strong>จำนวนข้อมูลทั้งหมด:</strong> <?= number_format($totalRecords) ?> รายการ
            </div>
        </div>
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
                <i class="fa fa-table"></i> รายการอุทธรณ์ C305-OPPP
            </h3>
        </div>
        <div class="panel-body">

            <!-- Export Info -->
            <div class="export-info">
                <i class="fa fa-info-circle"></i>
                <strong>ส่งออก CSV ทั้งหมด</strong> — รายงานเต็ม พร้อมหัวกระดาษ ชื่อโรงพยาบาล เหตุผลอัตโนมัติ
                &nbsp;|&nbsp;
                <strong>ส่งออก Trans Reason</strong> — เฉพาะ <code>tran_id</code> และ <code>reason</code>
                &nbsp;|&nbsp;
                <strong>ส่งออก PDF</strong> — รายงานพร้อมพิมพ์ ลายเซ็น ผอ.
                <br>
                <small style="color:#7c3aed;">
                    <i class="fa fa-check-circle"></i>
                    PDF ใช้ <strong>mPDF (PHP)</strong> — ไม่ต้องติดตั้ง Python
                </small>
            </div>

            <!-- ปุ่ม -->
            <p class="button-group">
                <?= Html::a(
                    '<i class="fa fa-download"></i> ส่งออก CSV ทั้งหมด',
                    ['export'],
                    ['class' => 'btn-modern btn-export-all']
                ) ?>

                <?= Html::a(
                    '<i class="fa fa-file-text-o"></i> ส่งออก Trans Reason',
                    ['export-trans-reason'],
                    ['class' => 'btn-modern btn-export-reason']
                ) ?>

                <?= Html::a(
                    '<i class="fa fa-file-pdf-o"></i> ส่งออก PDF',
                    ['export-pdf'],
                    ['class' => 'btn-modern btn-export-pdf']
                ) ?>

                <?= Html::a(
                    '<i class="fa fa-bar-chart"></i> ดูสถิติ',
                    ['statistics'],
                    ['class' => 'btn-modern btn-secondary']
                ) ?>

                <?= Html::a(
                    '<i class="fa fa-upload"></i> นำเข้าข้อมูล',
                    ['/oppp/index'],
                    ['class' => 'btn-modern btn-secondary', 'encode' => false]
                ) ?>

                <?= Html::a(
                    '<i class="fa fa-refresh"></i> รีเฟรช',
                    ['index'],
                    ['class' => 'btn-modern btn-light']
                ) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table modern-table'],
                'layout'       => "{summary}\n{items}\n{pager}",
                'columns'      => [

                    [
                        'class'  => 'yii\grid\SerialColumn',
                        'header' => 'ลำดับ',
                    ],

                    [
                        'attribute'     => 'trans_id',
                        'label'         => 'เลขอ้างอิงชื่อไฟล์',
                        'headerOptions' => ['style' => 'width: 120px;'],
                    ],

                    [
                        'attribute'     => 'trans_id2',
                        'label'         => 'รหัสอ้างอิง SERVICE',
                        'headerOptions' => ['style' => 'width: 180px;'],
                        'format'        => 'raw',
                        'value'         => function ($model) {
                            return '<span class="badge-modern">' . Html::encode($model['trans_id2']) . '</span>';
                        },
                    ],

                    [
                        'attribute'     => 'cid',
                        'label'         => 'รหัสบัตรประชาชน',
                        'headerOptions' => ['style' => 'width: 130px;'],
                    ],

                    [
                        'attribute'     => 'hn',
                        'label'         => 'HN',
                        'headerOptions' => ['style' => 'width: 80px;'],
                    ],

                    [
                        'attribute'     => 'regdate',
                        'label'         => 'วันที่รับบริการ',
                        'headerOptions' => ['style' => 'width: 120px;'],
                        'format'        => 'raw',
                        'value'         => function ($model) {
                            if (empty($model['regdate'])) {
                                return '<span class="text-muted">-</span>';
                            }
                            return '<span style="color:#4a90e2;"><i class="fa fa-calendar"></i> '
                                . Yii::$app->formatter->asDate($model['regdate'], 'php:d/m/Y')
                                . '</span>';
                        },
                    ],

                    [
                        'attribute'      => 'fullname',
                        'label'          => 'ชื่อ-สกุล',
                        'headerOptions'  => ['style' => 'width: 150px; text-align: left;'],
                        'contentOptions' => ['style' => 'text-align: left;'],
                        'encodeLabel'    => false,
                    ],

                    [
                        'attribute'     => 'reason',
                        'label'         => 'เหตุผล',
                        'headerOptions' => ['style' => 'min-width: 300px;'],
                        'format'        => 'raw',
                        'value'         => function ($model) {
                            if (empty($model['reason'])) {
                                return '<span class="badge-empty">ไม่มีข้อมูล</span>';
                            }
                            $reason = $model['reason'];
                            $icon   = 'fa-info-circle';
                            if (strpos($reason, 'อินเตอร์เนต') !== false) $icon = 'fa-wifi';
                            elseif (strpos($reason, 'นอกพื้นที่') !== false) $icon = 'fa-map-marker';
                            elseif (strpos($reason, 'จำนวนมาก') !== false) $icon = 'fa-users';
                            return '<div class="reason-box">
                                        <i class="fa ' . $icon . '"></i> '
                                . Html::encode($reason)
                                . '</div>';
                        },
                    ],

                    [
                        'attribute'     => 'dru_oper',
                        'label'         => 'ยาที่จ่าย',
                        'headerOptions' => ['style' => 'width: 200px;'],
                        'format'        => 'raw',
                        'value'         => function ($model) {
                            if (empty($model['dru_oper'])) {
                                return '<span class="text-muted">-</span>';
                            }
                            return '<strong style="color:#2c3e50;">' . Html::encode($model['dru_oper']) . '</strong>';
                        },
                    ],

                    [
                        'attribute'     => 'c305',
                        'label'         => 'TT305',
                        'headerOptions' => ['style' => 'width: 200px;'],
                        'format'        => 'raw',
                        'value'         => function ($model) {
                            if (empty($model['c305'])) {
                                return '<span class="text-muted">-</span>';
                            }
                            return '<strong style="color:#2c3e50;">' . Html::encode($model['c305']) . '</strong>';
                        },
                    ],

                ],
            ]); ?>

        </div>
    </div>

    <div class="guide-card">
        <h4><i class="fa fa-lightbulb-o"></i> คำแนะนำการใช้งาน</h4>
        <ul>
            <li><strong>ส่งออก CSV ทั้งหมด:</strong> รายงานหลักพร้อมหัวกระดาษและเหตุผลอัตโนมัติ ชื่อไฟล์ <code>c305_oppp_YYYYMMDD.csv</code></li>
            <li><strong>ส่งออก Trans Reason:</strong> เฉพาะ <code>tran_id</code> และ <code>reason</code> (2 คอลัมน์) ชื่อไฟล์ <code>c305_oppp_trans_reason_YYYYMMDD.csv</code></li>
            <li><strong>ส่งออก PDF:</strong> ใช้ mPDF (PHP ล้วน) หัวคอลัมน์ซ้ำทุกหน้า มีสรุปจำนวนและลายเซ็น ผอ. <br><small>ติดตั้งครั้งเดียว: <code>composer require mpdf/mpdf</code></small></li>
            <li>คลิกที่หัวคอลัมน์เพื่อเรียงลำดับข้อมูล</li>
            <li>ข้อมูลแสดง <?= $dataProvider->pagination->pageSize ?> รายการต่อหน้า</li>
        </ul>
    </div>

</div>

<style>
:root {
    --light-gradient: linear-gradient(135deg, #e0f7fa 0%, #b3e5fc 100%);
}

.info-card {
    background: var(--light-gradient);
    border: none;
    border-radius: 12px;
    padding: 18px 24px;
    margin-bottom: 25px;
    color: #2c3e50;
    box-shadow: 0 2px 8px rgba(79,172,254,0.15);
}
.info-card i { color: #4a90e2; margin-right: 8px; font-size: 18px; }

/* Alert Flash */
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

/* Export Info */
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

/* Main Panel */
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
.panel-title { color: #a515e8; font-size: 18px; font-weight: 600; margin: 0; }
.panel-title i { margin-right: 10px; }
.panel-body { padding: 24px; }

/* ปุ่ม */
.button-group { margin-bottom: 20px; }
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
/* ปุ่ม CSV ทั้งหมด — เขียว */
.btn-export-all {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: #155724;
}
/* ปุ่ม Trans Reason — ม่วง */
.btn-export-reason {
    background: linear-gradient(135deg, #ffe6fc 0%, #c3cfe2 100%);
    color: #a515e8;
}
/* ปุ่ม PDF — แดง-ส้ม */
.btn-export-pdf {
    background: linear-gradient(135deg, #ff6b6b 0%, #ffa500 100%);
    color: #fff;
    font-weight: 600;
}
.btn-secondary {
    background: linear-gradient(135deg, #ffe6fc 0%, #c3cfe2 100%);
    color: #a515e8;
}
.btn-light {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    color: #555;
}

/* ตาราง */
.modern-table { width: 100%; border-collapse: separate; border-spacing: 0; }
.modern-table th {
    background: linear-gradient(135deg, #e5cafc 0%, #f0f9ff 100%);
    color: #a515e8;
    font-weight: 600;
    text-align: center;
    vertical-align: middle !important;
    padding: 14px 12px;
    border: none;
}
.modern-table td {
    vertical-align: middle !important;
    padding: 12px;
    border-bottom: 1px solid #e8f4f8;
    background: white;
}
.modern-table tbody tr:hover td {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
}

/* Badge */
.badge-modern {
    background: linear-gradient(135deg, #e0f7fa 0%, #f0f9ff 100%);
    color: #972ef2;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    display: inline-block;
    border: 1px solid #d9b3ff;
}
.badge-empty {
    background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
    color: #2d3436;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    display: inline-block;
}
.reason-box {
    background: linear-gradient(135deg, #e0f7fa 0%, #f0f9ff 100%);
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 13px;
    line-height: 1.5;
    color: #2c3e50;
    border-left: 3px solid #4facfe;
}
.reason-box i { color: #4a90e2; margin-right: 6px; }

/* Guide */
.guide-card {
    background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
    border-radius: 12px;
    padding: 20px 24px;
    box-shadow: 0 2px 8px rgba(86,171,47,0.15);
}
.guide-card h4 { color: #2e7d32; font-weight: 600; margin: 0 0 12px 0; }
.guide-card h4 i { color: #66bb6a; margin-right: 8px; }
.guide-card ul { margin: 0; padding-left: 20px; color: #1b5e20; }
.guide-card li { margin-bottom: 8px; line-height: 1.6; }

.text-muted { color: #95a5a6; }

@media (max-width: 768px) {
    .btn-modern { margin-bottom: 10px; padding: 10px 18px; font-size: 13px; }
    .panel-body { padding: 16px; }
}
</style>