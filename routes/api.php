<?php

declare(strict_types=1);

use App\Controllers\Auth\LoginController;
use App\Middleware\JsonBodyParserMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('/api' , function (RouteCollectorProxy $group){
        $group->group('/v1', function (RouteCollectorProxy $group){
//            $group->get();
        });

        $group->post('/login', [LoginController::class, 'login']);
    })
    ->addMiddleware(new JsonBodyParserMiddleware());
};
