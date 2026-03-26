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
            // Desactivar cualquier asignación activa previa del empleado que NO sea al equipo destino
            TeamMember::where('employee_id', $dto->employee_id)
                ->where('is_active', true)
                ->where('team_id', '!=', $dto->team_id)
                ->update([
                    'is_active' => false,
                    'left_at' => $dto->joined_at,
                    'updated_at' => now(),
                ]);

            // Crear o actualizar la asignación al equipo destino
            return TeamMember::updateOrCreate(
                [
                    'team_id' => $dto->team_id,
                    'employee_id' => $dto->employee_id,
                    'joined_at' => $dto->joined_at,
                ],
                [
                    'left_at' => $dto->left_at,
                    'is_active' => true,
                    'updated_at' => now(),
                ]
            );
        });
    }
}
