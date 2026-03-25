<?php

namespace App\Modules\OrganizationModule\Actions;

use App\Modules\OrganizationModule\DTOs\AssignEmployeeToTeamDTO;
use App\Modules\OrganizationModule\Models\TeamMember;
use Illuminate\Support\Facades\DB;

/**
 * Asigna un empleado a un equipo creando un registro en team_members.
 *
 * @throws \Illuminate\Database\QueryException
 */
class AssignEmployeeToTeamAction {
    /**
     * Ejecuta la asignación del empleado al equipo.
     *
     * @param  AssignEmployeeToTeamDTO  $dto  Datos validados de la asignación
     * @return TeamMember               Registro de asignación creado
     */
    public function execute(AssignEmployeeToTeamDTO $dto): TeamMember {
        return DB::transaction(function () use ($dto) {
            // Desactivar cualquier asignación activa previa del empleado
            TeamMember::where('employee_id', $dto->employee_id)
                ->where('is_active', true)
                ->update([
                    'is_active' => false,
                    'end_date' => $dto->start_date,
                    'updated_at' => now(),
                ]);

            // Crear nueva asignación
            return TeamMember::create([
                'team_id' => $dto->team_id,
                'employee_id' => $dto->employee_id,
                'start_date' => $dto->start_date,
                'end_date' => $dto->end_date,
                'is_active' => true,
            ]);
        });
    }
}
