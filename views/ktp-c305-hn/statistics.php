<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'สถิติข้อมูล C305 รายเดือน';
$this->params['breadcrumbs'][] = ['label' => 'รายงาน C305', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// คำนวณสรุปรวมทั้งหมด
$grandTotal = 0;
$grandWithReason = 0;
$grandWithoutReason = 0;

foreach ($monthlyStats as $stats) {
    $grandTotal += $stats['total'];
    $grandWithReason += $stats['withReason'];
    $grandWithoutReason += $stats['withoutReason'];
}

// แปลง array เป็น format สำหรับ GridView
$gridData = [];
foreach ($monthlyStats as $monthKey => $stats) {
    $gridData[] = array_merge(
        ['monthKey' => $monthKey],
        $stats
    );
}

$dataProvider = new \yii\data\ArrayDataProvider([
    'allModels' => $gridData,
    'pagination' => [
        'pageSize' => 12,
    ],
    'sort' => [
        'attributes' => ['label', 'total', 'withReason', 'withoutReason'],
    ],
]);
?>

<div class="t305-statistics">
    <h1 style="color: #4a90e2; font-weight: 600; margin-bottom: 30px;">
        <i class="fa fa-calendar"></i> <?= Html::encode($this->title) ?>
    </h1>

    <!-- การ์ดสรุปรวมทั้งหมด -->
    <div class="summary-card">
        <div class="summary-header">
            <i class="fa fa-chart-bar"></i>
            <span>สรุปรวมทั้งหมด</span>
        </div>
        
        <div class="summary-body">
            <!-- ข้อมูลรวมทั้งหมด -->
            <div class="summary-total">
                <div class="summary-icon">
                    <i class="fa fa-database"></i>
                </div>
                <div class="summary-info">
                    <div class="summary-label">รวมทั้งหมด</div>
                    <div class="summary-number"><?= number_format($grandTotal) ?></div>
                </div>
            </div>
            
            <!-- Grid แสดงสถิติ -->
            <div class="summary-grid">
                <!-- มีเหตุผล -->
                <div class="summary-item summary-green">
                    <div class="summary-item-header">
                        <i class="fa fa-check-circle"></i>
                        <span>มีเหตุผล</span>
                    </div>
                    <div class="summary-item-body">
                        <div class="summary-count"><?= number_format($grandWithReason) ?></div>
                        <div class="summary-percent">
                            <?= $grandTotal > 0 ? number_format(($grandWithReason/$grandTotal)*100, 2) : 0 ?>%
                        </div>
                    </div>
                    <div class="summary-progress">
                        <div class="summary-progress-bar summary-progress-green" 
                             style="width: <?= $grandTotal > 0 ? ($grandWithReason/$grandTotal)*100 : 0 ?>%">
                        </div>
                    </div>
                </div>
                
                <!-- ไม่มีเหตุผล -->
                <div class="summary-item summary-orange">
                    <div class="summary-item-header">
                        <i class="fa fa-exclamation-circle"></i>
                        <span>ไม่มีเหตุผล</span>
                    </div>
                    <div class="summary-item-body">
                        <div class="summary-count"><?= number_format($grandWithoutReason) ?></div>
                        <div class="summary-percent">
                            <?= $grandTotal > 0 ? number_format(($grandWithoutReason/$grandTotal)*100, 2) : 0 ?>%
                        </div>
                    </div>
                    <div class="summary-progress">
                        <div class="summary-progress-bar summary-progress-orange" 
                             style="width: <?= $grandTotal > 0 ? ($grandWithoutReason/$grandTotal)*100 : 0 ?>%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- หัวข้อรายเดือน -->
    <h2 style="color: #2c3e50; font-weight: 600; margin: 40px 0 20px 0; font-size: 22px;">
        <i class="fa fa-calendar-alt"></i> รายละเอียดแต่ละเดือน
    </h2>

    <!-- GridView แสดงข้อมูลรายเดือน -->
    <div class="gridview-container">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table table-bordered table-hover monthly-table'],
            'summary' => '<div class="summary-text">แสดง {begin}-{end} จากทั้งหมด {totalCount} เดือน</div>',
            'columns' => [
                [
                    'label' => 'ลำดับ',
                    'headerOptions' => ['style' => 'width: 80px; text-align: center;'],
                    'contentOptions' => ['style' => 'text-align: center; font-weight: 600;'],
                    'value' => function ($model, $key, $index, $column) {
                        return $index + 1;
                    },
                ],
                [
                    'attribute' => 'label',
                    'label' => 'เดือน/ปี',
                    'headerOptions' => ['style' => 'width: 200px;'],
                    'contentOptions' => ['style' => 'font-weight: 600; font-size: 15px;'],
                    'format' => 'raw',
                    'value' => function ($model) {
                        return '<i class="fa fa-calendar-o" style="color: #4facfe; margin-right: 8px;"></i>' . 
                               Html::encode($model['label']);
                    },
                ],
                [
                    'attribute' => 'total',
                    'label' => 'รวมทั้งหมด',
                    'headerOptions' => ['style' => 'width: 150px; text-align: center;'],
                    'contentOptions' => ['style' => 'text-align: center;'],
                    'format' => 'raw',
                    'value' => function ($model) {
                        return '<span class="badge-total">' . number_format($model['total']) . '</span>';
                    },
                ],
                [
                    'attribute' => 'withReason',
                    'label' => 'มีเหตุผล',
                    'headerOptions' => ['style' => 'width: 180px; text-align: center;'],
                    'contentOptions' => ['style' => 'text-align: center;'],
                    'format' => 'raw',
                    'value' => function ($model) {
                        $percent = $model['total'] > 0 ? 
                            number_format(($model['withReason']/$model['total'])*100, 1) : 0;
                        return '<div class="stat-badge stat-badge-green">' .
                               '<span class="badge-count">' . number_format($model['withReason']) . '</span>' .
                               '<span class="badge-percent">' . $percent . '%</span>' .
                               '</div>';
                    },
                ],
                [
                    'attribute' => 'withoutReason',
                    'label' => 'ไม่มีเหตุผล',
                    'headerOptions' => ['style' => 'width: 180px; text-align: center;'],
                    'contentOptions' => ['style' => 'text-align: center;'],
                    'format' => 'raw',
                    'value' => function ($model) {
                        $percent = $model['total'] > 0 ? 
                            number_format(($model['withoutReason']/$model['total'])*100, 1) : 0;
                        return '<div class="stat-badge stat-badge-orange">' .
                               '<span class="badge-count">' . number_format($model['withoutReason']) . '</span>' .
                               '<span class="badge-percent">' . $percent . '%</span>' .
                               '</div>';
                    },
                ],
                [
                    'label' => 'สัดส่วน',
                    'headerOptions' => ['style' => 'width: 200px; text-align: center;'],
                    'contentOptions' => ['style' => 'padding: 15px;'],
                    'format' => 'raw',
                    'value' => function ($model) {
                        $withPercent = $model['total'] > 0 ? 
                            ($model['withReason']/$model['total'])*100 : 0;
                        $withoutPercent = $model['total'] > 0 ? 
                            ($model['withoutReason']/$model['total'])*100 : 0;
                        
                        return '<div class="progress-container">' .
                               '<div class="progress-bar">' .
                               '<div class="progress-fill progress-green" style="width: ' . $withPercent . '%"></div>' .
                               '<div class="progress-fill progress-orange" style="width: ' . $withoutPercent . '%"></div>' .
                               '</div>' .
                               '</div>';
                    },
                ],
                [
                    'label' => 'การจัดการ',
                    'headerOptions' => ['style' => 'width: 150px; text-align: center;'],
                    'contentOptions' => ['style' => 'text-align: center;'],
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::a(
                            '<i class="fa fa-eye"></i> รายละเอียด',
                            ['month-detail', 'month' => $model['monthKey']],
                            [
                                'class' => 'btn-detail',
                                'title' => 'ดูรายละเอียด ' . $model['label'],
                            ]
                        );
                    },
                ],
            ],
        ]); ?>
    </div>

    <!-- ปุ่มกลับ -->
    <div class="button-group">
        <?= Html::a(
            '<i class="fa fa-arrow-left"></i> กลับหน้ารายงาน', 
            ['index'], 
            ['class' => 'btn-modern btn-primary']
        ) ?>
        
        <?= Html::a(
            '<i class="fa fa-download"></i> ดาวน์โหลด CSV', 
            ['export'], 
            [
                'class' => 'btn-modern btn-secondary',
                'data-method' => 'post',
            ]
        ) ?>
    </div>

