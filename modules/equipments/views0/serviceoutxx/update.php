<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Serviceout */

$this->title = 'Update Serviceout: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Serviceouts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'store_id' => $model->store_id, 'categories_id' => $model->categories_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="serviceout-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
