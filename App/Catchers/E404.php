<?php

namespace App\Catchers;

use Core\ApiResponse;
use Core\Routing\Catcher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tnapf\Router\Exceptions\HttpNotFound;
use Tnapf\Router\Interfaces\ControllerInterface;
use Tnapf\Router\Routing\RouteRunner;

#[Catcher(HttpNotFound::class)]
class E404 implements ControllerInterface
{
    public function handle(
        ServerRequestInterface $request,
        ResponseInterface $response,
        RouteRunner $route
    ): ResponseInterface {
        return ApiResponse::error('Endpoint Not Found', 404);
    }
}
