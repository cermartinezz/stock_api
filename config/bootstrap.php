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

$conn = \Illuminate\Container\Container::getInstance();
$database = require_once __DIR__ . '/../config/database.php';
$connFactory = new \Illuminate\Database\Connectors\ConnectionFactory($conn);
$conn = $connFactory->make($database['db']);
$resolver = new \Illuminate\Database\ConnectionResolver();
$resolver->addConnection('default', $conn);
$resolver->setDefaultConnection('default');
\Illuminate\Database\Eloquent\Model::setConnectionResolver($resolver);

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
