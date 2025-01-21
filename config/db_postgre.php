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
        ]
    ], // PostgreSQL
    'tablePrefix' => '',
];
