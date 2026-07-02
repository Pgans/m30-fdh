<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Uploadfile */

$this->title = Yii::t('app', 'เพิ่มข้อมูลการนำเสนอ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Uploadfiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="uploadfile-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
