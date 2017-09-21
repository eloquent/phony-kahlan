<?php

declare(strict_types=1);

namespace Eloquent\Phony\Kahlan;

describe('FacadeContainer', function () {
    it('should define the expected services', function () {
        $subject = new FacadeContainer();

        expect($subject->filterManager)->not->toBe(null);
        expect($subject->mockBuilderFactory)->not->toBe(null);
        expect($subject->handleFactory)->not->toBe(null);
        expect($subject->spyVerifierFactory)->not->toBe(null);
        expect($subject->stubVerifierFactory)->not->toBe(null);
        expect($subject->functionHookManager)->not->toBe(null);
        expect($subject->eventOrderVerifier)->not->toBe(null);
        expect($subject->matcherFactory)->not->toBe(null);
        expect($subject->exporter)->not->toBe(null);
        expect($subject->assertionRenderer)->not->toBe(null);
        expect($subject->differenceEngine)->not->toBe(null);
        expect($subject->emptyValueFactory)->not->toBe(null);
        expect($subject->sequences)->not->toBe(null);
    });
});
