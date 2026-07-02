<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$this->title = 'รายงานผู้ป่วย Thalassemia(D569)';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="d569-index" style="background: linear-gradient(135deg, #f3e5f9 0%, #e1f5fe 50%, #e8f5e9 100%); min-height: 100vh; padding: 20px;">
    <h1 style="color: #5e35b1; text-shadow: 0 4px 15px rgba(142, 197, 252, 0.5); font-weight: 700; text-align: center; margin-bottom: 30px;"><?= Html::encode($this->title) ?></h1>
    
    <!-- ฟอร์มค้นหา -->
    <div class="panel panel-primary glass-panel">
        <div class="panel-heading glass-header">
            <h3 class="panel-title" style="color: #5e35b1; font-weight: 600; text-shadow: 0 2px 10px rgba(142, 197, 252, 0.3);">เงื่อนไขการค้นหา</h3>
        </div>
        <div class="panel-body glass-body">
            <?php $form = ActiveForm::begin(['method' => 'get', 'action' => ['index']]); ?>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="color: #4a148c; font-weight: 600; text-shadow: 0 2px 5px rgba(255, 255, 255, 0.5);">วันที่เริ่มต้น</label>
                        <?= Html::input('date', 'start_date', $startDate, ['class' => 'form-control glass-input']) ?>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="color: #4a148c; font-weight: 600; text-shadow: 0 2px 5px rgba(255, 255, 255, 0.5);">วันที่สิ้นสุด</label>
                        <?= Html::input('date', 'end_date', $endDate, ['class' => 'form-control glass-input']) ?>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="color: #4a148c; font-weight: 600; text-shadow: 0 2px 5px rgba(255, 255, 255, 0.5);">รหัส ICD10</label>
                        <?= Html::input('text', 'icd_code', $icdCode, ['class' => 'form-control glass-input', 'placeholder' => 'เช่น D569']) ?>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label><br>
                        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> ค้นหา', ['class' => 'btn btn-primary glass-button', 'name' => 'search', 'value' => '1']) ?>
                        
                        <?php if (Yii::$app->request->get('search')): ?>
                            <?= Html::a('<i class="glyphicon glyphicon-export"></i> ส่งออก Excel', ['export', 'start_date' => $startDate, 'end_date' => $endDate, 'icd_code' => $icdCode], ['class' => 'btn btn-success glass-button-success', 'target' => '_blank']) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    
    <!-- ตารางแสดงผล -->
    <?php if (Yii::$app->request->get('search')): ?>
        <?php if ($dataProvider->getTotalCount() > 0): ?>
            <div class="glass-alert glass-alert-success">
                <strong>ผลการค้นหา:</strong> พบข้อมูล <?= number_format($dataProvider->getTotalCount()) ?> รายการ
            </div>
            
            <div class="glass-table-container">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-striped table-bordered table-hover glass-table'],
                'layout' => "{items}\n{summary}\n{pager}",
                'columns' => [
                    ['attribute' => 'No', 'label' => 'ลำดับ', 'headerOptions' => ['style' => 'width: 60px; text-align: center;'], 'contentOptions' => ['style' => 'text-align: center;']],
                    ['attribute' => 'regdate', 'label' => 'วันที่ลงทะเบียน', 'headerOptions' => ['style' => 'width: 130px;']],
                    ['attribute' => 'hn', 'label' => 'HN', 'headerOptions' => ['style' => 'width: 100px;']],
					[
    'attribute' => 'an',
    'label' => 'AN',
    'format' => 'raw',
    'headerOptions' => [
        'style' => 'width:100px;text-align:center;'
    ],
    'contentOptions' => [
        'style' => 'text-align:center;'
    ],
    'value' => function ($model) {
        if (empty($model['an'])) {
            return '';
        }
        return '<span style="
            display:inline-block;
            padding:4px 12px;
            border-radius:20px;
            border:2px solid #43a047;
            color:#2e7d32;
            font-weight:bold;
            background:#e8f5e9;
            min-width:48px;
            text-align:center;
        ">'.$model['an'].'</span>';
    },
],



                    ['attribute' => 'fullname', 'label' => 'ชื่อ-สกุล', 'headerOptions' => ['style' => 'width: 200px;']],
                    ['attribute' => 'age', 'label' => 'อายุ', 'headerOptions' => ['style' => 'width: 60px; text-align: center;'], 'contentOptions' => ['style' => 'text-align: center;']],
                    ['attribute' => 'cid', 'label' => 'เลขบัตรประชาชน', 'headerOptions' => ['style' => 'width: 130px;']],
                    ['attribute' => 'Diagx', 'label' => 'วินิจฉัยหลัก', 'headerOptions' => ['style' => 'width: 100px;']],
                    ['attribute' => 'Diag', 'label' => 'วินิจฉัยรอง', 'format' => 'raw', 'value' => function($model) { $diag = $model['Diag'] ?? ''; if (empty($diag)) { return '<span class="text-muted">-</span>'; } return Html::tag('div', $diag, ['style' => 'max-height: 100px; overflow-y: auto;']); }],
                    ['attribute' => 'unit_name', 'label' => 'หน่วยงาน', 'headerOptions' => ['style' => 'width: 100px;']],
                    ['attribute' => 'inscl', 'label' => 'สิทธิ', 'headerOptions' => ['style' => 'width: 120px;']],
                    ['attribute' => 'hospmain', 'label' => 'รพ.หลัก', 'headerOptions' => ['style' => 'width: 150px;']],
                    ['attribute' => 'claimcode', 'label' => 'ยืนยันตัวตน', 'headerOptions' => ['style' => 'width:150px; text-align:center; font-weight:bold;'], 'contentOptions' => ['style' => 'color:#ff6b6b; font-weight:bold; text-align:center;']],
                    ['attribute' => 'amount', 'label' => 'ค่าใช้จ่าย', 'headerOptions' => ['style' => 'width: 100px; text-align: right;'], 'contentOptions' => ['style' => 'text-align: right;'], 'value' => function($model) { return number_format($model['amount'] ?? 0, 2); }],
                ],
            ]); ?>
            </div>
        <?php else: ?>
            <div class="glass-alert glass-alert-warning">
                <i class="glyphicon glyphicon-warning-sign"></i> ไม่พบข้อมูลตามเงื่อนไขที่ค้นหา
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="glass-alert glass-alert-info">
            <i class="glyphicon glyphicon-info-sign"></i> กรุณาเลือกเงื่อนไขการค้นหาและกดปุ่ม "ค้นหา"
        </div>
    <?php endif; ?>
    
    <div class="glass-alert glass-alert-note">
        <strong>หมายเหตุ:</strong>
        <ul style="margin-bottom: 0; color: #4a148c;">
            <li>รายงานนี้แสดงข้อมูลผู้ป่วยนอกที่มีวินิจฉัยตามรหัส ICD10 ที่กำหนด</li>
            <li>วินิจฉัยหลัก (Diagx) คือวินิจฉัยหลักของการมารับบริการ</li>
            <li>วินิจฉัยรอง (Diag) คือวินิจฉัยเพิ่มเติมทั้งหมดที่เกี่ยวข้อง</li>
            <li>ไม่แสดงผู้ป่วยที่เข้ารับบริการเป็นผู้ป่วยในหรือผ่าน Mobile App</li>
        </ul>
    </div>
