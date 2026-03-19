<?php

namespace SmartDato\DhlParcel\Data\Manifests;

use SmartDato\DhlParcel\Data\Responses\RequestStatusData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class MultipleManifestResponseData extends Data
{
    /**
     * @param  array<int, ShortResponseItemData>|null  $items
     */
    public function __construct(
        public ?RequestStatusData $status = null,
        #[DataCollectionOf(ShortResponseItemData::class)]
        public ?array $items = null,
    ) {}
}
