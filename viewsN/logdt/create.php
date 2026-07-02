<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Logdt */

$this->title = 'Create Logdt';
$this->params['breadcrumbs'][] = ['label' => 'Logdts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logdt-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
