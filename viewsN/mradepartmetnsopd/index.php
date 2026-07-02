<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MradepartmetnsopdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'จัดการแผนกผู้ป่วยนอก');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary box-solid">
<div class="mradepartmetnsopd-index">
<div class="well">


    <p>
        <?= Html::a(Yii::t('app', '<i class="glyphicon glyphicon-plus"></i> เพิ่มแผนกผู้ป่วยนอก'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'unit_id',
            'unit_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
