<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\F16fdhipd */

$this->title = Yii::t('app', 'Create F16fdhipd');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'F16fdhipds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="f16fdhipd-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
