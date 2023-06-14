<?php

namespace Core\Routing;

use Attribute;
use Tnapf\Router\Routing\Methods;

#[Attribute(Attribute::TARGET_CLASS)]
readonly class Route
{
    public function __construct(
        public string $uri,
        public array $methods = [Methods::GET],
        public array $middlewares = [],
        public array $postwares = [],
        public array $parameters = [],
        public bool $disabled = false
    ) {
    }
}
