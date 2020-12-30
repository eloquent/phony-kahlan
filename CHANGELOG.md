# Phony for Kahlan changelog

## 4.0.0 (2020-12-30)

This release uses *Phony* `5.x` and *Kahlan* `5.x`. There no BC breaking API
changes.

- **[BC BREAK]** PHP 7.2 is no longer supported.

## 3.0.0 (2020-01-06)

This release uses *Phony* `4.x`. There no BC breaking API changes aside from
stricter type declarations.

- **[BC BREAK]** PHP 7.1 is no longer supported.

## 2.0.0 (2018-06-08)

This release uses *Phony* `3.x` under the hood. Check out the
[migration guide][migration-3] for *Phony* `3.x`, which also applies to this
release.

- **[BC BREAK]** PHP 7.0 is no longer supported.

[migration-3]: https://github.com/eloquent/phony/blob/master/MIGRATING.md#migrating-from-2x-to-3x

## 1.0.1 (2017-10-17)

- **[FIXED]** Updated Kahlan configuration examples to work with Kahlan lazy
  autoloading ([#1]).

[#1]: https://github.com/eloquent/phony-kahlan/issues/1

## 1.0.0 (2017-10-05)

- **[IMPROVED]** Updated to use the `4.x` stable version of Kahlan.

## 0.3.0 (2017-09-29)

This release uses *Phony* `2.x` under the hood. Check out the
[migration guide][migration-2] for *Phony* `2.x`, which also applies to this
release.

- **[BC BREAK]** HHVM is no longer supported ([#216], [#219]).
- **[BC BREAK]** Removed `inOrderSequence`, `checkInOrderSequence`,
  `anyOrderSequence`, and `checkAnyOrderSequence` from the facade ([#215]).
- **[BC BREAK]** Stubs created outside of a mock now have their "self" value set
  to the stub itself, instead of the stubbed callback ([#226]).
- **[NEW]** Implemented `anInstanceOf()` ([#220]).
- **[NEW]** Implemented `emptyValue()` ([#218]).
- **[IMPROVED]** Support for PHP 7.2 features, including the `object` typehint
  ([#224]).
- **[IMPROVED]** Improved the error message produced when a default return value
  cannot be produced, because the return type is a final class ([#228]).
- **[IMPROVED]** Support for the PHP 7.1 `iterable` typehint in automatically
  injected suites and tests.
- **[IMPROVED]** Reduced the amount of output generated when mocks, stubs, and
  spies are encountered by `var_dump()` ([#223]).

[migration-2]: https://github.com/eloquent/phony/blob/2.0.0/MIGRATING.md#migrating-from-1x-to-2x
[#215]: https://github.com/eloquent/phony/issues/215
[#216]: https://github.com/eloquent/phony/issues/216
[#218]: https://github.com/eloquent/phony/issues/218
[#219]: https://github.com/eloquent/phony/issues/219
[#220]: https://github.com/eloquent/phony/issues/220
[#223]: https://github.com/eloquent/phony/issues/223
[#224]: https://github.com/eloquent/phony/issues/224
[#226]: https://github.com/eloquent/phony/issues/226
[#228]: https://github.com/eloquent/phony/issues/228

## 0.2.0 (2017-08-17)

- **[NEW]** Support for auto-wired test dependencies.

## 0.1.0 (2017-07-13)

- **[NEW]** Initial release.
