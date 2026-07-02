<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Visitinvoice */

$this->title = $model->auto_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Visitinvoices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="visitinvoice-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->auto_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->auto_id], [
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
            'visit_id',
            'record_dt',
            'order1',
            'order2',
            'order3',
            'item',
            'invoice',
            'is_refund',
            'amount',
            'subtotal',
            'ctype',
            'cfield',
            'drug_id',
            'opbills',
            'is_psc',
            'is_inv',
            'is_rcp',
            'base_rate',
            'extra',
            'unit_price',
            'xl_id',
            'lab_id',
            'xray_code',
            'type16',
            'seq16',
            'code16',
            'hosp',
            'chrgitem',
            'ned_code',
            'order_dt',
            'is_cancel',
            'auto_id',
        ],
    ]) ?>

</div>
