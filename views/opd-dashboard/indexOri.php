<?php
use yii\helpers\Html;
use yii\helpers\Url;

// คำนวณปี พ.ศ. ของปีงบประมาณ (ปีสิ้นสุด)
$fiscalYearBE = $fiscalYear + 1 + 543; // ปีงบประมาณใช้ปีสิ้นสุด

$this->title = 'Dashboard OPD ปีงบประมาณ ' . $fiscalYearBE;
?>

<style>
body {
    background-color: #f5f7fa;
}

.dashboard-container {
    padding: 20px;
}

.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    border-radius: 10px;
    margin-bottom: 30px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.page-header h1 {
    margin: 0;
    font-size: 28px;
    font-weight: bold;
}

/* กล่องสรุปยอด */
.summary-section {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 30px;
    flex-wrap: wrap;
}

.summary-box {
    flex: 1;
    min-width: 280px;
    max-width: 350px;
    padding: 25px;
    border-radius: 12px;
    color: white;
    text-align: center;
    box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    transition: transform 0.3s ease;
}

.summary-box:hover {
    transform: translateY(-5px);
}

.summary-claim {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.summary-compensation {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.summary-difference {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

.summary-box .label {
    font-size: 16px;
    margin-bottom: 10px;
    opacity: 0.95;
    font-weight: 500;
}

.summary-box .value {
    font-size: 36px;
    font-weight: bold;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}

/* ปุ่มเลือกปีงบประมาณ */
.fiscal-year-section {
    background: white;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.fiscal-year-selector {
    display: flex;
    gap: 15px;
    align-items: center;
    flex-wrap: wrap;
}

.fiscal-year-selector label {
    font-weight: 600;
    color: #333;
    font-size: 16px;
}

.fiscal-year-btn {
    padding: 12px 24px;
    border: 2px solid #667eea;
    background-color: white;
    color: #667eea;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
}

.fiscal-year-btn:hover {
    background-color: #f0f4ff;
    text-decoration: none;
    color: #667eea;
}

.fiscal-year-btn.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: #667eea;
}

/* ตาราง */
.table-container {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    overflow: hidden;
}

.table-responsive {
    overflow-x: auto;
    margin-top: 10px;
}

.table-dashboard {
    font-size: 11px;
    width: 100%;
    border-collapse: collapse;
    background: white;
}

.table-dashboard th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    text-align: center;
    vertical-align: middle;
    padding: 10px 5px;
    font-weight: 600;
    border: 1px solid rgba(255,255,255,0.2);
    font-size: 12px;
    white-space: nowrap;
}

.table-dashboard td {
    text-align: center;
    padding: 8px 4px;
    border: 1px solid #e0e0e0;
    white-space: nowrap;
}

.table-dashboard tbody tr:hover {
    background-color: #f8f9fa;
}

/* สีพื้นหลังแต่ละเดือน */
.month-oct { background-color: #fff5f5; }
.month-nov { background-color: #fff8f5; }
.month-dec { background-color: #fffcf5; }
.month-jan { background-color: #fffff5; }
.month-feb { background-color: #f5fff5; }
.month-mar { background-color: #f5fffc; }
.month-apr { background-color: #f5f8ff; }
.month-may { background-color: #f5f5ff; }
.month-jun { background-color: #fcf5ff; }
.month-jul { background-color: #fff5fc; }
.month-aug { background-color: #fff5f8; }
.month-sep { background-color: #fffaf5; }

/* สีแดงสำหรับเซลล์ที่ติด C */
.bg-red {
    background-color: #ff6b6b !important;
    color: white !important;
    font-weight: 600;
}

.month-group {
    border-left: 2px solid #999;
}

/* คอลัมน์แรก (กลุ่มงาน) */
.sticky-col {
    position: sticky;
    left: 0;
    background-color: #f8f9fa;
    z-index: 10;
    font-weight: 600;
    color: #333;
    border-right: 2px solid #999;
}

.table-dashboard tbody tr:hover .sticky-col {
    background-color: #e9ecef;
}

/* คอลัมน์รวม */
.total-col {
    background-color: #fff3cd !important;
    font-weight: bold;
    border-left: 2px solid #ffc107;
}

/* ปรับแต่งสำหรับหน้าจอเล็ก */
@media (max-width: 768px) {
    .summary-section {
        flex-direction: column;
    }
    
    .summary-box {
        max-width: 100%;
    }
    
    .table-dashboard {
        font-size: 9px;
    }
    
    .table-dashboard th,
    .table-dashboard td {
        padding: 5px 2px;
    }
}

/* Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.dashboard-container > * {
    animation: fadeIn 0.5s ease;
}

.date-range-info {
    color: #666;
    font-size: 14px;
    margin-top: 10px;
    padding: 10px;
    background-color: #f8f9fa;
    border-radius: 5px;
    border-left: 3px solid #667eea;
}
</style>

<div class="dashboard-container">
    <!-- Header -->
    <div class="page-header">
        <h1>📊 <?= Html::encode($this->title) ?></h1>
        <p style="margin: 10px 0 0 0; opacity: 0.9;">Dashboard สรุปข้อมูล OPD และการเรียกเก็บ-ชดเชย</p>
    </div>

    <!-- ปุ่มเลือกปีงบประมาณ -->
    <div class="fiscal-year-section">
        <div class="fiscal-year-selector">
            <label>📅 เลือกปีงบประมาณ:</label>
            <?php
            $currentYear = (int)date('Y');
            $currentMonth = (int)date('m');
            
            // คำนวณปีงบประมาณปัจจุบัน (ถ้าเดือน 10-12 ใช้ปีถัดไป, เดือน 1-9 ใช้ปีปัจจุบัน)
            $currentFiscalYear = ($currentMonth >= 10) ? $currentYear + 1 : $currentYear;
            
            // แสดงปีงบประมาณ: ปีปัจจุบัน + 3 ปีย้อนหลัง
            $fiscalYears = range($currentFiscalYear - 3, $currentFiscalYear);
            
            foreach ($fiscalYears as $year):
                // ปีงบประมาณไทยใช้ปีสิ้นสุด (พ.ศ.)
                $displayYearBE = $year + 543;
                $startYearBE = $displayYearBE - 1;
                $dateRange = "1 ต.ค. {$startYearBE} - 30 ก.ย. {$displayYearBE}";
            ?>
                <a href="<?= Url::to(['index', 'fiscalYear' => ($year - 1)]) ?>" 
                   class="fiscal-year-btn <?= ($year - 1) == $fiscalYear ? 'active' : '' ?>"
                   title="<?= $dateRange ?>">
                    <?= $displayYearBE ?>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="date-range-info">
            <?php
            $startYearBE = $fiscalYearBE - 1;
            $startDate = date('d/m/Y', strtotime($fiscalYear . '-10-01'));
            $endDate = date('d/m/Y', strtotime(($fiscalYear + 1) . '-09-30'));
            ?>
            <strong>ช่วงข้อมูลปีงบประมาณ <?= $fiscalYearBE ?>:</strong>
            1 ตุลาคม <?= $startYearBE ?> ถึง 30 กันยายน <?= $fiscalYearBE ?>
            (<?= $startDate ?> - <?= $endDate ?>)
        </div>
    </div>

    <!-- กล่องสรุปยอด -->
    <div class="summary-section">
        <div class="summary-box summary-claim">
            <div class="label">💰 ยอดเรียกเก็บทั้งหมด</div>
            <div class="value"><?= number_format($totalClaim, 2) ?></div>
            <small style="opacity: 0.9; margin-top: 5px; display: block;">บาท</small>
        </div>
        <div class="summary-box summary-compensation">
            <div class="label">✅ ยอดชดเชยทั้งหมด</div>
            <div class="value"><?= number_format($totalCompensation, 2) ?></div>
            <small style="opacity: 0.9; margin-top: 5px; display: block;">บาท</small>
        </div>
        <div class="summary-box summary-difference">
            <div class="label">📈 ผลต่าง (เรียกเก็บ - ชดเชย)</div>
            <div class="value"><?= number_format($totalDifference, 2) ?></div>
            <small style="opacity: 0.9; margin-top: 5px; display: block;">บาท</small>
        </div>
    </div>

    <!-- ตารางข้อมูล -->
    <div class="table-container">
        <h3 style="margin-top: 0; color: #333;">📋 รายละเอียดตามกลุ่มงาน</h3>
        <div class="table-responsive">
            <table class="table-dashboard">
                <thead>
                    <tr>
                        <th rowspan="2" class="sticky-col">กลุ่มงาน</th>
                        <?php
                        $months = [
                            ['ตุลาคม', 'oct'],
                            ['พฤศจิกายน', 'nov'],
                            ['ธันวาคม', 'dec'],
                            ['มกราคม', 'jan'],
                            ['กุมภาพันธ์', 'feb'],
                            ['มีนาคม', 'mar'],
                            ['เมษายน', 'apr'],
                            ['พฤษภาคม', 'may'],
                            ['มิถุนายน', 'jun'],
                            ['กรกฎาคม', 'jul'],
                            ['สิงหาคม', 'aug'],
                            ['กันยายน', 'sep'],
                        ];
                        foreach ($months as $m):
                        ?>
                            <th colspan="6" class="month-group month-<?= $m[1] ?>"><?= $m[0] ?></th>
                        <?php endforeach; ?>
                        <th rowspan="2" class="total-col">รวมทั้งหมด</th>
                        <th rowspan="2" class="total-col">ผลต่าง</th>
                    </tr>
                    <tr>
                        <?php foreach ($months as $m): ?>
                            <th class="month-group month-<?= $m[1] ?>">ทั้งหมด</th>
                            <th class="month-<?= $m[1] ?>">เคลม</th>
                            <th class="month-<?= $m[1] ?>">ไม่ชดเชย</th>
                            <th class="month-<?= $m[1] ?>">เรียกเก็บ</th>
                            <th class="month-<?= $m[1] ?>">ชดเชย</th>
                            <th class="month-<?= $m[1] ?>">ติดC</th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (empty($dataProvider->getModels())) {
                        echo '<tr><td colspan="74" style="text-align:center;padding:20px;color:#999;">ไม่พบข้อมูลในปีงบประมาณนี้</td></tr>';
                    }
                    
                    foreach ($dataProvider->getModels() as $row):
                        $monthCodes = [
                            ['ต10', 'oct'],
                            ['พ11', 'nov'],
                            ['ธ12', 'dec'],
                            ['ม1', 'jan'],
                            ['ก2', 'feb'],
                            ['มี3', 'mar'],
                            ['เม4', 'apr'],
                            ['พฤ5', 'may'],
                            ['มิ6', 'jun'],
                            ['กค7', 'jul'],
                            ['ส8', 'aug'],
                            ['กย9', 'sep']
                        ];
                    ?>
                        <tr>
                            <td class="sticky-col" style="text-align:left; padding-left:10px;">
                                <?= Html::encode($row['กลุ่มงาน']) ?>
                            </td>
                            <?php foreach ($monthCodes as $code): 
                                $monthCode = $code[0];
                                $monthClass = $code[1];
                                $hasError = isset($row[$monthCode . '_ติดC']) && $row[$monthCode . '_ติดC'] == 1;
                            ?>
                                <td class="<?= $hasError ? 'bg-red' : 'month-' . $monthClass ?> month-group">
                                    <?= number_format($row[$monthCode . '_ทั้งหมด'] ?? 0) ?>
                                </td>
                                <td class="<?= $hasError ? 'bg-red' : 'month-' . $monthClass ?>">
                                    <?= number_format($row[$monthCode . '_เคลม'] ?? 0) ?>
                                </td>
                                <td class="<?= $hasError ? 'bg-red' : 'month-' . $monthClass ?>">
                                    <?= number_format($row[$monthCode . '_ไม่ชดเชย'] ?? 0) ?>
                                </td>
                                <td class="<?= $hasError ? 'bg-red' : 'month-' . $monthClass ?>">
                                    <?= number_format($row[$monthCode . '_เรียกเก็บ'] ?? 0, 2) ?>
                                </td>
                                <td class="<?= $hasError ? 'bg-red' : 'month-' . $monthClass ?>">
                                    <?= number_format($row[$monthCode . '_ชดเชย'] ?? 0, 2) ?>
                                </td>
                                <td class="<?= $hasError ? 'bg-red' : 'month-' . $monthClass ?>">
                                    <?= ($row[$monthCode . '_ติดC'] ?? 0) == 1 ? '⚠' : '' ?>
                                </td>
                            <?php endforeach; ?>
                            <td class="total-col"><?= number_format($row['รวม_ทั้งหมด'] ?? 0) ?></td>
                            <td class="total-col"><?= number_format($row['ผลต่าง'] ?? 0, 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- คำอธิบาย -->
    <div style="margin-top: 20px; padding: 15px; background: #fff3cd; border-radius: 8px; border-left: 4px solid #ffc107;">
        <strong>📌 คำอธิบาย:</strong>
        <ul style="margin: 10px 0 0 20px;">
            <li><strong>ทั้งหมด:</strong> จำนวน visit ทั้งหมดในเดือนนั้น</li>
            <li><strong>เคลม:</strong> จำนวน visit ที่เคลมได้ (ไม่ถูก reject)</li>
            <li><strong>ไม่ชดเชย:</strong> จำนวน visit ที่ไม่ได้รับชดเชย (rejected หรือค่าว่าง)</li>
            <li><strong>เรียกเก็บ:</strong> ยอดเงินเรียกเก็บ (hosp_claim) หน่วยเป็นบาท</li>
            <li><strong>ชดเชย:</strong> ยอดเงินชดเชย (ret_statement) หน่วยเป็นบาท</li>
            <li><strong>ติดC (⚠):</strong> แสดงเมื่อจำนวนทั้งหมดไม่เท่ากับจำนวนเคลม (มีปัญหาต้องตรวจสอบ)</li>
            <li><strong>สีแดง:</strong> เซลล์ที่มีปัญหา (ติดC = 1) ต้องตรวจสอบข้อมูล</li>
            <li><strong>ผลต่าง:</strong> ยอดเรียกเก็บลบยอดชดเชย แสดงส่วนต่างที่ยังไม่ได้รับชดเชย</li>
        </ul>
    </div>

    <!-- ข้อมูลเพิ่มเติม -->
    <div style="margin-top: 20px; padding: 15px; background: #e7f3ff; border-radius: 8px; border-left: 4px solid #2196F3;">
        <strong>ℹ️ หมายเหตุ:</strong>
        <ul style="margin: 10px 0 0 20px;">
            <li><strong>ปีงบประมาณไทย</strong> ใช้ปี พ.ศ. ของปีสิ้นสุด เช่น ปีงบ 2568 = 1 ต.ค. 2567 - 30 ก.ย. 2568</li>
            <li>ข้อมูลที่แสดงเป็นข้อมูล OPD ที่ไม่ถูกยกเลิก (IS_CANCEL = 0)</li>
            <li>การคำนวณยอดเรียกเก็บและชดเชยใช้วันที่จาก datereg ของตาราง log_fdh_opd_ck</li>
            <li>หากพบเซลล์สีแดง แนะนำให้ตรวจสอบข้อมูลในเดือนนั้นๆ</li>
        </ul>
    </div>
</div>