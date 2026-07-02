<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

?>
<div class="panel panel-primary">
                        <div class="panel-heading"><i class="glyphicon glyphicon-user"></i>ITA66</div>
                        <div class="panel-body">
                        <div class="row">
    
    <div class="site-index">
	<p>
        <?= Html::a('เพิ่มข้อมูล ita2566', ['create'], ['class' => 'btn btn-success btn-lg']) ?>
   
    <!--<?= Html::button('<i class="glyphicon glyphicon-plus"></i>เพิ่มข้อมูล ita2566', ['value'=>Url::to(['ita66/create']), 'class' =>
     'btn btn-warning btn-lg','id'=>'modalButton']); ?> -->
     <?= Html::a('รองรับประเภทไฟล์ pdf, doc, docx, xls, xlsx')?></p>
    </p>
<?php Modal::begin([
    'id' => 'modal',
    // 'header' => '<h4><a color-blue>CREATE CUALITY FILES</a></h4>',
    'size'=>'modal-lg',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">ปิด</a>',
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
    ?>
    <!-- <?php Pjax::begin()?> -->
  <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => [
          ['class' => 'yii\grid\SerialColumn'],
          'title',
          ['attribute'=>'covenant','value'=>function($model){return $model->listDownloadFiles('covenant');},'format'=>'html'],
          'fiscal',
          'create_date',
          ['class' => 'yii\grid\ActionColumn',
          'header'=>'คลิกดู',
          'headerOptions' => ['style' => 'width:13%'],
          'template'=>'<div class="btn-group btn-group-sm text-center" role="group"> {detail} {edit} {del} </div>',
          'buttons'=>[
              'edit' => function($url,$model,$key){
                  return Html::a('แนบไฟล์',
                      ['update', 'id' => $model->id],
                      ['class' => 'btn btn-warning'],
                      $url);
              },
              //'del' => function($url,$model,$key){
               //   return Html::a('ลบ',
                //      ['delete', 'id' => $model->id],
                //      ['class' => 'btn btn-danger'],
                //      $url);
              //},
          ],
      ],

        ],
        'layout' => '{items}{pager}',
  ]); ?>
 <? Pjax::end() ?>
</div>
<?php
$this->registerJsFile('@web/js/main.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
 ?>