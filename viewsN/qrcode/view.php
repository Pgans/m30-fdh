<!-- views/qr-code/generated.php -->

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Generated QR Code';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="qr-code-generated">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::a('Download QR Code', ['download', 'id' => $model->id], ['class' => 'btn btn-success']) ?>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code_data',
            'created_at',
        ],
    ]) ?>
</div>
