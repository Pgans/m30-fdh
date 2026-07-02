<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Importtxt */

$this->title = 'Create Importtxt';
$this->params['breadcrumbs'][] = ['label' => 'Importtxts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="importtxt-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
