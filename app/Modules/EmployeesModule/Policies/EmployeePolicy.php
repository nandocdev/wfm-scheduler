<?php

namespace App\Modules\EmployeesModule\Policies;

use App\Modules\EmployeesModule\Models\Employee;
use App\Modules\CoreModule\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Define los permisos de acceso al recurso Employee.
 * Incluye scoping por team_id para acceso restringido.
 *
 * @module EmployeesModule
 * @type Policy
 * @author GitHub Copilot
 * @created 2026-03-25
 */
class EmployeePolicy {
    /**
     * Determina si el usuario puede ver cualquier empleado.
     */
    public function viewAny(User $user): bool {
        return $user->hasPermissionTo('employees.view');
    }

    /**
     * Determina si el usuario puede ver un empleado específico.
     * Aplica scoping por team_id.
     */
    public function view(User $user, Employee $employee): bool {
        if (!$user->hasPermissionTo('employees.view')) {
            return false;
        }

        // Si el usuario tiene permiso global, puede ver todos
        if ($user->hasPermissionTo('employees.view.all')) {
            return true;
        }

        // Si no, solo puede ver empleados de su mismo team
        return $this->isInSameTeam($user, $employee);
    }

    /**
     * Determina si el usuario puede crear empleados.
     */
    public function create(User $user): bool {
        return $user->hasPermissionTo('employees.create');
    }

    /**
     * Determina si el usuario puede actualizar un empleado.
     * Aplica scoping por team_id.
     */
    public function update(User $user, Employee $employee): bool {
        if (!$user->hasPermissionTo('employees.edit')) {
            return false;
        }

        // Si el usuario tiene permiso global, puede editar todos
        if ($user->hasPermissionTo('employees.edit.all')) {
            return true;
        }

        // Si no, solo puede editar empleados de su mismo team
        return $this->isInSameTeam($user, $employee);
    }

    /**
     * Determina si el usuario puede eliminar un empleado.
     * Aplica scoping por team_id.
     */
    public function delete(User $user, Employee $employee): bool {
        if (!$user->hasPermissionTo('employees.delete')) {
            return false;
        }

        // Si el usuario tiene permiso global, puede eliminar todos
        if ($user->hasPermissionTo('employees.delete.all')) {
            return true;
        }

        // Si no, solo puede eliminar empleados de su mismo team
        return $this->isInSameTeam($user, $employee);
    }

    /**
     * Aplica scoping a la consulta para limitar resultados por team_id.
     */
    public function scopeForUser(User $user, Builder $query): Builder {
        // Si el usuario tiene permisos globales, no aplicar filtro
        if ($user->hasPermissionTo('employees.view.all') ||
            $user->hasPermissionTo('employees.edit.all') ||
            $user->hasPermissionTo('employees.delete.all')) {
            return $query;
        }

        // Si el usuario tiene un empleado asociado, filtrar por su team
        if ($user->employee) {
            $teamId = $user->employee->currentTeamMember?->team_id;
            if ($teamId) {
                return $query->whereHas('currentTeamMember', function ($q) use ($teamId) {
                    $q->where('team_id', $teamId)->where('is_active', true);
                });
            }
        }

        // Si no tiene empleado asociado o team, no mostrar nada
        return $query->whereRaw('1 = 0');
    }

    /**
     * Verifica si el usuario y el empleado están en el mismo team.
     */
    private function isInSameTeam(User $user, Employee $employee): bool {
        if (!$user->employee) {
            return false;
        }

        $userTeamId = $user->employee->currentTeamMember?->team_id;
        $employeeTeamId = $employee->currentTeamMember?->team_id;

        return $userTeamId && $userTeamId === $employeeTeamId;
    }

    /**
     * Determina si el usuario puede gestionar asignaciones de equipos.
     */
    public function manageTeamAssignments(User $user): bool {
        return $user->hasPermissionTo('teams.members.manage');
    }

    /**
     * Determina si el usuario puede exportar empleados.
     */
    public function export(User $user): bool {
        return $user->hasPermissionTo('employees.export');
    }
}
