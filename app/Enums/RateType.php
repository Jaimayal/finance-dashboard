<?php

namespace App\Enums;

enum RateType: string
{
    case AMOUNT = 'amount';
    case TERM = 'term';
    case NONE = 'none';
}
