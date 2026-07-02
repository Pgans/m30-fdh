<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kha */

$this->title = Yii::t('app', 'Create Kha');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Khas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kha-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
