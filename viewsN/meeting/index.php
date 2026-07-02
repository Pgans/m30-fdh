<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MeetingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'E-Meetings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meeting-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <div class="box box-default box-solid" >
    <div class="box-header" id="grad8">
        <div class="box-title"> E-Meeting<small> MuangSamSib Hospital</small></div>
    </div>
    <div class="box-body">
    <p>
        <?= Html::a(Yii::t('app', '<i class="glyphicon glyphicon-plus"></i>เพิ่มการประชุม'), ['create'], ['class' => 'btn btn-success btn-lg']) ?>
    </p>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'meeting_id',
           [
            'attribute' => 'title',
            'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,  
            'format' => 'raw', // Set format to 'raw' for HTML output
            'value' => function ($model) {
                return Html::a(Html::encode($model->title), ['view', 'id' => $model->meeting_id]);
            },
        ],
            [
                'attribute'=>'attime',
                'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,            
            ],
            [
                'attribute'=>'date',
                'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,            
            ],
            [
                'attribute'=>'time',
                'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,            
            ],
            [
                'attribute'=>'user',
                'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,            
            ],
            [
                'attribute'=>'create_date',
                'headerOptions'=>[ 'style'=>'background-color:#a4e7df'] ,            
            ],
           

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
