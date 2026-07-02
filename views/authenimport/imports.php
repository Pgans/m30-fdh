<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
//use yii\grid\GridView;
use yii\helpers\Url;
use kartik\grid\GridView;

$this->title = 'นำเข้าไฟล์Authencode';
$this->params['breadcrumbs'][] = $this->title;
?>
<br>
<?php if (Yii::$app->session->hasFlash('success')) : ?>
  <div class="alert alert-success">
    <?= Yii::$app->session->getFlash('success') ?>
  
    <!-- <p>จำนวนรายการที่นำเข้าสำเร็จ: <?= $importedCount ?></p> -->
    <p>จำนวนรายการที่นำเข้าใหม่: <?=  $newCount ?></p>
    <p>จำนวนรายการที่นำเข้าเดิม: <?= $importedCount ?></p>
    <p>จำนวนรายการในไฟล์ที่นำเข้าทั้งหมด: <?= $totalRows ?></p>



  </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')) : ?>
  <div class="alert alert-danger">
    <?= Yii::$app->session->getFlash('error') ?>
  </div>
<?php endif; ?>

<div class="well" style="background-color: #eee1f2;">
  <div class="box-header">
    <h4 class="box-title" style="color:#0080ff;"><i class="fa fa-users"></i> <?= Html::encode($this->title) ?></h4>
  </div>
  <div class="box-body">
    <h5 style="color: indigo;">รองรับไฟล์ .xls, xlsx</h5>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($modelImport, 'fileImport')->fileInput(['style' => 'background-color: #ff6600; color: #fff; border-color: #ff6600;']) ?>


    <?= Html::submitButton('นำเข้าไฟล์', ['class' => 'btn btn-success', 'style' => 'background-color: green;']); ?>

    <?php ActiveForm::end(); ?>
  </div>
</div>


<div class="repimport-index">
  <div class="well">
    <div class="box-header">
      <h3 class="box-title" style="color:#0080ff;"><i class="fa fa-users"></i>รายการข้อมูลนำเข้าแล้ว
    </div>
    <div class="box-body">



      <?php
      echo GridView::widget([
        'dataProvider' => $dataimport,
        // 'filterModel' => $searchModel,
        'columns' => [
          ['class' => 'yii\grid\SerialColumn'],

          'id',
          'visit_id',
          'cid',
        //   [
        //     'attribute' => 'visit_id',
        //     'value' => function ($model) {
        //         return $model->visit_id ? $model->visit_id : ''; // ถ้ามีข้อมูลให้แสดงค่า visit_id มิฉะนั้นแสดงค่าว่าง
        //     },
        // ],
          'claimtype',
          'claimcode',
          'mobile',
          'dep_name',
          // 'authen_date',
          'd_update',

          // ['class' => 'yii\grid\ActionColumn'],
        ],
      ]); ?>
    </div>