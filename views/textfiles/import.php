<?php 
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\bootstrap\Modal;
    use yii\web\JsExpression;
    use yii\helpers\Url;
    use yii\widgets\Pjax;
    
$this->title = 'นำเข้าไฟล์ Paliiiative';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="box box-info box-solid">
<div class ="box-header">
          <h3 class = "box-title"><i class="fa fa-users"></i> <?= Html::encode($this->title) ?></h3>
            </div>
          <div class="box-body">
<h4>รองรับไฟล์ .xls, xlsx</h4>
<?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]);?>

<?= $form->field($modelImport,'fileImport')->fileInput() ?>

<?= Html::submitButton('<i class="glyphicon glyphicon-plus"></i> บันทึกการนำเข้าไฟล์',['class'=>'btn btn-success']);?>
<?php echo Html::a('<i class="glyphicon glyphicon-download"></i> ส่งออก-ดาวน์โหลด', ['textfiles/exporttextnon'], ['class' => 'btn btn-warning', 'style' => 'margin-left:5px','target'=>'_blank']); ?>

<?= Html::button('<i class="glyphicon glyphicon-minus"></i> Open View', ['value'=>Url::to(['textfiles/exporttextnon']), 'class' => 'btn btn-danger','id'=>'modalButton']); ?>
<?php   Html::a('Flash Link', '#', ['class' => 'flash-link']) ?> 

<?php 
// Generate the URL for browsing the folder
//$folderPath = 'web/exports/palliative/'; // Replace with the actual folder path
$browseUrl = Yii::getAlias('@web') . '/exports/palliative/';

// Create the link to browse the folder
//echo Html::a('Browse Folder', $browseUrl);
?>
<?php Modal::begin([
        'id' => 'modal',
        'header' => '<h4><a color-blue>CREATE PERMITS</a></h4>',
        'size'=>'modal-lg',
        'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">ปิด</a>',
        ]);
        echo "<div id='modalContent'></div>";
        Modal::end();
        ?> 
        <?php ActiveForm::end();?>
    <?php Pjax::begin(); ?>
    
  </div>
</div>

<div class="palliative-index">
<div class="box box-primary box-solid">
<div class ="box-header">
          <h3 class = "box-title"><i class="fa fa-users"></i>รายการข้อมูลนำเข้าแล้ว</div>
          <div class="box-body">
    <?php
		echo GridView::widget([
        'dataProvider' =>$importdataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'auto_id',
            'hospcode',
            'date_serv',
            'hn',
            'cid',
            'fullname',
            'age',
            'diag_primary',
            'diag_comor',
            'address',
            'telephone',
            'status',
            //'d_update',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end() ?>
</div>
<!-- <a href="download.php">xDownload ZIP</a> -->

<?php
$this->registerJs("$(function() {
 $('#modalButton').click(function(e) {
   e.preventDefault();
   $('#modal').modal('show').find('.modal-content')
   .load($(this).attr('value'));
 });
});");
?>

