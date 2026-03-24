<?php

namespace App\Modules\OrganizationModule\Livewire;

use App\Modules\OrganizationModule\Actions\CreateTeamAction;
use App\Modules\OrganizationModule\DTOs\TeamDTO;
use Livewire\Component;

/**
 * Componente Livewire para crear un nuevo equipo.
 *
 * Maneja validación del formulario y delega creación a CreateTeamAction.
 */
class CreateTeam extends Component {
    public string $name = '';
    public ?string $description = '';
    public bool $is_active = true;

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
    public function save(): void {
        $this->authorize('create', \App\Modules\OrganizationModule\Models\Team::class);

        $validated = $this->validate();

        $dto = TeamDTO::fromArray($validated);
        $action = new CreateTeamAction();
        $team = $action->execute($dto);

        session()->flash('success', 'Equipo creado exitosamente.');

        $this->dispatch('teamCreated', teamId: $team->id);

        // Resetear formulario
        $this->reset();
    }

    public function render() {
        return view('organization::livewire.create-team');
    }
}
