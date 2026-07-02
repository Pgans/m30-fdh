<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Fdhipnormal */

$this->title = Yii::t('app', 'Create Fdhipnormal');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fdhipnormals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fdhipnormal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
