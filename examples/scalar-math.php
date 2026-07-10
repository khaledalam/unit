<?php

/**
 * Scalar arithmetic, powers/roots, and dimension names.
 *
 *   php examples/scalar-math.php
 */

require __DIR__ . '/../vendor/autoload.php';

use KhaledAlam\Unit\Quantity;

// Scale by plain numbers
echo Quantity::of(5, 'm')->times(3), "\n";        // 15 m
echo Quantity::of(10, 'kg')->dividedBy(4), "\n";  // 2.5 kg

// Powers and roots track the dimension
echo Quantity::of(3, 'm')->pow(2), "\n";          // 9 m²
echo Quantity::of(9, 'm²')->sqrt(), "\n";         // 3 m

// Ask a quantity what it measures
echo Quantity::of(1, 'm/s')->dimensionName(), "\n";  // velocity
echo Quantity::of(1, 'Pa')->dimensionName(), "\n";   // pressure
