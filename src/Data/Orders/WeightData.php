<?php

namespace SmartDato\DhlParcel\Data\Orders;

use SmartDato\DhlParcel\Enums\WeightUom;
use Spatie\LaravelData\Data;

class WeightData extends Data
{
    public function __construct(
        public WeightUom $uom,
        public float $value,
    ) {}
}
