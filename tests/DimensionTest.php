<?php

namespace KhaledAlam\Unit\Tests;

use KhaledAlam\Unit\Dimension;
use PHPUnit\Framework\TestCase;

final class DimensionTest extends TestCase
{
    public function test_constructor_drops_zero_exponents_and_sorts(): void
    {
        $d = new Dimension(['T' => 0, 'L' => 1]);
        $this->assertSame(['L' => 1], $d->exponents);
        $this->assertFalse($d->isDimensionless());
    }

    public function test_multiply_and_divide(): void
    {
        $length = new Dimension(['L' => 1]);
        $time = new Dimension(['T' => 1]);

        $speed = $length->divide($time);
        $this->assertSame(['L' => 1, 'T' => -1], $speed->exponents);

        $area = $length->multiply($length);
        $this->assertSame(['L' => 2], $area->exponents);
    }

    public function test_division_by_same_dimension_is_dimensionless(): void
    {
        $length = new Dimension(['L' => 1]);
        $cancelled = $length->divide($length);

        $this->assertTrue($cancelled->isDimensionless());
        $this->assertTrue($cancelled->equals(new Dimension()));
    }

    public function test_equals_and_to_string(): void
    {
        $a = new Dimension(['L' => 1, 'T' => -1]);
        $b = new Dimension(['T' => -1, 'L' => 1]);

        $this->assertTrue($a->equals($b));
        $this->assertFalse($a->equals(new Dimension(['L' => 1])));
        $this->assertSame('{"L":1,"T":-1}', (string) $a);
        $this->assertSame('[]', (string) new Dimension());
    }
}
