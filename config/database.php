<?php

return [
    'db' => [
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'port'      => $_ENV["DB_PORT"] ?? '3306',
        'database'  => $_ENV["DB_DATABASE"] ?? 'php_jobsitykk',
        'username'  => $_ENV["DB_USER"] ?? 'root',
        'password'  => $_ENV["DB_PASSWORD"] ?? '',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ]
];
