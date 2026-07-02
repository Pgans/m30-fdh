<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Fdhhomeward */

$this->title = Yii::t('app', 'Create Fdhhomeward');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fdhhomewards'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fdhhomeward-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
