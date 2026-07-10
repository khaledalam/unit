<?php

namespace KhaledAlam\Unit\Tests;

use KhaledAlam\Unit\Dimension;
use PHPUnit\Framework\Attributes\DataProvider;
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

    public function test_power(): void
    {
        $this->assertSame(['L' => 2], (new Dimension(['L' => 1]))->power(2)->exponents);
        $this->assertSame(['L' => 2, 'T' => -2], (new Dimension(['L' => 1, 'T' => -1]))->power(2)->exponents);
        $this->assertTrue((new Dimension(['L' => 1]))->power(0)->isDimensionless());
    }

    public function test_root(): void
    {
        $this->assertSame(['L' => 1], (new Dimension(['L' => 2]))->root(2)->exponents);
    }

    public function test_root_with_invalid_degree_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Root degree must be >= 1.');
        (new Dimension(['L' => 2]))->root(0);
    }

    public function test_root_of_non_divisible_exponent_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new Dimension(['L' => 3]))->root(2);
    }

    /**
     * @return array<string, array{array<string, int>, ?string}>
     */
    public static function dimensionNames(): array
    {
        return [
            'dimensionless' => [[], 'dimensionless'],
            'length' => [['L' => 1], 'length'],
            'mass' => [['M' => 1], 'mass'],
            'time' => [['T' => 1], 'time'],
            'temperature' => [['Θ' => 1], 'temperature'],
            'area' => [['L' => 2], 'area'],
            'volume' => [['L' => 3], 'volume'],
            'velocity' => [['L' => 1, 'T' => -1], 'velocity'],
            'acceleration' => [['L' => 1, 'T' => -2], 'acceleration'],
            'force' => [['M' => 1, 'L' => 1, 'T' => -2], 'force'],
            'energy' => [['M' => 1, 'L' => 2, 'T' => -2], 'energy'],
            'power' => [['M' => 1, 'L' => 2, 'T' => -3], 'power'],
            'pressure' => [['M' => 1, 'L' => -1, 'T' => -2], 'pressure'],
            'frequency' => [['T' => -1], 'frequency'],
            'data' => [['B' => 1], 'data'],
            'angle' => [['A' => 1], 'angle'],
            'unknown' => [['X' => 5], null],
        ];
    }

    /**
     * @param array<string, int> $exponents
     */
    #[DataProvider('dimensionNames')]
    public function test_name(array $exponents, ?string $expected): void
    {
        $this->assertSame($expected, (new Dimension($exponents))->name());
    }
}
