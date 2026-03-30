<?php

declare(strict_types=1);

namespace App\Modules\CoreModule\Actions;

use App\Modules\CoreModule\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Acción para eliminar un usuario mediante SoftDeletes.
 */
class DeleteUserAction
{
    public function execute(User $user): void
    {
        DB::transaction(function () use ($user) {
            $user->delete();
        });
    }
}
