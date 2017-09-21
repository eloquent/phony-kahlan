<?php

declare(strict_types=1);

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
    public function install()
    {
        Globals::$container->filterManager->install();
    }

    /**
     * Uninstall Phony for Kahlan.
     */
    public function uninstall()
    {
        Globals::$container->filterManager->uninstall();
    }

    private static $globals = Globals::class;
}
