<?php

declare(strict_types=1);

namespace App\Modules\SchedulingModule\Enums;

enum ShiftStatus: string {
    case Draft = 'draft';
    case Published = 'published';
    case Modified = 'modified';
    case Cancelled = 'cancelled';
}
