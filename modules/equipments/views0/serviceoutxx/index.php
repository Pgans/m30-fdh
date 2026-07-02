<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\devices;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\equipment\models\ServiceoutSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ส่งซ่อมภายนอก';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary box-solid">
  <div class ="box-header">
          <h3 class = "box-title"><i class="fa fa-users"></i> <?= Html::encode($this->title) ?></h3>
            </div>
          <div class="box-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('เพิ่มการส่งซ่อมภายนอก', ['create'], ['class' => 'btn btn-info']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
          'before' => ''
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'device.device_name',
            'categories.category_name',
            'symptom',
            'date_sent',
            'date_in',
            'price',
            'orther',
            'store.store_name',


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
</div>
