<?php

namespace App\Modules\OrganizationModule\Models;

use App\Modules\CoreModule\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo para TeamMembers (Miembros de Equipo).
 *
 * Representa la pertenencia histórica de empleados a equipos.
 */
class TeamMember extends Model {
    use Auditable;

    protected $fillable = [
        'team_id',
        'employee_id',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Equipo al que pertenece este miembro.
     */
    public function team(): BelongsTo {
        return $this->belongsTo(Team::class);
    }

    /**
     * Empleado que es miembro del equipo.
     */
    public function employee(): BelongsTo {
        return $this->belongsTo(\App\Modules\EmployeesModule\Models\Employee::class);
    }
}
