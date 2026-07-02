<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Mraipd */

 $this->title = Yii::t('app', 'แบบบันทึกตรวจประเมินเวชระเบียนผู้ป่วยใน');
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mraipds'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="mraipd-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
