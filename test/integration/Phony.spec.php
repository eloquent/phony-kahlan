<?php

use Kahlan\Arg;
use function Eloquent\Phony\Kahlan\mock;

describe('Phony', function () {
    beforeEach(function () {
        $this->handle = mock('Eloquent\Phony\Kahlan\Test\TestClassA');
        $this->mock = $this->handle->get();
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
