<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@app' => dirname(__DIR__),
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'enableConfirmation' => false,
            'cost' => 12,
            'admins' => ['admin'],
            // ===== เพิ่ม controllerMap สำหรับ Provider ID Login =====
            'controllerMap' => [
                'security' => [
                    'class' => 'app\controllers\SecurityController',
                ],
            ],
            // =========================================================
        ], 
        'gridview' =>  [
             'class' => '\kartik\grid\Module'
        ],
        'lotto' => [
             'class' => 'app\module\lotto\Module',
            ],
        'huay' => [
            'class' => 'app\module\huay\Module',
        ],
    ],
    'components' => [
        'thaiYearFormatter' => [
            'class' => 'app\components\ThaiYearFormatter'
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@agency/views',
                    '@app/views' => '@app/themes/adminlte' 
                    //'@app/views'=> '@app/themes/sb-admin'
                ],
            ],
        ],
        'request' => [
            'cookieValidationKey' => '123456789',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'dektrium\user\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                    'logFile' => '@runtime/logs/app.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 5,
                ],
            ],
        ],

        'db'      => require(__DIR__ . '/db.php'),
        'db1'     => require(__DIR__ . '/db1.php'),
        'db2'     => require(__DIR__ . '/db2.php'),
        'db7'     => require(__DIR__ . '/db7.php'),
        'db14'    => require(__DIR__ . '/db14.php'),
        'db14j'   => require(__DIR__ . '/db14j.php'),
        'db_jhcis'=> require(__DIR__ . '/db_jhcis.php'),
        'db142'   => require(__DIR__ . '/db142.php'),
        'db143'   => require(__DIR__ . '/db143.php'),
        'db14map' => require(__DIR__ . '/db14map.php'),
        'db_mra'  => require(__DIR__ . '/db_mra.php'),
        'db_ehr'  => require(__DIR__ . '/db_ehr.php'),
        'db_host' => require(__DIR__ . '/db_host.php'),
        'db16'    => require(__DIR__ . '/db16.php'),
        'db70'    => require(__DIR__ . '/db70.php'),
        'db943'   => require(__DIR__ . '/db943.php'),
        'samba2'  => require(__DIR__ . '/samba2.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.200.*'],
    ];
}

return $config;