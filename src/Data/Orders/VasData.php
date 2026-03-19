<?php

namespace SmartDato\DhlParcel\Data\Orders;

use SmartDato\DhlParcel\Enums\Endorsement;
use SmartDato\DhlParcel\Enums\VisualCheckOfAge;
use Spatie\LaravelData\Data;

class VasData extends Data
{
    public function __construct(
        public ?string $preferredNeighbour = null,
        public ?string $preferredLocation = null,
        public ?VisualCheckOfAge $visualCheckOfAge = null,
        public ?bool $namedPersonOnly = null,
        public ?VasIdentCheckData $identCheck = null,
        public ?bool $signedForByRecipient = null,
        public ?Endorsement $endorsement = null,
        public ?string $preferredDay = null,
        public ?bool $noNeighbourDelivery = null,
        public ?ValueData $additionalInsurance = null,
        public ?bool $bulkyGoods = null,
        public ?VasCashOnDeliveryData $cashOnDelivery = null,
        public ?string $individualSenderRequirement = null,
        public ?bool $premium = null,
        public ?bool $closestDropPoint = null,
        public ?string $parcelOutletRouting = null,
        public ?bool $goGreenPlus = null,
        public ?VasDhlRetoureData $dhlRetoure = null,
        public ?bool $postalDeliveryDutyPaid = null,
    ) {}
}
