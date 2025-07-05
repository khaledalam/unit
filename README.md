# Unit

[![Latest Stable Version](https://poser.pugx.org/khaledalam/unit/v)](https://packagist.org/packages/KhaledAlam/Unit)
[![Push](https://github.com/KhaledAlam/Unit/actions/workflows/push.yml/badge.svg)](https://github.com/KhaledAlam/Unit/actions/workflows/push.yml)
[![codecov](https://codecov.io/gh/KhaledAlam/Unit/graph/badge.svg?token=4MIM2LRPRD)](https://codecov.io/gh/KhaledAlam/Unit)
[![License](https://poser.pugx.org/khaledalam/unit/license)](https://packagist.org/packages/khaledalam/unit)

### PHP Units & Dimensions Library

A lightweight, type-safe PHP library for working with **quantities**, **units**, and **dimensional analysis**. Inspired by scientific computing needs, this library lets you define units, register them globally, perform arithmetic with dimension checking, and convert across compatible units.

---

## Features

- [x] Immutable objects
- [x] Dimensionally-aware arithmetic (`add`, `subtract`, `multiply`, `divide`)
- [x] Automatic conversion between compatible units (e.g., cm to m)
- [x] Support for compound units (e.g., m/s, kg⋅m²/s²)
- [x] Enum-powered unit naming (`Name` enum)
- [x] Custom unit registry

---

## Installation

```bash
composer require khaledalam/unit
```

---

## Basic Usage

```php
<?php

// __construct(string $name, Name|string $symbol, float $factor, Dimension $dimension)

use KhaledAlam\Unit\Unit;
use KhaledAlam\Unit\Name;
use KhaledAlam\Unit\Dimension;
use KhaledAlam\Unit\Quantity;
use KhaledAlam\Unit\UnitRegistry;

// Register base units
UnitRegistry::register(new Unit(Name::M->value, Name::M, 1.0, new Dimension(['L' => 1])));

UnitRegistry::register(new Unit(Name::CM->value, Name::CM, 0.01, new Dimension(['L' => 1])));

// Create quantities
$length1 = Quantity::from(2.0, 'm');
$length2 = Quantity::from(100.0, 'cm');

// Add quantities (auto conversion)
$sum = $length1->add($length2); // Result: 3.0 m

echo $sum; // "3 m"

?>
```

---

## Arithmetic Support

```php
$velocity = Quantity::from(10, 'm')->divide(Quantity::from(2, 's'));  // 5 m/s
$area = Quantity::from(2, 'm')->multiply(Quantity::from(3, 'm'));     // 6 m²
```

All operations return new `Quantity` objects with proper dimensions and units.

---

## Unit Registration

Define and register your own units:

```php
UnitRegistry::register(new Unit('inch', Name::INCH, 0.0254, new Dimension(['L' => 1])));
```

---

## Exception Handling

Operations on incompatible dimensions will throw an exception:

```php
$mass = Quantity::from(5, 'kg');
$time = Quantity::from(3, 's');

$mass->add($time); // InvalidArgumentException
```

---

## Running Tests

This project uses PHP-internal's built-in `run-tests.php` format.

```bash
php run-tests.php tests/ --show-diff
```

Or 

```bash
./vendor/bin/phpunit \
    --configuration phpunit.xml.dist \
    --testsuite=unit
```

Each test follows `.phpt` format and validates expected behavior.

---

## Project Structure

```
src/
  └── Unit/
       ├── Quantity.php
       ├── Unit.php
       ├── Dimension.php
       ├── UnitRegistry.php
       └── Name.php (enum)

tests/
  ├── add/
  ├── convert/
  ├── divide/
  └── ...
```

---

## About

Built by **[Khaled Alam](https://khaledalam.net/)** to bring better scientific and data modeling features to PHP developers.

