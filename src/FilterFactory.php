<?php

declare(strict_types=1);

namespace Eloquent\Phony\Kahlan;

/**
 * Creates the Kahlan filter used to perform test dependency injection.
 */
class FilterFactory
{
    public function __construct(ArgumentFactory $argumentFactory)
    {
        $this->argumentFactory = $argumentFactory;
    }

    public function createFilter(): callable
    {
        $argumentFactory = $this->argumentFactory;

        return function ($next, $block, callable $closure) use (
            $argumentFactory
        ) {
            return $closure(
                ...$argumentFactory->argumentsForCallback($closure)
            );
        };
    }

    private $argumentFactory;
}
