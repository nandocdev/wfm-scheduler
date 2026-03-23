<?php

namespace App\Modules\SchedulingModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WeeklySchedule extends Model
{
    protected $fillable = ['name', 'start_date', 'end_date', 'status'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function assignments(): HasMany
    {
        return $this->hasMany(WeeklyScheduleAssignment::class);
    }
}