</div>

<style>
/* สี Gradient */
:root {
    --blue-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --green-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    --orange-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    --purple-gradient: linear-gradient(135deg, #667eea 0%, #02e898 100%);
}

/* ===== การ์ดสรุปรวม ===== */
.summary-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    overflow: hidden;
    margin-bottom: 40px;
    border: 3px solid #e3f2fd;
}

.summary-header {
    background: var(--purple-gradient);
    padding: 25px 30px;
    color: white;
    font-size: 24px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 15px;
}

.summary-header i {
    font-size: 28px;
}

.summary-body {
    padding: 35px 30px;
}

/* ข้อมูลรวมทั้งหมด */
.summary-total {
    display: flex;
    align-items: center;
    gap: 25px;
    padding: 25px;
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    border-radius: 16px;
    margin-bottom: 30px;
    border: 2px solid #4facfe;
}

.summary-icon {
    width: 80px;
    height: 80px;
    background: var(--blue-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 36px;
    flex-shrink: 0;
}

.summary-info {
    flex: 1;
}

.summary-label {
    font-size: 18px;
    font-weight: 600;
    color: #64748b;
    margin-bottom: 8px;
}

.summary-number {
    font-size: 48px;
    font-weight: 900;
    color: #1e293b;
    line-height: 1;
}

/* Grid สถิติ */
.summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}

