<?php

namespace App\Modules\WorkflowsModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeaveRequest extends Model
{
    protected $fillable = ['employee_id', 'type', 'start_time', 'end_time', 'status', 'reason'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\EmployeesModule\Models\Employee::class);
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(LeaveRequestApproval::class);
    }
}
