<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Fdhopae */

$this->title = Yii::t('app', 'Create Fdhopae');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fdhopaes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fdhopae-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
