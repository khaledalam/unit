--TEST--
Quantity::multiply() formats squared units and converts area
--FILE--
<?php
require_once __DIR__ . '/../include.inc';

use KhaledAlam\Unit\Quantity;

$area = Quantity::from(2.0, 'm')->multiply(Quantity::from(3.0, 'm'));
echo $area . "\n";
echo Quantity::from(1.0, 'm²')->convertTo('cm²') . "\n";
?>
--EXPECT--
6 m²
10000 cm²
