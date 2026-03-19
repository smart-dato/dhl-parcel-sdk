<?php

namespace SmartDato\DhlParcel\Data\Orders;

use Spatie\LaravelData\Data;

class ShipperData extends Data
{
    public function __construct(
        public string $name1,
        public string $addressStreet,
        public string $city,
        public string $country,
        public ?string $name2 = null,
        public ?string $name3 = null,
        public ?string $addressHouse = null,
        public ?string $postalCode = null,
        public ?string $contactName = null,
        public ?string $email = null,
    ) {}
}
