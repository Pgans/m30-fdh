<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Meeting */

$this->title = Yii::t('app', ' เพิ่มการประชุม');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Meetings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-default box-solid" >
    <div class="box-header" id="grad8">
        <div class="box-title"> E-Meeting<small> MuangSamSib Hospital</small></div>
    </div>
    <div class="box-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
