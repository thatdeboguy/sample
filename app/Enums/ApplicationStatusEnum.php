<?php


namespace App\Enums;

enum ApplicationStatusEnum: string {
    case REVIEWED = 'reviewed';

    case NOT_REVIEWED = 'not_reviewed';
}