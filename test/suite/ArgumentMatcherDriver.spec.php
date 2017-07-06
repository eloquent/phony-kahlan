<?php

namespace Eloquent\Phony\Kahlan;

use Eloquent\Phony\Exporter\InlineExporter;
use Eloquent\Phony\Invocation\InvocableInspector;
use Eloquent\Phony\Sequencer\Sequencer;
use Kahlan\Arg;
use function Eloquent\Phony\restoreGlobalFunctions;
use function Eloquent\Phony\stubGlobal;

describe('ArgumentMatcherDriver', function () {
    beforeEach(function () {
        $this->sequence = Sequencer::sequence(md5(mt_rand()));
        $this->invocableInspector = InvocableInspector::instance();
        $this->exporter = new InlineExporter(1, $this->sequence, $this->invocableInspector);

        $this->subject = new ArgumentMatcherDriver();
    });

    afterEach(function () {
        restoreGlobalFunctions();
    });

    context('isAvailable()', function () {
        it('should return true if Kahlan\Arg exists', function () {
            $classExists = stubGlobal('class_exists', __NAMESPACE__)->with('Kahlan\Arg')->returns(true);

            expect($this->subject->isAvailable())->toBe(true);
        });

        it('should return false if Kahlan\Arg does not exist', function () {
            $classExists = stubGlobal('class_exists', __NAMESPACE__)->with('Kahlan\Arg')->returns(false);

            expect($this->subject->isAvailable())->toBe(false);
        });
    });

    context('matcherClassNames()', function () {
        it('should return only Kahlan\Arg', function () {
            expect($this->subject->matcherClassNames())->toBe(['Kahlan\Arg']);
        });
    });

    context('wrapMatcher()', function () {
        it('should wrap the supplied matcher', function () {
            expect($this->subject->wrapMatcher(Arg::toBe('a')))->toBeAnInstanceOf(ArgumentMatcher::class);
        });
    });
});
