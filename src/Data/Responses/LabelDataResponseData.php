<?php

namespace SmartDato\DhlParcel\Data\Responses;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class LabelDataResponseData extends Data
{
    /**
     * @param  array<int, ResponseItemData>|null  $items
     */
    public function __construct(
        public ?RequestStatusData $status = null,
        #[DataCollectionOf(ResponseItemData::class)]
        public ?array $items = null,
    ) {}
}
