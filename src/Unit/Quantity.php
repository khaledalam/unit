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

    /**
     * Parse a human-readable string into a Quantity.
     *
     * Supports single values ("100 km/h", "-40 °C") and multi-segment inputs of
     * the same dimension ("5 ft 3 in"), which are summed. The result is expressed
     * in the first segment's unit.
     *
     * @throws \InvalidArgumentException on empty input, unknown units, or mixed dimensions.
     */
    public static function parse(string $input, ?int $precision = null): self
    {
        if (!preg_match_all('/([+-]?\d+(?:\.\d+)?)\s*([^\s\d]+)/u', $input, $matches, PREG_SET_ORDER)) {
            throw new \InvalidArgumentException("Could not parse a quantity from: \"{$input}\".");
        }

        $result = null;
        foreach ($matches as [, $value, $symbol]) {
            $part = self::from((float) $value, $symbol);
            $result = $result === null ? $part : $result->add($part);
        }

        /** @var self $result */
        return $precision === null ? $result : $result->withPrecision($precision);
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

    /**
     * Convert to the most readable unit in the same family (e.g. 1500 m -> 1.5 km).
     *
     * Picks the largest ladder unit whose value stays >= 1. Returns the quantity
     * unchanged when it has no ladder or uses an affine scale (e.g. temperature).
     */
    public function humanize(): self
    {
        if ($this->unit->offset !== 0.0) {
            return $this;
        }

        foreach (self::humanizeLadders() as $symbols) {
            if (!UnitRegistry::has($symbols[0])) {
                continue;
            }
            if (!UnitRegistry::get($symbols[0])->dimension->equals($this->unit->dimension)) {
                continue;
            }

            $base = $this->toBase();
            $chosen = $symbols[0];
            foreach ($symbols as $symbol) {
                $candidate = UnitRegistry::get($symbol);
                if (abs($base / $candidate->factor) >= 1.0) {
                    $chosen = $symbol;
                } else {
                    break;
                }
            }

            return $this->convertTo($chosen);
        }

        return $this;
    }

    /**
     * Ladders of unit symbols (smallest to largest) used by {@see self::humanize()}.
     *
     * @return list<list<string>>
     */
    private static function humanizeLadders(): array
    {
        return [
            ['mm', 'cm', 'm', 'km'],
            ['mg', 'g', 'kg', 't'],
            ['ms', 's', 'min', 'h', 'd'],
            ['mL', 'L', 'm³'],
            ['cm²', 'm²', 'km²'],
            ['B', 'KB', 'MB', 'GB', 'TB'],
        ];
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
