--TEST--
Quantity: throws exception on negative precision
--FILE--
<?php

use KhaledAlam\Unit\Quantity;
use KhaledAlam\Unit;
use KhaledAlam\Unit\Name;
use KhaledAlam\Unit\Dimension;
use KhaledAlam\Unit\UnitRegistry;

require_once __DIR__ . '/../include.inc';

// Register required unit
UnitRegistry::register(new Unit(Name::M->value, Name::M, 1.0, new Dimension(['L' => 1])));

try {
    $q = Quantity::from(1.23, 'm', -2);
    echo "No exception thrown\n";
} catch (\InvalidArgumentException $e) {
    echo "Caught: " . $e->getMessage() . "\n";
}
?>
--EXPECT--
Caught: Precision must be >= 0.
