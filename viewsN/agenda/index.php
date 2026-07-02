<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\models\Meeting;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AgendaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Agendas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-defualt box-solid">
<div class ="box-header" id="grad8">
          <h3 class = "box-title"><i class="fa fa-users"></i> วาระการประชุม</h3>
            </div>
          <div class="box-body">
          <p>
            <?php 
             echo Html::a('<i class="glyphicon glyphicon-plus"></i>1.เพิ่มหัวข้อการประชุม', ['meeting/create'], ['class' => 'btn btn-primary btn-lg' , 'style' => 'margin-left:5px','target'=>'_blank']);
             ?>
       
        <?= Html::a(Yii::t('app', '<i class="glyphicon glyphicon-plus"></i>2.เพิ่มวาระการประชุม'), ['create'], ['class' => 'btn btn-success btn-lg']) ?>
       </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'agenda_id',
            'meet.title',
           // 'ref',
            'topic',
            'discription:ntext',
            ['attribute'=>'covenant','value'=>function($model){return $model->listDownloadFiles('covenant');},'format'=>'html'],
            //'docs',
            'create_date',
            //'view',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
<h1><?= Html::encode($meeting->title) ?></h1>

<table>
    <tr>
        <th>Topic</th>
        <th>Description</th>
        <th>Meeting Link</th>
    </tr>
    <?php foreach ($meeting->agendas as $agenda): ?>
        <tr>
            <td><?= Html::encode($agenda->topic) ?></td>
            <td><?= Html::encode($agenda->description) ?></td>
            <td><?= Html::a('Go to Meeting', ['meeting/view', 'id' => $agenda->meeting_id]) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
