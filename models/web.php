<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$db_apps = require __DIR__ . '/db_apps.php';
$db_pegawai = require __DIR__ . '/db_pegawai.php';
$db_sso = require __DIR__ . '/db_sso.php';
$db_pendaftaran = require __DIR__ . '/db_pendaftaran.php';
$db_medis = require __DIR__ . '/db_medis.php';
$db_penunjang = require __DIR__ . '/db_penunjang.php';
$db_penunjang_2 = require __DIR__ . '/db_penunjang_2.php';
$db_farmasi = require __DIR__ . '/db_farmasi.php';
$db_mssql = require __DIR__ . '/db_mssql.php';
$config = [
    'id' => 'medis-app',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'oFwVN8ObxBLlQyJYGOp_go9EdyIgIY27',
        ],
        // 'cache' => [
        //     'class' => 'yii\caching\FileCache',
        // ],
        'session' => [
            'class' => 'yii\web\DbSession',
            'name' => sha1('$#DF8H^5R^%F6fEDUI('),
            'db' => 'db_apps',
            'sessionTable' => 'apps.session'
        ],
        'cache' => [
            'class' => 'yii\caching\DbCache',
            'db' => 'db_apps',
            'cacheTable' => 'apps.cache',
        ],
        'user' => [
            'identityClass' => 'app\models\sso\User',
            'loginUrl' => ['auth/login'],
            'enableAutoLogin' => true,
        ],
        'formatter' => [
            'dateFormat' => 'php:d-m-Y',
            'datetimeFormat' => 'php:d-m-Y H:i:s',
            'timeFormat' => 'php:H:i:s',
            'decimalSeparator' => ',',
            'thousandSeparator' => '.',
            'currencyCode' => 'IDR',
            // 'numberFormatterSymbols' => [
            //     \NumberFormatter::CURRENCY_SYMBOL => 'IDR',
            // \NumberFormatter::MIN_FRACTION_DIGITS => 0,
            // \NumberFormatter::MAX_FRACTION_DIGITS => 2,
            // ],
            // echo Yii::$app->formatter->asCurrency(1000); 
            'defaultTimeZone' => 'Asia/Jakarta',
            'nullDisplay' => '',
        ],
        'response' => [
            'charset' => 'UTF-8',
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db_mssql' => $db_mssql,

        'db_apps' => $db_apps,
        'db_pegawai' => $db_pegawai,
        'db_sso' => $db_sso,
        'db_pendaftaran' => $db_pendaftaran,
        'db_medis' => $db_medis,
        'db_penunjang' => $db_penunjang,
        'db_penunjang_2' => $db_penunjang_2,
        'db_farmasi' => $db_farmasi,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
            'db' => $db_penunjang_2
        ]
    ],
    'modules' => [
        'rbac' => [
            'class' => 'app\modules\rbac\Module',
        ],
    ],
    'as access' => [
        'class' => 'app\modules\rbac\components\AccessControl',
        'allowActions' => [
            'gii/*',
            'auth/*',
            'site/*',
            // '*'
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
