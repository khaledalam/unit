<?php

namespace KhaledAlam\Unit\Tests;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\SQLitePlatform;
use Doctrine\DBAL\Types\Type;
use KhaledAlam\Unit\Doctrine\QuantityType;
use KhaledAlam\Unit\Quantity;
use PHPUnit\Framework\TestCase;

final class DoctrineTypeTest extends TestCase
{
    private QuantityType $type;
    private AbstractPlatform $platform;

    protected function setUp(): void
    {
        if (!class_exists(Type::class) || !class_exists(SQLitePlatform::class)) {
            $this->markTestSkipped('doctrine/dbal is not installed.');
        }

        if (!Type::hasType(QuantityType::NAME)) {
            Type::addType(QuantityType::NAME, QuantityType::class);
        }

        $type = Type::getType(QuantityType::NAME);
        $this->assertInstanceOf(QuantityType::class, $type);
        $this->type = $type;
        $this->platform = new SQLitePlatform();
    }

    public function test_to_database_value(): void
    {
        $this->assertSame('2.5 kg', $this->type->convertToDatabaseValue(Quantity::of(2.5, 'kg'), $this->platform));
        $this->assertSame('5.25 ft', $this->type->convertToDatabaseValue('5 ft 3 in', $this->platform));
        $this->assertNull($this->type->convertToDatabaseValue(null, $this->platform));
    }

    public function test_to_database_value_rejects_invalid_type(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->type->convertToDatabaseValue(123, $this->platform);
    }

    public function test_to_php_value(): void
    {
        $quantity = $this->type->convertToPHPValue('2.5 kg', $this->platform);
        $this->assertInstanceOf(Quantity::class, $quantity);
        $this->assertSame('2500 g', (string) $quantity->to('g'));

        $this->assertNull($this->type->convertToPHPValue(null, $this->platform));
        $this->assertNull($this->type->convertToPHPValue('', $this->platform));

        $existing = Quantity::of(1, 'm');
        $this->assertSame($existing, $this->type->convertToPHPValue($existing, $this->platform));
    }

    public function test_sql_declaration_is_a_string_column(): void
    {
        $sql = $this->type->getSQLDeclaration([], $this->platform);
        $this->assertStringContainsStringIgnoringCase('CHAR', $sql);
    }
}
