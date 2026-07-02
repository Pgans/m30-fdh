<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ita66 */

$this->title = Yii::t('app', 'Create Ita66');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ita66s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ita66-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
