<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Store;
use common\models\Device;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\equipments\models\ServiceoutSearch */
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
         <!--<?= Html::button('เพิ่มการส่งซ่อมภายนอก', ['value' => Url::to(['servciceout/create']), 'class' => 'btn btn-success','id'=>'modalButton']); ?>-->
        <?= Html::button('เพิ่มการส่งซ่อมภายนอก', ['value'=>Url::to(['serviceout/create']), 'class' => 'btn btn-success','id'=>'modalButton']); ?>
    </p>

    <?php Modal::begin([
        'id' => 'modal',
        'header' => '<h4>เพิ่มรายการส่งซ่อมร้านนอก</h4>',
        'size'=>'modal-lg',
        'footer' => '<a href="#" class="btn btn-danger" data-dismiss="modal">ปิด</a>',
        ]);
        echo "<div id='modalContent'></div>";
        Modal::end();
        ?>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'device.device_name',
            'device.spec',
            'symptom',
            'date_sent',
            'date_in',
             'price',
            // 'orther',
            [
              'attribute' => 'store.store_id',
              'value'=> 'store.store_name',
              'filter' => Html::activeDropDownList($searchModel, 'store_id',
              ArrayHelper::map(Store::find()->all(), 'store_id', 'store_name'),
              ['class' => 'form-control'])
            ],
             //'store.store_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
     <?php Pjax::end() ?>
</div>
</div>
