<?php

use yii\helpers\Html;
use yii\grid\GridView;
use miloschuman\highcharts\Highcharts;
//Html::a('เดือนถัดไป', ['reportnext'], ['class' => 'btn btn-warning'])
//Html::a('พิมพ์เอกสาร', ['reportpdf'], ['class' => 'btn btn-primary'])


$this->title = 'สรุปยอดศุูนย์จัดเก็บรายได้เดือน' . $month;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="rental-view"><div class="box box-primary box-solid">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-bar-chart"></i> <?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <p>
                <?= Html::a('เดือนก่อนหน้า', ['reportprev'], ['class' => 'btn btn-warning']) ?>
                <?= Html::a('เดือนถัดไป', ['reportnext'], ['class' => 'btn btn-warning'])?>
                <?= Html::a('สรุปยอดปี'.$y, ['reportall'], ['class' => 'btn btn-success']) ?>
            </p>
            <?=
            Highcharts::widget([
                'options' => [
                    'title' => ['text' => 'สรุปยอดศูนย์จัดเก็บรายได้'],
                    'xAxis' => [
                        'categories' => ['กองทุน']
                    ],
                    'yAxis' => [
                        'title' => ['text' => 'จำนวน(ครั้ง)']
                    ],
                    'series' => $graph,
                ]
            ])
            ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'users',
                        'label' => 'กองทุน'
                    ],
                    [
                        'attribute' => 'counter',
                        'label' => 'จำนวน(ราย)'
                    ],
                ],
            ])
            ?>


        </div>
    </div>
