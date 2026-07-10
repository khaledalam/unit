<?php

namespace KhaledAlam\Unit;

use JsonSerializable;
use Stringable;

final readonly class Quantity implements Stringable, JsonSerializable
{
    private float $value;
    private Unit $unit;
    private ?int $precision;

    public function __construct(float $value, Unit $unit, ?int $precision = null)
    {
        if ($precision !== null && $precision < 0) {
            throw new \InvalidArgumentException('Precision must be >= 0.');
        }

        $this->value = $value;
        $this->unit = $unit;
        $this->precision = $precision;
    }

    public static function from(float $value, string $symbol, ?int $precision = null): self
    {
        $unit = UnitRegistry::get($symbol);
        return new self($value, $unit, $precision);
    }

    /** Fluent alias for {@see self::from()}. */
    public static function of(float $value, string $symbol, ?int $precision = null): self
    {
        return self::from($value, $symbol, $precision);
    }

    public function convertTo(string $symbol): self
    {
        $target = UnitRegistry::get($symbol);

        if (!$this->unit->dimension->equals($target->dimension)) {
            throw new \InvalidArgumentException('Cannot convert: units are dimensionally incompatible.');
        }

        $baseValue = $this->toBase();
        $convertedValue = ($baseValue - $target->offset) / $target->factor;

        return new self($convertedValue, $target, $this->precision);
    }

    /** Fluent alias for {@see self::convertTo()}. */
    public function to(string $symbol): self
    {
        return $this->convertTo($symbol);
    }

    public function add(Quantity $other): self
    {
        $this->assertSameDimension($other, 'add');

        $sumBase = $this->toBase() + $other->toBase();
        $sumValue = ($sumBase - $this->unit->offset) / $this->unit->factor;

        return new self($sumValue, $this->unit, $this->precision);
    }

    public function subtract(Quantity $other): self
    {
        $this->assertSameDimension($other, 'subtract');

        $diffBase = $this->toBase() - $other->toBase();
        $diffValue = ($diffBase - $this->unit->offset) / $this->unit->factor;

        return new self($diffValue, $this->unit, $this->precision);
    }

    public function multiply(Quantity $other): self
    {
        $value = $this->value * $other->value;
        $newDimension = $this->unit->dimension->multiply($other->unit->dimension);
        $newSymbol = self::combineSymbols($this->unit->symbolString(), $other->unit->symbolString(), '*');
        $newUnit = new Unit('derived', $newSymbol, 1.0, $newDimension);

        return new self($value, $newUnit, $this->precision);
    }

    public function divide(Quantity $other): self
    {
        if ($other->value === 0.0) {
            throw new \InvalidArgumentException('Cannot divide by a zero quantity.');
        }

        $value = $this->value / $other->value;
        $newDimension = $this->unit->dimension->divide($other->unit->dimension);
        $newSymbol = self::combineSymbols($this->unit->symbolString(), $other->unit->symbolString(), '/');
        $newUnit = new Unit('derived', $newSymbol, 1.0, $newDimension);

        return new self($value, $newUnit, $this->precision);
    }

    /** Compares two quantities after converting to a common base. */
    public function equals(Quantity $other, float $epsilon = 1e-9): bool
    {
        return $this->unit->dimension->equals($other->unit->dimension)
            && abs($this->toBase() - $other->toBase()) <= $epsilon;
    }

    public function isGreaterThan(Quantity $other): bool
    {
        $this->assertSameDimension($other, 'compare');
        return $this->toBase() > $other->toBase();
    }

    public function isLessThan(Quantity $other): bool
    {
        $this->assertSameDimension($other, 'compare');
        return $this->toBase() < $other->toBase();
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getUnit(): Unit
    {
        return $this->unit;
    }

    public function withPrecision(?int $precision): self
    {
        return new self($this->value, $this->unit, $precision);
    }

    public function format(?int $precision = null): string
    {
        $precision ??= $this->precision;

        $valueStr = $precision !== null
            ? number_format($this->value, $precision, '.', '')
            : (string) $this->value;

        return $valueStr . ' ' . $this->unit->symbolString();
    }

    /** Value expressed in the dimension's base unit (applies factor then offset). */
    private function toBase(): float
    {
        return $this->value * $this->unit->factor + $this->unit->offset;
    }

    private function assertSameDimension(Quantity $other, string $op): void
    {
        if (!$this->unit->dimension->equals($other->unit->dimension)) {
            throw new \InvalidArgumentException("Cannot {$op}: units are dimensionally incompatible.");
        }
    }

    private static function combineSymbols(string $a, string $b, string $op): string
    {
        if ($op === '*') {
            return $a === $b ? $a . '²' : $a . '·' . $b;
        }

        // Division: identical symbols cancel to a dimensionless quantity.
        return $a === $b ? '' : $a . '/' . $b;
    }

    /** @return array{value: float, unit: string} */
    public function jsonSerialize(): array
    {
        return [
            'value' => $this->value,
            'unit' => $this->unit->symbolString(),
        ];
    }

    public function __toString(): string
    {
        return $this->format();
    }
}
