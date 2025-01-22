<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => $config_apps['config']['db']['postgre']['db_perantara_lis']['db_pg'],
    'username' => $config_apps['config']['db']['postgre']['db_perantara_lis']['user_pg'],
    'password' => $config_apps['config']['db']['postgre']['db_perantara_lis']['pass_pg'],
    'charset' => 'utf8',
    'schemaMap' => [
        'pgsql' => [
            'class' => 'yii\db\pgsql\Schema',
            'defaultSchema' => 'public' //specify your schema here, public is the default schema
        ]
    ], // PostgreSQL
    'tablePrefix' => '',
];
