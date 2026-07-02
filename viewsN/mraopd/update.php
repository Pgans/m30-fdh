<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Mraopd */

$this->title = Yii::t('app', 'แก้ไขการบันทึกเวชระเบียนผู้ป่วยนอก: {name}', [
    'name' => $model->mra_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mraopds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mra_id, 'url' => ['view', 'id' => $model->mra_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="mraopd-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
