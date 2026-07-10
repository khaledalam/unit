<?php

namespace KhaledAlam\Unit\Tests;

use KhaledAlam\Unit\DefaultUnits;
use KhaledAlam\Unit\Dimension;
use KhaledAlam\Unit\Quantity;
use KhaledAlam\Unit\Unit;
use KhaledAlam\Unit\UnitRegistry;
use PHPUnit\Framework\TestCase;

final class QuantityEdgeTest extends TestCase
{
    protected function tearDown(): void
    {
        // Some tests mutate the global registry; always restore the defaults.
        UnitRegistry::clear();
        DefaultUnits::register();
    }

    public function test_negative_precision_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Quantity::of(1, 'm', -1);
    }

    public function test_subtract_across_units(): void
    {
        $result = Quantity::of(2, 'm')->subtract(Quantity::of(50, 'cm'));
        $this->assertEqualsWithDelta(1.5, $result->getValue(), 1e-9);
    }

    public function test_divide_by_zero_quantity_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot divide by a zero quantity.');
        Quantity::of(10, 'm')->divide(Quantity::of(0, 's'));
    }

    public function test_division_of_same_unit_cancels_symbol(): void
    {
        $ratio = Quantity::of(10, 'm')->divide(Quantity::of(2, 'm'));
        $this->assertSame(5.0, $ratio->getValue());
        $this->assertSame('', $ratio->getUnit()->symbolString());
        $this->assertTrue($ratio->getUnit()->dimension->isDimensionless());
    }

    public function test_multiply_same_unit_squares_symbol(): void
    {
        $area = Quantity::of(2, 'm')->multiply(Quantity::of(3, 'm'));
        $this->assertSame('m²', $area->getUnit()->symbolString());
    }

    public function test_comparison_helpers(): void
    {
        $this->assertTrue(Quantity::of(1, 'm')->isLessThan(Quantity::of(200, 'cm')));
        $this->assertFalse(Quantity::of(1, 'm')->isLessThan(Quantity::of(50, 'cm')));
        $this->assertFalse(Quantity::of(1, 'm')->equals(Quantity::of(3, 's')));
    }

    public function test_humanize_returns_self_when_no_ladder_applies(): void
    {
        // Frequency has no humanize ladder — value/unit stay unchanged.
        $freq = Quantity::of(2, 'kHz');
        $this->assertSame('2 kHz', (string) $freq->humanize());
    }

    public function test_humanize_skips_ladders_whose_units_are_not_registered(): void
    {
        // Only data units registered: humanize must skip the length/mass/etc.
        // ladders (their base symbols are absent) and still find the data ladder.
        UnitRegistry::clear();
        $data = new Dimension(['B' => 1]);
        UnitRegistry::register(new Unit('Byte', 'B', 1.0, $data));
        UnitRegistry::register(new Unit('Kilobyte', 'KB', 1e3, $data));
        UnitRegistry::register(new Unit('Megabyte', 'MB', 1e6, $data));

        $this->assertSame('2.5 MB', (string) Quantity::of(2_500_000, 'B')->humanize());
    }

    public function test_withPrecision_and_json(): void
    {
        $q = Quantity::of(1.23456, 'm')->withPrecision(2);
        $this->assertSame('1.23 m', (string) $q);
        $this->assertSame('{"value":1.23456,"unit":"m"}', json_encode($q));
    }
}
