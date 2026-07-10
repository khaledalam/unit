--TEST--
Quantity::convertTo() handles affine temperature scales (°C, °F, K)
--FILE--
<?php
require_once __DIR__ . '/../include.inc';

use KhaledAlam\Unit\Quantity;

echo Quantity::from(100.0, '°C')->convertTo('°F')->format(1) . "\n";
echo Quantity::from(32.0, '°F')->convertTo('°C')->format(1) . "\n";
echo Quantity::from(0.0, '°C')->convertTo('K')->format(2) . "\n";
echo Quantity::from(300.0, 'K')->convertTo('°C')->format(2) . "\n";
echo Quantity::from(-40.0, '°C')->convertTo('°F')->format(1) . "\n";
?>
--EXPECT--
212.0 °F
0.0 °C
273.15 K
26.85 °C
-40.0 °F
