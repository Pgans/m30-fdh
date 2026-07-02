<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KhaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Khas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kha-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Kha'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'workgroup_id',
            'document_id',
            'team_id',
            'dep_id',
            //'ha_name',
            //'filename',
            //'is_update',
            //'create_date',
            //'d_update',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
