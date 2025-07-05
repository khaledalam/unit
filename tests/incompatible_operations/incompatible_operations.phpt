--TEST--
Quantity: incompatible dimension add
--FILE--
<?php
require_once __DIR__ . '/../include.inc';

use KhaledAlam\Unit\Quantity;
use KhaledAlam\Unit;
use KhaledAlam\Unit\UnitRegistry;
use KhaledAlam\Unit\Dimension;
use KhaledAlam\Unit\Name;

UnitRegistry::register(new Unit(Name::M->value, Name::M, 1.0, new Dimension(['L' => 1])));
UnitRegistry::register(new Unit(Name::S->value, Name::S, 1.0, new Dimension(['T' => 1])));

$q1 = Quantity::from(5.0, 'm');
$q2 = Quantity::from(10.0, 's');

try {
    $q1->add($q2);
} catch (\Exception $e) {
    echo "Caught: " . $e->getMessage() . "\n";
}
?>
--EXPECT--
Caught: Cannot add: units are dimensionally incompatible.
