<?php

namespace App\Catchers;

use Core\ApiResponse;
use Core\Routing\Catcher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Tnapf\Router\Interfaces\ControllerInterface;
use Tnapf\Router\Routing\RouteRunner;

#[Catcher(Throwable::class, priority: -1)]
class E500 implements ControllerInterface
{
    public function handle(
        ServerRequestInterface $request,
        ResponseInterface $response,
        RouteRunner $route
    ): ResponseInterface {
        return ApiResponse::errorWithData(
            $route->exception->getMessage(),
            [
                'file' => $route->exception->getFile(),
                'line' => $route->exception->getLine(),
                'stacktrace' => $route->exception->getTrace(),
            ],
            500
        );
    }
}
