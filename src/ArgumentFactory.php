<?php

namespace Eloquent\Phony\Kahlan;

use ReflectionFunction;

/**
 * Creates test double arguments for callbacks.
 */
class ArgumentFactory
{
    /**
     * Construct a new argument factory.
     */
    public function __construct()
    {
        $this->isScalarTypeHintSupported =
            method_exists('ReflectionParameter', 'getType');
    }

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
        $parameters = $definition->getParameters();
        $arguments = [];

        foreach ($parameters as $parameter) {
            if ($parameter->allowsNull()) {
                $arguments[] = null;

                continue;
            }

            if ($this->isScalarTypeHintSupported) {
                $typeName = strval($parameter->getType());
                // @codeCoverageIgnoreStart
            } elseif ($class = $parameter->getClass()) {
                $typeName = $class->getName();
            } elseif ($parameter->isArray()) {
                $typeName = 'array';
            } elseif ($parameter->isCallable()) {
                $typeName = 'callable';
            } else {
                $arguments[] = null;

                continue;
            }
            // @codeCoverageIgnoreEnd

            switch (strtolower($typeName)) {
                case 'bool':
                    $argument = false;

                    break;

                case 'int':
                    $argument = 0;

                    break;

                case 'float':
                    $argument = .0;

                    break;

                case 'string':
                    $argument = '';

                    break;

                case 'array':
                    $argument = [];

                    break;

                case 'stdclass':
                    $argument = (object) [];

                    break;

                case 'callable':
                    $argument = Phony::stub();

                    break;

                case 'closure':
                    $argument = function () {};

                    break;

                case 'generator':
                    $fn = function () { return; yield; };
                    $argument = $fn();

                    break;

                default:
                    $argument = Phony::mock($typeName)->get();
            }

            $arguments[] = $argument;
        }

        return $arguments;
    }

    private $isScalarTypeHintSupported;
}
