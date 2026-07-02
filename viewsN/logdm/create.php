<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Logdm */

$this->title = 'Create Logdm';
$this->params['breadcrumbs'][] = ['label' => 'Logdms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logdm-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
