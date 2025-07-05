--TEST--
Quantity::__toString() formatting
--FILE--
<?php
require_once __DIR__ . '/../include.inc';

use KhaledAlam\Unit\Quantity;
use KhaledAlam\Unit;
use KhaledAlam\Unit\UnitRegistry;
use KhaledAlam\Unit\Name;
use KhaledAlam\Unit\Dimension;

UnitRegistry::register(new Unit(Name::CM->value, Name::CM, 0.01, new Dimension(['L' => 1])));

$q = Quantity::from(100.0, 'cm');
echo $q . "\n";
?>
--EXPECT--
100 cm
