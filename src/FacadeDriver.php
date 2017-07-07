<?php

namespace Eloquent\Phony\Kahlan;

use Eloquent\Phony\Facade\FacadeDriver as PhonyFacadeDriver;
use Kahlan\Block\Group;
use Kahlan\Block\Specification;
use Kahlan\Filter\Chain;
use Kahlan\Filter\Filter;
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
    public function __construct(string $filterClass = Filter::class)
    {
        parent::__construct(new AssertionRecorder());

        $this->filterClass = $filterClass;
        $this->argumentFactory = new ArgumentFactory();

        $this->matcherFactory->addMatcherDriver(new ArgumentMatcherDriver());
    }

    /**
     * Install Phony for Kahlan.
     */
    public function install()
    {
        if (null !== $this->aspect) {
            return;
        }

        $filterClass = $this->filterClass;
        $argumentFactory = $this->argumentFactory;

        $this->aspect = $filterClass::register(
            'phony.execute',
            function (Chain $chain) use ($argumentFactory) {
                list($closure) = $chain->params();
                $arguments = $argumentFactory->argumentsForCallback($closure);

                return $closure(...$arguments);
            }
        );

        $filterClass::apply(Group::class, 'executeClosure', 'phony.execute');
        $filterClass::apply(Specification::class, 'executeClosure', 'phony.execute');
        $filterClass::apply(Suite::class, 'executeClosure', 'phony.execute');
    }

    /**
     * Uninstall Phony for Kahlan.
     */
    public function uninstall()
    {
        if (null === $this->aspect) {
            return;
        }

        $filterClass = $this->filterClass;

        $filterClass::detach(Group::class, 'executeClosure', 'phony.execute');
        $filterClass::detach(Specification::class, 'executeClosure', 'phony.execute');
        $filterClass::detach(Suite::class, 'executeClosure', 'phony.execute');
        $filterClass::unregister($this->aspect);
        $this->aspect = null;
    }

    private static $instance;
    private $filterClass;
    private $argumentFactory;
    private $aspect;
}
