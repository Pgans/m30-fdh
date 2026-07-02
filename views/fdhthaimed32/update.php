<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Fdhthaimed32 */

$this->title = Yii::t('app', 'Update Fdhthaimed32: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fdhthaimed32s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="fdhthaimed32-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
