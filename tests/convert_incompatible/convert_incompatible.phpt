--TEST--
Quantity::convertTo() throws on incompatible units
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

$q = Quantity::from(10, 'm');

try {
    $q->convertTo('s');
} catch (\InvalidArgumentException $e) {
    echo "Caught: " . $e->getMessage() . "\n";
}
?>
--EXPECT--
Caught: Cannot convert: units are dimensionally incompatible.
