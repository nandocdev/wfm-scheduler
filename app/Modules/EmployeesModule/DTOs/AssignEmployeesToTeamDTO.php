<?php

namespace App\Modules\EmployeesModule\DTOs;

/**
 * DTO para asignar empleados a un equipo.
 */
readonly class AssignEmployeesToTeamDTO {
    public function __construct(
        public int $teamId,
        public array $employeeIds,
    ) {
    }

    /**
     * Construye el DTO desde un array validado.
     */
    public static function fromArray(array $data): self {
        return new self(
            teamId: $data['team_id'],
            employeeIds: $data['employee_ids'] ?? [],
        );
    }
}
