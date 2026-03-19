<?php

namespace SmartDato\DhlParcel\Data\Orders;

use Spatie\LaravelData\Data;

class VasDhlRetoureData extends Data
{
    public function __construct(
        public string $billingNumber,
        public ?string $refNo = null,
        public ?ContactAddressData $returnAddress = null,
        public ?bool $goGreenPlus = null,
    ) {}
}
