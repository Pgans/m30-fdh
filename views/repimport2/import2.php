<?php 

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;



$this->title = 'Import XLSX';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="import-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Import', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

?>
 <?php
		echo GridView::widget([
        'dataProvider' =>$dataimport,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'auto_id',
            'rep',
            //'id',
            'train_id',
            'hn',
            'an',
            'pid',
            'fullname',
            'main',
            'regdate',
           // 'discharge',
            'ins',
            //'pp',
            //'errorcode',
            'sub',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>