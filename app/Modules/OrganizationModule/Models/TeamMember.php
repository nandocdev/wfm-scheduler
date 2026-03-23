<?php

namespace App\Modules\OrganizationModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMember extends Model
{
    protected $fillable = ['team_id', 'employee_id', 'joined_at', 'left_at', 'is_active'];

    protected $casts = [
        'joined_at' => 'date',
        'left_at' => 'date',
        'is_active' => 'boolean',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function employee(): BelongsTo
    {
        // Importación FQCN dinámica para evitar dependencias circulares directas si es posible, 
        // pero aquí es estándar modular referenciar por namespace completo.
        return $this->belongsTo(\App\Modules\EmployeesModule\Models\Employee::class);
    }
}
