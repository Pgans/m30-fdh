<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

$this->title = 'รายละเอียดตามบุคคล - IPD';
?>

<style>
.person-details-container {
    background: #f5f7fa;
    padding: 20px;
    min-height: 100vh;
}

.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    border-radius: 15px;
    margin-bottom: 30px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.page-header h1 {
    margin: 0;
    font-size: 32px;
    font-weight: 600;
}

.filter-section {
    background: white;
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.date-filter-row {
    display: flex;
    gap: 15px;
    align-items: end;
}

.date-filter-row > div {
    flex: 1;
}

.table-section {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.section-title {
    font-size: 20px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 3px solid #f0f0f0;
}

.grid-view {
    overflow-x: auto;
}

.grid-view table {
    width: 100%;
    border-collapse: collapse;
}

.grid-view thead tr {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.grid-view thead th {
    padding: 15px;
    font-weight: 600;
    border: none;
}

.grid-view thead th a {
    color: white;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 5px;
}

.grid-view thead th a:hover {
    color: #ffd;
}

.grid-view tbody td {
    padding: 12px 15px;
    border-bottom: 1px solid #f0f0f0;
}

.grid-view tbody tr:hover {
    background-color: #f8f9fa;
}

.grid-view .filters input,
.grid-view .filters select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 13px;
}

.grid-view .filters input:focus,
.grid-view .filters select:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
}

.text-right {
    text-align: right;
}

.number-positive { 
    color: #6bc4a6; 
    font-weight: 600; 
}

.number-negative { 
    color: #ff9999; 
    font-weight: 600; 
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 10px 25px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: transform 0.2s;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.export-btn {
    background: linear-gradient(135deg, #7dd3c0 0%, #a8ffc8 100%);
    color: #2c3e50;
    padding: 10px 25px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: transform 0.2s;
    text-decoration: none;
    display: inline-block;
}

.export-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(125, 211, 192, 0.4);
    color: #2c3e50;
}

.summary-box {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    border-left: 5px solid #667eea;
}

.summary-box h3 {
    margin: 0 0 15px 0;
    color: #2c3e50;
    font-size: 18px;
}

.summary-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.stat-item {
    text-align: center;
}

.stat-label {
    color: #666;
    font-size: 13px;
    margin-bottom: 5px;
}

.stat-value {
    font-size: 24px;
    font-weight: 700;
    color: #2c3e50;
}

@media (max-width: 768px) {
    .date-filter-row {
        flex-direction: column;
    }
}
</style>

<div class="person-details-container">
    
    <div class="page-header">
        <h1>👤 รายละเอียดตามบุคคล</h1>
        <p style="margin: 10px 0 0 0; opacity: 0.9;">รายงานข้อมูลผู้ป่วยใน (IPD) แยกตามผู้ใช้งานและรายละเอียดการเคลม</p>
    </div>

    <div class="filter-section">
        <?= Html::beginForm(['ipd-dashboard/person-details'], 'get', ['id' => 'filterForm']) ?>
            <div class="date-filter-row">
                <div>
                    <label><strong>วันที่เริ่มต้น</strong></label>
                    <?= Html::input('date', 'start_date', $startDate, ['class' => 'form-control']) ?>
                </div>
                <div>
                    <label><strong>วันที่สิ้นสุด</strong></label>
                    <?= Html::input('date', 'end_date', $endDate, ['class' => 'form-control']) ?>
                </div>
                <div>
                    <?= Html::submitButton('🔍 ค้นหา', ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('📥 Export', ['export-person', 'start_date' => $startDate, 'end_date' => $endDate], ['class' => 'export-btn']) ?>
                    <?= Html::a('◀ กลับหน้าหลัก', ['index'], ['class' => 'btn btn-secondary']) ?>
                </div>
            </div>
        <?= Html::endForm() ?>
    </div>

    <?php if (!empty($personData)): ?>
    <div class="summary-box">
        <h3>📊 สรุปข้อมูลรวม</h3>
        <div class="summary-stats">
            <div class="stat-item">
                <div class="stat-label">จำนวนผู้ป่วยทั้งหมด</div>
                <div class="stat-value"><?= number_format(count($personData)) ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-label">ค่าเรียกเก็บรวม</div>
                <div class="stat-value"><?= number_format(array_sum(array_column($personData, 'hosp_claim')), 2) ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-label">ยอดตรวจสอบรวม</div>
                <div class="stat-value"><?= number_format(array_sum(array_column($personData, 'ret_statement')), 2) ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-label">ยอดชดเชยรวม</div>
                <div class="stat-value"><?= number_format(array_sum(array_column($personData, 'nhso_rep')), 2) ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-label">ส่วนต่างรวม</div>
                <div class="stat-value <?= array_sum(array_column($personData, 'difference')) >= 0 ? 'number-positive' : 'number-negative' ?>">
                    <?= array_sum(array_column($personData, 'difference')) >= 0 ? '+' : '' ?><?= number_format(array_sum(array_column($personData, 'difference')), 2) ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="table-section">
        <div class="section-title">
            📋 รายละเอียดข้อมูลผู้ป่วย
        </div>

        <?php
        $dataProvider = new ArrayDataProvider([
            'allModels' => $personData,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'attributes' => [
                    'date_admit',
                    'users',
                    'pt_type',
                    'master_fund',
                    'hn',
                    'an',
                    'hosp_claim',
                    'ret_statement',
                    'nhso_rep',
                    'difference',
                ],
                'defaultOrder' => [
                    'users' => SORT_ASC,
                    'date_admit' => SORT_DESC,
                ]
            ],
        ]);
        ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => null,
            'tableOptions' => ['class' => 'table table-striped table-bordered'],
            'rowOptions' => function ($model, $key, $index, $grid) {
                static $lastUser = null;
                $currentUser = $model['users'];
                
                if ($lastUser !== $currentUser) {
                    $lastUser = $currentUser;
                    return ['style' => 'border-top: 3px solid #667eea;'];
                }
                return [];
            },
            'columns' => [
                [
                    'attribute' => 'date_admit',
                    'label' => 'วันที่ Discharge',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if (!empty($model['date_admit'])) {
                            return '<strong>' . date('d/m/Y', strtotime($model['date_admit'])) . '</strong>';
                        }
                        return '-';
                    },
                    'filter' => Html::activeTextInput(new \yii\base\DynamicModel(['date_admit']), 'date_admit', [
                        'class' => 'form-control',
                        'placeholder' => 'กรองวันที่...'
                    ]),
                    'headerOptions' => ['style' => 'width: 120px;'],
                ],
                [
                    'attribute' => 'users',
                    'label' => 'ผู้ใช้งาน',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return '<strong style="color: #667eea;">' . Html::encode($model['users']) . '</strong>';
                    },
                    'filter' => Html::activeTextInput(new \yii\base\DynamicModel(['users']), 'users', [
                        'class' => 'form-control',
                        'placeholder' => 'กรองชื่อ...'
                    ]),
                    'headerOptions' => ['style' => 'width: 140px;'],
                ],
                [
                    'attribute' => 'hn',
                    'label' => 'HN',
                    'format' => 'text',
                    'filter' => Html::activeTextInput(new \yii\base\DynamicModel(['hn']), 'hn', [
                        'class' => 'form-control',
                        'placeholder' => 'HN...'
                    ]),
                    'headerOptions' => ['style' => 'width: 100px;'],
                ],
                [
                    'attribute' => 'an',
                    'label' => 'AN',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return '<strong>' . Html::encode($model['an']) . '</strong>';
                    },
                    'filter' => Html::activeTextInput(new \yii\base\DynamicModel(['an']), 'an', [
                        'class' => 'form-control',
                        'placeholder' => 'AN...'
                    ]),
                    'headerOptions' => ['style' => 'width: 100px;'],
                ],
                [
                    'attribute' => 'pt_type',
                    'label' => 'สิทธิ',
                    'format' => 'text',
                    'filter' => Html::activeTextInput(new \yii\base\DynamicModel(['pt_type']), 'pt_type', [
                        'class' => 'form-control',
                        'placeholder' => 'สิทธิ...'
                    ]),
                    'headerOptions' => ['style' => 'width: 80px;'],
                ],
                [
                    'attribute' => 'master_fund',
                    'label' => 'กองทุน',
                    'format' => 'text',
                    'filter' => Html::activeTextInput(new \yii\base\DynamicModel(['master_fund']), 'master_fund', [
                        'class' => 'form-control',
                        'placeholder' => 'กองทุน...'
                    ]),
                    'headerOptions' => ['style' => 'width: 100px;'],
                ],
                [
                    'attribute' => 'tran_id',
                    'label' => 'Tran ID',
                    'format' => 'text',
                    'headerOptions' => ['style' => 'width: 100px;'],
                ],
                [
                    'attribute' => 'rep_no',
                    'label' => 'Rep No',
                    'format' => 'text',
                    'headerOptions' => ['style' => 'width: 90px;'],
                ],
                [
                    'attribute' => 'hosp_claim',
                    'label' => 'ค่าเรียกเก็บ',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return number_format($model['hosp_claim'], 2);
                    },
                    'filter' => Html::activeTextInput(new \yii\base\DynamicModel(['hosp_claim']), 'hosp_claim', [
                        'class' => 'form-control',
                        'placeholder' => 'กรอง...',
                        'type' => 'number'
                    ]),
                    'contentOptions' => ['class' => 'text-right'],
                    'headerOptions' => ['class' => 'text-right', 'style' => 'width: 120px;'],
                ],
                [
                    'attribute' => 'ret_statement',
                    'label' => 'ยอดตรวจสอบ',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return number_format($model['ret_statement'], 2);
                    },
                    'filter' => Html::activeTextInput(new \yii\base\DynamicModel(['ret_statement']), 'ret_statement', [
                        'class' => 'form-control',
                        'placeholder' => 'กรอง...',
                        'type' => 'number'
                    ]),
                    'contentOptions' => ['class' => 'text-right'],
                    'headerOptions' => ['class' => 'text-right', 'style' => 'width: 120px;'],
                ],
                [
                    'attribute' => 'nhso_rep',
                    'label' => 'ยอดชดเชย',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return number_format($model['nhso_rep'], 2);
                    },
                    'filter' => Html::activeTextInput(new \yii\base\DynamicModel(['nhso_rep']), 'nhso_rep', [
                        'class' => 'form-control',
                        'placeholder' => 'กรอง...',
                        'type' => 'number'
                    ]),
                    'contentOptions' => ['class' => 'text-right'],
                    'headerOptions' => ['class' => 'text-right', 'style' => 'width: 120px;'],
                ],
                [
                    'attribute' => 'difference',
                    'label' => 'ส่วนต่าง',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $class = $model['difference'] >= 0 ? 'number-positive' : 'number-negative';
                        $sign = $model['difference'] >= 0 ? '+' : '';
                        return '<span class="' . $class . '">' . $sign . number_format($model['difference'], 2) . '</span>';
                    },
                    'contentOptions' => ['class' => 'text-right'],
                    'headerOptions' => ['class' => 'text-right', 'style' => 'width: 110px;'],
                ],
            ],
        ]); ?>

    </div>

</div>

<script>
// เพิ่ม loading effect เมื่อกด submit
document.getElementById('filterForm').addEventListener('submit', function() {
    const overlay = document.createElement('div');
    overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    `;
    overlay.innerHTML = `
        <div style="text-align: center; color: white;">
            <div style="border: 8px solid #f3f3f3; border-top: 8px solid #667eea; border-radius: 50%; width: 60px; height: 60px; animation: spin 1s linear infinite; margin: 0 auto 20px;"></div>
            <p style="font-size: 18px; font-weight: 600;">กำลังโหลดข้อมูล...</p>
        </div>
        <style>
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>
    `;
    document.body.appendChild(overlay);
});
</script>