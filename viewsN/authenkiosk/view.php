<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Authenkiosk */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Authenkiosks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="authenkiosk-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id, 'cid' => $model->cid, 'claimtype' => $model->claimtype], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id, 'cid' => $model->cid, 'claimtype' => $model->claimtype], [
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
            'hospcode',
            'cid',
            'visit_id',
            'claimtype',
            'claimcode',
            'mobile',
            'dep_name',
            'authen_date',
            'd_update',
        ],
    ]) ?>

</div>
