<?php

namespace SmartDato\DhlParcel\Data\Responses;

use Spatie\LaravelData\Data;

class RequestStatusData extends Data
{
    public function __construct(
        public string $title,
        public int $statusCode,
        public ?int $status = null,
        public ?string $detail = null,
        public ?string $instance = null,
    ) {}
}
