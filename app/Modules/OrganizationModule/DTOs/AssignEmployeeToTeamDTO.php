<?php

namespace App\Modules\OrganizationModule\DTOs;

/**
 * Datos de entrada validados para asignar un empleado a un equipo.
 */
readonly class AssignEmployeeToTeamDTO {
    public function __construct(
        public int $employee_id,
        public int $team_id,
        public string $start_date,
        public ?string $end_date = null,
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
            start_date: $data['start_date'],
            end_date: $data['end_date'] ?? null,
        );
    }
}
