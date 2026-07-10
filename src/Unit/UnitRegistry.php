<?php

namespace KhaledAlam\Unit;

use KhaledAlam\Unit\Unit;

final class UnitRegistry
{
    /** @var array<string, Unit> */
    private static array $units = [];

    public static function register(Unit $unit): void
    {
        self::$units[$unit->symbolString()] = $unit;
    }

    public static function get(string $symbol): Unit
    {
        if (!isset(self::$units[$symbol])) {
            throw new \InvalidArgumentException("Unknown unit: $symbol");
        }
        return self::$units[$symbol];
    }

    public static function has(string $symbol): bool
    {
        return isset(self::$units[$symbol]);
    }

    /** @return array<string, Unit> */
    public static function all(): array
    {
        return self::$units;
    }

    /** Clears every registered unit. Primarily useful for isolated tests. */
    public static function clear(): void
    {
        self::$units = [];
    }
}
