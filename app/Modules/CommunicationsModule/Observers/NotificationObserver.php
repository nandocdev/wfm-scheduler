<?php

declare(strict_types=1);

namespace App\Modules\CommunicationsModule\Observers;

use App\Modules\CommunicationsModule\Models\Notification;
use Illuminate\Support\Facades\Cache;

/**
 * Observa el ciclo de vida del modelo Notification.
 * Maneja efectos secundarios como caché y expiración automática.
 */
class NotificationObserver {
    public function created(Notification $notification): void {
        Cache::tags(['notifications', "user:{$notification->user_id}"])->flush();
    }

    public function updated(Notification $notification): void {
        Cache::tags(['notifications', "user:{$notification->user_id}"])->flush();
    }

    public function deleted(Notification $notification): void {
        Cache::tags(['notifications', "user:{$notification->user_id}"])->flush();
    }
}
