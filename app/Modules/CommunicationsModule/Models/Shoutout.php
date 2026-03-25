<?php

declare(strict_types=1);

namespace App\Modules\CommunicationsModule\Models;

use App\Modules\EmployeesModule\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo para Shoutouts.
 *
 * Representa reconocimientos cortos entre colaboradores.
 */
class Shoutout extends Model {
    protected $fillable = [
        'employee_id',
        'message',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Empleado reconocido.
     */
    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class);
    }
}
