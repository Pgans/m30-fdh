<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VisitinvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Visit_invoices');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .gradient-background {
        background: linear-gradient(to bottom right, rgba(144, 238, 144, 0.7), rgba(255, 255, 255, 0.7)); /* เขียวอ่อน */
        border-radius: 8px; /* ปรับให้มุมมน */
        padding: 20px; /* เพิ่มระยะห่างภายใน */
    }
</style>
<div class="box box-success box-solid gradient-background">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-users"></i> <?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div class="visitinvoice-index">

            <h1><?= Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <!-- <p>
                <?= Html::a(Yii::t('app', 'Create Visitinvoice'), ['create'], ['class' => 'btn btn-success']) ?>
            </p> -->

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'visit_id',
                    'record_dt',
                    'invoice',
                    'amount',
                    'subtotal',
                    'is_cancel',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
