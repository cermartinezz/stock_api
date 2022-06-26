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

if (!function_exists('env'))
{
    function env($key, $default = false)
    {
        $value = getenv($key);

        throw_when(!$value and !$default, "{$key} is not a defined .env variable and has not default value");

        return $value or $default;
    }
}


if (!function_exists('base_path'))
{
    function base_path($path = '')
    {
        return  __DIR__ . "/../{$path}";
    }
}


if (!function_exists('database_path'))
{
    function database_path($path = '')
    {
        return base_path("database/{$path}");
    }
}

if (!function_exists('config_path'))
{
    function config_path($path = '')
    {
        return base_path("config/{$path}");
    }
}

if (!function_exists('storage_path'))
{
    function storage_path($path = '')
    {
        return base_path("storage/{$path}");
    }
}

if (!function_exists('throw_when'))
{
    function throw_when(bool $fails, string $message, string $exception = Exception::class)
    {
        if (!$fails) return;

        throw new $exception($message);
    }
}
