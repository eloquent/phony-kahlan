<?php

namespace Eloquent\Phony\Kahlan;

use Eloquent\Phony\Exporter\Exporter;
use Kahlan\Arg;
use ReflectionClass;

/**
 * Describes Kahlan argument matchers.
 */
class KahlanMatcherDescriber
{
    /**
     * Construct a new Kahlan matcher describer.
     *
     * @param Exporter $exporter The exporter to use.
     */
    public function __construct(Exporter $exporter)
    {
        $this->exporter = $exporter;

        $argClass = new ReflectionClass(Arg::class);

        $this->nameProperty = $argClass->getProperty('_name');
        $this->nameProperty->setAccessible(true);

        $this->argsProperty = $argClass->getProperty('_args');
        $this->argsProperty->setAccessible(true);
    }

    /**
     * Describes the supplied matcher.
     *
     * @param Arg           $matcher  The matcher.
     * @param Exporter|null $exporter The exporter to use.
     *
     * @return string The description.
     */
    public function describe(Arg $matcher, Exporter $exporter = null)
    {
        if (!$exporter) {
            $exporter = $this->exporter;
        }

        $name = $this->nameProperty->getValue($matcher);
        $args = $this->argsProperty->getValue($matcher);

        return sprintf(
            '<%s (%s)>',
            $name,
            implode(', ', array_map([$exporter, 'export'], $args))
        );
    }

    private $exporter;
    private $nameProperty;
    private $argsProperty;
}
