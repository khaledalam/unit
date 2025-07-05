--TEST--
Quantity::add()
--FILE--
<?php
require_once __DIR__ . '/../include.inc';

use KhaledAlam\Unit\Unit;
use KhaledAlam\Unit\Name;
use KhaledAlam\Unit\Dimension;
use KhaledAlam\Unit\Quantity;
use KhaledAlam\Unit\UnitRegistry;

// Register required units
UnitRegistry::register(new Unit(Name::M->value, Name::M, 1.0, new Dimension(['L' => 1])));
UnitRegistry::register(new Unit(Name::CM->value, Name::CM, 0.01, new Dimension(['L' => 1])));

// Prepare test quantities
$lefts = [
    Quantity::from(1.0, 'm'),
    Quantity::from(2.5, 'm'),
    Quantity::from(100.0, 'cm'),
];

$rights = [
    Quantity::from(1.0, 'm'),
    Quantity::from(50.0, 'cm'),
    Quantity::from(0.75, 'm'),
];

// Execute and display results
foreach ($lefts as $left) {
    foreach ($rights as $right) {
        $ret = "{$left} + {$right}: ";
        try {
            $sum = $left->add($right)->convertTo('m');
            echo $ret . $sum . "\n";
        } catch (\Exception $e) {
            echo $ret . " " . $e->getMessage() . "\n";
        }
    }
}

?>
--EXPECTF--
1 m + 1 m: %f m
1 m + 50 cm: %f m
1 m + 0.75 m: %f m
2.5 m + 1 m: %f m
2.5 m + 50 cm: %f m
2.5 m + 0.75 m: %f m
100 cm + 1 m: %f m
100 cm + 50 cm: %f m
100 cm + 0.75 m: %f m
