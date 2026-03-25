<?php

namespace App\Modules\EmployeesModule\Livewire;

use App\Modules\EmployeesModule\Actions\UpdateEmployeeAction;
use App\Modules\EmployeesModule\DTOs\UpdateEmployeeDTO;
use App\Modules\EmployeesModule\Http\Requests\UpdateEmployeeRequest;
use App\Modules\EmployeesModule\Models\Employee;
use App\Modules\LocationModule\Models\Location;
use App\Modules\OrganizationModule\Models\Team;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

/**
 * Componente Livewire para editar empleados.
 *
 * @module EmployeesModule
 * @type Livewire Component
 * @author AI Assistant
 * @created 2024-01-15
 */
class EditEmployee extends Component {
    public Employee $employee;

    // Campos del formulario
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public ?string $phone = null;
    public ?string $birth_date = null;
    public string $gender = '';
    public string $position = '';
    public string $department = '';
    public string $hire_date = '';
    public float $salary = 0;
    public string $contract_type = '';
    public string $work_schedule = '';
    public int $location_id = 0;
    public ?int $manager_id = null;
    public int $team_id = 0;
    public bool $is_active = true;

    // Opciones para selects
    public Collection $locations;
    public Collection $teams;
    public Collection $possibleManagers;

    /**
     * Inicializa el componente con los datos del empleado.
     */
    public function mount(Employee $employee): void {
        $this->employee = $employee;

        // Cargar datos del empleado
        $this->first_name = $employee->first_name;
        $this->last_name = $employee->last_name;
        $this->email = $employee->email;
        $this->phone = $employee->phone;
        $this->birth_date = $employee->birth_date?->format('Y-m-d');
        $this->gender = $employee->gender;
        $this->position = $employee->position;
        $this->department = $employee->department;
        $this->hire_date = $employee->hire_date->format('Y-m-d');
        $this->salary = $employee->salary;
        $this->contract_type = $employee->contract_type;
        $this->work_schedule = $employee->work_schedule;
        $this->location_id = $employee->location_id;
        $this->manager_id = $employee->manager_id;
        $this->team_id = $employee->team_id;
        $this->is_active = $employee->is_active;

        // Cargar opciones
        $this->loadOptions();
    }

    /**
     * Carga las opciones para los selects.
     */
    private function loadOptions(): void {
        $this->locations = Location::active()->orderBy('name')->get();
        $this->teams = Team::active()->orderBy('name')->get();

        // Posibles managers: empleados activos del mismo equipo, excluyendo al empleado actual
        $this->possibleManagers = Employee::where('team_id', $this->team_id)
            ->where('is_active', true)
            ->where('id', '!=', $this->employee->id)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
    }

    /**
     * Actualiza las opciones cuando cambia el equipo.
     */
    public function updatedTeamId(): void {
        $this->manager_id = null; // Reset manager selection
        $this->loadOptions();
    }

    /**
     * Valida y actualiza el empleado.
     */
    public function update(): void {
        // Crear el Form Request para validación
        $request = new UpdateEmployeeRequest();
        $request->merge([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'birth_date' => $this->birth_date,
            'gender' => $this->gender,
            'position' => $this->position,
            'department' => $this->department,
            'hire_date' => $this->hire_date,
            'salary' => $this->salary,
            'contract_type' => $this->contract_type,
            'work_schedule' => $this->work_schedule,
            'location_id' => $this->location_id,
            'manager_id' => $this->manager_id,
            'team_id' => $this->team_id,
            'is_active' => $this->is_active,
        ]);

        $validated = $request->validateResolved();

        // Crear DTO y ejecutar Action
        $dto = UpdateEmployeeDTO::fromArray($validated);
        $action = new UpdateEmployeeAction();
        $updatedEmployee = $action->execute($this->employee, $dto);

        // Notificar éxito y redirigir
        session()->flash('success', 'Empleado actualizado correctamente.');
        $this->redirect(route('employees.show', $updatedEmployee), navigate: true);
    }

    /**
     * Renderiza el componente.
     */
    public function render() {
        return view('employees::edit-employee');
    }
}
