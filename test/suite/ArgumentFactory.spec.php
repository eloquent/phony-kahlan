<?php

declare(strict_types=1);

namespace Eloquent\Phony\Kahlan;

describe('ArgumentFactory', function () {
    beforeEach(function () {
        $this->subject = new ArgumentFactory();
    });

    describe('argumentsForCallback()', function () {
        it('should return arguments for each parameter', function () {
            $callback = function (bool $a, int $b, string $c, $d) {};

            expect($this->subject->argumentsForCallback($callback))->toBe([false, 0, '', null]);
        });
    });
});
