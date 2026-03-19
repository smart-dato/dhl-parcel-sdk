<?php

namespace SmartDato\DhlParcel\Enums;

enum Endorsement: string
{
    case Return = 'RETURN';
    case Abandon = 'ABANDON';
}
