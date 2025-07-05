<?php

namespace KhaledAlam;

use KhaledAlam\Unit\Dimension; 
use KhaledAlam\Unit\Name;
use Stringable;

final readonly class Unit implements Stringable
{
    public string $name;
    public Name|string $symbol;
    public float $factor;
    public Dimension $dimension;

    public function __construct(
        string $name,
        Name|string $symbol,
        float $factor,
        Dimension $dimension
    ) {
        $this->name = $name;
        $this->symbol = $symbol;
        $this->factor = $factor;
        $this->dimension = $dimension;
    }

    public function __toString(): string
    {
        return $this->symbol->__toString();
    }
}
