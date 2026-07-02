<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'นำเข้าข้อมูลจากไฟล์ Excel - รายการอุทธรณ์ C305งานแพทย์แผนไทย';
?>
<div class="oppp-import">
   
    
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible modern-alert success-alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-check-circle"></i> <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>
    
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissible modern-alert error-alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-exclamation-circle"></i> <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>
    
    <?php if (Yii::$app->session->hasFlash('warning')): ?>
        <div class="alert alert-warning alert-dismissible modern-alert warning-alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-exclamation-triangle"></i> <?= Yii::$app->session->getFlash('warning') ?>
        </div>
    <?php endif; ?>

    <div class="panel modern-panel panel-upload">
        <div class="panel-heading gradient-primary">
            <h3 class="panel-title">
                <i class="fa fa-cloud-upload"></i> อัปโหลดไฟล์ Excel
            </h3>
        </div>
        <div class="panel-body">
            <?= Html::beginForm(['import-excel'], 'post', ['enctype' => 'multipart/form-data']) ?>
                
                <div class="form-group">
                    <label for="excel_file" class="modern-label">
                        <i class="fa fa-file-excel-o text-success"></i> เลือกไฟล์ Excel (XLS, XLSX)
                    </label>
                    <input type="file" name="excel_file" id="excel_file" class="form-control modern-input" accept=".xls,.xlsx" required>
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
                        '<i class="fa fa-bar-chart"></i> เตรียมข้อมูลส่งออก CSV',
                        ['/t305/index'],
                        [
                            'class' => 'btn btn-modern btn-warning-gradient btn-lg btn-rounded',
                            'encode' => false
                        ]
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
                        <li><i class="fa fa-angle-right text-primary"></i> เลขอ้างอิงชื่อไฟล์</li>
                        <li><i class="fa fa-angle-right text-primary"></i> ชื่อไฟล์</li>
                        <li><i class="fa fa-angle-right text-primary"></i> รหัสเขต</li>
                        <li><i class="fa fa-angle-right text-primary"></i> ชื่อเขต</li>
                        <li><i class="fa fa-angle-right text-primary"></i> รหัสจังหวัด</li>
                        <li><i class="fa fa-angle-right text-primary"></i> ชื่อจังหวัด</li>
                        <li><i class="fa fa-angle-right text-primary"></i> รหัสหน่วยบริการ</li>
                        <li><i class="fa fa-angle-right text-primary"></i> ชื่อหน่วยบริการ</li>
                        <li><i class="fa fa-angle-right text-primary"></i> รหัสบัตรประชาชน</li>
                        <li><i class="fa fa-angle-right text-primary"></i> วันที่เข้ารับบริการ</li>
                        <li><i class="fa fa-angle-right text-primary"></i> วันที่ส่งข้อมูล</li>
                        <li><i class="fa fa-angle-right text-primary"></i> ประเภทการบริการ</li>
                        <li><i class="fa fa-angle-right text-primary"></i> รหัสอ้างอิงจากแฟ้ม SERVICE</li>
                        <li><i class="fa fa-angle-right text-primary"></i> รหัสหัตถการแพทย์แผนไทยที่จ่าย</li>
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
                        <li><i class="fa fa-angle-right text-primary"></i> รหัสหัตถการแพทย์แผนไทยที่ไม่จ่าย</li>
                        <li><i class="fa fa-angle-right text-primary"></i> วันที่เสียชีวิต</li>
                        <li><i class="fa fa-angle-right text-primary"></i> เพศ</li>
                        <li><i class="fa fa-angle-right text-primary"></i> สิทธิหลัก</li>
                        <li><i class="fa fa-angle-right text-primary"></i> หน่วยบริการประจำ</li>
                        <li><i class="fa fa-angle-right text-primary"></i> หน่วยบริการปฐมภูมิ</li>
                        <li><i class="fa fa-angle-right text-primary"></i> รหัสหัตถการที่ส่งทั้งหมดในวันรับบริการเดียวกัน</li>
                        <li><i class="fa fa-angle-right text-primary"></i> ประเภทกิจกรรมที่ส่งเบิกชดเชย</li>
                        <li><i class="fa fa-angle-right text-primary"></i> มีการส่งรหัสวินิจฉัยโรค</li>
                        <li><i class="fa fa-angle-right text-primary"></i> แจ้งผลการตรวจสอบข้อผิดพลาดของข้อมูล</li>
                        <li><i class="fa fa-angle-right text-primary"></i> สรุปผลการตรวจสอบเบื้องต้น</li>
                        <li><i class="fa fa-angle-right text-primary"></i> วันที่รับบริการอยู่ในปีงบประมาณ</li>
                        <li><i class="fa fa-angle-right text-primary"></i> รหัสอ้างอิงข้อมูลสำหรับการติดต่อกับทาง สปสช.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="alert modern-alert info-note">
        <h4><i class="fa fa-info-circle"></i> หมายเหตุ:</h4>
        <ul class="modern-list-plain">
            <li><i class="fa fa-check-circle text-info"></i> ระบบจะค้นหาแถว Header อัตโนมัติ (ที่มีคำว่า "เลขอ้างอิงชื่อไฟล์")</li>
            <li><i class="fa fa-check-circle text-info"></i> ข้อมูลจะเริ่มนำเข้าจากแถวถัดจาก Header</li>
            <li><i class="fa fa-check-circle text-info"></i> คอลัมน์วันที่จะถูกแปลงเป็นรูปแบบ Y-m-d โดยอัตโนมัติ</li>
            <li><i class="fa fa-check-circle text-info"></i> รองรับวันที่ทั้งในรูปแบบ พ.ศ. และ ค.ศ.</li>
            <li><i class="fa fa-check-circle text-info"></i> ระบบจะข้ามแถวที่ว่างหรือไม่มีข้อมูลโดยอัตโนมัติ</li>
            <li><i class="fa fa-check-circle text-info"></i> รองรับไฟล์ Excel ทั้งรูปแบบ .xls และ .xlsx</li>
        </ul>
    </div>

    <div class="alert modern-alert warning-note">
        <h4><i class="fa fa-exclamation-triangle"></i> ข้อควรระวัง:</h4>
        <ul class="modern-list-plain">
            <li><i class="fa fa-warning text-warning"></i> ตรวจสอบให้แน่ใจว่าไฟล์ Excel มีโครงสร้างตรงตามที่กำหนด</li>
            <li><i class="fa fa-warning text-warning"></i> ข้อมูลรหัสบัตรประชาชนควรเป็นตัวเลข 13 หลัก</li>
            <li><i class="fa fa-warning text-warning"></i> วันที่ควรอยู่ในรูปแบบที่ถูกต้อง เช่น วัน/เดือน/ปี</li>
            <li><i class="fa fa-warning text-warning"></i> หากมีข้อมูลจำนวนมาก กระบวนการนำเข้าอาจใช้เวลาสักครู่</li>
        </ul>
    </div>

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
                            <th>...</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                <em>รายงานผลการตรวจสอบเบื้องต้นก่อนการเบิกจ่าย...</em>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                <em>ข้อมูลเขต จังหวัด อำเภอ...</em>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-center">...</td>
                        </tr>
                        <tr class="bg-warning-soft">
                            <td><strong>เลขอ้างอิงชื่อไฟล์</strong></td>
                            <td><strong>ชื่อไฟล์</strong></td>
                            <td><strong>รหัสเขต</strong></td>
                            <td><strong>ชื่อเขต</strong></td>
                            <td><strong>รหัสจังหวัด</strong></td>
                            <td>...</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                <em>แถวว่าง (จะถูกข้าม)</em>
                            </td>
                        </tr>
                        <tr class="bg-success-soft">
                            <td>68032926</td>
                            <td>F43_10953...</td>
                            <td>10</td>
                            <td>เขต 10...</td>
                            <td>3400</td>
                            <td>...</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                <em>ข้อมูลต่อไป...</em>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p class="help-block">
                <i class="fa fa-lightbulb-o text-warning"></i> 
                <strong>คำแนะนำ:</strong> แถว Header (สีเหลือง) คือแถวที่มีชื่อคอลัมน์ทั้งหมด 
                และข้อมูล (สีเขียว) จะเริ่มถัดจากแถว Header
            </p>
        </div>
    </div>
