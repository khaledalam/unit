--TEST--
Quantity::parse() handles single, compound, and multi-segment strings
--FILE--
<?php
require_once __DIR__ . '/../include.inc';

use KhaledAlam\Unit\Quantity;

echo Quantity::parse('100 km/h')->to('mph')->format(2) . "\n";
echo Quantity::parse('-40 °C')->to('°F')->format(1) . "\n";
echo Quantity::parse('5 ft 3 in')->to('cm')->format(2) . "\n";
echo Quantity::parse('2.5 kg')->to('g') . "\n";

try {
    Quantity::parse('hello');
} catch (\InvalidArgumentException $e) {
    echo $e->getMessage() . "\n";
}

try {
    Quantity::parse('5 m 3 kg');
} catch (\InvalidArgumentException $e) {
    echo $e->getMessage() . "\n";
}
?>
--EXPECT--
62.14 mph
-40.0 °F
160.02 cm
2500 g
Could not parse a quantity from: "hello".
Cannot add: units are dimensionally incompatible.
