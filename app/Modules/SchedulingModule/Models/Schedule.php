<?php

namespace App\Modules\SchedulingModule\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'name', 'start_time', 'end_time', 'lunch_minutes', 
        'break_minutes', 'total_minutes', 'is_active'
    ];

    protected $casts = [
        'start_time' => 'string', // HH:mm:ss
        'end_time' => 'string',
        'is_active' => 'boolean',
    ];
}
