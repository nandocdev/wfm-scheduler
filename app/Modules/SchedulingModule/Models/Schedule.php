<?php

namespace App\Modules\SchedulingModule\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model {
    use HasUlids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name', 'start_time', 'end_time', 'lunch_minutes',
        'break_minutes', 'total_minutes', 'is_active'
    ];

    protected $casts = [
        'start_time' => 'string', // HH:mm:ss
        'end_time' => 'string',
        'is_active' => 'boolean',
    ];

    public function breakTemplates(): HasMany {
        return $this->hasMany(BreakTemplate::class);
    }
}
