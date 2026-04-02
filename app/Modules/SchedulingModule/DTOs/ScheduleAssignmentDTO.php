<?php

declare(strict_types=1);

namespace App\Modules\SchedulingModule\DTOs;

readonly class ScheduleAssignmentDTO {
    public function __construct(
        public string $employee_id,
        public string $weekly_schedule_id,
        public string $schedule_id,
        public string $assignment_date,
        public bool $is_manual = false,
    ) {
    }

    public static function fromArray(array $data): self {
        return new self(
            employee_id: (string) ($data['employee_id'] ?? ''),
            weekly_schedule_id: (string) ($data['weekly_schedule_id'] ?? ''),
            schedule_id: (string) ($data['schedule_id'] ?? ''),
            assignment_date: (string) ($data['assignment_date'] ?? ''),
            is_manual: (bool) ($data['is_manual'] ?? false),
        );
    }
}
