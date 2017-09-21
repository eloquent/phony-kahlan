<?php

declare(strict_types=1);

namespace Eloquent\Phony\Kahlan;

use Eloquent\Phony\Facade\FacadeContainerTrait;
use Kahlan\Filter\Filters;

/**
 * A service container for Phony for Kahlan facades.
 */
class FacadeContainer
{
    use FacadeContainerTrait;

    public function __construct()
    {
        $this->initializeContainer(new AssertionRecorder());
        $this->matcherFactory
            ->addMatcherDriver(new ArgumentMatcherDriver('class_exists'));

        $this->filterManager = new FilterManager(
            new FilterFactory(new ArgumentFactory()),
            Filters::class
        );
    }

    public $filterManager;
}
