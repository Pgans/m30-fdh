<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Serviceout */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'ส่งซ่อมภายนอก', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="serviceout-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id, 'store_id' => $model->store_id, 'categories_id' => $model->categories_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id, 'store_id' => $model->store_id, 'categories_id' => $model->categories_id], [
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
            'id',
            'symptom',
            'date_sent',
            'date_in',
            'price',
            'orther',
            'store.store_name',
            'device.device_name',
            'categories.category_name',
        ],
    ]) ?>

</div>
