<?php

namespace SmartDato\DhlParcel\Data\Responses;

use Spatie\LaravelData\Data;

class ValidationMessageData extends Data
{
    public function __construct(
        public ?string $property = null,
        public ?string $validationMessage = null,
        public ?string $validationState = null,
    ) {}
}
