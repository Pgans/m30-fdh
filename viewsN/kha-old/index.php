<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KhaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'เอกสารคุณภาพ');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kha-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <p>
        <?= Html::a('<i class="fas fa-plus"></i> ' . Yii::t('app', 'เพิ่มรายการเอกสาร'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary'=> 'false',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            /*
            [
                'label' => 'รหัสเอกสาร',
                'value' => function ($model) {
                    $paddedId = str_pad($model->id, 4, '0', STR_PAD_LEFT); // เติม "00" นำหน้า $model->id
                    return $model->document->document_id . ' - ' . $model->team->team_id . ' - ' . $model->dep->dep_id . ' - ' . $paddedId;
                },
            ],
            */
            [
                'label' => 'รหัสเอกสาร',
                'value' => function ($model) {
                    // Pad $model->id based on its position
                    $idLength = strlen($model->id);
                    $desiredLength = 4;

                    // Calculate the number of zeros to pad
                    $paddingLength = max(0, $desiredLength - $idLength);

                    // Pad $model->id with leading zeros
                    $paddedId = str_repeat('0', $paddingLength) . $model->id;

                    // Get the modification code based on the type of modification (you can adjust this logic as needed)
                   // $modificationCode = $model->is_update ? 'M' : 'A'; // Assuming isUpdate is a property indicating if it's an update
                   $paddedModificationCode = str_pad($model->is_update, 3, '0', STR_PAD_LEFT);
                    return $model->document->document_id . ' - ' . $model->team->team_id . ' - ' . $model->dep->dep_id . ' - ' . $paddedId . ' - ' . $paddedModificationCode;
                },
            ],

            //'document_id',
            //'team_id',
            //'dep_id',
            [
                'attribute' => 'ha_name',
                'label' => 'หัวข้อ',
            ],

            'filename',
            'create_date',
            'is_update',
            'd_update',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>