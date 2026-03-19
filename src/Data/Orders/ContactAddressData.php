<?php

namespace SmartDato\DhlParcel\Data\Orders;

use Spatie\LaravelData\Data;

class ContactAddressData extends Data
{
    public function __construct(
        public string $name1,
        public string $addressStreet,
        public string $city,
        public string $country,
        public ?string $name2 = null,
        public ?string $name3 = null,
        public ?string $dispatchingInformation = null,
        public ?string $addressHouse = null,
        public ?string $additionalAddressInformation1 = null,
        public ?string $additionalAddressInformation2 = null,
        public ?string $postalCode = null,
        public ?string $state = null,
        public ?string $contactName = null,
        public ?string $phone = null,
        public ?string $email = null,
    ) {}
}
