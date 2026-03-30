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
        return $user->hasPermissionTo('employees.view')
            || $user->hasPermissionTo('employees.view.others')
            || $user->hasPermissionTo('employees.view.all');
    }

    /**
     * Determina si el usuario puede ver un empleado específico.
     * Aplica scoping por team_id.
     */
    public function view(User $user, Employee $employee): bool {
        if ($user->hasPermissionTo('employees.view.all')) {
            return true;
        }

        if ($this->isOwn($user, $employee)) {
            return $user->hasPermissionTo('employees.view');
        }

        if ($this->isInSameTeam($user, $employee)) {
            return $user->hasPermissionTo('employees.view.others');
        }

        return false;
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
        if ($user->hasPermissionTo('employees.edit.all')) {
            return true;
        }

        if ($this->isOwn($user, $employee)) {
            return $user->hasPermissionTo('employees.edit');
        }

        if ($this->isInSameTeam($user, $employee)) {
            return $user->hasPermissionTo('employees.edit.others');
        }

        return false;
    }

    /**
     * Determina si el usuario puede eliminar un empleado.
     * Aplica scoping por team_id.
     */
    public function delete(User $user, Employee $employee): bool {
        if ($user->hasPermissionTo('employees.delete.all')) {
            return true;
        }

        if ($this->isOwn($user, $employee)) {
            return $user->hasPermissionTo('employees.delete');
        }

        if ($this->isInSameTeam($user, $employee)) {
            return $user->hasPermissionTo('employees.delete.others');
        }

        return false;
    }

    /**
     * Eliminación permanente (hard delete) restringida a alto privilegio.
     */
    public function forceDelete(User $user, Employee $employee): bool {
        if ($user->hasPermissionTo('employees.force_delete.all')) {
            return true;
        }

        if ($this->isOwn($user, $employee)) {
            return $user->hasPermissionTo('employees.force_delete');
        }

        if ($this->isInSameTeam($user, $employee)) {
            return $user->hasPermissionTo('employees.force_delete.others');
        }

        return false;
    }

    /**
     * Aplica scoping a la consulta para limitar resultados por team_id.
     */
    public function scopeForUser(User $user, Builder $query): Builder {
        // Si el usuario tiene permisos globales, no aplicar filtro
        if ($user->hasPermissionTo('employees.view.all') ||
            $user->hasPermissionTo('employees.edit.all') ||
            $user->hasPermissionTo('employees.delete.all') ||
            $user->hasPermissionTo('employees.force_delete.all')) {
            return $query;
        }

        // Si el usuario tiene un empleado asociado, filtrar por su team
        if ($user->employee) {
            $teamId = $user->employee->team_id;
            if ($teamId) {
                return $query->where('team_id', $teamId);
            }
        }

        // Si no tiene empleado asociado o team, no mostrar nada
        return $query->whereRaw('1 = 0');
    }

    /**
     * Verifica si el usuario y el empleado están en el mismo team.
     */
    private function isInSameTeam(User $user, Employee $employee): bool {
        if (!$user->employee || !$user->employee->team_id || !$employee->team_id) {
            return false;
        }

        return $user->employee->team_id === $employee->team_id;
    }

    /**
     * Identifica si el empleado corresponde al usuario autenticado.
     */
    private function isOwn(User $user, Employee $employee): bool {
        return (int) ($user->employee?->id ?? 0) === (int) $employee->id;
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

    /**
     * Permisos efectivos considerando jerarquía de rol y override de admin.
     *
     * @return array<string, mixed>
     */
    public function effectivePermissions(User $user, ?Employee $employee = null): array {
        $hierarchyLevel = (int) ($user->roles->max('hierarchy_level') ?? 0);
        $isAdminOverride = $user->hasRole('admin') || $hierarchyLevel >= 99;

        if ($isAdminOverride) {
            return [
                'scope' => 'all',
                'hierarchy_level' => $hierarchyLevel,
                'admin_override' => true,
                'can_view' => true,
                'can_create' => true,
                'can_update' => true,
                'can_delete' => true,
                'can_force_delete' => true,
                'can_export' => true,
            ];
        }

        $target = $employee ?? new Employee(['team_id' => $user->employee?->team_id]);
        $isOwn = $employee ? $this->isOwn($user, $employee) : false;
        $isSameTeam = $employee ? $this->isInSameTeam($user, $employee) : (bool) $user->employee?->team_id;

        $scope = 'none';
        if ($user->hasPermissionTo('employees.view.all')) {
            $scope = 'all';
        } elseif ($isOwn && $user->hasPermissionTo('employees.view')) {
            $scope = 'own';
        } elseif ($isSameTeam && $user->hasPermissionTo('employees.view.others')) {
            $scope = 'others';
        }

        return [
            'scope' => $scope,
            'hierarchy_level' => $hierarchyLevel,
            'admin_override' => false,
            'can_view' => $employee ? $this->view($user, $target) : $this->viewAny($user),
            'can_create' => $this->create($user),
            'can_update' => $employee ? $this->update($user, $target) : $user->hasPermissionTo('employees.edit') || $user->hasPermissionTo('employees.edit.others') || $user->hasPermissionTo('employees.edit.all'),
            'can_delete' => $employee ? $this->delete($user, $target) : $user->hasPermissionTo('employees.delete') || $user->hasPermissionTo('employees.delete.others') || $user->hasPermissionTo('employees.delete.all'),
            'can_force_delete' => $employee ? $this->forceDelete($user, $target) : $user->hasPermissionTo('employees.force_delete') || $user->hasPermissionTo('employees.force_delete.others') || $user->hasPermissionTo('employees.force_delete.all'),
            'can_export' => $this->export($user),
        ];
    }
}
