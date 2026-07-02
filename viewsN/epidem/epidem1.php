<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\editable\Editable;
use kartik\checkbox\CheckboxX;
use yii\widgets\Pjax;

$this->title = 'Epidem Covid19';
//$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['rep/index']];
//$this->params['breadcrumbs'][] = 'รายงานข้อมูลE-Claim แยกตามREP';
?>
<div class='well'>

  <?php $form = ActiveForm::begin(); ?>
  <input class="btn btn-success btn btn-block" id="btn-delete" type="submit" name="select" method="post" value="ส่งข้อมูล Epidem Covid-19">
  <input type="hidden" value="0" name="Model[active]">
  <p>
    <!-- <?= Html::a(Yii::t('app', 'Create Resume'), ['create'], ['class' => 'btn btn-success']) ?> -->
    <?= Html::button(Yii::t('app', 'Check'), ['class' => 'btn btn-warning pull-right', 'id' => 'btn-delete']) ?>

    <?= Html::beginForm(
      ['delete-all'],
      'post',
      [
        'id' => 'btn-delete',
        'data-pjax' => ''  // enable Pjax for this form so the page will do the action and reload after the action finishes.
      ]
    ); ?>
    <?= Html::submitButton('Update', ['class' => 'btn btn-success btn-flat pull-right', 'id' => 'btn-delete']); ?>
    <?= Html::a('Check', ['delete-all', 'id' => $model->id], [
      'class' => 'btn btn-danger',
      'data' => [
        'confirm' => 'Are you sure you want to delete this item?',
        'method' => 'post',
      ],
    ]) ?>
  </p>



  <?= GridView::widget([
    'dataProvider' => $epidemProvider,
    'filterModel' => $searchModel,
    "id" => "grid",
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],
      [

        'class' => 'yii\grid\CheckboxColumn',

        'checkboxOptions' =>

        function ($model) {

          return ['value' => $model->id, 'class' => 'checkbox-row', 'id' => 'checkbox'];
        }

      ],
      'regdate',
      'visit_id',
      'hn',
      'An',
      'ward',
      'fullname',
      'Diag',
      'lab',
      'unit_name',
      'Vaccine',
      ['class' => 'yii\grid\ActionColumn'],
    ],
  ]); ?>
</div>
<?php
$this->registerJs('
  jQuery("#btn-delete").click(function(){
    var keys = $("#grid").yiiGridView("getSelectedRows");
   // console.log(keys);
    if(keys.length>0){
     jQuery.post("' . Url::to(['delete-all']) . '",{selection:keys.join()},function(){

      });
    }
  });
');

//$this->registerJs($script, yii\web\View::POS_READY);

?>