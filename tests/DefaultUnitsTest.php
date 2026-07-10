<?php

namespace KhaledAlam\Unit\Tests;

use KhaledAlam\Unit\DefaultUnits;
use KhaledAlam\Unit\Name;
use KhaledAlam\Unit\Quantity;
use KhaledAlam\Unit\UnitRegistry;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class DefaultUnitsTest extends TestCase
{
    protected function setUp(): void
    {
        // Re-run registration against a clean registry inside the coverage window.
        UnitRegistry::clear();
        DefaultUnits::register();
    }

    public function test_registers_every_enum_case(): void
    {
        foreach (Name::cases() as $case) {
            $this->assertTrue(
                UnitRegistry::has($case->value),
                "Unit {$case->value} was not registered"
            );
        }

        $this->assertCount(count(Name::cases()), UnitRegistry::all());
    }

    /**
     * @return array<string, array{float, string, string, float, int}>
     */
    public static function conversions(): array
    {
        return [
            'km/h -> mph'   => [100.0, 'km/h', 'mph', 62.137119, 6],
            'GiB -> MiB'    => [1.0, 'GiB', 'MiB', 1024.0, 6],
            'kWh -> J'      => [1.0, 'kWh', 'J', 3_600_000.0, 6],
            'mi -> km'      => [1.0, 'mi', 'km', 1.609344, 6],
            'atm -> psi'    => [1.0, 'atm', 'psi', 14.695949, 6],
            'deg -> rad'    => [180.0, 'deg', 'rad', 3.141593, 6],
            'hp -> W'       => [1.0, 'hp', 'W', 745.699872, 6],
            'lb -> g'       => [1.0, 'lb', 'g', 453.59237, 6],
            'acre -> m²'    => [1.0, 'acre', 'm²', 4046.856422, 6],
            'gal -> L'      => [1.0, 'gal', 'L', 3.785412, 6],
        ];
    }

    #[DataProvider('conversions')]
    public function test_conversions_are_accurate(
        float $value,
        string $from,
        string $to,
        float $expected,
        int $precision
    ): void {
        $result = Quantity::of($value, $from)->convertTo($to)->getValue();
        $this->assertEqualsWithDelta($expected, $result, 10 ** -$precision);
    }
}
