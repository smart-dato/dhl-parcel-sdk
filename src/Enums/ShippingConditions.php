<?php

namespace SmartDato\DhlParcel\Enums;

enum ShippingConditions: string
{
    case Dap = 'DAP';
    case Ddp = 'DDP';
}
