<?php

namespace Eloquent\Phony\Kahlan;

use Eloquent\Phony\Event\EventCollection;

/**
 * Represents a Phony verification success under Kahlan.
 */
class PassResult
{
    /**
     * Construct a new pass result.
     *
     * @param EventCollection $result The Phony verification result.
     */
    public function __construct($result)
    {
        $this->result = $result;
    }

    public function resolve()
    {
        return true;
    }

    /**
     * Always returns an empty string.
     *
     * @return string
     */
    public function description()
    {
        return '';
    }

    /**
     * Always returns an empty array.
     *
     * @return array
     */
    public function backtrace()
    {
        return [];
    }

    public $result;
}
