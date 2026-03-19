<?php

namespace SmartDato\DhlParcel\Data\Orders;

use Spatie\LaravelData\Data;

class LockerData extends Data
{
    public function __construct(
        public string $name,
        public int $lockerID,
        public string $postNumber,
        public string $postalCode,
        public string $city,
        public ?string $country = null,
    ) {}
}
