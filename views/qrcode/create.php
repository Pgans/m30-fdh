<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Qrcode */

$this->title = Yii::t('app', 'Create Qrcode');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Qrcodes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qrcode-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
