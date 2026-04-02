<?php

declare(strict_types=1);

namespace App\Modules\SchedulingModule\Actions;

use App\Modules\SchedulingModule\DTOs\CreateBreakTemplateDTO;
use App\Modules\SchedulingModule\Models\BreakTemplate;
use App\Modules\SchedulingModule\Models\Schedule;
use App\Modules\SchedulingModule\Services\ScheduleValidationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

final class CreateBreakTemplateAction
{
    public function __construct(
        private readonly ScheduleValidationService $validator,
    ) {
    }

    public function execute(CreateBreakTemplateDTO $dto): BreakTemplate
    {
        return DB::transaction(function () use ($dto): BreakTemplate {
            $schedule = Schedule::query()->findOrFail($dto->schedule_id);

            $normalizedStart = $this->normalizeTime($dto->start_time);
            $breakStart = Carbon::createFromFormat('H:i:s', $normalizedStart);
            $breakEnd = (clone $breakStart)->addMinutes($dto->duration_minutes);

            $this->validator->validateTimes($normalizedStart, $breakEnd->format('H:i:s'));

            $scheduleStart = Carbon::createFromFormat('H:i:s', $this->normalizeTime((string) $schedule->start_time));
            $scheduleEnd = Carbon::createFromFormat('H:i:s', $this->normalizeTime((string) $schedule->end_time));

            if ($breakStart->lt($scheduleStart) || $breakEnd->gt($scheduleEnd)) {
                throw new \InvalidArgumentException('La plantilla de descanso debe estar dentro del rango del horario base.');
            }

            $exists = BreakTemplate::query()
                ->where('schedule_id', $dto->schedule_id)
                ->whereRaw('LOWER(name) = ?', [mb_strtolower($dto->name)])
                ->exists();

            if ($exists) {
                throw new \InvalidArgumentException('Ya existe una plantilla de descanso con ese nombre para este horario.');
            }

            return BreakTemplate::query()->create([
                'schedule_id' => $dto->schedule_id,
                'name' => $dto->name,
                'start_time' => $normalizedStart,
                'duration_minutes' => $dto->duration_minutes,
                'is_active' => true,
            ]);
        });
    }

    private function normalizeTime(string $time): string
    {
        $parts = explode(':', $time);

        if (count($parts) === 2) {
            return sprintf('%02d:%02d:00', (int) $parts[0], (int) $parts[1]);
        }

        return $time;
    }
}
