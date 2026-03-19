<?php

namespace SmartDato\DhlParcel\Data\Orders;

use SmartDato\DhlParcel\Enums\DimensionUom;
use Spatie\LaravelData\Data;

class DimensionsData extends Data
{
    public function __construct(
        public DimensionUom $uom,
        public int $height,
        public int $length,
        public int $width,
    ) {}
}
