<?php

namespace SmartDato\DhlParcel\Data\Orders;

use Spatie\LaravelData\Data;

class PostOfficeData extends Data
{
    public function __construct(
        public string $name,
        public int $retailID,
        public string $postalCode,
        public string $city,
        public ?string $postNumber = null,
        public ?string $email = null,
        public ?string $country = null,
    ) {}
}
