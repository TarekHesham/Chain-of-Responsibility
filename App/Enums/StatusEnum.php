<?php

namespace App\Enums;

enum StatusEnum: string
{
    case PENDING = 'PENDING';
    case IN_PROGRESS = 'IN_PROGRESS';
    case RESOLVED = 'RESOLVED';
    case ESCALATED = 'ESCALATED';
}
