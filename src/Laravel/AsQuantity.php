<?php

namespace KhaledAlam\Unit\Laravel;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use KhaledAlam\Unit\Quantity;

/**
 * Eloquent cast that stores a {@see Quantity} as a human-readable string
 * (e.g. "2 m") and hydrates it back into a Quantity on access.
 *
 * Usage:
 *   protected function casts(): array
 *   {
 *       return ['distance' => AsQuantity::class];
 *   }
 *
 * @implements CastsAttributes<Quantity, Quantity|string>
 */
final class AsQuantity implements CastsAttributes
{
    /**
     * @param array<string, mixed> $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?Quantity
    {
        if ($value instanceof Quantity) {
            return $value;
        }

        return is_string($value) && $value !== '' ? Quantity::parse($value) : null;
    }

    /**
     * @param array<string, mixed> $attributes
     * @return array<string, string|null>
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if ($value === null) {
            return [$key => null];
        }

        if ($value instanceof Quantity) {
            return [$key => (string) $value];
        }

        if (is_string($value)) {
            return [$key => (string) Quantity::parse($value)];
        }

        throw new \InvalidArgumentException(
            'AsQuantity expects a Quantity or string, got ' . get_debug_type($value) . '.'
        );
    }
}
