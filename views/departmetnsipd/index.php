<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DepartmetnsipdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'เพิ่มข้อมูลแผนกตรวจสอบเความสมบูรณ์เวชระเบียนผู้ป่วยใน');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-success box-solid">
<div class="departmetnsipd-index">
<div class="well">
   
    <p>
        <?= Html::a(Yii::t('app', '<i class="glyphicon glyphicon-plus"></i> เพิ่มข้อมูลแผนกผู้ป่วยใน'), ['create'], ['class' => 'btn btn-success']) ?>
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
