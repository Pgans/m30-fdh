<?php
use yii\helpers\Html;

$this->registerCss(<<<CSS
.modern-table-container {
    max-width: 1000px;
    margin: 30px auto;
    padding: 25px;
    background: #f0faff;
    border: 1px solid #b3e5fc;
    border-radius: 15px;
    box-shadow: 0 8px 24px rgba(0, 123, 255, 0.15);
    font-family: 'Sarabun', sans-serif;
}

.modern-table-container h4 {
    color: #007acc;
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
    font-weight: bold;
    text-shadow: 1px 1px 0px #fff;
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
    background-color: #ffffff;
    color: #333;
}

.modern-table thead {
    background-color: #0288d1;
    color: #ffffff;
    font-weight: bold;
}

.modern-table th, .modern-table td {
    border: 1px solid #dee2e6;
    padding: 10px 12px;
    text-align: center;
    font-size: 15px;
}

.modern-table tbody tr:hover {
    background-color: #e0f7fa;
    transition: background-color 0.3s ease;
}

.modern-table tbody td {
    color: #004d40;
}
CSS
);
?>
<style>
/* ปิด Left Menu และขยายพื้นที่ content */
.sidebar,
.main-sidebar,
.sidebar-menu {
    display: none !important;
}

.content-wrapper, .content {
    margin-left: 0 !important;
}
</style>
<div class="modern-table-container">
    <h4>ตรวจสอบรายการที่ไม่ระบุกองทุน  หรือยังไม่ได้ส่ง เดือนที่ <?= Html::encode($month) ?></h4>
    <table class="modern-table">
        <thead>
            <tr>
                <th>AN</th>
                <th>HN</th>
                <th>ชื่อ</th>
                <th>สกุล</th>
                <th>Ward</th>
                <th>วันที่จำหน่าย</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= Html::encode($row['AN']) ?></td>
                    <td><?= Html::encode($row['HN']) ?></td>
                    <td><?= Html::encode($row['fname']) ?></td>
                    <td><?= Html::encode($row['lname']) ?></td>
                    <td><?= Html::encode($row['ward_no']) ?></td>
                    <td><?= Html::encode($row['dsc_dt']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
