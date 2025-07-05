<?php

namespace KhaledAlam\Unit;

final readonly class Dimension
{
    public array $exponents;

    public function __construct(array $exponents = [])
    {
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

    public function __toString(): string
    {
        return json_encode($this->exponents);
    }
}
