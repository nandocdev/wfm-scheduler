<?php

namespace App\Modules\EmployeesModule\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\EmployeesModule\Actions\CreateEmployeeAction;
use App\Modules\EmployeesModule\Actions\UpdateEmployeeAction;
use App\Modules\EmployeesModule\DTOs\CreateEmployeeDTO;
use App\Modules\EmployeesModule\DTOs\UpdateEmployeeDTO;
use App\Modules\EmployeesModule\Http\Requests\StoreEmployeeRequest;
use App\Modules\EmployeesModule\Http\Requests\UpdateEmployeeRequest;
use App\Modules\EmployeesModule\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Controlador para gestión de empleados.
 * Solo orquestación: valida → action → response
 *
 * @module EmployeesModule
 * @type Controller
 * @author GitHub Copilot
 * @created 2026-03-25
 */
class EmployeeController extends Controller {
    /**
     * Muestra la lista de empleados.
     */
    public function index(): View {
        // La lógica de filtrado se implementará en el Livewire component
        return view('employees::index');
    }

    /**
     * Muestra el formulario para crear un empleado.
     */
    public function create(): View {
        return view('employees::create');
    }

    /**
     * Almacena un nuevo empleado.
     */
    public function store(
        StoreEmployeeRequest $request,
        CreateEmployeeAction $action,
    ): RedirectResponse {
        $dto = CreateEmployeeDTO::fromArray($request->validated());
        $employee = $action->execute($dto);

        return redirect()
            ->route('employees.show', $employee)
            ->with('success', 'Empleado creado correctamente.');
    }

    /**
     * Muestra los detalles de un empleado.
     */
    public function show(Employee $employee): View {
        return view('employees::show', compact('employee'));
    }

    /**
     * Muestra el formulario para editar un empleado.
     */
    public function edit(Employee $employee): View {
        return view('employees::edit', compact('employee'));
    }

    /**
     * Actualiza un empleado existente.
     */
    public function update(
        UpdateEmployeeRequest $request,
        Employee $employee,
        UpdateEmployeeAction $action,
    ): RedirectResponse {
        $dto = UpdateEmployeeDTO::fromArray($request->validated());
        $updatedEmployee = $action->execute($employee, $dto);

        return redirect()
            ->route('employees.show', $updatedEmployee)
            ->with('success', 'Empleado actualizado correctamente.');
    }

    /**
     * Elimina un empleado (soft delete).
     */
    public function destroy(Employee $employee): RedirectResponse {
        $this->authorize('delete', $employee);

        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Empleado eliminado correctamente.');
    }
}
