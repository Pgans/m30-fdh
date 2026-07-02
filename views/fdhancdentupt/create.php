<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Fdhancdentupt */

$this->title = Yii::t('app', 'Create Fdhancdentupt');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fdhancdentupts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fdhancdentupt-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
