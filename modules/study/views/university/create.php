<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\University */

$this->title = 'เพิ่มชื่อมหาวิทยาลัย';
$this->params['breadcrumbs'][] = ['label' => 'มหาวิทยาลัย', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
