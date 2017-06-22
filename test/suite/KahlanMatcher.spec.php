<?php

namespace Eloquent\Phony\Kahlan;

use Eloquent\Phony\Exporter\InlineExporter;
use Eloquent\Phony\Invocation\InvocableInspector;
use Eloquent\Phony\Sequencer\Sequencer;
use Kahlan\Arg;

describe('KahlanMatcher', function () {
    beforeEach(function () {
        $this->sequence = Sequencer::sequence(md5(mt_rand()));
        $this->invocableInspector = InvocableInspector::instance();
        $this->exporter = new InlineExporter(1, $this->sequence, $this->invocableInspector);
        $this->describer = new KahlanMatcherDescriber($this->exporter);
    });

    context('with a regular matcher', function () {
        beforeEach(function () {
            $this->subject = new KahlanMatcher(Arg::toBe('value'), $this->describer);
        });

        context('matches()', function () {
            it('should return true for matching values', function () {
                expect($this->subject->matches('value'))->toBe(true);
            });

            it('should return false for mismatched values', function () {
                expect($this->subject->matches('other'))->toBe(false);
            });
        });

        context('describe()', function () {
            it('should describe the underlying matcher', function () {
                expect($this->subject->describe())->toBe('<toBe ("value")>');
            });
        });
    });

    context('with a negated matcher', function () {
        beforeEach(function () {
            $this->subject = new KahlanMatcher(Arg::notToBe('value'), $this->describer);
        });

        context('matches()', function () {
            it('should return true for mismatched values', function () {
                expect($this->subject->matches('other'))->toBe(true);
            });

            it('should return false for matching values', function () {
                expect($this->subject->matches('value'))->toBe(false);
            });
        });

        context('describe()', function () {
            it('should describe the underlying matcher', function () {
                expect($this->subject->describe())->toBe('<notToBe ("value")>');
            });
        });
    });
});
