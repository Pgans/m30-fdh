<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kha */

$this->title = Yii::t('app', 'เพิ่มข้อมูลเอกสารคุณภาพ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Khas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kha-create">
<div class="box box-success box-solid">
<div class ="box-header">
          <h3 class = "box-title"><i class="fa fa-users"></i> 'เพิ่มข้อมูลเอกสารคุณภาพ'</h3>
            </div>
          <div class="box-body">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
