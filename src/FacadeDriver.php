<?php

namespace Eloquent\Phony\Kahlan;

use Eloquent\Phony\Facade\FacadeDriver as PhonyFacadeDriver;
use Kahlan\Matcher;

/**
 * A facade driver for Kahlan.
 */
class FacadeDriver extends PhonyFacadeDriver
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
        parent::__construct(new AssertionRecorder());

        $this->matcherFactory->addMatcherDriver(new ArgumentMatcherDriver(
            new ArgumentMatcherDescriber($this->exporter)
        ));

        Matcher::register('phonyFail', FailMatcher::class);
        Matcher::register('phonyPass', PassMatcher::class);
    }

    private static $instance;
}
