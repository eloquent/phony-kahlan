<?php

declare(strict_types=1);

namespace Eloquent\Phony\Kahlan;

use Eloquent\Phony\Assertion\AssertionRecorder as PhonyAssertionRecorder;
use Eloquent\Phony\Assertion\Exception\AssertionException;
use Eloquent\Phony\Call\CallVerifierFactory;
use Eloquent\Phony\Event\Event;
use Eloquent\Phony\Event\EventCollection;
use Eloquent\Phony\Event\EventSequence;
use Kahlan\Suite;

/**
 * An assertion recorder for Kahlan.
 */
class AssertionRecorder implements PhonyAssertionRecorder
{
    /**
     * Construct a new assertion recorder.
     *
     * @param class-string $suiteClass
     */
    public function __construct(string $suiteClass = Suite::class)
    {
        $this->suiteClass = $suiteClass;
        $this->successConfig = [
            'handler' => function () {},
            'type' => AssertionException::class,
        ];
    }

    /**
     * Set the call verifier factory.
     *
     * @param CallVerifierFactory $callVerifierFactory The call verifier factory to use.
     */
    public function setCallVerifierFactory(
        CallVerifierFactory $callVerifierFactory
    ): void {
        $this->callVerifierFactory = $callVerifierFactory;
    }

    /**
     * Record that a successful assertion occurred.
     *
     * @param array<Event> $events The events.
     *
     * @return EventCollection The result.
     */
    public function createSuccess(array $events = []): EventCollection
    {
        $suiteClass = $this->suiteClass;
        $suiteClass::current()->assert($this->successConfig);

        return new EventSequence($events, $this->callVerifierFactory);
    }

    /**
     * Record that a successful assertion occurred.
     *
     * @param EventCollection $events The events.
     *
     * @return EventCollection The result.
     */
    public function createSuccessFromEventCollection(
        EventCollection $events
    ): EventCollection {
        $suiteClass = $this->suiteClass;
        $suiteClass::current()->assert($this->successConfig);

        return $events;
    }

    /**
     * Create a new assertion failure exception.
     *
     * @param string $description The failure description.
     *
     * @return null      If this recorder does not throw exceptions.
     * @throws Throwable If this recorder throws exceptions.
     */
    public function createFailure(string $description)
    {
        $exception = new AssertionException($description);

        $suiteClass = $this->suiteClass;
        $suiteClass::current()->assert([
            'handler' => function () use ($exception) {
                throw $exception;
            },
            'type' => AssertionException::class,
        ]);

        return null;
    }

    /**
     * @var class-string
     */
    private $suiteClass;

    /**
     * @var array<string,mixed>
     */
    private $successConfig;

    /**
     * @var CallVerifierFactory
     */
    private $callVerifierFactory;
}
