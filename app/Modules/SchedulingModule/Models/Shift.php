<?php

declare(strict_types=1);

namespace App\Modules\SchedulingModule\Models;

use App\Modules\SchedulingModule\Enums\ShiftStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shift extends Model {
    use HasFactory;

    protected $table = 'shifts';

    protected $fillable = [
        'weekly_schedule_assignment_id',
        'employee_id',
        'date',
        'start_time',
        'end_time',
        'break_start',
        'lunch_start',
        'status',
        'published_at',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'time',
        'end_time' => 'time',
        'break_start' => 'time',
        'lunch_start' => 'time',
        'status' => ShiftStatus::class,
        'published_at' => 'datetime',
    ];

    public function employee(): BelongsTo {
        return $this->belongsTo(\App\Modules\EmployeesModule\Models\Employee::class, 'employee_id');
    }

    public function weeklyAssignment(): BelongsTo {
        return $this->belongsTo(WeeklyScheduleAssignment::class, 'weekly_schedule_assignment_id');
    }

    public function activities(): HasMany {
        return $this->hasMany(ShiftActivity::class, 'shift_id');
    }
}
