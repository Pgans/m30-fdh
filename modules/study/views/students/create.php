<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Students */

$this->title = 'เพิ่มนักศึกษาฝึกงาน';
$this->params['breadcrumbs'][] = ['label' => 'นศ.ฝึกงาน', 'url' => ['index']];
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
