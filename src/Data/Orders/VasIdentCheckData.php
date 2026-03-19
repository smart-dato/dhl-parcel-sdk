<?php

namespace SmartDato\DhlParcel\Data\Orders;

use SmartDato\DhlParcel\Enums\VisualCheckOfAge;
use Spatie\LaravelData\Data;

class VasIdentCheckData extends Data
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public ?string $dateOfBirth = null,
        public ?VisualCheckOfAge $minimumAge = null,
    ) {}
}
