<?php
/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'นำเข้าข้อมูลจากไฟล์ Excel - C305 HN';
$this->params['breadcrumbs'][] = ['label' => 'KTP C305 HN', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ktp-c305-import">

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible modern-alert success-alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-check-circle"></i> <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif ?>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissible modern-alert error-alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-exclamation-circle"></i> <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif ?>

    <!-- Upload Panel -->
    <div class="panel modern-panel panel-upload">
        <div class="panel-heading gradient-primary">
            <h3 class="panel-title">
                <i class="fa fa-cloud-upload"></i> อัปโหลดไฟล์ Excel - KTP C305 HN
            </h3>
        </div>
        <div class="panel-body">
            <?= Html::beginForm(['import'], 'post', ['enctype' => 'multipart/form-data']) ?>

                <div class="form-group">
                    <label for="import_file" class="modern-label">
                        <i class="fa fa-file-excel-o text-success"></i> เลือกไฟล์ Excel (XLS, XLSX)
                    </label>
                    <input type="file"
                           name="import_file"
                           id="import_file"
                           class="form-control modern-input"
                           accept=".xls,.xlsx"
                           required>
                    <p class="help-block">
                        <i class="fa fa-info-circle"></i> รองรับไฟล์นามสกุล .xls และ .xlsx
                    </p>
                </div>

                <div class="form-group">
                    <?= Html::submitButton(
                        '<i class="fa fa-cloud-upload"></i> นำเข้าข้อมูล',
                        ['class' => 'btn btn-modern btn-primary-gradient btn-lg btn-rounded']
                    ) ?>
                    <?= Html::a(
                        '<i class="fa fa-list"></i> กลับหน้ารายการ',
                        ['/ktp305/index'],
                        ['class' => 'btn btn-modern btn-warning-gradient btn-lg btn-rounded', 'encode' => false]
                    ) ?>
                </div>

            <?= Html::endForm() ?>
        </div>
    </div>

    <!-- Column List -->
    <div class="row">
        <div class="col-md-6">
            <div class="panel modern-panel panel-info-custom">
                <div class="panel-heading gradient-info">
                    <h3 class="panel-title">
                        <i class="fa fa-list-ul"></i> คอลัมน์ที่จะนำเข้า (ส่วนที่ 1)
                    </h3>
                </div>
                <div class="panel-body">
                    <ol class="modern-list">
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>ที่</strong> — ลำดับ</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>rep</strong> — REP</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>tran_id</strong> — Transaction ID</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>HN</strong> — เลขบัตรผู้ป่วย (HN)</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>AN</strong> — บัตรผู้ป่วยใน (AN)</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>pid</strong> — หมายเลขบัตรประชาชน</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>fullname</strong> — ชื่อ-นามสกุล</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>สิทธิการรักษาพยาบาล</strong> — สิทธิ์</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>หน่วยบริการแม่ข่าย (HmainOP)</strong></li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>วันที่ส่งข้อมูล</strong> — วันที่</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>regdate</strong> — วันที่ลงทะเบียน</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>ลำดับที่</strong></li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>รายการประเภทที่ขอเบิก</strong></li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>เรียกเก็บ</strong></li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel modern-panel panel-info-custom">
                <div class="panel-heading gradient-info">
                    <h3 class="panel-title">
                        <i class="fa fa-list-ul"></i> คอลัมน์ที่จะนำเข้า (ส่วนที่ 2)
                    </h3>
                </div>
                <div class="panel-body">
                    <ol class="modern-list" start="15">
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>O</strong></li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>P</strong></li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>Q</strong></li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>ล่าช้า (PS)</strong></li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>S</strong></li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>ชดเชย</strong></li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>U</strong></li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>V</strong></li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>W</strong></li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>สถานะ</strong></li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>c305</strong></li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>หมายเหตุอื่นๆ (STMID)</strong></li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>หน่วยบริการที่ส่งข้อมูล (HSEND)</strong></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes -->
    <div class="alert modern-alert info-note">
        <h4><i class="fa fa-info-circle"></i> หมายเหตุ:</h4>
        <ul class="modern-list-plain">
            <li><i class="fa fa-check-circle text-info"></i> ระบบจะค้นหาแถว Header อัตโนมัติ (ต้องมีคอลัมน์ตรงอย่างน้อย 5 คอลัมน์)</li>
            <li><i class="fa fa-check-circle text-info"></i> ชื่อคอลัมน์ในไฟล์ไม่จำเป็นต้องตรงตัวพิมพ์ใหญ่-เล็ก</li>
            <li><i class="fa fa-check-circle text-info"></i> คอลัมน์วันที่จะถูกแปลงเป็นรูปแบบ Y-m-d โดยอัตโนมัติ</li>
            <li><i class="fa fa-check-circle text-info"></i> รองรับวันที่ทั้งรูปแบบ Excel serial และข้อความ (d/m/Y, d-m-Y, Y-m-d)</li>
            <li><i class="fa fa-check-circle text-info"></i> ระบบจะข้ามแถวที่ว่างเปล่าโดยอัตโนมัติ</li>
            <li><i class="fa fa-check-circle text-info"></i> รองรับไฟล์ทั้ง .xls และ .xlsx</li>
        </ul>
    </div>

    <div class="alert modern-alert warning-note">
        <h4><i class="fa fa-exclamation-triangle"></i> ข้อควรระวัง:</h4>
        <ul class="modern-list-plain">
            <li><i class="fa fa-warning text-warning"></i> ตรวจสอบว่าชื่อคอลัมน์ในไฟล์ Excel ตรงกับชื่อที่กำหนด</li>
            <li><i class="fa fa-warning text-warning"></i> หมายเลขบัตรประชาชน (pid) ควรเป็นตัวเลข 13 หลัก</li>
            <li><i class="fa fa-warning text-warning"></i> คอลัมน์ที่มีวงเล็บ เช่น <strong>หน่วยบริการแม่ข่าย (HmainOP)</strong> ต้องมีครบทั้งวงเล็บ</li>
            <li><i class="fa fa-warning text-warning"></i> หากข้อมูลมีจำนวนมาก กระบวนการนำเข้าอาจใช้เวลาสักครู่</li>
        </ul>
    </div>

    <!-- Example Table -->
    <div class="panel modern-panel panel-example">
        <div class="panel-heading gradient-success">
            <h3 class="panel-title">
                <i class="fa fa-table"></i> ตัวอย่างโครงสร้างไฟล์ Excel
            </h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover modern-table">
                    <thead>
                        <tr class="bg-primary-gradient">
                            <th>A</th>
                            <th>B</th>
                            <th>C</th>
                            <th>D</th>
                            <th>E</th>
                            <th>F</th>
                            <th>...</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                <em>(แถวข้อมูลทั่วไป / หัวรายงาน — จะถูกข้าม)</em>
                            </td>
                        </tr>
                        <tr class="bg-warning-soft">
                            <td><strong>ที่</strong></td>
                            <td><strong>rep</strong></td>
                            <td><strong>tran_id</strong></td>
                            <td><strong>HN</strong></td>
                            <td><strong>AN</strong></td>
                            <td><strong>pid</strong></td>
                            <td>...</td>
                        </tr>
                        <tr class="bg-success-soft">
                            <td>1</td>
                            <td>REP001</td>
                            <td>TRN0000001</td>
                            <td>000001</td>
                            <td>630001</td>
                            <td>3341400524379</td>
                            <td>...</td>
                        </tr>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                <em>ข้อมูลต่อไป...</em>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p class="help-block">
                <i class="fa fa-lightbulb-o text-warning"></i>
                <strong>คำแนะนำ:</strong> แถว Header (สีเหลือง) คือแถวที่มีชื่อคอลัมน์
                และข้อมูล (สีเขียว) จะเริ่มถัดจากแถว Header ระบบจะหาแถว Header ให้อัตโนมัติ
            </p>
        </div>
    </div>

</div>

<style>
.ktp-c305-import {
    background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
    padding: 20px;
    border-radius: 15px;
    min-height: 100vh;
}
.modern-panel {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    margin-bottom: 25px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    animation: fadeIn 0.5s ease-out;
}
.modern-panel:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}
.gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #44fcfc 100%);
    color: white; padding: 18px 20px; border: none;
}
.gradient-info {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white; padding: 18px 20px; border: none;
}
.gradient-success {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: white; padding: 18px 20px; border: none;
}
.panel-heading { font-weight: 600; border-bottom: none; }
.panel-title {
    font-size: 16px; font-weight: 600;
    display: flex; align-items: center; gap: 10px;
}
.panel-title i { font-size: 20px; }
.panel-body { padding: 25px; }

