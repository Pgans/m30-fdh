<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Importtxt */

$this->title = $model->auto_id;
$this->params['breadcrumbs'][] = ['label' => 'Importtxts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="importtxt-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'auto_id' => $model->auto_id, 'train_id' => $model->train_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'auto_id' => $model->auto_id, 'train_id' => $model->train_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'auto_id',
            'rep',
            'id',
            'train_id',
            'hn',
            'an',
            'pid',
            'fullname',
            'main',
            'regdate',
            'discharge',
            'ins',
            'pp',
            'errorcode',
            'sub',
        ],
    ]) ?>

</div>
