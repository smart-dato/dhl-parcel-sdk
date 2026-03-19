<?php

namespace SmartDato\DhlParcel\Data\Orders;

use Spatie\LaravelData\Data;

class CommodityData extends Data
{
    public function __construct(
        public string $itemDescription,
        public int $packagedQuantity,
        public ValueData $itemValue,
        public WeightData $itemWeight,
        public ?string $countryOfOrigin = null,
        public ?string $hsCode = null,
    ) {}
}
