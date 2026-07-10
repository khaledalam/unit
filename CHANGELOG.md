# Changelog

All notable changes to this project are documented here. The format is based on
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project adheres
to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Automatic registration of all common units (length, mass, time, area, volume,
  temperature) via `src/Unit/bootstrap.php` — units work immediately after
  `composer require`, with no manual `UnitRegistry::register()` calls.
- Affine temperature conversions (`°C`, `°F`, `K`) using a per-unit `offset`.
- Fluent aliases `Quantity::of()` and `Quantity::to()`.
- Comparison helpers: `equals()`, `isGreaterThan()`, `isLessThan()`.
- `Quantity` now implements `JsonSerializable`; added `format()` and `withPrecision()`.
- `UnitRegistry::has()`, `all()`, and `clear()` helpers.
- `Dimension::isDimensionless()`; zero exponents are now dropped so cancelled
  dimensions compare equal.
- PHPStan (level max), PHP-CS-Fixer, PHP 8.3 to the CI matrix, and Dependabot.
- Community health files, issue/PR templates, and an `examples/` directory.

### Changed
- Compound unit symbols now render as `m²` and `m·s` instead of `m*m` / `m*s`.

### Fixed
- Removed the broken, never-loaded `UnitBootstrap.php` that passed an enum where a
  string was expected.
- `Unit::__toString()` no longer errors for derived (string-symbol) units.
- `divide()` now throws on division by a zero quantity.

## [0.1.0]

- Initial release: immutable quantities, dimensional arithmetic, conversions,
  and a custom unit registry.
