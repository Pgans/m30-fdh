<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'ตรวจสอบ C514';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index" style="background: linear-gradient(45deg, #b0e2d6, #d4f4e8); padding: 20px;">
    <h1 style="color: #333;"><?= Html::encode($this->title) ?></h1>
    <p style="color: #555; font-size: 14px; line-height: 1.6;">
        สำหรับการตรวจสอบการติด C514 เริ่มตั้งแต่ 1 ตุลาคม 2567-ปัจจุบัน   
        <strong>****สถานะการจำหน่ายผู้ป่วยใน****</strong>
    </p>
    <div class="well" style="background-color: #f7f7f7; border: 1px solid #ddd; padding: 20px; border-radius: 5px;">
        <?= GridView::widget([
            'dataProvider' => new \yii\data\ArrayDataProvider([
                'allModels' => $data,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'HN',
                    'label' => 'HN',
                    'headerOptions' => ['style' => 'background-color: #f1f1f1; color: #333;'],
                ],
                [
                    'attribute' => 'ADM_ID',
                    'label' => 'Admission ID',
                    'headerOptions' => ['style' => 'background-color: #f1f1f1; color: #333;'],
                ],
                [
                    'attribute' => 'DSC_TYPE',
                    'label' => 'Discharge Type',
                    'headerOptions' => ['style' => 'background-color: #f1f1f1; color: #333;'],
                ],
                [
                    'attribute' => 'DSC_DT',
                    'label' => 'Discharge Date',
                    'headerOptions' => ['style' => 'background-color: #f1f1f1; color: #333;'],
                ],
            ],
            'tableOptions' => [
                'class' => 'table table-striped table-bordered',
                'style' => 'background-color: #fff; border-collapse: separate; border-spacing: 0; box-shadow: 0 2px 5px rgba(0,0,0,0.1);',
            ],
        ]); ?>
    </div>
</div>

