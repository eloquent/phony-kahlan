<?php

namespace Eloquent\Phony\Kahlan;

/**
 * A Kahlan matcher that fails with a supplied description.
 */
class KahlanFailureMatcher
{
    /**
     * Always returns false.
     *
     * @param mixed  $actual      Ignored.
     * @param string $description The failure description.
     *
     * @return false
     */
    public static function match($actual, $description)
    {
        self::$description = $description;

        return false;
    }

    /**
     * Get the most recent failure description.
     *
     * @return string The failure description.
     */
    public static function description()
    {
        return self::$description;
    }

    private static $description;
}
