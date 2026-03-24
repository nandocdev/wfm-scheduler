<?php

namespace App\Modules\OrganizationModule\Observers;

use App\Modules\OrganizationModule\Models\Team;
use Illuminate\Support\Facades\Cache;

/**
 * Observa el ciclo de vida del modelo Team.
 * Solo efectos secundarios: caché, logs, sincronizaciones externas.
 * NO contiene lógica de negocio (esa va en Actions).
 */
class TeamObserver {
    public function created(Team $team): void {
        Cache::tags(['organization'])->flush();
    }

    public function updated(Team $team): void {
        Cache::forget("team:{$team->id}");
    }

    public function deleted(Team $team): void {
        Cache::forget("team:{$team->id}");
    }
}