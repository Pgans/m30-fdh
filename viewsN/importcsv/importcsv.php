<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\models\Importcsv */

$this->title = 'Import CSV';
$this->params['breadcrumbs'][] = ['label' => 'Import CSV', 'url' => ['importcsv']];
$this->params['breadcrumbs'][] = 'Upload CSV';

?>

<div class="import-csv">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Import CSV', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</br>
<div class="box box-info box-solid">
<div class ="box-header">
          <h3 class = "box-title"><i class="fa fa-users"></i> รายการข้อมูลนำเข้าแล้ว</h3>
            </div>
          <div class="box-body">
          <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        //'id',
        'trans_id',
        'visit_id',
        'cid',
        'amount',
        'approvecode',
        'edc_date',
        'edc_time',
        'd_update',

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
</div>