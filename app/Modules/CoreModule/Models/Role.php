<?php

namespace App\Modules\CoreModule\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'guard_name', 'code', 'hierarchy_level'])]
class Role extends SpatieRole
{
    /**
     * Modelo de Rol institucional extendido para soportar jerarquías operativas.
     */
}
