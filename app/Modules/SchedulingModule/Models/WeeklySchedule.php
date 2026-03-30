<?php

namespace App\Modules\SchedulingModule\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WeeklySchedule extends Model {
    use HasUlids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'start_date', 'end_date', 'status'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function assignments(): HasMany {
        return $this->hasMany(WeeklyScheduleAssignment::class);
    }
}
