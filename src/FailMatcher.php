<?php

namespace Eloquent\Phony\Kahlan;

/**
 * A Kahlan expect() matcher that fails with a supplied description.
 */
class FailMatcher
{
    /**
     * Get a failure result.
     *
     * @param mixed  $actual      Ignored.
     * @param string $description The failure description.
     *
     * @return FailResult The result.
     */
    public static function match($actual, $description)
    {
        return new FailResult($description);
    }
}
