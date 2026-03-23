<?php

namespace App\Modules\WorkflowsModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShiftSwapApproval extends Model
{
    protected $fillable = ['shift_swap_request_id', 'approver_id', 'status', 'comment', 'step_order'];

    public function request(): BelongsTo
    {
        return $this->belongsTo(ShiftSwapRequest::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\EmployeesModule\Models\Employee::class, 'approver_id');
    }
}
