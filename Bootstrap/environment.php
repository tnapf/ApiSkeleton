<?php

use Core\Env;
use Tnapf\Router\Router;

const API_ENV = API_ROOT . '/.env';
const API_PREFIX = '/api';

$env = file_exists(API_ENV) ? Env::createFromFile(API_ENV) : new Env();
$env->router = new Router();
