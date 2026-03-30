<?php

declare(strict_types=1);

namespace App\Modules\CoreModule\Listeners;

use App\Modules\CoreModule\Models\User;
use Illuminate\Auth\Events\Login;

/**
 * Actualiza la marca de último acceso exitoso del usuario.
 */
final class UpdateLastLoginAtListener {
    public function handle(Login $event): void {
        if (!$event->user instanceof User) {
            return;
        }

        $event->user->forceFill([
            'last_login_at' => now(),
        ])->saveQuietly();
    }
}
