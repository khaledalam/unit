<?php

namespace KhaledAlam\Unit;

enum Name: string
{
    // Length
    case MM = 'mm';
    case CM = 'cm';
    case M = 'm';
    case KM = 'km';
    case INCH = 'in';
    case FT = 'ft';
    case YD = 'yd';
    case MI = 'mi';

    // Mass
    case MG = 'mg';
    case G = 'g';
    case KG = 'kg';
    case TON = 't';
    case LB = 'lb';
    case OZ = 'oz';

    // Time
    case MS = 'ms';
    case S = 's';
    case MIN = 'min';
    case H = 'h';
    case DAY = 'd';
    case WK = 'wk';

    // Area
    case CM2 = 'cm²';
    case M2 = 'm²';
    case KM2 = 'km²';
    case FT2 = 'ft²';
    case HA = 'ha';
    case ACRE = 'acre';

    // Volume
    case ML = 'mL';
    case L = 'L';
    case M3 = 'm³';
    case GAL = 'gal';

    // Temperature
    case C = '°C';
    case F = '°F';
    case K = 'K';

    // Speed
    case MPS = 'm/s';
    case KMH = 'km/h';
    case MPH = 'mph';
    case KNOT = 'kn';

    // Data
    case BIT = 'bit';
    case BYTE = 'B';
    case KB = 'KB';
    case MB = 'MB';
    case GB = 'GB';
    case TB = 'TB';
    case KIB = 'KiB';
    case MIB = 'MiB';
    case GIB = 'GiB';
    case TIB = 'TiB';

    // Force
    case N = 'N';
    case KN = 'kN';

    // Energy
    case J = 'J';
    case KJ = 'kJ';
    case CAL = 'cal';
    case KCAL = 'kcal';
    case WH = 'Wh';
    case KWH = 'kWh';

    // Power
    case W = 'W';
    case KW = 'kW';
    case HP = 'hp';

    // Pressure
    case PA = 'Pa';
    case KPA = 'kPa';
    case BAR = 'bar';
    case ATM = 'atm';
    case PSI = 'psi';

    // Frequency
    case HZ = 'Hz';
    case KHZ = 'kHz';
    case MHZ = 'MHz';
    case GHZ = 'GHz';

    // Angle
    case RAD = 'rad';
    case DEG = 'deg';
    case GRAD = 'grad';
    case TURN = 'turn';

    /** Human-readable name for the unit. */
    public function label(): string
    {
        return match ($this) {
            self::MM => 'Millimeter',
            self::CM => 'Centimeter',
            self::M => 'Meter',
            self::KM => 'Kilometer',
            self::INCH => 'Inch',
            self::FT => 'Foot',
            self::YD => 'Yard',
            self::MI => 'Mile',

            self::MG => 'Milligram',
            self::G => 'Gram',
            self::KG => 'Kilogram',
            self::TON => 'Tonne',
            self::LB => 'Pound',
            self::OZ => 'Ounce',

            self::MS => 'Millisecond',
            self::S => 'Second',
            self::MIN => 'Minute',
            self::H => 'Hour',
            self::DAY => 'Day',
            self::WK => 'Week',

            self::CM2 => 'Square Centimeter',
            self::M2 => 'Square Meter',
            self::KM2 => 'Square Kilometer',
            self::FT2 => 'Square Foot',
            self::HA => 'Hectare',
            self::ACRE => 'Acre',

            self::ML => 'Milliliter',
            self::L => 'Liter',
            self::M3 => 'Cubic Meter',
            self::GAL => 'Gallon (US)',

            self::C => 'Celsius',
            self::F => 'Fahrenheit',
            self::K => 'Kelvin',

            self::MPS => 'Meter per second',
            self::KMH => 'Kilometer per hour',
            self::MPH => 'Mile per hour',
            self::KNOT => 'Knot',

            self::BIT => 'Bit',
            self::BYTE => 'Byte',
            self::KB => 'Kilobyte',
            self::MB => 'Megabyte',
            self::GB => 'Gigabyte',
            self::TB => 'Terabyte',
            self::KIB => 'Kibibyte',
            self::MIB => 'Mebibyte',
            self::GIB => 'Gibibyte',
            self::TIB => 'Tebibyte',

            self::N => 'Newton',
            self::KN => 'Kilonewton',

            self::J => 'Joule',
            self::KJ => 'Kilojoule',
            self::CAL => 'Calorie',
            self::KCAL => 'Kilocalorie',
            self::WH => 'Watt-hour',
            self::KWH => 'Kilowatt-hour',

            self::W => 'Watt',
            self::KW => 'Kilowatt',
            self::HP => 'Horsepower',

            self::PA => 'Pascal',
            self::KPA => 'Kilopascal',
            self::BAR => 'Bar',
            self::ATM => 'Atmosphere',
            self::PSI => 'Pound per square inch',

            self::HZ => 'Hertz',
            self::KHZ => 'Kilohertz',
            self::MHZ => 'Megahertz',
            self::GHZ => 'Gigahertz',

            self::RAD => 'Radian',
            self::DEG => 'Degree',
            self::GRAD => 'Gradian',
            self::TURN => 'Turn',
        };
    }
}
