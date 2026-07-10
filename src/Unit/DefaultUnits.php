<?php

namespace KhaledAlam\Unit;

/**
 * Registers the built-in units shipped with the library.
 *
 * Invoked automatically from {@see bootstrap.php} (wired through Composer's
 * "autoload.files"), so all common units are available immediately after
 * `composer require`. Exposed as a class so the registration logic is testable
 * and can be re-run against a cleared registry.
 */
final class DefaultUnits
{
    private static function add(Name $name, float $factor, Dimension $dimension, float $offset = 0.0): void
    {
        UnitRegistry::register(new Unit($name->label(), $name, $factor, $dimension, $offset));
    }

    public static function register(): void
    {
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
        self::add(Name::MM, 0.001, $length);
        self::add(Name::CM, 0.01, $length);
        self::add(Name::M, 1.0, $length);
        self::add(Name::KM, 1000.0, $length);
        self::add(Name::INCH, 0.0254, $length);
        self::add(Name::FT, 0.3048, $length);
        self::add(Name::YD, 0.9144, $length);
        self::add(Name::MI, 1609.344, $length);

        // Mass (base unit: kilogram)
        self::add(Name::MG, 1e-6, $mass);
        self::add(Name::G, 0.001, $mass);
        self::add(Name::KG, 1.0, $mass);
        self::add(Name::TON, 1000.0, $mass);
        self::add(Name::LB, 0.45359237, $mass);
        self::add(Name::OZ, 0.028349523125, $mass);

        // Time (base unit: second)
        self::add(Name::MS, 0.001, $time);
        self::add(Name::S, 1.0, $time);
        self::add(Name::MIN, 60.0, $time);
        self::add(Name::H, 3600.0, $time);
        self::add(Name::DAY, 86400.0, $time);
        self::add(Name::WK, 604800.0, $time);

        // Area (base unit: square metre)
        self::add(Name::CM2, 0.0001, $area);
        self::add(Name::M2, 1.0, $area);
        self::add(Name::KM2, 1e6, $area);
        self::add(Name::FT2, 0.09290304, $area);
        self::add(Name::HA, 10000.0, $area);
        self::add(Name::ACRE, 4046.8564224, $area);

        // Volume (base unit: cubic metre)
        self::add(Name::ML, 1e-6, $volume);
        self::add(Name::L, 0.001, $volume);
        self::add(Name::M3, 1.0, $volume);
        self::add(Name::GAL, 0.003785411784, $volume);

        // Temperature (base unit: kelvin) — affine scales use factor + offset.
        self::add(Name::K, 1.0, $temperature, 0.0);
        self::add(Name::C, 1.0, $temperature, 273.15);
        self::add(Name::F, 5.0 / 9.0, $temperature, 273.15 - (32.0 * 5.0 / 9.0));

        // Speed (base unit: metre per second)
        self::add(Name::MPS, 1.0, $speed);
        self::add(Name::KMH, 1000.0 / 3600.0, $speed);
        self::add(Name::MPH, 0.44704, $speed);
        self::add(Name::KNOT, 1852.0 / 3600.0, $speed);

        // Data (base unit: byte)
        self::add(Name::BIT, 0.125, $data);
        self::add(Name::BYTE, 1.0, $data);
        self::add(Name::KB, 1e3, $data);
        self::add(Name::MB, 1e6, $data);
        self::add(Name::GB, 1e9, $data);
        self::add(Name::TB, 1e12, $data);
        self::add(Name::KIB, 1024.0, $data);
        self::add(Name::MIB, 1024.0 ** 2, $data);
        self::add(Name::GIB, 1024.0 ** 3, $data);
        self::add(Name::TIB, 1024.0 ** 4, $data);

        // Force (base unit: newton)
        self::add(Name::N, 1.0, $force);
        self::add(Name::KN, 1000.0, $force);

        // Energy (base unit: joule)
        self::add(Name::J, 1.0, $energy);
        self::add(Name::KJ, 1000.0, $energy);
        self::add(Name::CAL, 4.184, $energy);
        self::add(Name::KCAL, 4184.0, $energy);
        self::add(Name::WH, 3600.0, $energy);
        self::add(Name::KWH, 3.6e6, $energy);

        // Power (base unit: watt)
        self::add(Name::W, 1.0, $power);
        self::add(Name::KW, 1000.0, $power);
        self::add(Name::HP, 745.6998715822702, $power);

        // Pressure (base unit: pascal)
        self::add(Name::PA, 1.0, $pressure);
        self::add(Name::KPA, 1000.0, $pressure);
        self::add(Name::BAR, 1e5, $pressure);
        self::add(Name::ATM, 101325.0, $pressure);
        self::add(Name::PSI, 6894.757293168361, $pressure);

        // Frequency (base unit: hertz)
        self::add(Name::HZ, 1.0, $frequency);
        self::add(Name::KHZ, 1e3, $frequency);
        self::add(Name::MHZ, 1e6, $frequency);
        self::add(Name::GHZ, 1e9, $frequency);

        // Angle (base unit: radian)
        self::add(Name::RAD, 1.0, $angle);
        self::add(Name::DEG, M_PI / 180.0, $angle);
        self::add(Name::GRAD, M_PI / 200.0, $angle);
        self::add(Name::TURN, 2.0 * M_PI, $angle);
    }
}
