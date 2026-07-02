<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FdhanccareSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'เยี่ยมหลังคลอด');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fdhanccare-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'main_table',
            'main_query:ntext',
            'd_update',

           [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}', // กำหนดให้แสดงเฉพาะปุ่มแก้ไขเท่านั้น
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-edit" style="font-size: 25px;"></span>', $url, [
                            'title' => Yii::t('yii', 'Update'),
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
