<?php

use Core\Env;

const ROOT = __DIR__ . '/..';

require_once ROOT . '/Bootstrap/requires.php';

Env::get()->router->emit();
