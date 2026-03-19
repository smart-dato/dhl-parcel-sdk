<?php

namespace SmartDato\DhlParcel\Data\Orders;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class ShipmentOrderRequestData extends Data
{
    /**
     * @param array<int, ShipmentData> $shipments
     */
    public function __construct(
        public string $profile,
        #[DataCollectionOf(ShipmentData::class)]
        public array $shipments,
    ) {}
}
