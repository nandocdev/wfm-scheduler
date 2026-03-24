<?php

declare(strict_types=1);

namespace App\Modules\CoreModule\Actions;

use App\Modules\CoreModule\Models\Role;
use Illuminate\Support\Facades\DB;

/**
 * Sincroniza permisos asignados a un rol institucional.
 * [UC-ADM-05] Gestionar permisos
 */
class SyncRolePermissionsAction
{
    public function execute(Role $role, array $permissions): void
    {
        DB::transaction(function () use ($role, $permissions) {
            // Sincronización atómica de permisos vía Spatie
            $role->syncPermissions($permissions);
        });
    }
}
