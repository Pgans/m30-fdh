<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Impalliatives */

$this->title = Yii::t('app', 'Create Impalliatives');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Impalliatives'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="impalliatives-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
