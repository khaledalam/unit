<?php

/**
 * Real-world: sum mixed-unit cart item weights and price by the kilogram.
 *
 *   php examples/shipping.php
 */

require __DIR__ . '/../vendor/autoload.php';

use KhaledAlam\Unit\Quantity;

$cart = [
    Quantity::of(500, 'g'),
    Quantity::of(1.2, 'kg'),
    Quantity::of(750, 'g'),
];

$total = array_reduce(
    $cart,
    static fn (Quantity $carry, Quantity $item) => $carry->add($item),
    Quantity::of(0, 'kg'),
);

$kg = $total->convertTo('kg');
$ratePerKg = 3.50;

printf("Total weight: %s\n", $kg->format(3));                     // 2.450 kg
printf("Shipping: $%.2f\n", $kg->getValue() * $ratePerKg);       // $8.58
