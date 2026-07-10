<?php

/**
 * Temperature conversions use affine scales (factor + offset), so °C/°F/K
 * convert correctly — not just by a naive multiplier.
 *
 *   php examples/temperature.php
 */

require __DIR__ . '/../vendor/autoload.php';

use KhaledAlam\Unit\Quantity;

echo Quantity::of(100, '°C')->to('°F')->format(1), "\n"; // 212.0 °F
echo Quantity::of(32, '°F')->to('°C')->format(1), "\n";  // 0.0 °C
echo Quantity::of(25, '°C')->to('K')->format(2), "\n";   // 298.15 K
