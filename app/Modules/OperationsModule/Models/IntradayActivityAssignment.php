<?php

namespace App\Modules\OperationsModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IntradayActivityAssignment extends Model
{
    protected $fillable = ['employee_id', 'intraday_activity_id', 'start_time', 'end_time', 'notes'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\EmployeesModule\Models\Employee::class);
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(IntradayActivity::class, 'intraday_activity_id');
    }
}
