--TEST--
Conversions across the extended unit families (speed, data, energy, pressure, angle)
--FILE--
<?php
require_once __DIR__ . '/../include.inc';

use KhaledAlam\Unit\Quantity;

echo Quantity::of(100, 'km/h')->to('mph')->format(2) . "\n";
echo Quantity::of(1, 'GB')->to('MB') . "\n";
echo Quantity::of(1, 'GiB')->to('MiB') . "\n";
echo Quantity::of(1, 'kWh')->to('J') . "\n";
echo Quantity::of(1, 'mi')->to('km') . "\n";
echo Quantity::of(1, 'atm')->to('psi')->format(3) . "\n";
echo Quantity::of(180, 'deg')->to('rad')->format(5) . "\n";
echo Quantity::of(1, 'hp')->to('W')->format(2) . "\n";
echo Quantity::of(1, 'lb')->to('g')->format(2) . "\n";
?>
--EXPECT--
62.14 mph
1000 MB
1024 MiB
3600000 J
1.609344 km
14.696 psi
3.14159 rad
745.70 W
453.59 g
