<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Logrequests */

$this->title = Yii::t('app', 'รายละเอียดการร้องขอ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'การร้องขอ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .logrequests-view {
        background: linear-gradient(to right, #f1f1f1, #ffffff);
        padding: 20px;
        border: 1px solid #ccc; /* เส้นกรอบสีเทา */
        border-radius: 10px;
    }


  
</style>

<div class="logrequests-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
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
            'id',
            'users',
            'action:ntext',
            'request_date',
            'developer_comments:ntext',
            'completion_date',
        ],
        'options' => ['class' => 'table table-striped'], // เพิ่มคลาสสำหรับ CSS
    ]) ?>

</div>
