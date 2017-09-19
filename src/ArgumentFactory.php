<?php

namespace Eloquent\Phony\Kahlan;

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
     * @return array The arguments.
     */
    public function argumentsForCallback(callable $callback)
    {
        $definition = new ReflectionFunction($callback);
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
