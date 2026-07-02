<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Fdhoptonpillsupt */

$this->title = Yii::t('app', 'Create Fdhoptonpillsupt');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fdhoptonpillsupts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fdhoptonpillsupt-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
