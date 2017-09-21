<?php

declare(strict_types=1);

namespace Eloquent\Phony\Kahlan;

use Kahlan\Suite;

/**
 * Manages the installation of Kahlan filters for test dependency injection.
 */
class FilterManager
{
    public function __construct(
        FilterFactory $filterFactory,
        string $filtersClass
    ) {
        $this->filterFactory = $filterFactory;
        $this->filtersClass = $filtersClass;
    }

    public function install()
    {
        if (null !== $this->filterId) {
            return;
        }

        $this->filterId = $this->filtersClass::apply(
            Suite::class,
            'runBlock',
            $this->filterFactory->createFilter()
        );
    }

    public function uninstall()
    {
        if (null === $this->filterId) {
            return;
        }

        $this->filtersClass::detach($this->filterId);
        $this->filterId = null;
    }

    private $filterFactory;
    private $filtersClass;
    private $filterId;
}
