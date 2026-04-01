<?php

namespace App\Modules\SchedulingModule\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftActivity extends Model {
    use HasFactory;

    protected $table = 'shift_activities';

    protected $fillable = [
        'shift_id',
        'activity_type',
        'start_slot',
        'end_slot',
        'description',
        'created_by',
    ];

    protected $casts = [
        'start_slot' => 'integer',
        'end_slot' => 'integer',
    ];

    public function shift() {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
}
