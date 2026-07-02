<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\LogdmhtdtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log_dmhtdts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logdmhtdt-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- <p>
        <?= Html::a('Create Logdmhtdt', ['create'], ['class' => 'btn btn-success']) ?>
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
                       'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,
                       
                    ],
					[
                        'attribute' => 'visit_id',
                       'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,
                       
                    ],
                    [
                        'attribute' => 'pid',
                       'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,
                       
                    ],
                    
                    [
                        'attribute' => 'status',
                        'label'=>'สถานะ',
                    'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,
                    ],
                    [
                        'attribute' => 'messagecode',
                        'label'=>'Error',
                        'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,
                        'format'=>'raw',
                        'value' => function ($model, $key, $index, $widget) {
                            return "<font  color='2E86C1'>" . $model['messagecode'] . "</font>"; 
                    }, 
                    ],
                    [
                        'attribute' => 'response',
                        'label'=>'response',
                    'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,
                    ],
					[
                        'attribute' => 'users',
                        'label'=>'ผู้ส่ง',
                    'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,
                    ],
					[
                        'attribute' => 'd_update',
                        'label'=>'วันที่รับบริการ',
                    'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,
                    ],
                    

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
     ?>
</div>
