<?php

declare(strict_types=1);

namespace Eloquent\Phony\Kahlan;

use Kahlan\Arg;
use function Eloquent\Phony\stub;

describe('ArgumentMatcherDriver', function () {
    beforeEach(function () {
        $this->classExists = stub();
        $this->subject = new ArgumentMatcherDriver($this->classExists);
    });

    describe('isAvailable()', function () {
        it('should return true if Kahlan\Arg exists', function () {
            $this->classExists->with(Arg::class)->returns(true);

            expect($this->subject->isAvailable())->toBe(true);
        });

        it('should return false if Kahlan\Arg does not exist', function () {
            $this->classExists->with(Arg::class)->returns(false);

            expect($this->subject->isAvailable())->toBe(false);
        });
    });

    describe('matcherClassNames()', function () {
        it('should return only Kahlan\Arg', function () {
            expect($this->subject->matcherClassNames())->toBe([Arg::class]);
        });
    });

    describe('wrapMatcher()', function () {
        it('should wrap the supplied matcher', function () {
            expect($this->subject->wrapMatcher(Arg::toBe('a')))->toBeAnInstanceOf(ArgumentMatcher::class);
        });
    });
});