.summary-item {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.summary-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}

.summary-green {
    border-left: 5px solid #22c55e;
}

.summary-orange {
    border-left: 5px solid #f97316;
}

.summary-item-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    font-size: 18px;
    font-weight: 600;
    color: #2c3e50;
}

.summary-item-header i {
    font-size: 24px;
}

.summary-green .summary-item-header i {
    color: #22c55e;
}

.summary-orange .summary-item-header i {
    color: #f97316;
}

.summary-item-body {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    margin-bottom: 15px;
}

.summary-count {
    font-size: 36px;
    font-weight: 800;
    color: #1e293b;
}

.summary-percent {
    font-size: 20px;
    font-weight: 700;
    color: #64748b;
    background: #f1f5f9;
    padding: 6px 16px;
    border-radius: 20px;
}

.summary-progress {
    height: 10px;
    background: #f1f5f9;
    border-radius: 10px;
    overflow: hidden;
}

.summary-progress-bar {
    height: 100%;
    transition: width 0.8s ease;
    border-radius: 10px;
}

.summary-progress-green {
    background: var(--green-gradient);
}

.summary-progress-orange {
    background: var(--orange-gradient);
}

/* ===== GridView Container ===== */
.gridview-container {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    margin-bottom: 30px;
}

.summary-text {
    padding: 15px;
    color: #64748b;
    font-size: 14px;
    font-weight: 600;
}

/* ===== Table Styling ===== */
.monthly-table {
    margin-bottom: 0 !important;
    border-collapse: separate !important;
    border-spacing: 0 !important;
    border-radius: 12px !important;
    overflow: hidden;
}

