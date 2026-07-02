<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel backend\modules\opdcard\models\PermitsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ยืมคืนเวชระเบียน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-warning box-solid">
  <div class ="box-header">
          <h3 class = "box-title"><i class="fa fa-home"></i> <?= Html::encode($this->title) ?></h3>
            </div>
          <div class="box-body">
    <p>
         <?= Html::button('เพิ่มข้อมูล', ['value' => Url::to(['permits/create']), 'class' => 'btn btn-success','id'=>'modalButton']); ?>
        <!--<?= Html::a('เพิ่มการยืม', ['create'], ['class' => 'btn btn-success']) ?>-->
        <?= Html::a('เงื่อนไข:', ['create'], ['class' => 'btn btn-danger']) ?>
        <?= Html::a('กำหนดการคืนเวชระเบียนภายใน 7 วัน', ['create'], ['class' => 'btn btn-danger']) ?>
    </p>
    <?php Modal::begin([
        'id' => 'modal',
        'header' => '<h4>เพิ่มการยืมแฟ้มเวชระเบียน</h4>',
        'size'=>'modal-lg',
        'footer' => '<a href="#" class="btn btn-danger" data-dismiss="modal">ปิด</a>',
        ]);
        echo "<div id='modalContent'></div>";
        Modal::end();
    ?>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'AN',
            'HN',
            'fullname',
            'treatments.treatment_name',
            'createdBy.firstname',
            'createdBy.lastname',
            'created_at',
            'updater.firstname',
            'updater.lastname',
            'updated_at',
            'status.status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
        <?php Pjax::end() ?>
    </div>
</div>
