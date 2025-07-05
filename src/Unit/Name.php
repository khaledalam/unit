<?php

namespace KhaledAlam\Unit;

enum Name: string
{
    // Length units
    case MM = 'mm';       // millimeter
    case CM = 'cm';       // centimeter
    case M = 'm';         // meter
    case KM = 'km';       // kilometer
    case INCH = 'in';     // inch
    case FT = 'ft';       // foot

    // Mass units
    case G = 'g';         // gram
    case KG = 'kg';       // kilogram
    case MG = 'mg';       // milligram

    // Time units
    case S = 's';         // second
    case MIN = 'min';     // minute
    case H = 'h';         // hour

    // Area units
    case M2 = 'm²';
    case CM2 = 'cm²';

    // Volume units
    case L = 'L';         // liter
    case ML = 'mL';       // milliliter
    case M3 = 'm³';

    // Temperature units (if supported)
    case C = '°C';
    case F = '°F';
    case K = 'K';

    // Helper: full unit name
    public function label(): string
    {
        return match ($this) {
            self::MM => 'Millimeter',
            self::CM => 'Centimeter',
            self::M => 'Meter',
            self::KM => 'Kilometer',
            self::INCH => 'Inch',
            self::FT => 'Foot',

            self::G => 'Gram',
            self::KG => 'Kilogram',
            self::MG => 'Milligram',

            self::S => 'Second',
            self::MIN => 'Minute',
            self::H => 'Hour',

            self::M2 => 'Square Meter',
            self::CM2 => 'Square Centimeter',

            self::L => 'Liter',
            self::ML => 'Milliliter',
            self::M3 => 'Cubic Meter',

            self::C => 'Celsius',
            self::F => 'Fahrenheit',
            self::K => 'Kelvin',
        };
    }
}
