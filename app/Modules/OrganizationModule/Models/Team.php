<?php

namespace App\Modules\OrganizationModule\Models;

use App\Modules\CoreModule\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Modelo para Teams (Equipos).
 *
 * Representa los equipos de trabajo.
 */
class Team extends Model {
    use Auditable;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Miembros del equipo.
     */
    public function members(): HasMany {
        return $this->hasMany(TeamMember::class);
    }

    /**
     * Empleados activos en el equipo (a través de miembros).
     */
    public function users(): HasManyThrough {
        return $this->hasManyThrough(
            \App\Modules\EmployeesModule\Models\Employee::class,
            TeamMember::class,
            'team_id', // Foreign key on TeamMember table
            'id', // Foreign key on Employee table
            'id', // Local key on Team table
            'employee_id' // Local key on TeamMember table
        )->where('team_members.is_active', true);
    }
}
