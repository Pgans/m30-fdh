<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogdtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Logdts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logdt-index">
<!-- 
    <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- <p>
        <?= Html::a('Create Logdt', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?= GridView::widget([
        'tableOptions' => [
			'class' => 'table table-striped table-hover1',
			'width'=>'100%',
			'cellspacing'=> '1'
			],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
               'headerOptions'=>[ 'style'=>'background-color:#EA8DF5'] ,
               
            ],
            [
                'attribute' => 'visit_id',
               'headerOptions'=>[ 'style'=>'background-color:#EA8DF5'] ,
               
            ],
            [
                'attribute' => 'pid',
               'headerOptions'=>[ 'style'=>'background-color:#EA8DF5'] ,
               
            ],
            
            [
                'attribute' => 'status',
                'label'=>'สถานะ',
            'headerOptions'=>[ 'style'=>'background-color:#EA8DF5'] ,
            ],
            [
                'attribute' => 'messagecode',
                'label'=>'Error',
                'headerOptions'=>[ 'style'=>'background-color:#EA8DF5'] ,
                'format'=>'raw',
                'value' => function ($model, $key, $index, $widget) {
                    return "<font  color='2E86C1'>" . $model['messagecode'] . "</font>"; 
            }, 
            ],
            [
                'attribute' => 'response',
                'label'=>'response',
            'headerOptions'=>[ 'style'=>'background-color:#EA8DF5'] ,
            ],
            [
                'attribute' => 'users',
                'label'=>'ผู้ส่ง',
            'headerOptions'=>[ 'style'=>'background-color:#EA8DF5'] ,
            ],
            [
                'attribute' => 'd_update',
                'label'=>'วันที่รับบริการ',
            'headerOptions'=>[ 'style'=>'background-color:#EA8DF5'] ,
            ],
            

    ['class' => 'yii\grid\ActionColumn'],
],
]);
?>
</div>
