<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\University */

$this->title = 'แก้ไขมหาวิทยาลัย: ' . ' ' . $model->university_name;
$this->params['breadcrumbs'][] = ['label' => 'มหาวิทยาลัย', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->university_name, 'url' => ['view', 'id' => $model->university_id]];
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
