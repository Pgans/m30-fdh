<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogdtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Logdm ข้อมูลเบาหวาน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logdt-index">
    <!-- 
    <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <!-- <p>
        <?= Html::a('Create Logdt', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->
    
    
    <?= GridView::widget([
        'tableOptions' => [
            'class' => 'table table-striped table-hover1',
            'width' => '100%',
            'cellspacing' => '1'
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{items}\n{pager}", //
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            [
                'attribute' => 'regdate',
                'label' => 'วันรับบริการ',
                'headerOptions' => ['style' => 'background-color:#d9ddf4'],
                'contentOptions' => ['style' => 'text-overflow: ellipsis; white-space: nowrap; max-width: 10vw; overflow: hidden;'],

            ],
            [
                'attribute' => 'visit_id',
                'headerOptions' => ['style' => 'background-color:#d9ddf4'],

            ],
            [
                'attribute' => 'hn',
                'headerOptions' => ['style' => 'background-color:#d9ddf4'],

            ],
            [
                'attribute' => 'unit_name',
                'headerOptions' => ['style' => 'background-color:#d9ddf4'],

            ],
            [
                'attribute' => 'labname',
                'headerOptions' => ['style' => 'background-color:#d9ddf4'],
            ],
            [
                'attribute' => 'Diag',
                'headerOptions' => ['style' => 'background-color:#d9ddf4'],

            ],
            [
                'attribute' => 'refers',
                'headerOptions' => ['style' => 'background-color:#d9ddf4'],

            ],
            [
                'attribute' => 'status',
                'label' => 'สถานะ',
                'headerOptions' => ['style' => 'background-color:#d9ddf4'],
            ],

            [
                'attribute' => 'response',
                'label' => 'response',
                'headerOptions' => ['style' => 'background-color:#d9ddf4'],
            ],
            [
                'attribute' => 'claimcode',
                'headerOptions' => ['style' => 'background-color:#d9ddf4'],

            ],
            [
                'attribute' => 'users',
                'label' => 'ผู้ส่ง',
                'headerOptions' => ['style' => 'background-color:#d9ddf4'],
            ],
            [
                'attribute' => 'd_update',
                'label' => 'วันส่งข้อมูล',
                'headerOptions' => ['style' => 'background-color:#d9ddf4'],
            ],


            //  ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>