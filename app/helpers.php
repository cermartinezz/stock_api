<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

if (!function_exists('collect'))
{
    function collect($items): Collection
    {
        return new Collection($items);
    }
}

if (!function_exists('factory'))
{
    function factory(string $model, int $count = 1)
    {
        $factory = new Factory;

        return $factory($model, $count);
    }
}

if (!function_exists('config'))
{
    function config($path = null)
    {
        $config = require_once __DIR__ . '/../config/settings.php';

        return data_get($config, $path);
    }
}

if (!function_exists('env'))
{
    function env($key, $default = false): bool
    {
        $value = getenv($key);

        throw_when(!$value and !$default, "{$key} is not a defined .env variable and has not default value");

        return $value or $default;
    }
}


if (!function_exists('base_path'))
{
    function base_path($path = ''): string
    {
        return  __DIR__ . "/../{$path}";
    }
}


if (!function_exists('database_path'))
{
    function database_path($path = ''): string
    {
        return base_path("database/{$path}");
    }
}

if (!function_exists('config_path'))
{
    function config_path($path = ''): string
    {
        return base_path("config/{$path}");
    }
}

if (!function_exists('storage_path'))
{
    function storage_path($path = ''): string
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

if (! function_exists('data_get')) {
    /**
     * Get an item from an array or object using "dot" notation.
     *
     * @param  mixed  $target
     * @param  string|array|int|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    function data_get($target, $key, $default = null)
    {
        if (is_null($key)) {
            return $target;
        }

        $key = is_array($key) ? $key : explode('.', $key);

        while (! is_null($segment = array_shift($key))) {
            if ($segment === '*') {
                if ($target instanceof Collection) {
                    $target = $target->all();
                } elseif (! is_array($target)) {
                    return value($default);
                }

                $result = [];

                foreach ($target as $item) {
                    $result[] = data_get($item, $key);
                }

                return in_array('*', $key) ? Arr::collapse($result) : $result;
            }

            if (Arr::accessible($target) && Arr::exists($target, $segment)) {
                $target = $target[$segment];
            } elseif (is_object($target) && isset($target->{$segment})) {
                $target = $target->{$segment};
            } else {
                return value($default);
            }
        }

        return $target;
    }
}
