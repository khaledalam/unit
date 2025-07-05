<?php

namespace KhaledAlam\Unit\Cache;

use KhaledAlam\Unit\Quantity;
use LogicException;

class QuantityCache
{
    private ?Quantity $value = null;

    public function get(): ?Quantity
    {
        return $this->value;
    }

    public function set(Quantity $value): void
    {
        if (!is_null($this->value)) {
            // @codeCoverageIgnoreStart
            throw new LogicException('Value is already set');
            // @codeCoverageIgnoreEnd
        }
        $this->value = $value;
    }
}
