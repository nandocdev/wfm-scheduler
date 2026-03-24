<?php

namespace App\Modules\OrganizationModule\Livewire;

use App\Modules\OrganizationModule\Actions\ToggleTeamStatusAction;
use App\Modules\OrganizationModule\Models\Team;
use Livewire\Component;

/**
 * Componente Livewire para mostrar los detalles de un equipo.
 */
class ShowTeam extends Component {
    public Team $team;

    public function mount(Team $team): void {
        $this->authorize('view', $team);
        $this->team = $team->load('users');
    }

    /**
     * Cambia el estado activo/inactivo del equipo.
     */
    public function toggleStatus(): void {
        $this->authorize('update', $this->team);

        $action = new ToggleTeamStatusAction();
        $this->team = $action->execute($this->team);

        session()->flash('success',
            $this->team->is_active
            ? 'Equipo activado exitosamente.'
            : 'Equipo desactivado exitosamente.'
        );

        $this->dispatch('teamStatusToggled');
    }

    public function render() {
        return view('organization::livewire.show-team');
    }
}
