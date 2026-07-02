<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Agenda */

$this->title = $model->agenda_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Agendas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="agenda-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->agenda_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->agenda_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'agenda_id',
            'meeting_id',
            'ref',
            'topic',
            'discription:ntext',
            'docs',
            'create_date',
            'view',
        ],
    ]) ?>

</div>
<h1><?= Html::encode($meeting->title) ?></h1>

<table>
    <tr>
        <th>Topic</th>
        <th>Description</th>
        <th>Meeting Link</th>
    </tr>
    <?php foreach ($meeting->agendas as $agenda): ?>
        <tr>
            <td><?= Html::encode($agenda->topic) ?></td>
            <td><?= Html::encode($agenda->description) ?></td>
            <td><?= Html::a('Go to Meeting', ['meeting/view', 'id' => $agenda->meeting_id]) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