</div>

<style>
/* พื้นหลังอ่อนๆ จางๆ */
.oppp-import {
    background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
    padding: 20px;
    border-radius: 15px;
    min-height: 100vh;
}

/* Panel สไตล์ทันสมัย */
.modern-panel {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    margin-bottom: 25px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
}

.modern-panel:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

/* Gradient Headers */
.gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #44fcfc 100%);
    color: white;
    padding: 18px 20px;
    border: none;
}

.gradient-info {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
    padding: 18px 20px;
    border: none;
}

.gradient-success {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: white;
    padding: 18px 20px;
    border: none;
}

.panel-heading {
    font-weight: 600;
    border-bottom: none;
}

.panel-title {
    font-size: 16px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.panel-title i {
    font-size: 20px;
}

/* ปุ่มสไตล์ทันสมัย */
.btn-modern {
    border: none;
    border-radius: 25px;
    padding: 12px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.btn-modern:before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-modern:hover:before {
    width: 300px;
    height: 300px;
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
}

.btn-primary-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-warning-gradient {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.btn-rounded {
    border-radius: 25px;
}

.btn-modern i {
    margin-right: 8px;
}

/* Input สไตล์ทันสมัย */
.modern-input {
    border-radius: 10px;
    border: 2px solid #e0e6ed;
    padding: 12px 15px;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.9);
}

.modern-input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    background: white;
}

.modern-label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 10px;
    display: block;
}

