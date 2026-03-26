<?php

namespace App\Modules\OrganizationModule\Actions;

use App\Modules\OrganizationModule\DTOs\TeamDTO;
use App\Modules\OrganizationModule\Models\Team;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

/**
 * Crea un nuevo equipo en el sistema.
 *
 * @throws \Illuminate\Database\QueryException
 */
class CreateTeamAction {
    /**
     * Ejecuta la creación del equipo.
     *
     * @param  TeamDTO  $dto  Datos validados del equipo
     * @return Team           Equipo creado y persistido
     */
    public function execute(TeamDTO $dto): Team {
        return DB::transaction(function () use ($dto) {
            return Team::create([
                'name' => $dto->name,
                'description' => $dto->description,
                'supervisor_id' => $dto->supervisor_id,
                'is_active' => $dto->is_active,
            ]);
        });
    }
}
