<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Claimpalliative */

$this->title = 'Create Claimpalliative';
$this->params['breadcrumbs'][] = ['label' => 'Claimpalliatives', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="claimpalliative-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
