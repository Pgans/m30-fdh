<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Visitinvoice */

$this->title = Yii::t('app', 'Create Visitinvoice');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Visitinvoices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visitinvoice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
