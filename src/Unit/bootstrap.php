<?php

/**
 * Default unit registry bootstrap.
 *
 * Loaded automatically via Composer's "autoload.files", so every unit listed in
 * the {@see \KhaledAlam\Unit\Name} enum is usable immediately after
 * `composer require khaledalam/unit` — no manual registration required.
 *
 * The registration logic lives in {@see \KhaledAlam\Unit\DefaultUnits} so it can
 * be tested and re-run against a cleared registry.
 */

use KhaledAlam\Unit\DefaultUnits;

DefaultUnits::register();
