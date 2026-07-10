# Contributing to Unit

Thanks for taking the time to contribute! 🎉

## Getting started

```bash
git clone https://github.com/khaledalam/unit.git
cd unit
composer install
```

## Development workflow

Run the full quality suite before opening a pull request:

```bash
composer test      # PHPUnit test suite
composer analyse   # PHPStan (level max)
composer cs        # PHP-CS-Fixer (dry run)
composer cs-fix    # PHP-CS-Fixer (apply fixes)
```

All three must pass — CI enforces the same checks.

## Adding a unit

1. Add the case to the `Name` enum in `src/Unit/Name.php` and its label in `label()`.
2. Register it (factor, dimension, and offset if it is an affine scale) in `src/Unit/bootstrap.php`.
3. Add a `.phpt` test under `tests/` covering a conversion round-trip.

## Pull requests

- Keep changes focused; one logical change per PR.
- Add or update tests for any behavior change.
- Update `README.md` and `CHANGELOG.md` when user-facing behavior changes.
- Write a clear description of **what** changed and **why**.

## Reporting bugs

Open an issue using the bug report template and include a minimal reproduction.

By contributing, you agree that your contributions are licensed under the MIT License.
