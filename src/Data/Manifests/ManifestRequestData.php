<?php

namespace SmartDato\DhlParcel\Data\Manifests;

use Spatie\LaravelData\Data;

class ManifestRequestData extends Data
{
    /**
     * @param array<int, string>|null $shipmentNumbers
     */
    public function __construct(
        public string $profile,
        public ?array $shipmentNumbers = null,
        public ?string $billingNumber = null,
    ) {}
}
