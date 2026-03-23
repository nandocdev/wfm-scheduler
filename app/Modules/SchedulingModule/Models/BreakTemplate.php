<?php

namespace App\Modules\SchedulingModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BreakTemplate extends Model
{
    protected $fillable = ['schedule_id', 'name', 'start_time', 'duration_minutes'];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }
}
