<?php

declare(strict_types=1);

namespace Eloquent\Phony\Kahlan;

describe('initialize', function () {
    beforeEach(function () {
        $this->previousContainer = Globals::$container;
    });

    afterEach(function () {
        Globals::$container = $this->previousContainer;
    });

    it('should create the container', function () {
        require __DIR__ . '/../../src/initialize.php';

        expect(Globals::$container)->toBeAnInstanceOf(FacadeContainer::class);
        expect(Globals::$container)->not->toBe($this->previousContainer);
    });
});
