<?php

namespace SmartDato\DhlParcel\Data\Manifests;

use SmartDato\DhlParcel\Data\Responses\RequestStatusData;
use Spatie\LaravelData\Data;

class ShortResponseItemData extends Data
{
    public function __construct(
        public RequestStatusData $sstatus,
        public ?string $shipmentNo = null,
    ) {}
}
