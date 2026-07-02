<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ImporttextSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Importtxts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="importtxt-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Importtxt', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'auto_id',
            'rep',
            'id',
            'train_id',
            'hn',
            //'an',
            //'pid',
            //'fullname',
            //'main',
            //'regdate',
            //'discharge',
            //'ins',
            //'pp',
            //'errorcode',
            //'sub',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
