<?php

/**
 * Basic usage — no manual registration needed, common units are auto-loaded.
 *
 *   php examples/basic.php
 */

require __DIR__ . '/../vendor/autoload.php';

use KhaledAlam\Unit\Quantity;

// Add across units (automatic conversion)
$total = Quantity::of(2, 'm')->add(Quantity::of(100, 'cm'));
echo $total->convertTo('m'), "\n";        // 3 m

// Convert
echo Quantity::of(5, 'km')->to('m'), "\n"; // 5000 m

// Compare
$a = Quantity::of(1, 'm');
$b = Quantity::of(90, 'cm');
echo $a->isGreaterThan($b) ? "1 m > 90 cm\n" : "1 m <= 90 cm\n";
