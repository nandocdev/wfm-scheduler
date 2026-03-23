<?php

namespace App\Modules\SchedulingModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WeeklyScheduleAssignment extends Model
{
    protected $fillable = [
        'weekly_schedule_id', 'employee_id', 'schedule_id', 
        'assignment_date', 'is_manual'
    ];

    protected $casts = [
        'assignment_date' => 'date',
        'is_manual' => 'boolean',
    ];

    public function weeklySchedule(): BelongsTo
    {
        return $this->belongsTo(WeeklySchedule::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\EmployeesModule\Models\Employee::class);
    }

    public function overrides(): HasMany
    {
        return $this->hasMany(EmployeeBreakOverride::class);
    }
}
