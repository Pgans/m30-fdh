<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Keypoints */

$this->title = Yii::t('app', 'Update Keypoints: {name}', [
    'name' => $model->key_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Keypoints'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->key_id, 'url' => ['view', 'id' => $model->key_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="keypoints-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
