# Unit

[![Latest Stable Version](https://poser.pugx.org/khaledalam/unit/v)](https://packagist.org/packages/khaledalam/unit)
[![Total Downloads](https://poser.pugx.org/khaledalam/unit/downloads)](https://packagist.org/packages/khaledalam/unit)
[![Push](https://github.com/KhaledAlam/Unit/actions/workflows/push.yml/badge.svg)](https://github.com/KhaledAlam/Unit/actions/workflows/push.yml)
[![codecov](https://codecov.io/gh/KhaledAlam/Unit/graph/badge.svg?token=4MIM2LRPRD)](https://codecov.io/gh/KhaledAlam/Unit)
[![PHP Version](https://poser.pugx.org/khaledalam/unit/require/php)](https://packagist.org/packages/khaledalam/unit)
[![License](https://poser.pugx.org/khaledalam/unit/license)](https://packagist.org/packages/khaledalam/unit)

### Type-safe units, quantities & dimensional analysis for PHP

A lightweight, **immutable**, type-safe PHP library for working with **quantities**, **units**, and **dimensional analysis**. Define units, convert across compatible ones, and do arithmetic that refuses to add meters to seconds.

```php
use KhaledAlam\Unit\Quantity;

echo Quantity::of(2, 'm')->add(Quantity::of(100, 'cm'))->to('m'); // "3 m"
echo Quantity::of(100, '°C')->to('°F')->format(1);                // "212.0 °F"
echo Quantity::of(4, 'm')->multiply(Quantity::of(3, 'm'));        // "12 m²"
```

No setup, no registration — common units are ready the moment you install.

**▶️ [Try the live demo](https://khaledalam.net/unit/)** — an interactive converter running in your browser.

---

## Why Unit?

| | **Unit** | Hand-rolled `* factor` | Raw floats |
| --- | :---: | :---: | :---: |
| Blocks nonsensical math (`m + s`) | ✅ | ❌ | ❌ |
| Auto-converts compatible units | ✅ | ❌ | ❌ |
| Affine temperature scales (°C/°F/K) | ✅ | ⚠️ easy to get wrong | ❌ |
| Derived units (`m/s`, `m²`) | ✅ | ❌ | ❌ |
| Immutable value objects | ✅ | — | ❌ |
| Zero dependencies | ✅ | ✅ | ✅ |

If you've ever shipped a bug because someone stored centimeters in a "meters" column, this library is for you.

---

## Installation

```bash
composer require khaledalam/unit
```

Requires PHP 8.2+.

---

## Quick start

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use KhaledAlam\Unit\Quantity;

// Common units are auto-registered — just use them.
$length1 = Quantity::of(2.0, 'm');
$length2 = Quantity::of(100.0, 'cm');

$sum = $length1->add($length2); // auto-converts cm -> m
echo $sum->to('m');             // "3 m"
```

---

## Features

- ✅ Immutable value objects
- ✅ Dimensionally-aware arithmetic (`add`, `subtract`, `multiply`, `divide`)
- ✅ Automatic conversion between compatible units (e.g. cm → m)
- ✅ **Correct** affine temperature conversion (°C ↔ °F ↔ K)
- ✅ Derived/compound units rendered as `m/s`, `m²`, `m·s`
- ✅ Comparisons (`equals`, `isGreaterThan`, `isLessThan`)
- ✅ `JsonSerializable` output
- ✅ Enum-powered unit naming and a custom unit registry
- ✅ Zero runtime dependencies

---

## Usage

### Conversion

```php
echo Quantity::of(2, 'm')->to('cm');   // "200 cm"
echo Quantity::of(5, 'km')->to('m');   // "5000 m"
echo Quantity::of(1, 'h')->to('s');    // "3600 s"
```

### Arithmetic

```php
$speed = Quantity::of(10, 'm')->divide(Quantity::of(2, 's')); // "5 m/s"
$area  = Quantity::of(2, 'm')->multiply(Quantity::of(3, 'm')); // "6 m²"
```

All operations return **new** `Quantity` objects with the proper dimension and unit.

### Temperature (affine scales)

```php
echo Quantity::of(100, '°C')->to('°F')->format(1); // "212.0 °F"
echo Quantity::of(32, '°F')->to('°C')->format(1);  // "0.0 °C"
echo Quantity::of(25, '°C')->to('K')->format(2);   // "298.15 K"
```

### Comparison

```php
Quantity::of(1, 'm')->isGreaterThan(Quantity::of(90, 'cm')); // true
Quantity::of(1, 'm')->equals(Quantity::of(100, 'cm'));       // true
```

### Precision & formatting

```php
echo Quantity::of(1, 'm')->divide(Quantity::of(3, 's'))->format(2); // "0.33 m/s"
```

### JSON

```php
echo json_encode(Quantity::of(2, 'm')); // {"value":2,"unit":"m"}
```

### Custom units

Register your own units against a dimension:

```php
use KhaledAlam\Unit\{Unit, Name, Dimension, UnitRegistry};

UnitRegistry::register(new Unit('yard', 'yd', 0.9144, new Dimension(['L' => 1])));

echo Quantity::of(1, 'yd')->to('m'); // "0.9144 m"
```

### Incompatible operations throw

```php
Quantity::of(5, 'kg')->add(Quantity::of(3, 's')); // InvalidArgumentException
```

---

## Supported units

| Dimension | Units |
| --- | --- |
| Length | `mm`, `cm`, `m`, `km`, `in`, `ft` |
| Mass | `mg`, `g`, `kg` |
| Time | `s`, `min`, `h` |
| Area | `cm²`, `m²` |
| Volume | `mL`, `L`, `m³` |
| Temperature | `°C`, `°F`, `K` |

Need more? [Open an issue](https://github.com/khaledalam/unit/issues) or register your own.

---

## Examples

Runnable scripts live in [`examples/`](examples):

```bash
php examples/basic.php
php examples/temperature.php
php examples/shipping.php
php examples/physics.php
```

---

## Testing & quality

```bash
composer test      # PHPUnit
composer analyse   # PHPStan (level max)
composer cs        # PHP-CS-Fixer (dry run)
```

Tests use the `.phpt` format and run through PHPUnit across PHP 8.2, 8.3, and 8.4 in CI.

---

## Contributing

Contributions are welcome! Please read [CONTRIBUTING.md](CONTRIBUTING.md) and the
[Code of Conduct](CODE_OF_CONDUCT.md). Adding a unit is usually a three-line change.

---

## License

MIT © [Khaled Alam](https://khaledalam.net/)
