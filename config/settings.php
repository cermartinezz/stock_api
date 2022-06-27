<?php

return [
    'settings' => [
        'db' => [
            'driver'    => 'mysql',
            'host'      => env("DB_HOST", 'localhost') ,
            'database'  => env("DB_DATABASE", 'php_jobsity') ,
            'username'  => env("DB_USERNAME", 'root') ,
            'password'  => env("DB_PASSWORD", ''),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],
        'auth' => [
            # 1 day (1 * 24 * 60 * 60)
            'token_lifetime' => 86400
        ]
    ]
];
