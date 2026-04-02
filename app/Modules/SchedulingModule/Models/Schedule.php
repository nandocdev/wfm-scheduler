<?php

declare(strict_types=1);

namespace App\Modules\SchedulingModule\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'start_time', 'end_time', 'lunch_minutes',
        'break_minutes', 'total_minutes', 'is_active'
    ];

    protected $casts = [
        'start_time' => 'string',
        'end_time' => 'string',
        'is_active' => 'boolean',
    ];

    public function breakTemplates(): HasMany
    {
        return $this->hasMany(BreakTemplate::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(WeeklyScheduleAssignment::class);
    }
}
