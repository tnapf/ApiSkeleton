<?php

use Core\Env;

const __ROOT__ = __DIR__ . '/..';

require_once __ROOT__ . '/Bootstrap/requires.php';

Env::get()->router->emit();
