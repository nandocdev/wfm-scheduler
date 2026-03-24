<?php

namespace App\Modules\OrganizationModule\Models;

use App\Modules\CoreModule\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo para Positions (Cargos).
 *
 * Representa los cargos dentro de un departamento.
 */
class Position extends Model {
    use Auditable;

    protected $fillable = [
        'department_id',
        'title',
        'description',
        'position_code',
    ];

    /**
     * Departamento al que pertenece este cargo.
     */
    public function department(): BelongsTo {
        return $this->belongsTo(Department::class);
    }
}
