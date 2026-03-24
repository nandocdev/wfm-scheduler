<?php

namespace App\Modules\OrganizationModule\Events;

use App\Modules\OrganizationModule\Models\Team;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Evento disparado cuando un equipo es actualizado.
 */
class TeamUpdated {
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly Team $team
    ) {
    }
}
