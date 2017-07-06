<?php

namespace Eloquent\Phony\Kahlan;

use Eloquent\Phony\Facade\FacadeDriver as PhonyFacadeDriver;
use Kahlan\Block\Group;
use Kahlan\Block\Specification;
use Kahlan\Filter\Chain;
use Kahlan\Filter\Filter;

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

        $this->matcherFactory->addMatcherDriver(new ArgumentMatcherDriver());
        $this->argumentFactory = new ArgumentFactory();
    }

    /**
     * Install Phony for Kahlan.
     */
    public function install()
    {
        $argumentFactory = $this->argumentFactory;

        Filter::register(
            'phony.execute',
            function (Chain $chain) use ($argumentFactory) {
                list($closure) = $chain->params();
                $arguments = $argumentFactory->argumentsForCallback($closure);

                return $closure(...$arguments);
            }
        );

        Filter::apply(Group::class, 'executeClosure', 'phony.execute');
        Filter::apply(Specification::class, 'executeClosure', 'phony.execute');
    }

    private static $instance;
    private $argumentFactory;
}
