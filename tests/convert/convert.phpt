--TEST--
Quantity::convertTo()
--FILE--
<?php
require_once __DIR__ . '/../include.inc';

use KhaledAlam\Unit\Quantity;
use KhaledAlam\Unit\Unit;
use KhaledAlam\Unit\UnitRegistry;
use KhaledAlam\Unit\Dimension;
use KhaledAlam\Unit\Name;

UnitRegistry::register(new Unit(Name::M->value, Name::M, 1.0, new Dimension(['L' => 1])));
UnitRegistry::register(new Unit(Name::CM->value, Name::CM, 0.01, new Dimension(['L' => 1])));

$q = Quantity::from(2.0, 'm');
echo $q->convertTo('cm') . "\n";
?>
--EXPECT--
200 cm
