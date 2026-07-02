<?php
use yii\helpers\Html;

$this->title = 'นำเข้าข้อมูลจากไฟล์ Excel - Patient Claim 305';
$this->params['breadcrumbs'][] = ['label' => 'Patient Claim 305', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patient-claim305-import">

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

    <div class="panel modern-panel panel-upload">
        <div class="panel-heading gradient-primary">
            <h3 class="panel-title">
                <i class="fa fa-cloud-upload"></i> อัปโหลดไฟล์ Excel - Patient Claim 305
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
                        ['class' => 'btn btn-modern btn-primary-gradient btn-lg btn-rounded', 'encode' => false]
                    ) ?>
                    <?= Html::a(
                        '<i class="fa fa-list"></i> กลับหน้ารายการ',
                        ['index'],
                        ['class' => 'btn btn-modern btn-warning-gradient btn-lg btn-rounded', 'encode' => false]
                    ) ?>
                </div>

            <?= Html::endForm() ?>
        </div>
    </div>

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
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>row / no</strong> — ลำดับ</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>EClaim No / eclaim_no</strong> — EClaim No.</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>ประเภทผู้ป่วย / patient_type</strong> — 1=OPD, 2=IPD</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>สิทธิประโยชน์ / benefit_rights</strong> — สิทธิ เช่น UCS</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>หมายเลขบัตร / card_no</strong> — บัตรประชาชน</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>ชื่อผู้ป่วย / patient_name</strong> — ชื่อ-นามสกุล</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>เลขบัตร...HN / hn</strong> — HN</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>บัตร...AN / an</strong> — AN</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>วันที่เข้ารับบริการ / service_date</strong> — วันที่รับบริการ</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>เวลารับบริการ / service_time</strong> — เวลา</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>วันที่จำหน่าย / discharge_date</strong> — วันจำหน่าย</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>เวลาจำหน่าย / discharge_time</strong> — เวลาจำหน่าย</li>
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
                    <ol class="modern-list" start="13">
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>สถานะข้อมูล / data_status</strong> — สถานะ</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>ชื่อผู้บันทึก... / recorder_name</strong> — ผู้บันทึก</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>Tran ID / tran_id</strong> — Transaction ID</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>ค่าใช้จ่ายสูง / high_cost</strong> — ค่าใช้จ่ายสูง</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>ยอดเรียกเก็บ / claim_amount</strong> — ยอดเรียกเก็บ</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>REP / rep</strong> — REP</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>STM / stm</strong> — STM</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>SEQ / seq</strong> — SEQ</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>รายละเอียด... / inspection_details</strong> — รายละเอียด</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>Deny/Warning / deny_warning</strong> — Deny/Warning</li>
                        <li><i class="fa fa-angle-right text-primary"></i> <strong>Channel / channel</strong> — Channel</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="alert modern-alert info-note">
        <h4><i class="fa fa-info-circle"></i> หมายเหตุ:</h4>
        <ul class="modern-list-plain">
            <li><i class="fa fa-check-circle text-info"></i> รองรับทั้งชื่อคอลัมน์ภาษาไทย และ snake_case (English)</li>
            <li><i class="fa fa-check-circle text-info"></i> ระบบจะค้นหาแถว Header อัตโนมัติ</li>
            <li><i class="fa fa-check-circle text-info"></i> ข้อมูลจะเริ่มนำเข้าจากแถวถัดจาก Header</li>
            <li><i class="fa fa-check-circle text-info"></i> คอลัมน์วันที่จะถูกแปลงเป็นรูปแบบ Y-m-d โดยอัตโนมัติ</li>
            <li><i class="fa fa-check-circle text-info"></i> ระบบจะข้ามแถวที่ว่างหรือไม่มีข้อมูลโดยอัตโนมัติ</li>
        </ul>
    </div>

    <div class="alert modern-alert warning-note">
        <h4><i class="fa fa-exclamation-triangle"></i> ข้อควรระวัง:</h4>
        <ul class="modern-list-plain">
            <li><i class="fa fa-warning text-warning"></i> ตรวจสอบให้แน่ใจว่าไฟล์ Excel มีโครงสร้างถูกต้อง</li>
            <li><i class="fa fa-warning text-warning"></i> หมายเลขบัตรประชาชนควรเป็นตัวเลข 13 หลัก</li>
            <li><i class="fa fa-warning text-warning"></i> วันที่ควรอยู่ในรูปแบบที่ถูกต้อง</li>
        </ul>
    </div>

</div>

<style>
.patient-claim305-import { background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%); padding: 20px; border-radius: 15px; min-height: 100vh; }
.modern-panel { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); margin-bottom: 25px; overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); animation: fadeIn 0.5s ease-out; }
.modern-panel:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
.gradient-primary { background: linear-gradient(135deg, #667eea 0%, #44fcfc 100%); color: white; padding: 18px 20px; border: none; }
.gradient-info { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 18px 20px; border: none; }
.panel-heading { font-weight: 600; border-bottom: none; }
.panel-title { font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 10px; }
.panel-title i { font-size: 20px; }
.panel-body { padding: 25px; }
.btn-modern { border: none; border-radius: 25px; padding: 12px 30px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.1); position: relative; overflow: hidden; margin-right: 10px; }
.btn-modern:hover { transform: translateY(-2px); box-shadow: 0 6px 25px rgba(0,0,0,0.15); }
.btn-primary-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
.btn-warning-gradient  { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; }
.btn-rounded { border-radius: 25px; }
.btn-modern i { margin-right: 8px; }
.modern-input { border-radius: 10px; border: 2px solid #e0e6ed; padding: 12px 15px; transition: all 0.3s ease; }
.modern-input:focus { border-color: #667eea; box-shadow: 0 0 0 0.2rem rgba(102,126,234,0.15); }
.modern-label { font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block; }
.modern-alert { border: none; border-radius: 12px; padding: 18px 20px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border-left: 5px solid; }
.success-alert { background: linear-gradient(135deg, #d4edda, #c3e6cb); border-left-color: #28a745; color: #155724; }
.error-alert   { background: linear-gradient(135deg, #f8d7da, #f5c6cb); border-left-color: #dc3545; color: #721c24; }
.info-note     { background: linear-gradient(135deg, #d1ecf1, #bee5eb); border-left-color: #17a2b8; color: #0c5460; }
.warning-note  { background: linear-gradient(135deg, #fff3cd, #ffeaa7); border-left-color: #ff9800; color: #856404; }
.modern-alert h4 { margin-top: 0; font-weight: 700; margin-bottom: 12px; }
.modern-alert i.fa { font-size: 18px; margin-right: 8px; }
.modern-list { list-style: none; padding-left: 0; }
.modern-list li { padding: 9px 0; border-bottom: 1px solid rgba(0,0,0,0.05); transition: all 0.3s ease; }
.modern-list li:hover { padding-left: 10px; background: rgba(102,126,234,0.05); border-radius: 5px; }
.modern-list li i { margin-right: 10px; }
.modern-list-plain { list-style: none; padding-left: 0; }
.modern-list-plain li { padding: 8px 0; }
.modern-list-plain li i { margin-right: 10px; }
.help-block { color: #6c757d; font-size: 14px; margin-top: 8px; }
.text-success { color: #28a745 !important; }
.text-primary { color: #667eea !important; }
.text-info    { color: #17a2b8 !important; }
.text-warning { color: #ffc107 !important; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
@media (max-width: 768px) { .btn-modern { width: 100%; margin-bottom: 10px; } .modern-panel { margin-bottom: 15px; } }
</style>