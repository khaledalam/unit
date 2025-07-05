<?php

namespace KhaledAlam\Unit;

use KhaledAlam\Unit\Unit;

final class UnitRegistry
{
    /** @var array<string, Unit> */
    private static array $units = [];

    public static function register(Unit $unit): void
    {
        self::$units[$unit->symbol->value] = $unit;
    }

    public static function get(string $symbol): Unit
    {
        if (!isset(self::$units[$symbol])) {
            throw new \InvalidArgumentException("Unknown unit: $symbol");
        }
        return self::$units[$symbol];
    }
}
