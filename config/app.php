<?php

return [
    'db' => [
        'host' => $_ENV['HOST'] ?? 'localhost',
        'username' => $_ENV['USERNAME'] ?? 'root',
        'password' => $_ENV['PASSWORD'] ?? 'secret',
        'port' => $_ENV['PORT'] ?? '3306',
        'dbname' => $_ENV['DBNAME'] ?? 'yii-academy-clean-arch',
        'charset' => $_ENV['CHARSET'] ?? 'utf8',
    ],
];
