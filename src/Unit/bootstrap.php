<?php

/**
 * Default unit registry.
 *
 * Loaded automatically via Composer's "autoload.files", so every unit listed in
 * the {@see \KhaledAlam\Unit\Name} enum is usable immediately after
 * `composer require khaledalam/unit` — no manual registration required.
 */

use KhaledAlam\Unit\Dimension;
use KhaledAlam\Unit\Name;
use KhaledAlam\Unit\Unit;
use KhaledAlam\Unit\UnitRegistry;

$register = static function (Name $name, float $factor, Dimension $dimension, float $offset = 0.0): void {
    UnitRegistry::register(new Unit($name->label(), $name, $factor, $dimension, $offset));
};

$length = new Dimension(['L' => 1]);
$mass = new Dimension(['M' => 1]);
$time = new Dimension(['T' => 1]);
$area = new Dimension(['L' => 2]);
$volume = new Dimension(['L' => 3]);
$temperature = new Dimension(['Θ' => 1]);

// Length (base unit: metre)
$register(Name::MM, 0.001, $length);
$register(Name::CM, 0.01, $length);
$register(Name::M, 1.0, $length);
$register(Name::KM, 1000.0, $length);
$register(Name::INCH, 0.0254, $length);
$register(Name::FT, 0.3048, $length);

// Mass (base unit: kilogram)
$register(Name::MG, 1e-6, $mass);
$register(Name::G, 0.001, $mass);
$register(Name::KG, 1.0, $mass);

// Time (base unit: second)
$register(Name::S, 1.0, $time);
$register(Name::MIN, 60.0, $time);
$register(Name::H, 3600.0, $time);

// Area (base unit: square metre)
$register(Name::M2, 1.0, $area);
$register(Name::CM2, 0.0001, $area);

// Volume (base unit: cubic metre)
$register(Name::M3, 1.0, $volume);
$register(Name::L, 0.001, $volume);
$register(Name::ML, 1e-6, $volume);

// Temperature (base unit: kelvin) — affine scales use factor + offset.
$register(Name::K, 1.0, $temperature, 0.0);
$register(Name::C, 1.0, $temperature, 273.15);
$register(Name::F, 5.0 / 9.0, $temperature, 273.15 - (32.0 * 5.0 / 9.0));
