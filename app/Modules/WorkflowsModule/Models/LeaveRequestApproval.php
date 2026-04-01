<?php

namespace App\Modules\WorkflowsModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveRequestApproval extends Model
{
    protected $fillable = ['leave_request_id', 'approver_id', 'status', 'comment', 'step_order'];

    public function request(): BelongsTo
    {
        return $this->belongsTo(LeaveRequest::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\EmployeesModule\Models\Employee::class, 'approver_id');
    }
}
