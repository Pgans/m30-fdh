<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Mradepartmetnsopd */

$this->title = Yii::t('app', 'เพิ่มแผนกผู้ป่วยนอก');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mradepartmetnsopds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary box-solid">
<div class="mradepartmetnsopd-create">
<div class="well">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
