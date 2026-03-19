<?php

namespace SmartDato\DhlParcel\Data\Orders;

use Spatie\LaravelData\Data;

class POBoxData extends Data
{
    public function __construct(
        public string $name1,
        public int $poBoxID,
        public string $postalCode,
        public string $city,
        public ?string $name2 = null,
        public ?string $name3 = null,
        public ?string $email = null,
        public ?string $country = null,
    ) {}
}
