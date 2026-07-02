<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'รายละเอียด ' . $monthLabel;
$this->params['breadcrumbs'][] = ['label' => 'รายงาน C305', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'สถิติรายเดือน', 'url' => ['statistics']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="month-detail-page">
    <!-- Header -->
    <div class="page-header">
        <h1>
            <i class="fa fa-calendar-check"></i> 
            รายละเอียดข้อมูล <?= Html::encode($monthLabel) ?>
        </h1>
    </div>

    <!-- สรุปข้อมูลเดือน -->
    <div class="month-summary">
        <div class="summary-card-mini summary-total-mini">
            <div class="summary-icon-mini">
                <i class="fa fa-database"></i>
            </div>
            <div class="summary-content-mini">
                <div class="summary-value-mini"><?= number_format($totalCount) ?></div>
                <div class="summary-label-mini">รวมทั้งหมด</div>
            </div>
        </div>
        
        <div class="summary-card-mini summary-green-mini">
            <div class="summary-icon-mini">
                <i class="fa fa-check-circle"></i>
            </div>
            <div class="summary-content-mini">
                <div class="summary-value-mini"><?= number_format($withReasonCount) ?></div>
                <div class="summary-label-mini">มีเหตุผล</div>
                <div class="summary-percent-mini">
                    <?= $totalCount > 0 ? number_format(($withReasonCount/$totalCount)*100, 1) : 0 ?>%
                </div>
            </div>
        </div>
        
        <div class="summary-card-mini summary-orange-mini">
            <div class="summary-icon-mini">
                <i class="fa fa-exclamation-circle"></i>
            </div>
            <div class="summary-content-mini">
                <div class="summary-value-mini"><?= number_format($withoutReasonCount) ?></div>
                <div class="summary-label-mini">ไม่มีเหตุผล</div>
                <div class="summary-percent-mini">
                    <?= $totalCount > 0 ? number_format(($withoutReasonCount/$totalCount)*100, 1) : 0 ?>%
                </div>
            </div>
        </div>
    </div>

    <!-- GridView รายละเอียด -->
    <div class="detail-gridview-container">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table table-bordered table-hover detail-table'],
            'summary' => '<div class="grid-summary">แสดง {begin}-{end} จากทั้งหมด {totalCount} รายการ</div>',
            'columns' => [
                [
                    'label' => 'ลำดับ',
                    'headerOptions' => ['style' => 'width: 70px; text-align: center;'],
                    'contentOptions' => ['style' => 'text-align: center; font-weight: 600;'],
                    'value' => function ($model, $key, $index, $column) {
                        $pagination = $column->grid->dataProvider->pagination;
                        return $pagination->offset + $index + 1;
                    },
                ],
                [
                    'attribute' => 'regdate',
                    'label' => 'วันที่เข้ารับบริการ',
                    'headerOptions' => ['style' => 'width: 150px;'],
                    'format' => 'raw',
                    'value' => function ($model) {
                        if (empty($model['regdate'])) return '-';
                        $date = date('d/m/Y', strtotime($model['regdate']));
                        return '<span class="date-badge">' . $date . '</span>';
                    },
                ],
                [
                    'attribute' => 'hn',
                    'label' => 'HN',
                    'headerOptions' => ['style' => 'width: 120px;'],
                    'contentOptions' => ['style' => 'font-weight: 600;'],
                    'value' => function ($model) {
                        return $model['hn'] ?? '-';
                    },
                ],
                [
                    'label' => 'ชื่อ-นามสกุล',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $fullName = trim(
                            ($model['pname'] ?? '') . ' ' . 
                            ($model['fname'] ?? '') . ' ' . 
                            ($model['lname'] ?? '')
                        );
                        return !empty($fullName) ? Html::encode($fullName) : '-';
                    },
                ],
                [
                    'attribute' => 'reason',
                    'label' => 'เหตุผล',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if (!empty($model['reason'])) {
                            return '<div class="reason-badge reason-has">' .
                                   '<i class="fa fa-check-circle"></i> ' .
                                   Html::encode($model['reason']) .
                                   '</div>';
                        } else {
                            return '<div class="reason-badge reason-none">' .
                                   '<i class="fa fa-exclamation-circle"></i> ' .
                                   'ไม่มีเหตุผล' .
                                   '</div>';
                        }
                    },
                ],
                [
                    'label' => 'สถานะ',
                    'headerOptions' => ['style' => 'width: 120px; text-align: center;'],
                    'contentOptions' => ['style' => 'text-align: center;'],
                    'format' => 'raw',
                    'value' => function ($model) {
                        if (!empty($model['reason'])) {
                            return '<span class="status-badge status-complete">' .
                                   '<i class="fa fa-check"></i> ครบถ้วน' .
                                   '</span>';
                        } else {
                            return '<span class="status-badge status-incomplete">' .
                                   '<i class="fa fa-times"></i> ไม่ครบ' .
                                   '</span>';
                        }
                    },
                ],
            ],
        ]); ?>
    </div>

    <!-- ปุ่มกลับ -->
    <div class="button-group">
        <?= Html::a(
            '<i class="fa fa-arrow-left"></i> กลับหน้าสถิติ', 
            ['statistics'], 
            ['class' => 'btn-modern btn-primary']
        ) ?>
        
        <?= Html::a(
            '<i class="fa fa-download"></i> ดาวน์โหลด Excel', 
            ['export-month', 'month' => $month], 
            [
                'class' => 'btn-modern btn-success',
                'data-method' => 'post',
            ]
        ) ?>
    </div>
