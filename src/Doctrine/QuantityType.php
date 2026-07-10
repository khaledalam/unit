<?php

namespace KhaledAlam\Unit\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use KhaledAlam\Unit\Quantity;

/**
 * Doctrine DBAL type that persists a {@see Quantity} as a human-readable string
 * (e.g. "2.5 kg") and hydrates it back into a Quantity.
 *
 * Register it once (e.g. in a Symfony bundle boot or bootstrap):
 *
 *   use Doctrine\DBAL\Types\Type;
 *   use KhaledAlam\Unit\Doctrine\QuantityType;
 *
 *   Type::addType(QuantityType::NAME, QuantityType::class);
 *
 * Then map a column with `#[ORM\Column(type: 'quantity')]`.
 *
 * Requires doctrine/dbal ^4.
 */
final class QuantityType extends Type
{
    public const NAME = 'quantity';

    /**
     * @param array<string, mixed> $column
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Quantity
    {
        if ($value instanceof Quantity) {
            return $value;
        }

        return is_string($value) && $value !== '' ? Quantity::parse($value) : null;
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Quantity) {
            return (string) $value;
        }

        if (is_string($value)) {
            return (string) Quantity::parse($value);
        }

        throw new \InvalidArgumentException(
            'QuantityType expects a Quantity or string, got ' . get_debug_type($value) . '.'
        );
    }
}
