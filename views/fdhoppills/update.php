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
    <div class="well" style="background-color: #e2e2e2;">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
    <!-- ลายน้ำ -->
    <div class="index-watermark">
        <span>สมุนไพรไทย</span>
    </div>
</div>
<style>
    .index-watermark {
        position: fixed;
        bottom: 10px;
        right: 10px;
        transform: rotate(-45deg);
        opacity: 0.2;
        pointer-events: none;
        z-index: 1000;
    }

    .index-watermark span {
        font-size: 2em;
        color: rgba(0, 0, 0, 0.2);
    }
</style>
