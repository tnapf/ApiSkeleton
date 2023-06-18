<?php

use CommandString\Utils\FileSystemUtils;
use Core\Env;
use Core\Routing\Catcher;
use Tnapf\Router\Interfaces\ControllerInterface;
use Tnapf\Router\Routing\Route;
use Core\Routing\Route as RouteAttribute;

$router = Env::get()->router;
$routeDirectory = API_ROOT . '/App/Controllers';
$catcherDirectory = API_ROOT . '/App/Catchers';

$convertPathToNamespace = static fn (string $path): string => str_replace([realpath(API_ROOT), '/'], ['', '\\'], $path);

// Register Routes
$routes = [];
foreach (FileSystemUtils::getAllFilesWithExtensions($routeDirectory, ['php'], true) as $file) {
    $className = basename($file, '.php');
    $path = dirname($file);
    $namespace = $convertPathToNamespace($path);
    $className = $namespace . '\\' . $className;
    $reflection = new ReflectionClass($className);
    $routeProperties = $reflection->getAttributes(RouteAttribute::class, ReflectionAttribute::IS_INSTANCEOF)[0] ?? null;

    if ($routeProperties === null) {
        continue;
    }

    $controller = new $className();

    /** @var RouteAttribute $settings */
    $settings = $routeProperties->newInstance();

    if ($settings->disabled) {
        continue;
    }

    $routes[] = compact('settings', 'controller');
}

foreach ($routes as $route) {
    /** @var RouteAttribute $settings */
    $settings = $route['settings'];

    /** @var ControllerInterface $route */
    $controller = $route['controller'];

    $route = new Route(
        $settings->uri,
        $controller,
        API_PREFIX,
        ...$settings->methods,
    );

    if (count($settings->parameters) > 0) {
        foreach ($settings->parameters as $name => $regex) {
            $route->setParameter($name, $regex);
        }
    }

    $route->addPostware(...$settings->postwares);
    $route->addMiddleware(...$settings->middlewares);

    $router->addRoute($route);
}

// Register Catchers
$catchers = [];
foreach (FileSystemUtils::getAllFilesWithExtensions($catcherDirectory, ['php']) as $file) {
    $className = basename($file, '.php');
    $path = dirname($file);
    $namespace = $convertPathToNamespace($path);
    $className = $namespace . '\\' . $className;
    $reflection = new ReflectionClass($catcher);
    $catcherProperties = $reflection->getAttributes(Catcher::class, ReflectionAttribute::IS_INSTANCEOF)[0] ?? null;

    if ($catcherProperties === null) {
        continue;
    }
    
    $catcher = new $className();

    /** @var Catcher $settings */
    $settings = $catcherProperties->newInstance();

    if ($settings->disabled) {
        continue;
    }

    $uri = API_PREFIX . $settings->uri;

    $catchers[] = compact('settings', 'catcher');
}

usort($catchers, static fn ($a, $b) => $a['settings']->priority <=> $b['settings']->priority);

foreach ($catchers as $catcher) {
    /** @var Catcher $settings */
    $settings = $catcher['settings'];

    /** @var ControllerInterface $catcher */
    $catcher = $catcher['catcher'];

    $router->catch($settings->toCatch, $catcher, $settings->uri);
}
