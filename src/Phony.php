<?php

namespace Eloquent\Phony\Kahlan;

use Eloquent\Phony\Facade\FacadeTrait;

/**
 * A facade for Phony usage under Kahlan.
 */
class Phony
{
    use FacadeTrait;

    /**
     * Install Phony for Kahlan.
     */
    public static function install()
    {
        return static::driver()->install();
    }

    /**
     * Uninstall Phony for Kahlan.
     */
    public static function uninstall()
    {
        return static::driver()->uninstall();
    }

    private static function driver()
    {
        return self::$driver ?? self::$driver = FacadeDriver::instance();
    }

    private static $driver;
}
