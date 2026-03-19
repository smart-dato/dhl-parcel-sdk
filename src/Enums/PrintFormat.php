<?php

namespace SmartDato\DhlParcel\Enums;

enum PrintFormat: string
{
    case A4 = 'A4';
    case P910_300_600 = '910-300-600';
    case P910_300_610 = '910-300-610';
    case P910_300_700 = '910-300-700';
    case P910_300_700_Oz = '910-300-700-oz';
    case P910_300_710 = '910-300-710';
    case P910_300_300 = '910-300-300';
    case P910_300_300_Oz = '910-300-300-oz';
    case P910_300_400 = '910-300-400';
    case P910_300_410 = '910-300-410';
    case P100x70mm = '100x70mm';
}
