--TEST--
Quantity: zero and negative values
--FILE--
<?php
require_once __DIR__ . '/../include.inc';

use KhaledAlam\Unit\Quantity;
use KhaledAlam\Unit\Unit;
use KhaledAlam\Unit\UnitRegistry;
use KhaledAlam\Unit\Dimension;
use KhaledAlam\Unit\Name;

UnitRegistry::register(new Unit(Name::M->value, Name::M, 1.0, new Dimension(['L' => 1])));

$zero = Quantity::from(0.0, 'm');
$neg = Quantity::from(-5.0, 'm');

echo $zero->add($zero) . "\n";
echo $neg->add($neg) . "\n";
echo $neg->subtract($zero) . "\n";
?>
--EXPECT--
0 m
-10 m
-5 m
