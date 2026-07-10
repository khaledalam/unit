<?php

namespace KhaledAlam\Unit\Laravel;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\ServiceProvider;
use KhaledAlam\Unit\Unit;
use KhaledAlam\Unit\UnitRegistry;

/**
 * Registers the package with Laravel.
 *
 * Common units are already available (they auto-register via the package's
 * Composer `autoload.files`). This provider lets an application register extra
 * custom units through config, e.g.:
 *
 *   // config/unit.php
 *   return [
 *       'units' => [
 *           new \KhaledAlam\Unit\Unit('yard', 'yd', 0.9144, new \KhaledAlam\Unit\Dimension(['L' => 1])),
 *       ],
 *   ];
 */
final class UnitServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        /** @var Repository $config */
        $config = $this->app->make('config');

        $units = $config->get('unit.units', []);

        foreach (is_array($units) ? $units : [] as $unit) {
            if ($unit instanceof Unit) {
                UnitRegistry::register($unit);
            }
        }
    }
}
