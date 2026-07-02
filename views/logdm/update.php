<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Logdm */

$this->title = 'Update Logdm: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Logdms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'visit_id' => $model->visit_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="logdm-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
