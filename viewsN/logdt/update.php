<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Logdt */

$this->title = 'Update Logdt: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Logdts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'visit_id' => $model->visit_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="logdt-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
