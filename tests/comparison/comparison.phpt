--TEST--
Quantity comparison helpers (equals, isGreaterThan, isLessThan)
--FILE--
<?php
require_once __DIR__ . '/../include.inc';

use KhaledAlam\Unit\Quantity;

var_dump(Quantity::of(1, 'm')->equals(Quantity::of(100, 'cm')));
var_dump(Quantity::of(1, 'm')->equals(Quantity::of(101, 'cm')));
var_dump(Quantity::of(1, 'm')->isGreaterThan(Quantity::of(90, 'cm')));
var_dump(Quantity::of(1, 'm')->isLessThan(Quantity::of(200, 'cm')));

try {
    Quantity::of(1, 'm')->isGreaterThan(Quantity::of(1, 's'));
} catch (\InvalidArgumentException $e) {
    echo $e->getMessage() . "\n";
}
?>
--EXPECT--
bool(true)
bool(false)
bool(true)
bool(true)
Cannot compare: units are dimensionally incompatible.
