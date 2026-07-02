<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MraipdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mraipds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mraipd-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Mraipd', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'mra_id',
            'unit_id',
            'HN',
            'AN',
            'dr_license',
            //'date_admit',
            //'date_discharge',
            //'date_audit',
            //'NA1',
            //'Missing1',
            //'No1',
            //'dxop1',
            //'dxop2',
            //'dxop3',
            //'dxop4',
            //'dxop5',
            //'dxop6',
            //'dxop7',
            //'dxop8',
            //'dxop9',
            //'dxop_huk',
            //'NA2',
            //'Missing2',
            //'No2',
            //'other1',
            //'other2',
            //'other3',
            //'other4',
            //'other5',
            //'other6',
            //'other7',
            //'other8',
            //'other9',
            //'other_huk',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
