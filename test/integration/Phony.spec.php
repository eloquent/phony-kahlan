<?php

use Eloquent\Phony\Kahlan\Test\TestClassA;
use Eloquent\Phony\Mock\Mock;
use Eloquent\Phony\Stub\StubVerifier;
use Kahlan\Arg;
use function Eloquent\Phony\Kahlan\on;

describe('Phony', function (DateTime $dateTime) {
    beforeEach(function (TestClassA $mock) {
        $this->mock = $mock;
        $this->handle = on($mock);
    });

    it('should support auto-injected mocks', function (DateTime $dateTime) {
        expect($dateTime)->toBeAnInstanceOf(Mock::class);
    });

    it('should support auto-injected mocks in describe blocks', function () use ($dateTime) {
        expect($dateTime)->toBeAnInstanceOf(Mock::class);
    });

    it('should support auto-injected stubs', function (callable $stub) {
        expect($stub)->toBeAnInstanceOf(StubVerifier::class);
    });

    it('should support auto-injected scalar values', function (string $string) {
        expect($string)->toBe('');
    });

    it('should record passing mock assertions', function () {
        $this->mock->testClassAMethodA('aardvark', 'bonobo');

        $this->handle->testClassAMethodA->calledWith('aardvark', 'bonobo');
    });

    it('should record failing mock assertions', function () {
        $this->mock->testClassAMethodA('aardvark', ['bonobo', 'capybara', 'dugong']);
        $this->mock->testClassAMethodA('armadillo', ['bonobo', 'chameleon', 'dormouse']);

        $this->handle->testClassAMethodA->calledWith('aardvark', ['bonobo', 'chameleon', 'dugong']);
    });

    it('should support argument matcher integrations', function () {
        $this->mock->testClassAMethodA(111);
        $this->mock->testClassAMethodA(222);

        $this->handle->testClassAMethodA->calledWith(Arg::toBeGreaterThan(333));
    });
});
