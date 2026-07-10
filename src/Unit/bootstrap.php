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
$speed = new Dimension(['L' => 1, 'T' => -1]);
$data = new Dimension(['B' => 1]);
$force = new Dimension(['M' => 1, 'L' => 1, 'T' => -2]);
$energy = new Dimension(['M' => 1, 'L' => 2, 'T' => -2]);
$power = new Dimension(['M' => 1, 'L' => 2, 'T' => -3]);
$pressure = new Dimension(['M' => 1, 'L' => -1, 'T' => -2]);
$frequency = new Dimension(['T' => -1]);
$angle = new Dimension(['A' => 1]);

// Length (base unit: metre)
$register(Name::MM, 0.001, $length);
$register(Name::CM, 0.01, $length);
$register(Name::M, 1.0, $length);
$register(Name::KM, 1000.0, $length);
$register(Name::INCH, 0.0254, $length);
$register(Name::FT, 0.3048, $length);
$register(Name::YD, 0.9144, $length);
$register(Name::MI, 1609.344, $length);

// Mass (base unit: kilogram)
$register(Name::MG, 1e-6, $mass);
$register(Name::G, 0.001, $mass);
$register(Name::KG, 1.0, $mass);
$register(Name::TON, 1000.0, $mass);
$register(Name::LB, 0.45359237, $mass);
$register(Name::OZ, 0.028349523125, $mass);

// Time (base unit: second)
$register(Name::MS, 0.001, $time);
$register(Name::S, 1.0, $time);
$register(Name::MIN, 60.0, $time);
$register(Name::H, 3600.0, $time);
$register(Name::DAY, 86400.0, $time);
$register(Name::WK, 604800.0, $time);

// Area (base unit: square metre)
$register(Name::CM2, 0.0001, $area);
$register(Name::M2, 1.0, $area);
$register(Name::KM2, 1e6, $area);
$register(Name::FT2, 0.09290304, $area);
$register(Name::HA, 10000.0, $area);
$register(Name::ACRE, 4046.8564224, $area);

// Volume (base unit: cubic metre)
$register(Name::ML, 1e-6, $volume);
$register(Name::L, 0.001, $volume);
$register(Name::M3, 1.0, $volume);
$register(Name::GAL, 0.003785411784, $volume);

// Temperature (base unit: kelvin) — affine scales use factor + offset.
$register(Name::K, 1.0, $temperature, 0.0);
$register(Name::C, 1.0, $temperature, 273.15);
$register(Name::F, 5.0 / 9.0, $temperature, 273.15 - (32.0 * 5.0 / 9.0));

// Speed (base unit: metre per second)
$register(Name::MPS, 1.0, $speed);
$register(Name::KMH, 1000.0 / 3600.0, $speed);
$register(Name::MPH, 0.44704, $speed);
$register(Name::KNOT, 1852.0 / 3600.0, $speed);

// Data (base unit: byte)
$register(Name::BIT, 0.125, $data);
$register(Name::BYTE, 1.0, $data);
$register(Name::KB, 1e3, $data);
$register(Name::MB, 1e6, $data);
$register(Name::GB, 1e9, $data);
$register(Name::TB, 1e12, $data);
$register(Name::KIB, 1024.0, $data);
$register(Name::MIB, 1024.0 ** 2, $data);
$register(Name::GIB, 1024.0 ** 3, $data);
$register(Name::TIB, 1024.0 ** 4, $data);

// Force (base unit: newton)
$register(Name::N, 1.0, $force);
$register(Name::KN, 1000.0, $force);

// Energy (base unit: joule)
$register(Name::J, 1.0, $energy);
$register(Name::KJ, 1000.0, $energy);
$register(Name::CAL, 4.184, $energy);
$register(Name::KCAL, 4184.0, $energy);
$register(Name::WH, 3600.0, $energy);
$register(Name::KWH, 3.6e6, $energy);

// Power (base unit: watt)
$register(Name::W, 1.0, $power);
$register(Name::KW, 1000.0, $power);
$register(Name::HP, 745.6998715822702, $power);

// Pressure (base unit: pascal)
$register(Name::PA, 1.0, $pressure);
$register(Name::KPA, 1000.0, $pressure);
$register(Name::BAR, 1e5, $pressure);
$register(Name::ATM, 101325.0, $pressure);
$register(Name::PSI, 6894.757293168361, $pressure);

// Frequency (base unit: hertz)
$register(Name::HZ, 1.0, $frequency);
$register(Name::KHZ, 1e3, $frequency);
$register(Name::MHZ, 1e6, $frequency);
$register(Name::GHZ, 1e9, $frequency);

// Angle (base unit: radian)
$register(Name::RAD, 1.0, $angle);
$register(Name::DEG, M_PI / 180.0, $angle);
$register(Name::GRAD, M_PI / 200.0, $angle);
$register(Name::TURN, 2.0 * M_PI, $angle);
