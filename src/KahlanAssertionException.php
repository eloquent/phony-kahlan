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

use Eloquent\Phony\Assertion\Exception\AssertionException;
use PHPUnit\Framework\ExpectationFailedException;

/**
 * Wraps Kahlan's expectation failed exception for improved assertion failure
 * output.
 */
final class KahlanAssertionException extends ExpectationFailedException
{
    /**
     * Construct a new Kahlan assertion exception.
     *
     * @param string $description The failure description.
     */
    public function __construct($description)
    {
        AssertionException::trim($this);

        parent::__construct($description);
    }
}
