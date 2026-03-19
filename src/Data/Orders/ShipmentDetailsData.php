<?php

namespace SmartDato\DhlParcel\Data\Orders;

use Spatie\LaravelData\Data;

class ShipmentDetailsData extends Data
{
    public function __construct(
        public WeightData $weight,
        public ?DimensionsData $dim = null,
    ) {}
}
