<?php

use App\Middleware\JsonBodyParserMiddleware;
use App\Models\User;
use Slim\App;

return function (App $app){

    $app->add(new JsonBodyParserMiddleware());
    $app->add(new Tuupola\Middleware\JwtAuthentication([
        "path" => '/api',
        "ignore" => ["/api/login","/api/register"],
        "secret" => env('APP_KEY'),
        "error" => function ($response, $arguments) {
            $data["status"] = "error";
            $data["message"] = $arguments["message"];
            $response = $response->withHeader('Content-Type', 'application/json');

            $response->getBody()
                ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

            return $response;
        },
        "before" => function ($request, $arguments){
            $token = $request->getAttribute('token');

            if(!empty($token)){
                $user = User::query()->where('id', $token['sub'])->first();
                return $request->withAttribute("auth", $user);
            }
        }
    ]));

    $displayErrorDetails = env('ENV') == 'dev';

    $errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, true, true);

    // Error Handler
    $errorHandler = $errorMiddleware->getDefaultErrorHandler();
    $errorHandler->forceContentType('application/json');
};
