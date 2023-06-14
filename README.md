# Tnapf/ApiSkeleton

# Bootstrapping

Just create a new file inside `Bootstrap` and then require it in `Bootstrap/requires.php`

# Routing

## Creating an endpoint

First create a class that extends `Tnapf\Router\Interfaces\ControllerInterface` inside `App\Controllers` and add the `#[Route]` attribute to the class.

```php
<?php

namespace App\Controllers;

use Core\ApiResponse;
use Core\Routing\Route;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tnapf\Router\Interfaces\ControllerInterface;
use Tnapf\Router\Routing\RouteRunner;

#[Route('/ping', ['GET'])]
class Ping implements ControllerInterface
{
    public function handle(
        ServerRequestInterface $request,
        ResponseInterface $response,
        RouteRunner $route
    ): ResponseInterface {
        return ApiResponse::success();
    }
}
```

## Creating responses

There is a helper class named `ApiResponse` that can be used to create responses.

```php
use Core\ApiResponse;ApiResponse;

ApiResponse::success(200);
/**
 * {
 *   "success": true
 * }
 */

ApiResponse::successWithData(['foo' => 'bar']);
/**
 * {
 *   "success": true,
 *   "data": {
 *     "foo": "bar"
 *   }
 * } 
 */

ApiResponse::error('life is pain', 500);
/**
 * {
 *   "success": false,
 *   "message": "life is pain",
 *   "code": 500
 * } 
 */

ApiResponse::errorWithData('life is pain', ['foo' => 'bar'], 500);
/**
 * {
 *    "success": false,
 *    "message": "life is pain",
 *    "code": 500,
 *    "data": {
 *      "foo": "bar"
 *    } 
 * }
 */
```

# Unit Testing

## Creating a test

Create a class that extends `Tests\ApiTestCase` inside `App\Tests`. This should bootstrap the application into the testing environment, so you can test your endpoints. You'll also get some additional helper methods. See `Tests\PingTest.php` for an example.

## Running tests

`composer tests` or `composer tests:coverage` to generate a coverage report.

# Packages

* [php: ^8.1](https://www.php.net/downloads.php)
* [tnapf/env: ^v1.1.1](https://packagist.org/packages/tnapf/env)
* [tnapf/router: ^v6.0.0](https://packagist.org/packages/tnapf/router)
* [commandstring/utils: ^1.7](https://packagist.org/packages/commandstring/utils)
* [xheaven/composer-git-hooks: ^3.0](https://packagist.org/packages/xheaven/composer-git-hooks)
