<?php

namespace App\Modules\EmployeesModule\Livewire;

use App\Modules\EmployeesModule\Actions\AssignEmployeesToTeamAction;
use App\Modules\EmployeesModule\DTOs\AssignEmployeesToTeamDTO;
use App\Modules\EmployeesModule\Models\Employee;
use App\Modules\OrganizationModule\Models\Team;
use Livewire\Component;

/**
 * Gestiona la asignación de empleados a equipos.
 */
class ManageTeamAssignments extends Component {
    public int $selectedTeamId = 0;
    public array $selectedUnassigned = [];
    public array $selectedAssigned = [];

    protected $listeners = ['refresh' => '$refresh'];

    /**
     * Reglas de validación.
     */
    protected function rules(): array {
        return [
            'selectedTeamId' => 'required|exists:teams,id',
        ];
    }

    /**
     * Obtiene los equipos disponibles.
     */
    public function getTeamsProperty(): \Illuminate\Database\Eloquent\Collection {
        return Team::where('is_active', true)->orderBy('name')->get();
    }

    /**
     * Obtiene empleados sin asignar a ningún equipo.
     */
    public function getUnassignedEmployeesProperty(): \Illuminate\Database\Eloquent\Collection {
        return Employee::whereDoesntHave('currentTeamMember')
            ->where('is_active', true)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
    }

    /**
     * Obtiene empleados asignados al equipo seleccionado.
     */
    public function getAssignedEmployeesProperty(): \Illuminate\Database\Eloquent\Collection {
        if (!$this->selectedTeamId) {
            return collect();
        }

        return Employee::whereHas('currentTeamMember', function ($q) {
            $q->where('team_id', $this->selectedTeamId)->where('is_active', true);
        })
            ->where('is_active', true)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
    }

    /**
     * Asigna empleados seleccionados al equipo.
     */
    public function assignToTeam(): void {
        $this->validate();

        if (empty($this->selectedUnassigned)) {
            $this->addError('selectedUnassigned', 'Selecciona al menos un empleado para asignar.');
            return;
        }

        $dto = new AssignEmployeesToTeamDTO(
            teamId: $this->selectedTeamId,
            employeeIds: $this->selectedUnassigned
        );

        app(AssignEmployeesToTeamAction::class)->assign($dto);

        $this->selectedUnassigned = [];
        $this->dispatch('refresh');
        session()->flash('success', 'Empleados asignados al equipo correctamente.');
    }

    /**
     * Desasigna empleados seleccionados del equipo.
     */
    public function unassignFromTeam(): void {
        if (empty($this->selectedAssigned)) {
            $this->addError('selectedAssigned', 'Selecciona al menos un empleado para desasignar.');
            return;
        }

        $dto = new AssignEmployeesToTeamDTO(
            teamId: $this->selectedTeamId,
            employeeIds: $this->selectedAssigned
        );

        app(AssignEmployeesToTeamAction::class)->unassign($dto);
        $this->selectedAssigned = [];
        $this->dispatch('refresh');
        session()->flash('success', 'Empleados desasignados del equipo correctamente.');
    }

    /**
     * Renderiza el componente.
     */
    public function render() {
        return view('employees::manage-team-assignments', [
            'teams' => $this->teams,
            'unassignedEmployees' => $this->unassignedEmployees,
            'assignedEmployees' => $this->assignedEmployees,
        ]);
    }
}
