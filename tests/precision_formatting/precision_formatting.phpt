--TEST--
Quantity: formatting decimal precision
--FILE--
<?php
require_once __DIR__ . '/../include.inc';

use KhaledAlam\Unit\Quantity;
use KhaledAlam\Unit;
use KhaledAlam\Unit\UnitRegistry;
use KhaledAlam\Unit\Dimension;
use KhaledAlam\Unit\Name;

UnitRegistry::register(new Unit(Name::M->value, Name::M, 1.0, new Dimension(['L' => 1])));

$q = Quantity::from(3.14159, 'm', 5);
echo $q . "\n";
?>
--EXPECT--
3.14159 m
