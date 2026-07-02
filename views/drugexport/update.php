<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Drugexport */

$this->title = 'Update Drugexport: ' . $model->HOSPCODE;
$this->params['breadcrumbs'][] = ['label' => 'Drugexports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->HOSPCODE, 'url' => ['view', 'HOSPCODE' => $model->HOSPCODE, 'PID' => $model->PID, 'SEQ' => $model->SEQ, 'DIDSTD' => $model->DIDSTD]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="drugexport-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
