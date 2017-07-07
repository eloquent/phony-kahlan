<?php

namespace Eloquent\Phony\Kahlan;

use Closure;
use Eloquent\Phony\Kahlan\Test\TestClassA;
use Eloquent\Phony\Mock\Mock;
use Eloquent\Phony\Stub\StubVerifier;
use Generator;
use stdClass;

describe('ArgumentFactory', function () {
    beforeEach(function () {
        $this->subject = new ArgumentFactory();
    });

    context('argumentsForCallback()', function () {
        it('should should return arguments for each parameter', function () {
            $callback = function (string $a, int $b) {};

            expect($this->subject->argumentsForCallback($callback))->toBe(['', 0]);
        });

        it('should favour null where the parameter accepts null', function () {
            $callback = function (int $a = null) {};

            expect($this->subject->argumentsForCallback($callback))->toBe([null]);
        });

        it('should support boolean parameters', function () {
            $callback = function (bool $a) {};

            expect($this->subject->argumentsForCallback($callback))->toBe([false]);
        });

        it('should support integer parameters', function () {
            $callback = function (int $a) {};

            expect($this->subject->argumentsForCallback($callback))->toBe([0]);
        });

        it('should support floating-point parameters', function () {
            $callback = function (float $a) {};

            expect($this->subject->argumentsForCallback($callback))->toBe([.0]);
        });

        it('should support string parameters', function () {
            $callback = function (string $a) {};

            expect($this->subject->argumentsForCallback($callback))->toBe(['']);
        });

        it('should support array parameters', function () {
            $callback = function (array $a) {};

            expect($this->subject->argumentsForCallback($callback))->toBe([[]]);
        });

        it('should support stdClass parameters', function () {
            $callback = function (stdClass $a) {};

            expect($this->subject->argumentsForCallback($callback))->toEqual([(object) []]);
        });

        it('should support callable parameters', function () {
            $callback = function (callable $a) {};
            $actual = $this->subject->argumentsForCallback($callback);

            expect($actual)->toHaveLength(1);
            expect($actual[0])->toBeAnInstanceOf(StubVerifier::class);
        });

        it('should support closure parameters', function () {
            $callback = function (Closure $a) {};
            $actual = $this->subject->argumentsForCallback($callback);

            expect($actual)->toHaveLength(1);
            expect($actual[0])->toBeAnInstanceOf(Closure::class);
        });

        it('should support generator parameters', function () {
            $callback = function (Generator $a) {};
            $actual = $this->subject->argumentsForCallback($callback);

            expect($actual)->toHaveLength(1);
            expect($actual[0])->toBeAnInstanceOf(Generator::class);
            expect(iterator_to_array($actual[0]))->toBe([]);
        });

        it('should support object parameters', function () {
            $callback = function (TestClassA $a) {};
            $actual = $this->subject->argumentsForCallback($callback);

            expect($actual)->toHaveLength(1);
            expect($actual[0])->toBeAnInstanceOf(TestClassA::class);
            expect($actual[0])->toBeAnInstanceOf(Mock::class);
        });
    });
});
