<?php

namespace App\Modules\SchedulingModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeBreakOverride extends Model
{
    protected $fillable = [
        'weekly_schedule_assignment_id', 'start_time', 
        'duration_minutes', 'reason'
    ];

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(WeeklyScheduleAssignment::class, 'weekly_schedule_assignment_id');
    }
}
