<?php

namespace SmartDato\DhlParcel\Data\Manifests;

use SmartDato\DhlParcel\Data\Responses\DocumentData;
use SmartDato\DhlParcel\Data\Responses\RequestStatusData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class SingleManifestResponseData extends Data
{
    /**
     * @param  array<int, DocumentData>|null  $manifest
     * @param  array<int, array{billingNumber: string, sheetNo: string}>|null  $sheetNo
     * @param  array<int, array{shipmentNo: string, sheetNo: string}>|null  $items
     */
    public function __construct(
        public ?RequestStatusData $status = null,
        public ?string $manifestDate = null,
        #[DataCollectionOf(DocumentData::class)]
        public ?array $manifest = null,
        public ?array $sheetNo = null,
        public ?array $items = null,
    ) {}
}
