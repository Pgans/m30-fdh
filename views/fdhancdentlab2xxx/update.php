<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FdhancdentLab2 */

$this->title = Yii::t('app', 'Update Fdhancdent Lab2: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fdhancdent Lab2s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="fdhancdent-lab2-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
