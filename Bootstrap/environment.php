<?php

use Core\Env;
use Tnapf\Router\Router;

$env = Env::createFromFile(__ROOT__ . '/.env');
$env->router = new Router();
