<?php

use DI\ContainerBuilder;

if (! function_exists('config')) {
    function config($key) {
        $config = require_once __DIR__ . '/../config/settings.php';

        if(in_array($key, array_keys($config['settings']))){
            return $config['settings'][$key];
        }

        return false;
    }
}
