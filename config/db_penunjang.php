<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' =>  $params['db_pg'],
    'username' => $params['user_db_pg'],
    'password' => $params['password_db_pg'],
    'charset' => 'utf8',
    'schemaMap' => [
        'pgsql' => [
            'class' => 'yii\db\pgsql\Schema',
            'defaultSchema' => 'penunjang_2' //specify your schema here, public is the default schema
        ]
    ], // PostgreSQL
    'tablePrefix' => '',

    // 'class' => 'yii\db\Connection',
    // 'dsn' => 'pgsql:host=localhost;port=5432;dbname=SIMRS;',
    // 'username' => 'postgres',
    // 'password' => '12345678',
    // 'charset' => 'utf8',
    // 'schemaMap' => [
    //     'pgsql' => [
    //         'class' => 'yii\db\pgsql\Schema',
    //         'defaultSchema' => 'public' //specify your schema here, public is the default schema
    //     ]
    // ], // PostgreSQL
    // 'tablePrefix' => '',

    //PRODUCTION
    // 'class' => 'yii\db\Connection',
    // 'driverName' => 'sqlsrv',
    // 'dsn' => 'sqlsrv:Server=192.168.252.250;Database=RS_AASimrs',
    // 'username' => 'sa',
    // 'password' => 'data_123',
    // 'charset' => 'utf8',

    //DEVELOPMENT
    // 'class' => 'yii\db\Connection',
    // 'driverName' => 'sqlsrv',
    // 'dsn' => 'sqlsrv:Server=192.168.254.21;Database=RS_AASimrs',
    // 'username' => 'itrsud',
    // 'password' => 'rsud44edp_123',
    // 'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
