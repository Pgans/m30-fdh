<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Departments */

$this->title = 'แก้ไขแผนก: ' . ' ' . $model->dep_name;
$this->params['breadcrumbs'][] = ['label' => 'แผนก', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->dep_name, 'url' => ['view', 'id' => $model->dep_id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<div class="box box-danger box-solid">
  <div class ="box-header">
          <h3 class = "box-title"><i class="fa fa-home"></i> <?= Html::encode($this->title) ?></h3>
            </div>
          <div class="box-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
