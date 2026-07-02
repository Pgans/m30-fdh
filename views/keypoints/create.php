<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Keypoints */

$this->title = Yii::t('app', 'Create Keypoints');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Keypoints'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="keypoints-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
