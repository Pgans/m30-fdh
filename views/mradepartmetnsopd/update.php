<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Mradepartmetnsopd */

$this->title = Yii::t('app', 'แก้ไข: {name}', [
    'name' => $model->unit_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mradepartmetnsopds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->unit_id, 'url' => ['view', 'id' => $model->unit_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="box box-primary box-solid">
<div class="mradepartmetnsopd-update">
<div class="well">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
