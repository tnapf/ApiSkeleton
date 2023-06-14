<?php

use Core\Env;

const API_ROOT = __DIR__ . '/..';

require_once API_ROOT . '/Bootstrap/requires.php';

Env::get()->router->emit();
