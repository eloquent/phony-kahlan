<?php

namespace Eloquent\Phony\Kahlan;

use Countable;
use Eloquent\Phony\Event\EventSequence;
use Eloquent\Phony\Kahlan\Test\TestClassA;
use Eloquent\Phony\Kahlan\Test\TestClassB;
use Eloquent\Phony\Kahlan\Test\TestEvent;
use Eloquent\Phony\Matcher\AnyMatcher;
use Eloquent\Phony\Matcher\EqualToMatcher;
use Eloquent\Phony\Matcher\WildcardMatcher;
use Eloquent\Phony\Mock\Builder\MockBuilder;
use Eloquent\Phony\Mock\Handle\InstanceHandle;
use Eloquent\Phony\Mock\Handle\StaticHandle;
use Eloquent\Phony\Mock\Mock;
use Eloquent\Phony\Spy\SpyVerifier;
use Eloquent\Phony\Stub\StubVerifier;

describe('Phony', function () {
    afterEach(function () {
        restoreGlobalFunctions();
    });

    context('install()', function () {
        it('should not fail catastrophically', function () {
            expect(function () {
                install();
            })->not->toThrow();
        });

        it('should be able to be run after install()', function () {
            expect(function () {
                install();
                install();
            })->not->toThrow();
        });

        it('should be able to be run after uninstall()', function () {
            expect(function () {
                install();
                uninstall();
                install();
            })->not->toThrow();
        });
    });

    context('uninstall()', function () {
        it('should not fail catastrophically', function () {
            expect(function () {
                install();
                uninstall();
            })->not->toThrow();
        });

        it('should be able to be run after uninstall()', function () {
            expect(function () {
                install();
                uninstall();
                uninstall();
            })->not->toThrow();
        });

        it('should be able to be run before install()', function () {
            expect(function () {
                uninstall();
            })->not->toThrow();
        });
    });

    context('mockBuilder()', function () {
        it('should produce a working mock builder', function () {
            $builder = mockBuilder(TestClassA::class);
            $mock = $builder->get();

            expect($builder)->toBeAnInstanceOf(MockBuilder::class);
            expect($mock)->toBeAnInstanceOf(Mock::class);
            expect($mock)->toBeAnInstanceOf(TestClassA::class);
        });

        it('should produce a working mock builder with all arguments defaulted', function () {
            $builder = mockBuilder();
            $mock = $builder->get();

            expect($builder)->toBeAnInstanceOf(MockBuilder::class);
            expect($mock)->toBeAnInstanceOf(Mock::class);
        });
    });

    context('partialMock()', function () {
        it('should produce a working partial mock', function () {
            $handle = partialMock([TestClassB::class, Countable::class], ['a', 'b']);
            $mock = $handle->get();

            expect($handle)->toBeAnInstanceOf(InstanceHandle::class);
            expect($mock)->toBeAnInstanceOf(Mock::class);
            expect($mock)->toBeAnInstanceOf(TestClassB::class);
            expect($mock)->toBeAnInstanceOf(Countable::class);
            expect($mock->constructorArguments)->toBe(['a', 'b']);
            expect($mock->testClassAMethodA('a', 'b'))->toBe('ab');
        });

        it('should produce a working partial mock with constructor bypassing', function () {
            $handle = partialMock([TestClassB::class, Countable::class], null);

            expect($handle->get()->constructorArguments)->toBe(null);
        });

        it('should produce a working partial mock with defaulted arguments', function () {
            $handle = partialMock([TestClassB::class, Countable::class]);

            expect($handle->get()->constructorArguments)->toBe([]);
        });

        it('should produce a generic partial mock with all arguments defaulted', function () {
            $handle = partialMock();

            expect($handle->get())->toBeAnInstanceOf(Mock::class);
        });
    });

    context('mock()', function () {
        it('should produce a working mock', function () {
            $handle = mock([TestClassB::class, Countable::class]);
            $mock = $handle->get();

            expect($handle)->toBeAnInstanceOf(InstanceHandle::class);
            expect($mock)->toBeAnInstanceOf(Mock::class);
            expect($mock)->toBeAnInstanceOf(TestClassB::class);
            expect($mock)->toBeAnInstanceOf(Countable::class);
            expect($mock->constructorArguments)->toBe(null);
            expect($mock->testClassAMethodA('a', 'b'))->toBe(null);
        });

        it('should produce a generic mock with all arguments defaulted', function () {
            $handle = mock();

            expect($handle->get())->toBeAnInstanceOf(Mock::class);
        });
    });

    context('onStatic()', function () {
        it('should retrieve the static handle for a mock class', function () {
            $class = mockBuilder()->build();
            $handle = onStatic($class);

            expect($handle)->toBeAnInstanceOf(StaticHandle::class);
            expect($handle->clazz())->toBe($class);
        });
    });

    context('on()', function () {
        it('should retrieve the handle for a mock instance', function () {
            $mock = mockBuilder()->get();
            $handle = on($mock);

            expect($handle)->toBeAnInstanceOf(InstanceHandle::class);
            expect($handle->get())->toBe($mock);
        });
    });

    context('spy()', function () {
        it('should produce a working spy', function () {
            $spy = spy(function () {
                return implode(func_get_args());
            });

            expect($spy)->toBeAnInstanceOf(SpyVerifier::class);
            expect($spy('a', 'b'))->toBe('ab');
            expect($spy->calledWith('a', 'b'))->toBeTruthy();
        });
    });

    context('spyGlobal()', function () {
        it('should produce a working global spy', function () {
            $spy = spyGlobal('sprintf', 'Eloquent\Phony\Facade');

            expect($spy)->toBeAnInstanceOf(SpyVerifier::class);
            expect(\Eloquent\Phony\Facade\sprintf('%s, %s', 'a', 'b'))->toBe('a, b');
            expect($spy->calledWith('%s, %s', 'a', 'b'))->toBeTruthy();
        });
    });

    context('stub()', function () {
        it('should produce a working stub', function () {
            $stub = stub(function () {
                return implode(func_get_args());
            })->returns('x');

            expect($stub)->toBeAnInstanceOf(StubVerifier::class);
            expect($stub('a', 'b'))->toBe('x');
            expect($stub->calledWith('a', 'b'))->toBeTruthy();
        });
    });

    context('spyGlobal()', function () {
        it('should produce a working global stub', function () {
            $stub = stubGlobal('sprintf', 'Eloquent\Phony\Facade')->returns('x');

            expect($stub)->toBeAnInstanceOf(StubVerifier::class);
            expect(\Eloquent\Phony\Facade\sprintf('%s, %s', 'a', 'b'))->toBe('x');
            expect($stub->calledWith('%s, %s', 'a', 'b'))->toBeTruthy();
        });
    });

    context('restoreGlobalFunctions()', function () {
        it('should restore global functions that have been stubbed', function () {
            stubGlobal('sprintf', 'Eloquent\Phony\Facade');
            stubGlobal('vsprintf', 'Eloquent\Phony\Facade');

            expect(\Eloquent\Phony\Facade\sprintf('%s, %s', 'a', 'b'))->toBe(null);
            expect(\Eloquent\Phony\Facade\vsprintf('%s, %s', ['a', 'b']))->toBe(null);

            restoreGlobalFunctions();

            expect(\Eloquent\Phony\Facade\sprintf('%s, %s', 'a', 'b'))->toBe('a, b');
            expect(\Eloquent\Phony\Facade\vsprintf('%s, %s', ['a', 'b']))->toBe('a, b');
        });
    });

    context('event order verification', function () {
        beforeEach(function () {
            $this->eventA = new TestEvent(0, 0.0);
            $this->eventB = new TestEvent(1, 1.0);
        });

        context('checkInOrder()', function () {
            it('should return truthy when the events are in order', function () {
                expect(checkInOrder($this->eventA, $this->eventB))->toBeTruthy();
            });

            it('should return falsey when the events are out of order', function () {
                expect(checkInOrder($this->eventB, $this->eventA))->toBeFalsy();
            });
        });

        context('inOrder()', function () {
            it('should return a verification result when the events are in order', function () {
                $result = inOrder($this->eventA, $this->eventB);

                expect($result)->toBeAnInstanceOf(EventSequence::class);
                expect($result->allEvents())->toBe([$this->eventA, $this->eventB]);
            });
        });

        context('checkAnyOrder()', function () {
            it('should return truthy when events are supplied', function () {
                expect(checkAnyOrder($this->eventA, $this->eventB))->toBeTruthy();
            });

            it('should return falsey when no events are supplied', function () {
                expect(checkAnyOrder())->toBeFalsy();
            });
        });

        context('anyOrder()', function () {
            it('should return a verification result when events are supplied', function () {
                $result = anyOrder($this->eventA, $this->eventB);

                expect($result)->toBeAnInstanceOf(EventSequence::class);
                expect($result->allEvents())->toBe([$this->eventA, $this->eventB]);
            });
        });
    });

    context('matchers', function () {
        context('any()', function () {
            it('should return an "any" matcher', function () {
                expect(any())->toBeAnInstanceOf(AnyMatcher::class);
            });
        });

        context('equalTo()', function () {
            it('should return an "equal to" matcher', function () {
                $matcher = equalTo('a');

                expect($matcher)->toBeAnInstanceOf(EqualToMatcher::class);
                expect($matcher->value())->toBe('a');
            });
        });

        context('wildcard()', function () {
            it('should return a "wildcard" matcher', function () {
                $matcher = wildcard('a', 1, 2);
                $innerMatcher = $matcher->matcher();

                expect($matcher)->toBeAnInstanceOf(WildcardMatcher::class);
                expect($innerMatcher)->toBeAnInstanceOf(EqualToMatcher::class);
                expect($innerMatcher->value())->toBe('a');
                expect($matcher->minimumArguments())->toBe(1);
                expect($matcher->maximumArguments())->toBe(2);
            });

            it('should return a generic "wildcard" matcher when all arguments are defaulted', function () {
                $matcher = wildcard();

                expect($matcher)->toBeAnInstanceOf(WildcardMatcher::class);
                expect($matcher->matcher())->toBeAnInstanceOf(AnyMatcher::class);
                expect($matcher->minimumArguments())->toBe(0);
                expect($matcher->maximumArguments())->toBe(null);
            });
        });
    });

    context('setExportDepth()', function () {
        it('should allow the export depth to be set', function () {
            expect(setExportDepth(111))->toBe(1);
            expect(setExportDepth(1))->toBe(111);
        });
    });

    context('setUseColor()', function () {
        it('should allow the color usage flag to be set', function () {
            expect(setUseColor(false))->toBe(null);
            expect(setUseColor(true))->toBe(null);
        });
    });
});
