<?php

declare(strict_types=1);

namespace App\Modules\CoreModule\Actions;

use App\Modules\CoreModule\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Cambia el estado de activación de un usuario e invalida sesiones si se desactiva.
 * [UC-ADM-03] Activar / desactivar usuario
 */
class ToggleUserStatusAction
{
    public function execute(User $user, bool $status): void
    {
        DB::transaction(function () use ($user, $status) {
            $user->update(['is_active' => $status]);

            if (!$status) {
                // [RIESGO] Inconsistencia al desactivar -> Mitigar invalidando tokens
                $user->tokens()->delete();
                // Si usas sesiones de base de datos, podrías borrarlas aquí
            }
        });
    }
}
