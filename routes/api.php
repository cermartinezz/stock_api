<?php

declare(strict_types=1);

use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\RegisterController;
use App\Controllers\Stock\StockController;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('/api' , function (RouteCollectorProxy $group){
        $group->group('/v1', function (RouteCollectorProxy $group){
            $group->get('/stock', [StockController::class, 'show']);
        });

        $group->post('/login', [LoginController::class, 'login']);
        $group->post('/register', [RegisterController::class, 'register']);
    });
};
