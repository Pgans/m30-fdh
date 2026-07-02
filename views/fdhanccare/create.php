<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Fdhanccare */

$this->title = Yii::t('app', 'Create Fdhanccare');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fdhanccares'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fdhanccare-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
