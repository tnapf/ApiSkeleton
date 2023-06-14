<?php

use Core\Env;
use Tnapf\Router\Router;

$envFile = __ROOT__ . '/.env';

$env = file_exists($envFile) ? Env::createFromFile($envFile) : new Env();
$env->router = new Router();
