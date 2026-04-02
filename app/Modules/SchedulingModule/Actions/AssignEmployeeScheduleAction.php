<?php

declare(strict_types=1);

namespace App\Modules\SchedulingModule\Actions;

use App\Modules\SchedulingModule\DTOs\ScheduleAssignmentDTO;
use App\Modules\SchedulingModule\Models\WeeklyScheduleAssignment;
use App\Modules\SchedulingModule\Models\Schedule;
use App\Modules\SchedulingModule\Services\ScheduleValidationService;
use Illuminate\Support\Facades\DB;

final class AssignEmployeeScheduleAction {
    public function __construct(private ScheduleValidationService $validator) {
    }

    /**
     * Ejecuta asignaciones en lote.
     *
     * @param ScheduleAssignmentDTO[] $assignments
     * @return array<int, WeeklyScheduleAssignment>
     */
    public function execute(array $assignments): array {
        $created = [];

        DB::transaction(function () use ($assignments, &$created) {
            foreach ($assignments as $dto) {
                if (!($dto instanceof ScheduleAssignmentDTO)) {
                    throw new \InvalidArgumentException('Invalid DTO provided.');
                }

                $schedule = Schedule::findOrFail($dto->schedule_id);

                // Validate no overlap for employee on the date
                $this->validator->assertNoOverlapForEmployee(
                    $dto->employee_id,
                    $dto->assignment_date,
                    $schedule->start_time,
                    $schedule->end_time,
                );

                $created[] = WeeklyScheduleAssignment::create([
                    'weekly_schedule_id' => $dto->weekly_schedule_id,
                    'employee_id' => $dto->employee_id,
                    'schedule_id' => $dto->schedule_id,
                    'assignment_date' => $dto->assignment_date,
                    'is_manual' => $dto->is_manual,
                ]);
            }
        });

        return $created;
    }
}
