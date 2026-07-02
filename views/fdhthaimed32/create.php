<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Fdhthaimed32 */

$this->title = Yii::t('app', 'Create Fdhthaimed32');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fdhthaimed32s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fdhthaimed32-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
