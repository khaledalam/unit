--TEST--
Quantity: derived unit multiplication/division
--FILE--
<?php
require_once __DIR__ . '/../include.inc';

use KhaledAlam\Unit\Quantity;
use KhaledAlam\Unit\Unit;
use KhaledAlam\Unit\UnitRegistry;
use KhaledAlam\Unit\Dimension;
use KhaledAlam\Unit\Name;

UnitRegistry::register(new Unit(Name::M->value, Name::M, 1.0, new Dimension(['L' => 1])));
UnitRegistry::register(new Unit(Name::S->value, Name::S, 1.0, new Dimension(['T' => 1])));

$d = Quantity::from(10.0, 'm');
$t = Quantity::from(2.0, 's');
$v = $d->divide($t);
echo $v . "\n";
?>
--EXPECT--
5 m/s
