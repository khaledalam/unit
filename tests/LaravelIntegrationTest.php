<?php

namespace KhaledAlam\Unit\Tests;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use KhaledAlam\Unit\Dimension;
use KhaledAlam\Unit\Laravel\AsQuantity;
use KhaledAlam\Unit\Laravel\UnitServiceProvider;
use KhaledAlam\Unit\Quantity;
use KhaledAlam\Unit\Unit;
use KhaledAlam\Unit\UnitRegistry;
use PHPUnit\Framework\TestCase;

final class LaravelIntegrationTest extends TestCase
{
    protected function setUp(): void
    {
        if (!class_exists(Model::class) || !class_exists(Container::class)) {
            $this->markTestSkipped('illuminate packages are not installed.');
        }
    }

    public function test_service_provider_registers_custom_units_from_config(): void
    {
        $furlong = new Unit('furlong', 'fur', 201.168, new Dimension(['L' => 1]));

        $container = new Container();
        $container->instance('config', new class ($furlong) {
            /** @param Unit $furlong */
            public function __construct(private $furlong)
            {
            }

            public function get(string $key, mixed $default = null): mixed
            {
                return $key === 'unit.units' ? [$this->furlong, 'not-a-unit'] : $default;
            }
        });

        (new UnitServiceProvider($container))->boot();

        $this->assertTrue(UnitRegistry::has('fur'));
        $this->assertEqualsWithDelta(
            201.168,
            Quantity::of(1, 'fur')->convertTo('m')->getValue(),
            1e-9
        );
    }

    public function test_cast_round_trips_a_quantity(): void
    {
        $cast = new AsQuantity();
        $model = new class extends Model {
        };

        // set() from a Quantity
        $stored = $cast->set($model, 'distance', Quantity::of(2.5, 'km'), []);
        $this->assertSame(['distance' => '2.5 km'], $stored);

        // set() from a string (parsed + normalized)
        $fromString = $cast->set($model, 'distance', '5 ft 3 in', []);
        $this->assertSame(['distance' => '5.25 ft'], $fromString);

        // set() null
        $this->assertSame(['distance' => null], $cast->set($model, 'distance', null, []));

        // get() hydrates a Quantity
        $quantity = $cast->get($model, 'distance', '2.5 km', []);
        $this->assertInstanceOf(Quantity::class, $quantity);
        $this->assertSame('2500 m', (string) $quantity->to('m'));

        // get() null / empty
        $this->assertNull($cast->get($model, 'distance', null, []));
        $this->assertNull($cast->get($model, 'distance', '', []));

        // get() passes through an existing Quantity
        $existing = Quantity::of(1, 'm');
        $this->assertSame($existing, $cast->get($model, 'distance', $existing, []));
    }

    public function test_cast_set_rejects_invalid_type(): void
    {
        $cast = new AsQuantity();
        $model = new class extends Model {
        };

        $this->expectException(\InvalidArgumentException::class);
        $cast->set($model, 'distance', 123, []);
    }
}
