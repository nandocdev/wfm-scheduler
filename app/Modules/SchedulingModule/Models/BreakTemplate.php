<?php

declare(strict_types=1);

namespace App\Modules\SchedulingModule\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BreakTemplate extends Model {
    use HasFactory;

    protected $table = 'break_templates';

    /** @var array<int, string> */
    protected $fillable = [
        'schedule_id',
        'name',
        'start_time',
        'duration_minutes',
        'is_active',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'start_time' => 'string',
        'duration_minutes' => 'integer',
        'is_active' => 'boolean',
    ];

    public function schedule(): BelongsTo {
        return $this->belongsTo(Schedule::class);
    }
}
