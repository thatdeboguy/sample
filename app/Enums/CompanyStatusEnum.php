<?php

namespace App\Enums;

enum CompanyStatusEnum: string{
    case CONVERTED = 'converted';

    case NOT_CONVERTED = 'not_converted';
}