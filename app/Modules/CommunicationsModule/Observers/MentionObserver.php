<?php

declare(strict_types=1);

namespace App\Modules\CommunicationsModule\Observers;

use App\Modules\CommunicationsModule\Models\Mention;
use Illuminate\Support\Facades\Cache;

/**
 * Observa el ciclo de vida del modelo Mention.
 * Maneja efectos secundarios como caché y limpieza.
 */
class MentionObserver {
    public function created(Mention $mention): void {
        Cache::tags(['mentions', "user:{$mention->mentioned_user_id}"])->flush();
    }

    public function updated(Mention $mention): void {
        Cache::tags(['mentions', "user:{$mention->mentioned_user_id}"])->flush();
    }

    public function deleted(Mention $mention): void {
        Cache::tags(['mentions', "user:{$mention->mentioned_user_id}"])->flush();
    }
}
