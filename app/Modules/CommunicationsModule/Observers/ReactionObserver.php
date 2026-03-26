<?php

declare(strict_types=1);

namespace App\Modules\CommunicationsModule\Observers;

use App\Modules\CommunicationsModule\Models\Reaction;
use Illuminate\Support\Facades\Cache;

/**
 * Observa el ciclo de vida del modelo Reaction.
 * Maneja efectos secundarios como caché y limpieza.
 */
class ReactionObserver {
    public function created(Reaction $reaction): void {
        Cache::tags(['reactions', "shoutout:{$reaction->shoutout_id}"])->flush();
    }

    public function updated(Reaction $reaction): void {
        Cache::tags(['reactions', "shoutout:{$reaction->shoutout_id}"])->flush();
    }

    public function deleted(Reaction $reaction): void {
        Cache::tags(['reactions', "shoutout:{$reaction->shoutout_id}"])->flush();
    }
}
