<?php

namespace App\Modules\EmployeesModule\Livewire;

use App\Modules\EmployeesModule\Models\Employee;
use App\Modules\OrganizationModule\Models\Department;
use App\Modules\OrganizationModule\Models\Position;
use App\Modules\OrganizationModule\Models\Team;
use App\Modules\EmployeesModule\Models\EmploymentStatus;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

/**
 * Componente Livewire para listar empleados con filtros.
 *
 * @module EmployeesModule
 * @type Livewire
 * @author GitHub Copilot
 * @created 2026-03-25
 */
class ListEmployees extends Component {
    use WithPagination;

    // Filtros
    public ?string $search = null;
    public ?int $department_id = null;
    public ?int $position_id = null;
    public ?int $employment_status_id = null;
    public ?bool $is_active = null;
    public ?bool $is_manager = null;

    // Configuración de paginación
    public int $perPage = 15;

    protected $queryString = [
        'search' => ['except' => null],
        'department_id' => ['except' => null],
        'position_id' => ['except' => null],
        'employment_status_id' => ['except' => null],
        'is_active' => ['except' => null],
        'is_manager' => ['except' => null],
    ];

    /**
     * Reinicia la paginación cuando cambian los filtros.
     */
    public function updated($property): void {
        if (in_array($property, ['search', 'department_id', 'position_id', 'employment_status_id', 'is_active', 'is_manager'])) {
            $this->resetPage();
        }
    }

    /**
     * Limpia todos los filtros.
     */
    public function clearFilters(): void {
        $this->search = null;
        $this->department_id = null;
        $this->position_id = null;
        $this->employment_status_id = null;
        $this->is_active = null;
        $this->is_manager = null;
        $this->resetPage();
    }

    /**
     * Obtiene los empleados con filtros aplicados.
     */
    public function getEmployeesProperty() {
        return Employee::query()
            ->with(['department', 'position', 'employmentStatus', 'township'])
            ->when($this->search, function (Builder $query) {
                $query->where(function (Builder $q) {
                    $q->where('first_name', 'ilike', "%{$this->search}%")
                        ->orWhere('last_name', 'ilike', "%{$this->search}%")
                        ->orWhere('employee_number', 'ilike', "%{$this->search}%")
                        ->orWhere('email', 'ilike', "%{$this->search}%");
                });
            })
            ->when($this->department_id, fn(Builder $query) => $query->where('department_id', $this->department_id))
            ->when($this->position_id, fn(Builder $query) => $query->where('position_id', $this->position_id))
            ->when($this->employment_status_id, fn(Builder $query) => $query->where('employment_status_id', $this->employment_status_id))
            ->when($this->is_active !== null, fn(Builder $query) => $query->where('is_active', $this->is_active))
            ->when($this->is_manager !== null, fn(Builder $query) => $query->where('is_manager', $this->is_manager))
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->paginate($this->perPage);
    }

    /**
     * Obtiene las opciones para los filtros.
     */
    public function getFilterOptionsProperty(): array {
        return [
            'departments' => Department::orderBy('name')->pluck('name', 'id'),
            'positions' => Position::orderBy('name')->pluck('name', 'id'),
            'employment_statuses' => EmploymentStatus::orderBy('name')->pluck('name', 'id'),
        ];
    }

    public function render() {
        return view('employees::livewire.list-employees', [
            'employees' => $this->employees,
            'filterOptions' => $this->filterOptions,
        ]);
    }
}
