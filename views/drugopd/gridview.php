<?php
use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Gridview';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-success box-solid">
    <div class='well'>
        <h1><?= Html::encode($this->title) ?></h1>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                // กำหนดคอลัมน์ที่คุณต้องการแสดงใน Gridview นี้
                // ตัวอย่าง:
                'id',
                'name',
                'amount',
                // ...
            ],
        ]); ?>

    </div>
</div>
