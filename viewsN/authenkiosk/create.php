<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Authenkiosk */

$this->title = 'Create Authenkiosk';
$this->params['breadcrumbs'][] = ['label' => 'Authenkiosks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="authenkiosk-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
