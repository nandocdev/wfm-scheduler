<?php

namespace App\Modules\OrganizationModule\Livewire;

use App\Modules\OrganizationModule\Actions\UpdateTeamAction;
use App\Modules\OrganizationModule\DTOs\TeamDTO;
use App\Modules\OrganizationModule\Models\Team;
use Livewire\Component;

/**
 * Componente Livewire para editar un equipo existente.
 */
class EditTeam extends Component {
    public Team $team;
    public string $name = '';
    public ?string $description = '';
    public bool $is_active = true;

    public function mount(Team $team): void {
        $this->authorize('update', $team);
        $this->team = $team;

        $this->name = $team->name;
        $this->description = $team->description;
        $this->is_active = $team->is_active;
    }

    /**
     * Reglas de validación del formulario.
     */
    protected function rules(): array {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['boolean'],
        ];
    }

    /**
     * Mensajes de validación personalizados.
     */
    protected function validationAttributes(): array {
        return [
            'name' => 'nombre',
            'description' => 'descripción',
            'is_active' => 'estado activo',
        ];
    }

    /**
     * Maneja el envío del formulario.
     */
    public function save() {
        $this->authorize('update', $this->team);

        $validated = $this->validate();

        $dto = TeamDTO::fromArray($validated);
        $action = new UpdateTeamAction();
        $this->team = $action->execute($this->team, $dto);

        session()->flash('success', 'Equipo actualizado exitosamente.');

        $this->dispatch('teamUpdated', teamId: $this->team->id);

        return $this->redirect(route('organization.teams.show', $this->team));
    }

    public function render() {
        return view('organization::livewire.edit-team')
            ->layout('layouts.app');
    }
}
