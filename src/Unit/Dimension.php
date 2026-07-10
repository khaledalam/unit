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

    public function power(int $exponent): Dimension
    {
        $result = [];
        foreach ($this->exponents as $key => $val) {
            $result[$key] = $val * $exponent;
        }
        return new Dimension($result);
    }

    /**
     * @throws \InvalidArgumentException when an exponent is not divisible by $degree.
     */
    public function root(int $degree): Dimension
    {
        if ($degree < 1) {
            throw new \InvalidArgumentException('Root degree must be >= 1.');
        }

        $result = [];
        foreach ($this->exponents as $key => $val) {
            if ($val % $degree !== 0) {
                throw new \InvalidArgumentException(
                    "Cannot take root {$degree} of dimension: exponent for '{$key}' is not divisible."
                );
            }
            $result[$key] = intdiv($val, $degree);
        }
        return new Dimension($result);
    }

    public function isDimensionless(): bool
    {
        return $this->exponents === [];
    }

    /**
     * Human-readable name of a common physical dimension, or null if unrecognized.
     */
    public function name(): ?string
    {
        return match ((string) $this) {
            '[]' => 'dimensionless',
            '{"L":1}' => 'length',
            '{"M":1}' => 'mass',
            '{"T":1}' => 'time',
            '{"Θ":1}' => 'temperature',
            '{"L":2}' => 'area',
            '{"L":3}' => 'volume',
            '{"L":1,"T":-1}' => 'velocity',
            '{"L":1,"T":-2}' => 'acceleration',
            '{"L":1,"M":1,"T":-2}' => 'force',
            '{"L":2,"M":1,"T":-2}' => 'energy',
            '{"L":2,"M":1,"T":-3}' => 'power',
            '{"L":-1,"M":1,"T":-2}' => 'pressure',
            '{"T":-1}' => 'frequency',
            '{"B":1}' => 'data',
            '{"A":1}' => 'angle',
            default => null,
        };
    }

    public function __toString(): string
    {
        return json_encode($this->exponents, JSON_UNESCAPED_UNICODE) ?: '{}';
    }
}
