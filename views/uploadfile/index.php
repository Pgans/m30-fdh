<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UploadfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Uploadfiles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="uploadfile-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Uploadfile'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'key_id',
            'meeting_id',
            'agenda_id',
            'key_point',
            'show_work:ntext',
            'create_date',
            [
                'attribute' => 'filename',
                'format' => 'raw',
                'value' => function ($model) {
                    $downloadUrl = Url::to(['upload-file/download', 'id' => $model->key_id]);
                    return Html::a($model->getFilename(), $downloadUrl, ['target' => '_blank']);
                },
            ],
            'path',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{download}', // กำหนด Template เพื่อให้แสดงเฉพาะปุ่ม Download
                'buttons' => [
                    'download' => function ($url, $model, $key) {
                        return Html::a('Download', ['download', 'id' => $model->key_id], ['class' => 'btn btn-primary', 'target' => '_blank']);
                    },
                ],
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <p>
    <?= Html::a('Upload File', ['create'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('Download All Files', ['download-all'], ['class' => 'btn btn-primary']) ?>
</p>
</div>
