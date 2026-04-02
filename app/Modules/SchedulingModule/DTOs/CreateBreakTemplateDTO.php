<?php

declare(strict_types=1);

namespace App\Modules\SchedulingModule\DTOs;

readonly class CreateBreakTemplateDTO {
    public function __construct(
        public int $schedule_id,
        public string $name,
        public string $start_time,
        public int $duration_minutes,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self {
        return new self(
            schedule_id: (int) $data['schedule_id'],
            name: trim((string) $data['name']),
            start_time: (string) $data['start_time'],
            duration_minutes: (int) $data['duration_minutes'],
        );
    }
}
