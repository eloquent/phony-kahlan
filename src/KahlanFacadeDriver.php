<?php

/*
 * This file is part of the Phony package.
 *
 * Copyright © 2017 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

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

        $this->matcherFactory->addMatcherDriver(new KahlanMatcherDriver());
    }

    private static $instance;
}
