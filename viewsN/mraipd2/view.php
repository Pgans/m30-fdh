<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Mraipd */

$this->title = $model->mra_id;
$this->params['breadcrumbs'][] = ['label' => 'Mraipds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mraipd-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->mra_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->mra_id], [
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
            'mra_id',
            'unit_id',
            'HN',
            'AN',
            'dr_license',
            'date_admit',
            'date_discharge',
            'date_audit',
            'NA1',
            'Missing1',
            'No1',
            'dxop1',
            'dxop2',
            'dxop3',
            'dxop4',
            'dxop5',
            'dxop6',
            'dxop7',
            'dxop8',
            'dxop9',
            'dxop_huk',
            'NA2',
            'Missing2',
            'No2',
            'other1',
            'other2',
            'other3',
            'other4',
            'other5',
            'other6',
            'other7',
            'other8',
            'other9',
            'other_huk',
        ],
    ]) ?>

</div>
