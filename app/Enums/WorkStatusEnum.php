<?php

namespace App\Enums;

enum WorkStatusEnum: string {
    case PUBLISHED = 'published';

    case NOT_PUBLISHED = 'not_published';
}