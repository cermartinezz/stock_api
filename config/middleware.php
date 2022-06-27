<?php

return function (\Slim\App $app){
    $app->add(new Tuupola\Middleware\JwtAuthentication([
        "path" => '/api',
        "ignore" => ["/api/login"],
        "secret" => env('APP_KEY'),
        "error" => function ($response, $arguments) {
            $data["status"] = "error";
            $data["message"] = $arguments["message"];
            $response = $response->withHeader('Content-Type', 'application/json');

            $response->getBody()
                ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

            return $response;
        }
    ]));

    $displayErrorDetails = env('ENV') == 'dev';

    $errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, true, true);

    // Error Handler
    $errorHandler = $errorMiddleware->getDefaultErrorHandler();
    $errorHandler->forceContentType('application/json');
};
