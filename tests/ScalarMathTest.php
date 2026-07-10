<?php

namespace KhaledAlam\Unit\Tests;

use KhaledAlam\Unit\Quantity;
use PHPUnit\Framework\TestCase;

final class ScalarMathTest extends TestCase
{
    public function test_times_and_divided_by(): void
    {
        $this->assertSame('15 m', (string) Quantity::of(5, 'm')->times(3));
        $this->assertSame('2.5 m', (string) Quantity::of(10, 'm')->dividedBy(4));
    }

    public function test_divided_by_zero_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot divide by zero.');
        Quantity::of(10, 'm')->dividedBy(0);
    }

    public function test_abs_and_negate(): void
    {
        $this->assertSame('3 m', (string) Quantity::of(-3, 'm')->abs());
        $this->assertSame('-3 m', (string) Quantity::of(3, 'm')->negate());
    }

    public function test_pow_scales_value_and_dimension(): void
    {
        $this->assertSame('m', (string) Quantity::of(2, 'm')->pow(1)->getUnit());
        $this->assertSame('4 m²', (string) Quantity::of(2, 'm')->pow(2));
        $this->assertSame('8 m³', (string) Quantity::of(2, 'm')->pow(3));
        $this->assertSame('16 m^4', (string) Quantity::of(2, 'm')->pow(4));
        $this->assertSame('0.5 s^-1', (string) Quantity::of(2, 's')->pow(-1));
    }

    public function test_pow_zero_is_dimensionless(): void
    {
        $result = Quantity::of(5, 'm')->pow(0);
        $this->assertSame(1.0, $result->getValue());
        $this->assertSame('', $result->getUnit()->symbolString());
        $this->assertTrue($result->getUnit()->dimension->isDimensionless());
    }

    public function test_pow_on_dimensionless_keeps_empty_symbol(): void
    {
        $ratio = Quantity::of(4, 'm')->divide(Quantity::of(2, 'm')); // "" symbol
        $this->assertSame('', $ratio->pow(2)->getUnit()->symbolString());
        $this->assertSame('', $ratio->pow(3)->getUnit()->symbolString());
        $this->assertSame('', $ratio->pow(5)->getUnit()->symbolString());
    }

    public function test_pow_result_is_convertible_for_base_units(): void
    {
        $this->assertSame('40000 cm²', (string) Quantity::of(2, 'm')->pow(2)->convertTo('cm²'));
    }

    public function test_sqrt_halves_the_dimension(): void
    {
        $this->assertSame('2 m', (string) Quantity::of(4, 'm²')->sqrt());
    }

    public function test_sqrt_of_dimensionless(): void
    {
        $ratio = Quantity::of(4, 'm')->divide(Quantity::of(1, 'm')); // 4, symbol ""
        $this->assertSame(2.0, $ratio->sqrt()->getValue());
        $this->assertSame('', $ratio->sqrt()->getUnit()->symbolString());
    }

    public function test_sqrt_falls_back_to_radical_symbol(): void
    {
        // (2 m)^4 has symbol "m^4"; its square root can't strip a trailing ².
        $root = Quantity::of(2, 'm')->pow(4)->sqrt();
        $this->assertSame('√m^4', $root->getUnit()->symbolString());
        $this->assertSame(4.0, $root->getValue());
    }

    public function test_sqrt_of_negative_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Quantity::of(-4, 'm²')->sqrt();
    }

    public function test_sqrt_of_odd_dimension_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('not divisible');
        Quantity::of(4, 'm')->sqrt();
    }

    public function test_dimension_name(): void
    {
        $this->assertSame('velocity', Quantity::of(1, 'm/s')->dimensionName());
        $this->assertSame('force', Quantity::of(1, 'N')->dimensionName());
        $this->assertSame('length', Quantity::of(1, 'm')->dimensionName());

        // m·s is not a named dimension.
        $unnamed = Quantity::of(1, 'm')->multiply(Quantity::of(1, 's'));
        $this->assertNull($unnamed->dimensionName());
    }
}
