# Phony for Kahlan

[![Current version image][version-image]][current version]
[![Current build status image][build-image]][current build status]
[![Current Windows build status image][windows-build-image]][current windows build status]
[![Current coverage status image][coverage-image]][current coverage status]

[build-image]: https://img.shields.io/travis/eloquent/phony-kahlan/master.svg?style=flat-square "Current build status for the master branch"
[coverage-image]: https://img.shields.io/codecov/c/github/eloquent/phony-kahlan/master.svg?style=flat-square "Current test coverage for the master branch"
[current build status]: https://travis-ci.org/eloquent/phony-kahlan
[current coverage status]: https://codecov.io/github/eloquent/phony-kahlan
[current version]: https://packagist.org/packages/eloquent/phony-kahlan
[current windows build status]: https://ci.appveyor.com/project/eloquent/phony-kahlan
[version-image]: https://img.shields.io/packagist/v/eloquent/phony-kahlan.svg?style=flat-square "This project uses semantic versioning"
[windows-build-image]: https://img.shields.io/appveyor/ci/eloquent/phony-kahlan/master.svg?label=windows&style=flat-square "Current Windows build status for the master branch"

## Installation and documentation

- Available as [Composer] package [eloquent/phony-kahlan].
- Read the [Phony documentation].
- Read the [Kahlan documentation].
- Visit the [main Phony repository].

[composer]: http://getcomposer.org/
[eloquent/phony-kahlan]: https://packagist.org/packages/eloquent/phony-kahlan
[kahlan documentation]: https://kahlan.github.io/docs/
[main phony repository]: https://github.com/eloquent/phony
[phony documentation]: http://eloquent-software.com/phony/latest/

## What is *Phony for Kahlan*?

*Phony for Kahlan* is a plugin for the [Kahlan] testing framework that provides
general integration with the [Phony] mocking framework, as well as optional
auto-wired test dependencies.

In other words, if a [Kahlan] test (or suite) requires a mock object, it can be
defined to have a parameter with an appropriate [type declaration], and it will
automatically receive a mock of that type as an argument when run.

[Stubs] for `callable` types, and "empty" values for other type declarations are
also [supported].

## Plugin installation

Installation is only required when using the [dependency injection] features of
the plugin. The plugin can be installed in the [Kahlan configuration file] like
so:

```php
<?php // kahlan-config.php

// disable monkey-patching for Phony classes
$this->commandLine()->set('exclude', ['Eloquent\Phony']);

// install the plugin once autoloading is available
Kahlan\Filter\Filters::apply($this, 'run', function (callable $chain) {
    Eloquent\Phony\Kahlan\install();

    return $chain();
});
```

## Dependency injection

Once the plugin is installed, any tests or suites that are defined with
parameters will be supplied with matching arguments when run:

```php
describe('Phony for Kahlan', function () {
    it('Auto-wires test dependencies', function (PDO $db) {
        expect($db)->toBeAnInstanceOf(PDO::class);
    });
});
```

### Injected mock objects

*Phony for Kahlan* supports automatic injection of [mock objects]. Because
[Phony] doesn't alter the interface of mocked objects, it is necessary to use
[`on()`] to retrieve the [mock handle] in order to perform [stubbing] and
[verification]:

```php
use function Eloquent\Phony\Kahlan\on;

describe('Phony for Kahlan', function () {
    it('Supports stubbing', function (PDO $db) {
        on($db)->exec->with('DELETE FROM users')->returns(111);

        expect($db->exec('DELETE FROM users'))->toBe(111);
    });

    it('Supports verification', function (PDO $db) {
        $db->exec('DROP TABLE users');

        on($db)->exec->calledWith('DROP TABLE users');
    });
});
```

### Injected stubs

*Phony for Kahlan* supports automatic injection of [stubs] for parameters with
a `callable` type declaration:

```php
describe('Phony for Kahlan', function () {
    it('Supports callable stubs', function (callable $stub) {
        $stub->with('a', 'b')->returns('c');
        $stub('a', 'b');

        $stub->calledWith('a', 'b')->firstCall()->returned('c');
    });
});
```

## Supported types

The following table lists the supported type declarations, and the value
supplied for each:

Parameter type | Supplied value
---------------|---------------
*(none)*       | `null`
`bool`         | `false`
`int`          | `0`
`float`        | `.0`
`string`       | `''`
`array`        | `[]`
`iterable`     | `[]`
`object`       | `(object) []`
`stdClass`     | `(object) []`
`callable`     | [`stub()`]
`Closure`      | `function () {}`
`Generator`    | `(function () {return; yield;})()`

When using a [type declaration] that is not listed above, the supplied value
will be a [mock] of the specified type.

By necessity, the supplied value will not be wrapped in a [mock handle]. In
order to obtain a handle, simply use [`on()`]:

```php
use function Eloquent\Phony\Kahlan\on;

it('Example mock handle retrieval', function (ClassA $mock) {
    $handle = on($mock);
});
```

## License

For the full copyright and license information, please view the [LICENSE file].

<!-- References -->

[`on()`]: http://eloquent-software.com/phony/latest/#facade.on
[`stub()`]: http://eloquent-software.com/phony/latest/#facade.stub
[dependency injection]: #dependency-injection
[kahlan configuration file]: https://kahlan.github.io/docs/config-file.html
[kahlan]: https://kahlan.github.io/docs/
[license file]: LICENSE
[mock handle]: http://eloquent-software.com/phony/latest/#mock-handles
[mock objects]: http://eloquent-software.com/phony/latest/#mocks
[mock]: http://eloquent-software.com/phony/latest/#mocks
[phony]: http://eloquent-software.com/phony/latest/
[stubbing]: http://eloquent-software.com/phony/latest/#stubs
[stubs]: http://eloquent-software.com/phony/latest/#stubs
[supported]: #supported-types
[type declaration]: http://php.net/functions.arguments#functions.arguments.type-declaration
[verification]: http://eloquent-software.com/phony/latest/#verification
