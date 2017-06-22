<?php

namespace Eloquent\Phony\Kahlan;

use Eloquent\Phony\Exporter\Exporter;
use Eloquent\Phony\Matcher\WrappedMatcher;
use Kahlan\Arg;

/**
 * A matcher that wraps a Kahlan constraint.
 */
class KahlanMatcher extends WrappedMatcher
{
    /**
     * Construct a new Kahlan matcher.
     *
     * @param Arg                    $matcher   The matcher to wrap.
     * @param KahlanMatcherDescriber $describer The describer to use.
     */
    public function __construct(Arg $matcher, KahlanMatcherDescriber $describer)
    {
        parent::__construct($matcher);

        $this->describer = $describer;
    }

    /**
     * Returns `true` if `$value` matches this matcher's criteria.
     *
     * @param mixed $value The value to check.
     *
     * @return bool True if the value matches.
     */
    public function matches($value)
    {
        return (bool) $this->matcher->match($value);
    }

    /**
     * Describe this matcher.
     *
     * @param Exporter|null $exporter The exporter to use.
     *
     * @return string The description.
     */
    public function describe(Exporter $exporter = null)
    {
        return $this->describer->describe($this->matcher, $exporter);
    }

    /**
     * Describe this matcher.
     *
     * @return string The description.
     */
    public function __toString()
    {
        return $this->describer->describe($this->matcher);
    }

    private $describer;
}
