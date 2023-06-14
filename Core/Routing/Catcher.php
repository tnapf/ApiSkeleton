<?php

namespace Core\Routing;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Catcher
{
    public function __construct(
        public readonly string $toCatch,
        public readonly string $uri = '/(.*)',
        public readonly bool $disabled = false,
        public readonly int $priority = 0
    ) {

    }
}
