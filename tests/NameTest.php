<?php

namespace KhaledAlam\Unit\Tests;

use KhaledAlam\Unit\Name;
use PHPUnit\Framework\TestCase;

final class NameTest extends TestCase
{
    /**
     * Exercises every arm of Name::label() so the mapping stays exhaustive.
     */
    public function test_every_case_has_a_non_empty_label(): void
    {
        foreach (Name::cases() as $case) {
            $label = $case->label();
            $this->assertNotSame('', $label, "Missing label for {$case->value}");
            $this->assertMatchesRegularExpression('/^[A-Z]/', $label);
        }
    }

    public function test_labels_are_unique(): void
    {
        $labels = array_map(static fn (Name $n): string => $n->label(), Name::cases());
        $this->assertSame(count($labels), count(array_unique($labels)));
    }

    public function test_specific_labels(): void
    {
        $this->assertSame('Meter', Name::M->label());
        $this->assertSame('Kilometer per hour', Name::KMH->label());
        $this->assertSame('Gibibyte', Name::GIB->label());
        $this->assertSame('Pound per square inch', Name::PSI->label());
    }
}
