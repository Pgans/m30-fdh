<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AuthenkioskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Authenkiosks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="authenkiosk-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Authenkiosk', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'hospcode',
            'cid',
            'visit_id',
            'claimtype',
            //'claimcode',
            //'mobile',
            //'dep_name',
            //'authen_date',
            //'d_update',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
