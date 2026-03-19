<?php

namespace SmartDato\DhlParcel\Data\Orders;

use SmartDato\DhlParcel\Enums\ExportType;
use SmartDato\DhlParcel\Enums\ShippingConditions;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class CustomsDetailsData extends Data
{
    /**
     * @param  array<int, CommodityData>  $items
     */
    public function __construct(
        public ExportType $exportType,
        public ValueData $postalCharges,
        #[DataCollectionOf(CommodityData::class)]
        public array $items,
        public ?string $invoiceNo = null,
        public ?string $exportDescription = null,
        public ?ShippingConditions $shippingConditions = null,
        public ?string $permitNo = null,
        public ?string $attestationNo = null,
        public ?bool $hasElectronicExportNotification = null,
        public ?string $MRN = null,
        public ?string $officeOfOrigin = null,
        public ?string $shipperCustomsRef = null,
        public ?string $consigneeCustomsRef = null,
    ) {}
}
