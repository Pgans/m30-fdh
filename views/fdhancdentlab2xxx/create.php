<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FdhancdentLab2 */

$this->title = Yii::t('app', 'Create Fdhancdent Lab2');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fdhancdent Lab2s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fdhancdent-lab2-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
