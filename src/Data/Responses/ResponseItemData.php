<?php

namespace SmartDato\DhlParcel\Data\Responses;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class ResponseItemData extends Data
{
    /**
     * @param  array<int, ValidationMessageData>|null  $validationMessages
     */
    public function __construct(
        public RequestStatusData $sstatus,
        public ?string $shipmentNo = null,
        public ?string $routingCode = null,
        public ?string $returnRoutingCode = null,
        public ?string $returnShipmentNo = null,
        public ?string $shipmentRefNo = null,
        public ?DocumentData $label = null,
        public ?DocumentData $returnLabel = null,
        public ?DocumentData $customsDoc = null,
        public ?DocumentData $codLabel = null,
        #[DataCollectionOf(ValidationMessageData::class)]
        public ?array $validationMessages = null,
    ) {}
}
