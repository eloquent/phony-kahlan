<?php

namespace Eloquent\Phony\Kahlan;

/**
 * Represents a Phony verification failure under Kahlan.
 */
class FailResult
{
    /**
     * Construct a new fail result.
     *
     * @param string $description The failure description.
     */
    public function __construct($description)
    {
        $this->description = $description;
    }

    /**
     * Always returns false.
     *
     * @return false
     */
    public function resolve()
    {
        return false;
    }

    /**
     * Get the failure description.
     *
     * @return array The description.
     */
    public function description()
    {
        return [
            'description' => '',
            'data' => ['raw' => $this->description]
        ];
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

    private $description;
}
