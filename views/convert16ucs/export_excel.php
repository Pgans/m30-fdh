<?php

use kartik\grid\GridView;
use kartik\export\ExportMenu;
// ...

echo  GridView::widget([
    'dataProvider' => $dataProvider,
	 
    'columns' => [
	 ['class' => 'yii\grid\SerialColumn'],
        'hn',
        'dateopd',
        'seq',
        'person_id',
        'fullname',
        'detail',
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
                        'hn',
                        'dateopd',
                        'seq',
                        'person_id',
                        'fullname',
                        'detail',
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

