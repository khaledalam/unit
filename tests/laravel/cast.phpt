--TEST--
Laravel AsQuantity Eloquent cast round-trips quantities
--SKIPIF--
<?php
require_once __DIR__ . '/../include.inc';
if (!class_exists(\Illuminate\Database\Eloquent\Model::class)) {
    echo 'skip illuminate/database not installed';
}
?>
--FILE--
<?php
require_once __DIR__ . '/../include.inc';

use Illuminate\Database\Eloquent\Model;
use KhaledAlam\Unit\Laravel\AsQuantity;
use KhaledAlam\Unit\Quantity;

$model = new class extends Model {
    protected $guarded = [];
    public function casts(): array
    {
        return ['distance' => AsQuantity::class];
    }
};

$model->distance = Quantity::of(2.5, 'km');
echo $model->getAttributes()['distance'] . "\n";      // stored string
echo $model->distance->to('m') . "\n";                 // hydrated + converted

$model->distance = '5 ft 3 in';
echo $model->getAttributes()['distance'] . "\n";       // parsed + stored
echo $model->distance->humanize()->format(4) . "\n";   // hydrated + humanized

$model->distance = null;
var_dump($model->distance);
?>
--EXPECT--
2.5 km
2500 m
5.25 ft
1.6002 m
NULL
