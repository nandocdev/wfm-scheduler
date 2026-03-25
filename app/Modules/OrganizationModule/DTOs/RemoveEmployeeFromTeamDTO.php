<?php

namespace App\Modules\OrganizationModule\DTOs;

/**
 * Datos de entrada validados para remover un empleado de un equipo.
 */
readonly class RemoveEmployeeFromTeamDTO {
    public function __construct(
        public int $employee_id,
        public int $team_id,
        public string $end_date,
    ) {
    }

    /**
     * Construye el DTO desde un array validado (Form Request).
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self {
        return new self(
            employee_id: $data['employee_id'],
            team_id: $data['team_id'],
            end_date: $data['end_date'],
        );
    }
}