.btn-modern {
    border: none; border-radius: 25px; padding: 12px 30px;
    font-weight: 600; transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    position: relative; overflow: hidden; margin-right: 10px;
}
.btn-modern:hover { transform: translateY(-2px); box-shadow: 0 6px 25px rgba(0,0,0,0.15); }
.btn-primary-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
.btn-warning-gradient  { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; }
.btn-rounded { border-radius: 25px; }
.btn-modern i { margin-right: 8px; }

.modern-input {
    border-radius: 10px; border: 2px solid #e0e6ed;
    padding: 12px 15px; transition: all 0.3s ease;
}
.modern-input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102,126,234,0.15);
}
.modern-label { font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block; }

.modern-alert {
    border: none; border-radius: 12px; padding: 18px 20px;
    margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    border-left: 5px solid;
}
.success-alert { background: linear-gradient(135deg, #d4edda, #c3e6cb); border-left-color: #28a745; color: #155724; }
.error-alert   { background: linear-gradient(135deg, #f8d7da, #f5c6cb); border-left-color: #dc3545; color: #721c24; }
.info-note     { background: linear-gradient(135deg, #d1ecf1, #bee5eb); border-left-color: #17a2b8; color: #0c5460; }
.warning-note  { background: linear-gradient(135deg, #fff3cd, #ffeaa7); border-left-color: #ff9800; color: #856404; }
.modern-alert h4 { margin-top: 0; font-weight: 700; margin-bottom: 12px; }
.modern-alert i.fa { font-size: 18px; margin-right: 8px; }

.modern-list { list-style: none; padding-left: 0; }
.modern-list li {
    padding: 9px 0; border-bottom: 1px solid rgba(0,0,0,0.05); transition: all 0.3s ease;
}
.modern-list li:hover { padding-left: 10px; background: rgba(102,126,234,0.05); border-radius: 5px; }
.modern-list li i { margin-right: 10px; }
.modern-list-plain { list-style: none; padding-left: 0; }
.modern-list-plain li { padding: 8px 0; }
.modern-list-plain li i { margin-right: 10px; }

.modern-table { border-radius: 10px; overflow: hidden; background: white; }
.modern-table th { text-align: center; vertical-align: middle; font-weight: 600; color: white; padding: 15px; }
.modern-table td { padding: 12px; vertical-align: middle; }
.bg-primary-gradient { background: linear-gradient(135deg, #667eea 0%, #f5defa 100%); }
.bg-warning-soft { background: rgba(255,193,7,0.15); font-weight: 600; }
.bg-success-soft { background: rgba(40,167,69,0.15); }

.help-block { color: #6c757d; font-size: 14px; margin-top: 8px; }

.text-success { color: #28a745 !important; }
.text-primary { color: #667eea !important; }
.text-info    { color: #17a2b8 !important; }
.text-warning { color: #ffc107 !important; }
.text-muted   { color: #6c757d !important; }

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

@media (max-width: 768px) {
    .btn-modern { width: 100%; margin-bottom: 10px; }
    .modern-panel { margin-bottom: 15px; }
}
</style>
