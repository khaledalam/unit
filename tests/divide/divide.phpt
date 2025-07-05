--TEST--
Quantity::divide()
--FILE--
<?php
require_once __DIR__ . '/../include.inc';

use KhaledAlam\Unit\Quantity;
use KhaledAlam\Unit\Unit;
use KhaledAlam\Unit\UnitRegistry;
use KhaledAlam\Unit\Name;
use KhaledAlam\Unit\Dimension;

UnitRegistry::register(new Unit(Name::M->value, Name::M, 1.0, new Dimension(['L' => 1])));
UnitRegistry::register(new Unit(Name::S->value, Name::S, 1.0, new Dimension(['T' => 1])));

$q1 = Quantity::from(10, 'm');
$q2 = Quantity::from(2, 's');

$result = $q1->divide($q2);

echo $result->getValue() . ' ' . $result->getUnit()->symbol . "\n";
?>
--EXPECT--
5 m/s
