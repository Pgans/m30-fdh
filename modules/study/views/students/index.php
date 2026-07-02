<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Faculty;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\study\models\StudentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'นักศึกษาฝึกงาน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-danger box-solid">
  <div class ="box-header">
          <h3 class = "box-title"><i class="fa fa-home"></i> <?= Html::encode($this->title) ?></h3>
            </div>
          <div class="box-body">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('เพิ่มนักศึกษาฝึกงาน', ['value'=>Url::to(['students/create']), 'class' => 'btn btn-success','id'=>'modalButton']); ?>
    </p>
    <?php Modal::begin([
        'id' => 'modal',
        'header' => '<h4>เพิ่มนักศึกษาฝึกงาน</h4>',
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
        'panel'=> [
          'before'=> ''
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          //  'id',
            'stud_id',
            'fullname',
            'address',
            'email:email',
            // 'tel',
             'faculty.faculty_name',
             'university.university_name',
             'train_at',
             'traint_out',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end() ?>
</div>
</div>
