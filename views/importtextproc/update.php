<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Importtxt */

$this->title = 'Update Importtxt: ' . $model->auto_id;
$this->params['breadcrumbs'][] = ['label' => 'Importtxts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->auto_id, 'url' => ['view', 'auto_id' => $model->auto_id, 'train_id' => $model->train_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="importtxt-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
