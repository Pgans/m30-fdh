<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Categories;
use common\models\Departments;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\equipment\models\DevicesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายการอุปกรณ์';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-success box-solid">
  <div class ="box-header">
          <h3 class = "box-title"><i class="fa fa-users"></i> <?= Html::encode($this->title) ?></h3>
            </div>
          <div class="box-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <!--<?= Html::a('เพิ่มอุปกรณ์', ['create'], ['class' => 'btn btn-success']) ?>-->
        <?= Html::button('เพิ่มอุปกรณ์', ['value'=>Url::to(['devices/create']),'class' => 'btn btn-success','id'=>'modalButton']); ?>
    </p>
    <?php Modal::begin([
        'id' => 'modal',
        'header' => '<h4>เพิ่มอุปกรณ์คอมพิวเตอร์ ศูนย์คอมพิวเตอร์ โรงพยาบาลม่วงสามสิบ</h4>',
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
          'panel' =>[
            'before'=> ''
          ],

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          //  'device_id',
            'device_serial',
            'device_name',
            [
              'attribute' => 'categories.category_id',
              'value'=> 'categories.category_name',
              'filter' => Html::activeDropDownList($searchModel, 'category_id',
              ArrayHelper::map(Categories::find()->all(), 'category_id', 'category_name'),
              ['prompt' => 'กรุณาเลือกประเภท'],
              ['class' => 'form-control'])
            ],

            [
              'attribute' => 'departments.dep_id',
              'value'=> 'departments.dep_name',
              'filter' => Html::activeDropDownList($searchModel, 'dep_id',
              ArrayHelper::map(Departments::find()->all(), 'dep_id', 'dep_name'),
              ['prompt' => 'กรุณาเลือกแผนก'],
              ['class' => 'form-control'])
            ],
            // 'spec',
            'purchase_date',
            'sale_date',
            'price',
            // 'orther',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end() ?>
</div>
</div>
