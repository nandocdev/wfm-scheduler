<?php

namespace App\Modules\OrganizationModule\Models;

use App\Modules\CoreModule\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
