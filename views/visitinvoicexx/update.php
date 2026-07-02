<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Visitinvoice */

$this->title = Yii::t('app', 'แก้ไข Visitinvoice: {name}', [
    'name' => $model->auto_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Visitinvoices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->auto_id, 'url' => ['view', 'id' => $model->auto_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<style>
    .gradient-background {
        background: linear-gradient(to bottom right, rgba(173, 216, 230, 0.7), rgba(255, 255, 255, 0.7)); /* สีฟ้าอ่อน */
        border-radius: 8px; /* ปรับให้มุมมน */
        padding: 20px; /* เพิ่มระยะห่างภายใน */
    }
</style>
<div class="visitinvoice-update gradient-background">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
