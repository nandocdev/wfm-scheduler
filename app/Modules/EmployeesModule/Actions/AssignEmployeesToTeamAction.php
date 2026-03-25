<?php

namespace App\Modules\EmployeesModule\Actions;

use App\Modules\EmployeesModule\DTOs\AssignEmployeesToTeamDTO;
use App\Modules\OrganizationModule\Models\Team;
use App\Modules\OrganizationModule\Models\TeamMember;
use Illuminate\Support\Facades\DB;

/**
 * Asigna empleados a un equipo.
 * Maneja bulk assignments y desassignments.
 */
class AssignEmployeesToTeamAction {
    /**
     * Asigna empleados a un equipo.
     */
    public function assign(AssignEmployeesToTeamDTO $dto): void {
        DB::transaction(function () use ($dto) {
            foreach ($dto->employeeIds as $employeeId) {
                // Marcar cualquier asignación previa como inactiva
                TeamMember::where('employee_id', $employeeId)
                    ->where('is_active', true)
                    ->update(['is_active' => false, 'left_at' => now()]);

                // Crear nueva asignación
                TeamMember::create([
                    'team_id' => $dto->teamId,
                    'employee_id' => $employeeId,
                    'joined_at' => now(),
                    'is_active' => true,
                ]);
            }
        });
    }

    /**
     * Desasigna empleados de un equipo.
     */
    public function unassign(AssignEmployeesToTeamDTO $dto): void {
        DB::transaction(function () use ($dto) {
            TeamMember::where('team_id', $dto->teamId)
                ->whereIn('employee_id', $dto->employeeIds)
                ->where('is_active', true)
                ->update(['is_active' => false, 'left_at' => now()]);
        });
    }
}
