<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\FileHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KhaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'เอกสารคุณภาพ');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kha-index">
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i>เอกสารคุณภาพ</i></h3>
  </div>
  <div class="panel-body">

    <p>
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('app', 'เพิ่มรายการเอกสาร'), ['create'], ['class' => 'btn btn-success btn-lg']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary'=> 'faulse',
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
                'contentOptions' => ['style' => 'text-overflow: ellipsis; white-space: nowrap; max-width: 25vw; overflow: hidden;'],
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
                'contentOptions' => ['style' => 'text-overflow: ellipsis; white-space: nowrap; max-width: 25vw; overflow: hidden;'],
            ],

            'filename',
            [
                'attribute' => 'create_date',
                'label' => 'วันบันทึก',
                'contentOptions' => ['style' => 'text-overflow: ellipsis; white-space: nowrap; max-width: 25vw; overflow: hidden;'],
            ],
            
            [
                'attribute' => 'd_update',
                'label' => 'วันแก้ไข',
                'contentOptions' => ['style' => 'text-overflow: ellipsis; white-space: nowrap; max-width: 25vw; overflow: hidden;'],
            ],
            
           // 'is_update',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'คลิกดู',
                'headerOptions' => ['style' => 'width:15%'],
                'template' => '<div class="btn-group btn-group-sm text-center" role="group">{detail} {edit} {del}</div>',
                'buttons' => [
                    'detail' => function ($url, $model, $key) {
                        $hasAttachment = !empty($model->filename);
                        $buttonClass = $hasAttachment ? 'btn btn-success' : 'btn btn-info';
                    
                        $filename = $model->filename; // Assuming 'covenant' is the attribute storing the file name
                    
                        // Extract file extension
                        $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
                    
                        return Html::a('ไฟล์ (' . $fileExtension . ')',
                            ['download', 'id' => $model->id], // Assuming 'download' is the action to download the file
                            [
                                'class' => $buttonClass,
                                'target' => '_blank',
                                'data' => [
                                    'pjax' => 0, // Use this if you are using pjax
                                ],
                            ]
                        );
                    },
                    
                    'edit' => function ($url, $model, $key) {
                        return Html::a('แก้ไข',
                            ['update', 'id' => $model->id],
                            ['class' => 'btn btn-warning']
                        );
                    },
                    /*
                    'del' => function ($url, $model, $key) {
                        return Html::a('ลบ',
                            ['delete', 'id' => $model->id],
                            [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'คุณแน่ใจหรือไม่ที่จะลบรายการนี้?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    },
                    */
                ],
            ],
            
        ],
    ]); ?>
</div>