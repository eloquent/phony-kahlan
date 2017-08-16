<?php

namespace Eloquent\Phony\Kahlan;

use Eloquent\Phony\Facade\FacadeDriver as PhonyFacadeDriver;
use Kahlan\Filter\Filters;
use Kahlan\Suite;

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
    public function __construct(string $filtersClass = Filters::class)
    {
        parent::__construct(new AssertionRecorder());

        $this->filtersClass = $filtersClass;
        $this->matcherFactory->addMatcherDriver(new ArgumentMatcherDriver());

        $argumentFactory = new ArgumentFactory();
        $this->filter = function ($next, $block, $closure) use ($argumentFactory) {
            $arguments = $argumentFactory->argumentsForCallback($closure);

            return $closure(...$arguments);
        };
    }

    /**
     * Install Phony for Kahlan.
     */
    public function install()
    {
        if (null !== $this->filterId) {
            return;
        }

        $filtersClass = $this->filtersClass;
        $this->filterId = $filtersClass::apply(Suite::class, 'runBlock', $this->filter);
    }

    /**
     * Uninstall Phony for Kahlan.
     */
    public function uninstall()
    {
        if (null === $this->filterId) {
            return;
        }

        $filtersClass = $this->filtersClass;
        $filtersClass::detach($this->filterId);
        $this->filterId = null;
    }

    private static $instance;
    private $filtersClass;
    private $filter;
    private $filterId;
}
