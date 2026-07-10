--TEST--
Quantity::humanize() picks the most readable unit
--FILE--
<?php
require_once __DIR__ . '/../include.inc';

use KhaledAlam\Unit\Quantity;

echo Quantity::of(1500, 'm')->humanize() . "\n";
echo Quantity::of(999, 'm')->humanize() . "\n";
echo Quantity::of(0.5, 'mm')->humanize() . "\n";
echo Quantity::of(5400, 's')->humanize() . "\n";
echo Quantity::of(1500, 'B')->humanize() . "\n";
echo Quantity::of(2500000, 'B')->humanize()->format(2) . "\n";
echo Quantity::of(2500, 'g')->humanize() . "\n";
echo Quantity::of(25, '°C')->humanize() . "\n";
?>
--EXPECT--
1.5 km
999 m
0.5 mm
1.5 h
1.5 KB
2.50 MB
2.5 kg
25 °C
