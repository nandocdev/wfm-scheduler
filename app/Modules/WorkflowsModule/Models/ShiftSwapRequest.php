<?php

namespace App\Modules\WorkflowsModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShiftSwapRequest extends Model
{
    protected $fillable = ['requester_id', 'recipient_id', 'requested_date', 'status', 'reason'];

    protected $casts = [
        'requested_date' => 'date',
    ];

    public function requester(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\EmployeesModule\Models\Employee::class, 'requester_id');
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\EmployeesModule\Models\Employee::class, 'recipient_id');
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(ShiftSwapApproval::class);
    }
}
