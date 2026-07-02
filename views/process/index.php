<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'MySQL Process List';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-6" style="padding: 10px; flex: 1;">
    <div class="card shadow-sm" style="background-color: #f8f9fa; border-radius: 10px;">
        <div class="card-header" style="background-color: #e9ecef; border-bottom: 1px solid #dee2e6; padding: 15px;">
            <h3 class="card-title text-secondary" style="margin: 0;"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-body" style="padding: 15px;">
            <?= GridView::widget([
                'tableOptions' => [
                    'class' => 'table table-hover table-striped',
                    'style' => 'margin-bottom: 0;'
                ],
                'dataProvider' => new \yii\data\ArrayDataProvider([
                    'allModels' => $processList,
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]),
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn', 
                        'headerOptions' => ['style' => 'background-color: #f1f3f5; color: #495057;']
                    ],
                    [
                        'attribute' => 'Id',
                        'headerOptions' => ['style' => 'background-color: #f1f3f5; color: #495057;']
                    ],
                    [
                        'attribute' => 'User',
                        'headerOptions' => ['style' => 'background-color: #f1f3f5; color: #495057;']
                    ],
                    [
                        'attribute' => 'Host',
                        'headerOptions' => ['style' => 'background-color: #f1f3f5; color: #495057;']
                    ],
                    [
                        'attribute' => 'db',
                        'headerOptions' => ['style' => 'background-color: #f1f3f5; color: #495057;']
                    ],
                    [
                        'attribute' => 'Command',
                        'headerOptions' => ['style' => 'background-color: #f1f3f5; color: #495057;']
                    ],
                    [
                        'attribute' => 'Time',
                        'headerOptions' => ['style' => 'background-color: #f1f3f5; color: #495057;']
                    ],
                    [
                        'attribute' => 'State',
                        'headerOptions' => ['style' => 'background-color: #f1f3f5; color: #495057;']
                    ],
                    [
                        'attribute' => 'Info',
                        'headerOptions' => ['style' => 'background-color: #f1f3f5; color: #495057;']
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{kill}',
                        'buttons' => [
                            'kill' => function ($url, $model, $key) {
                                return Html::a('Kill', Url::to(['kill', 'id' => $model['Id']]), [
                                    'class' => 'btn btn-danger btn-sm rounded',
                                    'data' => [
                                        'confirm' => 'คุณแน่ใจหรือไม่ว่าต้องการ Kill Process นี้?',
                                        'method' => 'post',
                                    ],
                                ]);
                            }
                        ],
                        'headerOptions' => ['style' => 'background-color: #f1f3f5; color: #495057;']
                    ],
                ],
                'layout' => "{items}\n{pager}",
                'pager' => [
                    'options' => ['class' => 'pagination justify-content-center'],
                    'linkContainerOptions' => ['class' => 'page-item'],
                    'linkOptions' => ['class' => 'page-link'],
                    'activePageCssClass' => 'active',
                    'disabledPageCssClass' => 'disabled',
                    'prevPageLabel' => '&laquo;',
                    'nextPageLabel' => '&raquo;',
                ],
            ]); ?>
        </div>
    </div>
</div>