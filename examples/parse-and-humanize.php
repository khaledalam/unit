<?php

/**
 * Parse human-readable strings and print them in the most readable unit.
 *
 *   php examples/parse-and-humanize.php
 */

require __DIR__ . '/../vendor/autoload.php';

use KhaledAlam\Unit\Quantity;

// Parse compound and multi-segment strings
echo Quantity::parse('100 km/h')->to('mph')->format(2), "\n"; // 62.14 mph
echo Quantity::parse('5 ft 3 in')->to('cm')->format(2), "\n"; // 160.02 cm

// Let the library choose the nicest unit
echo Quantity::of(1500, 'm')->humanize(), "\n";      // 1.5 km
echo Quantity::of(2_500_000, 'B')->humanize(), "\n"; // 2.5 MB
echo Quantity::of(90, 'min')->humanize(), "\n";      // 1.5 h
