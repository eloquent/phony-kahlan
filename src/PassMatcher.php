<?php

namespace Eloquent\Phony\Kahlan;

use Eloquent\Phony\Event\EventCollection;

/**
 * A Kahlan expect() matcher that passes with a supplied Phony verification
 * result.
 */
class PassMatcher
{
    /**
     * Get a pass result.
     *
     * @param mixed           $actual Ignored.
     * @param EventCollection $result The Phony verification result.
     *
     * @return PassResult The result.
     */
    public static function match($actual, $result)
    {
        return new PassResult($result);
    }
}
