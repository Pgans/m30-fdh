<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\F16fdhipd */

$this->title = Yii::t('app', 'แก้ไขคิวรี่: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'คิวรี่16แฟ้ม'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'แก้ไข');
?>
<div class="f16fdhipd-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <div class="well" style="background-color: #e2e2e2;">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
