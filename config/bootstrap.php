<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

$ENV = $_ENV['ENV'] ?? 'dev';

$containerBuilder = new ContainerBuilder();

// Import services
$dependencies = require __DIR__ . '/../config/services.php';
$dependencies($containerBuilder);

// Initialize app with PHP-DI
$container = $containerBuilder->build();

$container->set('db', function () {
    $database = require __DIR__ . '/../config/database.php';
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($database['db']);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
});

AppFactory::setContainer($container);

$app = AppFactory::create();

// Register routes
$routes = require __DIR__ . '/../routes/api.php';
$routes($app);

// Setup Basic Auth
$auth = require __DIR__ . '/../config/auth.php';
$auth($app);

$displayErrorDetails = $ENV == 'dev';
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, true, true);

// Error Handler
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->forceContentType('application/json');

$app->run();
