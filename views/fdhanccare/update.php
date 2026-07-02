<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Fdhanccare */

$this->title = Yii::t('app', 'Update เยี่ยมหลังคลอด: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fdhanccares'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="fdhanccare-update">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
