<?php

namespace App\Modules\SchedulingModule\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BreakTemplate extends Model {
    use HasUlids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['schedule_id', 'name', 'start_time', 'duration_minutes'];

    protected $casts = [
        'duration_minutes' => 'integer',
    ];

    public function schedule(): BelongsTo {
        return $this->belongsTo(Schedule::class);
    }
}
