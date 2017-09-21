<?php

declare(strict_types=1);

namespace Eloquent\Phony\Kahlan;

use Kahlan\Arg;

describe('ArgumentMatcher', function () {
    context('with a regular matcher', function () {
        beforeEach(function () {
            $this->subject = new ArgumentMatcher(Arg::toBe('value'));
        });

        describe('matches()', function () {
            it('should return true for matching values', function () {
                expect($this->subject->matches('value'))->toBe(true);
            });

            it('should return false for mismatched values', function () {
                expect($this->subject->matches('other'))->toBe(false);
            });
        });

        describe('describe()', function () {
            it('should describe the underlying matcher', function () {
                expect($this->subject->describe())->toBe('<toBe("value")>');
            });
        });

        describe('string representation', function () {
            it('should describe the underlying matcher', function () {
                expect(strval($this->subject))->toBe('<toBe("value")>');
            });
        });
    });

    context('with a negated matcher', function () {
        beforeEach(function () {
            $this->subject = new ArgumentMatcher(Arg::notToBe('value'));
        });

        describe('matches()', function () {
            it('should return true for mismatched values', function () {
                expect($this->subject->matches('other'))->toBe(true);
            });

            it('should return false for matching values', function () {
                expect($this->subject->matches('value'))->toBe(false);
            });
        });

        describe('describe()', function () {
            it('should describe the underlying matcher', function () {
                expect($this->subject->describe())->toBe('<notToBe("value")>');
            });
        });

        describe('string representation', function () {
            it('should describe the underlying matcher', function () {
                expect(strval($this->subject))->toBe('<notToBe("value")>');
            });
        });
    });
});
