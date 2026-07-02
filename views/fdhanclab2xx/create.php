<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Fdhanclab2 */

$this->title = Yii::t('app', 'Create Fdhanclab2');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fdhanclab2s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fdhanclab2-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
