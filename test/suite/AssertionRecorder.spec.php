<?php

namespace Eloquent\Phony\Kahlan;

use Closure;
use Eloquent\Phony\Assertion\Exception\AssertionException;
use Eloquent\Phony\Call\CallVerifierFactory;
use Eloquent\Phony\Event\EventSequence;
use Eloquent\Phony\Kahlan\Test\TestEvent;
use Kahlan\Arg;
use Kahlan\Scope;
use Kahlan\Suite;

describe('AssertionRecorder', function () {
    beforeEach(function () {
        $this->scope = mock(Scope::class);
        $this->suite = onStatic(mock(Suite::class))->full();
        $this->suite->current->returns($this->scope->get());
        $this->callVerifierFactory = CallVerifierFactory::instance();

        $this->subject = new AssertionRecorder($this->suite->className());
        $this->subject->setCallVerifierFactory($this->callVerifierFactory);

        $this->eventA = new TestEvent(0, 0.0);
        $this->eventB = new TestEvent(1, 1.0);
    });

    context('createSuccess()', function () {
        beforeEach(function () {
            $this->result = $this->subject->createSuccess([$this->eventA, $this->eventB]);
        });

        it('should create a verification result', function () {
            expect($this->result)->toBeAnInstanceOf(EventSequence::class);
        });

        it('should have recorded the verification with Kahlan', function () {
            $this->scope->expectExternal->calledWith(['type' => AssertionException::class]);
        });
    });

    context('createSuccessFromEventCollection()', function () {
        beforeEach(function () {
            $this->result = $this->subject->createSuccessFromEventCollection(
                new EventSequence([$this->eventA, $this->eventB], $this->callVerifierFactory)
            );
        });

        it('should create a verification result', function () {
            expect($this->result)->toBeAnInstanceOf(EventSequence::class);
        });

        it('should have recorded the verification with Kahlan', function () {
            $this->scope->expectExternal->calledWith(['type' => AssertionException::class]);
        });
    });

    context('createFailure()', function () {
        beforeEach(function () {
            $this->result = $this->subject->createFailure('You done goofed.');
        });

        it('should have recorded the verification with Kahlan', function () {
            $config = $this->scope->expectExternal->calledWith(Arg::toBeAn('array'))->firstCall()->argument();

            expect($config['type'])->toBe(AssertionException::class);
            expect($config['callback'])->toBeAnInstanceOf(Closure::class);
        });

        context('expectation callback', function () {
            beforeEach(function () {
                $config = $this->scope->expectExternal->calledWith(Arg::toBeAn('array'))->firstCall()->argument();
                $this->callback = $config['callback'];
            });

            it('should throw an assertion exception', function () {
                expect($this->callback)->toThrow(new AssertionException('You done goofed.'));
            });
        });
    });
});
