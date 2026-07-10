<?php

namespace KhaledAlam\Unit;

final readonly class Dimension
{
    /** @var array<string, int> */
    public array $exponents;

    /**
     * @param array<string, int> $exponents Map of base-dimension symbol (e.g. "L") to its exponent.
     */
    public function __construct(array $exponents = [])
    {
        // Drop zero exponents so cancelled dimensions compare equal (e.g. m/s·s === m).
        $exponents = array_filter($exponents, static fn (int $exp): bool => $exp !== 0);
        ksort($exponents);
        $this->exponents = $exponents;
    }

    public function equals(Dimension $other): bool
    {
        return $this->exponents === $other->exponents;
    }

    public function multiply(Dimension $other): Dimension
    {
        $result = $this->exponents;
        foreach ($other->exponents as $key => $val) {
            $result[$key] = ($result[$key] ?? 0) + $val;
        }
        return new Dimension($result);
    }

    public function divide(Dimension $other): Dimension
    {
        $result = $this->exponents;
        foreach ($other->exponents as $key => $val) {
            $result[$key] = ($result[$key] ?? 0) - $val;
        }
        return new Dimension($result);
    }

    public function isDimensionless(): bool
    {
        return $this->exponents === [];
    }

    public function __toString(): string
    {
        return json_encode($this->exponents) ?: '{}';
    }
}
