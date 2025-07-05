--TEST--
Quantity::subtract()
--FILE--
<?php
require_once __DIR__ . '/../include.inc';

use KhaledAlam\Unit\Quantity;
use KhaledAlam\Unit\Unit;
use KhaledAlam\Unit\UnitRegistry;
use KhaledAlam\Unit\Name;
use KhaledAlam\Unit\Dimension;

UnitRegistry::register(new Unit(Name::M->value, Name::M, 1.0, new Dimension(['L' => 1])));
UnitRegistry::register(new Unit(Name::CM->value, Name::CM, 0.01, new Dimension(['L' => 1])));

$q1 = Quantity::from(2, 'm');
$q2 = Quantity::from(50, 'cm');

echo $q1->subtract($q2)->convertTo('m') . "\n";
?>
--EXPECT--
1.5 m
