<?php

namespace SmartDato\DhlParcel\Data\Orders;

use Spatie\LaravelData\Data;

class ShipperReferenceData extends Data
{
    public function __construct(
        public string $shipperRef,
    ) {}
}
