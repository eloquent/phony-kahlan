<?php

declare(strict_types=1);

namespace Eloquent\Phony\Kahlan;

use Closure;
use Kahlan\Block;

/**
 * Creates the Kahlan filter used to perform test dependency injection.
 */
class FilterFactory
{
    public function __construct(ArgumentFactory $argumentFactory)
    {
        $this->argumentFactory = $argumentFactory;
    }

    public function createFilter()
    {
        $argumentFactory = $this->argumentFactory;

        return function (callable $next, Block $block, Closure $closure) use (
            $argumentFactory
        ) {
            return $closure(
                ...$argumentFactory->argumentsForCallback($closure)
            );
        };
    }

    private $argumentFactory;
}
