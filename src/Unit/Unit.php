<?php

namespace KhaledAlam\Unit;

use Stringable;

final readonly class Unit implements Stringable
{
    public string $name;
    public Name|string $symbol;
    public float $factor;
    public Dimension $dimension;

    /**
     * @param string      $name      Human-readable name (e.g. "Meter").
     * @param Name|string $symbol    Display symbol (enum case, or raw string for derived units).
     * @param float       $factor    Multiplicative factor to the dimension's base unit.
     * @param Dimension   $dimension Physical dimension of the unit.
     * @param float       $offset    Additive offset to the base unit, applied after $factor.
     *                               Needed for affine scales such as °C and °F.
     */
    public function __construct(
        string $name,
        Name|string $symbol,
        float $factor,
        Dimension $dimension,
        public float $offset = 0.0,
    ) {
        $this->name = $name;
        $this->symbol = $symbol;
        $this->factor = $factor;
        $this->dimension = $dimension;
    }

    public function symbolString(): string
    {
        return $this->symbol instanceof Name
            ? $this->symbol->value
            : (string) $this->symbol;
    }

    public function __toString(): string
    {
        return $this->symbolString();
    }
}
