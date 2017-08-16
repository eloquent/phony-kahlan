<?php

namespace Eloquent\Phony\Kahlan;

use Closure;
use Kahlan\Arg;
use Kahlan\Filter\Filters;
use Kahlan\Suite;

describe('FacadeDriver', function () {
    beforeEach(function () {
        $this->filters = onStatic(mock(Filters::class))->full();
        $this->filters->apply->returns('filter-a');

        $this->subject = new FacadeDriver($this->filters->className());
    });

    context('install()', function () {
        beforeEach(function () {
            $this->subject->install();
        });

        afterEach(function () {
            $this->subject->uninstall();
        });

        it('should do nothing when already installed', function () {
            $expected = $this->filters->apply->callCount();
            $this->subject->install();

            expect($this->filters->apply->callCount())->toBe($expected);
        });

        it('should apply the execution filter', function () {
            $this->filters->apply->calledWith(Suite::class, 'runBlock', Arg::toBeAnInstanceOf(Closure::class));
        });

        context('execution filter', function () {
            beforeEach(function () {
                $this->filterClosure = $this->filters->apply->calledWith(Suite::class, 'runBlock', '*')
                    ->firstCall()->argument(2);
            });

            it('should execute the closure with arguments that match the parameters', function () {
                $calls = [];
                $closure = function (string $a, int $b) use (&$calls) {
                    $calls[] = func_get_args();
                };
                $this->filterClosure(null, null, $closure);

                expect($calls)->toBe([['', 0]]);
            });
        });
    });

    context('uninstall()', function () {
        it('should do nothing when not installed', function () {
            $expected = $this->filters->detach->callCount();
            $this->subject->uninstall();

            expect($this->filters->detach->callCount())->toBe($expected);
        });

        context('when previously installed', function () {
            beforeEach(function () {
                $this->subject->install();
                $this->subject->uninstall();
            });

            it('should detach the execution filter', function () {
                $this->filters->detach->calledWith('filter-a');
            });
        });
    });
});
