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
      'defaultSchema' => 'bedah_sentral' //specify your schema here
    ]
  ],
  'on afterOpen' => function ($event) {
    $event->sender->createCommand("SET search_path TO bedah_sentral;")->execute();
  },
  // Schema cache options (for production environment)
  //'enableSchemaCache' => true,
  //'schemaCacheDuration' => 60,
  //'schemaCache' => 'cache',
];
