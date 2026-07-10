<?php

namespace KhaledAlam\Unit\Tests;

use KhaledAlam\Unit\DefaultUnits;
use KhaledAlam\Unit\Dimension;
use KhaledAlam\Unit\Unit;
use KhaledAlam\Unit\UnitRegistry;
use PHPUnit\Framework\TestCase;

final class UnitRegistryTest extends TestCase
{
    protected function tearDown(): void
    {
        // Restore defaults for any following tests that rely on them.
        UnitRegistry::clear();
        DefaultUnits::register();
    }

    public function test_register_get_has(): void
    {
        UnitRegistry::clear();
        $this->assertFalse(UnitRegistry::has('yd'));

        $yard = new Unit('yard', 'yd', 0.9144, new Dimension(['L' => 1]));
        UnitRegistry::register($yard);

        $this->assertTrue(UnitRegistry::has('yd'));
        $this->assertSame($yard, UnitRegistry::get('yd'));
        $this->assertSame(['yd' => $yard], UnitRegistry::all());
    }

    public function test_get_unknown_unit_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unknown unit: nope');
        UnitRegistry::get('nope');
    }

    public function test_clear_empties_the_registry(): void
    {
        DefaultUnits::register();
        $this->assertNotEmpty(UnitRegistry::all());

        UnitRegistry::clear();
        $this->assertEmpty(UnitRegistry::all());
    }
}
