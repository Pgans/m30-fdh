<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Fdhtelemed */

$this->title = Yii::t('app', 'Create Fdhtelemed');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fdhtelemeds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fdhtelemed-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
