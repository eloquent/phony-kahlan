<?php

declare(strict_types=1);

namespace Eloquent\Phony\Kahlan;

use Eloquent\Phony\Exporter\Exporter;
use Eloquent\Phony\Matcher\Matcher;
use Kahlan\Arg;

/**
 * A matcher that wraps a Kahlan argument matcher.
 */
class ArgumentMatcher implements Matcher
{
    /**
     * Construct a new Kahlan matcher.
     *
     * @param Arg $matcher The matcher to wrap.
     */
    public function __construct(Arg $matcher)
    {
        $this->matcher = $matcher;
    }

    /**
     * Returns `true` if `$value` matches this matcher's criteria.
     *
     * @param mixed $value The value to check.
     *
     * @return bool True if the value matches.
     */
    public function matches($value): bool
    {
        return $this->matcher->match($value);
    }

    /**
     * Describe this matcher.
     *
     * @param Exporter|null $exporter The exporter to use.
     *
     * @return string The description.
     */
    public function describe(Exporter $exporter = null): string
    {
        return '<' . $this->matcher . '>';
    }

    /**
     * Describe this matcher.
     *
     * @return string The description.
     */
    public function __toString(): string
    {
        return '<' . $this->matcher . '>';
    }

    /**
     * @var Arg
     */
    private $matcher;
}
