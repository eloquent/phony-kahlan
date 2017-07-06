<?php

namespace Eloquent\Phony\Kahlan;

use Eloquent\Phony\Facade\AbstractFacade;

/**
 * A facade for Phony usage under Kahlan.
 */
class Phony extends AbstractFacade
{
    /**
     * Install Phony for Kahlan.
     */
    public static function install()
    {
        return static::driver()->install();
    }

    /**
     * Get the facade driver.
     *
     * @return FacadeDriver The facade driver.
     */
    protected static function driver()
    {
        return FacadeDriver::instance();
    }
}
