<?php

namespace Core\Routing;

use Attribute;
use Tnapf\Router\Routing\Methods;

#[Attribute(Attribute::TARGET_CLASS)]
class Route
{
    public function __construct(
        public readonly string $uri,
        public readonly array $methods = [Methods::GET],
        public readonly array $middlewares = [],
        public readonly array $postwares = [],
        public readonly array $parameters = [],
        public readonly bool $disabled = false
    ) {
    }
}
