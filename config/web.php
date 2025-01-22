<?php

$params = require __DIR__ . '/params.php';
$config_apps = require __DIR__ . '/config_apps.php';
$db_penunjang = require __DIR__ . '/db_penunjang.php';
$db_penunjang_lama = require __DIR__ . '/db_penunjang_lama.php';
$db_perantara_lis = require __DIR__ . '/db_perantara_lis.php';
$db_pengolahan_data = require __DIR__ . '/db_pengolahan_data.php';
$db_bedah_sentral = require __DIR__ . '/db_bedah_sentral.php';
$db_pegawai = require __DIR__ . '/db_pegawai.php';
$db_medis = require __DIR__ . '/db_medis.php';
$db_pendaftaran = require __DIR__ . '/db_pendaftran.php';
$db_sso = require __DIR__ . '/db_sso.php';
$db_postgre = require __DIR__ . '/db_postgre.php';
$db_sql_server = require __DIR__ . '/db_sql_server.php';
$db_sign = require __DIR__ . '/db_sign.php';
$params['config_apps'] = $config_apps;

$user = [];
// CEK APAKAH SSO ATAU LOCALHOST
if ($params['config_sso'] === true) {
    $user = [
        'class' => 'app\models\User',
        'identityClass' => 'app\models\Identitas',
        'enableAutoLogin' => true,
        'loginUrl'  => $config_apps['config']['url_apps']['sso'] . 'masuk?b=' . $config_apps['config']['url_apps']['base'],
        'identityCookie' => ['name' => '_identity-id', 'httpOnly' => true, 'domain' => 'simrs.aa'],
    ];
} else {
    $user = [
        'identityClass' => 'app\models\sso\User',
        'loginUrl' => ['auth/login'],
        'enableAutoLogin' => true,
    ];
}
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'timeZone' => 'Asia/Jakarta',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'ApiComponent' => [
            'class' => 'app\components\ApiComponent',
        ],
        'session' => [
            'class' => 'yii\web\Session',
            'cookieParams' => ['lifetime' => 24 * 60 * 60]
        ],
        'sessionMiddleware' => [
            'class' => 'app\components\SessionMiddleware',
        ],
        'request' => [
            'cookieValidationKey' => 'sso',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        // settingnya di variable paling atas
        'user' => $user,
        'formatter' => [
            'dateFormat' => 'php:d-m-Y',
            'datetimeFormat' => 'php:d-m-Y H:i:s',
            'timeFormat' => 'php:H:i:s',
            'decimalSeparator' => ',',
            'thousandSeparator' => '.',
            'currencyCode' => 'IDR',
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
        'db' => $db_medis,
        'db_pegawai' => $db_pegawai,
        'db_medis' => $db_medis,
        'db_pendaftaran' => $db_pendaftaran,
        'db_penunjang' => $db_penunjang,
        'db_penunjang_lama' => $db_penunjang_lama,
        'db_perantara_lis' => $db_perantara_lis,
        'db_sso' => $db_sso,
        'db_postgre' => $db_postgre,
        'db_pengolahan_data' => $db_pengolahan_data,
        'db_bedah_sentral' => $db_bedah_sentral,
        'db_sql_server' => $db_sql_server,
        'db_sign' => $db_sign,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'db' => $db_pengolahan_data,
            'itemTable' => 'pengolahan_data.auth_item',
            'assignmentTable' => 'pengolahan_data.auth_assignment',
            'itemChildTable' => 'pengolahan_data.auth_item_child',
            'ruleTable' => 'pengolahan_data.auth_rule'
        ]
    ],
    'on beforeRequest' => function ($event) {
        Yii::$app->sessionMiddleware->checkSession();
    },
    'modules' => [
        'rbac' => [
            'class' => 'app\modules\rbac\Module',
            // 'layout' => 'left-menu',
            // 'mainLayout' => '@app/views/layouts/main.php',
        ],
    ],
    'as access' => [
        'class' => 'app\modules\rbac\components\AccessControl',
        'allowActions' => [
            '*',
            'gii/*',
            'site/*',
            'rbac/*',
            'hasil/*',
            'peminjaman-rekam-medis/*',
            'history-pasien/*',
            'panduan-praktik-klinis/panduan',


        ]
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
    ];
}

return $config;
