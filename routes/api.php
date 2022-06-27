<?php

declare(strict_types=1);

use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\RegisterController;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('/api' , function (RouteCollectorProxy $group){
        $group->group('/v1', function (RouteCollectorProxy $group){
        });

        $group->post('/login', [LoginController::class, 'login']);
        $group->post('/register', [RegisterController::class, 'register']);
    });
};
