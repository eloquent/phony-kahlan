<?php

declare(strict_types=1);

namespace Eloquent\Phony\Kahlan;

use Closure;
use ReflectionFunction;

/**
 * Creates test double arguments for callbacks.
 */
class ArgumentFactory
{
    /**
     * Returns an argument list of test doubles for the supplied callback.
     *
     * @param callable $callback The callback.
     *
     * @return array<int,mixed> The arguments.
     */
    public function argumentsForCallback(callable $callback): array
    {
        /** @var Closure */
        $callableCallback = $callback;

        $definition = new ReflectionFunction($callableCallback);
        $arguments = [];

        foreach ($definition->getParameters() as $parameter) {
            if ($type = $parameter->getType()) {
                $arguments[] = Phony::emptyValue($type);
            } else {
                $arguments[] = null;
            }
        }

        return $arguments;
    }
}
