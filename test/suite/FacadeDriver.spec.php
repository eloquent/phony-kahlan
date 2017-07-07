<?php

namespace Eloquent\Phony\Kahlan;

use Closure;
use Kahlan\Arg;
use Kahlan\Block\Group;
use Kahlan\Block\Specification;
use Kahlan\Filter\Chain;
use Kahlan\Filter\Filter;
use Kahlan\Suite;

describe('FacadeDriver', function () {
    beforeEach(function () {
        $this->filter = onStatic(mock(Filter::class))->full();
        $this->filter->register->returns('aspect-a');

        $this->subject = new FacadeDriver($this->filter->className());
    });

    context('install()', function () {
        beforeEach(function () {
            $this->subject->install();
        });

        afterEach(function () {
            $this->subject->uninstall();
        });

        it('should do nothing when already installed', function () {
            $expected = $this->filter->register->callCount();
            $this->subject->install();

            expect($this->filter->register->callCount())->toBe($expected);
        });

        it('should register an execution filter', function () {
            $this->filter->register->calledWith('phony.execute', Arg::toBeAnInstanceOf(Closure::class));
        });

        it('should apply the execution filter to groups', function () {
            $this->filter->apply->calledWith(Group::class, 'executeClosure', 'phony.execute');
        });

        it('should apply the execution filter to specifications', function () {
            $this->filter->apply->calledWith(Specification::class, 'executeClosure', 'phony.execute');
        });

        it('should apply the execution filter to suites', function () {
            $this->filter->apply->calledWith(Suite::class, 'executeClosure', 'phony.execute');
        });

        context('execution filter', function () {
            beforeEach(function () {
                $this->filter = $this->filter->register->calledWith('phony.execute', '*')->firstCall()->argument(1);
            });

            it('should execute the closure with arguments that match the parameters', function () {
                $calls = [];
                $closure = function (string $a, int $b) use (&$calls) {
                    $calls[] = func_get_args();
                };
                $chain = mock(Chain::class);
                $chain->params->returns([$closure]);
                $this->filter($chain->get());

                expect($calls)->toBe([['', 0]]);
            });
        });
    });

    context('uninstall()', function () {
        it('should do nothing when not installed', function () {
            $expected = $this->filter->unregister->callCount();
            $this->subject->uninstall();

            expect($this->filter->unregister->callCount())->toBe($expected);
        });

        context('when previously installed', function () {
            beforeEach(function () {
                $this->subject->install();
                $this->subject->uninstall();
            });

            it('should detach the execution filter from groups', function () {
                $this->filter->detach->calledWith(Group::class, 'executeClosure', 'phony.execute');
            });

            it('should detach the execution filter from specifications', function () {
                $this->filter->detach->calledWith(Specification::class, 'executeClosure', 'phony.execute');
            });

            it('should detach the execution filter from suites', function () {
                $this->filter->detach->calledWith(Suite::class, 'executeClosure', 'phony.execute');
            });

            it('should unregister the execution filter', function () {
                $this->filter->unregister->calledWith('aspect-a');
            });
        });
    });
});
