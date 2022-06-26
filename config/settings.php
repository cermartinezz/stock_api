<?php

return [
    'settings' => [
        'db' => [
            'driver'    => 'mysql',
            'host'      => 'mysql',
            'database'  => $_ENV["DB_DATABASE"] ?? 'php_jobsity',
            'username'  => $_ENV["DB_USER"] ?? 'root',
            'password'  => $_ENV["DB_PASSWORD"] ?? '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]
    ]
];
