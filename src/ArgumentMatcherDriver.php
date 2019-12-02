<?php

declare(strict_types=1);

namespace Eloquent\Phony\Kahlan;

use Eloquent\Phony\Matcher\Matchable;
use Eloquent\Phony\Matcher\MatcherDriver;
use Kahlan\Arg;

/**
 * A matcher driver for Kahlan argument matchers.
 */
class ArgumentMatcherDriver implements MatcherDriver
{
    public function __construct(callable $classExists)
    {
        $this->classExists = $classExists;
    }

    /**
     * Returns true if this matcher driver's classes or interfaces exist.
     *
     * @return bool True if available.
     */
    public function isAvailable(): bool
    {
        return ($this->classExists)(Arg::class);
    }

    /**
     * Get the supported matcher class names.
     *
     * @return array<string> The matcher class names.
     */
    public function matcherClassNames(): array
    {
        return [Arg::class];
    }

    /**
     * Wrap the supplied third party matcher.
     *
     * @param Arg $matcher The matcher to wrap.
     *
     * @return Matchable The wrapped matcher.
     */
    public function wrapMatcher($matcher): Matchable
    {
        return new ArgumentMatcher($matcher);
    }

    private $classExists;
}
