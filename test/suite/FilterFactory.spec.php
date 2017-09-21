<?php

declare(strict_types=1);

namespace Eloquent\Phony\Kahlan;

use Closure;

describe('FilterFactory', function () {
    beforeEach(function () {
        $this->subject = new FilterFactory(new ArgumentFactory());
    });

    describe('createFilter()', function () {
        it('should return a bindable filter closure', function () {
            expect($this->subject->createFilter())->toBeAnInstanceOf(Closure::class);
        });

        describe('filter closure', function () {
            it('should call the supplied block closure with appropriate arguments', function () {
                $filter = $this->subject->createFilter();

                expect($filter)->toBeAnInstanceOf(Closure::class);

                $arguments = null;
                $filter(null, null, function (bool $a, int $b, string $c, $d) use (&$arguments) {
                    $arguments = [$a, $b, $c, $d];
                });

                expect($arguments)->toBe([false, 0, '', null]);
            });
        });
    });
});
