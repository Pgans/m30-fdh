<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Authenkiosk */

$this->title = 'Update Authenkiosk: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Authenkiosks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'cid' => $model->cid, 'claimtype' => $model->claimtype]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="authenkiosk-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
