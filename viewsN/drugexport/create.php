<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Drugexport */

$this->title = 'Create Drugexport';
$this->params['breadcrumbs'][] = ['label' => 'Drugexports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="drugexport-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
