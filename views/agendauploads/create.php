<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Agendauploads */

$this->title = Yii::t('app', 'Create Agendauploads');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Agendauploads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agendauploads-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
