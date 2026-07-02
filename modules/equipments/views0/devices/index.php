<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Categories;
use common\models\Departments;

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
        <?= Html::a('เพิ่มอุปกรณ์', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
              ArrayHelper::map(categories::find()->all(), 'category_id', 'category_name'),
              ['class' => 'form-control'])
            ],

            'departments.dep_name',
            // 'spec',
            'purchase_date',
             'due_date',
             'price',
             //'sale_date',
            // 'orther',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
</div>
