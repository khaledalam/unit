<?php

use KhaledAlam\Unit\Dimension;  
use KhaledAlam\Unit;
use KhaledAlam\Unit\UnitRegistry;
use KhaledAlam\Unit\Name;

// Length
UnitRegistry::register(new Unit(Name::M, Name::M, 1.0, new Dimension(['L' => 1])));
UnitRegistry::register(new Unit(Name::KM, Name::KM, 1000.0, new Dimension(['L' => 1])));
UnitRegistry::register(new Unit(Name::CM, Name::CM, 0.01, new Dimension(['L' => 1])));
UnitRegistry::register(new Unit(Name::MM, Name::MM, 0.001, new Dimension(['L' => 1])));
