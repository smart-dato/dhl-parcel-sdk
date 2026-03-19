<?php

namespace SmartDato\DhlParcel\Data\Responses;

use Spatie\LaravelData\Data;

class DocumentData extends Data
{
    public function __construct(
        public ?string $b64 = null,
        public ?string $zpl2 = null,
        public ?string $url = null,
        public ?string $fileFormat = null,
        public ?string $printFormat = null,
    ) {}
}
