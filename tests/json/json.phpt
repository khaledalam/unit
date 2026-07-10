--TEST--
Quantity JSON serialization, withPrecision, and registry helpers
--FILE--
<?php
require_once __DIR__ . '/../include.inc';

use KhaledAlam\Unit\Quantity;
use KhaledAlam\Unit\UnitRegistry;

echo json_encode(Quantity::of(2, 'm')) . "\n";
echo json_encode(Quantity::of(10, 'm')->divide(Quantity::of(4, 's'))) . "\n";

$q = Quantity::of(1.23456, 'm');
echo $q->withPrecision(2) . "\n";
echo $q->format(3) . "\n";

var_dump(UnitRegistry::has('kg'));
var_dump(UnitRegistry::has('nope'));
?>
--EXPECT--
{"value":2,"unit":"m"}
{"value":2.5,"unit":"m\/s"}
1.23 m
1.235 m
bool(true)
bool(false)
