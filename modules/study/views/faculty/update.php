<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Faculty */

$this->title = 'แก้ไขคณะวิชา: ' . ' ' . $model->faculty_name;
$this->params['breadcrumbs'][] = ['label' => 'คณะวิชา', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->faculty_name, 'url' => ['view', 'id' => $model->faculty_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box box-success box-solid">
  <div class ="box-header">
          <h3 class = "box-title"><i class="fa fa-home"></i> <?= Html::encode($this->title) ?></h3>
            </div>
          <div class="box-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
