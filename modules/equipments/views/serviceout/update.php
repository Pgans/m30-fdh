<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Serviceout */

$this->title = 'แก้ไขส่งซ่อมภายนอก: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'ส่งซ่อมภายนอก', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'store_id' => $model->store_id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<div class="box box-primary box-solid">
  <div class ="box-header">
          <h3 class = "box-title"><i class="fa fa-users"></i> <?= Html::encode($this->title) ?></h3>
            </div>
          <div class="box-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
