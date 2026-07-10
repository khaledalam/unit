--TEST--
Common units are auto-registered by the bootstrap file
--FILE--
<?php
require_once __DIR__ . '/../include.inc';

use KhaledAlam\Unit\Quantity;
use KhaledAlam\Unit\UnitRegistry;

// No manual registration: bootstrap.php ran via composer autoload.files.
var_dump(UnitRegistry::has('kg'));
var_dump(UnitRegistry::has('km'));

echo Quantity::from(2.0, 'm')->add(Quantity::from(100.0, 'cm'))->convertTo('m') . "\n";
echo Quantity::from(1.0, 'kg')->convertTo('g') . "\n";
echo Quantity::from(1.0, 'h')->convertTo('s') . "\n";
?>
--EXPECT--
bool(true)
bool(true)
3 m
1000 g
3600 s
