<?php

/**
 * Real-world: derived units from arithmetic — speed and area.
 *
 *   php examples/physics.php
 */

require __DIR__ . '/../vendor/autoload.php';

use KhaledAlam\Unit\Quantity;

// Speed = distance / time  ->  m/s
$speed = Quantity::of(100, 'm')->divide(Quantity::of(9.58, 's'));
echo $speed->format(2), "\n"; // 10.44 m/s

// Area = length * width  ->  m²
$area = Quantity::of(4, 'm')->multiply(Quantity::of(3, 'm'));
echo $area, "\n";             // 12 m²
