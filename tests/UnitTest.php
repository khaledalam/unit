<?php

namespace KhaledAlam\Unit\Tests;

use KhaledAlam\Unit\Dimension;
use KhaledAlam\Unit\Name;
use KhaledAlam\Unit\Unit;
use PHPUnit\Framework\TestCase;

final class UnitTest extends TestCase
{
    public function test_enum_symbol_string_and_to_string(): void
    {
        $unit = new Unit('Meter', Name::M, 1.0, new Dimension(['L' => 1]));

        $this->assertSame('m', $unit->symbolString());
        $this->assertSame('m', (string) $unit);
        $this->assertSame(0.0, $unit->offset);
    }

    public function test_string_symbol_does_not_error(): void
    {
        $derived = new Unit('derived', 'm/s', 1.0, new Dimension(['L' => 1, 'T' => -1]));

        $this->assertSame('m/s', $derived->symbolString());
        $this->assertSame('m/s', (string) $derived);
    }

    public function test_offset_is_retained(): void
    {
        $celsius = new Unit('Celsius', Name::C, 1.0, new Dimension(['Θ' => 1]), 273.15);
        $this->assertSame(273.15, $celsius->offset);
    }
}
