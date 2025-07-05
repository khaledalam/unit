<?php

namespace KhaledAlam\Unit;

use KhaledAlam\Unit\UnitRegistry;
use KhaledAlam\Unit\Unit;

final readonly class Quantity
{
    private float $value;
    private Unit $unit;
    private ?int $precision;

    public function __construct(float $value, Unit $unit, ?int $precision = null)
    {
        if ($precision !== null && $precision < 0) {
            throw new \InvalidArgumentException("Precision must be >= 0.");
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

    public function convertTo(string $symbol): self
    {
        $target = UnitRegistry::get($symbol);

        if (!$this->unit->dimension->equals($target->dimension)) {
            throw new \InvalidArgumentException("Cannot convert: units are dimensionally incompatible.");
        }

        $baseValue = $this->value * $this->unit->factor;
        $convertedValue = $baseValue / $target->factor;

        return new self($convertedValue, $target);
    }

    public function add(Quantity $other): self
    {
        if (!$this->unit->dimension->equals($other->unit->dimension)) {
            throw new \InvalidArgumentException("Cannot add: units are dimensionally incompatible.");
        }

        $thisBase = $this->value * $this->unit->factor;
        $otherBase = $other->value * $other->unit->factor;
        $sumBase = $thisBase + $otherBase;

        $sumValue = $sumBase / $this->unit->factor;

        return new self($sumValue, $this->unit);
    }

    public function subtract(Quantity $other): self
    {
        if (!$this->unit->dimension->equals($other->unit->dimension)) {
            throw new \InvalidArgumentException("Cannot subtract: units are dimensionally incompatible.");
        }

        $thisBase = $this->value * $this->unit->factor;
        $otherBase = $other->value * $other->unit->factor;
        $diffBase = $thisBase - $otherBase;

        $diffValue = $diffBase / $this->unit->factor;

        return new self($diffValue, $this->unit);
    }

    public function multiply(Quantity $other): self
    {
        $value = $this->value * $other->value;
        $newDimension = $this->unit->dimension->multiply($other->unit->dimension);
        $newSymbol = "{$this->unit->symbol->value}*{$other->unit->symbol->value}";
        $newUnit = new Unit("derived", $newSymbol, 1.0, $newDimension);

        return new self($value, $newUnit);
    }

    public function divide(Quantity $other): self
    {
        $value = $this->value / $other->value;
        $newDimension = $this->unit->dimension->divide($other->unit->dimension);
        $newSymbol = "{$this->unit->symbol->value}/{$other->unit->symbol->value}";
        $newUnit = new Unit("derived", $newSymbol, 1.0, $newDimension);

        return new self($value, $newUnit);
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getUnit(): Unit
    {
        return $this->unit;
    }

    public function __toString(): string
    {

        $valueStr = $this->precision !== null
            ? number_format($this->value, $this->precision, '.', '')
            : (string) $this->value;


        $symbolStr = is_object($this->unit->symbol)
            ? $this->unit->symbol->value
            : (string) $this->unit->symbol;

        return $valueStr . ' ' . $symbolStr;
    }




}
