<?php

namespace Eloquent\Phony\Kahlan;

describe('ArgumentFactory', function () {
    beforeEach(function () {
        $this->subject = new ArgumentFactory();
    });

    context('argumentsForCallback()', function () {
        it('should should return arguments for each parameter', function () {
            $callback = function (bool $a, int $b, string $c, $d) {};

            expect($this->subject->argumentsForCallback($callback))->toBe([false, 0, '', null]);
        });
    });
});