</div>

<style>
/* Glassmorphism Base - Light Theme */
body { margin: 0; padding: 0; }
.d569-index { background: linear-gradient(135deg, #f3e5f9 0%, #e1f5fe 50%, #e8f5e9 100%); min-height: 100vh; }

/* Glass Panel - Lighter */
.glass-panel { background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border-radius: 20px; border: 2px solid rgba(255, 255, 255, 0.8); box-shadow: 0 8px 32px 0 rgba(142, 197, 252, 0.4), inset 0 0 20px rgba(255, 255, 255, 0.5); margin-bottom: 30px; }
.glass-header { background: linear-gradient(135deg, rgba(224, 195, 252, 0.5) 0%, rgba(142, 197, 252, 0.5) 100%); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border-radius: 20px 20px 0 0; border: none; padding: 15px 20px; border-bottom: 2px solid rgba(255, 255, 255, 0.6); box-shadow: 0 4px 15px rgba(142, 197, 252, 0.3); }
.glass-body { padding: 25px; }

/* Glass Input - Lighter */
.glass-input { background: rgba(255, 255, 255, 0.7) !important; backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); border: 2px solid rgba(142, 197, 252, 0.5) !important; border-radius: 10px !important; color: #4a148c !important; padding: 10px 15px !important; box-shadow: inset 0 2px 10px rgba(142, 197, 252, 0.2); }
.glass-input::placeholder { color: rgba(94, 53, 177, 0.5); }
.glass-input:focus { background: rgba(255, 255, 255, 0.9) !important; border: 2px solid rgba(142, 197, 252, 0.8) !important; outline: none; box-shadow: 0 0 20px rgba(142, 197, 252, 0.5), inset 0 2px 10px rgba(142, 197, 252, 0.3); }

/* Glass Buttons - Lighter */
.glass-button { background: linear-gradient(135deg, rgba(224, 195, 252, 0.7) 0%, rgba(142, 197, 252, 0.7) 100%) !important; backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); border: 2px solid rgba(255, 255, 255, 0.8) !important; border-radius: 10px !important; color: #4a148c !important; padding: 10px 25px !important; font-weight: 600; transition: all 0.3s; box-shadow: 0 4px 15px rgba(142, 197, 252, 0.4), inset 0 0 15px rgba(255, 255, 255, 0.5); }
.glass-button:hover { background: linear-gradient(135deg, rgba(224, 195, 252, 0.9) 0%, rgba(142, 197, 252, 0.9) 100%) !important; transform: translateY(-2px); box-shadow: 0 6px 25px rgba(142, 197, 252, 0.6), inset 0 0 20px rgba(255, 255, 255, 0.7); }
.glass-button-success { background: linear-gradient(135deg, rgba(184, 245, 205, 0.7) 0%, rgba(102, 187, 106, 0.7) 100%) !important; backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); border: 2px solid rgba(255, 255, 255, 0.8) !important; border-radius: 10px !important; color: #1b5e20 !important; padding: 10px 25px !important; font-weight: 600; transition: all 0.3s; box-shadow: 0 4px 15px rgba(102, 187, 106, 0.4), inset 0 0 15px rgba(255, 255, 255, 0.5); }
.glass-button-success:hover { background: linear-gradient(135deg, rgba(184, 245, 205, 0.9) 0%, rgba(102, 187, 106, 0.9) 100%) !important; transform: translateY(-2px); box-shadow: 0 6px 25px rgba(102, 187, 106, 0.6), inset 0 0 20px rgba(255, 255, 255, 0.7); }

/* Glass Alerts - Lighter */
.glass-alert { background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border-radius: 15px; border: 2px solid rgba(255, 255, 255, 0.8); padding: 15px 20px; margin-bottom: 20px; color: #4a148c; font-weight: 500; box-shadow: 0 4px 20px rgba(142, 197, 252, 0.3), inset 0 0 15px rgba(255, 255, 255, 0.5); }
.glass-alert-success { background: rgba(184, 245, 205, 0.6); border: 2px solid rgba(129, 199, 132, 0.6); color: #1b5e20; box-shadow: 0 4px 20px rgba(102, 187, 106, 0.3), inset 0 0 15px rgba(255, 255, 255, 0.5); }
.glass-alert-warning { background: rgba(255, 224, 178, 0.6); border: 2px solid rgba(255, 183, 77, 0.6); color: #e65100; box-shadow: 0 4px 20px rgba(255, 152, 0, 0.3), inset 0 0 15px rgba(255, 255, 255, 0.5); }
.glass-alert-info { background: rgba(179, 229, 252, 0.6); border: 2px solid rgba(129, 212, 250, 0.6); color: #01579b; box-shadow: 0 4px 20px rgba(3, 169, 244, 0.3), inset 0 0 15px rgba(255, 255, 255, 0.5); }
.glass-alert-note { background: rgba(225, 190, 231, 0.6); border: 2px solid rgba(206, 147, 216, 0.6); color: #4a148c; box-shadow: 0 4px 20px rgba(156, 39, 176, 0.3), inset 0 0 15px rgba(255, 255, 255, 0.5); }

/* Glass Table Container - Lighter */
.glass-table-container { background: rgba(255, 255, 255, 0.5); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border-radius: 20px; border: 2px solid rgba(255, 255, 255, 0.8); padding: 20px; box-shadow: 0 8px 32px 0 rgba(142, 197, 252, 0.4), inset 0 0 20px rgba(255, 255, 255, 0.5); margin-bottom: 30px; overflow: hidden; }

/* Glass Table - Lighter with reflective effect */
.glass-table { font-size: 13px; border-radius: 15px; overflow: hidden; margin-bottom: 0 !important; background: transparent; }
.glass-table thead th { background: linear-gradient(135deg, rgba(224, 195, 252, 0.7) 0%, rgba(142, 197, 252, 0.7) 100%) !important; backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); color: #4a148c !important; font-weight: 700; text-align: center; border: 1px solid rgba(255, 255, 255, 0.6) !important; padding: 15px 8px; text-shadow: 0 2px 8px rgba(255, 255, 255, 0.8); box-shadow: inset 0 0 15px rgba(255, 255, 255, 0.6); }
.glass-table tbody tr:nth-child(odd) { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); box-shadow: inset 0 0 10px rgba(255, 255, 255, 0.5); transition: all 0.3s ease; }
.glass-table tbody tr:nth-child(even) { background: rgba(224, 247, 250, 0.6); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); box-shadow: inset 0 0 10px rgba(142, 197, 252, 0.3); transition: all 0.3s ease; }
.glass-table tbody tr:hover { background: linear-gradient(135deg, rgba(224, 195, 252, 0.5) 0%, rgba(142, 197, 252, 0.5) 100%) !important; }
.glass-table tbody td { border: 1px solid rgba(142, 197, 252, 0.3) !important; padding: 12px 8px; color: #1a237e; font-weight: 500; }
.glass-table .summary { color: #4a148c; margin-top: 15px; text-shadow: 0 2px 5px rgba(255, 255, 255, 0.8); font-weight: 600; }
.glass-table .pagination > li > a, .glass-table .pagination > li > span { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); border: 2px solid rgba(142, 197, 252, 0.5); color: #4a148c; margin: 0 3px; border-radius: 8px; box-shadow: 0 2px 10px rgba(142, 197, 252, 0.3), inset 0 0 10px rgba(255, 255, 255, 0.5); font-weight: 600; }
.glass-table .pagination > .active > a { background: linear-gradient(135deg, rgba(224, 195, 252, 0.8) 0%, rgba(142, 197, 252, 0.8) 100%) !important; border: 2px solid rgba(142, 197, 252, 0.8); box-shadow: 0 4px 15px rgba(142, 197, 252, 0.5), inset 0 0 15px rgba(255, 255, 255, 0.7); }
</style>