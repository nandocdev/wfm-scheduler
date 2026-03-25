<?php

namespace App\Modules\OrganizationModule\Models;

use App\Modules\CoreModule\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo para Positions (Cargos).
 *
 * Representa los cargos dentro de un departamento.
 */
class Position extends Model {
    use Auditable;

    protected $fillable = [
        'department_id',
        'name',
        'description',
        'position_code',
        'salary',
        'is_active',
    ];

    protected $casts = [
        'salary' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Departamento al que pertenece este cargo.
     */
    public function department(): BelongsTo {
        return $this->belongsTo(Department::class);
    }

    /**
     * Empleados que ocupan este cargo.
     */
    public function users(): HasMany {
        return $this->hasMany(\App\Modules\EmployeesModule\Models\Employee::class);
    }
}
