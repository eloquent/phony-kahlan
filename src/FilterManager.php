<?php

declare(strict_types=1);

namespace Eloquent\Phony\Kahlan;

use Kahlan\Suite;

/**
 * Manages the installation of Kahlan filters for test dependency injection.
 */
class FilterManager
{
    /**
     * @param class-string $filtersClass
     */
    public function __construct(
        FilterFactory $filterFactory,
        string $filtersClass
    ) {
        $this->filterFactory = $filterFactory;
        $this->filtersClass = $filtersClass;
    }

    public function install(): void
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

    public function uninstall(): void
    {
        if (null === $this->filterId) {
            return;
        }

        $this->filtersClass::detach($this->filterId);
        $this->filterId = null;
    }

    /**
     * @var FilterFactory
     */
    private $filterFactory;

    /**
     * @var class-string
     */
    private $filtersClass;

    /**
     * @var ?string
     */
    private $filterId;
}
