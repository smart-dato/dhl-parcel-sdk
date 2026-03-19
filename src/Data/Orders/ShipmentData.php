<?php

namespace SmartDato\DhlParcel\Data\Orders;

use SmartDato\DhlParcel\Enums\Product;
use Spatie\LaravelData\Data;

class ShipmentData extends Data
{
    public function __construct(
        public Product $product,
        public string $billingNumber,
        public ShipmentDetailsData $details,
        public ShipperData|ShipperReferenceData $shipper,
        public ContactAddressData|LockerData|PostOfficeData|POBoxData $consignee,
        public ?string $refNo = null,
        public ?string $costCenter = null,
        public ?string $creationSoftware = null,
        public ?string $shipDate = null,
        public ?VasData $services = null,
        public ?CustomsDetailsData $customs = null,
    ) {}
}
