<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=db;port=5432;dbname=loan_app_db',
    'username' => 'root',
    'password' => 'password',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
