<?php

namespace SmartDato\DhlParcel\Data\Orders;

use Spatie\LaravelData\Data;

class ValueData extends Data
{
    public function __construct(
        public string $currency,
        public float $value,
    ) {}
}
