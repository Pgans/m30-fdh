<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Departmetnsipd */

$this->title = Yii::t('app', 'เพิ่มข้อมูลแผนกผู้ป่วยใน');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Departmetnsipds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary box-solid">
<div class="departmetnsipd-create">
<div class="well">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