</div>

<style>
/* Page Header */
.page-header {
    margin-bottom: 30px;
}

.page-header h1 {
    color: #2c3e50;
    font-weight: 700;
    font-size: 28px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.page-header h1 i {
    color: #4facfe;
    font-size: 32px;
}

/* Month Summary Cards */
.month-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.summary-card-mini {
    background: white;
    border-radius: 16px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.summary-card-mini:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}

.summary-total-mini {
    border-left: 5px solid #4facfe;
}

.summary-green-mini {
    border-left: 5px solid #22c55e;
}

.summary-orange-mini {
    border-left: 5px solid #f97316;
}

.summary-icon-mini {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: white;
    flex-shrink: 0;
}

.summary-total-mini .summary-icon-mini {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.summary-green-mini .summary-icon-mini {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.summary-orange-mini .summary-icon-mini {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

.summary-content-mini {
    flex: 1;
}

.summary-value-mini {
    font-size: 32px;
    font-weight: 900;
    color: #1e293b;
    line-height: 1;
    margin-bottom: 5px;
}

.summary-label-mini {
    font-size: 14px;
    font-weight: 600;
    color: #64748b;
}

.summary-percent-mini {
    display: inline-block;
    margin-top: 5px;
    padding: 4px 12px;
    background: #f1f5f9;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 700;
    color: #64748b;
}

/* Detail GridView */
.detail-gridview-container {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    margin-bottom: 30px;
}

.grid-summary {
    padding: 15px;
    color: #64748b;
    font-size: 14px;
    font-weight: 600;
}

/* Detail Table */
.detail-table {
    margin-bottom: 0 !important;
    border-collapse: separate !important;
    border-spacing: 0 !important;
}

.detail-table thead th {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
    color: white !important;
    font-weight: 700 !important;
    font-size: 14px !important;
    padding: 15px 12px !important;
    border: none !important;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-table tbody td {
    padding: 12px !important;
    vertical-align: middle !important;
    border: 1px solid #e2e8f0 !important;
    font-size: 14px;
    color: #2c3e50;
}

.detail-table tbody tr {
    transition: all 0.2s ease;
}

.detail-table tbody tr:hover {
    background-color: #f8fafc !important;
}

/* Date Badge */
.date-badge {
    display: inline-block;
    padding: 6px 12px;
    background: linear-gradient(135deg, #e0f2fe 0%, #dbeafe 100%);
    color: #0284c7;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13px;
    border: 1px solid #bae6fd;
}

/* Reason Badge */
.reason-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 14px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 13px;
}

.reason-has {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    color: #16a34a;
    border: 1px solid #86efac;
}

.reason-has i {
    color: #22c55e;
}

.reason-none {
    background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
    color: #ea580c;
    border: 1px solid #fed7aa;
}

.reason-none i {
    color: #f97316;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 16px;
    font-weight: 600;
    font-size: 12px;
}

.status-complete {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: white;
}

.status-incomplete {
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: white;
}

/* Buttons */
.button-group {
    margin-top: 20px;
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.btn-modern {
    padding: 12px 28px;
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
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

.btn-success {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: white;
}

/* Pagination */
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
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    border-color: #4facfe;
}

/* Responsive */
@media (max-width: 768px) {
    .month-summary {
        grid-template-columns: 1fr;
    }
    
    .detail-gridview-container {
        padding: 15px;
        overflow-x: auto;
    }
    
    .detail-table {
        font-size: 12px;
    }
    
    .detail-table thead th {
        font-size: 12px !important;
        padding: 12px 8px !important;
    }
    
    .detail-table tbody td {
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
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.page-header {
    animation: slideDown 0.5s ease-out;
}

.month-summary {
    animation: fadeIn 0.6s ease-out;
}

.detail-gridview-container {
    animation: fadeIn 0.8s ease-out;
}
</style>