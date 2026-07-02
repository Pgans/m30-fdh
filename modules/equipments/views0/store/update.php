<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Store */

$this->title = 'แก้ไขร้านค้า: ' . ' ' . $model->store_name;
$this->params['breadcrumbs'][] = ['label' => 'ร้านค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->store_id, 'url' => ['view', 'id' => $model->store_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box box-warning box-solid">
  <div class ="box-header">
          <h3 class = "box-title"><i class="fa fa-home"></i> <?= Html::encode($this->title) ?></h3>
            </div>
          <div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
