<?php

namespace App\Modules\SchedulingModule\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'published_at' => 'datetime',
    ];

    public function employee() {
        return $this->belongsTo(\App\Modules\EmployeesModule\Models\Employee::class, 'employee_id');
    }

    public function weeklyAssignment() {
        return $this->belongsTo(\App\Modules\SchedulingModule\Models\WeeklyScheduleAssignment::class, 'weekly_schedule_assignment_id');
    }

    public function activities() {
        return $this->hasMany(ShiftActivity::class, 'shift_id');
    }
}
