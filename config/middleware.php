<?php

use App\Middleware\ErrorHandlerMiddleware;
use App\Middleware\HttpExceptionMiddleware;
use Selective\BasePath\BasePathMiddleware;
use Selective\Validation\Middleware\ValidationExceptionMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return function (App $app) {
    $app->addBodyParsingMiddleware();
    $app->add(ValidationExceptionMiddleware::class);
    $app->addRoutingMiddleware();
    $app->add(BasePathMiddleware::class);
    $app->add(HttpExceptionMiddleware::class);
    $app->add(ErrorHandlerMiddleware::class);
    $app->add(ErrorMiddleware::class);
};
