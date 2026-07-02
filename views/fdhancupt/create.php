<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Fdhancupt */

$this->title = Yii::t('app', 'Create Fdhancupt');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fdhancupts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fdhancupt-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
