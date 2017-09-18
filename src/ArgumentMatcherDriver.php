<?php

namespace Eloquent\Phony\Kahlan;

use Eloquent\Phony\Matcher\Matchable;
use Eloquent\Phony\Matcher\MatcherDriver;

/**
 * A matcher driver for Kahlan argument matchers.
 */
class ArgumentMatcherDriver implements MatcherDriver
{
    /**
     * Returns true if this matcher driver's classes or interfaces exist.
     *
     * @return bool True if available.
     */
    public function isAvailable(): bool
    {
        return class_exists('Kahlan\Arg');
    }

    /**
     * Get the supported matcher class names.
     *
     * @return array<string> The matcher class names.
     */
    public function matcherClassNames(): array
    {
        return ['Kahlan\Arg'];
    }

    /**
     * Wrap the supplied third party matcher.
     *
     * @param object $matcher The matcher to wrap.
     *
     * @return Matchable The wrapped matcher.
     */
    public function wrapMatcher($matcher): Matchable
    {
        return new ArgumentMatcher($matcher);
    }
}
