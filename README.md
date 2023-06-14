# Tnapf/ApiSkeleton

# Setup
`composer create-project tnapf/api-skeleton`

# Bootstrapping

Just create a new file inside `Bootstrap` and then require it in `Bootstrap/requires.php`

# Routing

## Creating an endpoint

First create a class that extends `Tnapf\Router\Interfaces\ControllerInterface` inside `App\Controllers` and add the `#[Route]` attribute to the class.

By default, each URI is prefixed with `/api` so the route below can be access by `/api/ping`. You can change this by setting the `API_PREFIX` constant in `Bootstrap/environment.php`.

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
Note: You can set the priority of the route to determine the order in which routes are loaded. The default priority is 0.

## Catching exceptions

First create a class that extends `Tnapf\Router\Interfaces\ControllerInterface` inside `App\Catchers` and add the `#[Catcher]` attribute to the class.

```php
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
```
Note: You can set the priority of the catcher to determine the order in which catchers are loaded. The default priority is 0.

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

# Dependencies

* [php: ^8.1](https://www.php.net/downloads.php)
* [tnapf/env: ^v1.1.1](https://packagist.org/packages/tnapf/env)
* [tnapf/router: ^v6.0.0](https://packagist.org/packages/tnapf/router)
* [commandstring/utils: ^1.7](https://packagist.org/packages/commandstring/utils)

# Dev Dependencies

* [friendsofphp/php-cs-fixer: ^3.16](https://packagist.org/packages/friendsofphp/php-cs-fixer)
* [phpunit/phpunit: ^10.1](https://www.php.net/downloads.php)
* [xheaven/composer-git-hooks: ^3.0](https://packagist.org/packages/xheaven/composer-git-hooks)
