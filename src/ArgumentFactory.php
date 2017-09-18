<?php

namespace Eloquent\Phony\Kahlan;

use ReflectionException;
use ReflectionFunction;

/**
 * Creates test double arguments for callbacks.
 */
class ArgumentFactory
{
    public function __construct()
    {
        try {
            $function = new ReflectionFunction(function (object $a) {});
            $parameters = $function->getParameters();
            $this->isObjectTypeSupported = null === $parameters[0]->getClass();
        } catch (ReflectionException $e) {
            $this->isObjectTypeSupported = false;
        }
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

            $typeName = strval($parameter->getType());

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
                case 'iterable':
                    $argument = [];

                    break;

                case 'object':
                    if ($this->isObjectTypeSupported) {
                        $argument = (object) [];

                        break;
                    }

                    $argument = Phony::mock('object')->get();

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

    private $isObjectTypeSupported;
}
