<?php

return [
    //PRODUCTION
    'class' => 'yii\db\Connection',
    'driverName' => 'sqlsrv',
    'dsn' => $config_apps['config']['db']['sql_server']['db_sql_server'],
    'username' => $config_apps['config']['db']['sql_server']['user_sql_server'],
    'password' => $config_apps['config']['db']['sql_server']['pass_sql_server'],
    'charset' => 'utf8',
    // 'enableSchemaCache' => true,
];
