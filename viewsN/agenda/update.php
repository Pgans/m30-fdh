<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Agenda */

$this->title = Yii::t('app', 'แก้ไขวาระการประชุม: {name}', [
    'name' => $model->agenda_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Agendas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->agenda_id, 'url' => ['view', 'id' => $model->agenda_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="box box-default box-solid" >
    <div class="box-header" id="grad8">
        <div class="box-title"> E-Meeting<small> วาระการประชุม</small></div>
    </div>
    <div class="box-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
