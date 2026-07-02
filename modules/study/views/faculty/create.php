<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Faculty */

$this->title = 'เพิ่มคณะวิชา';
$this->params['breadcrumbs'][] = ['label' => 'คณะวิชา', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-info box-solid">
  <div class ="box-header">
          <h3 class = "box-title"><i class="fa fa-home"></i> <?= Html::encode($this->title) ?></h3>
            </div>
          <div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
