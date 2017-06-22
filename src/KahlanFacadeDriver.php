<?php

namespace Eloquent\Phony\Kahlan;

use Eloquent\Phony\Facade\FacadeDriver;

/**
 * A facade driver for Kahlan.
 */
class KahlanFacadeDriver extends FacadeDriver
{
    /**
     * Get the static instance of this driver.
     *
     * @return FacadeDriver The static driver.
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Construct a new Kahlan facade driver.
     */
    public function __construct()
    {
        parent::__construct(new KahlanAssertionRecorder());

        $this->matcherFactory->addMatcherDriver(new KahlanMatcherDriver(
            new KahlanMatcherDescriber($this->exporter)
        ));
    }

    private static $instance;
}
