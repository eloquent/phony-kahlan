<?php

use Eloquent\Phony\Kahlan\Phony;

class PhonyTest extends TestCase
{
    protected function setUp()
    {
        $this->handle = Phony::mock('Eloquent\Phony\Kahlan\Test\TestClassA');
        $this->mock = $this->handle->get();
    }

    public function testShouldRecordPassingMockAssertions()
    {
        $this->mock->testClassAMethodA('aardvark', 'bonobo');

        $this->handle->testClassAMethodA->calledWith('aardvark', 'bonobo');
    }

    public function testShouldRecordFailingMockAssertions()
    {
        $this->mock->testClassAMethodA('aardvark', ['bonobo', 'capybara', 'dugong']);
        $this->mock->testClassAMethodA('armadillo', ['bonobo', 'chameleon', 'dormouse']);

        $this->handle->testClassAMethodA->calledWith('aardvark', ['bonobo', 'chameleon', 'dugong']);
    }
}