/* Alert สไตล์ทันสมัย */
.modern-alert {
    border: none;
    border-radius: 12px;
    padding: 18px 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    border-left: 5px solid;
}

.success-alert {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border-left-color: #28a745;
    color: #155724;
}

.error-alert {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    border-left-color: #dc3545;
    color: #721c24;
}

.warning-alert {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    border-left-color: #ffc107;
    color: #856404;
}

.info-note {
    background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
    border-left-color: #17a2b8;
    color: #0c5460;
}

.warning-note {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    border-left-color: #ff9800;
    color: #856404;
}

.modern-alert h4 {
    margin-top: 0;
    font-weight: 700;
    margin-bottom: 12px;
}

.modern-alert i.fa {
    font-size: 18px;
    margin-right: 8px;
}

/* List สไตล์ทันสมัย */
.modern-list {
    list-style: none;
    padding-left: 0;
}

.modern-list li {
    padding: 10px 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.modern-list li:hover {
    padding-left: 10px;
    background: rgba(102, 126, 234, 0.05);
    border-radius: 5px;
}

.modern-list li i {
    margin-right: 10px;
    font-size: 14px;
}

.modern-list-plain {
    list-style: none;
    padding-left: 0;
}

.modern-list-plain li {
    padding: 8px 0;
}

.modern-list-plain li i {
    margin-right: 10px;
}

/* Table สไตล์ทันสมัย */
.modern-table {
    border-radius: 10px;
    overflow: hidden;
    background: white;
}

.modern-table th {
    text-align: center;
    vertical-align: middle;
    font-weight: 600;
    color: white;
    padding: 15px;
}

.modern-table td {
    padding: 12px;
    vertical-align: middle;
}

.bg-primary-gradient {
    background: linear-gradient(135deg, #667eea 0%, #f5defa 100%);
}

.bg-warning-soft {
    background: rgba(255, 193, 7, 0.15);
    font-weight: 600;
}

.bg-success-soft {
    background: rgba(40, 167, 69, 0.15);
}

/* Panel Body */
.panel-body {
    padding: 25px;
}

/* Help Block */
.help-block {
    color: #6c757d;
    font-size: 14px;
    margin-top: 8px;
}

/* Responsive */
@media (max-width: 768px) {
    .btn-modern {
        width: 100%;
        margin-bottom: 10px;
    }
    
    .modern-panel {
        margin-bottom: 15px;
    }
}

/* Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modern-panel {
    animation: fadeIn 0.5s ease-out;
}

/* Icon Colors */
.text-success { color: #28a745 !important; }
.text-primary { color: #667eea !important; }
.text-info { color: #17a2b8 !important; }
.text-warning { color: #ffc107 !important; }
.text-muted { color: #6c757d !important; }
</style>