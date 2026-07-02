<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Mraopd */

$this->title = Yii::t('app', 'แบบบันทึกตรวจประเมินเวชระเบียนผู้ป่วยนอก/ฉุกเฉิน');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mraopds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mraopd-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
