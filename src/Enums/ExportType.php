<?php

namespace SmartDato\DhlParcel\Enums;

enum ExportType: string
{
    case Other = 'OTHER';
    case Present = 'PRESENT';
    case CommercialSample = 'COMMERCIAL_SAMPLE';
    case Document = 'DOCUMENT';
    case ReturnOfGoods = 'RETURN_OF_GOODS';
    case CommercialGoods = 'COMMERCIAL_GOODS';
}
