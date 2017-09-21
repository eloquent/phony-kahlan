<?php

declare(strict_types=1);

namespace Eloquent\Phony\Kahlan;

use Kahlan\Filter\Filters;
use Kahlan\Suite;

describe('FilterManager', function () {
    beforeEach(function () {
        $this->filterFactory = mock(FilterFactory::class);
        $this->filters = onStatic(mock(Filters::class))->full();
        $this->filters->apply->returns('filter-a');
        $this->subject = new FilterManager($this->filterFactory->get(), $this->filters->className());

        $this->filter = function () {};
        $this->filterFactory->createFilter->returns($this->filter);
    });

    describe('install()', function () {
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

        it('should apply the filter', function () {
            $this->filters->apply->calledWith(Suite::class, 'runBlock', $this->filter);
        });
    });

    describe('uninstall()', function () {
        it('should do nothing when not installed', function () {
            $expected = $this->filters->detach->callCount();
            $this->subject->uninstall();

            expect($this->filters->detach->callCount())->toBe($expected);
        });

        context('when previously installed', function () {
            beforeEach(function () {
                $this->subject->install();
            });

            afterEach(function () {
                $this->subject->uninstall();
            });

            it('should detach the execution filter', function () {
                $this->subject->uninstall();

                $this->filters->detach->calledWith('filter-a');
            });
        });
    });
});
