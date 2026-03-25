<?php

namespace App\Modules\OrganizationModule\Actions;

use App\Modules\OrganizationModule\DTOs\RemoveEmployeeFromTeamDTO;
use App\Modules\OrganizationModule\Models\TeamMember;
use Illuminate\Support\Facades\DB;

/**
 * Remueve un empleado de un equipo desactivando su asignación activa.
 *
 * @throws \Illuminate\Database\QueryException
 */
class RemoveEmployeeFromTeamAction {
    /**
     * Ejecuta la remoción del empleado del equipo.
     *
     * @param  RemoveEmployeeFromTeamDTO  $dto  Datos validados de la remoción
     * @return TeamMember                  Registro de asignación actualizado
     */
    public function execute(RemoveEmployeeFromTeamDTO $dto): TeamMember {
        return DB::transaction(function () use ($dto) {
            /** @var TeamMember $teamMember */
            $teamMember = TeamMember::where('team_id', $dto->team_id)
                ->where('employee_id', $dto->employee_id)
                ->where('is_active', true)
                ->firstOrFail();

            $teamMember->update([
                'is_active' => false,
                'end_date' => $dto->end_date,
            ]);

            return $teamMember;
        });
    }
}
