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
    public static function install(): void
    {
        Globals::$container->filterManager->install();
    }

    /**
     * Uninstall Phony for Kahlan.
     */
    public static function uninstall(): void
    {
        Globals::$container->filterManager->uninstall();
    }

    /**
     * @var class-string
     */
    private static $globals = Globals::class;
}
