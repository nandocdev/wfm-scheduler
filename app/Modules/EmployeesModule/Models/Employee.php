<?php

namespace App\Modules\EmployeesModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'employee_number', 'username', 'first_name', 'last_name', 'email', 
        'birth_date', 'gender', 'blood_type', 'phone', 'mobile_phone', 'address',
        'township_id', 'department_id', 'position_id', 'employment_status_id', 
        'parent_id', 'user_id', 'hire_date', 'salary', 'is_active', 'is_manager', 'metadata'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'hire_date' => 'date',
        'salary' => 'decimal:2',
        'is_active' => 'boolean',
        'is_manager' => 'boolean',
        'metadata' => 'array',
    ];

    // Relaciones Fundacionales
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\CoreModule\Models\User::class);
    }

    public function township(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\LocationModule\Models\Township::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\OrganizationModule\Models\Department::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\OrganizationModule\Models\Position::class);
    }

    public function employmentStatus(): BelongsTo
    {
        return $this->belongsTo(EmploymentStatus::class);
    }

    // Jerarquía Operativa (Adjacency List)
    public function manager(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'parent_id');
    }

    public function subordinates(): HasMany
    {
        return $this->hasMany(Employee::class, 'parent_id');
    }

    // Detalles del Empleado
    public function positions(): HasMany
    {
        return $this->hasMany(EmployeePosition::class);
    }

    public function dependents(): HasMany
    {
        return $this->hasMany(EmployeeDependent::class);
    }

    public function diseases(): HasMany
    {
        return $this->hasMany(EmployeeDisease::class);
    }

    public function disabilities(): HasMany
    {
        return $this->hasMany(EmployeeDisability::class);
    }
}
