<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Mraipd */

$this->title = 'Update Mraipd: ' . $model->mra_id;
$this->params['breadcrumbs'][] = ['label' => 'Mraipds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mra_id, 'url' => ['view', 'id' => $model->mra_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mraipd-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
