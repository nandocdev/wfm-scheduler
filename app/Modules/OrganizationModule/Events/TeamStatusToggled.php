<?php

namespace App\Modules\OrganizationModule\Events;

use App\Modules\OrganizationModule\Models\Team;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Evento disparado cuando el estado de un equipo cambia.
 */
class TeamStatusToggled {
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly Team $team
    ) {
    }
}
