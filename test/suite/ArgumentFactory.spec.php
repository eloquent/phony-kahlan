<?php

namespace Eloquent\Phony\Kahlan;

use Closure;
use Eloquent\Phony\Kahlan\Test\TestClassA;
use Eloquent\Phony\Mock\Mock;
use Eloquent\Phony\Stub\StubVerifier;
use Generator;
use ReflectionException;
use ReflectionFunction;
use stdClass;

try {
    $function = new ReflectionFunction(function (iterable $a) {});
    $parameters = $function->getParameters();
    $isIterableTypeSupported = null === $parameters[0]->getClass();
} catch (ReflectionException $e) {
    $isIterableTypeSupported = false;
}

describe('ArgumentFactory', function () use ($isIterableTypeSupported) {
    beforeEach(function () {
        $this->subject = new ArgumentFactory();
    });

    context('argumentsForCallback()', function () use ($isIterableTypeSupported) {
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

        it('should support iterable parameters', function () use ($isIterableTypeSupported) {
            skipIf(!$isIterableTypeSupported);

            $callback = function (iterable $a) {};

            expect($this->subject->argumentsForCallback($callback))->toBe([[]]);
        });

        it('should support object parameters', function () {
            skipIf(version_compare(PHP_VERSION, '7.2.x', '<'));

            $callback = function (object $a) {};

            expect($this->subject->argumentsForCallback($callback))->toEqual([(object) []]);
        });

        it('should support object parameters before PHP 7.2', function () {
            skipIf(version_compare(PHP_VERSION, '7.2.x', '>='));

            $callback = eval('return function (object $a) {};');

            $actual = $this->subject->argumentsForCallback($callback);
            expect($actual[0])->toBeAnInstanceOf('object');
            expect($actual[0])->toBeAnInstanceOf(Mock::class);
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

        it('should support generic object parameters', function () {
            $callback = function (TestClassA $a) {};
            $actual = $this->subject->argumentsForCallback($callback);

            expect($actual)->toHaveLength(1);
            expect($actual[0])->toBeAnInstanceOf(TestClassA::class);
            expect($actual[0])->toBeAnInstanceOf(Mock::class);
        });
    });
});
