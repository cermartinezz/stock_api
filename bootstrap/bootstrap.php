<?php

use DI\ContainerBuilder;
use DI\Bridge\Slim\Bridge as AppFactory;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

$ENV = env('ENV');

$containerBuilder = new ContainerBuilder();

// Import services
$dependencies = require_once __DIR__ . '/../config/services.php';
$dependencies($containerBuilder);

// Initialize app with PHP-DI
$container = $containerBuilder->build();

$container->set('db', config('settings.db'));

date_default_timezone_set(config('settings.location.region'));

$app = AppFactory::create($container);

$database = require_once __DIR__ . '/../config/database.php';
$database($app);

// Register routes
$routes = require_once __DIR__ . '/../routes/api.php';
$routes($app);

// Setup Basic Auth
$auth = require_once __DIR__ . '/../config/auth.php';
$auth($app);

// Setup Basic Auth
$middleware = require_once __DIR__ . '/../config/middleware.php';
$middleware($app);

$_SERVER['app'] = &$app;

if (!function_exists('app'))
{
    function app()
    {
        return $_SERVER['app'];
    }
}

return $app;