.monthly-table thead th {
    background: linear-gradient(135deg, #2ed5f2 0%, #02e898 100%) !important;
    color: white !important;
    font-weight: 700 !important;
    font-size: 14px !important;
    padding: 18px 15px !important;
    border: none !important;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.monthly-table tbody td {
    padding: 15px !important;
    vertical-align: middle !important;
    border: 1px solid #e2e8f0 !important;
    font-size: 14px;
    color: #2c3e50;
}

.monthly-table tbody tr {
    transition: all 0.3s ease;
}

.monthly-table tbody tr:hover {
    background-color: #f8fafc !important;
    transform: scale(1.01);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

/* ===== Badge Styling ===== */
.badge-total {
    display: inline-block;
    padding: 8px 20px;
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
    border-radius: 20px;
    font-weight: 700;
    font-size: 16px;
}

.stat-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 8px 16px;
    border-radius: 12px;
    font-weight: 600;
}

.stat-badge-green {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border: 2px solid #22c55e;
}

.stat-badge-orange {
    background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
    border: 2px solid #f97316;
}

.badge-count {
    font-size: 16px;
    color: #2c3e50;
}

.stat-badge-green .badge-percent {
    color: #16a34a;
    background: white;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 13px;
}

.stat-badge-orange .badge-percent {
    color: #ea580c;
    background: white;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 13px;
}

/* ===== Progress Bar in Table ===== */
.progress-container {
    width: 100%;
}

.progress-bar {
    display: flex;
    height: 20px;
    background: #f1f5f9;
    border-radius: 10px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    transition: width 0.6s ease;
}

.progress-green {
    background: var(--green-gradient);
}

.progress-orange {
    background: var(--orange-gradient);
}

/* ===== Button Detail ===== */
.btn-detail {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white !important;
    border-radius: 20px;
    text-decoration: none !important;
    font-weight: 600;
    font-size: 13px;
    transition: all 0.3s ease;
    border: none;
}

.btn-detail:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(79, 172, 254, 0.4);
    color: white !important;
    text-decoration: none !important;
}

.btn-detail i {
    font-size: 14px;
}

/* ===== Pagination ===== */
.pagination {
    margin-top: 20px;
    justify-content: center;
}

.pagination > li > a,
.pagination > li > span {
    color: #4facfe;
    border-radius: 8px;
    margin: 0 3px;
    border: 2px solid #e2e8f0;
    font-weight: 600;
}

.pagination > li > a:hover {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
    border-color: #4facfe;
}

.pagination > .active > a,
.pagination > .active > span {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
}

/* ปุ่ม */
.button-group {
    margin-top: 30px;
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.btn-modern {
    padding: 14px 32px;
    border-radius: 25px;
    border: none;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    text-decoration: none;
}

.btn-primary {
    background: var(--blue-gradient);
    color: white;
}

.btn-secondary {
    background: var(--green-gradient);
    color: white;
}

.btn-modern i {
    font-size: 16px;
}

/* Responsive */
@media (max-width: 768px) {
    .summary-total {
        flex-direction: column;
        text-align: center;
    }
    
    .summary-icon {
        width: 70px;
        height: 70px;
        font-size: 32px;
    }
    
    .summary-number {
        font-size: 36px;
    }
    
    .summary-grid {
        grid-template-columns: 1fr;
    }
    
    .gridview-container {
        padding: 15px;
        overflow-x: auto;
    }
    
    .monthly-table {
        font-size: 12px;
    }
    
    .monthly-table thead th {
        font-size: 12px !important;
        padding: 12px 8px !important;
    }
    
    .monthly-table tbody td {
        padding: 10px 8px !important;
    }
    
    .button-group {
        flex-direction: column;
    }
    
    .btn-modern {
        justify-content: center;
        width: 100%;
    }
}

/* Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.summary-card {
    animation: fadeIn 0.6s ease-out;
}

.gridview-container {
    animation: fadeIn 0.8s ease-out;
}
</style>