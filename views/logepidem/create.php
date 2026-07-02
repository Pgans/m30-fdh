<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Logepidem */

$this->title = 'Create Logepidem';
$this->params['breadcrumbs'][] = ['label' => 'Logepidems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logepidem-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
