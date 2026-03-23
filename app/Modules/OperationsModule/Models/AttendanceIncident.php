<?php

namespace App\Modules\OperationsModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceIncident extends Model
{
    protected $fillable = [
        'employee_id', 'incident_type_id', 'incident_date', 
        'start_time', 'end_time', 'user_comment', 'admin_comment'
    ];

    protected $casts = [
        'incident_date' => 'date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\EmployeesModule\Models\Employee::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(IncidentType::class, 'incident_type_id');
    }
}
