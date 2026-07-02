<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogclosevisitsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'จองเคลม');
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- CSS สำหรับ gradient สีฟ้าอ่อน -->
<style>
    .gradient-bg {
        background: linear-gradient(to right, #f8f9f9  , #f4f6f6  ); /* ไล่สีฟ้าอ่อน */
         border-radius: 8px; /* ขอบมน */
        padding: 15px; /* ระยะห่างภายใน */
        border: 2px solid #b2babb ; /* เส้นขอบสีฟ้าเข้ม */
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* เพิ่มความชัดของเงา */
    }
</style>

<div class="logclosevisits-index">
    <div class="box box-info box-solid gradient-bg">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-file-text-o"></i> <?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    'visit_id',
                    'pid',
                   // 'status',
                   // 'messagecode',
                    'response',
                    'transaction_uid',
                    'users',
					'regdate',
                    'send_date',

                    //['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

        </div>
    </div>
</div>

