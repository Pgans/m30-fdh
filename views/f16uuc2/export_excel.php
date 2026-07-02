<?php

use kartik\grid\GridView;
use kartik\export\ExportMenu;
// ...

echo  GridView::widget([
    'dataProvider' => $dataProvider,
	 
    'columns' => [
	 ['class' => 'yii\grid\SerialColumn'],
     'pid',
     'cid',
     'visit_id',
     'fullname',
     'age_year',
     'screen_date',
     'symptoms',
     'height',
     'weight',
     'ผลตรวจ',
     'response',
        // Add more columns as needed
    ],
    'responsive' => true,
    'hover' => true,
    'resizableColumns' => true,
    'export' => false, // Disable export for now, you can enable it as needed
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => 'Exported Data',
    ],
	'responsive' => true,
    'hover' => true,
    'resizableColumns' => true,
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => 'Exported Data',
    ],
    'toolbar' => [
        [
            'content' =>
                ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        'pid',
                        'cid',
                        'seq',
                        // Add more columns as needed
                    ],
                    'filename' => 'exported-data',
                    'showConfirmAlert' => false,
                    'exportConfig' => [
                        ExportMenu::FORMAT_EXCEL => true,
                        ExportMenu::FORMAT_PDF => true,
                    ],
                ]),
        ],
        // Other toolbar options can be added here
    ],
]); ?>

