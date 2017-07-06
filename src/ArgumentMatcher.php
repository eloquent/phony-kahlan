<?php

namespace Eloquent\Phony\Kahlan;

use Eloquent\Phony\Matcher\WrappedMatcher;

/**
 * A matcher that wraps a Kahlan argument matcher.
 */
class ArgumentMatcher extends WrappedMatcher
{
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
}
