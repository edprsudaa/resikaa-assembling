<?php

return [

    //DEVELOPMENT
    // 'class' => 'yii\db\Connection',
    // 'driverName' => 'sqlsrv',
    // 'dsn' => 'sqlsrv:Server=192.168.254.21;Database=RS_AASimrs',
    // 'username' => 'itrsud',
    // 'password' => 'rsud44edp_123',
    // 'charset' => 'utf8',
    // 'enableSchemaCache' => true,

    //PRODUCTION
    'class' => 'yii\db\Connection',
    'driverName' => 'sqlsrv',
    'dsn' => $params['db_sqlsrv'],
    'username' => $params['user_db_sqlsrv'],
    'password' => $params['password_db_sqlsrv'],
    'charset' => 'utf8',
    // 'enableSchemaCache' => true,
];
